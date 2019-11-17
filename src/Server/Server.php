<?php
namespace App\Server;

class Server
{
    public static function listen($server)
    {
        $method = $server['REQUEST_METHOD'];
        $url = $server['REQUEST_URI'];

        
        $param = explode('/', $url);
        if (empty($param[0])) {
            array_shift($param);
        }
        $contentType = self::getContentType($server);
        $payload = self::getpayload($server);
        
        //Convert urlencoded to JSON
        if($contentType === "application/x-www-form-urlencoded"){
            parse_str(urldecode($payload), $result);
            $payload = \json_decode($result);
        }


        switch ($method) {
            case 'GET':
                if (count($param) > 1 && !empty($param[1])) {
                    $method = self::camelize(strtolower('FIND_ONE'));
                } else {
                    $method = strtolower('FIND');
                }

                break;
            case 'POST':
                if (!$payload) {
                    self::handlerpayloadError();
                    return;
                }
                $method = strtolower("CREATE");
                break;
            case 'PUT':
                if (!$payload) {
                    self::handlerpayloadError();
                    return;
                }
                $method = strtolower("UPDATE");
                break;
            case 'DELETE':
                $method = strtolower("REMOVE");
                break;
            default:
                http_response_code(500);
                echo json_encode(array('error' => "OMG! We can't handler this action!"));
                break;
        }
        self::handlerController($url, $method, $payload);
    }

    private function getpayload($server)
    {
        if (!isset($server['HTTP_CONTENT_LENGTH']) || !isset($server['CONTENT_LENGTH']) || !$server['HTTP_CONTENT_LENGTH'] || !$server['CONTENT_LENGTH']) {
            return null;
        }
        return file_get_contents('php://input');
    }

    private function getContentType($server){
        if (!isset($server['HTTP_CONTENT_TYPE']) || !isset($server['CONTENT_TYPE']) || !$server['HTTP_CONTENT_TYPE'] || !$server['CONTENT_TYPE']) {
            return null;
        }

        $contentType =  $server['HTTP_CONTENT_TYPE'] ? $server['HTTP_CONTENT_TYPE'] : 
                        $server['CONTENT_TYPE'] ? $server['CONTENT_TYPE'] : '';
        return $contentType;
    }

    private function handlerpayloadError()
    {
        http_response_code(500);
        echo json_encode(array('error' => "Bad move! Try removing the task instead of deleting its content."));
    }

    private function handlerController($url, $method, $payload)
    {
        if ($url === '/') {
            http_response_code(200);
            echo json_encode(array(
                'hello' => 'Hi, if you need more info please let me know on laerciobernardo@hotmail.com',
                'tasks' => 'http://localhost:8000/task',
            ));
            return;
        }

        $path = explode('/', $url);
        if (empty($path[0])) {
            array_shift($path);
        }

        $className = ucfirst($path[0]);
        $param = isset($path[1]) ? $path[1] : null;

        $className = "App\Controllers\\".$className."Ctrl";

      //   echo "<pre>";
      //   var_dump(array(
      //       'className' => $className,
      //       'method' => $method,
      //       'param' => $param,
      //       'payload' => json_decode($payload, true)
      //   ));


        if (!class_exists($className)) {
            http_response_code(500);
            echo json_encode(array('error' => "OMG! We can't handler this action with this namespace!"));
            return;
        }

        $return = call_user_func_array(array(new $className, $method), array($param, json_decode($payload)));

        echo json_encode($return);
    }

    private function camelize($input, $separator = '_')
    {
        return str_replace($separator, '', lcfirst(ucwords($input, $separator)));
    }
}
