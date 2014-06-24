<?php

class ConnDB {

    private $server, $username, $password, $con;

    function  __construct($iserver, $iusername, $ipassword) {

        $this->server = $iserver;
        $this->username = $iusername;
        $this->password = $ipassword;

        $this->con = mysql_pconnect($this->server, $this->username, $this->password);

     } 
	 
}

class SelDB {

    private $db;

    function  __construct($idb) {

        $this->db = $idb;

        mysql_select_db($this->db);

    }
}

$conn = new ConnDB("SERVER NAME", "USER NAME", "PASSWORD");
$database = new SelDB("DATABASE NAME");


?>
