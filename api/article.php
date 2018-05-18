<?php

    //文章
    include_once("config.cmd.php");

    ob_start();
    include_once(INCLUDE_DIR. "/Article.php");
    ob_clean();

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myArticle = new Article($myMySQL);

    //轮播图, 最多展示5条
    $rows = $myArticle->getRows("*", "is_through = 'Y' ORDER BY top DESC LIMIT 5");

    $result = array();
    for($i = 0; isset($rows[$i]); $i++)
    {
        $dataArray = $myArticle->getDataClean($rows[$i]);

        $result[] = $dataArray;
    }

    Output::succ('', $result);
    


?>