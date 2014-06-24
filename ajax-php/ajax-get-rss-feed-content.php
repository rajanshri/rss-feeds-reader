<?php

/* Start session and load library. */
session_start();
// include common files
include '../common.inc.php';
include '../library/JSON.php';

$data = array();
$html_content = '';
$ip=getenv('REMOTE_ADDR');
$today = time();


if(isset($_SESSION['rssreader_login_user_id']) && isset($_POST['webiste_url']) && trim($_POST['webiste_url']) != ''){
	$webiste_url = trim($_POST['webiste_url']);
	
	$web_html = file_get_contents($webiste_url);

	$rss_feed_url = $func->getRSSLocation($web_html, $webiste_url);
	
	if($rss_feed_url){
		$rawFeed = file_get_contents($rss_feed_url);
		$rssfeed = simplexml_load_string($rawFeed,'SimpleXMLElement', LIBXML_NOCDATA);//simplexml_load_file($rss_feed_url);
		$feed_array = array();
		foreach($rssfeed->channel->item as $story){
			$story_array = array (
								  'title' => (string)trim($story->title),
								  'desc' => (string)trim($story->description),
								  'link' => $story->link,
								  'date' => $story->pubDate
			);
	
			array_push($feed_array, $story_array);
		}
		//print_r($feed_array);
		if(isset($feed_array) && count($feed_array) > 0){
			$count = 0;
			foreach($feed_array as $feed){
				if($count < 10){
					$html_content .= '<div class="slide">';
					$html_content .= '<div style="background-color:#CCC; height:140px; padding:5px;">';
					$html_content .= '<div style="width:100%; margin:3px 0; height:50px;">';
					//$html_content .= '<div style="width:48px; margin:0 3px 0 0; float:left; display:inline;">';
					//$html_content .= '<img src="'.$user_profile_image.'" alt=""  style="border:1px solid #000;" />';
					//$html_content .= '</div>';
					$html_content .= '<div style="float:left; display:inline;">';
					$html_content .= '<a href="'.$feed['link'][0].'" target="_blank" title="'.$feed['title'].'">'.$feed['title'].'</a>';
					$html_content .= '</div>';
					$html_content .= '</div>';
					$html_content .= '<div style="width:100%; margin:3px 0;">';
					if(strlen($feed['desc']) >150){
						$feed_desc = substr(strip_tags($feed['desc']),0,147)."...";
					}else{
						$feed_desc = strip_tags($feed['desc']);
					}
					$html_content .= $feed_desc;
					$html_content .= '</div>';
					$html_content .= '</div>';
					$html_content .= '</div>';
					$count++;
				}
			}
			
			$new_feed_added_html = '';
			
			$column = '';
			$feed_url_data = $db->getSpecificRecords(USER_FEED_DETAILS_TABLE, $column, "WHERE `UserID` = '".$_SESSION['rssreader_login_user_id']."' AND `FeedURL` = '".$webiste_url."'");
			if($feed_url_data == 'no_result'){
				$table_data = array();
				$table_data_expression = array();
				
				$user_feed_id = $func->Rand_String(10);
				$table_data["UserFeedID"] = $user_feed_id;
				$table_data["UserID"] = $_SESSION['rssreader_login_user_id'];				
				$table_data["FeedURL"] = $webiste_url;
				$table_data_expression["AddDate"] = "NOW()";
	
				$db->insert(USER_FEED_DETAILS_TABLE, $table_data, $table_data_expression);
				
				$new_feed_added_html = '<div style="width:100%; margin:2px;"><a href="javascript: void(0);" onClick="getAddedFeedContent(\''.$webiste_url.'\');" title="Click to get feeds">'.$webiste_url.'</a></div>';
			}else{
				$user_feed_id = $feed_url_data[0]['UserFeedID'];
			}
			
			$data['ErrorCode'] = 0;
			$data['Content'] = $html_content;
			$data['AddedFeedContent'] = $new_feed_added_html;
			$data['UserFeedID'] = $user_feed_id;
		}else{
			$data['ErrorCode'] = 1;
			$data['ErrorMessage'] = 'Some error found in RSS feed';
		}
	}else{
		$data['ErrorCode'] = 1;
		$data['ErrorMessage'] = 'RSS page not found form given URL';
	}
}else{
	$data['ErrorCode'] = 1;
	$data['ErrorMessage'] = 'Please enter a website url to get rss feed content';	
}

die(json_encode($data));

?>