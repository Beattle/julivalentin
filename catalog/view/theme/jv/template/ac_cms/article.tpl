<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<?php // echo '<pre>' . print_r($article_info, true) . '</pre>'; ?>
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
<div id="content" class="article"><?php echo $content_top; ?>
  <h1><?php echo $heading_title; ?></h1>
  <div class="article-info">
      <?php if(!$disable_author || !$disable_create_date || !$disable_cat_list || !$disable_com_count) { ?>
      <div class="info">
        <?php if(!$disable_author) { ?>
         <span class="article-htext"><?php echo $text_author.$username;?></span>
        <?php } ?>
        <?php if(!$disable_create_date) { ?>
         <span class="article-htext"><?php echo $text_created.$date_added; ?></span>
        <?php } ?>
        <?php if($categories && !$disable_cat_list) { ?>
            <span class="article-htext"><?php echo $text_category; ?>&zwj;</span> 
            <?php $c_i=1; foreach ($categories as $category) { ?>
             <?php if($c_count == $c_i || $c_count == 0) { ?>
              <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
             <?php }else{ ?>
              <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a><span class="article-htext">,&nbsp;</span>
             <?php } ?>
            <?php $c_i++; } ?>
        <?php } ?>
      <?php if($allow_comments && !$disable_com_count) { ?>
      <?php if($comment_engine == 0) { ?>
        <a href="<?php echo $comment_href; ?>" class="article-comments"><?php echo $text_comments.$comments; ?></a>
      <?php } elseif($comment_engine == 2) { ?>
        <a class="article-comments" href="<?php echo $href; ?>#disqus_thread"><?php echo $text_comments; ?></a>
      <?php } ?>
      <?php } ?>
      </div>
     <?php } ?>
      <?php if($article_info['image_ac']): ?>
          <div class="main-image">
              <img src="<?php echo $article_info['image_ac'] ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" />
          </div>
      <?php endif; ?>
      <?php if($tags) { ?>
          <div class="tags">
              <?php foreach($tags as $tag): ?>
                  <div  class="tag">
                      <img src="<?php echo $tag['pic']; ?>" title="<?php echo $tag['name']; ?>"/>
                  </div>
              <?php endforeach; ?>
<!--              <span><?php /*echo $text_tags; */?>&nbsp;</span>
              <?php /*$t_i=1; foreach ($tags as $tag) { */?>
                  <?php /*if($c_tags == $t_i || $c_tags == 0) { */?>
                      <a href="<?php /*echo $tag['href']; */?>"><?php /*echo $tag['tag']; */?></a>
                  <?php /*}else{ */?>
                      <a href="<?php /*echo $tag['href']; */?>"><?php /*echo $tag['tag']; */?></a>,&nbsp;
                  <?php /*} */?>
                  --><?php /*$t_i++; } */?>
          </div>
      <?php } ?>
      <div class="intro"><?php echo $intro; ?></div>
      <?php if($description) { ?>
      <div class="description"><?php echo $description; ?></div>
      <?php } ?>
      <?php if((!$disable_mod_date) && ($date_modified)) { ?>
      <div class="last-mod"><?php echo $text_modified.$date_modified; ?></div>
      <?php } ?>
     <?php if(!$disable_fblike) { ?>
      <div id="fb-like">
          <iframe src="//www.facebook.com/plugins/like.php?href=<?php echo $fb_href;?>&amp;send=false&amp;layout=standard&amp;width=450&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font&amp;height=30" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:30px;" allowTransparency="true"></iframe>
      </div>
     <?php } ?>
     <?php if(!$disable_viewed || !$disable_share) { ?>
      <div class="footer-info">
       <?php if(!$disable_viewed) { ?>
        <span class="article-ftext"><?php echo $text_viewed.$viewed; ?></span>
       <?php } ?>
       <?php if(!$disable_share) { ?>
        <span class="article-ftext"><?php echo $text_share; ?></span>
        <div class="share"><!-- AddThis Button BEGIN -->
          <div class="addthis_toolbox addthis_default_style"> <a class="addthis_button_facebook"></a> <a class="addthis_button_twitter"></a><a class="addthis_button_google_plusone_badge" g:plusone:size="small"><a class="addthis_button_email"></a></a><a class="addthis_button_print"></a></div>
          <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js"></script> 
          <!-- AddThis Button END --> 
        </div>
       <?php } ?>
<!--        <span class="article-ftext"><?php echo $text_rss; ?></span>    -->
        <div class="clr"></div>
      </div>
     <?php } ?>

      <?php if($rel_articles) { ?>
      <div class="article-related" >
         <h3><?php echo $text_rel_article; ?></h3>
          <?php foreach($rel_articles as $id => $value) { ?>
          <div>
<!--              <img src="<?php echo (defined('HTTP_IMAGE')) ? HTTP_IMAGE.$rel_articles[$id]['image']:HTTP_SERVER.'image/'.$rel_articles[$id]['image']; ?>" alt="<?php echo $rel_articles[$id]['title']; ?>" />-->
              <a href="<?php echo $rel_articles[$id]['href']; ?>"><?php echo $rel_articles[$id]['title']; ?></a>
          </div>
          <?php } ?>
      </div>
      <?php } ?>
      <?php if($products) { ?>
      <div class="product-related" >
        <h3><?php echo $text_rel_product; ?></h3>
        <div class="box-product">
        <?php foreach ($products as $product) { ?>
        <div>
            <?php if ($product['thumb']) { ?>
            <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
            <?php } ?>
            <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
            <?php if ($product['price']) { ?>
            <div class="price">
            <?php if (!$product['special']) { ?>
            <?php echo $product['price']; ?>
            <?php } else { ?>
            <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
            <?php } ?>
            </div>
            <?php } ?>
            <?php if ($product['rating']) { ?>
            <div class="rating"><img src="catalog/view/theme/default/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
            <?php } ?>
            <a onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button"><span><?php echo $button_cart; ?></span></a></div>
        <?php } ?>
        </div>
      </div>
      <?php } ?>
      <?php if ($allow_comments && $allow_access) { ?>
      <?php if($comment_engine == 1) { ?>
      <fb:comments href="<?php echo $fb_href;?>" width="<?php echo $facebook_width; ?>" num_posts="<?php echo $comment_page_size; ?>"></fb:comments>
      <?php } elseif($comment_engine == 2) { ?>
      <div id="disqus_thread"></div>
      <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
      <a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
      <?php } else { ?>
        <div class="comment-content">
            <a name="comments"></a>
            <h3 id="comments"><?php echo $text_comments.$comments; ?></h3>
            <div id="comment"></div>
            <?php if(!$archive) { ?>
            <h2 id="comment-title"><?php echo $text_write; ?></h2>
            <b><?php echo $entry_name; ?></b><br />
            <input type="text" name="name" value="" />
            <br />
            <br />
            <b><?php echo $entry_comment; ?></b>
            <textarea name="text" cols="40" rows="8" style="width: 98%;"></textarea>
            <span style="font-size: 11px;"><?php echo $text_note; ?></span><br />
            <br />
            <b><?php echo $entry_captcha; ?></b><br />
            <input type="text" name="captcha" value="" />
            <br />
            <img src="index.php?route=ac_cms/article/captcha" alt="" id="captcha" /><br />
            <br />
            <div class="buttons">
            <div class="right"><a id="button-comment" class="button"><span><?php echo $button_add_comment; ?></span></a></div>
            </div>
            <?php } ?>
        </div>
      <?php } ?>
    <?php } ?>
  </div>
  
