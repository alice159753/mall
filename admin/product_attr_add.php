<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/Product.php");
    include_once(INCLUDE_DIR. "/Specification.php");
    ob_clean();

    $product_no = !empty($_REQUEST["product_no"]) ? $_REQUEST["product_no"] : "0";

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
   
    $myProduct = new Product($myMySQL);
    $mySpecification = new Specification($myMySQL);

    $myTemplate = new Template(TEMPLATE_DIR ."/product_attr_add.html");
    
    include_once("common.inc.php");

    if( empty($product_no) )
    {
        JavaScript::alert("商品编号不能为空！");
        exit;
    }

    $productRow = $myProduct->getRow("title", "no = $product_no");

    $dataArray = array();
    $dataArray['{product_no}'] = $product_no;
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