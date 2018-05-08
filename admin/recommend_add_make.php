<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/Recommend.php");
    include_once(INCLUDE_DIR. "/Output.php");
    ob_clean();

    $title = !empty($_REQUEST["title"]) ? trim($_REQUEST["title"]) : "" ;

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myRecommend = new Recommend($myMySQL);

    $condition = "title = '". $title ."'";

    if( $myRecommend->getCount($condition) >= 1 )
    {
       Output::error('推荐位名称不能重复！',array(), 1);
    }

    $dataArray = $_REQUEST;
    $dataArray['add_time'] = 'now()';

    $myRecommend->addRow($dataArray);

    Output::succ('添加成功！', array());

?>