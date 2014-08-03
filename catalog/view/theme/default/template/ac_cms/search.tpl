<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1><?php echo $heading_title; ?></h1>
  <b><?php echo $text_critea; ?></b>
  <div class="content">
    <p><?php echo $entry_search; ?>
      <?php if ($filter_name) { ?>
      <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" />
      <?php } else { ?>
      <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" onclick="this.value = '';" onkeydown="this.style.color = '000000'" style="color: #999;" />
      <?php } ?>
      <select name="filter_bc_id">
        <option value="0"><?php echo $text_category; ?></option>
        <?php foreach ($categories as $category_1) {;?>
        <?php if ($category_1['bc_id'] == $filter_bc_id) { ?>
        <option value="<?php echo $category_1['bc_id']; ?>" selected="selected"><?php echo $category_1['name']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $category_1['bc_id']; ?>"><?php echo $category_1['name']; ?></option>
        <?php } ?>
        <?php foreach ($category_1['children'] as $category_2) { ?>
        <?php if ($category_2['bc_id'] == $filter_bc_id) { ?>
        <option value="<?php echo $category_2['bc_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $category_2['bc_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
        <?php } ?>
        <?php foreach ($category_2['children'] as $category_3) { ?>
        <?php if ($category_3['bc_id'] == $filter_bc_id) { ?>
        <option value="<?php echo $category_3['bc_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $category_3['bc_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
        <?php } ?>
        <?php } ?>
        <?php } ?>
        <?php } ?>
      </select>
      <?php if ($filter_sub_category) { ?>
      <input type="checkbox" name="filter_sub_category" value="1" id="sub_category" checked="checked" />
      <?php } else { ?>
      <input type="checkbox" name="filter_sub_category" value="1" id="sub_category" />
      <?php } ?>
      <label for="sub_category"><?php echo $text_sub_category; ?></label>
    </p>
    <?php if ($filter_description) { ?>
    <input type="checkbox" name="filter_description" value="1" id="description" checked="checked" />
    <?php } else { ?>
    <input type="checkbox" name="filter_description" value="1" id="description" />
    <?php } ?>
    <label for="description"><?php echo $entry_article_description; ?></label>
  </div>
  <div class="buttons">
        <div class="right"><a onclick="searchurl('index.php?route=ac_cms/search', true)" id="button-search" class="button"><span><?php echo $button_search; ?></span></a></div>
        <div class="right"><a onclick="searchurl('index.php?route=product/search', false)" id="button-search-product" class="button"><span><?php echo $text_product_search; ?></span></a>&nbsp;</div>                  
  </div>
  
  <h2><?php echo $text_search_article; ?></h2>
  <?php if ($articles) { ?>
  <div class="article-filter">
    <div class="limit"><?php echo $text_limit; ?>
      <select onchange="location = this.value;">
        <?php foreach ($limits as $limits) { ?>
        <?php if ($limits['value'] == $limit) { ?>
        <option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
        <?php } ?>
        <?php } ?>
      </select>
    </div>
    <div class="sort" style="display: none;"><?php echo $text_sort; ?>
      <select onchange="location = this.value;">
        <?php foreach ($sorts as $sorts) { ?>
        <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
        <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
        <?php } ?>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="article-search">
    <?php foreach ($articles as $article) { ?>
    <div>
      <?php if ($article['thumb']) { ?>
      <div class="image"><a href="<?php echo $article['href']; ?>"><img src="<?php echo $article['thumb']; ?>" title="<?php echo $article['name']; ?>" alt="<?php echo $article['name']; ?>" /></a></div>
      <?php } ?>
      <div class="name"><a href="<?php echo $article['href']; ?>"><?php echo $article['name']; ?></a></div>
      <div class="info"><span><?php echo $text_created.$article['date_added']; ?></span><?php if($article['comment_access']) { ?><?php if($comment_engine==0) { ?><a href="<?php echo $article['href'] . '#comments'; ?>"><?php echo $text_comments.$article['comments']; ?></a><?php } elseif($comment_engine==2) { ?><a class="article-comments" href="#disqus_thread"><?php echo $text_comments; ?></a><?php  }} ?></div>
      <div class="description"><?php echo $article['intro']; ?></div>
      <div class="read-more">
          <a class="button" href="<?php echo $article['href']; ?>"><span><?php echo $text_readmore; ?></span></a>
      </div>
      </div>
    <?php } ?>
  </div>
  <div class="pagination"><?php echo $pagination; ?></div>
  <?php } else { ?>
  <div class="content"><?php echo $text_article_empty; ?></div>
  <?php }?>
  <?php echo $content_bottom; ?></div>
<script type="text/javascript"><!--
$('#content input[name=\'filter_name\']').keydown(function(e) {
	if (e.keyCode == 13) {
		$('#button-search').trigger('click');
	}
});

    function searchurl(url, flag) {
                        
	var search_type = <?php echo $search_type; ?>;
        
        if(search_type == '0')
        {
            var filter_name = $('#content input[name=\'filter_name\']').attr('value');

            if (filter_name) {
                    url += '&filter_name=' + encodeURIComponent(filter_name);
            }

            if(flag)
            {
                var filter_bc_id = $('#content select[name=\'filter_bc_id\']').attr('value');

                if (filter_bc_id > 0) {
                        url += '&filter_bc_id=' + encodeURIComponent(filter_bc_id);
                }
            }

            var filter_sub_category = $('#content input[name=\'filter_sub_category\']:checked').attr('value');

            if (filter_sub_category) {
                    url += '&filter_sub_category=true';
            }

            var filter_description = $('#content input[name=\'filter_description\']:checked').attr('value');

            if (filter_description) {
                    url += '&filter_description=true';
            }
        } else {
            var filter_name = $('#content input[name=\'filter_name\']').attr('value');

            if (filter_name) {
                    url += '&search=' + encodeURIComponent(filter_name);
            }

            if(flag)
            {
                var filter_bc_id = $('#content select[name=\'filter_bc_id\']').attr('value');

                if (filter_bc_id > 0) {
                        url += '&filter_bc_id=' + encodeURIComponent(filter_bc_id);
                }
            }

            var filter_sub_category = $('#content input[name=\'filter_sub_category\']:checked').attr('value');

            if (filter_sub_category) {
                    url += '&sub_category=true';
            }

            var filter_description = $('#content input[name=\'filter_description\']:checked').attr('value');

            if (filter_description) {
                    url += '&description=true';
            }
        }
        
        location = url; 
    }
//--></script> 
<?php echo $footer; ?>