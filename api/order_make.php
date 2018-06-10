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
    include_once(INCLUDE_DIR. "/Tools.php");
    include_once(INCLUDE_DIR. "/UserCards.php");
    include_once(INCLUDE_DIR. "/UserCardsRecord.php");
    ob_clean();

    $user_carts_nos = !empty($_REQUEST["user_carts_nos"]) ? $_REQUEST["user_carts_nos"] : 0;
    $user_no = !empty($_REQUEST["user_no"]) ? $_REQUEST["user_no"] : 0;
    $discount_coupon_no = !empty($_REQUEST["discount_coupon_no"]) ? $_REQUEST["discount_coupon_no"] : 0;
    $openid = !empty($_REQUEST["openid"]) ? $_REQUEST["openid"] : '';
    $user_address_no = !empty($_REQUEST["user_address_no"]) ? $_REQUEST["user_address_no"] : '0';
    $postscript = !empty($_REQUEST["postscript"]) ? urldecode($_REQUEST["postscript"]) : '';//卖家留言

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
    $myUserCards = new UserCards($myMySQL);
    $myUserCardsRecord = new UserCardsRecord($myMySQL);

    //获取用户openid
    if( empty($openid) )
    {
        $userRow = $myUser->getRow("*", "no = $user_no");
        $openid = $userRow['openid'];
    }

    //获取购物车
    $userCartsRows = $myUserCarts->getRows("*", "user_no = $user_no AND no in ($user_carts_nos)");
    if( empty($userCartsRows) )
    {
        Output::error('商品不能为空2', '3');
    }

    //获取地址
    $userAddressRow = $myUserAddress->getRow("*", "no = $user_address_no");
    if( empty($userAddressRow) )
    {
        Output::error('收货地址不能为空', '3');
    }

    //商品
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

        $dataArray['cost_price'] = $productRow['member_price']; //记录成本价

        $dataArray['buy_num'] = $userCartsRows[$i]['buy_num'];
        $dataArray['product_attr_text'] = $userCartsRows[$i]['product_attr_text'];
        $dataArray['product_attr_no']   = $userCartsRows[$i]['product_attr_no'];

        $repertory_num = $dataArray['repertory_num'];

        //如果规格不为空，则从规格里面获取内容
        if( !empty($userCartsRows[$i]['product_attr_no']) )
        {
            $productAttrRow = $myProductAttr->getRow("*", "no = ". $userCartsRows[$i]['product_attr_no']);

            $dataArray['sale_price']        = $productAttrRow['sale_price'];
            $dataArray['lineation_price']   = $productAttrRow['lineation_price'];
            $dataArray['member_price']      = $productAttrRow['member_price'];
            $dataArray['cost_price']        = $productAttrRow['member_price'];
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
    }

    $product_fee  = $myOrderInfo->orderFee($result['product_lists']);

    $carriage_fee = $myOrderInfo->orderCarriageFee($result['product_lists']);

    //如果优惠券不等于空
    if( !empty($discount_coupon_no) )
    {
        //判断这个优惠券是否合法
        $product_fee_discount = $myDiscountCoupon->computerPrice($discount_coupon_no, $product_fee);
    }

    //判断这个用户是否有会员卡
    $userCardsRecordRow = $myUserCardsRecord->getRow("*", "user_no = $user_no AND is_default = 1");
    if( !empty($userCardsRecordRow) )
    {
        $userCardsRow = $myUserCards->getRow("*", "no = ". $userCardsRecordRow['user_cards_no']);

        //是否免邮
        if( $userCardsRow['is_shipping'] == 1 )
        {
            $carriage_fee = 0;
        }

        if( $userCardsRow['is_discount'] == 1 )
        {
            //折上折
            if( !empty($product_fee_discount) )
            {
                $product_fee_discount = ($product_fee_discount * $userCardsRow['discount'])/10;
            }
            else
            {
                $product_fee_discount = ($product_fee * $userCardsRow['discount'])/10;
            }
        }
    }

    //清空购物车
    $myUserCarts->remove("user_no = $user_no AND no in ($user_carts_nos)");

    //减少库存
    $myOrderInfo->reduceProduct($result['product_lists']);

    //下订单
    $order_sn = $myOrderInfo->createOrder($user_no, $userAddressRow, $result['product_lists'], $product_fee_discount, $product_fee, $carriage_fee, $postscript, $discount_coupon_no, 1);

    $product_fee = !empty($product_fee_discount) ? $product_fee_discount : $product_fee;

    $product_fee = sprintf("%.2f", $product_fee);
    $carriage_fee = sprintf("%.2f", $carriage_fee);

    $product_fee = $product_fee * 100; //转换成分

    $product_fee = 1;

    $response = $myWeChat->xcx($openid, $result['product_lists'][0]['title'], $product_fee, $order_sn, 'https://mall.huaban1314.com/api/wechat_callback.php', 'https://mall.huaban1314.com/wechat_callback.php');

    $result = array();
    $result['timeStamp'] = (string)time();
    $result['nonceStr']  = $response['nonce_str'];
    $result['package']   = "prepay_id=".$response['prepay_id'];
    $result['signType']  = $response['MD5'];
    $result['paySign']   = $myWeChat->makePaySign($result['nonceStr'], $result['package'], $result['timeStamp']);
    $result['order_sn']  = $order_sn;

    Output::succ('', $result);

?>