<?php

    //下单
    include_once("config.cmd.php");

    ob_start();
    include_once(INCLUDE_DIR. "/Product.php");
    include_once(INCLUDE_DIR. "/UserAddress.php");
    include_once(INCLUDE_DIR. "/DiscountCoupon.php");
    include_once(INCLUDE_DIR. "/OrderInfo.php");
    include_once(INCLUDE_DIR. "/UserCarts.php");
    include_once(INCLUDE_DIR. "/DiscountCouponRecord.php");
    include_once(INCLUDE_DIR. "/ProductAttr.php");
    include_once(INCLUDE_DIR. "/WeChat.php");
    include_once(INCLUDE_DIR. "/User.php");
    ob_clean();

    $user_carts_nos = !empty($_REQUEST["user_carts_nos"]) ? $_REQUEST["user_carts_nos"] : 0;
    $user_no = !empty($_REQUEST["user_no"]) ? $_REQUEST["user_no"] : 0;
    $discount_coupon_no = !empty($_REQUEST["discount_coupon_no"]) ? $_REQUEST["discount_coupon_no"] : 0;
    $openid = !empty($_REQUEST["openid"]) ? $_REQUEST["openid"] : '';

    if( empty($user_carts_nos) )
    {
        Output::error('商品不能为空1', '1');
    }

    if( empty($user_no) )
    {
        Output::error('用户不能为空', '2');
    }

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myProduct = new Product($myMySQL);
    $myUserAddress = new UserAddress($myMySQL);
    $myDiscountCoupon = new DiscountCoupon($myMySQL);
    $myOrderInfo = new OrderInfo($myMySQL);
    $myUserCarts = new UserCarts($myMySQL);
    $myDiscountCouponRecord = new DiscountCouponRecord($myMySQL);
    $myProductAttr = new ProductAttr($myMySQL);
    $myWeChat = new WeChat();
    $myUser = new User($myMySQL);

    if( empty($openid) )
    {
        $userRow = $myUser->getRow("*", "no = $user_no");
        $openid = $userRow['openid'];
    }

    $userCartsRows = $myUserCarts->getRows("*", "user_no = $user_no AND no in ($user_carts_nos)");
    if( empty($userCartsRows) )
    {
        Output::error('商品不能为空2', '3');
    }

    $response = $myWeChat->xcx($openid, '测试', 1, time(), 'https://mall.huaban1314.com', 'https://mall.huaban1314.com');

    $result = array();
    $result['timeStamp'] = (string)time();
    $result['nonceStr']  = $response['nonce_str'];
    $result['package']   = "prepay_id=".$response['prepay_id'];
    $result['signType']  = $response['MD5'];
    $result['paySign']   = $myWeChat->makePaySign($result['nonceStr'], $result['package'], $result['timeStamp']);

    Output::succ('', $result);

?>