<?php

include_once(PATH_ROOT."app/models/Model_user_disborse.php");
include_once(PATH_ROOT."app/models/Model_disborse.php");
include_once(PATH_ROOT."app/libraries/Flip.php");

use Core\response;

class User_disborse

{
    
    public function __construct()
    {
        
    }

    public function send() {
        $bank_code = !empty($_POST["bank_code"]) ? $_POST["bank_code"] : "";
        $account_number = !empty($_POST["account_number"]) ? $_POST["account_number"] : "";
        $amount = !empty($_POST['amount']) ? (int) $_POST['amount'] : 0;
        $remark = !empty($_POST["remark"]) ? $_POST["remark"] : "";

        $response = new response();
        $model_user_disborse = new \Models\Model_user_disborse;
        $model_disborse = new \Models\Model_disborse;

        $where = " AND ud_account_no = ? AND ud_bank_code = ? AND created_date > ?";
        $data = [$account_number, $bank_code, date("Y-m-d H:m:s", strtotime("-5 minutes"))];
        $order_by = " order by created_date DESC ";
        $latest_disborse = $model_user_disborse->getlatest_user_disborse($where, $data, $order_by);
        if(!empty($latest_disborse)) {
            $response->error("Your transfer has been submit 5 menitues ago.", 401);
        }

        $flip = new \Libraries\Flip;
        $data = array(
            'bank_code' => $bank_code,
            'account_number' => $account_number,
            'amount' => (int) $amount,
            'remark' => $remark
        );

        $data_res = $flip->disborse($data);

        if($data_res["http_code"] === "200") {
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
                'created_date' => date("Y-m-d H:m:s")
            );
            
            if(!empty($data_disborse['remark'])){

                $create_user_disborse['ud_remark'] = $data_disborse["remark"];
            }

            if(!empty($data_disborse['receipt'])) {
                
                $create_user_disborse['ud_receipt'] = $data_disborse["receipt"];
            }
            $ud_id = $model_user_disborse->create_user_disborse($create_user_disborse);

            
            $create_disborse = array(
                'ud_id' => $ud_id,
                'ud_code' => $data_disborse["id"],
                'ds_status' => $data_disborse["status"],
                'created_date' => date("Y-m-d H:m:s")
            );

            $model_disborse->create_disborse($create_disborse);

            $result = $model_user_disborse->get_user_disborse($ud_id);

            $response->success($result, 200);
        } else {
            $response->error("Please try again.", 401);
        }

    }
}
