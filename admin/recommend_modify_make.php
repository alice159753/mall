<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/Recommend.php");
    ob_clean();

    // request
    $no    = isset($_REQUEST["no"]) ? $_REQUEST["no"] : 0;
    $title = !empty($_REQUEST["title"]) ? trim($_REQUEST["title"]) : "" ;

    if ( $no == 0 )
    {
        header("Location: recommend.php?r=".time());
        exit;
    }
   
    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myRecommend= new Recommend($myMySQL);

     // check no
    $row = $myRecommend->get("*", "no = $no");

    if ( !isset($row["no"]) )
    {
        Output::error('无数据',array(), 1);
    }

    $condition = "title = '". $title ."' AND no != $no";

    if( $myRecommend->getCount($condition) >= 1 )
    {
       Output::error('推荐位名称不能重复！',array(), 1);
    }

    $dataArray = $_REQUEST;
    $dataArray['update_time'] = 'now()';

    $myRecommend->update($dataArray, "no = ". $no);

    Output::succ('修改成功',array());

?>