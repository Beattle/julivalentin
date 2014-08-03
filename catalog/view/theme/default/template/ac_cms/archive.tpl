<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1><?php echo $heading_title; ?></h1>
  <div id="archive-filter">
      <?php echo $text_date_start; ?>:&nbsp;<input name="filter_date_from" class="date" type="text" value="<?php echo $filter_date_from; ?>" /> &nbsp;&nbsp;<?php echo $text_date_end; ?>:&nbsp;<input name="filter_date_to" value="<?php echo $filter_date_to; ?>" class="date" type="text" /> <a onclick="filter();" class="button"><span><?php echo $text_filter; ?></span></a>
  </div>
  <?php if ($thumb || $description) { ?>
  <div class="category-info">
    <?php if ($thumb) { ?>
    <div class="image"><img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" /></div>
    <?php } ?>
    <?php if ($description) { ?>
    <?php echo $description; ?>
    <?php } ?>
  </div>
  <?php } ?>
  <?php foreach ($articles as $article) { ?>
   <div class="article-info">
       <h2><a href="<?php echo $article['href']; ?>"><?php echo $article['title']; ?></a></h2>
      <?php if(!$disable_author || !$disable_create_date || !$disable_cat_list || !$disable_com_count) { ?>
       <div class="info">
        <?php if(!$disable_author) { ?>
         <span class="article-htext"><?php echo $text_author.$article['username'];?></span>
        <?php } ?>
        <?php if(!$disable_create_date) { ?>
         <span class="article-htext"><?php echo $text_created.$article['date_added']; ?></span>
        <?php } ?>
        <?php if($article['categories'] && !$disable_cat_list) { ?>
            <span class="article-htext"><?php echo $text_category; ?>&nbsp;</span>
            <?php $c_i=1; foreach ($article['categories'] as $category) { ?>
            <?php if($article['c_count'] == $c_i || $article['c_count'] == 0) { ?>
              <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
            <?php }else{ ?>
              <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a><span class="article-htext">,&nbsp;</span>
            <?php } ?>  
            <?php $c_i++; } ?>
        <?php } ?>
      <?php if ($article['allow_comments'] && !$disable_com_count && $article['comment_access']) { ?>
            <a href="<?php echo $article['href'] . '#comments'; ?>" class="article-comments"><?php echo $text_comments.$article['comments']; ?></a>
      <?php } ?>
      </div>
     <?php } ?>
      <div class="intro"><?php echo $article['intro']; ?></div>
      <?php if((!$disable_mod_date) && ($article['date_modified'])) {?>
      <div class="last-mod"><?php echo $text_modified.$article['date_modified']; ?></div>
      <?php } ?>
      <?php if($article['description']) { ?>
      <div class="read-more">
          <a class="button" href="<?php echo $article['href']; ?>"><span><?php echo $text_readmore; ?></span></a>
      </div>
      <?php } ?>
   </div>
       <?php } ?>
   <?php if (!$articles) { ?>
      <div class="content"><?php echo $text_empty; ?></div>
      <div class="buttons">
        <div class="right"><a href="<?php echo $continue; ?>" class="button"><span><?php echo $button_continue; ?></span></a></div>
      </div>
   <?php } else {?>
      <div class="pagination"><?php echo $pagination; ?></div>
      <?php if($archive) {?>
       <div><a class="button" href="<?php echo $archive_href; ?>"><span><?php echo $text_archive; ?></span></a></div>
      <?php }  ?>
   <?php }  ?>
<?php echo $content_bottom; ?></div>
<script type="text/javascript"><!--
$('document').ready(function(){
   $('.date').datepicker({dateFormat: 'yy-mm-dd'}); 
});


function filter() {
    var url = '<?php echo str_replace('&amp;','&',$archive_href); ?>';
	
	var filter_date_from = $('input[name=\'filter_date_from\']').attr('value');
	
	if (filter_date_from) {
		url += '&filter_date_from=' + encodeURIComponent(filter_date_from);
	}
	
	var filter_date_to = $('input[name=\'filter_date_to\']').attr('value');
	
	if (filter_date_to) {
		url += '&filter_date_to=' + encodeURIComponent(filter_date_to);
	}

	location = url;
}
//--></script> 
<?php echo $footer; ?>