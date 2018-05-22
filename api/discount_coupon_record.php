<?php

    //客户的优惠券
    include_once("config.cmd.php");

    ob_start();
    include_once(INCLUDE_DIR. "/DiscountCouponRecord.php");    
    include_once(INCLUDE_DIR. "/DiscountCoupon.php");
    ob_clean();

    $order = !empty($_REQUEST["order"]) ? $_REQUEST["order"] : 'no desc';  //综合将序
    $page = !empty($_REQUEST["page"]) ? $_REQUEST["page"] : 1;
    $page_size = !empty($_REQUEST["page_size"]) ? $_REQUEST["page_size"] : 1;
    $user_no = !empty($_REQUEST["user_no"]) ? trim($_REQUEST["user_no"]) : "0";
    $type = !empty($_REQUEST["type"]) ? trim($_REQUEST["type"]) : "1";  //1 可使用，2已过期，已使用

    if( empty($user_no) )
    {
        Output::succ('',  array());
    }

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myDiscountCouponRecord = new DiscountCouponRecord($myMySQL);
    $myDiscountCoupon = new DiscountCoupon($myMySQL);

    if( $type == 1 )
    {
        $condition = "user_no = $user_no AND is_use = 0 AND is_past = 0";
    }
    else if( $type == 2 )
    {
        $condition = "user_no = $user_no AND (is_use = 1 OR is_past = 1)";
    }

    $total_page = $myDiscountCouponRecord->getPageCount($page_size, $condition);

    $total_page = ($total_page == 0) ? 1 : $total_page;

    if( $page > $total_page )
    {
        Output::succ('', array());
    }

    $default_field = "*";
    $rows = $myDiscountCouponRecord->getPage($default_field, $page, $page_size, $condition ." ORDER BY $order");

    $result = array();
    for($i = 0; isset($rows[$i]); $i++)
    {
        $dataArray = $myDiscountCouponRecord->getDataClean($rows[$i]);

        //获取优惠券信息
        $row = $myDiscountCoupon->getRow("*", "no = ". $rows[$i]['discount_coupon_no']);
        $dataArray['discount_coupon'] = $myDiscountCoupon->getDataClean($row);

        //统计开始时间和结束时间
        if( $dataArray['discount_coupon']['date_type'] == 1 )
        {
            $dataArray['start_date'] = $dataArray['discount_coupon']['start_date'];
            $dataArray['end_date'] = $dataArray['discount_coupon']['end_date'];
        }

        if( $dataArray['discount_coupon']['date_type'] == 2 )
        {
            $valid_day_today = $dataArray['discount_coupon']['valid_day_today'];

            $dataArray['start_date'] = date('Y-m-d', strtotime($rows[$i]['add_time']));
            $dataArray['end_date'] = date('Y-m-d', strtotime('+ '.$valid_day_today.'day', strtotime($rows[$i]['add_time'])));
        }

        if( $dataArray['discount_coupon']['date_type'] == 3 )
        {
            $valid_day_tomorrow = $dataArray['discount_coupon']['valid_day_tomorrow'];

            $dataArray['start_date'] = date('Y-m-d', strtotime($rows[$i]['add_time']));
            $dataArray['end_date'] = date('Y-m-d', strtotime('+ '.$valid_day_tomorrow.'day', strtotime($rows[$i]['add_time'])));
        }

        $result[] = $dataArray;
    }

    Output::succ('', $result);
    


?>