<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/UserCards.php");
    include_once(INCLUDE_DIR. "/FileTools.php");
    include_once(INCLUDE_DIR ."/Image.php");
    include_once(INCLUDE_DIR ."/ImageCrop.php");
    ob_clean();

    // request
    $no    = isset($_REQUEST["no"]) ? $_REQUEST["no"] : 0;
    $fileList = !empty($_REQUEST["fileList"]) ? trim($_REQUEST["fileList"]) : "" ;
    $is_shipping = !empty($_REQUEST["is_shipping"]) ? trim($_REQUEST["is_shipping"]) : "0" ;
    $is_discount = !empty($_REQUEST["is_discount"]) ? trim($_REQUEST["is_discount"]) : "0" ;
    $is_give_integral = !empty($_REQUEST["is_give_integral"]) ? trim($_REQUEST["is_give_integral"]) : "0" ;

    if ( $no == 0 )
    {
        header("Location: user_cards.php?r=".time());
        exit;
    }

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myUserCards = new UserCards($myMySQL);

     // check no
    $row = $myUserCards->get("*", "no = $no");

    if ( !isset($row["no"]) )
    {
        Output::error('无数据',array(), 1);
    }

    $condition = "title = '". $title ."' AND no != $no";

    if( $myUserCards->getCount($condition) >= 1 )
    {
       Output::error('标题不能重复！',array(), 1);
    }

    unset($_REQUEST['fileList']);
    unset($_REQUEST['is_shipping']);
    unset($_REQUEST['is_discount']);
    unset($_REQUEST['is_give_integral']);

    $dataArray = $_REQUEST;
    $dataArray['update_time']      = 'now()';
    $dataArray['is_shipping']      = $is_shipping;
    $dataArray['is_discount']      = $is_discount;
    $dataArray['is_give_integral'] = $is_give_integral;

    if( !empty($fileList) )
    {
        $dataArray['pic'] = $fileList;
    }

    $myUserCards->update($dataArray, "no = ". $no);

    Output::succ('修改成功',array());

?>