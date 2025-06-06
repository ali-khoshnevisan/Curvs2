<?php 

/* Check the absolute path to the Social Auto Poster directory. */
if ( !defined( 'SAP_APP_PATH' ) ) {
    // If SAP_APP_PATH constant is not defined, perform some action, show an error, or exit the script
    // Or exit the script if required
    exit();
}

global $sap_common;
$SAP_Mingle_Update = new SAP_Mingle_Update();
$license_data = $SAP_Mingle_Update->get_license_data();
if( !$sap_common->sap_is_license_activated() ){
	$redirection_url = '/mingle-update/';
	header('Location: ' . SAP_SITE_URL . $redirection_url );
	die();
}

include SAP_APP_PATH . 'header.php';

include SAP_APP_PATH . 'sidebar.php';


// Get user's active networks
$networks = sap_get_users_networks();

//Get Facebook options
$sap_facebook_options = array();
if ( in_array('facebook', $networks) ) {
	$sap_facebook_options = $this->settings->get_user_setting('sap_facebook_options');
	$sap_facebook_options = !empty($sap_facebook_options) ? $sap_facebook_options : array();
}

//Get Linkdin options
$sap_linkedin_options = array();
if ( in_array('linkedin', $networks) ) {
	$sap_linkedin_options = $this->settings->get_user_setting('sap_linkedin_options');
	$sap_linkedin_options = !empty($sap_linkedin_options) ? $sap_linkedin_options : array();
}

//Get Twitter options
$sap_twitter_options = array();
if ( in_array('twitter', $networks) ) {
	$sap_twitter_options = $this->settings->get_user_setting('sap_twitter_options');
	$sap_twitter_options = !empty($sap_twitter_options) ? $sap_twitter_options : array();
}

//Get Telegram options
$sap_telegram_options = array();
if ( in_array('telegram', $networks) ) {
    $sap_telegram_options = $this->settings->get_user_setting('sap_telegram_options');
    $sap_telegram_options = !empty($sap_telegram_options) ? $sap_telegram_options : array();
}


//Get Tumblr options
$sap_tumblr_options = array();
if ( in_array('tumblr', $networks) ) {
	$sap_tumblr_options = $this->settings->get_user_setting('sap_tumblr_options');
	$sap_tumblr_options = !empty($sap_tumblr_options) ? $sap_tumblr_options : array();
}

//Get Pinterest options
$sap_pinterest_options = array();
if ( in_array('pinterest', $networks) ) {
	$sap_pinterest_options = $this->settings->get_user_setting('sap_pinterest_options');
	$sap_pinterest_options = !empty($sap_pinterest_options) ? $sap_pinterest_options : array();
}

//Get GMB options
$sap_gmb_options = array();
if ( in_array('gmb', $networks) ) {
	$sap_gmb_options = $this->settings->get_user_setting('sap_google_business_options');
	$sap_gmb_options = !empty($sap_gmb_options) ? $sap_gmb_options : array();
}

//Get GMB options
$sap_instagram_options = array();
if ( in_array('instagram', $networks) ) {
	$sap_instagram_options = $this->settings->get_user_setting('sap_instagram_options');
	$sap_instagram_options = !empty($sap_instagram_options) ? $sap_instagram_options : array();
}

// Reddit
$sap_reddit_options = array();
if ( in_array('reddit', $networks) ) {
    $sap_reddit_options = $this->settings->get_user_setting('sap_reddit_options');
    $sap_reddit_options =!empty($sap_reddit_options)? $sap_reddit_options: array();
}

// Blogger
$sap_blogger_options = array();
if ( in_array('blogger', $networks) ) {
    $sap_blogger_options = $this->settings->get_user_setting('sap_blogger_options');
    $sap_blogger_options =!empty($sap_blogger_options)? $sap_blogger_options: array();
}
// Blogger
$sap_wordpress_options = array();
if ( in_array('wordpress', $networks) ) {
    $sap_wordpress_options = $this->settings->get_user_setting('sap_wordpress_options');
    $sap_wordpress_options =!empty($sap_wordpress_options)? $sap_wordpress_options: array();
}




if ( !class_exists('SAP_Linkedin') ) {
	include ( CLASS_PATH . 'Social' . DS . 'liConfig.php' );
}
$linkedin = new SAP_Linkedin();

if (!class_exists('SAP_Facebook')) {
	include ( CLASS_PATH . 'Social' . DS . 'fbConfig.php' );
}
$facebook = new SAP_Facebook();

if (!class_exists('SAP_Pinterest')) {
	include ( CLASS_PATH . 'Social' . DS . 'pinConfig.php' );
}
$pinterest = new SAP_Pinterest();

if (!class_exists('SAP_Gmb')) {
	include ( CLASS_PATH . 'Social' . DS . 'gmbConfig.php' );
}
$google_buisness = new SAP_Gmb();

if (!class_exists('SAP_Instagram')) {
	include ( CLASS_PATH . 'Social' . DS . 'instaConfig.php' );
}
$instagram = new SAP_Instagram();

if (!class_exists('SAP_Reddit')) {
    include ( CLASS_PATH . 'Social' . DS . 'redditConfig.php' );
}
$reddit = new SAP_Reddit();

if (!class_exists('SAP_Youtube')) {
    include ( CLASS_PATH . 'Social' . DS . 'youtubeConfig.php' );
}
$youtube = new SAP_Youtube();

if (!class_exists('SAP_Telegram')) {
    include(CLASS_PATH . 'Social' . DS . 'telegramConfig.php');
}
$telegram = new SAP_Telegram();

if (!class_exists('SAP_Blogger')) {
    include ( CLASS_PATH . 'Social' . DS . 'bloggerConfig.php' );
}
$blogger = new SAP_Blogger();

if (!class_exists('SAP_Tumblr')) {
	include ( CLASS_PATH . 'Social' . DS . 'tumblrConfig.php' );
}
$tumblr = new SAP_Tumblr();
if (!class_exists('SAP_Tumblr')) {
	include ( CLASS_PATH . 'Social' . DS . 'tumblrConfig.php' );
}
$tumblr = new SAP_Tumblr();

if (!class_exists('SAP_Wordpress_Config')) {
	include ( CLASS_PATH . 'Social' . DS . 'wordpressConfig.php' );
}

$wordpress = new SAP_Wordpress_Config();

$to_get_social_posting_error = array();
$status_meta = array();
$link_to_post = array();
$all_status = array();
$sap_schedule_time = '';

//Get Post data
if (!empty($match['params']['id'])) {
	$post_id = $match['params']['id'];
	$post_data = $this->get_post($post_id, true);
			
	$sap_networks = $this->get_post_meta($post_id, 'sap_networks');
		
	if (isset($post_data->status) && $post_data->status == 2) {
		$sap_schedule_time = $this->get_post_meta($post_id, 'sap_schedule_time');
	}

	if(empty($sap_schedule_time)){
		$sap_schedule_time = $this->get_post_meta($post_id, 'sap_schedule_time');
		
	}

	$post_meta = array();
	if(!empty($sap_networks)){
		foreach ($sap_networks as $key => $sap_network) {
			if($key == 'fb_accounts'){
				$post_meta['facebook_accounts'] = $sap_network;
			}else{
				$post_meta[$key] = $sap_network;
			}
		}
	}
	
	
	if (!empty($post_meta)) {
		
		foreach ($post_meta as $post_meta_key => $post_meta_value) {
			if (strpos($post_meta_key, "_accounts")) {
				
				$to_get_social_posting_error[] = str_replace("_accounts", "", $post_meta_key);
				$status_key = str_replace("_accounts", "", $post_meta_key);
			
				$get_post_status = '';
				if ($status_key === 'facebook') {
					$get_post_status = $this->get_post_meta($post_id, 'fb_status');
					
						
				}elseif ( $status_key === 'instagram' ) {
	

					$get_post_status = $this->get_post_meta($post_id, '_sap_' . $status_key . '_status');
					
				

					if(empty($get_post_status)){
						$get_post_status = $this->get_post_meta($post_id, $status_key . '_status');
					}
				}
				elseif($status_key == 'reddit'){
					$get_post_status = $this->get_post_meta($post_id, '_sap_' . $status_key . '_status');
				}
				elseif($status_key == 'blogger'){
					$get_post_status = $this->get_post_meta($post_id, '_sap_' . $status_key . '_status');
							
				}
				 else {
					
					$get_post_status = $this->get_post_meta($post_id, $status_key . '_status');
					if (empty($get_post_status)) {
						$get_post_status = $this->get_post_meta($post_id, '_sap_' . $status_key . '_status');
						
					}
				}
				
				$all_status[$status_key] = $get_post_status;
				$link_to_post[] = $this->get_post_meta($post_id, 'sap_'.$status_key.'_link_to_post');
			} elseif (strpos($post_meta_key, "_locations")) {

				$to_get_social_posting_error[] = str_replace("_locations", "", $post_meta_key);
				$status_key = str_replace("_locations", "", $post_meta_key);
				$get_post_status = $this->get_post_meta($post_id, $status_key . '_status');
				if (empty($get_post_status)) {
					$get_post_status = $this->get_post_meta($post_id, '_sap_' . $status_key . '_status');
				}
				$all_status[$status_key] = $get_post_status;
				$link_to_post[] = $this->get_post_meta($post_id, 'sap_'.$status_key.'_link_to_post');
			} elseif ( in_array( $post_meta_key, $networks ) ) {

				$to_get_social_posting_error[] = $post_meta_key;

				if ( $post_meta_key === 'facebook' ) {
					$get_post_status = $this->get_post_meta( $post_id, 'fb_status' );
				}elseif ( $post_meta_key === 'instagram' ) {
					$get_post_status = $this->get_post_meta( $post_id, '_sap_' . $post_meta_key . '_status' );
					if( empty( $get_post_status ) ){
						$get_post_status = $this->get_post_meta( $post_id, $post_meta_key . '_status' );
					}
				}else{
					$get_post_status = $this->get_post_meta( $post_id, '_sap_' . $post_meta_key . '_status' );
				}

				$all_status[$post_meta_key] = $get_post_status;
			
			}
		}
		
	}
	
	
	if (!empty($to_get_social_posting_error)) {

		foreach ($to_get_social_posting_error as $to_get_social_posting_error_key => $to_get_social_posting_error_value) {
				if($to_get_social_posting_error_value == 'facebook'){
					$acc = 'fb';
				}else{
					$acc = $to_get_social_posting_error_value;
				}
				
			$status_meta[$to_get_social_posting_error_value] = $this->get_post_meta($post_id, 'sap_' . $acc . '_posting_error');
		}
	}
}
	


