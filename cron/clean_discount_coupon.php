<?php

    //清除用户过期的优惠券
    include_once("../api/config.cmd.php");

    ob_start();
    include_once(INCLUDE_DIR. "/DiscountCouponRecord.php");
    include_once(INCLUDE_DIR. "/DiscountCoupon.php");
    ob_clean();

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myDiscountCouponRecord = new DiscountCouponRecord($myMySQL);
    $myDiscountCoupon = new DiscountCoupon($myMySQL);

    $count = $myDiscountCouponRecord->getCount("1=1");

    $start = 0;
    $page = 1;
    $today = date('Y-m-d');

    while( $start < $count )
    {
        $rows = $myDiscountCouponRecord->getPage("*", $page, 500, "1=1");

        for($i = 0; isset($rows[$i]);  $i++)
        {
            $no = $rows[$i]['no'];
            $add_time = $rows[$i]['add_time'];
            $add_time = date('Y-m-d', strtotime($add_time));

            $dataArray = array();
            $dataArray['is_past'] = 1;
            $dataArray['update_time'] = 'now()';

            $one = $myDiscountCoupon->getRow("*", "no =". $rows[$i]['discount_coupon_no']);

            //固定日期
            if( $one['date_type'] == 1 )
            {
                if( strtotime($today) > strtotime($one['end_date']) )
                {
                    $myDiscountCouponRecord->update($dataArray, "no = $no");
                }
            }

            //领到券当日开始N天内有效
            if( $one['date_type'] == 2 )
            {
                $add_time = date('Y-m-d', strtotime('+'.$one['valid_day_today'].' day', strtotime($add_time)));

                if( strtotime($today) > strtotime($add_time) )
                {
                    $myDiscountCouponRecord->update($dataArray, "no = $no");
                }

            }

            //领到券次日开始N天内有效
            if( $one['date_type'] == 3 )
            {
                $one['valid_day_tomorrow'] = $one['valid_day_tomorrow'] + 1;

                $add_time = date('Y-m-d', strtotime('+'.$one['valid_day_tomorrow'].' day', strtotime($add_time)));

                if( strtotime($today) > strtotime($add_time) )
                {
                    $myDiscountCouponRecord->update($dataArray, "no = $no");
                }
            }
        }


        $page++;
        $start += 500;
    }






?>