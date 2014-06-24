<?php
class functions {
	function validateEmpty($field_name) {
		if(trim($field_name)=='')
			return 0;
		else
			return 1;
	}


	function validateEmail($email){
		$extension = explode("@",$email);

		count($extension);

		if(count($extension)<2) {
			return 0;
		}

		$dmain_ext = $extension[1];
		$domain = explode('.',$dmain_ext);
		$dmain_arr = count($domain);

		if($dmain_arr<2) {
			return 0;
		}

		if($dmain_arr>6) {
			return 0;
		}



		if($dmain_arr==6 || $dmain_arr==5) {
			$n1 = is_validateNumeric($domain[0]);
			$n2 = is_validateNumeric($domain[1]);
			$n3 = is_validateNumeric($domain[2]);
			$n4 = is_validateNumeric($domain[3]);
			if(($n1&&$n2&& $n3&&$n4)!=1) {
				return 0;
			}
		}

		if($dmain_arr==6 ) {
			$ext1 = is_validateNumeric($domain[4]);
			$ext2 = is_validateNumeric($domain[5]);
			if($ext1 == $ext2 ) {
				return 0;
			}
		}

		if($dmain_arr==3) {
			if($domain[1] == $domain[2]) {
				return 0;
			}
		}

		if($dmain_arr==2){
			if(strlen($domain[1])>6 ) {
				return 0;
			}
		}

		if(!preg_match("/^[a-zA-Z0-9_\+-]+(\.[a-zA-Z0-9_\+-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.([a-z]{2,7})$/",$email)) {
			return 0;
		}else {
			return 1;
		}
	}
	
	function Rand_String($digits) {
		$alphanum = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

		// generate the random string
		$rand = substr(str_shuffle($alphanum), 0, $digits);
		$time = time();
		$val=$time.$rand;

		return $val;
	}
	
	function getRSSLocation($html, $location){
		if(!$html or !$location){
			return false;
		}else{
			#search through the HTML, save all <link> tags
			# and store each link's attributes in an associative array
			preg_match_all('/<link\s+(.*?)\s*\/?>/si', $html, $matches);
			$links = $matches[1];
			$final_links = array();
			$link_count = count($links);
			for($n=0; $n<$link_count; $n++){
				$attributes = preg_split('/\s+/s', $links[$n]);
				foreach($attributes as $attribute){
					$att = preg_split('/\s*=\s*/s', $attribute, 2);
					if(isset($att[1])){
						$att[1] = preg_replace('/([\'"]?)(.*)\1/', '$2', $att[1]);
						$final_link[strtolower($att[0])] = $att[1];
					}
				}
				$final_links[$n] = $final_link;
			}
			//print_r($final_links);
			#now figure out which one points to the RSS file
			for($n=0; $n<$link_count; $n++){
				if(strtolower($final_links[$n]['rel']) == 'alternate'){
					if(strtolower($final_links[$n]['type']) == 'application/rss+xml'){
						$href = $final_links[$n]['href'];
					}
					if(!$href and strtolower($final_links[$n]['type']) == 'text/xml'){
						#kludge to make the first version of this still work
						$href = $final_links[$n]['href'];
					}
					if($href){
						if(strstr($href, "http://") !== false){ #if it's absolute
							$full_url = $href;
						}if(strstr($href, "https://") !== false){ #if it's absolute
							$full_url = $href;
						}else{ #otherwise, 'absolutize' it
							$url_parts = parse_url($location); 
							#only made it work for http:// links. Any problem with this?
							$full_url = "http://$url_parts[host]";
							if(isset($url_parts['port'])){
								$full_url .= ":$url_parts[port]";
							}
							if($href{0} != '/'){ #it's a relative link on the domain
								$full_url .= dirname($url_parts['path']);
								if(substr($full_url, -1) != '/'){
									#if the last character isn't a '/', add it
									$full_url .= '/';
								}
							}
							$full_url .= $href;
						}
						return $full_url;
					}
				}
			}
			return false;
		}
	}
	
	function __destruct() { 
		
	}
			
}
?>