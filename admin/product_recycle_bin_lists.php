<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/Product.php");
    include_once(INCLUDE_DIR. "/Role.php");
    include_once(INCLUDE_DIR. "/Category.php");
    ob_clean();

    $order = !empty($_REQUEST["order"]) ? $_REQUEST["order"] : "no desc";
    $page = !empty($_REQUEST["page"]) ? $_REQUEST["page"] : 1;
    $product_id = !empty($_REQUEST["product_id"]) ? $_REQUEST["product_id"] : "";
    $add_time_min = !empty($_REQUEST["add_time_min"]) ? $_REQUEST["add_time_min"] : "";
    $add_time_max = !empty($_REQUEST["add_time_max"]) ? $_REQUEST["add_time_max"] : "";
    $is_online = isset($_REQUEST["is_online"]) ? $_REQUEST["is_online"] : "";
    $title = !empty($_REQUEST["title"]) ? $_REQUEST["title"] : "";
    $category_no_1 = !empty($_REQUEST["category_no_1"]) ? $_REQUEST["category_no_1"] : "";
    $category_no_2 = !empty($_REQUEST["category_no_2"]) ? $_REQUEST["category_no_2"] : "";


    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
   
    $myProduct = new Product($myMySQL);
    $myRole = new Role($myMySQL);
    $myCategory = new Category($myMySQL);

    $myTemplate = new Template(TEMPLATE_DIR ."/product_recycle_bin_lists.html");

    include_once("common.inc.php");

    // search
    $searchArray = array( "{order}" => $order );

    $searchArray['{product_id}']    = $product_id;
    $searchArray['{add_time_min}']  = $add_time_min;
    $searchArray['{add_time_max}']  = $add_time_max;
    $searchArray['{is_online}']     = $is_online;
    $searchArray['{title}']         = $title;
    $searchArray['{category_no_1}'] = $category_no_1;
    $searchArray['{category_no_2}'] = $category_no_2;

    $myTemplate->setReplace("search", $searchArray);


    $rows = $myCategory->getRows("*", "parent_no = 0");

    for($i = 0; isset($rows[$i]); $i++)
    {
        $dataArray = $myCategory->getData($rows[$i]);

        $myTemplate->setReplace("category_no", $dataArray);
    }

    $condition = " is_delete = 1 ";

    if ( !empty($title) )
    {
        $condition .= " AND title like '%$title%' ";
    }

    if ( !empty($category_no_1) )
    {
        $condition .= " AND category_no_1 =  '$category_no_1' ";
    }

    if ( !empty($category_no_2) )
    {
        $condition .= " AND category_no_2 =  $category_no_2 ";
    }

    if ( !empty($product_id) )
    {
        $condition .= " AND product_id =  '$product_id' ";
    }

    if ( is_numeric($is_online) )
    {
        $condition .= " AND is_online =  '$is_online' ";
    }

    if ( !empty($add_time_min) )
    {
        $condition .= " AND add_time >= '".$add_time_min."'";
    }

    if ( !empty($add_time_max) )
    {
        $condition .= " AND add_time <= '".$add_time_max."'";
    }


    // page
    $page_size = 100;

    $total_count = $myProduct->getCount($condition);
    $total_page = $myProduct->getPageCount($page_size, $condition);

    $total_page = ($total_page == 0) ? 1 : $total_page;
    $page = ($total_page < $page) ? $total_page : $page;

    // list
    $rows = $myProduct->getPage("*", $page, $page_size, $condition ." ORDER BY ". str_replace("-", " ", $order));

    $random = time();

    for($i = 0; isset($rows[$i]); $i++)
    {   
        $dataArray = $myProduct->getData($rows[$i]);

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