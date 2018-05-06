<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/OrderInfo.php");
    ob_clean();

    // request
    $no = isset($_REQUEST["no"]) ? $_REQUEST["no"] : 0;

    $order_status = isset($_REQUEST["order_status"]) ? $_REQUEST["order_status"] : 0;
    $shipping_status = isset($_REQUEST["shipping_status"]) ? $_REQUEST["shipping_status"] : 0;
    $pay_status = isset($_REQUEST["pay_status"]) ? $_REQUEST["pay_status"] : 0;
    $comment_status = isset($_REQUEST["comment_status"]) ? $_REQUEST["comment_status"] : 0;
    $pay_type = isset($_REQUEST["pay_type"]) ? $_REQUEST["pay_type"] : 0;
    $invoice_no = isset($_REQUEST["invoice_no"]) ? $_REQUEST["invoice_no"] : '';
    $pay_note = isset($_REQUEST["pay_note"]) ? $_REQUEST["pay_note"] : '';

    if ( $no == 0 )
    {
        header("Location: order_info.php?r=".time());
        exit;
    }
   
    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myOrderInfo= new OrderInfo($myMySQL);

     // check no
    $row = $myOrderInfo->get("*", "no = $no");

    if ( !isset($row["no"]) )
    {
        Output::error('无数据',array(), 1);
    }

    $dataArray = array();
    $dataArray['order_status']    = $order_status;
    $dataArray['shipping_status'] = $shipping_status;
    $dataArray['pay_status']      = $pay_status;
    $dataArray['comment_status']  = $comment_status;
    $dataArray['pay_type']        = $pay_type;
    $dataArray['lastmodify']      = 'now()';
    $dataArray['invoice_no']      = $invoice_no;
    $dataArray['pay_note']        = $pay_note;

    $myOrderInfo->update($dataArray, "no = ". $no);

    Output::succ('修改成功',array());

?>