<?php 
namespace Libraries;

class Flip
{
    
    public function disborse($data) {
        $curl = curl_init();;

        // OPTIONS:
        $options = $this->getOptions($data);
        
        $curl_opt = array(
            CURLOPT_URL => $options->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_POSTFIELDS => json_encode($options->body),
            CURLOPT_HTTPHEADER => $options->header
        );
        
        curl_setopt_array($curl, $curl_opt);

        // EXECUTE:
        $result = curl_exec($curl);
        $err = curl_error($curl);

        //get header response
        $response = explode("\r\n\r\n",$result);
        $http_code = curl_getinfo( $curl, CURLINFO_HTTP_CODE );
        curl_close($curl);

        if ($err) {
            $data_res['request'] = $curl_opt;
            $data_res['logs']   = "Error" ;
            $data_res['data']   = $err;
            $data_res['http_code'] = (string)$http_code;
            $data_res['options'] = $options;
            return $data_res;
        } else {
            $data_res['request'] = $curl_opt;
            $data_res['logs']   = isset($response) ? $response : '' ;
            $data_res['data']   = isset($response) ? (count($response) > 0 ? $response[count($response)-1] : '{}') : '{}';
            $data_res['http_code'] = (string)$http_code;
            $data_res['options'] = $options;
            return $data_res;
        }
    }

    public function disborseStatus($data, $action = "disburse/") {
        $curl = curl_init();;

        // OPTIONS:
        $options = $this->getOptions($data, $action);

        $curl_opt = array(
            CURLOPT_URL => $options->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_POSTFIELDS => json_encode($options->body),
            CURLOPT_HTTPHEADER => $options->header
        );
        curl_setopt_array($curl, $curl_opt);

        // EXECUTE:
        $result = curl_exec($curl);
        $err = curl_error($curl);

        //get header response
        $response = explode("\r\n\r\n",$result);
        $http_code = curl_getinfo( $curl, CURLINFO_HTTP_CODE );
        curl_close($curl);

        if ($err) {
            $data_res['request'] = $curl_opt;
            $data_res['logs']   = "Error" ;
            $data_res['data']   = $err;
            $data_res['http_code'] = (string)$http_code;
            $data_res['options'] = $options;
            return $data_res;
        } else {
            $data_res['request'] = $curl_opt;
            $data_res['logs']   = isset($response) ? $response : '' ;
            $data_res['data']   = isset($response) ? (count($response) > 0 ? $response[count($response)-1] : '{}') : '{}';
            $data_res['http_code'] = (string)$http_code;
            $data_res['options'] = $options;
            return $data_res;
        }
    }

    public function getOptions($data, $url = "disburse") {
        $options = new \stdClass;
        $options->url = FLIP_URL.$url;
        $options->header[] = "Authorization: Basic ". base64_encode(SECRET_KEY.":");
        $options->header[] = "Content-Type: application/json";

        if($url == "disburse") {
            // $options->body = new \stdClass;
            $options->body["bank_code"] = $data['bank_code'];
            $options->body["account_number"] = $data['account_number'];
            $options->body["amount"] = (int) $data['amount'];
            $options->body["remark"] = $data['remark'];
        } else {
            $options->url .= $data['ud_code'];
        }
        return $options;
    }
}
