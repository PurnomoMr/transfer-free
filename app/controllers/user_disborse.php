<?php

include_once(PATH_ROOT."app/models/Model_user_disborse.php");
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
        $where = " AND ud_account_no = ? AND ud_bank_code = ? AND created_date > ?";
        $data = [$account_number, $bank_code, date("Y-m-d H:m:s", strtotime("+5 minutes"))];
        $order_by = " order by created_date DESC ";
        $disborse = $model_user_disborse->getlatest_user_disborse($where, $data, $order_by);
        if(!empty($disborse)) {
            $response->error("Your transfer has been submit 5 menitues ago.", 400);
        }

        $flip = new \Libraries\Flip;
        $data = array(
            'bank_code' => $bank_code,
            'account_number' => $account_number,
            'amount' => (int) $amount,
            'remark' => $remark
        );

        $result = $flip->disborse($data);
        var_dump($result);exit();

        $response->success("berhasil", 200);
    }
}
