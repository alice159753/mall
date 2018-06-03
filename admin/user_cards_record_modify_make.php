<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/UserCardsRecord.php");
    include_once(INCLUDE_DIR. "/FileTools.php");
    include_once(INCLUDE_DIR ."/Image.php");
    include_once(INCLUDE_DIR ."/ImageCrop.php");
    ob_clean();

    // request
    $no    = isset($_REQUEST["no"]) ? $_REQUEST["no"] : 0;

    if ( $no == 0 )
    {
        header("Location: user_cards_record.php?r=".time());
        exit;
    }

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myUserCardsRecord = new UserCardsRecord($myMySQL);

     // check no
    $row = $myUserCardsRecord->get("*", "no = $no");

    if ( !isset($row["no"]) )
    {
        Output::error('无数据',array(), 1);
    }

    //判断是否已经添加了该会员卡
    if( $myUserCardsRecord->getCount("user_no = ".$_REQUEST['user_no']." AND user_cards_no = ". $_REQUEST['user_cards_no'] ." AND no != $no") >= 1 )
    {
        Output::error('已经添加了该会员卡，不能重复添加',array(), 1);
    }

    $dataArray = $_REQUEST;
    $dataArray['update_time'] = 'now()';

    $myUserCardsRecord->update($dataArray, "no = ". $no);

    Output::succ('修改成功',array());

?>