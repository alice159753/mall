<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/UserLabel.php");
    ob_clean();

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
   
    $myUserLabel = new UserLabel($myMySQL);

    $myTemplate = new Template(TEMPLATE_DIR ."/user_add.html");
    
    include_once("common.inc.php");

    $rows = $myUserLabel->getRows("*", "1=1");

    for($i = 0; isset($rows[$i]); $i++)
    {
        $dataArray = $myUserLabel->getData($rows[$i]);

        $myTemplate->setReplace("user_label", $dataArray);
    }

    $myTemplate->process();
    $myTemplate->output();

?>