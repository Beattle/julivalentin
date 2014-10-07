<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
    <div class="breadcrumb">
        <?php $last = array_search(end($breadcrumbs), $breadcrumbs); ?>
        <?php foreach ($breadcrumbs as $key => $breadcrumb) { ?>
            <?php if($last !== $key): ?>
                <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
            <?php else: ?>
                <?php echo $breadcrumb['separator']; ?><span class="last-bread"><?php echo $breadcrumb['text']; ?></span>
            <?php endif; ?>
        <?php } ?>
    </div>
<div id="content" class="error-404"><?php echo $content_top; ?>
  <h1><?php echo $heading_title; ?></h1>
  <div class="content"><div class="image-err"> <img src="image/data/404.jpg" alt="404" /></div> </div>
  <!--<div class="buttons">
    <div class="right"><a href="<?php /*echo $continue; */?>" class="button"><?php /*echo $button_continue; */?></a></div>
  </div>-->
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>