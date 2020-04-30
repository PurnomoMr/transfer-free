<?php 
namespace Response;

class Response
{
    protected $status;

    public function __construct() {
        $this->status = [
            200 => '200 OK',
            400 => '400 Bad Request',
            422 => 'Unprocessable Entity',
            500 => '500 Internal Server Error'
        ];
    }

    public function success($data = [], $code = 200) {
        
       // clear the old headers
        header_remove();
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

        header("Status: ". $status[$code]);

        return json_encode($success);
    }

    public function error($data = [], $code = 500) {
         // clear the old headers
         header_remove();
         // set the actual code
         http_response_code($code);
         // set the header to make sure cache is forced
         header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
         // treat this as json
         header('Content-Type: application/json');
 
         $error = array(
             "status"=> 'error',
             "statusCode"=> $code,
             "payload"=> $data
         );
 
         header("Status: ". $status[$code]);
 
         return json_encode($error);
    }
}
