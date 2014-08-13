<?php // echo '<pre>' . print_r($articles, true) . '</pre>'; ?>
<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
            <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
    </div>
<div id="content" class="category"><?php echo $content_top; ?>
  <?php if($rss) { ?>
    <div class="ac-rss-feed-icon"><a href="<?php echo $rss_href; ?>"><img src="<?php echo (defined('HTTP_IMAGE')) ? HTTP_IMAGE.'data/rss_feed.png':HTTP_SERVER . 'image/data/rss_feed.png' ;?>" alt="rss_feed" ></a></div>
  <?php } ?>
  <h1><?php echo $heading_title; ?></h1>
    <section class="category-content">
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
  <?php $last = array_search(end($articles),$articles); ?>
  <?php foreach ($articles as $key => $article) { ?>
   <div  class="article-info<?php if($key == $last) echo ' last'; ?>">
       <?php if($article['image']):?>
           <div class="article-image">
               <a href="<?php echo $article['href'] ?>" title="<?php echo $article['title'] ?>">
                   <img src="<?php echo 'image/'.$article['image'] ?>"alt="<?php echo $article['title']; ?>"/>
               </a>
           </div>
       <?php endif;?>
       <h2><a href="<?php echo $article['href']; ?>"><?php echo $article['title']; ?></a></h2>
       <?php  if($article['tags']): ?>
           <div class="tags">
               <?php foreach($article['tags'] as $tag): ?>
                   <div  class="tag">
                       <img src="<?php echo $tag['pic']; ?>" title="<?php echo $tag['name']; ?>"/>
                   </div>
               <?php endforeach; ?>
           </div>
       <?php endif;?>
      <?php if(!$disable_author || !$disable_create_date || !$disable_cat_list || !$disable_com_count) { ?>
       <div class="info">
        <?php if(!$disable_author) { ?>
         <span class="article-htext"><?php echo $text_author.$article['username'];?></span>
        <?php } ?>
        <?php if(!$disable_create_date) { ?>
         <span class="article-htext"><?php echo $text_created.$article['date_added']; ?></span>
        <?php } ?>
        <?php if($article['categories'] && !$disable_cat_list) { ?>
            <span class="article-htext"><?php echo $text_category; ?>&zwj;</span> 
            <?php $c_i=1; foreach ($article['categories'] as $category) { ?>
            <?php if($article['c_count'] == $c_i || $article['c_count'] == 0) { ?>
              <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
            <?php }else{ ?>
              <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a><span class="article-htext">,&nbsp;</span>
            <?php } ?>  
            <?php $c_i++; } ?>
        <?php } ?>
      <?php if ($article['allow_comments'] && !$disable_com_count && $article['comment_access']) { ?>
        <?php if($comment_engine == 0) { ?>
        <a href="<?php echo $article['href'] . '#comments'; ?>" class="article-comments"><?php echo $text_comments.$article['comments']; ?></a>
        <?php } elseif($comment_engine == 2) { ?>
        <a class="article-comments" href="<?php echo $article['href']?>#disqus_thread"><?php echo $text_comments; ?></a>
      <?php } ?>
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
      <?php if(!empty($archive)) {?>
       <div><a class="button" href="<?php echo $archive_href; ?>"><span><?php echo $text_archive; ?></span></a></div>
      <?php }  ?>
   <?php }  ?>
  </section>
<?php echo $content_bottom; ?></div>
<?php echo $footer; ?>