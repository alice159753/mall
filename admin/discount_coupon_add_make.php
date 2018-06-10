<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/DiscountCoupon.php");
    include_once(INCLUDE_DIR. "/DiscountCouponRecord.php");
    include_once(INCLUDE_DIR. "/FileTools.php");
    include_once(INCLUDE_DIR ."/User.php");
    ob_clean();

    $fileList = !empty($_REQUEST["fileList"]) ? trim($_REQUEST["fileList"]) : "" ;
    
    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myDiscountCoupon = new DiscountCoupon($myMySQL);
    $myUser = new User($myMySQL);
    $myDiscountCouponRecord = new DiscountCouponRecord($myMySQL);

    unset($_REQUEST['fileList']);

    //判断优惠券名称不能为空
    $row = $myDiscountCoupon->getRow("*", "title = '".$_REQUEST['title']."'");
    if( !empty($row) )
    {
        Output::error('标题不能重复',array(), 1);
    }

    $dataArray = $_REQUEST;
    $dataArray['add_time']    = 'now()';

    if( !empty($fileList) )
    {
        $dataArray['pic'] = $fileList;
    }

    $myDiscountCoupon->addRow($dataArray);
    $insert_id = $myDiscountCoupon->getInsertID();

    //同步到标签用户
    if( !empty($_REQUEST['user_label_no']) )
    {
        //获得当前所有用户标签
        $rows = $myUser->getRows("*", "user_label_no = ". $_REQUEST['user_label_no']);
        for($i = 0; isset($rows[$i]); $i++)
        {
            $dataArray = array();
            $dataArray['user_no'] = $rows[$i]['no'];
            $dataArray['discount_coupon_no'] = $insert_id;
            $dataArray['add_time'] = 'now()';
            $dataArray['is_use'] = 0;
            $dataArray['is_past'] = 0;

            $myDiscountCouponRecord->addRow($dataArray);
        }
    }

    Output::succ('添加成功！',array());

?>