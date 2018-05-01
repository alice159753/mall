<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/Article.php");
    include_once(INCLUDE_DIR. "/FileTools.php");
    include_once(INCLUDE_DIR ."/Image.php");
    ob_clean();

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myArticle = new Article($myMySQL);

    unset($_REQUEST['fileList']);

    $dataArray = $_REQUEST;
    $dataArray['add_time']    = 'now()';

    $myArticle->addRow($dataArray);

    Output::succ('添加成功！',array());

?>