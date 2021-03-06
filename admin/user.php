<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/User.php");
    include_once(INCLUDE_DIR. "/UserLabel.php");
    ob_clean();

    $order = !empty($_REQUEST["order"]) ? $_REQUEST["order"] : "no desc";
    $page = !empty($_REQUEST["page"]) ? $_REQUEST["page"] : 1;
    $nickname = !empty($_REQUEST["nickname"]) ? $_REQUEST["nickname"] : "";
    $open_id = !empty($_REQUEST["open_id"]) ? $_REQUEST["open_id"] : "";
    $phone = !empty($_REQUEST["phone"]) ? $_REQUEST["phone"] : "";
    $add_time_min = !empty($_REQUEST["add_time_min"]) ? $_REQUEST["add_time_min"] : "";
    $add_time_max = !empty($_REQUEST["add_time_max"]) ? $_REQUEST["add_time_max"] : "";
    $channel_id = !empty($_REQUEST["channel_id"]) ? $_REQUEST["channel_id"] : "";
    $user_label_no = !empty($_REQUEST["user_label_no"]) ? $_REQUEST["user_label_no"] : "0";


    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myUser = new User($myMySQL);
    $myUserLabel = new UserLabel($myMySQL);

    $myTemplate = new Template(TEMPLATE_DIR ."/user.html");

    include_once("common.inc.php");

    // search
    $searchArray = array( "{order}" => $order );

    $searchArray['{nickname}'] = $nickname;
    $searchArray['{open_id}'] = $open_id;
    $searchArray['{phone}'] = $phone;
    $searchArray['{add_time_max}'] = $add_time_max;
    $searchArray['{add_time_min}'] = $add_time_min;
    $searchArray['{channel_id}'] = $channel_id;
    $searchArray['{user_label_no}'] = $user_label_no;

    $myTemplate->setReplace("search", $searchArray);

    $condition = " 1=1 ";

    if( !empty($nickname) )
    {
        $condition .= " AND nickname like '%$nickname%'";
    }

    if( !empty($open_id) )
    {
        $condition .= " AND open_id like '%$open_id%'";
    }

    if( !empty($phone) )
    {
        $condition .= " AND phone = '$phone'";
    }

    if( !empty($channel_id) )
    {
        $condition .= " AND channel_id = '$channel_id'";
    }

    if( !empty($user_label_no) )
    {
        $condition .= " AND user_label_no = $user_label_no";
    }

    if( !empty($add_time_min) )
    {
        $condition .= " AND add_time >= '$add_time_min'";
    }

    if( !empty($add_time_max) )
    {
        $condition .= " AND add_time <= '$add_time_max 23:59:59'";
    }

    // page
    $page_size = 50;

    $total_count = $myUser->getCount($condition);
    $total_page = $myUser->getPageCount($page_size, $condition);

    $total_page = ($total_page == 0) ? 1 : $total_page;
    $page = ($total_page < $page) ? $total_page : $page;

    // list
    $rows = $myUser->getPage("*", $page, $page_size, $condition ." ORDER BY ". str_replace("-", " ", $order));

    $random = time();

    $userLabelMap = $myUserLabel->getMapping("no","*", "1=1");

    $userLabelRows = $myUserLabel->getRows("*", "1=1");

    for($i = 0; isset($userLabelRows[$i]); $i++)
    {
        $dataArray = $myUserLabel->getData($userLabelRows[$i]);
        
        $myTemplate->setReplace("user_label", $dataArray);
    }

    for($i = 0; isset($rows[$i]); $i++)
    {   
        $dataArray = $myUser->getData($rows[$i]);

        $dataArray['{user_label_title}'] = $userLabelMap[ $rows[$i]['user_label_no'] ]['title'];

        unset($_REQUEST['no']);
        $dataArray["{get}"] = isset($_REQUEST) ? http_build_query($_REQUEST) : "";

        $myTemplate->setReplace("list", $dataArray);
    }

    // page list
    $previous_page = $page - 1 < 1 ? 1 : $page - 1;
    $next_page = $page + 1 > $total_page ? $total_page : $page + 1;

    unset($_REQUEST["page"]);

    $dataArray = array( "{get}"           => isset($_REQUEST) ? http_build_query($_REQUEST) : "",
                        "{total_count}"   => $total_count,
                        "{total_page}"    => $total_page,
                        "{page}"          => $page,
                        "{previous_page}" => $previous_page,
                        "{next_page}"     => $next_page,
                        "{last_page}"     => $total_page );

    $myTemplate->setReplace("page_list", $dataArray);

    for($i = 4; $i > 0; $i--)
    {
        if ( $page - $i >= 1 )
        {
            $myTemplate->setReplace("previous", array("{previous}" => $page - $i), 2);
        }
    }

    for($i = 1; $i <= 4; $i++)
    {
        if ( $page + $i <= $total_page )
        {
            $myTemplate->setReplace("next", array("{next}" => $page + $i), 2);
        }
    }

    $myTemplate->process();
    $myTemplate->output();

?>