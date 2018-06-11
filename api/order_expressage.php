<?php

    //获得用户的地址，优惠券，计算商品的价格，运费
    include_once("config.cmd.php");

    ob_start();
    include_once(INCLUDE_DIR. "/OrderProduct.php");
    include_once(INCLUDE_DIR. "/OrderInfo.php");
    include_once(INCLUDE_DIR. "/OrderExpressage.php");
    ob_clean();


    $order_info_no = !empty($_REQUEST["order_info_no"]) ? $_REQUEST["order_info_no"] : 0;
    $user_no = !empty($_REQUEST["user_no"]) ? $_REQUEST["user_no"] : 0;

    if( empty($order_info_no) )
    {
        Output::error('订单编号不能为空1', '1');
    }

    if( empty($user_no) )
    {
        Output::error('用户不能为空', '2');
    }

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myOrderInfo = new OrderInfo($myMySQL);
    $myOrderProduct = new OrderProduct($myMySQL);
    $myOrderExpressage = new OrderExpressage();

    $orderInfoRow = $myOrderInfo->getRow("*", "user_no = $user_no AND no = $order_info_no");

    if( empty($orderInfoRow) )
    {
        Output::error('订单编号不能为空2', '2');
    }

    $productRow = $myOrderProduct->getRow("*", "order_no = $order_info_no");

    $invoice_no = $orderInfoRow['invoice_no'];
    $invoice_no = explode(",", $invoice_no);

    for($i = 0; isset($invoice_no[$i]); $i++)
    {
        $name = $myOrderExpressage->getName($invoice_no[$i]);
        $name = $name['auto'][0]['comCode'];

        $route = $myOrderExpressage->query2($invoice_no[$i], $name);

        $dataArray = array();
        $dataArray['invoice_no'] = $invoice_no[$i];
        $dataArray['product_pic'] = FILE_URL.$productRow['product_pic'];
        $dataArray['route'] = $route;

        $result[] = $dataArray;
    }

    Output::succ('', $result);

?>