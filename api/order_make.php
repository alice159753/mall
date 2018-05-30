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
    ob_clean();

    $user_carts_nos = !empty($_REQUEST["user_carts_nos"]) ? $_REQUEST["user_carts_nos"] : 0;
    $user_no = !empty($_REQUEST["user_no"]) ? $_REQUEST["user_no"] : 0;
    $discount_coupon_no = !empty($_REQUEST["discount_coupon_no"]) ? $_REQUEST["discount_coupon_no"] : 0;

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

    $userCartsRows = $myUserCarts->getRows("*", "user_no = $user_no AND no in ($user_carts_nos)");
    if( empty($userCartsRows) )
    {
        Output::error('商品不能为空2', '3');
    }

    $myWeChat->xcx('测试', 1, time(), 'https://mall.huaban1314.com', 'https://mall.huaban1314.com');


?>