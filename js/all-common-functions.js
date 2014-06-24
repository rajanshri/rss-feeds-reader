var mainSlider;
// checks that an input string looks like a valid email address.
var isEmail_re       = /^\s*[\w\-\+_]+(\.[\w\-\+_]+)*\@[\w\-\+_]+\.[\w\-\+_]+(\.[\w\-\+_]+)*\s*$/;

function isEmail(s){
   return String(s).search (isEmail_re) != -1;
}

function getLogin(){
	$('#error_msg_container').html('').hide();
	$('#success_msg_container').html('').hide();			

	var message_txt = '';
	var curr_elem = '';
	
	var user_email = $.trim($('#user_email').val());
	var user_password = $.trim($('#user_password').val());
	
	if(user_email == ''){
		message_txt = 'Please enter your login email id';
		curr_elem = $('#user_email');
	}else if(user_email != '' && isEmail(user_email) == false){
		message_txt = 'Please enter your valid login email id';
		curr_elem = $('#user_email');
	}else if(user_password == ''){
		message_txt = 'Please enter your login password';
		curr_elem = $('#user_password');
	}else{
		$('#error_msg_container').animate({height: 'hide', width: 'hide', opacity: 'hide'}, 300);
		return true;
	}
	
	if(message_txt!=""){		
		$('#success_msg_container').animate({height: 'hide', width: 'hide', opacity: 'hide'}, 300);
		$('#error_msg_container').animate({height: 'show', width: 'show', opacity: 'show'}, 300);
		$('#error_msg_container').html(message_txt);
		setTimeout("$('#error_msg_container').animate({height: 'hide', width: 'hide', opacity: 'hide'}, 300);",50000);
		return false;
	}
	
}
		
function getFeedContent(){		
	$('#download_btn_content').hide();
	var webiste_url = $.trim($('#webiste_url').val());
	if(webiste_url != ''){
		$('#slider_feed_content').html('<img src="'+root_path+'images/ajax_loading.gif" alt="Loading..." style="left: 70%;  margin-left: -150px;  margin-top: -150px;  position: absolute; top: 50%; z-index: 9999;" />');
		$.ajax({
			url: "ajax-php/ajax-get-rss-feed-content.php",
			type: "POST",
			data: "webiste_url="+webiste_url,
			dataType: "json",
			async:false,
			success: function(resp){				
				 if(resp.ErrorCode == 0){
					$('#slider_feed_content').html('');
					$('#slider_feed_content').html(resp.Content);
					if($('#slider_feed_content').hasClass('open')){
						$('#slider_feed_content').removeClass('open');
						mainSlider.destroySlider();
					}
					mainSlider = $('.slider4').bxSlider({
						slideWidth: 300,
						minSlides: 2,
						maxSlides: 3,
						moveSlides: 1,
						slideMargin: 10,
						auto: true
					});	
					$('#slider_feed_content').addClass('open');	
					$('#webiste_url').val('');
					$('#user_feed_id').val(resp.UserFeedID);
					$('#download_btn_content').show();
					$('#all_added_feed_content').prepend(resp.AddedFeedContent);
				 }
			}
		});
	}
	return false;
}

function getAddedFeedContent(webiste_url){
	$('#download_btn_content').hide();
	if(webiste_url != ''){
		$('#slider_feed_content').html('<img src="'+root_path+'images/ajax_loading.gif" alt="Loading..." style="left: 70%;  margin-left: -150px;  margin-top: -150px;  position: absolute; top: 50%; z-index: 9999;" />');
		$.ajax({
			url: "ajax-php/ajax-get-rss-feed-content.php",
			type: "POST",
			data: "webiste_url="+webiste_url,
			dataType: "json",
			async:false,
			success: function(resp){				
				 if(resp.ErrorCode == 0){
					$('#slider_feed_content').html('');
					$('#slider_feed_content').html(resp.Content);
					if($('#slider_feed_content').hasClass('open')){
						$('#slider_feed_content').removeClass('open');
						mainSlider.destroySlider();
					}
					mainSlider = $('.slider4').bxSlider({
						slideWidth: 300,
						minSlides: 2,
						maxSlides: 3,
						moveSlides: 1,
						slideMargin: 10,
						auto: true
					});	
					$('#slider_feed_content').addClass('open');	
					$('#user_feed_id').val(resp.UserFeedID);
					$('#download_btn_content').show();
					$('#all_added_feed_content').prepend(resp.AddedFeedContent);
				 }
			}
		});
	}
}