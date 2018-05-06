<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/Article.php");
    include_once(INCLUDE_DIR. "/FileTools.php");
    include_once(INCLUDE_DIR ."/Image.php");
    ob_clean();

    $fileList = !empty($_REQUEST["fileList"]) ? trim($_REQUEST["fileList"]) : "" ;
    $title = !empty($_REQUEST["title"]) ? trim($_REQUEST["title"]) : "" ;

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myArticle = new Article($myMySQL);

    unset($_REQUEST['fileList']);

    $condition = "title = '". $title ."' ";

    if( $myArticle->getCount($condition) >= 1 )
    {
       Output::error('标题不能重复！',array(), 1);
    }

    $dataArray = $_REQUEST;
    $dataArray['add_time']    = 'now()';

    if( !empty($fileList) )
    {
        $dataArray['thumb_pic'] = $fileList;
    }

    $myArticle->addRow($dataArray);

    Output::succ('添加成功！',array());

?>