<?php
ob_start();
session_start();

// include common files
include 'common.inc.php';
include 'library/dompdf/dompdf_config.inc.php';

if(isset($_SESSION['rssreader_login_user_id']) && isset($_POST['user_feed_id']) && trim($_POST['user_feed_id']) != ''){
	$column = '';
	$user_feed_url_details = $db->getSpecificRecords(USER_FEED_DETAILS_TABLE, $column, "WHERE `UserFeedID` = '".trim($_POST['user_feed_id'])."' AND `UserID` = '".$_SESSION['rssreader_login_user_id']."' ORDER BY `AddDate` DESC");
	
	if($user_feed_url_details != 'no_result'){
		$webiste_url = trim($user_feed_url_details[0]['FeedURL']);
	
		$web_html = file_get_contents($webiste_url);
	
		$rss_feed_url = $func->getRSSLocation($web_html, $webiste_url);
		
		$file_name = "rss-feeds-of-".$_SESSION['rssreader_login_user_id'].".pdf";
				
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
				$html_content = '<!DOCTYPE html>';
				$html_content .= '<html lang="en">';
				$html_content .= '<head>';
				$html_content .= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
				$html_content .= '<title>RSS Feeds</title>';
				$html_content .= '<style>* { font-family: "DejaVu Sans","ariblk", "monospace","Times-Roman"; } @page { margin: 0em; } .tr-odd{background-color: #CCC}</style>';
				$html_content .= '</head>';
				$html_content .= '<body bgcolor="#ffffff">';
				$html_content .= '<table id="Table_01" width="100%" border="1" cellpadding="0" cellspacing="0"  bgcolor="#ffffff">';
				$html_content .= '<tr>';
				$html_content .= '<td colspan="3" style="text-align:center; padding:10px; font-weight:bold; font-size:16px;">RSS Feed Details<br/></td>';
				$html_content .= '</tr>';
				$html_content .= '<tr>';
				$html_content .= '<td style="padding:5px; text-align:left; font-weight:bold; width:35%;">Title</td><td style="padding:5px; text-align:left; font-weight:bold; width:45%;">Description</td><td style="padding:5px; text-align:left; font-weight:bold;">Publish Date</td>';
				$html_content .= '</tr>';
				$count = 0;
				foreach($feed_array as $feed){
					if($count < 10){	
						if(($count+1)%2 == 0){
							$tr_class="tr-odd";
						}else{
							$tr_class="";
						}			
						if(strlen($feed['desc']) >150){
							$feed_desc = substr(strip_tags($feed['desc']),0,147)."...";
						}else{
							$feed_desc = strip_tags($feed['desc']);
						}
						$html_content .= '<tr class="'.$tr_class.'">';
						$html_content .= '<td style="padding:5px; text-align:left;"><a href="'.$feed['link'][0].'" target="_blank" title="'.$feed['title'].'">'.$feed['title'].'</a></td><td style="padding:5px; text-align:left;">'.$feed_desc.'</td><td>'.$feed['date'].'</td>';
						$html_content .= '</tr>';
						$count++;
					}
				}
				$html_content .= '</table>';
				$html_content .= '</body>';
				$html_content .= '</html>';
				
				//echo $html_content; die;
				$dompdf = new DOMPDF();
				//$dompdf->set_base_path(realpath(ABSOLUTE_PATH . '/css/'));
				$dompdf->load_html($html_content);
				$dompdf->set_paper('a4','portrait');
				$dompdf->render();
				$dompdf->stream($file_name);	
				exit;		
			}
		}
	}
}

?>