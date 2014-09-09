<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8" />
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<?php } ?>
<?php if ($icon) { ?>
<link href="<?php echo $icon; ?>" rel="icon" />
<?php } ?>
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<?php foreach ($styles as $style) { ?>
<link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<link href='http://fonts.googleapis.com/css?family=Alegreya+SC:400,400italic,700%7CAlegreya:400,400italic,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/customScrollbar/jquery.mCustomScrollbar.css">
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" />
    <script type="text/javascript" src="catalog/view/javascript/jquery/image-scale/image-scale.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/customScrollbar/jquery.mCustomScrollbar.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/customScrollbar/jquery.mousewheel-3.0.6.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/common.js"></script>
<?php foreach ($scripts as $script) { ?>
<script type="text/javascript" src="<?php echo $script; ?>"></script>
<?php } ?>
<!--[if IE 7]> 
<link rel="stylesheet" type="text/css" href="catalog/view/theme/jv/stylesheet/ie7.css" />
<![endif]-->
<!--[if lt IE 7]>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/jv/stylesheet/ie6.css" />
<script type="text/javascript" src="catalog/view/javascript/DD_belatedPNG_0.0.8a-min.js"></script>
<script type="text/javascript">
DD_belatedPNG.fix('#logo img');
</script>
<![endif]-->
   <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css" />
    <link rel="stylesheet/less" type="text/css" href="catalog/view/theme/jv/stylesheet/stylesheet.less" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/less.js/1.7.4/less.min.js"></script>


<?php if ($stores) { ?>
<script type="text/javascript"><!--
$(document).ready(function() {
<?php foreach ($stores as $store) { ?>
$('body').prepend('<iframe src="<?php echo $store; ?>" style="display: none;"></iframe>');
<?php } ?>
});
//--></script>
<?php } ?>
<?php echo $google_analytics; ?>
</head>
<body>
<?php // echo '<pre>' . print_r($_SERVER, true) . '</pre>'; ?>
<div id="container">
<header>
  <?php echo $cart; ?>
  <?php echo $language; ?>
  <div id="contact"><a class="top-icons message" href="javascript:void(0);"></a></div>
  <div id="hello-users">
    <?php if (!$logged) { ?>
    <?php  echo $text_welcome; ?>
        <div id="simple_login">
            <div id="simple_login_header"></div>
            <div id="simple_login_content">
                <div id="simplecheckout_login">
                    <div class="simplecheckout-warning-block"
                         <?php if (!$error_login) { ?>style="visibility:hidden;"<?php } ?>><?php echo $error_login ?></div>
                    <table class="simplecheckout-login">
                        <tbody>
                        <tr>
                            <td colspan="2" class="simplecheckout-login-left"><?php echo $entry_email; ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="simplecheckout-login-right"><input type="text"
                                                                                      value="<?php echo $email; ?>"
                                                                                      name="email"></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="simplecheckout-login-left"><?php echo $entry_password; ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="simplecheckout-login-right"><input type="password" value=""
                                                                                      name="password"></td>
                        </tr>
                        <tr>
                            <td class="simplecheckout-login-right fgt-pass"><a
                                    href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a></td>
                            <td class="simplecheckout-login-right buttons"><a class="button btn"
                                                                              onclick="simplecheckout_login()"
                                                                              id="simplecheckout_button_login"><span><?php echo $button_login; ?></span></a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script type='text/javascript'>
            $('.simplecheckout-login input').keydown(function (e) {
                if (e.keyCode == 13) {
                    simplecheckout_login();
                }
            });
        </script>
    <?php if ($redirect) { ?>
        <script type='text/javascript'>
            location = '<?php echo $redirect ?>';
        </script>
    <?php } ?>
    <?php } else { ?>
    <?php echo $text_logged; ?>
    <?php } ?>
  </div>
    <?php echo $currency; ?>
</header>
<?php if ($error) { ?>
    
    <div class="warning"><?php echo $error ?><img src="catalog/view/theme/jv/image/close.png" alt="" class="close" /></div>
    
<?php } ?>
<div id="notification"></div>
