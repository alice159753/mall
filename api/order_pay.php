<?php

    //付款
    include_once("config.cmd.php");

    ob_start();
    include_once(INCLUDE_DIR. "/OrderInfo.php");
    include_once(INCLUDE_DIR. "/WeChat.php");
    include_once(INCLUDE_DIR. "/OrderProduct.php");
    include_once(INCLUDE_DIR. "/User.php");
    ob_clean();

    $order_info_no = isset($_REQUEST["order_info_no"]) ? $_REQUEST["order_info_no"] : "0";
    $user_no = !empty($_REQUEST["user_no"]) ? $_REQUEST["user_no"] : 0;
    $openid = !empty($_REQUEST["openid"]) ? $_REQUEST["openid"] : '';

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myOrderInfo = new OrderInfo($myMySQL);
    $myOrderProduct = new OrderProduct($myMySQL);
    $myUser = new User($myMySQL);
    $myWeChat = new WeChat();

    if( empty($order_info_no) )
    {
        Output::error('订单不能为空',array(), 1);
    }

    if( empty($user_no) )
    {
        Output::error('用户no不能为空',array(), 1);
    }

    //获取用户openid
    if( empty($openid) )
    {
        $userRow = $myUser->getRow("*", "no = $user_no");
        $openid = $userRow['openid'];
    }

    $orderInfoRow = $myOrderInfo->getRow("*", "no = $order_info_no AND user_no = ". $user_no);

    if( empty($orderInfoRow) )
    {
        Output::error('订单不存在',array(), 1);
    }

    $order_sn = $orderInfoRow['order_sn'];
    $total_fee = $orderInfoRow['total_fee'] * 100;

    $orderProduct = $myOrderProduct->getRow("*", "order_sn = '".$order_sn."' LIMIT 1");
    $product_title = $orderProduct['product_title'];

    $response = $myWeChat->xcx($openid, $product_title, $total_fee, $order_sn, 'https://mall.huaban1314.com/api/wechat_callback.php', 'https://mall.huaban1314.com/wechat_callback.php');

    $result = array();
    $result['timeStamp'] = (string)time();
    $result['nonceStr']  = $response['nonce_str'];
    $result['package']   = "prepay_id=".$response['prepay_id'];
    $result['signType']  = $response['MD5'];
    $result['paySign']   = $myWeChat->makePaySign($result['nonceStr'], $result['package'], $result['timeStamp']);
    $result['order_sn']  = $order_sn;

    Output::succ('', $result);

?>