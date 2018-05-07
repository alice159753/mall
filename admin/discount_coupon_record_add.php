<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/DiscountCoupon.php");
    include_once(INCLUDE_DIR. "/User.php");
    ob_clean();

    $user_no = !empty($_REQUEST["user_no"]) ? $_REQUEST["user_no"] : "0";

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
   
    $myDiscountCoupon = new DiscountCoupon($myMySQL);
    $myUser = new User($myMySQL);

    $myTemplate = new Template(TEMPLATE_DIR ."/discount_coupon_record_add.html");
    
    include_once("common.inc.php");

    $rows = $myDiscountCoupon->getRows("*", "1=1");

    for($i = 0; isset($rows[$i]); $i++)
    {
        $dataArray = $myDiscountCoupon->getData($rows[$i]);

        $myTemplate->setReplace("discount_coupon_record", $dataArray);
    }

    $userRow = $myUser->getRow("*", "no = $user_no");

    $dataArray = $myUser->getData($userRow);

    $myTemplate->setReplace("user", $dataArray);


    $myTemplate->process();
    $myTemplate->output();

?>