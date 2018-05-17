<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/Slideshowad.php");
    ob_clean();

    // request
    $no    = isset($_REQUEST["no"]) ? $_REQUEST["no"] : 0;
    $title = !empty($_REQUEST["title"]) ? trim($_REQUEST["title"]) : "" ;
    $fileList = !empty($_REQUEST["fileList"]) ? trim($_REQUEST["fileList"]) : "" ;
    $url = !empty($_REQUEST["url"]) ? trim($_REQUEST["url"]) : "" ;

    if ( $no == 0 )
    {
        header("Location: slideshow_ad.php?r=".time());
        exit;
    }
   
    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $mySlideshowad = new Slideshowad($myMySQL);

     // check no
    $row = $mySlideshowad->get("*", "no = $no");

    if ( !isset($row["no"]) )
    {
        Output::error('无数据',array(), 1);
    }

    if( !empty($title) )
    {
        $condition = "title = '". $title ."' AND no != $no";

        if( $mySlideshowad->getCount($condition) >= 1 )
        {
           Output::error('标题不能重复！',array(), 1);
        }
    }

    $dataArray = array();
    $dataArray['title']       = $title;
    $dataArray['update_time'] = 'now()';
    $dataArray['url']         = $url;

    if( !empty($fileList) )
    {
        $dataArray['pic'] = $fileList;
    }

    $mySlideshowad->update($dataArray, "no = ". $no);

    Output::succ('修改成功',array());

?>