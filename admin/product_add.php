<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/Category.php");
    include_once(INCLUDE_DIR. "/Brand.php");
    include_once(INCLUDE_DIR. "/PostageConfig.php");
    ob_clean();

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
   
    $myCategory = new Category($myMySQL);
    $myBrand = new Brand($myMySQL);
    $myPostageConfig = new PostageConfig($myMySQL);

    $myTemplate = new Template(TEMPLATE_DIR ."/product_add.html");
    
    include_once("common.inc.php");

    //获得一级分类
    $rows = $myCategory->getRows("*", "1=1");

    for($i = 0; isset($rows[$i]); $i++)
    {
        $dataArray = $myCategory->getData($rows[$i]);

        $myTemplate->setReplace("category", $dataArray);
    }

    //获得商品品牌
    $rows = $myBrand->getRows("*", "1=1 ORDER BY sort ASC");

    for($i = 0; isset($rows[$i]); $i++)
    {
        $dataArray = $myBrand->getData($rows[$i]);

        $myTemplate->setReplace("brand", $dataArray);
    }

    //获得运费模版
    $rows = $myPostageConfig->getRows("*", "1=1");

    for($i = 0; isset($rows[$i]); $i++)
    {
        $dataArray = $myPostageConfig->getData($rows[$i]);

        $myTemplate->setReplace("postage_config", $dataArray);
    }


    $myTemplate->process();
    $myTemplate->output();

?>