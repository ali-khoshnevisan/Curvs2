<?php

/* Check the absolute path to the Social Auto Poster directory. */
if (!defined('SAP_APP_PATH')) {
    // If SAP_APP_PATH constant is not defined, perform some action, show an error, or exit the script
    // Or exit the script if required
    exit();
}

global $sap_common;
$SAP_Mingle_Update = new SAP_Mingle_Update();
$license_data = $SAP_Mingle_Update->get_license_data();
if (!$sap_common->sap_is_license_activated()) {
    $redirection_url = '/mingle-update/';
    header('Location: ' . SAP_SITE_URL . $redirection_url);
    die();
}

include 'header.php';

include 'sidebar.php';

require_once(CLASS_PATH . 'Posts.php');
require_once(CLASS_PATH . 'Common.php');


// Get user's active networks
$networks = sap_get_users_networks();
$networks_count = sap_get_users_networks_count();

//Check Social class exist or not then load class
if (!class_exists('SAP_Facebook')) {
    include(CLASS_PATH . 'Social' . DS . 'fbConfig.php');
}
if (!class_exists('SAP_Linkedin')) {
    include(CLASS_PATH . 'Social' . DS . 'liConfig.php');
}
if (!class_exists('SAP_Tumblr')) {
    include(CLASS_PATH . 'Social' . DS . 'tumblrConfig.php');
}
if (!class_exists('SAP_Gmb')) {
    include(CLASS_PATH . 'Social' . DS . 'gmbConfig.php');
}
if (!class_exists('SAP_Pinterest')) {
    include(CLASS_PATH . 'Social' . DS . 'pinConfig.php');
}
if (!class_exists('SAP_Instagram')) {
    include(CLASS_PATH . 'Social' . DS . 'instaConfig.php');
}
if (!class_exists('SAP_Reddit')) {
    include(CLASS_PATH . 'Social' . DS . 'redditConfig.php');
}
if (!class_exists('SAP_Youtube')) {
    include(CLASS_PATH . 'Social' . DS . 'youtubeConfig.php');
}
if (!class_exists('SAP_Blogger')) {
    include(CLASS_PATH . 'Social' . DS . 'bloggerConfig.php');
}
if (!class_exists('SAP_Wordpress')) {
    include(CLASS_PATH . 'Social' . DS . 'wordpressConfig.php');
}

//Object of social classed
$facebook = new SAP_Facebook();
$linkedin = new SAP_Linkedin();
$tumblr = new SAP_Tumblr();
$google_business = new SAP_Gmb();
$pinterest = new SAP_Pinterest();
$instagram = new SAP_Instagram();
$reddit = new SAP_Reddit();
$youtube = new SAP_Youtube();
$blogger = new SAP_Blogger();
$wordpress = new SAP_Wordpress_Config();


