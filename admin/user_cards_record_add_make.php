<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/UserCardsRecord.php");
    include_once(INCLUDE_DIR. "/FileTools.php");
    include_once(INCLUDE_DIR ."/Tools.php");
    ob_clean();

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myUserCardsRecord = new UserCardsRecord($myMySQL);

    //判断是否已经添加了该会员卡
    if( $myUserCardsRecord->getCount("user_no = ".$_REQUEST['user_no']." AND user_cards_no = ". $_REQUEST['user_cards_no']) >= 1 )
    {
        Output::error('已经添加了该会员卡，不能重复添加',array(), 1);
    }

    $dataArray = $_REQUEST;
    $dataArray['add_time']    = 'now()';

    //创建一个会员卡号
    $cards_sn1 = Tools::makeUniqueNumber(4);
    $cards_sn2 = Tools::makeUniqueNumber(4);
    $cards_sn3 = Tools::makeUniqueNumber(4);
    $cards_sn4 = Tools::makeUniqueNumber(4);
    $cards_sn5 = Tools::makeUniqueNumber(2);

    $dataArray['cards_sn'] = $cards_sn1." ".$cards_sn2." ".$cards_sn3." ".$cards_sn4." ".$cards_sn5;

    $myUserCardsRecord->addRow($dataArray);

    Output::succ('添加成功！',array());

?>