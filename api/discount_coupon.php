<?php

    //所有的优惠券
    include_once("config.cmd.php");

    ob_start();
    include_once(INCLUDE_DIR. "/DiscountCoupon.php");
    ob_clean();

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myDiscountCoupon = new DiscountCoupon($myMySQL);

    //轮播图, 最多展示5条
    $rows = $myDiscountCoupon->getRows("*", "1 = 1 ORDER BY no DESC");

    $result = array();
    for($i = 0; isset($rows[$i]); $i++)
    {
        $dataArray = $myDiscountCoupon->getDataClean($rows[$i]);

        $result[] = $dataArray;
    }

    Output::succ('', $result);
    


?>