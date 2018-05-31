<?php

    //文章
    include_once("config.cmd.php");

    ob_start();
    include_once(INCLUDE_DIR. "/Article.php");
    ob_clean();

    $article_no = !empty($_REQUEST["article_no"]) ? $_REQUEST["article_no"] : 0;

    if( empty($article_no) )
    {
        Output::error('article_no不能为空',array(), 1);
    }

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myArticle = new Article($myMySQL);

    $row = $myArticle->getRow("*", "is_through = 'Y' AND no = $article_no");

    if( empty($row) )
    {
        Output::error('文章不存在',array(), 1);
    }

    $result = $myArticle->getDataClean($row);

    $dataArray = array();
    $dataArray['view_count'] = $row['view_count'] + 1;

    $myArticle->update($dataArray, "no = $article_no");

    Output::succ('', $result);
    


?>