<?php

    //推荐位
    include_once("config.cmd.php");

    ob_start();
    include_once(INCLUDE_DIR. "/Recommend.php");
    include_once(INCLUDE_DIR. "/Product.php");
    ob_clean();

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myRecommend = new Recommend($myMySQL);
    $myProduct = new Product($myMySQL);

    //轮播图, 最多展示5条
    $rows = $myRecommend->getRows("*", "1=1 ORDER BY no ASC");

    $result = array();
    for($i = 0; isset($rows[$i]); $i++)
    {
        $dataArray = $myRecommend->getDataClean($rows[$i]);

        $product_no = $rows[$i]['product_no'];
        $product_no_lists = explode(",", $product_no);

        foreach ($product_no_lists as $key => $value) 
        {
            $productRow = $myProduct->getRow("*", "no = ". $value ." AND is_online = 1 LIMIT 12");

            if( empty($productRow) )
            {
                continue;
            }

            $data = $myProduct->getDataClean($productRow);

            $dataArray['product_lists'][] = $data;
        }

        $result[] = $dataArray;
    }

    Output::succ('', $result);
    


?>