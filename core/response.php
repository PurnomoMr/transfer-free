<?php 
namespace Core;

class Response
{
    protected $status;

    public function __construct() {
        $this->status = [
            200 => '200 OK',
            400 => '400 Bad Request',
            404 => '404 Page Not Found',
            422 => 'Unprocessable Entity',
            500 => '500 Internal Server Error'
        ];
    }

    public function success($data = [], $code = 200) {
        // set the actual code
        http_response_code($code);
        // set the header to make sure cache is forced
        header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
        // treat this as json
        header('Content-Type: application/json');

        $success = array(
            "status"=> 'success',
            "statusCode"=> $code,
            "payload"=> $data
        );

        header("Status: ". $this->status[$code]);

        exit(json_encode($success, JSON_FORCE_OBJECT));
    }

    public function error($data, $code = 500) {

         $error = array(
             "status"=> 'error',
             "statusCode"=> $code,
             "payload"=> $data
         );
 
         exit(json_encode($error, JSON_FORCE_OBJECT));
    }
}


?>