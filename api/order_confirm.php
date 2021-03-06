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
    include_once(INCLUDE_DIR. "/UserCardsRecord.php");
    include_once(INCLUDE_DIR. "/UserCards.php");
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
    $myUserCardsRecord = new UserCardsRecord($myMySQL);
    $myUserCards = new UserCards($myMySQL);

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

    //商品
    $productNoList = array();
    for($i = 0; isset($userCartsRows[$i]); $i++)
    {
        $product_no = $userCartsRows[$i]['product_no'];
        $productRow = $myProduct->getRow("*", "no = $product_no");

        $dataArray = $myProduct->getDataClean($productRow);

        //检查商品是否在售卖期间
        if( !$myProduct->is_sale($productRow) )
        {
            Output::error($dataArray['title'].'-商品不再售卖期间', '4');
        }

        $dataArray['buy_num'] = $userCartsRows[$i]['buy_num'];
        $dataArray['product_attr_text'] = $userCartsRows[$i]['product_attr_text'];

        $repertory_num = $dataArray['repertory_num'];

        //如果规格不为空，则从规格里面获取内容
        if( !empty($userCartsRows[$i]['product_attr_no']) )
        {
            $productAttrRow = $myProductAttr->getRow("*", "no = ". $userCartsRows[$i]['product_attr_no']);

            $dataArray['sale_price']        = $productAttrRow['sale_price'];
            $dataArray['product_weight_kg'] = $productAttrRow['product_weight_kg'];
            $dataArray['product_weight_g']  = $productAttrRow['product_weight_g'];
            $dataArray['pic']               = FILE_URL.$productAttrRow['pic'];

            $repertory_num  = $productAttrRow['repertory_num'];

        }

        //检查库存
        if( $dataArray['buy_num'] > $repertory_num )
        {
            Output::error($dataArray['title'].'-库存数量不够，请重新选择购买数量', '4');
        }

        $result['product_lists'][] = $dataArray;

        $productNoList[] = $userCartsRows[$i]['product_no'];
    }

    $product_fee  = $myOrderInfo->orderFee($result['product_lists']);

    $carriage_fee = $myOrderInfo->orderCarriageFee($result['product_lists']);

    $product_fee = sprintf("%.2f", $product_fee);
    $carriage_fee = sprintf("%.2f", $carriage_fee);


    //判断这个用户是否有会员卡
    $userCardsRecordRow = $myUserCardsRecord->getRow("*", "user_no = $user_no AND is_default = 1");
    if( !empty($userCardsRecordRow) )
    {
        $userCardsRow = $myUserCards->getRow("*", "no = ". $userCardsRecordRow['user_cards_no']);

        $userCardsRow['picker_title'] = '';

        //是否免邮
        if( $userCardsRow['is_shipping'] == 1 )
        {
            $carriage_fee = 0;
            $userCardsRow['picker_title'] = '包邮';
        }

        if( $userCardsRow['is_discount'] == 1 )
        {
            $product_fee_discount = ($product_fee * $userCardsRow['discount'])/10;

            $userCardsRow['picker_title'] .= ' 打'.$userCardsRow['discount']."折";
        }

        $result['user_cards'] = $userCardsRow;
    }

    $product_fee = !empty($product_fee_discount) ? $product_fee_discount : $product_fee;

    //计算总共金额
    $result['total_fee']       = $product_fee + $carriage_fee;
    $result['product_fee']     = $product_fee;
    $result['carriage_fee']    = $carriage_fee;


    //获取当前商品可以使用的优惠券
    $discountCouponRows = $myDiscountCouponRecord->getRows("*", "user_no = $user_no AND is_use = 0 AND is_past = 0");

    for($i = 0; isset($discountCouponRows[$i]); $i++)
    {
        $row = $myDiscountCoupon->getRow("*", "no = ".$discountCouponRows[$i]['discount_coupon_no']);

        //满多少元可以使用
        if( $row['use_type'] == 2 )
        {
            if( $row['full_price'] > $product_fee )
            {
                continue;
            }
        }

        //判断优惠券这个商品是否可以使用
        if( $row['use_product_type'] == 2 )
        {
            if( empty($row['product_no']) )
            {
                continue;
            }
            else
            {
                $product_no = $row['product_no'];
                $product_no = explode(",", $product_no);

                $product_can_use = array_intersect($productNoList, $product_no);
            }

            //如果交集为空则过滤
            if( empty($product_can_use) )
            {
                continue;
            }
        }

        $dataArray = $myDiscountCoupon->getDataClean($row);
        $dataArray['discount_coupon_no'] = $discountCouponRows[$i]['no'];

        $result['discount_coupon'][] = $dataArray;
    }

    Output::succ('', $result);



?>