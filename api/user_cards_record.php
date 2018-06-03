<?php

    //客户的会员卡
    include_once("config.cmd.php");

    ob_start();
    include_once(INCLUDE_DIR. "/UserCardsRecord.php");    
    include_once(INCLUDE_DIR. "/UserCards.php");
    ob_clean();

    $order = !empty($_REQUEST["order"]) ? $_REQUEST["order"] : 'is_default desc';  //综合将序
    $page = !empty($_REQUEST["page"]) ? $_REQUEST["page"] : 1;
    $page_size = !empty($_REQUEST["page_size"]) ? $_REQUEST["page_size"] : 100;
    $user_no = !empty($_REQUEST["user_no"]) ? trim($_REQUEST["user_no"]) : "0";

    if( empty($user_no) )
    {
        Output::succ('',  array());
    }

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myUserCardsRecord = new UserCardsRecord($myMySQL);
    $myUserCards = new UserCards($myMySQL);

    $condition = "user_no = $user_no";

    $total_page = $myUserCardsRecord->getPageCount($page_size, $condition);

    $total_page = ($total_page == 0) ? 1 : $total_page;

    if( $page > $total_page )
    {
        Output::succ('', array());
    }

    $default_field = "*";
    $rows = $myUserCardsRecord->getPage($default_field, $page, $page_size, $condition ." ORDER BY $order");

    $result = array();
    for($i = 0; isset($rows[$i]); $i++)
    {
        $dataArray = $myUserCardsRecord->getDataClean($rows[$i]);

        $user_cards_no = $rows[$i]['user_cards_no'];

        $userCards = $myUserCards->getRow("*", "no = $user_cards_no");

        if( empty($userCards) )
        {
            continue;
        }

        $dataArray['user_cards'] = $myUserCards->getDataClean($userCards);

        $result[] = $dataArray;
    }

    Output::succ('', $result);
    


?>