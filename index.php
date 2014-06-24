<?php
session_start();

include 'common.inc.php';

if(isset($_SESSION['rssreader_login_user_id']) && $_SESSION['rssreader_login_user_id'] != ''){
	header('Location: ' . ROOT_PATH.'get-feed.php');
	exit();
}

$disp_error_message_div = 'display:none;';
$disp_success_message_div = 'display:none;';
$error_message = 0;

//============= Start Assign values in session in case of error ===============//
if (isset($_SESSION['error_message']) && trim($_SESSION['error_message']) != '') {
	$disp_success_message_div = 'display:none;';
    $disp_error_message_div = 'display:block;';
    $error_message = $_SESSION['error_message']; 
    unset($_SESSION['error_message']);
	
	if(isset($_SESSION['user_email'])){
		$user_email = $_SESSION['user_email'];
		unset($_SESSION['user_email']);
	}
}
//============= End Assign values in session in case of error ===============//

//=========== Start Show sucess message ============//
if (isset($_SESSION['success_message'])) {
    $disp_success_message_div = 'display:block;';
    $disp_error_message_div = 'display:none;';
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);	
}
//=========== End Show sucess message ============//

//=========== Start user login process ===========//
if(isset($_POST['btn_login'])){
	$signin_user_email = trim($_POST['user_email']);
	$signin_user_password = trim($_POST['user_password']);
	
	$empty_signin_email_msg = $func->validateEmpty($signin_user_email);
    $valid_signin_email_msg = $func->validateEmail($signin_user_email);
    $empty_signin_password_msg = $func->validateEmpty($signin_user_password);	
	
	if($empty_signin_email_msg == 0){
		$error_message = 1;
		$_SESSION['error_message'] = 'Please enter your login email id';
	}else if($signin_user_email != ''  && $valid_signin_email_msg == 0){
		$error_message = 1;
		$_SESSION['error_message'] = 'Please enter your valid login email id';
	}else if($empty_signin_password_msg == 0){
		$error_message = 1;
		$_SESSION['error_message'] = 'Please enter your login password';
	}else{
		$error_message = 0;
	}	
	
	//---- Start if there are errors ----//
    if ($error_message == 1) {	
		$_SESSION['user_email'] = $signin_user_email;
		
		header('Location: ' . ROOT_PATH);
		exit();
	}//------ End if there are errors --------//
	else{
        $encrypted_password = md5($signin_user_password);
		
        $column = '';

        $authenticity_data = $db->getSpecificRecords(USER_DETAILS_TABLE, $column, "WHERE `UserEmail` = '".$signin_user_email."' AND `UserPassword` = '".$encrypted_password."' AND `Status` = '1'");
		//print_r($authenticity_data); die;
        if ($authenticity_data != "no_result"){	
			
			// start filling up user login info table //
            $random_string = $func->Rand_String(10);
            $login_id = 'RSS' . $random_string;
            $login_ip = getenv('REMOTE_ADDR'); // get ip address
            $data = array();
            $data_expression = array();

            $data["UserLoginID"] = $login_id;
            $data["UserID"] = $authenticity_data[0]['UserID'];
            $data_expression["LoginTime"] = "NOW()";
            $data["LoginIPAddress"] = $login_ip;

            $db->insert(USER_LOG_DETAILS_TABLE, $data, $data_expression);
            // end filling up admin user info table //
			
			$_SESSION['rssreader_current_login_id'] = $login_id;
			$_SESSION['rssreader_login_user_id'] = $authenticity_data[0]['UserID'];
			$_SESSION['rssreader_login_username'] = $authenticity_data[0]['FirstName'].' '.$authenticity_data[0]['LastName'];
					
			header('Location: ' . ROOT_PATH.'get-feed.php');
			exit();
		}else{
			$_SESSION['error_message'] = 'Invalid E-Mail and/or Password. Please try again.';
			header('Location: ' . ROOT_PATH);
			exit();
		}
		//print_r($_SESSION); die;	
	}
}
//=========== End user login process ===========//

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo SITE_NAME; ?></title>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>style.css" />
        
        <script type="text/javascript">
		var root_path = '<?php echo ROOT_PATH; ?>';
		</script>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.8.1.min.js"></script>
        
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>jquery.bxslider.css" />
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery.bxslider.js"></script>
        
        <script type="text/javascript" src="<?php echo JS_PATH; ?>all-common-functions.js"></script>
        
	</head>
    
    <body>
        <div class="login-content">
            <div class="heading">RSS Feed Reader</div>
            <form name="frmLogin" method="post" onSubmit="return getLogin();">
            <div class="login-form-content">
            	<div id="error_msg_container" class="E-msg" style="<?php echo $disp_error_message_div; ?>">   
                	<?php if(isset($error_message) && $error_message != ''){ echo $error_message; } ?>              
                </div>
                <div id="success_msg_container" class="S-msg" style="<?php echo $disp_success_message_div; ?>">
                	<?php if(isset($success_message) && $success_message != ''){ echo $success_message; } ?>                
                </div>
                
            	<div class="login-form-row">
                	<input type="text" placeholder="Login Email" name="user_email" id="user_email" value="<?php if(isset($user_email)){ echo $user_email; } ?>" /> 
                </div>
                <div class="login-form-row">
                	<input type="password" placeholder="Login Password" name="user_password" id="user_password" value="" /> 
                </div>
                <div class="login-form-row">
                	<input type="submit" name="btn_login" id="btn_login" value="Log In" /> 
                </div>
            </div>
            </form>
            <br clear="all" />
        </div>
    </body>
</html>