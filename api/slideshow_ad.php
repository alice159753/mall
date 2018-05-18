<?php

    //推荐位
    include_once("config.cmd.php");

    ob_start();
    include_once(INCLUDE_DIR. "/Slideshowad.php");
    ob_clean();

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $mySlideshowad = new Slideshowad($myMySQL);

    //轮播图, 最多展示5条
    $rows = $mySlideshowad->getRows("*", "1=1 ORDER BY no DESC LIMIT 5");

    $result = array();
    for($i = 0; isset($rows[$i]); $i++)
    {
        $dataArray = $mySlideshowad->getDataClean($rows[$i]);

        $result[] = $dataArray;
    }

    Output::succ('', $result);
    


?>