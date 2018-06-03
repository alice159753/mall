<?php

    //确认收货
    include_once("config.cmd.php");

    ob_start();
    include_once(INCLUDE_DIR. "/OrderInfo.php");    
    include_once(INCLUDE_DIR. "/OrderProduct.php");
    include_once(INCLUDE_DIR. "/User.php");
    ob_clean();

    $order_info_no = isset($_REQUEST["order_info_no"]) ? $_REQUEST["order_info_no"] : "0";
    $user_no = !empty($_REQUEST["user_no"]) ? $_REQUEST["user_no"] : 0;

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myOrderInfo = new OrderInfo($myMySQL);

    if( empty($order_info_no) )
    {
        Output::error('订单不能为空',array(), 1);
    }
    
    if( empty($user_no) )
    {
        Output::error('用户no不能为空',array(), 1);
    }

    $orderInfoRow = $myOrderInfo->getRow("*", "no = $no AND user_no = ". $user_no);

    if( empty($orderInfoRow) )
    {
        Output::error('订单不存在',array(), 1);
    }

    $dataArray = array();
    $dataArray["shipping_status"] = 2;
    $dataArray["lastmodify"]      = 'now()';

    $myOrderInfo->update($dataArray, "no = $no AND user_no = ".$user_no);

    Output::succ('提交成功',array());

?>