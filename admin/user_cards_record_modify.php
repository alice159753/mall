<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/UserCardsRecord.php");
    include_once(INCLUDE_DIR. "/User.php");
    include_once(INCLUDE_DIR. "/UserCards.php");
    ob_clean();

    // request
    $no = isset($_REQUEST["no"]) ? $_REQUEST["no"] : 0;

    if ( $no == 0 )
    {
        header("Location: user_cards_record.php?r=".time());
        exit;
    }
   
    $myTemplate = new Template(TEMPLATE_DIR ."/user_cards_record_modify.html");
    
    include_once("common.inc.php");

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myUserCardsRecord = new UserCardsRecord($myMySQL);
    $myUser = new User($myMySQL);
    $myUserCards = new UserCards($myMySQL);

    $row = $myUserCardsRecord->get("*", "no = $no");
    
    $dataArray = $myUserCardsRecord->getData($row);

    $dataArray['{nickname}'] = $myUser->getValue("nickname", "no = ".$row['user_no']);

    $myTemplate->setReplace("data", $dataArray);


    $rows = $myUserCards->getRows("*", "1=1");

    for($i = 0; isset($rows[$i]); $i++)
    {
        $dataArray = $myUserCards->getData($rows[$i]);

        $myTemplate->setReplace("user_cards_record", $dataArray, 2);
    }

    $myTemplate->process();
    $myTemplate->output();

?>