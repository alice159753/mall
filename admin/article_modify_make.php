<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/Article.php");
    include_once(INCLUDE_DIR. "/FileTools.php");
    include_once(INCLUDE_DIR ."/Image.php");
    include_once(INCLUDE_DIR ."/ImageCrop.php");
    ob_clean();

    // request
    $no    = isset($_REQUEST["no"]) ? $_REQUEST["no"] : 0;
    $fileList = !empty($_REQUEST["fileList"]) ? trim($_REQUEST["fileList"]) : "" ;
    $title = !empty($_REQUEST["title"]) ? trim($_REQUEST["title"]) : "" ;

    if ( $no == 0 )
    {
        header("Location: article.php?r=".time());
        exit;
    }
   
    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myArticle = new Article($myMySQL);

     // check no
    $row = $myArticle->get("*", "no = $no");

    if ( !isset($row["no"]) )
    {
        Output::error('无数据',array(), 1);
    }

    $condition = "title = '". $title ."' AND no != $no";

    if( $myArticle->getCount($condition) >= 1 )
    {
       Output::error('标题不能重复！',array(), 1);
    }

    unset($_REQUEST['fileList']);

    $dataArray = $_REQUEST;
    $dataArray['update_time']   = 'now()';

    if( !empty($fileList) )
    {
        $dataArray['thumb_pic'] = $fileList;
    }

    $myArticle->update($dataArray, "no = ". $no);

    Output::succ('修改成功',array());

?>