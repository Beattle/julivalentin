<!--<?php
    switch(true):
        case $setting['position'] == 'content_top' && $setting['layout_id'] == 1:$grid = 'pure-u-11-47';
            break;
        case $setting['position'] == 'content_left' && $setting['layout_id'] == 1:
        case $setting['position'] == 'content_right' && $setting['layout_id'] == 1:
        $grid ='pure-u-23-47';
            break;
    endswitch;
?>
  <?php foreach ($banners as $banner) { ?>
  <?php if ($banner['link']) { ?>--><div id="banner<?php echo $module; ?>" class="banner <?php echo $grid ?>">
      <div class="l-box">
        <a href="<?php echo $banner['link']; ?>"><img class="pure-img" src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" /></a>
      </div></div><?php } else { ?>--><div id="banner<?php echo $module; ?>" class="banner <?php echo $grid ?>">
        <div class="l-box">
            <img class="pure-img" src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" />
        </div>
    </div><?php } ?><!--<?php } ?>-->