$common = new Common();

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
			<span class="d-flex flex-wrap align-items-center">
		                <span class="margin-r-5"><i class="fa fa-cog"></i></span>

				Settings
			</span>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">
                <?php
                echo $this->flash->renderFlash();

                //Active tab check
                $active_tab = !empty($_SESSION['sap_active_tab']) ? $_SESSION['sap_active_tab'] : '';


                if (!in_array($active_tab, $networks)) {
                    $active_tab = '';
                } ?>
                <!-- Custom Tabs -->
                <div class="nav-tabs-custom settings--tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="<?php echo (empty($active_tab) || $active_tab == "general") ? "active" : "" ?>"><a
                                    href="#general" data-toggle="tab">General</a></li>

                        <?php

                        foreach ($networks as $key => $network) {
                            switch ($network) {
                                case 'facebook':
                                    $label = $sap_common->lang('network_label_fb');
                                    break;
                                case 'telegram':
                                    $label = $sap_common->lang('network_label_tg');
                                    break;
                                case 'twitter':
                                    $label = $sap_common->lang('network_label_twitter');
                                    break;
                                case 'linkedin':
                                    $label = $sap_common->lang('network_label_li');
                                    break;
                                case 'tumblr':
                                    $label = $sap_common->lang('network_label_tumblr');
                                    break;
                                case 'pinterest':
                                    $label = $sap_common->lang('network_label_pinterest');
                                    break;
                                case 'gmb':
                                    $label = $sap_common->lang('network_label_gmb');
                                    break;
                                case 'reddit':
                                    $label = $sap_common->lang('network_label_reddit');
                                    break;
                                case 'blogger':
                                    $label = $sap_common->lang('network_label_blogger');
                                    break;
                                case 'youtube':
                                    $label = $sap_common->lang('network_label_youtube');
                                    break;
                                case 'instagram':
                                    $label = $sap_common->lang('network_label_insta');
                                    break;
                                case 'wordpress':
                                    $label = $sap_common->lang('network_label_wordpress');
                                    break;
                                case 'crod':
                                    $label = $sap_common->lang('network_label_crod');
                                    break;
                                case 'crud':
                                    $label = $sap_common->lang('network_label_crud');
                                    break;
                                default:
                                    $label = '';
                            }

                            $class = ($active_tab == $network) ? "active" : "";
                            echo '<li class="' . $class . '"><a href="#' . $network . '" data-toggle="tab">' . $label . ' 
<img src="'. $this->socialIconsByType($network) .'"
                                                                     alt="Social Icon" style="width: 20px;">
</a></li>';
                        } ?>

                    </ul>

                    <div class="tab-content tab-content-settings">
                        <div class="tab-pane <?php echo (empty($active_tab) || $active_tab == "general") ? "active" : "" ?>"
                             id="general">
                            <div class="box box-primary">

                                <!-- <div class="box-header sap-settings-box-header">General Settings</div> -->
                                <!-- /.box-header -->
                                <!-- form start -->

                                <form class="form-horizontal" action="<?php echo SAP_SITE_URL . '/settings/save/'; ?>"
                                      method="POST" id="sap-general-settings-form">

                                    <?php
                                    //Get SAP options which stored
                                    $sap_general_options = $this->get_user_setting('sap_general_options');
                                    ?>
                                    <div class="box-body">
                                        <div class="sap-box-inner">

                                            <div class="form-group">
                                                <label for="schedule_wallpost_option" class="col-sm-3 control-label">Timezone
                                                    <i class="fa fa-question-circle text-muted" data-toggle="tooltip"
                                                       title="<?php eLang('settings_timezone_tooltip'); ?>"></i>
                                                </label>
                                                <div class="col-sm-6 general-timezone-wrap">
                                                    <select name="sap_general_options[timezone]"
                                                            id="schedule_wallpost_option"
                                                            class="form-control sap_select">
                                                        <option value=''>Select your timezone</option>
                                                        <?php
                                                        //Get all schedule time
                                                        $timezones_options = $this->get_timezones();

                                                        foreach ($timezones_options as $key => $option) {
                                                            echo '<option value="' . $option['zone_name'] . '" ' . (!empty($sap_general_options['timezone']) && $sap_general_options['timezone'] == $option['zone_name'] ? 'selected="selected"' : '') . ' >' . $option['zone_name'] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="box-body sap-mt-3">
                                                <div style="background: linear-gradient(145deg, #e3f2fd, #bbdefb); padding: 30px; border-radius: 15px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1); text-align: center; max-width: 600px; margin: auto; position: relative; overflow: hidden;">
                                                    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: radial-gradient(circle, rgba(135, 206, 250, 0.2), transparent); animation: moveGradient 5s infinite alternate; pointer-events: none;"></div>
                                                    <h1 style="color: #0d47a1; font-size: 3em; font-weight: bold; margin-bottom: 15px; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);">
                                                        Help:</h1>
                                                    <h3 style="color: #1565c0; font-size: 1.6em; line-height: 1.6; margin-bottom: 20px; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.05);">
                                                        For service support, send a message to the following address on
                                                        Telegram. We will create a private group to listen and resolve
                                                        your issues.</h3>
                                                    <a href="https://t.me/Curvs_ai_support" target="_blank">
                                                        <h4 style="color: #fff; font-size: 1.3em; font-weight: bold; background: linear-gradient(90deg, #2196f3, #1e88e5); padding: 12px 25px; border-radius: 8px; display: inline-block; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); transition: transform 0.3s ease, box-shadow 0.3s ease;">
                                                            ID: Curvs_ai_support </h4>
                                                    </a>

                                                </div>
                                                <style>
                                                    @keyframes moveGradient {
                                                        0% {
                                                            transform: translateX(-50%) translateY(-50%);
                                                        }
                                                        100% {
                                                            transform: translateX(50%) translateY(50%);
                                                        }
                                                    }
                                                </style>

                                            </div>



                                        </div>

                                    </div>

                                    <div class="box-footer">
                                        <div class="">
                                            <button type="submit" name="sap_general_submit"
                                                    class="btn btn-primary sap-general-submit"><i
                                                        class="fa fa-inbox"></i> Save
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <?php
                        foreach ($networks as $key => $network) {

                            include_once(SAP_APP_PATH . 'view/Settings/' . ucwords($network) . '-settings.php');

                        } ?>


                        <!-- /.tab-pane -->
                        <span class="sap-loader">
							<div class="sap-loader-sub">
								<div class="sap-loader-img"></div>
							</div>
						</span>
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- nav-tabs-custom -->
            </div>
        </div>
        <!-- /.row -->
    </section>
</div>

<?php
unset($_SESSION['sap_active_tab']);
include 'footer.php';
?>
