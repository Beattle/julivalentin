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
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" />
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
<!--[if lte IE 8]>
  <link rel="stylesheet" href="<?php echo THEME_PATH.'stylesheet/grid-old-ie.css' ?>"/>
<![endif]-->
<!--[if gt IE 8]><!-->
  <link rel="stylesheet" href="<?php echo THEME_PATH.'stylesheet/grid.css' ?>" />
<!--<![endif]-->
    <link href='http://fonts.googleapis.com/css?family=Alegreya+SC:700,400,400italic,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/jv/stylesheet/stylesheet.css" />

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
<div id="container">
<header>
  <?php echo $cart; ?>
  <?php echo $language; ?>
  <div id="contact"><a class="top-icons message" href="javascript:void(0);"></a></div>
  <div id="hello-users">
    <?php if (!$logged) { ?>
    <?php  echo $text_welcome; ?>
    <?php } else { ?>
    <?php echo $text_logged; ?>
    <?php } ?>
  </div>
</header>
<?php if ($categories) { ?>
<div id="menu">
  <ul>
    
			<?php foreach($headermenu as $header){?> 
			<li><a href="<?php echo $header['link'] ?>"><?php echo $header['title']; ?></a>
			<?php if($header['sub_title']){?>
				<div>	
				<ul>
				<?php foreach($header['sub_title'] as $subtitle){ ?>
				<li>
					<?php if(isset($subtitle['href'])){?>					
					<a href="<?php echo $subtitle['href']; ?>"><?php echo $subtitle['title']; ?></a>
					<?php }else{?>
					<a href="<?php echo $subtitle['link']?>"><?php echo $subtitle['title']; ?></a>	
					<?php } ?>
					<?php if($header['sub_title']){?>
				
				<ul>
				<?php foreach($subtitle['sub_title'] as $subtitle){ ?>
				<li>
					<?php if(isset($subtitle['href'])){?>					
					<a href="<?php echo $subtitle['href']; ?>"><?php echo $subtitle['title']; ?></a>
					<?php }else{?>
					<a href="<?php echo $subtitle['link']?>"><?php echo $subtitle['title']; ?></a>	
					<?php } ?>
					
					
					
			</li>
				<?php }?>
					
				</ul>				
				
				
				<?php }?>	
			</li>
				<?php }?>
				</ul>				
				</div>
				
				<?php }?>		
			</li>			
			<?php  }?>
			<?php foreach ($categories as $category) { ?>
		
    <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
      <?php if ($category['children']) { ?>
      <div>
        <?php for ($i = 0; $i < count($category['children']);) { ?>
        <ul>
          <?php $j = $i + ceil(count($category['children']) / $category['column']); ?>
          <?php for (; $i < $j; $i++) { ?>
          <?php if (isset($category['children'][$i])) { ?>
          <li><a href="<?php echo $category['children'][$i]['href']; ?>"><?php echo $category['children'][$i]['name']; ?></a></li>
          <?php } ?>
          <?php } ?>
        </ul>
        <?php } ?>
      </div>
      <?php } ?>
    </li>
    <?php } ?>
  </ul>
</div>
<?php } ?>
<?php if ($error) { ?>
    
    <div class="warning"><?php echo $error ?><img src="catalog/view/theme/jv/image/close.png" alt="" class="close" /></div>
    
<?php } ?>
<div id="notification"></div>
