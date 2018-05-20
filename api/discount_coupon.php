<?php

    //所有的优惠券
    include_once("config.cmd.php");

    ob_start();
    include_once(INCLUDE_DIR. "/DiscountCoupon.php");
    include_once(INCLUDE_DIR. "/DiscountCouponRecord.php");
    ob_clean();

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myDiscountCoupon = new DiscountCoupon($myMySQL);
    $myDiscountCouponRecord = new DiscountCouponRecord($myMySQL);

    $rows = $myDiscountCoupon->getRows("*", "1 = 1 ORDER BY no DESC");

    $result = array();
    for($i = 0; isset($rows[$i]); $i++)
    {
        //排除掉已经过期的优惠券
        if( $rows[$i]['date_type'] == 1 )
        {
            if( $rows[$i]['end_date'] < date('Y-m-d') )
            {
                continue;
            }
        }

        //过滤掉发放数量超过限制的
        $total_count = $myDiscountCouponRecord->getCount("discount_coupon_no = ". $rows[$i]['no']);

        if( $total_count >= $rows[$i]['send_num'] )
        {
            continue;
        }

        $dataArray = $myDiscountCoupon->getDataClean($rows[$i]);

        $result[] = $dataArray;
    }

    Output::succ('', $result);
    


?>