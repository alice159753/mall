<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/DiscountCouponRecord.php");
    include_once(INCLUDE_DIR. "/User.php");
    include_once(INCLUDE_DIR. "/DiscountCoupon.php");
    ob_clean();

    // request
    $no = isset($_REQUEST["no"]) ? $_REQUEST["no"] : 0;

    if ( $no == 0 )
    {
        header("Location: discount_coupon_record.php?r=".time());
        exit;
    }
   
    $myTemplate = new Template(TEMPLATE_DIR ."/discount_coupon_record_modify.html");
    
    include_once("common.inc.php");

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myDiscountCouponRecord = new DiscountCouponRecord($myMySQL);
    $myUser = new User($myMySQL);
    $myDiscountCoupon = new DiscountCoupon($myMySQL);

    $row = $myDiscountCouponRecord->get("*", "no = $no");
    
    $dataArray = $myDiscountCouponRecord->getData($row);

    $dataArray['{nickname}'] = $myUser->getValue("nickname", "no = ".$row['user_no']);

    $myTemplate->setReplace("data", $dataArray);


    $rows = $myDiscountCoupon->getRows("*", "1=1");

    for($i = 0; isset($rows[$i]); $i++)
    {
        $dataArray = $myDiscountCoupon->getData($rows[$i]);

        $myTemplate->setReplace("discount_coupon_record", $dataArray, 2);
    }

    $myTemplate->process();
    $myTemplate->output();

?>