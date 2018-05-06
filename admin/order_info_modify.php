<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/OrderInfo.php");
    include_once(INCLUDE_DIR. "/OrderProduct.php");
    include_once(INCLUDE_DIR. "/ProductComment.php");
    ob_clean();

    // request
    $no = isset($_REQUEST["no"]) ? $_REQUEST["no"] : 0;

    if ( $no == 0 )
    {
        header("Location: order_info.php?r=".time());
        exit;
    }
   
    $myTemplate = new Template(TEMPLATE_DIR ."/order_info_modify.html");
    
    include_once("common.inc.php");

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myOrderInfo = new OrderInfo($myMySQL);
    $myOrderProduct = new OrderProduct($myMySQL);
    $myProductComment = new ProductComment($myMySQL);

    $row = $myOrderInfo->get("*", "no = $no");
    
    $dataArray = $myOrderInfo->getData($row);

    $myTemplate->setReplace("data", $dataArray);

    $commentType = $myProductComment->getCommentType();

    $rows = $myOrderProduct->getRows("*", "order_no = $no");
    for($i = 0; isset($rows[$i]); $i++)
    {
        $dataArray = $myOrderProduct->getData($rows[$i]);

        $productComment = $myProductComment->getRow("*", "order_info_no = $no AND product_no = ".$rows[$i]['product_no']);

        $dataArray['{comment_type_title}'] = $commentType[ $productComment['comment_type'] ];
        $dataArray['{content}'] = $productComment['content'];

        $myTemplate->setReplace("product", $dataArray, 2);
    }


    $myTemplate->process();
    $myTemplate->output();
?>