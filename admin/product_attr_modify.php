<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/ProductAttr.php");
    include_once(INCLUDE_DIR. "/Product.php");
    include_once(INCLUDE_DIR. "/Specification.php");
    ob_clean();

    // request
    $no = isset($_REQUEST["no"]) ? $_REQUEST["no"] : 0;

    if ( $no == 0 )
    {
        header("Location: product_attr.php?r=".time());
        exit;
    }
   
    $myTemplate = new Template(TEMPLATE_DIR ."/product_attr_modify.html");
    
    include_once("common.inc.php");

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myProductAttr = new ProductAttr($myMySQL);
    $myProduct = new Product($myMySQL);
    $mySpecification = new Specification($myMySQL);

    $row = $myProductAttr->get("*", "no = $no");
    
    $dataArray = $myProductAttr->getData($row);

    $productRow = $myProduct->getRow("title", "no = ".$row['product_no']);

    $dataArray['{product_title}'] = $productRow['title'];

    $myTemplate->setReplace("data", $dataArray);

    //获得所有的规格
    $rows = $mySpecification->getRows("*", "1=1");

    for($i = 0; isset($rows[$i]); $i++)
    {
        $dataArray = $mySpecification->getData($rows[$i]);

        $myTemplate->setReplace("specification", $dataArray, 2);
    }

    $myTemplate->process();
    $myTemplate->output();
?>