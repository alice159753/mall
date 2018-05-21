<?php

    //领取优惠券
    include_once("config.cmd.php");

    ob_start();
    include_once(INCLUDE_DIR. "/DiscountCoupon.php");
    include_once(INCLUDE_DIR. "/DiscountCouponRecord.php");
    ob_clean();

    $user_no = !empty($_REQUEST["user_no"]) ? trim($_REQUEST["user_no"]) : "0";
    $discount_coupon_no = !empty($_REQUEST["discount_coupon_no"]) ? trim($_REQUEST["discount_coupon_no"]) : "0";

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myDiscountCoupon = new DiscountCoupon($myMySQL);
    $myDiscountCouponRecord = new DiscountCouponRecord($myMySQL);

    $row = $myDiscountCoupon->getRow("*", "no = $discount_coupon_no");

    if( empty($user_no) || empty($discount_coupon_no) )
    {
        Output::error('参数错误',  '', 20000);
    }

    if( empty($row) )
    {
        Output::error('优惠券不存在',  '', 20001);
    }

    //判断优惠券是否已经过期
    if( $row['date_type'] == 1 )
    {
        if( $row['end_date'] < date('Y-m-d') )
        {
            Output::error('优惠券已过期',  '', 20002);
        }
    }

    //判断优惠券领取数量
    if( $row['limit_num'] != 0 )
    {
        $has_count = $myDiscountCouponRecord->getCount("user_no = $user_no AND discount_coupon_no = $discount_coupon_no");

        if( $has_count >= $row['limit_num'] )
        {
            Output::error('优惠券个人领取数量已达上限',  '', 20003);
        }
    }

    $total_count = $myDiscountCouponRecord->getCount("discount_coupon_no = $discount_coupon_no");

    if( $total_count >= $row['send_num'] )
    {
        Output::error('优惠券发放已达上限',  '', 20004);
    }

    $dataArray = array();
    $dataArray['user_no']            = $user_no;
    $dataArray['discount_coupon_no'] = $discount_coupon_no;
    $dataArray['add_time']           = 'now()';
    $dataArray['is_use']             = 0;
    $dataArray['is_past']            = 0;

    $myDiscountCouponRecord->addRow($dataArray);
    $insert_id = $myDiscountCouponRecord->getInsertID();

    $dataArray['no'] = $insert_id;

    $myDiscountCoupon->update(array('get_num' => $row['get_num'] + 1), "no = $discount_coupon_no");

    Output::succ('', $dataArray);
    


?>