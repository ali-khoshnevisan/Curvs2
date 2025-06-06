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
global $router, $match; 

$payment_gateway = $this->setting->get_options('payment_gateway');
$stripe_label    = $this->setting->get_options('stripe_label');
$default_payment_method = $this->setting->get_options('default_payment_method');

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <?php
        $mingle_site_name  = $this->setting->get_options('mingle_site_name' );

        if( ! empty( $mingle_site_name ) ) {
            ?>
           <title><?php echo $mingle_site_name; ?></title>
            <?php
        } else {
            ?>
            <title><?php echo SAP_NAME; ?></title>
            <?php
        }
        ?>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="icon" href="<?php echo SAP_SITE_URL . '/assets/images/favicon.png'; ?>" type="image/png" sizes="32x32">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="<?php echo SAP_SITE_URL . '/assets/css/bootstrap.min.css'; ?>">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo SAP_SITE_URL . '/assets/css/font-awesome.min.css'; ?>">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo SAP_SITE_URL . '/assets/css/curvs-social-auto-poster.min.css'; ?>">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="<?php echo SAP_SITE_URL . '/assets/css/_all-skins.min.css'; ?>">
        <!-- Login Page CSS -->
        <link rel="stylesheet" href="<?php echo SAP_SITE_URL . '/assets/css/curvs-login.css?id=1'; ?>">
        
        <link rel="stylesheet" href="<?php echo SAP_SITE_URL . '/assets/css/style.css'; ?>">
        
        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <!-- Custom Stylesheet Start -->
        <style>
            <?php echo $this->setting->get_options('css_content'); ?>
        </style>
        <!-- Custom Stylesheet End -->
        <script>
            var SAP_SITE_URL = "<?php echo SAP_SITE_URL; ?>";
        </script>
    </head>
    <body class="hold-transition login-page thank-you-page">
        <!-- login -->
        <div class="thank-you-box">
            <div class="d-lg-block col-lg-5 h-100 bg-plum-plate">
                    <div class="login-logo-inner">
                        <div class="login-logo">
                            <?php
                             if(!empty($this->setting->get_options('mingle_logo')) ) {?>
                               
                                <img src="<?php echo SAP_SITE_URL .'/assets/images/Mingle-Logo.svg'; ?>" class="mingle-logo" />
                             
                             <?php }else{ ?>

                                <img src="<?php echo SAP_SITE_URL .'/assets/images/Mingle-Logo.svg'; ?>" class="mingle-logo" />
                                
                             <?php } ?>
                            <p class="thank_you_msg"><?php echo $sap_common->lang('thank_you_msg'); ?></p>
                        </div>
                    </div>
                </div>
             <div class="h-100 d-flex bg-white justify-content-center align-items-center col-md-12 col-lg-7 login-box-wrap">
                <div class="login-box" style="margin-left: 0;">
                    <?php echo $this->flash->renderFlash(); ?>
                    <!-- /.login-logo -->
                    <div class="signup-box-body">                
                       <div class="box box-primary">
                            <div class="box-header text-center">
                                <h3 class="box-title"><?php echo $sap_common->lang('subscription_details'); ?></h2>
                            </div>                        
                            <div class="box-body">
                            	<div id="plan_result">
                                    <table class="table table-striped table-bordered">  
                                        <tbody>
                                            <tr>
                                                <th scope="row"><?php echo $sap_common->lang('customer_name'); ?></th>
                                                <td><?php echo $subscription_details->customer_name ?? ''; ?></td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><?php echo $sap_common->lang('membership_level'); ?></th>
                                                <td><?php echo $subscription_details->name ?? ''; ?></td>
                                            </tr>
                                            <tr>
                                              <th scope="row"><?php echo $sap_common->lang('allowed_network'); ?></th>
                                              <td>
                                                <?php
                                                    $networks = isset($subscription_details->networks) ? unserialize($subscription_details->networks) : '';
                                                    if( !empty( $networks ) ){
                                                        $li_content = '';
                                                        foreach ($networks as $key => $network) {
                                                            $li_content .= sap_get_networks_label($network).', ';
                                                        }
                                                        echo rtrim($li_content,", ");  
                                                    }
                                                ?>
                                                 </td>
                                            </tr>
                                                    
                                            <tr>
                                                <th scope="row"><?php echo $sap_common->lang('price'); ?></th>
                                                <td><?php echo $sap_common->get_default_currency_symbol().($subscription_details->price ?? '0'); ?></td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><?php echo $sap_common->lang('membership_status'); ?></th>
                                                <td><?php echo get_membership_status_label($subscription_details->membership_status ?? '') ?></td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><?php echo $sap_common->lang('recurring'); ?></th>
                                                <td><?php                                         
                                                echo get_recuring_status_label($subscription_details->recurring ?? '')  ?></td>                                 
                                            </tr>
                                            <tr>
                                                <th scope="row"><?php echo $sap_common->lang('expiration_date'); ?></th>
                                                <td><?php echo sap_get_membership_expiration_date($subscription_details->expiration_date ?? '') ?></td>
                                            </tr>                                    
                                          </tbody>
                                        </table>                          
                                        </div>
                                    </div>
                                    <div class="login-btn-wrap text-center box-footer">
        		                        <a class="text-center btn btn-primary" href="<?php echo SAP_SITE_URL?>"><?php echo $sap_common->lang('continue_login'); ?></a>
        		                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- /.signup-box-body -->
            </div>
        </div>
    </body>
    <!-- jQuery 3 -->
    <script src="<?php echo SAP_SITE_URL . '/assets/js/jquery.min.js'; ?>"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="<?php echo SAP_SITE_URL . '/assets/js/bootstrap.min.js'; ?>"></script>
    <script src="<?php echo SAP_SITE_URL . '/assets/js/jQuery-validate/jquery.validate.js' ?>"></script>
    <script src="<?php echo SAP_SITE_URL . '/assets/js/curvs-login.js'; ?>"></script>


<script type="text/javascript" src="https://js.stripe.com/v1/"></script>
<script type="text/javascript" src="<?php echo SAP_SITE_URL .'/assets/js/stripe-processing.js' ?>"></script>
</body>
</html>