<?php

    //客户的会员卡
    include_once("config.cmd.php");

    ob_start();
    include_once(INCLUDE_DIR. "/UserCardsRecord.php");    
    include_once(INCLUDE_DIR. "/UserCards.php");
    ob_clean();

    $user_cards_record_no = !empty($_REQUEST["user_cards_record_no"]) ? $_REQUEST["user_cards_record_no"] : '0';
    $user_no = !empty($_REQUEST["user_no"]) ? trim($_REQUEST["user_no"]) : "0";

    if( empty($user_no) )
    {
        Output::error('用户no不能为空',array(), 1);
    }

    if( empty($user_cards_record_no) )
    {
        Output::error('会员卡no不能为空',array(), 1);
    }

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myUserCardsRecord = new UserCardsRecord($myMySQL);
    $myUserCards = new UserCards($myMySQL);

    $condition = "user_no = $user_no AND no = $user_cards_record_no";

    $row = $myUserCardsRecord->getRow("*", $condition);

    if( empty($row) )
    {
        Output::error('会员卡已经失效1',array(), 1);
    }

    $dataArray = $myUserCardsRecord->getDataClean($row);

    $user_cards_no = $row['user_cards_no'];

    $userCards = $myUserCards->getRow("*", "no = $user_cards_no");

    if( empty($userCards) )
    {
        Output::error('会员卡已经失效2',array(), 1);
    }

    $dataArray['user_cards'] = $myUserCards->getDataClean($userCards);

    $result = $dataArray;

    Output::succ('', $result);
    


?>