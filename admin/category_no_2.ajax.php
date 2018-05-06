<?php


    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/Category.php");
    ob_clean();

    $category_no_1 = !empty($_REQUEST["category_no_1"]) ? trim($_REQUEST["category_no_1"]) : 0;

    if( empty($category_no_1) )
    {
        echo '';
        exit;
    }

    $myTemplate = new Template(TEMPLATE_DIR ."/category_no_2.ajax.html");
    
    include_once("common.inc.php");

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myCategory = new Category($myMySQL);

    $rows = $myCategory->getRows("*", "parent_no = $category_no_1 ORDER BY no ASC");

    for($i = 0; isset($rows[$i]); $i++)
    {
        $dataArray = $myCategory->getData($rows[$i]);

        $myTemplate->setReplace("category", $dataArray);
    }

    $myTemplate->process();
    $myTemplate->output();

?>