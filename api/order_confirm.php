<?php

    //获得用户的地址，优惠券，计算商品的价格，运费
    include_once("config.cmd.php");

    ob_start();
    include_once(INCLUDE_DIR. "/Product.php");
    include_once(INCLUDE_DIR. "/UserAddress.php");
    include_once(INCLUDE_DIR. "/DiscountCoupon.php");
    include_once(INCLUDE_DIR. "/OrderInfo.php");
    include_once(INCLUDE_DIR. "/UserCarts.php");
    include_once(INCLUDE_DIR. "/DiscountCouponRecord.php");
    include_once(INCLUDE_DIR. "/ProductAttr.php");
    ob_clean();

    $user_carts_nos = !empty($_REQUEST["user_carts_nos"]) ? $_REQUEST["user_carts_nos"] : 0;
    $user_no = !empty($_REQUEST["user_no"]) ? $_REQUEST["user_no"] : 0;

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myProduct = new Product($myMySQL);
    $myUserAddress = new UserAddress($myMySQL);
    $myDiscountCoupon = new DiscountCoupon($myMySQL);
    $myOrderInfo = new OrderInfo($myMySQL);
    $myUserCarts = new UserCarts($myMySQL);
    $myDiscountCouponRecord = new DiscountCouponRecord($myMySQL);
    $myProductAttr = new ProductAttr($myMySQL);

    if( empty($user_carts_nos) )
    {
        Output::error('商品不能为空1', '1');
    }

    if( empty($user_no) )
    {
        Output::error('用户不能为空', '2');
    }

    $result = array();

    $userCartsRows = $myUserCarts->getRows("*", "user_no = $user_no AND no in ($user_carts_nos)");
    if( empty($userCartsRows) )
    {
        Output::error('商品不能为空2', '3');
    }

    //设置一个默认的地址
    $userAddressRow = $myUserAddress->getRow("*", "user_no = $user_no order by is_default desc");

    $result['user_address'] = $userAddressRow;

    $discountCouponRows = $myDiscountCouponRecord->getRows("*", "user_no = $user_no AND is_use = 0 AND is_past = 0");

    for($i = 0; isset($discountCouponRows[$i]); $i++)
    {
        $row = $myDiscountCoupon->getRow("*", "no = ".$discountCouponRows[$i]['discount_coupon_no']);

        $dataArray = $myDiscountCoupon->getDataClean($row);

        $result['discount_coupon'][] = $dataArray;
    }

    //商品
    for($i = 0; isset($userCartsRows[$i]); $i++)
    {
        $product_no = $userCartsRows[$i]['product_no'];
        $productRow = $myProduct->getRow("*", "no = $product_no");

        $dataArray = $myProduct->getDataClean($productRow);

        $dataArray['buy_num'] = $userCartsRows[$i]['buy_num'];
        $dataArray['product_attr_text'] = $userCartsRows[$i]['product_attr_text'];

        //如果规格不为空，则从规格里面获取内容
        if( !empty($userCartsRows[$i]['product_attr_no']) )
        {
            $productAttrRow = $myProductAttr->getRow("*", "no = ". $userCartsRows[$i]['product_attr_no']);

            $dataArray['sale_price']        = $productAttrRow['sale_price'] / 100;
            $dataArray['product_weight_kg'] = $productAttrRow['product_weight_kg'];
            $dataArray['product_weight_g']  = $productAttrRow['product_weight_g'];
            $dataArray['pic']               = FILE_URL.$productAttrRow['pic'];
        }

        $result['product_lists'][] = $dataArray;
    }

    $product_fee = $myOrderInfo->orderFee($userCartsRows);
    $product_fee = $product_fee / 100; //单位转换为元

    //$carriageFee = $myOrderInfo->orderCarriageFee($userCartsRows, $userAddressRow);
    //$carriage_fee = $carriageFee['carriage_fee'] / 100;

    $carriage_fee = 10;

    //计算总共金额
    $result['total_fee']       = $product_fee + $carriage_fee;
    $result['product_fee']     = $product_fee;
    $result['carriage_fee']    = $carriage_fee;

    Output::succ('', $result);



?>