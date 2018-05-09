<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/DiscountCoupon.php");
    include_once(INCLUDE_DIR. "/UserLabel.php");
    ob_clean();

    // request
    $no = isset($_REQUEST["no"]) ? $_REQUEST["no"] : 0;

    if ( $no == 0 )
    {
        header("Location: discount_coupon.php?r=".time());
        exit;
    }
   
    $myTemplate = new Template(TEMPLATE_DIR ."/discount_coupon_modify.html");
    
    include_once("common.inc.php");

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myDiscountCoupon = new DiscountCoupon($myMySQL);
    $myUserLabel = new UserLabel($myMySQL);

    $row = $myDiscountCoupon->get("*", "no = $no");
    
    $dataArray = $myDiscountCoupon->getData($row);

    $myTemplate->setReplace("data", $dataArray);

    $userLabelRows = $myUserLabel->getRows("*", "1=1");

    for($i = 0; isset($userLabelRows[$i]); $i++)
    {
        $dataArray = $myUserLabel->getData($userLabelRows[$i]);
        
        $myTemplate->setReplace("user_label", $dataArray, 2);
    }


    $myTemplate->process();
    $myTemplate->output();
?>