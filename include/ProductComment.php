<?php

	include_once("Table.php");

    ob_start();
    include_once(INCLUDE_DIR. "/Role.php");
    ob_clean();

	class ProductComment extends Table
	{
	    function ProductComment($myMySQL, $table = "product_comment")
	    {
	        $this->myMySQL = $myMySQL;
	        $this->table = DB_PRE.$table;
	    }

        function getCommentType()
        {
            return array('1' => '好评', '2' => '中评', '3'=>'差评');
        }

        function getIsAnonymity()
        {
            return array('0' => '未匿名', '1' => '匿名');
        }

        function getData($row)
        {
            $dataArray = array();
            $dataArray["{no}"]           = $row['no'];
            $dataArray["{user_no}"]      = $row['user_no'];
            $dataArray["{nickname}"]     = $row['nickname'];
            $dataArray["{product_no}"]   = $row['product_no'];
            $dataArray["{order_no}"]     = $row['order_no'];
            $dataArray["{content}"]      = $row['content'];
            $dataArray["{is_anonymity}"] = $row['is_anonymity'];
            $dataArray["{comment_type}"] = $row['comment_type'];
            $dataArray["{add_time}"]     = $row['add_time'];
            $dataArray["{update_time}"]  = $row['update_time'];

            return $dataArray;
        }

	}

?>