if (isset($post_data) && !empty($post_data)) {
	$preview_date    = ( isset($post_data->created_date) && !empty($post_data->created_date) ) ? $post_data->created_date : "";
    $preview_image = (isset($post_data->image) && !empty($post_data->image)) ? $post_data->image : "";
    if(!empty($preview_image)) {
        $preview_image = SAP_IMG_URL . str_replace(SAP_IMG_URL, "", $preview_image);
    }
    $post_data->image = $preview_image;
	$preview_link 	 = ( isset($post_data->share_link) && !empty($post_data->share_link) ) ? $post_data->share_link : "";
	$preview_message = ( isset($post_data->message) && !empty($post_data->message) ) ? $post_data->message : "";
	$preview_video   = $post_data->video;
	 

	if(!empty($preview_video)){
	
		$preview_video_url = SAP_SITE_URL.'/uploads/'.$preview_video;
	
	}
	$file_data = pathinfo($preview_video_url);
	$extension = $file_data['extension'];

	$image_style = $video_style = $media_style = '';
	if(!empty($preview_image)) {
		//$video_style = "style ='display:none;'";
	}
	if(!empty($preview_video)) {
		//$image_style = "style ='display:none;'";
	}
	
	
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<section class="content-header content-header-quick-post">
		<h1>
            <span class="margin-r-5"><i class="fa fa-pencil-square-o"></i></span>
			<?php echo $sap_common->lang('quick_post_edit'); ?>
		</h1>
		
	</section>

	<section class="content sap-quick-post">
		<div class="row">
			<?php echo $this->flash->renderFlash(); ?>
			<?php if (isset($match['params']['id'])) { ?>
				<form action="<?php echo $router->generate('quick_updatepost'); ?>" id="quick-update-form" class="quick-post" method="post" enctype="multipart/form-data" accept-charset="utf-8">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left" style="background-color: #fff !important;">
						<input type="hidden" value="<?php echo (!empty($post_id) ? $post_id : 0); ?>" name="id">
						<!-- <div class="col-lg-12">
							<div class="row">
								<div class="col-lg-12 sap-msg-wrap">
									<label class="message-label control-label"><?php echo $sap_common->lang('message'); ?><span class="astric">*</span></label>
									<div class="form-group">
										<textarea name="message" class="quick-post-message form-control" rows="5" placeholder="Write something here..."><?php echo!empty($post_data->message) ? strip_tags($post_data->message) : ''; ?></textarea>
									</div>
								</div>
							</div>
						</div> -->
					<?php
						$chat_gpt_api_key = $this->settings->get_options('sap_chatgpt_api_key');
						$custom_message_tab_active = $ai_message_tab_active = $custom_message_content_active = $ai_message_content_active = "";
						$sap_caption_words = $this->get_post_meta($post_id, 'sap_caption_words');
						if (isset($sap_caption_words) && !empty($sap_caption_words) && !empty($chat_gpt_api_key) ) {
							$ai_message_li_active = "sap-msg-tab-li-active";
							$ai_message_tab_active = "sap-msg-tab-nav-active";
							$ai_message_content_active = "sap-msg-tab-content-active";
						} else {
							$custom_message_li_active = "sap-msg-tab-li-active";
							$custom_message_tab_active = "sap-msg-tab-nav-active";
							$custom_message_content_active = "sap-msg-tab-content-active";
						}
					?>
					<div class="sap-tab-nav-wrap">
						<ul class="nav nav-tabs">
							<li class="msg-li <?php echo $custom_message_li_active; ?>">
								<a href="#" class="sap-message-tab-nav <?php echo $custom_message_tab_active; ?>" id="sap-custom-message"><?php echo $sap_common->lang('custom_message'); ?></a>
							</li>
							<?php if( !empty( $chat_gpt_api_key) ){ ?>
								<li class="msg-li <?php echo $ai_message_li_active; ?>">
									<a href="#" class="sap-message-tab-nav <?php echo $ai_message_tab_active; ?>" id="sap-ai-message"><?php echo $sap_common->lang('ai_message'); ?></a>
								</li>
							<?php } ?>
						</ul>
					</div>
						<input type="hidden" name="sap-active-tab" class="sap-active-tab">
						<div class="col-lg-12 sap-custom-tab sap-tab-content sap-message-tab-content <?php echo $custom_message_content_active ?>" id="sap-custom-message">
							<div class="row">
								<div class="col-lg-12 sap-msg-wrap">
									<label class="message-label control-label" for="custom-message"><?php echo $sap_common->lang('message'); ?><span class="astric">*</span></label>
									<div class="form-group">
										<textarea name="custom-message" id="custom-message" class="quick-post-message form-control" rows="5" placeholder="Write something here..."><?php echo!empty($post_data->message) ? strip_tags($post_data->message) : ''; ?></textarea>
										<div class="custom-char-count"><span id="char-count">0</span> <?php echo $sap_common->lang('char_count'); ?></div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-12 sap-tab-content sap-message-tab-content <?php echo $ai_message_content_active ?>" id="sap-ai-message">
							<img src="<?php echo SAP_SITE_URL.'/assets/images/ajax-loader.gif'; ?>" id="sap-caption-loader" class="sap-caption-loader-img">
							<div class="row sap-ai-div">
								<div class="col-lg-12 form-group sap-share-link-parent" >
									<label class="control-label" id="sap-share-link-parent-link" for="ai_share_link"><?php echo $sap_common->lang('link'); ?><span class="astric">*</span></label>
									<span id="sap_caption_link_error_msg" class="sap_caption_link_error_msg"></span>
									<input class="form-control sap-ai-link" tabindex="4" placeholder="Content share link" name="ai_share_link" id="ai_share_link" value="<?php echo!empty($post_data->share_link) ? $post_data->share_link : ''; ?>">
								</div>
								<div class="col-lg-12 sap-msg-wrap">
									<label class="message-label control-label" for="quick-post-ai-message"><?php echo $sap_common->lang('message'); ?><span class="astric">*</span></label>
									<span id="sap_caption_error_msg" class="sap_caption_error_msg"></span>
									<div class="form-group">
										<textarea name="ai-message" id="quick-post-ai-message" class="quick-post-message quick-post-ai-message form-control" rows="5" placeholder="AI message here..."><?php echo!empty($post_data->message) ? strip_tags($post_data->message) : ''; ?></textarea>
									</div>
									<div class="form-group caption-words  align-items-end">
										<div class="sap-caption-words-wrap col-md-6 pl-0">
										<label for="sap_caption_words"><strong><?php echo $sap_common->lang('caption_words');  ?></strong></label>	
										<input type="number" name="sap_caption_words" id="sap_caption_words" value="<?php echo !empty($sap_caption_words) ? $sap_caption_words : 30 ;  ?>" class="sap-caption-words form-control" > 
											
										</div>
										<div class="col-md-6">
											<input type="button" class="sap-ai-caption-btn btn btn-success" value="Generate caption">
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="row">
								<h4 class="box-title">
									<div class="col-sm-6">
										<h5 for="enable-image-video" class=" control-label padding-top-0"><?php echo $sap_common->lang('video'); ?></h5>
									</div>
									<div class="col-sm-6 box-radio-wrap">	
										<div class="image-video-select">
											<input id="enable_image" type="radio" name="enable_video_image" <?php echo empty($post_data->image) ? '' : 'checked="checked"'; ?> value="enableimage">
				                            <label class="enable_image" for="enable_image"><?php echo $sap_common->lang('image'); ?></label>
										</div>
										<div class="image-video-select" style="display: none">
											<input id="enable_video" type="radio" name="enable_video_image" value="enablevideo" <?php echo empty($post_data->video) ? '' : 'checked="checked"'; ?>>
			                            	<label class="enable_image" for="enable_video"><?php echo $sap_common->lang('video_label'); ?></label>
										</div>
                                        <div class="image-video-select" style="display: none">
                                            <input id="enable_media" type="radio" name="enable_video_image" value="enablemedia" <?php echo isEmptyJson($post_data->media) ? '' : 'checked="checked"'; ?>>
                                            <label class="enable_image" for="enable_media"><?php echo $sap_common->lang('media_label'); ?></label>
                                        </div>
                                    </div>
									<!--<div class="tg-list-item col-sm-6 show-hide-video">
										<input data-content="#quick-video" class="tgl tgl-ios" name="networks[video]" <?php echo!empty($post_meta['twitter']) ? 'checked="checked"' : ''; ?> id="enable_video" type="checkbox" value="1">
										<label class="tgl-btn float-right-cs-init" for="enable_video"></label>
									</div>-->
								</h4>
								<div class="col-lg-12 quick-image-wrap" <?php echo $image_style; ?>>
									<label class="control-label"><?php echo $sap_common->lang('image'); ?></label>
									<div class="form-group">
										<?php if (!empty($post_data->image)) { ?>
											<input id="quick-post-image" tabindex="3" value="" name="image" type="file" class="file file-loading" data-show-upload="false" data-show-caption="true" data-allowed-file-extensions='["png", "jpg","jpeg", "gif"]' data-max-file-size="<?php echo MINGLE_MAX_FILE_UPLOAD_SIZE; ?>" data-initial-preview="<img src='<?php echo $post_data->image; ?>' class='uploaded-img'/>">
										<?php } else { ?>
											<input id="quick-post-image" tabindex="3" value="" name="image" type="file" class="file file-loading" data-show-upload="false" data-show-caption="true" data-max-file-size="<?php echo MINGLE_MAX_FILE_UPLOAD_SIZE; ?>" data-allowed-file-extensions='["png", "jpg","jpeg", "gif"]'/>
										<?php } ?>
										<input type="hidden" id="featured-img" name="image" value="<?php echo (!empty($post_data->image) ? $post_data->image : 0); ?>" data-max-file-size="1M">
									</div>
									<?php if (!empty($sap_facebook_options['fb_app_version']) && $sap_facebook_options['fb_app_version'] >= 2.9) { ?>
										<div class="alert alert-warning sap-warning"><i class="fa fa-info-circle" aria-hidden="true"></i> <?php echo $sap_common->lang('quick_post_image_help_text'); ?></div>
									<?php } ?>
								</div>
								<div  class="col-lg-12 quick-video-wrap" <?php echo $video_style; ?>>
									<label class="control-label"><?php echo $sap_common->lang('video_label'); ?></label>
									<input id="quick-post-video" tabindex="3" value="" name="video" type="file" class="file file-loading" data-show-upload="false" data-show-caption="true" data-max-file-size="<?php echo MINGLE_MAX_FILE_UPLOAD_SIZE; ?>" data-allowed-file-extensions='["mp4"]'/>
                                    <?php if(!empty($post_data->video)) { ?>
                                        <video width="400" controls>
                                            <source src="<?php echo SAP_IMG_URL . $post_data->video ?>" type="video/mp4">
                                        </video>
                                    <?php } ?>
								</div>
								<div class="video-label-notification" <?php echo $video_style; ?>>
									<div class="alert alert-info note-text ">Note: Video Posting is only supported with Quick Share to these 3 Social Media : Twitter, Facebook, Tumblr.</div>
									<h6><b>Please check allowed video formats and standards <a target="_blank" href="https://docs.wpwebelite.com/mingle-saas/social-network-configuration/#Quickshare-video">here.</a></b></h6>
								</div>
                                <div  class="col-lg-12 quick-media-wrap" <?php echo $media_style; ?>>
                                    <label class="control-label"><?php echo $sap_common->lang('media_label'); ?></label>
                                    <input id="quick-post-media" tabindex="3" value="" multiple name="media[]" type="file" class="file file-loading" data-show-upload="false" data-show-caption="true" data-max-file-size="<?php echo MINGLE_MAX_FILE_UPLOAD_SIZE; ?>" data-allowed-file-extensions='["png", "jpg","jpeg", "gif","mp4"]'/>
                                    <div class="sap-mt-3" style="display: flex">
                                        <?php if(!isEmptyJson($post_data->media)) { ?>
                                            <?php foreach (json_decode($post_data->media,true) as $media) { ?>
                                                <?php if(mediaIsImage($media['src'])) { ?>
                                                    <div style="margin-right: 15px">
                                                        <a href="<?php echo SAP_IMG_URL . $media['src']; ?>" target="_blank">
                                                            <img src='<?php echo SAP_IMG_URL . $media['src']; ?>' width="100%" height="100%" style="max-width: 250px"/>
                                                        </a>
                                                    </div>
                                                <?php } else if(mediaIsVideo($media['src'])) { ?>
                                                    <div><a href='<?php echo SAP_IMG_URL . $media['src'] ?>' target='_blank'><i class='fa fa-file-video-o' aria-hidden='true'></i></a><div>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>
							</div>
						</div>
						<div class="col-lg-12 sap-custom-link">
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group sap-share-link-parent" >
										<label class="control-label" id="sap-share-link-parent-link" for="custom_share_link"><?php echo $sap_common->lang('link'); ?></label>
										<input class="form-control sap-quick-valid-url" tabindex="4" placeholder="Content share link" name="custom_share_link" id="custom_share_link" value="<?php echo!empty($post_data->share_link) ? $post_data->share_link : ''; ?>">
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-12 123">
							<div class="row">
								<div class="col-lg-12">

									<label class="control-label dark-blue-text"><?php echo $sap_common->lang('networks'); ?></label>
									<div class="network-error"></div>
									<div class="form-group">
										
										<div class="box-group custom-accordion" id="accordion">
											<?php
											$sap_facebook_grant_data = $this->settings->get_user_setting('sap_fb_sess_data');
                                            $sap_twitter_accounts_details = $this->settings->get_user_setting('sap_twitter_accounts_details');
                                            $sap_telegram_accounts_details = $this->settings->get_user_setting('sap_telegram_accounts_details');


											//$sap_tumblr_account_details = $this->settings->get_user_setting('sap_tumblr_sess_data');
											$sap_tumblr_account_details = $tumblr->sap_fetch_tumblr_accounts();

											$sap_linkedin_sess_data = $this->settings->get_user_setting('sap_li_sess_data');

											$selected_accounts_tumblr = !empty($sap_tumblr_options['tumblr_type_post_accounts']) ? $sap_tumblr_options['tumblr_type_post_accounts'] : array();
											$gmb_locations = $google_buisness->sap_add_gmb_locations();
											$sap_auto_poster_gmb_sess_data = $this->settings->get_user_setting('sap_google_business_sess_data');
										
											$sap_pinterest_grant_data = $this->settings->get_user_setting('sap_pin_sess_data');

											$sap_instagram_grant_data = $this->settings->get_user_setting('sap_fb_sess_data_for_insta');

											$sap_reddit_grant_data = $this->settings->get_user_setting('sap_reddit_sess_data');
											
											$sap_blogger_grant_data = $this->settings->get_user_setting('sap_blogger_sess_data');

											$sap_wordpress_grant_data = $wordpress->sap_get_wordpress_urls();


											if (!empty($sap_facebook_options['enable_facebook'])) {
												?>
												<div class="panel box fb-wrap">
													<h4 class="box-title">
														<a href="javascript:void(0)"><?php echo $sap_common->lang('network_label_fb'); ?></a>
														<div class="tg-list-item col-sm-6">
															<input data-content="#quick_post_facebook" class="tgl tgl-ios" <?php echo!empty($post_meta['facebook']) ? 'checked="checked"' : ''; ?> name="networks[facebook]" id="enable_facebook" type="checkbox" value="1">
															<label class="tgl-btn float-right-cs-init" for="enable_facebook"></label>
														</div>
													</h4>
													<?php
													$fb_type_post_user = (!empty($post_meta['facebook_accounts'])) ? $post_meta['facebook_accounts'] : array();
													$style = !empty($post_meta['facebook']) ? 'display:block;' : 'display:none;';
													?>
													<div id="quick_post_facebook" class="panel-collapse collapse" style="<?php echo $style; ?>">

														<?php if (empty($sap_facebook_grant_data)) { ?>
															<div class="alert alert-danger sap-warning">
																<i class="fa fa-info-circle" aria-hidden="true"></i>
																<?php echo $sap_common->lang('quick_post_facebook_help_text'); ?>.
															</div>
														<?php } else { ?>
															<label for="sap_fb_user_id" class="control-label"><?php echo $sap_common->lang('select_accounts'); ?></label>
															<select class="form-control sap_select" tabindex="6" name="networks[fb_accounts][]" multiple="multiple" id="sap_fb_user_id" data-placeholder="Select User">
																<?php
																$fb_accounts = $facebook->sap_get_fb_accounts('all_app_users_with_name');
																if (!empty($fb_accounts) && is_array($fb_accounts)) {

																	$fb_type_post_user = (!empty($post_meta['facebook_accounts'])) ? $post_meta['facebook_accounts'] : array();
																	foreach ($fb_accounts as $aid => $aval) {

																		if (is_array($aval)) {
																			$fb_app_data = isset($sap_fb_sess_data[$aid]) ? $sap_fb_sess_data[$aid] : array();
																			$fb_user_data = isset($fb_app_data['sap_fb_user_cache']) ? $fb_app_data['sap_fb_user_cache'] : array();
																			$fb_opt_label = !empty($fb_user_data['name']) ? $fb_user_data['name'] . ' - ' : '';
																			$fb_opt_label = $fb_opt_label . $aid;
																			foreach ($aval as $aval_key => $aval_data) {
																				?>
																				<option <?php echo in_array($aval_key, $fb_type_post_user) ? 'selected="selected"' : ''; ?> value="<?php echo $aval_key; ?>" ><?php echo $aval_data; ?></option>
																			<?php } ?>
																		<?php } else {
																			?>
																			<option <?php echo in_array($aid, $fb_type_post_user) ? 'selected="selected"' : ''; ?> value="<?php echo $aid; ?>" ><?php echo $aval; ?></option>
																			<?php
																		}
																	} // End of foreach
																} // End of main if
																?>
															</select>

															<!-- Added Posting type -->
															<div class="share-type-wrap  fb-selector">
																<label for="sap_fb_user_id" class="control-label"><?php echo $sap_common->lang('share_posting_type'); ?></label>
																<?php
																$selected_share_posting_type = '';
																$share_posting_type = array(
																	"link_posting" => 'Link posting',
																	"image_posting" => "Image/Video posting",
																	"reel_posting" => "Reel posting",
																);
																?>
																<select class="form-control sap_select" id="sap_fb_user_id"  name="sap_share_posting_type_fb">          
																	<?php
																		foreach ($share_posting_type as $type => $share_posting_type) {
																			?>
																			<option value="<?php echo $type ?>" <?php
																			if ($type == $selected_share_posting_type) {
																				echo 'selected=selected';
																			} else {
																				echo '';
																			}
																			?>><?php echo $share_posting_type ?></option> 
																			<?php
																		}
																	?>    

																</select>
															</div>

															<?php $sap_schedule_time_fb = $this->get_post_meta($post_id, 'sap_schedule_time_fb'); ?>
															<div class="sap-individual-time">
																<label for="sap-schedule-time-fb" class="control-label"><?php echo $sap_common->lang('schedule_individual'); ?><i class="fa fa-question-circle sap-st-tooltip" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="This setting modifies the schedule global setting and overrides scheduled time. Keep it blank to use the global schedule settings."></i></label>
																<input type="text" name="sap-schedule-time-fb" id="sap-schedule-time-fb" <?php echo !empty($sap_schedule_time_fb) ? 'value="' . date('Y-m-d H:i', $sap_schedule_time_fb) . '"' : ''; ?> readonly="" class="form-control sap-datetime ">
															</div>
														<?php } ?>
													</div>
												</div>
												<?php
											}
											if (!empty($sap_twitter_options['enable_twitter'])) {
												?>
												<div class="panel box tw-wrap">
													<h4 class="box-title">
														<a href="javascript:void(0)"><?php echo $sap_common->lang('network_label_twitter'); ?></a>
														<div class="tg-list-item col-sm-6">
															<input data-content="#quick_post_twitter" class="tgl tgl-ios" name="networks[twitter]" <?php echo!empty($post_meta['twitter']) ? 'checked="checked"' : ''; ?> id="enable_twitter" type="checkbox" value="1">
															<label class="tgl-btn float-right-cs-init" for="enable_twitter"></label>
														</div>
													</h4>
													<?php
													$style = !empty($post_meta['twitter']) ? 'display:block;' : 'display:none;';
													?>
													<div id="quick_post_twitter" class="panel-collapse collapse" style="<?php echo $style; ?>">

														<?php 														
														if (empty($sap_twitter_accounts_details)) { ?>
															<div class="alert alert-danger sap-warning">
																<i class="fa fa-info-circle" aria-hidden="true"></i>
																<?php echo $sap_common->lang('quick_post_twi_cnofig_msg'); ?>
															</div>
														<?php } else { ?>
															<label for="sap_twitter_user_id" class="control-label"><?php echo $sap_common->lang('select_accounts'); ?></label>
															<select class="form-control sap_select" tabindex="14" name="networks[tw_accounts][]" multiple="multiple" id="sap_twitter_user_id" data-placeholder="Select User">
																<?php
																if (!empty($sap_twitter_accounts_details)) {
																	foreach ($sap_twitter_accounts_details as $key => $profile_details) {
																		$selected = "";
																		if (!empty($post_meta['tw_accounts']) && in_array($key, $post_meta['tw_accounts'])) {
																			$selected = ' selected="selected"';
																		}
																		?>
																		<option value="<?php echo $key; ?>"<?php print $selected; ?>><?php echo $profile_details['name']; ?></option>
																		<?php
																	}
																}
																?>
															</select>
															<?php $sap_schedule_time_tw = $this->get_post_meta($post_id, 'sap_schedule_time_tw'); ?>
															<div class="sap-individual-time">
																<label for="sap-schedule-time-tw" class="control-label"><?php echo $sap_common->lang('schedule_individual'); ?><i class="fa fa-question-circle sap-st-tooltip" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="This setting modifies the schedule global setting and overrides scheduled time. Keep it blank to use the global schedule settings."></i></label>
																<input type="text" name="sap-schedule-time-tw" id="sap-schedule-time-tw" <?php echo !empty($sap_schedule_time_tw) ? 'value="' . date('Y-m-d H:i', $sap_schedule_time_tw) . '"' : ''; ?> readonly="" class="form-control sap-datetime">
															</div>
														<?php } ?>

													</div>
												</div>
												<?php
											}

                                            if (!empty($sap_telegram_options['enable_telegram'])) {
                                                ?>
                                                <div class="panel box tg-wrap">
                                                    <h4 class="box-title">
                                                        <a href="javascript:void(0)"><?php echo $sap_common->lang('network_label_telegram'); ?></a>
                                                        <div class="tg-list-item col-sm-6">
                                                            <input data-content="#quick_post_telegram" class="tgl tgl-ios" name="networks[telegram]" <?php echo!empty($post_meta['telegram']) ? 'checked="checked"' : ''; ?> id="enable_telegram" type="checkbox" value="1">
                                                            <label class="tgl-btn float-right-cs-init" for="enable_telegram"></label>
                                                        </div>
                                                    </h4>
                                                    <?php
                                                    $style = !empty($post_meta['telegram']) ? 'display:block;' : 'display:none;';
                                                    ?>
                                                    <div id="quick_post_telegram" class="panel-collapse collapse" style="<?php echo $style; ?>">

                                                        <?php
                                                        if (empty($sap_telegram_accounts_details)) { ?>
                                                            <div class="alert alert-danger sap-warning">
                                                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                                <?php echo $sap_common->lang('quick_post_tg_cnofig_msg'); ?>
                                                            </div>
                                                        <?php } else { ?>
                                                            <label for="sap_telegram_user_id" class="control-label"><?php echo $sap_common->lang('select_accounts'); ?></label>
                                                            <select class="form-control sap_select" tabindex="14" name="networks[tg_accounts][]" multiple="multiple" id="sap_telegram_user_id" data-placeholder="Select User">
                                                                <?php

                                                                if (!empty($sap_telegram_accounts_details)) {
                                                                    foreach ($sap_telegram_accounts_details as $key => $profile_details) {
                                                                        $selected = "";
                                                                        if ((!empty($post_meta['tg_accounts']) && in_array($key, $post_meta['tg_accounts'])) || (!empty($post_meta['telegram']) && $post_meta['telegram'] == @$profile_details['name'])) {
                                                                            $selected = ' selected="selected"';
                                                                        }
                                                                        ?>
                                                                        <option value="<?php echo $key; ?>"<?php print $selected; ?>><?php echo $profile_details['name']; ?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                            <?php $sap_schedule_time_tg = $this->get_post_meta($post_id, 'sap_schedule_time_tg'); ?>
                                                            <div class="sap-individual-time">
                                                                <label for="sap-schedule-time-tg" class="control-label"><?php echo $sap_common->lang('schedule_individual'); ?><i class="fa fa-question-circle sap-st-tooltip" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="This setting modifies the schedule global setting and overrides scheduled time. Keep it blank to use the global schedule settings."></i></label>
                                                                <input type="text" name="sap-schedule-time-tg" id="sap-schedule-time-tg" <?php echo !empty($sap_schedule_time_tg) ? 'value="' . date('Y-m-d H:i', $sap_schedule_time_tg) . '"' : ''; ?> readonly="" class="form-control sap-datetime">
                                                            </div>
                                                        <?php } ?>

                                                    </div>
                                                </div>
                                                <?php
                                            }


											if (!empty($sap_linkedin_options['enable_linkedin'])) {
												?>
												<div class="panel box li-wrap">
													<h4 class="box-title">
														<a href="javascript:void(0)"><?php echo $sap_common->lang('network_label_li'); ?></a>
														<div class="tg-list-item col-sm-6">
															<input data-content="#quick_post_linkedin" class="tgl tgl-ios" name="networks[linkedin]" <?php echo!empty($post_meta['linkedin']) ? 'checked="checked"' : ''; ?> id="enable_linkedin" type="checkbox" value="1">
															<label class="tgl-btn float-right-cs-init" for="enable_linkedin"></label>
														</div>
													</h4>
													<?php
													$style = !empty($post_meta['linkedin']) ? 'display:block;' : 'display:none;';
													?>
													<div id="quick_post_linkedin" class="panel-collapse collapse" style="<?php echo $style; ?>">

														<?php if (empty($sap_linkedin_sess_data)) { ?>
															<div class="alert alert-danger sap-warning">
																<i class="fa fa-info-circle" aria-hidden="true"></i>
																<?php echo $sap_common->lang('quick_post_li_help_msg'); ?>
															</div>
														<?php } else { ?>
															<label for="sap_linkedin_user_id" class="control-label"><?php echo $sap_common->lang('select_accounts'); ?></label>
															<select class="form-control sap_select width-100" id="sap_linkedin_user_id" name="networks[li_accounts][]" multiple="multiple" data-placeholder="Select User">
																<?php
																$li_profile_data = $linkedin->sap_li_get_profiles_data();

																if (!empty($li_profile_data)) {
																	foreach ($li_profile_data as $profile_id => $profile_name) {
																		$selected = '';
																		if (!empty($post_meta['li_accounts']) && in_array($profile_id, $post_meta['li_accounts'])) {
																			$selected = ' selected="selected"';
																		}
																		?>
																		<option value="<?php echo $profile_id; ?>" <?php echo $selected; ?>><?php echo $profile_name; ?></option>
																		<?php
																	}
																}
																?>
															</select>
															<?php $sap_schedule_time_li = $this->get_post_meta($post_id, 'sap_schedule_time_li'); ?>
															<div class="sap-individual-time">
																<label for="sap-schedule-time-li" class="control-label"><?php echo $sap_common->lang('schedule_individual'); ?><i class="fa fa-question-circle sap-st-tooltip" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="This setting modifies the schedule global setting and overrides scheduled time. Keep it blank to use the global schedule settings."></i></label>
																<input type="text" name="sap-schedule-time-li" id="sap-schedule-time-li" <?php echo !empty($sap_schedule_time_li) ? 'value="' . date('Y-m-d H:i', $sap_schedule_time_li) . '"' : ''; ?> readonly="" class="form-control sap-datetime">
															</div>
															<div class="alert alert-info linkedin-multi-post-note">
																<!-- <i> -->
																<?php echo sprintf($sap_common->lang('quick_post_li_link_msg'),'<a href="#sap-share-link-parent-link">','</a>'); ?>
															<!-- </i> -->
														</div>
														<?php } ?>
													</div>
													
												</div>
												<?php
											}
											if (!empty($sap_tumblr_options['enable_tumblr'])) {
												?>
												<div class="panel box tum-wrap">
													<h4 class="box-title">
														<a href="javascript:void(0)"><?php echo $sap_common->lang('network_label_tumblr'); ?></a>
														<div class="tg-list-item col-sm-6">
															<input data-content="#quick_post_tumblr" class="tgl tgl-ios" name="networks[tumblr]" <?php echo!empty($post_meta['tumblr']) ? 'checked="checked"' : ''; ?> id="enable_tumblr" type="checkbox" value="1">
															<label class="tgl-btn float-right-cs-init" for="enable_tumblr"></label>
														</div>
													</h4>

													<?php
													$style = !empty($post_meta['tumblr']) ? 'display:block;' : 'display:none;';
													?>
													<div id="quick_post_tumblr" class="panel-collapse collapse" style="<?php echo $style; ?>">
														<?php $tumblr_sess_data = $this->settings->get_user_setting('sap_tumblr_sess_data'); ?>
														<?php if (empty($tumblr_sess_data)) { ?>
															<div class="alert alert-danger sap-warning">
																<i class="fa fa-info-circle" aria-hidden="true"></i>
																<?php echo $sap_common->lang('quick_post_tumb_help_msg'); ?>
															</div>

														<?php } else if (empty($selected_accounts_tumblr)) { ?>

															<div class="alert alert-danger sap-warning">
																<i class="fa fa-info-circle" aria-hidden="true"></i>
																<?php echo $sap_common->lang('quick_post_tumb_setting_msg'); ?>
															</div>

														<?php } else { ?>

															<label for="sap_tumblr_user_id" class="location-label control-label"><?php echo $sap_common->lang('select_accounts'); ?></label>
															<select class="form-control sap_select" tabindex="14" name="networks[tumblr_accounts][]" multiple="multiple" id="sap_tumblr_user_id" data-placeholder="Select User">
																<?php
																if (!empty($sap_tumblr_account_details) && is_array( $sap_tumblr_account_details ) ) {
																	
																	foreach ($sap_tumblr_account_details as $key => $profile_details) {
																		$selected = "";
																		if (!empty($post_meta['tumblr_accounts']) && in_array($key, $post_meta['tumblr_accounts'])) {
																			$selected = ' selected="selected"';
																		}
																		?>
																		<option value="<?php echo $key; ?>"<?php echo $selected; ?>><?php echo $profile_details; ?></option>
																		<?php
																	}
																}
																?>
															</select>
															<br /><br />
															<label for="sap_posting_type" class="control-label"><?php echo $sap_common->lang('select_posting_type'); ?></label>
															<select class="form-control" id="sap_posting_type" name="networks[tu_posting_type]">
																<option <?php echo!empty($post_meta['tu_posting_type']) && $post_meta['tu_posting_type'] == 'text' ? 'selected="selected"' : ''; ?> value="text"><?php echo $sap_common->lang('text'); ?></option>
																<option <?php echo!empty($post_meta['tu_posting_type']) && $post_meta['tu_posting_type'] == 'link' ? 'selected="selected"' : ''; ?> value="link"><?php echo $sap_common->lang('link'); ?></option>
																<option <?php echo!empty($post_meta['tu_posting_type']) && $post_meta['tu_posting_type'] == 'photo' ? 'selected="selected"' : ''; ?> value="photo"><?php echo $sap_common->lang('photo'); ?></option>
																<option <?php echo!empty($post_meta['tu_posting_type']) && $post_meta['tu_posting_type'] == 'video' ? 'selected="selected"' : ''; ?> value="video"><?php echo $sap_common->lang('video_label'); ?></option>
															</select>

														<?php } ?>
														<?php $sap_schedule_time_tumblr = $this->get_post_meta($post_id, 'sap_schedule_time_tumblr'); ?>
														<div class="sap-individual-time">
															<label for="sap-schedule-time-tumblr" class="control-label"><?php echo $sap_common->lang('schedule_individual'); ?><i class="fa fa-question-circle sap-st-tooltip" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="This setting modifies the schedule global setting and overrides scheduled time. Keep it blank to use the global schedule settings."></i></label>
															<input type="text" name="sap-schedule-time-tumblr" id="sap-schedule-time-tumblr" <?php echo !empty($sap_schedule_time_tumblr) ? 'value="' . date('Y-m-d H:i', $sap_schedule_time_tumblr) . '"' : ''; ?> readonly="" class="form-control sap-datetime">
														</div>
													</div>
												</div>
												<?php
											}

											if (!empty($sap_pinterest_options['enable_pinterest'])) {
												?>
												<div class="panel box pin-wrap">
													<h4 class="box-title">
														<a href="javascript:void(0)"><?php echo $sap_common->lang('network_label_pinterest'); ?></a>
														<div class="tg-list-item col-sm-6">
															<input data-content="#quick_post_pinterest" class="tgl tgl-ios" <?php echo!empty($post_meta['pinterest']) ? 'checked="checked"' : ''; ?> name="networks[pinterest]" id="enable_pinterest" type="checkbox" value="1">
															<label class="tgl-btn float-right-cs-init" for="enable_pinterest"></label>
														</div>
													</h4>
													<?php
													$style = !empty($post_meta['pin_accounts']) ? 'display:block;' : 'display:none;';
													?>
													<div id="quick_post_pinterest" class="panel-collapse collapse" style="<?php echo $style; ?>">


														<?php if (empty($sap_pinterest_grant_data)) { ?>
															<div class="alert alert-danger sap-warning">
																<i class="fa fa-info-circle" aria-hidden="true"></i>
																<?php echo $sap_common->lang('quick_post_pit_help_msg'); ?>
															</div>
														<?php } else { ?>
															<label for="sap_pin_user_id" class="control-label"><?php echo $sap_common->lang('select_accounts'); ?></label>
															<select class="form-control sap_select" tabindex="6" name="networks[pin_accounts][]" multiple="multiple" id="sap_pin_user_id" data-placeholder="Select User">
																<?php
																// Getting pinterest all accounts
																$pin_accounts = $pinterest->sap_get_pin_apps_with_boards();
																if (!empty($pin_accounts) && is_array($pin_accounts)) {

																	$pin_type_post_user = (!empty($post_meta['pin_accounts'])) ? $post_meta['pin_accounts'] : array();
																	foreach ($pin_accounts as $aid => $aval) {
																		?>

																		<option <?php echo in_array($aid, $pin_type_post_user) ? 'selected="selected"' : ''; ?> value="<?php echo $aid; ?>" ><?php echo $aval; ?></option>
																		<?php
																	} // End of foreach
																} // End of main if
																?>
															</select>
															<?php $sap_schedule_time_pin = $this->get_post_meta($post_id, 'sap_schedule_time_pin'); ?>
															<div class="sap-individual-time">
																<label for="sap-schedule-time-pin" class="control-label"><?php echo $sap_common->lang('schedule_individual'); ?><i class="fa fa-question-circle sap-st-tooltip" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="This setting modifies the schedule global setting and overrides scheduled time. Keep it blank to use the global schedule settings."></i></label>
																<input type="text" name="sap-schedule-time-pin" id="sap-schedule-time-pin" <?php echo !empty($sap_schedule_time_pin) ? 'value="' . date('Y-m-d H:i', $sap_schedule_time_pin) . '"' : ''; ?> readonly="" class="form-control sap-datetime" >
															</div>
														<?php } ?>
													</div>
												</div>
											<?php }
											?>


											<?php if (!empty($sap_gmb_options['enable_google_business'])) {
												?>
												<div class="panel box gmb-wrap">
													<h4 class="box-title">
														<a href="javascript:void(0)"><?php echo $sap_common->lang('network_label_gmb'); ?></a>
														<div class="tg-list-item col-sm-6">
															<input data-content="#quick_post_gmb" class="tgl tgl-ios" <?php echo!empty($post_meta['gmb']) ? 'checked="checked"' : ''; ?> name="networks[gmb]" id="enable_gmb" type="checkbox" value="1">
															<label class="tgl-btn float-right-cs-init" for="enable_gmb"></label>
														</div>
													</h4>
													<?php
													$style = !empty($post_meta['gmb']) ? 'display:block;' : 'display:none;';
													?>
													<div id="quick_post_gmb" class="panel-collapse collapse" style="<?php echo $style; ?>">
														<?php if (empty($sap_auto_poster_gmb_sess_data)) { ?>
															<div class="alert alert-danger sap-warning">
																<i class="fa fa-info-circle" aria-hidden="true"></i>
																<?php echo $sap_common->lang('quick_post_gmb_help_msg'); ?>
															</div>
															<?php
														} else {

															$button_type_options = array(
																"BOOK" => $sap_common->lang('book'),
																"ORDER" => $sap_common->lang('order_online'),
																"SHOP" => $sap_common->lang('buy'),
																"LEARN_MORE" => $sap_common->lang('learn_more'),
																"SIGN_UP" => $sap_common->lang('sign_up'),
																"CALL" => $sap_common->lang('call')
															);
															?>
															<label for="sap_gmb_location_id" class="location-label control-label"><?php echo $sap_common->lang('select_locations'); ?></label>
															<select class="form-control sap_select" tabindex="6" name="networks[gmb_locations][]" multiple="multiple" id="sap_gmb_location_id" data-placeholder="Select Locations">
																<?php
																if (!empty($gmb_locations) && is_array($gmb_locations)) {
																	$gmp_type_locations = (!empty($post_meta['gmb_locations'])) ? $post_meta['gmb_locations'] : array();
																	foreach ($gmb_locations as $aid => $aval) {
																		?>
																		<option <?php echo in_array($aid, $gmp_type_locations) ? 'selected="selected"' : ''; ?> value="<?php echo $aid; ?>" ><?php echo $aval; ?></option>
																		<?php
																	} // End of foreach
																} // End of main if
																?>
															</select>
															<br /><br />
															<label for="sap_gmb_button_type" class="control-label"><?php echo $sap_common->lang('select_btn_type'); ?></label>
															<select class="form-control sap_select" tabindex="6" name="networks[gmb_button_type]"  id="sap_gmb_btn_type_id" data-placeholder="Select Button Type">
																<?php
																$sap_gmb_button_type = !empty($post_meta['gmb_button_type']) ? $post_meta['gmb_button_type'] : 'LEARN_MORE';
																if (!empty($button_type_options)) {
																	foreach ($button_type_options as $button_id => $button_label) {
																		?>
																		<option value="<?php echo $button_id ?>" <?php
																		if ($button_id == $sap_gmb_button_type) {
																			echo 'selected=selected';
																		} else {
																			echo '';
																		}
																		?>><?php echo $button_label ?></option>
																		<?php
																	}
																}
																?>
															</select>
															<?php $sap_schedule_time_gmb = $this->get_post_meta($post_id, 'sap_schedule_time_gmb'); ?>
															<div class="sap-individual-time">
																<label for="sap-schedule-time-gmb" class="control-label"><?php echo $sap_common->lang('schedule_individual'); ?><i class="fa fa-question-circle sap-st-tooltip" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="This setting modifies the schedule global setting and overrides scheduled time. Keep it blank to use the global schedule settings."></i></label>
																<input type="text" name="sap-schedule-time-gmb" id="sap-schedule-time-gmb" <?php echo !empty($sap_schedule_time_gmb) ? 'value="' . date('Y-m-d H:i', $sap_schedule_time_gmb) . '"' : ''; ?> readonly="" class="form-control sap-datetime">
															</div>
															<div class="alert alert-info linkedin-multi-post-note">
																<!-- <i> -->
																	<?php echo sprintf($sap_common->lang('quick_post_gmb_link_msg'),'<a href="#sap-share-link-parent-link">','</a>'); ?>
																<!-- </i> -->
															</div>
														<?php } ?>
													</div>
												</div>
												<?php
											}
											?>
											<?php
											if (!empty($sap_instagram_options['enable_instagram'])) {
												?>
												<div class="panel box insta-wrap">
													<h4 class="box-title">
														<a href="javascript:void(0)"><?php echo $sap_common->lang('network_label_insta'); ?></a>
														<div class="tg-list-item col-sm-6">
															<input data-content="#quick_post_intagram" class="tgl tgl-ios" <?php echo!empty($post_meta['instagram']) ? 'checked="checked"' : ''; ?> name="networks[instagram]" id="enable_instagram" type="checkbox" value="1">
															<label class="tgl-btn float-right-cs-init" for="enable_instagram"></label>
														</div>
													</h4>
													<?php
													$fb_type_post_user = (!empty($post_meta['insta_accounts'])) ? $post_meta['insta_accounts'] : array();
													$style = !empty($post_meta['instagram']) ? 'display:block;' : 'display:none;';
													?>
													<div id="quick_post_intagram" class="panel-collapse collapse" style="<?php echo $style; ?>">

														<?php if (empty($sap_instagram_grant_data)) { ?>
															<div class="alert alert-danger sap-warning">
																<i class="fa fa-info-circle" aria-hidden="true"></i>
																<?php echo $sap_common->lang('instagram_quick_post_facebook_help_text'); ?>.
															</div>
														<?php } else { ?>
															<label for="sap_fb_user_id" class="control-label"><?php echo $sap_common->lang('select_accounts'); ?></label>
															<select class="form-control sap_select" tabindex="6" name="networks[instagram_accounts][]" multiple="multiple" id="sap_fb_user_id" data-placeholder="Select User">
																<?php
																$insta_accounts = $instagram->sap_get_fb_instagram_accounts('all_app_users_with_name');
																if (!empty($insta_accounts) && is_array($insta_accounts)) {

																	$instagram_type_post_user = (!empty($post_meta['instagram_accounts'])) ? $post_meta['instagram_accounts'] : array();
																	foreach ($insta_accounts as $aid => $aval) {

																		if (is_array($aval)) {
																			$fb_app_data = isset($sap_instagram_grant_data[$aid]) ? $sap_instagram_grant_data[$aid] : array();
																			$fb_user_data = isset($fb_app_data['sap_fb_user_cache']) ? $fb_app_data['sap_fb_user_cache'] : array();
																			$fb_opt_label = !empty($fb_user_data['name']) ? $fb_user_data['name'] . ' - ' : '';
																			$fb_opt_label = $fb_opt_label . $aid;
																			foreach ($aval as $aval_key => $aval_data) {
																				?>
																				<option <?php echo in_array($aval_key, $instagram_type_post_user) ? 'selected="selected"' : ''; ?> value="<?php echo $aval_key; ?>" ><?php echo $aval_data; ?></option>
																			<?php } ?>
																		<?php } else {
																			?>
																			<option <?php echo in_array($aid, $instagram_type_post_user) ? 'selected="selected"' : ''; ?> value="<?php echo $aid; ?>" ><?php echo $aval; ?></option>
																			<?php
																		}
																	} // End of foreach
																} // End of main if
																?>
															</select>
															<?php $sap_schedule_time_instagram = $this->get_post_meta($post_id, 'sap_schedule_time_instagram'); ?>
															<div class="sap-individual-time">
																<label for="sap-schedule-time-instagram" class="control-label"><?php echo $sap_common->lang('schedule_individual'); ?><i class="fa fa-question-circle sap-st-tooltip" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="This setting modifies the schedule global setting and overrides scheduled time. Keep it blank to use the global schedule settings."></i></label>
																<input type="text" name="sap-schedule-time-instagram" id="sap-schedule-time-instagram" <?php echo !empty($sap_schedule_time_instagram) ? 'value="' . date('Y-m-d H:i', $sap_schedule_time_instagram) . '"' : ''; ?> readonly="" class="form-control sap-datetime">
															</div>
														<?php } ?>
													</div>
												</div>
												<?php
											} ?>

											<?php
											if (!empty($sap_reddit_options['enable_reddit'])) {
												
												?>
												<div class="panel box insta-wrap">
													<h4 class="box-title">
														<a href="javascript:void(0)"><?php echo $sap_common->lang('network_label_reddit'); ?></a>
														<div class="tg-list-item col-sm-6">
															<input data-content="#quick_post_reddit" class="tgl tgl-ios" <?php echo!empty($post_meta['reddit']) ? 'checked="checked"' : ''; ?> name="networks[reddit]" id="enable_reddit" type="checkbox" value="1">
															<label class="tgl-btn float-right-cs-init" for="enable_reddit"></label>
														</div>
													</h4>
													<?php
													$reddit_type_post_user = (!empty($post_meta['insta_reddit'])) ? $post_meta['insta_reddit'] : array();
													$style = !empty($post_meta['reddit']) ? 'display:block;' : 'display:none;';
													?>
													<div id="quick_post_reddit" class="panel-collapse collapse" style="<?php echo $style; ?>">

														<?php if (empty($sap_reddit_grant_data)) { ?>
															<div class="alert alert-danger sap-warning">
																<i class="fa fa-info-circle" aria-hidden="true"></i>
																<?php echo $sap_common->lang('reddit_quick_post_help_text'); ?>.
															</div>
														<?php } else { ?>
															<label for="sap_fb_user_id" class="control-label"><?php echo $sap_common->lang('select_accounts'); ?></label>
															<select class="form-control sap_select" tabindex="6" name="networks[reddit_accounts][]" multiple="multiple" id="sap_reddit_user_id" data-placeholder="Select User">
																<?php
																$reddit_accounts = $reddit->sap_get_reddit_accounts();
																if (!empty($reddit_accounts) && is_array($reddit_accounts)) {

																	$reddit_type_post_user = (!empty($post_meta['reddit_accounts'])) ? $post_meta['reddit_accounts'] : array();
																	foreach ($reddit_accounts as $uid => $uname) {

																		if (!empty($uid)) { ?>
																				
																				<option <?php echo in_array($uid, $reddit_type_post_user) ? 'selected="selected"' : ''; ?> value="<?php echo $uid; ?>" ><?php echo $uname; ?></option>
																			
																		<?php }																		
																	} // End of foreach
																} // End of main if
																?>
															</select>
															<?php 
															}
															$sap_schedule_time_reddit = $this->get_post_meta($post_id, 'sap_schedule_time_reddit'); ?>
															<div class="sap-individual-time">
																<label for="sap-schedule-time-reddit" class="control-label"><?php echo $sap_common->lang('schedule_individual'); ?><i class="fa fa-question-circle sap-st-tooltip" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="This setting modifies the schedule global setting and overrides scheduled time. Keep it blank to use the global schedule settings."></i></label>
																<input type="text" name="sap-schedule-time-reddit" id="sap-schedule-time-reddit" <?php echo !empty($sap_schedule_time_reddit) ? 'value="' . date('Y-m-d H:i', $sap_schedule_time_reddit) . '"' : ''; ?> class="form-control sap-datetime">
															</div>
													</div>
												</div>
												<?php
											}
											 ?>

											<?php if ( !empty( $sap_blogger_options['enable_blogger'] ) ) { ?>
												<div class="panel box blogger-wrap">
													<h4 class="box-title">
														<a href="javascript:void(0)"><?php echo $sap_common->lang('network_label_blogger'); ?></a>
														<div class="tg-list-item col-sm-6">
															<input data-content="#quick_post_blogger" class="tgl tgl-ios" <?php echo !empty( $post_meta['blogger'] ) ? 'checked="checked"' : ''; ?> name="networks[blogger]" id="enable_blogger" type="checkbox" value="1">
															<label class="tgl-btn float-right-cs-init" for="enable_blogger"></label>
														</div>
													</h4>
													<?php $style = !empty( $post_meta['blogger'] ) ? 'display:block;' : 'display:none;'; ?>
													<div id="quick_post_blogger" class="panel-collapse collapse" style="<?php echo $style; ?>">

														<?php if ( empty( $sap_blogger_grant_data ) ) { ?>
															<div class="alert alert-danger sap-warning">
																<i class="fa fa-info-circle" aria-hidden="true"></i>
																<?php echo $sap_common->lang('quick_post_blog_cnofig_msg'); ?>.
															</div>
														<?php } else { ?>

															<label for="sap_blogger_post_url" class="control-label"><?php echo $sap_common->lang('blogger_post_url'); ?></label>
															<select class="form-control sap_select" tabindex="6" name="networks[blogger_urls][]" multiple="multiple" id="sap_blogger_post_url" data-placeholder="Select User">
															<?php
																$blogger_urls = $blogger->sap_get_blogger_urls();
																if ( !empty( $blogger_urls ) && is_array( $blogger_urls ) ) {

																	$blogger_type_post_url = ( !empty( $post_meta['blogger_urls'] ) ) ? $post_meta['blogger_urls'] : array();

																	foreach ( $blogger_urls as $Urlkey => $val ) { ?>
																				
																		<option <?php echo in_array( $val, $blogger_type_post_url ) ? 'selected="selected"' : ''; ?> value="<?php echo $val; ?>" ><?php echo $val; ?></option>

																	<?php } ?>

																<?php } // End of foreach ?>

															</select>

															<div class="sap-msg-wrap">
															<label for="sap_blogger_title" class="control-label"><?php echo $sap_common->lang('blogger_custom_message'); ?><span class="astric">*</span></label>
																
															<input type="text" name="networks[blogger_title]" class="form-control sap-blogger-title" id="sap_blogger_title" tabindex="5" value="<?php echo ( !empty( $post_meta['blogger_title'] ) ) ? $post_meta['blogger_title'] : ''; ?>" />
															</div>

															<label for="sap_fb_user_id" class="control-label"><?php echo $sap_common->lang('select_accounts'); ?></label>
															<select class="form-control sap_select" tabindex="6" name="networks[blogger_accounts][]" multiple="multiple" id="sap_blogger_user_id" data-placeholder="Select User">
															<?php
																$blogger_accounts = $blogger->sap_get_blogger_accounts();
																if ( !empty( $blogger_accounts ) && is_array( $blogger_accounts ) ) {

																	$blogger_type_post_user = ( !empty( $post_meta['blogger_accounts'] ) ) ? $post_meta['blogger_accounts'] : array();
																	foreach ( $blogger_accounts as $uid => $uname ) {

																		if ( !empty( $uid ) ) { ?>
																				
																			<option <?php echo in_array( $uid, $blogger_type_post_user ) ? 'selected="selected"' : ''; ?> value="<?php echo $uid; ?>" ><?php echo $uname; ?></option>
																			
																		<?php }	?>

																	<?php } ?>

																<?php } // End of foreach ?>

															</select>
															<?php $sap_schedule_time_blogger = $this->get_post_meta($post_id, 'sap_schedule_time_blogger'); ?>
															<div class="sap-individual-time">
																<label for="sap-schedule-time-blogger" class="control-label"><?php echo $sap_common->lang('schedule_individual'); ?><i class="fa fa-question-circle sap-st-tooltip" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="This setting modifies the schedule global setting and overrides scheduled time. Keep it blank to use the global schedule settings."></i></label>
																<input type="text" name="sap-schedule-time-blogger" id="sap-schedule-time-blogger" <?php echo !empty($sap_schedule_time_blogger) ? 'value="' . date('Y-m-d H:i', $sap_schedule_time_blogger) . '"' : ''; ?> readonly="" class="form-control sap-datetime">
															</div>
														<?php } // End of main if ?> 
													</div>
												</div>
											<?php } ?> 

											 <?php if(!empty($sap_wordpress_options['enable_wordpress'])){ ?>
													<div class="panel box blogger-wrap">
														<h4 class="box-title">
															<?php echo $sap_common->lang('network_label_wordpress'); ?>
															<div class="tg-list-item col-sm-6">
																<input data-content="#quick_post_wordpress" class="tgl tgl-ios" <?php echo !empty( $post_meta['wordpress'] ) ? 'checked="checked"' : ''; ?> name="networks[wordpress]" id="enable_wordpress" type="checkbox" value="1">
																<label class="tgl-btn float-right-cs-init" for="enable_wordpress"></label>
															</div>
														</h4>
														<?php $style = !empty( $post_meta['wordpress'] ) ? 'display:block;' : 'display:none;'; ?>
														<div id="quick_post_wordpress" class="panel-collapse collapse" style="<?php echo $style; ?>">

															<?php if (! empty( $sap_wordpress_grant_data ) ) { ?>
																<div class="alert alert-danger sap-warning">
																	<i class="fa fa-info-circle" aria-hidden="true"></i>
																	<?php echo $sap_common->lang('quick_post_wp_cnofig_msg'); ?>.
																</div>
															<?php } else {
																$wordpress_urls = $wordpress->sap_get_wordpress_urls();
																$wordpress_urls = $sap_wordpress_grant_data;
																
																?>

																
																<div class="sap-msg-wrap">
																<label for="sap_blogger_title" class="control-label"><?php echo $sap_common->lang('wordpress_custom_message'); ?><span class="astric">*</span></label>
																	
																<input type="text" name="networks[wordpress_title]" class="form-control sap_wordpress_title" id="sap_wordpress_title" tabindex="5" value="<?php echo ( !empty( $post_meta['wordpress_title'] ) ) ? $post_meta['wordpress_title'] : ''; ?>" />
																</div>

																<label for="sap_fb_user_id" class="control-label"><?php echo $sap_common->lang('select_accounts'); ?></label>
																<select class="form-control sap_select" tabindex="6" name="networks[wordpress_accounts][]" multiple="multiple" id="sap_wordpress_user_id" data-placeholder="Select User">
																<?php
																	
																	$wordpress_urls = $wordpress->sap_get_wordpress_urls();
																	$wordpress_type_post_user = (!empty($post_meta['wordpress_accounts'])) ? $post_meta['wordpress_accounts'] : array();
																	
																	if ( !empty( $wordpress_urls ) && is_array( $wordpress_urls ) ) {
																		$wordpress_cnt =1;
																		$wordpress_count =  $networks_count['wordpress'];
																		foreach ( $wordpress_urls as $uid => $uname ) {
																			if( $wordpress_cnt > $wordpress_count && $wordpress_count >0){
																				break;
																			}
																			$wordpress_cnt++;
																			?>
																			<option value="<?php echo $uname;?>" <?php echo in_array($uname,$wordpress_type_post_user)?"selected" :"" ?>><?php echo $uname;?></option>
																		<?php } ?>
																	<?php } // End of foreach ?>
																</select>
																<div class="sap-individual-time">
																<?php $sap_schedule_time_wordpress = $this->get_post_meta($post_id, 'sap_schedule_time_wordpress'); ?>
																	<label for="sap-schedule-time-wordpress" class="control-label"><?php echo $sap_common->lang('schedule_individual'); ?><i class="fa fa-question-circle sap-st-tooltip" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="This setting modifies the schedule global setting and overrides scheduled time. Keep it blank to use the global schedule settings."></i></label>
																	<input type="text" name="sap-schedule-time-wordpress" id="sap-schedule-time-wordpress" <?php echo !empty($sap_schedule_time_wordpress) ? 'value="' . date('Y-m-d H:i', $sap_schedule_time_wordpress) . '"' : ''; ?> readonly="" class="form-control sap-datetime ">
																</div>
															<?php } // End of main if 
															?>
														</div>
													</div>
												<?php }	?>
										</div>
									</div>
								</div>
							</div>
						<!-- </div> -->

						<div class="col-lg-12">
							<div class="row">
								<div class="col-lg-12 buttons buttons-display-flex button-amin-wrap sap-global-time-wrap d-flex">
								<label for="sap-schedule-time" class="col-sm-6 control-label"><?php echo $sap_common->lang('schedule_global'); ?><i class="fa fa-question-circle sap-st-tooltip" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="Enter schedule time to publish post on social media. This setting applies the schedule time for all the social media and it gets over-written if Schedule Individually is applied for any particular social media."></i></label>
							    	<div class="col-sm-12">
									  <div class="col-lg-8 sap-global-time">
										<div class="form-group">
										  <div class="" style="padding-left: 0px;">
										    <div class="d-flex align-items-center sap-schedule-clock">
												<i class="fa fa-clock-o sap-schedule-icon" aria-hidden="true"></i>
												<input type="text" name="sap-schedule-time" id="sap-schedule-time" readonly="" <?php echo!empty($sap_schedule_time) ? 'value="' . date('Y-m-d H:i', $sap_schedule_time) . '"' : ''; ?> class="form-control sap-datetime sap-schedule-input">
											 </div>
											</div>
										</div>
									</div>	
									<div class="col-lg-4" style="padding-right: 0px;">
											<input type="hidden" id="status" value="1" name="status">
											<input type="hidden" name="quick-form-updated" value="1">
											<button type="submit" name="sap_quick_post_update" class="btn btn-success pull-right buttons-margin-left-auto"><?php echo $sap_common->lang('update_post'); ?></button>
										</div>	
  									</div>						
								</div>
								</div>
							</div>
						</div>
					</div>
				</form>
			<?php } ?>		

	<?php
	$schedule_tab_active = $publish_tab_active = $schedule_content_active = $publish_content_active = "";
	if (isset($sap_schedule_time) && !empty($sap_schedule_time)) {
		$schedule_li_active = "sap-tab-li-active";
		$schedule_tab_active = "sap-tab-nav-active";
		$schedule_content_active = "sap-tab-content-active";
	} else {
		$publish_li_active = "sap-tab-li-active";
		$publish_tab_active = "sap-tab-nav-active";
		$publish_content_active = "sap-tab-content-active";
	}
	?>
</div>
</section>

</div>

<?php include SAP_APP_PATH . 'footer.php'; ?>

<script type="text/javascript" class="init">
	'use strict';
	
	$(document).ready(function () {

		$(document).on('click',".sap-tab-nav",function (e) {
			e.preventDefault();

			var id = $(this).attr("id");
			$("a.sap-tab-nav").each(function (index, element) {
				$(this).removeClass("sap-tab-nav-active");
				$(this).closest('ul').find('li').removeClass("sap-tab-li-active");
			});
			$(".sap-tab-content").each(function (index, element) {
				$(this).removeClass("sap-tab-content-active");
			});
			$(this).addClass("sap-tab-nav-active");
			$(this).closest('li').addClass("sap-tab-li-active");
			$(".sap-tab-content#" + id).addClass("sap-tab-content-active");
			$('#list-post-scheduled').removeAttr('style');
		});

		$('#list-post').DataTable({
			"oLanguage": {
				"sEmptyTable": "No post found."
			},
			"aLengthMenu": [[15,25, 50, 100], [15,25, 50, 100]],
			"pageLength": 15,
			"pagingType": "full",
			"dom": 'lrtip',
			"order": [],
			"columnDefs" : [
			   {
				 'targets': [0,3],
				 'orderable': false,
			  },
			  { width: '220px', targets: 1 },
			  { width: '80px', targets: 3 },
			]
		});
		
		// Attach DataTables search to custom input
        $('#searchInputquickpost').on('keyup', function() {
            $('#list-post').DataTable().search(this.value).draw();
        });

		$('#list-post-scheduled').DataTable({
			"oLanguage": {
				"sEmptyTable": "No post found."
			},
			"aLengthMenu": [[15,25, 50, 100], [15,25, 50, 100]],
			"pageLength": 15,
			"pagingType": "full",
			"dom": 'lrtip',
			"order": [],
			"autoWidth": false,
			"columnDefs": [
			{"width": "17px", "targets": 0},
			{ width: '220px', targets: 1 },
			{ width: '80px', targets: 3 },
			{
				 'targets': [0,3],
				 'orderable': false
			  }
			],
		});

		// Attach DataTables search to custom input
        $('#searchInputquickposts').on('keyup', function() {
            $('#list-post-scheduled').DataTable().search(this.value).draw();
        });

		$(document).on('click', '.delete_quick_post', function () {
			var obj = $(this);
			var post_id = $(this).attr('aria-data-id');
			if (confirm("<?php echo $sap_common->lang('delete_record_conform_msg'); ?>")) {
				$.ajax({
					type: 'POST',
					url: SAP_SITE_URL + '/quick-post/delete/',
					data: {post_id: post_id},
					success: function (result) {
						var result = jQuery.parseJSON(result);
						if (result.status)
						{
							$('#quick_post_' + post_id).remove();
							if ($("#list-post tbody tr").length == 0) {
								$("#list-post").find('tbody').append('<tr class="odd"><td valign="top" colspan="5" class="dataTables_empty">No data available in table</td></tr>');
							}
						}
					}
				});
			}

		});

		$(document).on('change','#searchByGender', function(){
			var selected_val = $('#searchByGender option:selected').val();
			if(selected_val == 'delete'){
				var id = [];
				$("input[name='post_id[]']:checked").each(function (i) {
					id[i] = $(this).val();
				});

			//tell you if the array is empty
			if (id.length === 0) {
				alert("<?php echo $sap_common->lang('select_checkbox_alert'); ?>");

			} else if (confirm("<?php echo $sap_common->lang('delete_selected_records_conform_msg'); ?>")) {

				$.ajax({
					url: SAP_SITE_URL + '/quick-post/delete_multiple/',
					method: 'POST',
					data: {id: id},
					success: function (result)
					{
						var result = jQuery.parseJSON(result);
						if (result.status) {
							window.location.replace(result.redirect_url);
						}
					}
				});
			} else {
				return false;
			}
		}
	});
        setTimeout(() => {
            const enableImage = $('#enable_image');
            if(enableImage.is(':checked')) {
                enableImage.trigger('change');
            }

            const enableVideo = $('#enable_video');
            if(enableVideo.is(':checked')) {
                $('#enable_video').trigger('change');
            }

            const enableMedia = $('#enable_media');
            if(enableMedia.is(':checked')) {
                $('#enable_media').trigger('change');
            }
        },1000);

	});
</script>
