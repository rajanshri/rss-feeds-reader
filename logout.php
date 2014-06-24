<?php

    session_start();

    // include common files
    include 'common.inc.php';

    if(isset($_SESSION['rssreader_login_user_id'])){

        $login_id = $_SESSION['rssreader_current_login_id'];

        $column = array("LoginTime");
        $get_logintime = $db->getSpecificRecords(USER_LOG_DETAILS_TABLE, $column, "WHERE `UserLoginID` = '$login_id'");
		//die(print_r($get_logintime));
		if($get_logintime != 'no_result'){
			$login_time = $get_logintime[0]['LoginTime'];
			$data_expression["LogoutTime"] = "NOW()";
			$data_expression["LoginDuration"] = "TIMEDIFF(NOW(), '$login_time')";
			$db->update(USER_LOG_DETAILS_TABLE, "`UserLoginID` = '$login_id'", "", $data_expression);
		}
        unset ($_SESSION['rssreader_login_user_id']);
        unset ($_SESSION['rssreader_current_login_id']);
		
        session_destroy();

    }
	
	header('Location: '.ROOT_PATH);
	exit();
    
?>