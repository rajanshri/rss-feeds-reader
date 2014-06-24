<?php
session_start();

include 'common.inc.php';

if(!isset($_SESSION['rssreader_login_user_id'])){
	header('Location: ' . ROOT_PATH);
	exit();
}
//$location = 'https://www.rtcamp.com/';//'https://www.rtcamp.com/'; //'http://www.news.google.co.in/'; //'http://www.washingtonpost.com/'; //'http://www.nytimes.com/'; 

$column = '';
$user_feed_url_details = $db->getSpecificRecords(USER_FEED_DETAILS_TABLE, $column, "WHERE `UserID` = '".$_SESSION['rssreader_login_user_id']."' ORDER BY `AddDate` DESC");

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
    	<div class="heading">RSS Feed Reader</div>
        <div class="header">Hi! <?php if(isset($_SESSION['rssreader_login_username'])){ echo $_SESSION['rssreader_login_username']; } ?> | <a href="<?php echo ROOT_PATH.'logout.php'; ?>">Logout</a></div>
    	<div class="maincontent">
        	<!-- Left Content -->
        	<div class="left-content">
            	<div class="feed-form-content">
                    
                    <input type="text" name="webiste_url" id="webiste_url" placeholder="Add Site URL, eg: http://www.abcd.com/" />
                    
                    <input type="submit" name="btn_get_feed_url" value="Get Feed" onClick="return getFeedContent();" />
            	</div>
                <br clear="all" />
                
                <div class="added-feed-content">
                	<div class="sub-heading">Added Feed URLs</div>
                    <br clear="all" />
                    <div id="all_added_feed_content">
                    <?php
					if($user_feed_url_details != 'no_result'){
						foreach($user_feed_url_details as $user_feed){
					?>
                    <div style="width:100%; margin:2px;">
                    <a href="javascript: void(0);" onClick="getAddedFeedContent('<?php echo $user_feed['FeedURL']; ?>');" title="Click to get feeds"><?php echo $user_feed['FeedURL']; ?></a>
                    </div>
                    <?php
						}
					}
					?>
                    </div>
                </div>
            </div>           
            
            <!-- Right Content -->
            <div class="right-content">
                <div class="sub-heading">Feed Reader</div>
                <br clear="all" />
                <div class="slider4" id="slider_feed_content">
                </div>
                <br clear="all" />
                <div id="download_btn_content" class="download-btn-content">
                	<form method="post" action="<?php echo ROOT_PATH; ?>download.php" target="_blank">
                        <input type="hidden" name="user_feed_id" id="user_feed_id" value="" />
                        <input type="submit" name="download_rss_feed" value="Download RSS Feed" class="download_btn" />
                    </form>
                </div>
            </div>
        </div>
    	
    </body>
</html>