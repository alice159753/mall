<?php

    include_once("config.cmd.php");

    ob_start();
    include_once(INCLUDE_DIR. "/HotSearch.php");
    ob_clean();

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myHotSearch = new HotSearch($myMySQL);

    $rows = $myHotSearch->getRows("*", "1=1");

    $result = array();
    for($i = 0; isset($rows[$i]); $i++)
    {
        $dataArray = $myHotSearch->getDataClean($rows[$i]);

        $result[] = $dataArray;
    }

    Output::succ('', $result);
    


?>