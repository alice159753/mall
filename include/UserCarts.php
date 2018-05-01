<?php

	include_once("Table.php");

	class UserCarts extends Table
	{
	    function UserCarts($myMySQL, $table = "user_carts")
	    {
	        $this->myMySQL = $myMySQL;
	        $this->table = DB_PRE.$table;
	    }

       
	}

?>