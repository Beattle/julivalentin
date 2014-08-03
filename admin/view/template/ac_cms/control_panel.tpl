<?php echo $header; ?>
<style type="text/css">
    ul.control-panel{
        padding-left: 0px;
        list-style: none;
        width: 600px;
        float:left;
    }
    
    ul.control-panel li{
        display:inline;
        float: left;
        margin-bottom: 10px;
        margin-right: 5px;
        width: 160px;
    }
    
    ul.control-panel li a{
        display:block;
    }
    
    ul.control-panel li {
        text-align: center;
        padding: 5px;
    }
    ul.control-panel li:hover {
        background-color: #f3f3f3;
    }
    .accms_logo{
        text-align: center;
        float: right;
        padding: 70px 10% 0 0;
    }
    
</style>
<div id="content">
<div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
  <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
</div>
<?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
<div class="box">
  <div class="heading">
    <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
  </div>
  <div class="content">
      <ul class="control-panel">
          <li>   
           <a href="<?php echo $new_article_url; ?>">
            <span>
             <img src="view/image/ac_cms/article_add.png" /><br />
             <?php echo $text_new_article; ?>
            </span>
           </a>
          </li>
          <li>   
           <a href="<?php echo $manage_articles_url; ?>">
            <span>
             <img src="view/image/ac_cms/article.png" /><br />
             <?php echo $text_manage_articles; ?>
            </span>
           </a>
          </li>
          <li>   
           <a href="<?php echo $manage_category_url; ?>">
            <span>
             <img src="view/image/ac_cms/category.png" /><br />
             <?php echo $text_manage_categories; ?>
            </span>
           </a>
          </li>
          <li>   
           <a href="<?php echo $manage_comment_url; ?>">
            <span>
             <img src="view/image/ac_cms/comment.png" /><br />
             <?php echo $text_manage_comments; ?>
            </span>
           </a>
          </li>
          <li>   
           <a href="<?php echo $manage_article_set_url; ?>">
            <span>
             <img src="view/image/ac_cms/article_set.png" /><br />
             <?php echo $text_manage_article_sets; ?>
            </span>
           </a>
          </li>
          <li>   
           <a href="<?php echo $place_your_set_url; ?>">
            <span>
             <img src="view/image/ac_cms/place_article_set.png" /><br />
             <?php echo $text_place_article_set; ?>
            </span>
           </a>
          </li>
          <li>   
           <a href="<?php echo $manage_menu_url; ?>">
            <span>
             <img src="view/image/ac_cms/menu.png" /><br />
             <?php echo $text_manage_menu; ?>
            </span>
           </a>
          </li>
          <li>   
           <a href="<?php echo $category_module_url; ?>">
            <span>
             <img src="view/image/ac_cms/category_module.png" /><br />
             <?php echo $text_category_module; ?>
            </span>
           </a>
          </li>
          <li>   
           <a href="<?php echo $manage_global_settings_url; ?>">
            <span>
             <img src="view/image/ac_cms/global_settings.png" /><br />
             <?php echo $text_global_settings; ?>
            </span>
           </a>
          </li>
      </ul>
      <div class="accms_logo"><a target="_blank" href="http://www.ac-cms.artcorner.hu"><img src="view/image/ac_cms.png" /></a><br/>
          <span style="font-size:11px;">AC CMS v2.3</span><br/>
      </div>
      <div style="clear:both;" ></div>
  </div>
</div>

<?php echo $footer; ?>