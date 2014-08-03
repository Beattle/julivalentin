<?php echo $header; ?>
<div id="content">
<div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
  <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
</div>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="heading">
    <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
    <div class="buttons">
        <a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a>
        <a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a>
    </div>
  </div>
  <div class="content">
      <span><?php echo $entry_store ?></span> <select style="margin: 10px 0 10px 0; padding: 5px;" onchange="location = this.value;">
        <?php foreach($stores as $store_name => $value) { ?>
         <?php if($store_href == $value['href']) { ?>
         <option selected="selected" value="<?php echo $value['href']; ?>"><?php echo $store_name; ?></option>
         <?php } else { ?>
         <option value="<?php echo $value['href']; ?>"><?php echo $store_name; ?></option>
         <?php } ?>
        <?php } ?>
    </select>
    <div id="tabs" class="htabs">
        <a href="#tab-general"><?php echo $tab_general; ?></a>
        <a href="#tab-data"><?php echo $tab_data; ?></a>
    </div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <div id="tab-general">
          <div id="languages" class="htabs">
            <?php foreach ($languages as $language) { ?>
            <a href="#language<?php echo $language['language_id']; ?>"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
            <?php } ?>
         </div>
          <?php foreach ($languages as $language) { ?>
           <div id="language<?php echo $language['language_id']; ?>">
            <table class="form">
              <tr>
                <td><span class="required">*</span> <?php echo $entry_blog_name; ?></td>
                <td><input type="text" name="ac_cms_gs_<?php echo $store_id; ?>[desc][<?php echo $language['language_id']; ?>][blog_name]" size="100" value="<?php echo isset($ac_cms_gs['desc'][$language['language_id']]) ? $ac_cms_gs['desc'][$language['language_id']]['blog_name'] : ''; ?>" />
                  <?php if (isset($error_blog_name[$language['language_id']])) { ?>
                  <span class="error"><?php echo $error_blog_name[$language['language_id']]; ?></span>
                  <?php } ?>
                </td>
              </tr>
              <tr>
                <td><?php echo $entry_meta_description; ?></td>
                <td><textarea style="width: 99%" name="ac_cms_gs_<?php echo $store_id; ?>[desc][<?php echo $language['language_id']; ?>][meta_description]" cols="40" rows="5"><?php echo isset($ac_cms_gs['desc'][$language['language_id']]) ? $ac_cms_gs['desc'][$language['language_id']]['meta_description'] : ''; ?></textarea></td>
              </tr>
              <tr>
                <td><?php echo $entry_meta_keywords; ?></td>
                <td><textarea style="width: 99%" name="ac_cms_gs_<?php echo $store_id; ?>[desc][<?php echo $language['language_id']; ?>][meta_keyword]" cols="40" rows="5"><?php echo isset($ac_cms_gs['desc'][$language['language_id']]) ? $ac_cms_gs['desc'][$language['language_id']]['meta_keyword'] : ''; ?></textarea></td>
             </tr>
            </table>
          </div>
        <?php } ?>
      </div>
      <div id="tab-data">
          <table class="form">
              <tr colspan="2" ><td style="height: 50px; font-size: 14px; font-weight: bold;"><?php echo $text_blog; ?></td></tr>
              <tr>
                  <td><?php echo $entry_blog_rss; ?></td>
                  <td><select name="ac_cms_gs_<?php echo $store_id; ?>[blog_rss]">
                      <?php if ($blog_rss) { ?>
                      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                      <option value="0"><?php echo $text_disabled; ?></option>
                      <?php } else { ?>
                      <option value="1"><?php echo $text_enabled; ?></option>
                      <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                      <?php } ?>
                    </select>
                   </td>
              </tr>
              <tr colspan="2" ><td style="height: 50px; font-size: 14px; font-weight: bold;"><?php echo $text_article; ?></td></tr>
              <tr>
                <td><?php echo $entry_page_size; ?></td>
                <td><input type="text" size="6" name="ac_cms_gs_<?php echo $store_id; ?>[page_size]" value="<?php echo $page_size; ?>" /></td>
              </tr> 
              <tr>
                <td><?php echo $entry_comment_page_size; ?></td>
                <td><input type="text" size="6" name="ac_cms_gs_<?php echo $store_id; ?>[comment_page_size]" value="<?php echo $comment_page_size; ?>" /></td>
              </tr> 
              <tr>
                  <td><?php echo $entry_disable_author; ?></td>
                  <td>
                    <?php if ($disable_author) { ?>
                      <input type="checkbox" name="ac_cms_gs_<?php echo $store_id; ?>[disable_author]" value="1" checked="checked" />
                      <?php } else { ?>
                      <input type="checkbox" name="ac_cms_gs_<?php echo $store_id; ?>[disable_author]" value="1" />
                    <?php } ?>
                  </td>
              </tr>
              <tr>
                  <td><?php echo $entry_disable_mod_date; ?></td>
                  <td>
                    <?php if ($disable_mod_date) { ?>
                      <input type="checkbox" name="ac_cms_gs_<?php echo $store_id; ?>[disable_mod_date]" value="1" checked="checked" />
                      <?php } else { ?>
                      <input type="checkbox" name="ac_cms_gs_<?php echo $store_id; ?>[disable_mod_date]" value="1" />
                    <?php } ?>
                  </td>
              </tr>
              <tr>
                  <td><?php echo $entry_disable_create_date; ?></td>
                  <td>
                    <?php if ($disable_create_date) { ?>
                      <input type="checkbox" name="ac_cms_gs_<?php echo $store_id; ?>[disable_create_date]" value="1" checked="checked" />
                      <?php } else { ?>
                      <input type="checkbox" name="ac_cms_gs_<?php echo $store_id; ?>[disable_create_date]" value="1" />
                    <?php } ?>
                  </td>
                  
              </tr>
              <tr>
                  <td><?php echo $entry_disable_cat_list; ?></td>
                  <td>
                    <?php if ($disable_cat_list) { ?>
                      <input type="checkbox" name="ac_cms_gs_<?php echo $store_id; ?>[disable_cat_list]" value="1" checked="checked" />
                      <?php } else { ?>
                      <input type="checkbox" name="ac_cms_gs_<?php echo $store_id; ?>[disable_cat_list]" value="1" />
                    <?php } ?>
                  </td>
                  
              </tr>
              <tr>
                  <td><?php echo $entry_disable_com_count; ?></td>
                  <td>
                    <?php if ($disable_com_count) { ?>
                      <input type="checkbox" name="ac_cms_gs_<?php echo $store_id; ?>[disable_com_count]" value="1" checked="checked" />
                      <?php } else { ?>
                      <input type="checkbox" name="ac_cms_gs_<?php echo $store_id; ?>[disable_com_count]" value="1" />
                    <?php } ?>
                  </td>
              </tr>
              <tr>
                  <td><?php echo $entry_disable_share; ?></td>
                  <td>
                    <?php if ($disable_share) { ?>
                      <input type="checkbox" name="ac_cms_gs_<?php echo $store_id; ?>[disable_share]" value="1" checked="checked" />
                      <?php } else { ?>
                      <input type="checkbox" name="ac_cms_gs_<?php echo $store_id; ?>[disable_share]" value="1" />
                    <?php } ?>
                  </td>
              </tr>
              <tr>
                  <td><?php echo $entry_disable_fblike; ?></td>
                  <td>
                    <?php if ($disable_fblike) { ?>
                      <input type="checkbox" name="ac_cms_gs_<?php echo $store_id; ?>[disable_fblike]" value="1" checked="checked" />
                      <?php } else { ?>
                      <input type="checkbox" name="ac_cms_gs_<?php echo $store_id; ?>[disable_fblike]" value="1" />
                    <?php } ?>
                  </td>
              </tr>
              <tr>
                  <td><?php echo $entry_disable_viewed; ?></td>
                  <td>
                    <?php if ($disable_viewed) { ?>
                      <input type="checkbox" name="ac_cms_gs_<?php echo $store_id; ?>[disable_viewed]" value="1" checked="checked" />
                      <?php } else { ?>
                      <input type="checkbox" name="ac_cms_gs_<?php echo $store_id; ?>[disable_viewed]" value="1" />
                    <?php } ?>
                  </td>
              </tr>
                             <tr colspan="2" ><td style="height: 50px; font-size: 14px; font-weight: bold;"><?php echo $text_comment; ?></td></tr>
               <tr>
                  <td><?php echo $entry_comment_engine; ?></td>
                  <td><select id="comment_engine" name="ac_cms_gs_<?php echo $store_id; ?>[comment_engine]">
                      <?php if ($comment_engine == 1) { ?>
                      <option value="0"><?php echo 'AC CMS'; ?></option>
                      <option value="1" selected="selected"><?php echo 'Facebook' ?></option>
                      <option value="2"><?php echo 'Disqus'; ?></option>
                      <?php } elseif($comment_engine == 2) { ?>
                      <option value="0"><?php echo 'AC CMS'; ?></option>
                      <option value="1"><?php echo 'Facebook' ?></option>
                      <option value="2" selected="selected"><?php echo 'Disqus'; ?></option>
                      <?php } else { ?>
                      <option value="0" selected="selected"><?php echo 'AC CMS'; ?></option>
                      <option value="1"><?php echo 'Facebook' ?></option>
                      <option value="2"><?php echo 'Disqus'; ?></option>
                      <?php } ?>
                    </select>
                   </td>
              </tr>
              <tr class="yfb">
                <td><?php echo $entry_facebook_admins; ?></td>
                <td><input type="text" size="50" name="ac_cms_gs_<?php echo $store_id; ?>[facebook_admins]" value="<?php echo $facebook_admins; ?>" /></td>
              </tr>
              <tr class="yfb">
                <td><?php echo $entry_facebook_width; ?></td>
                <td><input type="text" size="6" name="ac_cms_gs_<?php echo $store_id; ?>[facebook_width]" value="<?php echo $facebook_width; ?>" />px</td>
              </tr>
              <tr class="ydq ybi">
                  <td><?php echo $entry_disable_com_count; ?></td>
                  <td>
                    <?php if ($disable_com_count) { ?>
                      <input type="checkbox" name="ac_cms_gs_<?php echo $store_id; ?>[disable_com_count]" value="1" checked="checked" />
                      <?php } else { ?>
                      <input type="checkbox" name="ac_cms_gs_<?php echo $store_id; ?>[disable_com_count]" value="1" />
                    <?php } ?>
                  </td>
              </tr>
              <tr class="ydq">
                <td><?php echo $entry_disqus_id; ?></td>
                <td><input type="text" size="6" name="ac_cms_gs_<?php echo $store_id; ?>[disqus_id]" value="<?php echo $disqus_id; ?>" /></td>
              </tr>
              <tr class="ydq">
                  <td><?php echo $entry_disqus_force_lang; ?></td>
                  <td>
                    <?php if ($disqus_force_lang) { ?>
                      <input type="checkbox" name="ac_cms_gs_<?php echo $store_id; ?>[disqus_force_lang]" value="1" checked="checked" />
                      <?php } else { ?>
                      <input type="checkbox" name="ac_cms_gs_<?php echo $store_id; ?>[disqus_force_lang]" value="1" />
                    <?php } ?>
                  </td>
              </tr>
              <tr class="ybi yfb">
                <td><?php echo $entry_comment_page_size; ?></td>
                <td><input type="text" size="6" name="ac_cms_gs_<?php echo $store_id; ?>[comment_page_size]" value="<?php echo $comment_page_size; ?>" /></td>
              </tr> 
          </table>
      </div>
      </form>
  </div>
 </div>
</div>
<?php echo $footer; ?>
<script type="text/javascript"><!--
commentEngine();
function commentEngine(){
    var engine = $('#comment_engine :selected').val();
    switch(engine){
        case('1'):
            $('.ydq').hide();
            $('.ybi').hide();
            $('.yfb').show();
            break;
        case('2'):
            $('.ybi').hide();
            $('.yfb').hide();
            $('.ydq').show();
            break;
        default:
            $('.yfb').hide();
            $('.ydq').hide();
            $('.ybi').show();
            break;
    }
}
$('#comment_engine').change(function(){
    commentEngine();
});
$('#tabs a').tabs(); 
$('#languages a').tabs();
//--></script>