<?php echo $content_bottom;?></div>
<script type="text/javascript"><!--
    <?php if($allow_comments && $allow_access && $comment_engine == 2 && $disqus_id) { ?>
    /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
    var disqus_shortname = "<?php echo $disqus_id; ?>"; // required: replace example with your forum shortname
    var disqus_identifier = '<?php echo HTTP_SERVER . 'index.php?route=ac_cms/article&b_id=' . $b_id; ?>';
    <?php if(!empty($disqus_force_lang)) { ?>
        var disqus_config = function () {
            this.language = "<?php echo $this->config->get('config_language'); ?>";
            request
        }; 
    <?php } ?>
    /* * * DON'T EDIT BELOW THIS LINE * * */
    (function() {
        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
    })();
    <?php } elseif($allow_comments && $allow_access && $comment_engine == 0) { ?>
    
    $('#comment .pagination a').live('click', function() {
	$('#comment').slideUp('slow');
		
	$('#comment').load(this.href);
	
	$('#comment').slideDown('slow');
	
	return false;
    });			

    $('#comment').load('index.php?route=ac_cms/article/comment&b_id=<?php echo $b_id; ?>');

    $('#button-comment').bind('click', function() {
	$.ajax({
		type: 'POST',
		url: 'index.php?route=ac_cms/article/write&b_id=<?php echo $b_id; ?>',
		dataType: 'json',
		data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'text\']').val()) + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
		beforeSend: function() {
			$('.success, .warning').remove();
			$('#button-comment').attr('disabled', true);
			$('#comment-title').after('<div class="attention"><img src="catalog/view/theme/default/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		complete: function() {
			$('#button-comment').attr('disabled', false);
			$('.attention').remove();
		},
		success: function(data) {
			if (data.error) {
				$('#comment-title').after('<div class="warning">' + data.error + '</div>');
			}
			
			if (data.success) {
				$('#comment-title').after('<div class="success">' + data.success + '</div>');
                                <?php if ($comments_approve) { ?>
				$('#comment').load('index.php?route=ac_cms/article/comment&b_id=<?php echo $b_id; ?>');
                                <?php } ?>
				$('input[name=\'name\']').val('');
				$('textarea[name=\'text\']').val('');
				$('input[name=\'rating\']:checked').attr('checked', '');
				$('input[name=\'captcha\']').val('');
			}
                    }
                });
            });
        <?php } ?>
//--></script> 
<?php echo $footer; ?>