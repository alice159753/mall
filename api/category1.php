<?php

    include_once("config.cmd.php");

    ob_start();
    include_once(INCLUDE_DIR. "/Category.php");
    ob_clean();

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myCategory = new Category($myMySQL);

    //轮播图, 最多展示5条
    $rows = $myCategory->getRows("*", "is_show = 'Y' AND parent_no = 0 ORDER BY sort ASC");

    $result = array();
    for($i = 0; isset($rows[$i]); $i++)
    {
        $dataArray = $myCategory->getDataClean($rows[$i]);

        $result[] = $dataArray;
    }

    Output::succ('', $result);
    


?>