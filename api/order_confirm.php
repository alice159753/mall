<?php

    //获得用户的地址，优惠券，计算商品的价格，运费
    include_once("config.cmd.php");

    ob_start();
    include_once(INCLUDE_DIR. "/Product.php");
    include_once(INCLUDE_DIR. "/UserAddress.php");
    include_once(INCLUDE_DIR. "/DiscountCoupon.php");
    include_once(INCLUDE_DIR. "/OrderInfo.php");
    ob_clean();

    $product_nos = !empty($_REQUEST["product_nos"]) ? $_REQUEST["product_nos"] : 0;
    $user_no = !empty($_REQUEST["user_no"]) ? $_REQUEST["user_no"] : 0;

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myProduct = new Product($myMySQL);
    $myUserAddress = new UserAddress($myMySQL);
    $myDiscountCoupon = new DiscountCoupon($myMySQL);
    $myOrderInfo = new OrderInfo($myMySQL);

    if( empty($product_nos) )
    {
        Output::error('1', '商品不能为空');
    }

    if( empty($user_no) )
    {
        Output::error('1', '用户不能为空');
    }

    $result = array();

    $userAddressRow = $myUserAddress->getRow("*", "user_no = $user_no order by is_default desc");

    $result['user_address'] = $userAddressRow;

    $discountCouponRows = $myDiscountCoupon->getRows("*", "user_no = $user_no AND is_use = 0 AND is_past = 0");




    Output::succ('', $result);



?>