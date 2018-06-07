<?php

    //申请退款订单
    include_once("config.cmd.php");

    ob_start();
    include_once(INCLUDE_DIR. "/OrderInfo.php");    
    include_once(INCLUDE_DIR. "/OrderProduct.php");
    include_once(INCLUDE_DIR. "/User.php");
    ob_clean();

    $order_info_no = isset($_REQUEST["order_info_no"]) ? $_REQUEST["order_info_no"] : "0";
    $user_no = !empty($_REQUEST["user_no"]) ? $_REQUEST["user_no"] : 0;
    $sales_return_note = isset($_REQUEST["sales_return_note"]) ? $_REQUEST["sales_return_note"] : "";

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

    if( empty($sales_return_note) )
    {
        Output::error('退款理由和联系方式不能为空',array(), 1);
    }

    $orderInfoRow = $myOrderInfo->getRow("*", "no = $order_info_no AND user_no = ". $user_no);

    if( empty($orderInfoRow) )
    {
        Output::error('订单不存在',array(), 1);
    }

    $dataArray = array();
    $dataArray["order_status"]      = 6;
    $dataArray["sales_return_note"] = $sales_return_note;
    $dataArray["lastmodify"]        = 'now()';

    $myOrderInfo->update($dataArray, "no = $order_info_no AND user_no = ". $user_no);

    Output::succ('提交成功',array());

