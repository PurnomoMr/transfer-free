<?php

include_once(PATH_ROOT."app/models/Model_user_disborse.php");
include_once(PATH_ROOT."app/models/Model_disborse.php");
include_once(PATH_ROOT."app/libraries/Flip.php");

use Core\response;

class Disborse

{
    
    public function __construct()
    {
        
    }

    public function check() {
        $response = new response();
        $model_user_disborse = new \Models\Model_user_disborse;
        $model_disborse = new \Models\Model_disborse;
        
        $trx_id = !empty($_GET["trx_id"]) ? $_GET["trx_id"] : 0;
        if($trx_id <= 0) {
            $response->error("Transaction id not found.", 401);
        }
        $user_disborse = new \stdClass;
        $disborse = $model_disborse->get_disborse_by_ud_code($trx_id);
        if(empty($disborse)) {
            $response->error("Transaction id not found.", 401);
        }

        if($disborse->ds_success == "success") {
            $result = $model_user_disborse->get_user_disborse($disborse->ud_id);
        } else {
            $flip = new \Libraries\Flip;
            $data = array(
                'ud_code' => $disborse->ud_code,
            );
            $data_res = $flip->disborseStatus($data);

            if($data_res["http_code"] !== "200") { 
                $response->error("Please try again.", 401);
            } else {
                $data_disborse = json_decode($data_res['data'], true);
    
                $create_user_disborse = array(
                    'ud_code' => $data_disborse["id"],
                    'ud_amount' => $data_disborse["amount"],
                    'ud_status' => $data_disborse["status"],
                    'ud_date' => $data_disborse["timestamp"],
                    'ud_bank_code' => $data_disborse["bank_code"],
                    'ud_account_no' => $data_disborse["account_number"],
                    'ud_beneficiary_name' => $data_disborse["beneficiary_name"],
                    'ud_time_served' => $data_disborse["time_served"],
                    'ud_fee' => $data_disborse["fee"],
                    'updated_date' => date("Y-m-d H:m:s")
                );
                
                if(!empty($data_disborse['remark'])){
    
                    $create_user_disborse['ud_remark'] = $data_disborse["remark"];
                }
    
                if(!empty($data_disborse['receipt'])) {
                    
                    $create_user_disborse['ud_receipt'] = $data_disborse["receipt"];
                }
                $ud_id = $model_user_disborse->update_user_disborse($disborse->ud_id, $create_user_disborse);
                
                $create_disborse = array(
                    'ud_id' => $ud_id,
                    'ud_code' => $data_disborse["id"],
                    'ds_status' => $data_disborse["status"],
                    'created_date' => date("Y-m-d H:m:s")
                );
    
                $model_disborse->create_disborse($create_disborse);
    
                $result = $model_user_disborse->get_user_disborse($ud_id);
    
            }
        }

        $response->success($result, 200);
    }
}
