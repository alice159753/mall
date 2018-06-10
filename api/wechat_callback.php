<?php

    include_once("config.cmd.php");

    ob_start();
    include_once(INCLUDE_DIR. "/OrderInfo.php");    
    include_once(INCLUDE_DIR. "/OrderProduct.php");
    include_once(INCLUDE_DIR. "/User.php");
    ob_clean();

    $filename = date('Ym').'/'.date('Ymd').'/wechat_callback.log';

    //记录请求日志
    Logs::write($filename, $_REQUEST, 'NtpP');

    $order_sn = isset($_REQUEST["order_sn"]) ? $_REQUEST["order_sn"] : "";
    $user_no = !empty($_REQUEST["user_no"]) ? $_REQUEST["user_no"] : 0;

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myOrderInfo = new OrderInfo($myMySQL);

    $dataArray = array();
    $dataArray['pay_status'] = 2;
    $dataArray["lastmodify"] = 'now()';
    $dataArray["pay_time"]   = 'now()';

    $myOrderInfo->update($dataArray, "user_no = $user_no AND order_sn = '".$order_sn."'");

    Output::succ('提交成功',array());

?>