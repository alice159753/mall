<?php


    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/Specification.php");
    ob_clean();

    $specification_no1 = !empty($_REQUEST["specification_no1"]) ? trim($_REQUEST["specification_no1"]) : 0;
    $specification_no2 = !empty($_REQUEST["specification_no2"]) ? trim($_REQUEST["specification_no2"]) : 0;
    $specification_no3 = !empty($_REQUEST["specification_no3"]) ? trim($_REQUEST["specification_no3"]) : 0;


    if( empty($specification_no1) && empty($specification_no2) && 
        empty($specification_no3))
    {
        echo '';
        exit;
    }

    if( !empty($specification_no1) )
    {
        $specification_no = $specification_no1;
    }

    if( !empty($specification_no2) )
    {
        $specification_no = $specification_no2;
    }

    if( !empty($specification_no3) )
    {
        $specification_no = $specification_no3;
    }

    if( empty($specification_no) )
    {
        echo '';
        exit;
    }

    $myTemplate = new Template(TEMPLATE_DIR ."/specification_content.ajax.html");
    
    include_once("common.inc.php");

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $mySpecification = new Specification($myMySQL);

    $row = $mySpecification->getRow("*", "no = $specification_no ORDER BY no ASC");

    $contentList = explode(",", $row['content']);

    for($i = 0; isset($contentList[$i]); $i++)
    {
        $dataArray = array();
        $dataArray['{title}'] = $contentList[$i];

        $myTemplate->setReplace("specification", $dataArray);
    }

    $myTemplate->process();
    $myTemplate->output();

?>