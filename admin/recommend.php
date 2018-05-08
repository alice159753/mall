<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/Recommend.php");
    include_once(INCLUDE_DIR. "/Product.php");
    ob_clean();

    $order = !empty($_REQUEST["order"]) ? $_REQUEST["order"] : "no desc";
    $page = !empty($_REQUEST["page"]) ? $_REQUEST["page"] : 1;
    $title = !empty($_REQUEST["title"]) ? $_REQUEST["title"] : "";
    $add_time_min = !empty($_REQUEST["add_time_min"]) ? $_REQUEST["add_time_min"] : "";
    $add_time_max = !empty($_REQUEST["add_time_max"]) ? $_REQUEST["add_time_max"] : "";

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
   
    $myRecommend = new Recommend($myMySQL);
    $myProduct = new Product($myMySQL);

    $myTemplate = new Template(TEMPLATE_DIR ."/recommend.html");

    include_once("common.inc.php");

    // recommend
    $recommendArray = array( "{order}" => $order );

    $recommendArray['{title}'] = $title;
    $recommendArray['{add_time_min}'] = $add_time_min;
    $recommendArray['{add_time_max}'] = $add_time_max;

    $myTemplate->setReplace("recommend", $recommendArray);

    $condition = " 1=1 ";

    if ( !empty($title) )
    {
        $condition .= " AND title like  '%". $title ."%' ";
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
    $page_size = 50;

    $total_count = $myRecommend->getCount($condition);
    $total_page = $myRecommend->getPageCount($page_size, $condition);

    $total_page = ($total_page == 0) ? 1 : $total_page;
    $page = ($total_page < $page) ? $total_page : $page;

    // list
    $rows = $myRecommend->getPage("*", $page, $page_size, $condition ." ORDER BY ". str_replace("-", " ", $order));

    $random = time();

    for($i = 0; isset($rows[$i]); $i++)
    {   
        $dataArray = $myRecommend->getData($rows[$i]);

        $product_no = explode(",", $rows[$i]['product_no']);

        unset($_REQUEST['no']);
        $dataArray["{get}"] = isset($_REQUEST) ? http_build_query($_REQUEST) : "";

        $myTemplate->setReplace("list", $dataArray);

        foreach ($product_no as $key => $value) 
        {
            $title = $myProduct->getValue("title", "no = ". $value);

            $dataArray = array();
            $dataArray['{product_no}'] = $value;
            $dataArray['{title}'] = $title;

            $myTemplate->setReplace("product", $dataArray, 2);
        }
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