<?php

    //文章收藏
    include_once("config.cmd.php");

    ob_start();
    include_once(INCLUDE_DIR. "/Article.php");
    include_once(INCLUDE_DIR. "/UserCollect.php");
    ob_clean();

    $article_no = !empty($_REQUEST["article_no"]) ? $_REQUEST["article_no"] : 0;
    $user_no = !empty($_REQUEST["user_no"]) ? $_REQUEST["user_no"] : 0;

    if( empty($article_no) )
    {
        Output::error('article_no不能为空',array(), 1);
    }

    if( empty($user_no) )
    {
        Output::error('user_no不能为空',array(), 1);
    }

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myArticle = new Article($myMySQL);
    $myUserCollect = new UserCollect($myMySQL);

    //已经收藏则删除
    $result = array();
    $result['is_collect'] = 0;

    $condition = "user_no = $user_no AND collect_no = $article_no AND collect_type = 2";
    if( $myUserCollect->getCount($condition) >= 1 )
    {
        $myUserCollect->remove($condition);

        $result['is_collect'] = 0;
    }
    else
    {
        $dataArray = array();
        $dataArray['user_no']      = $user_no;
        $dataArray['collect_no']   = $article_no;
        $dataArray['collect_type'] = 2;
        $dataArray['add_time']     = 'now()';

        $myUserCollect->addRow($dataArray);

        $result['is_collect'] = 1;
    }

    Output::succ('', $result);
    


?>