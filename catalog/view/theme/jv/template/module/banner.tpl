<?php
$title = false;
switch(true):
    case $setting['position'] == 'content_top' && $setting['layout_id'] == 1:$title = true;
        break;
endswitch;
?>
<?php foreach ($banners as $banner) { ?>
  <?php if ($banner['link']) { ?>
    <div id="banner<?php echo $module; ?>" class="banner">
      <div class="l-box">
        <a href="<?php echo $banner['link']; ?>">
            <img class="pure-img" src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" />
            <?php if($title) :?>
            <span class="title"><?php echo $banner['title']; ?></span>
            <?php endif; ?>
        </a>
      </div>
    </div>
    <?php } else { ?>
    <div id="banner<?php echo $module; ?>" class="banner">
        <div class="l-box">
            <img class="pure-img" src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" />
            <?php if($title) :?>
                <span class="title"><?php echo $banner['title']; ?></span>
            <?php endif; ?>
        </div>
    </div>
    <?php } ?>
    <?php } ?>