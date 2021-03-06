<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/Category.php");
    ob_clean();

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
   
    $myCategory  = new Category($myMySQL);

    $myTemplate = new Template(TEMPLATE_DIR ."/category_add.html");
    
    include_once("common.inc.php");

    $categoryRow = $myCategory->getRow("*", "1=1 ORDER BY sort DESC LIMIT 1");

    $categoryRow['sort'] = $categoryRow['sort'] + 1;

    $dataArray = $myCategory->getData($categoryRow);

    $myTemplate->setReplace("data", $dataArray);

    $rows = $myCategory->getRows("*", "parent_no = 0");

    for($i = 0; isset($rows[$i]); $i++)
    {   
        $dataArray = $myCategory->getData($rows[$i]);

        $myTemplate->setReplace("parent_no_lists", $dataArray);
    }

    $myTemplate->process();
    $myTemplate->output();

?>