<?php

    //文章
    include_once("config.cmd.php");

    ob_start();
    include_once(INCLUDE_DIR. "/Article.php");
    ob_clean();

    $article_no = !empty($_REQUEST["article_no"]) ? $_REQUEST["article_no"] : 0;

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myArticle = new Article($myMySQL);

    if( empty($article_no) )
    {
        $rows = $myArticle->getRows("*", "is_through = 'Y' ORDER BY top DESC LIMIT 5");
    }
    else
    {
        $rows = $myArticle->getRows("*", "is_through = 'Y' AND no != $article_no ORDER BY top DESC LIMIT 5");
    }

    $result = array();
    for($i = 0; isset($rows[$i]); $i++)
    {
        $dataArray = $myArticle->getDataClean($rows[$i]);

        $result[] = $dataArray;
    }

    Output::succ('', $result);
    


?>