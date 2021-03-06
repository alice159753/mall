<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/UserLabel.php");
    include_once(INCLUDE_DIR. "/FileTools.php");
    include_once(INCLUDE_DIR ."/Image.php");
    ob_clean();

    $fileList = !empty($_REQUEST["fileList"]) ? trim($_REQUEST["fileList"]) : "" ;
    
    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myUserLabel = new UserLabel($myMySQL);

    unset($_REQUEST['fileList']);

    $dataArray = $_REQUEST;
    $dataArray['add_time']    = 'now()';

    if( !empty($fileList) )
    {
        $dataArray['pic'] = $fileList;
    }

    $myUserLabel->addRow($dataArray);

    Output::succ('添加成功！',array());

?>