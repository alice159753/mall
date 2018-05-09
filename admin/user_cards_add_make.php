<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/UserCards.php");
    include_once(INCLUDE_DIR. "/FileTools.php");
    include_once(INCLUDE_DIR ."/Image.php");
    ob_clean();

    $fileList = !empty($_REQUEST["fileList"]) ? trim($_REQUEST["fileList"]) : "" ;
    $is_shipping = !empty($_REQUEST["is_shipping"]) ? trim($_REQUEST["is_shipping"]) : "0" ;
    $is_discount = !empty($_REQUEST["is_discount"]) ? trim($_REQUEST["is_discount"]) : "0" ;
    $is_give_integral = !empty($_REQUEST["is_give_integral"]) ? trim($_REQUEST["is_give_integral"]) : "0" ;

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myUserCards = new UserCards($myMySQL);

    unset($_REQUEST['fileList']);
    unset($_REQUEST['fileList']);
    unset($_REQUEST['is_shipping']);
    unset($_REQUEST['is_discount']);
    unset($_REQUEST['is_give_integral']);

    $dataArray = $_REQUEST;
    $dataArray['is_shipping']      = $is_shipping;
    $dataArray['is_discount']      = $is_discount;
    $dataArray['is_give_integral'] = $is_give_integral;
    $dataArray['add_time']    = 'now()';

    if( !empty($fileList) )
    {
        $dataArray['pic'] = $fileList;
    }

    $myUserCards->addRow($dataArray);

    Output::succ('添加成功！',array());

?>