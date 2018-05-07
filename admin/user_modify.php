<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/User.php");
    include_once(INCLUDE_DIR. "/UserLabel.php");
    ob_clean();

    // request
    $no = isset($_REQUEST["no"]) ? $_REQUEST["no"] : 0;

    if ( $no == 0 )
    {
        header("Location: user.php?r=".time());
        exit;
    }
   
    $myTemplate = new Template(TEMPLATE_DIR ."/user_modify.html");
    
    include_once("common.inc.php");

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myUser = new User($myMySQL);
    $myUserLabel = new UserLabel($myMySQL);

    $row = $myUser->get("*", "no = $no");
    
    $dataArray = $myUser->getData($row);
 
    $myTemplate->setReplace("data", $dataArray);


    $rows = $myUserLabel->getRows("*", "1=1");

    for($i = 0; isset($rows[$i]); $i++)
    {
        $dataArray = $myUserLabel->getData($rows[$i]);

        $myTemplate->setReplace("user_label", $dataArray, 2);
    }



    $myTemplate->process();
    $myTemplate->output();
?>