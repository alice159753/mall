<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/UserCards.php");
    include_once(INCLUDE_DIR. "/User.php");
    ob_clean();

    $user_no = !empty($_REQUEST["user_no"]) ? $_REQUEST["user_no"] : "0";

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
   
    $myUserCards = new UserCards($myMySQL);
    $myUser = new User($myMySQL);

    $myTemplate = new Template(TEMPLATE_DIR ."/user_cards_record_add.html");
    
    include_once("common.inc.php");

    $rows = $myUserCards->getRows("*", "1=1");

    for($i = 0; isset($rows[$i]); $i++)
    {
        $dataArray = $myUserCards->getData($rows[$i]);

        $myTemplate->setReplace("user_cards_record", $dataArray);
    }

    $userRow = $myUser->getRow("*", "no = $user_no");

    $dataArray = $myUser->getData($userRow);

    $myTemplate->setReplace("user", $dataArray);


    $myTemplate->process();
    $myTemplate->output();

?>