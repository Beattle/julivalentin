<?php echo $header; ?>
<style>
    #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
    #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; color:#666666; }
    #sortable li span { position: absolute; margin-left: -1.3em; }
    span.hint { color: #666666; }
    
    .alt-heading{
        position: fixed;
        top: 0;
        left: 30px;
        right: 30px;
        border-radius: 0px!important;
    }
    .info-alt .success, .info-alt .warning{
        top:50%;
        left:37.5%;  
        position: fixed; 
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
<div class="box">
  <div class="heading">
    <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
    <div class="buttons">
        <a onclick="apply_submit()" class="button"><span><?php echo $button_apply; ?></span></a>
        <a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a>
        <a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a>
    </div>
  </div>
  <div class="heading alt-heading" style="display:none;">
    <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
    <div class="buttons">
        <a onclick="apply_submit()" class="button"><span><?php echo $button_apply; ?></span></a>
        <a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a>
        <a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a>
    </div>
  </div>
  <div class="info-alt">
        <div class="success" style="display:none;"></div>
        <div class="warning" style="display:none;"><?php echo $error_warning; ?></div>
  </div>
  <div class="content">
    <div id="tabs" class="htabs">
        <a href="#tab-general"><?php echo $tab_general; ?></a>
        <a href="#tab-data"><?php echo $tab_data; ?></a>
    </div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
          <input name="set_id" id="set_id" type="hidden" value="<?php echo $bs_id; ?>" />
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
                <td><span class="required">*</span> <?php echo $entry_as_title; ?></td>
                <td><input type="text" name="article_set_description[<?php echo $language['language_id']; ?>][title]" size="100" value="<?php echo isset($article_set_description[$language['language_id']]) ? $article_set_description[$language['language_id']]['title'] : ''; ?>" />
                  <?php if (isset($error_title[$language['language_id']])) { ?>
                  <span class="error"><?php echo $error_title[$language['language_id']]; ?></span>
                  <?php } ?>
                </td>
              </tr>
            </table>
          </div>
        <?php } ?>
      </div>
      <div id="tab-data">
          <table class="form">
              <tr>
                  <td><?php echo $entry_display_type; ?></td>
                  <td>
                      <select id="display_type" name="display_type">
                          <?php foreach($display_types as $t_key => $type) { ?>
                          <?php if($t_key == $display_type) { ?>
                          <option value="<?php echo $t_key; ?>" selected="selected"><?php echo $type; ?></option>
                          <?php } else { ?>
                          <option value="<?php echo $t_key; ?>"><?php echo $type; ?></option>
                          <?php } ?>
                          <?php } ?>
                       </select>
                  </td>
              </tr>
              <tr>
                  <td><?php echo $entry_select_cat; ?></td>
                  <td><div class="scrollbox">
                      <?php $class = 'odd'; ?>
                      <?php foreach ($categories as $category) { ?>
                      <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                      <div class="<?php echo $class; ?>">
                        <?php if (in_array($category['bc_id'], $set_category)) { ?>
                        <input type="checkbox" name="settings[set_category][]" value="<?php echo $category['bc_id']; ?>" checked="checked" />
                        <?php echo $category['name']; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="settings[set_category][]" value="<?php echo $category['bc_id']; ?>" />
                        <?php echo $category['name']; ?>
                        <?php } ?>
                      </div>
                      <?php } ?>
                    </div>
                    <a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a>
                  </td>
              </tr>
              <tr class="class_4">
                  <td><?php echo $entry_select_art; ?></td>
                  <td><input type="text" id="rel_article" name="rel_article" value="" /></td>
              </tr>
              <tr class="class_4">
                  <td>&nbsp;</td>
                  <td><div class="scrollbox" id="article-related">
                      <?php $class = 'odd'; ?>
                      <?php foreach ($article_related as $article_related) { ?>
                      <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                      <div id="article-related<?php echo $article_related['b_id']; ?>" class="<?php echo $class; ?>"> <?php echo $article_related['title']; ?><img src="view/image/delete.png" />
                        <input type="hidden" name="settings[article_related][]" value="<?php echo $article_related['b_id']; ?>" />
                      </div>
                      <?php } ?>
                    </div>
                  </td>
              </tr>
<!--              <tr>
                  <td><?php echo $entry_column_width; ?></td>
                  <td><input type="text" size="6" name="settings[column_width]" value="<?php echo $column_width; ?>" /><span class="hint">%</span></td>
              </tr>-->
              <tr class="class_1 class_2">
                  <td><?php echo $entry_lead_art_amount; ?></td>
                  <td><input type="text" size="6" name="settings[lead_art_amount]" value="<?php echo $lead_art_amount; ?>" /></td>
              </tr>
              <tr>
                  <td><?php echo $entry_art_amount; ?></td>
                  <td><input type="text" size="6" name="settings[art_amount]" value="<?php echo $art_amount; ?>" /></td>
              </tr>
              <tr>
                  <td><?php echo $entry_sort_by; ?></td>
                  <td>
                      <select name="settings[sort_by]">
                          <?php if ($sort_by) { ?>
                          <option value="0" <?php if ($sort_by == '0') echo 'selected="selected"'; ?> ><?php echo $text_sort_by_title; ?></option>
                          <option value="1" <?php if ($sort_by == '1') echo 'selected="selected"'; ?> ><?php echo $text_sort_by_author; ?></option>
                          <option value="2" <?php if ($sort_by == '2') echo 'selected="selected"'; ?> ><?php echo $text_sort_by_viewed; ?></option>
                          <option value="3" <?php if ($sort_by == '3') echo 'selected="selected"'; ?> ><?php echo $text_sort_by_art_so; ?></option>
                          <option value="4" <?php if ($sort_by == '4') echo 'selected="selected"'; ?> ><?php echo $text_sort_by_modate; ?></option>
                          <option value="5" <?php if ($sort_by == '5') echo 'selected="selected"'; ?> ><?php echo $text_sort_by_crdate; ?></option>
                          <?php } else { ?>
                          <option value="0" selected="selected"><?php echo $text_sort_by_title ?></option>
                          <option value="1"><?php echo $text_sort_by_author ?></option>
                          <option value="2"><?php echo $text_sort_by_viewed; ?></option>
                          <option value="3"><?php echo $text_sort_by_art_so; ?></option>
                          <option value="4"><?php echo $text_sort_by_modate; ?></option>
                          <option value="5"><?php echo $text_sort_by_crdate; ?></option>
                          <?php } ?>
                       </select>
                  </td>
              </tr>
              <tr>
                  <td><?php echo $entry_sort_order; ?></td>
                  <td>
                      <select name="settings[sort_order]">
                          <?php if ($sort_order) { ?>
                          <option value="1" selected="selected"><?php echo $text_desc; ?></option>
                          <option value="0"><?php echo $text_asc; ?></option>
                          <?php } else { ?>
                          <option value="1"><?php echo $text_desc; ?></option>
                          <option value="0" selected="selected"><?php echo $text_asc; ?></option>
                          <?php } ?>
                       </select>
                  </td>
              </tr>
              <tr class="class_1 class_2">
                  <td><?php echo $entry_art_columns; ?></td>
                  <td><input type="text" size="6" name="settings[art_columns]" value="<?php echo $art_columns; ?>" /></td>
              </tr>
<!--              <tr>
                  <td><?php echo $entry_allow_paging; ?></td>
                  <td>
                    <?php if ($allow_paging) { ?>
                      <input type="checkbox" name="settings[allow_paging]" value="1" checked="checked" />
                      <?php } else { ?>
                      <input type="checkbox" name="settings[allow_paging]" value="1" />
                    <?php } ?>
                  </td>
              </tr>
              <tr>
                  <td><?php echo $entry_page_size; ?></td>
                  <td><input type="text" size="6" name="settings[page_size]" value="<?php echo $page_size; ?>" /></td>
              </tr>-->
              <tr class="class_1">
                  <td><?php echo $entry_position; ?></td>
                  <td> 
                    <div class="position-sort">
                     <ul id="sortable">
                         <?php if (!empty($sort_array)) {?>
                          <?php foreach ($sort_array as $value) {?>
                            <?php if ($value == 'title') {?>
                                    <li id="title" class="ui-state-default class_2"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo $entry_title_position; ?></li>
                            <?php } ?>
                            <?php if ($value == 'info') {?>
                                    <li id="info" class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo $entry_info_position; ?></li>
                            <?php } ?>
                            <?php if ($value == 'image') {?>
                                    <li id="image" class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo $entry_image_position; ?></li>
                            <?php } ?>
                            <?php if ($value == 'text') {?>
                                    <li id="text" class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo $entry_text_position; ?></li>
                            <?php } ?>
                            <?php if ($value == 'r_more') {?>
                                    <li id="r_more" class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo $entry_readmore_position; ?></li>
                            <?php } ?>
                          <?php } ?>
                         <?php } else { ?>
                                <li id="title" class="ui-state-default class_2"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo $entry_title_position; ?></li>
                                <li id="info" class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo $entry_info_position; ?></li>
                                <li id="image" class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo $entry_image_position; ?></li>
                                <li id="text" class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo $entry_text_position; ?></li>
                                <li id="r_more" class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo $entry_readmore_position; ?></li>
                         <?php } ?>
                        
                     </ul>
                    </div>
                      <input id="sort" name="settings[sort]" type="hidden" value="<?php echo $sort; ?>" />
                  </td>
              </tr>
              <tr class="class_2">
                  <td><?php echo $entry_title_order; ?></td>
                  <td>
                      <select name="settings[title_order]">
                          <?php if ($title_order) { ?>
                          <option value="0" <?php if ($title_order == '0') echo 'selected="selected"'; ?> ><?php echo $text_disabled; ?></option>
                          <option value="1" <?php if ($title_order == '1') echo 'selected="selected"'; ?> ><?php echo $text_left; ?></option>
                          <option value="2" <?php if ($title_order == '2') echo 'selected="selected"'; ?> ><?php echo $text_right; ?></option>
                          <option value="3" <?php if ($title_order == '3') echo 'selected="selected"'; ?> ><?php echo $text_center; ?></option>
                          <?php } else { ?>
                          <option value="0" selected="selected"><?php echo $text_disabled ?></option>
                          <option value="1"><?php echo $text_left ?></option>
                          <option value="2"><?php echo $text_right; ?></option>
                          <option value="3"><?php echo $text_center; ?></option>
                          <?php } ?>
                       </select>
                  </td>
              </tr>
              <tr class="class_1">
                  <td><?php echo $entry_info_order; ?></td>
                  <td>
                      <select name="settings[info_order]">
                          <?php if ($info_order) { ?>
                          <option value="0" <?php if ($info_order == '0') echo 'selected="selected"'; ?> ><?php echo $text_disabled;; ?></option>
                          <option value="1" <?php if ($info_order == '1') echo 'selected="selected"'; ?> ><?php echo $text_left; ?></option>
                          <option value="2" <?php if ($info_order == '2') echo 'selected="selected"'; ?> ><?php echo $text_right; ?></option>
                          <option value="3" <?php if ($info_order == '3') echo 'selected="selected"'; ?> ><?php echo $text_center; ?></option>
                          <?php } else { ?>
                          <option value="0" selected="selected"><?php echo $text_disabled ?></option>
                          <option value="1"><?php echo $text_left ?></option>
                          <option value="2"><?php echo $text_right; ?></option>
                          <option value="3"><?php echo $text_center; ?></option>
                          <?php } ?>
                       </select>
                  </td>
              </tr>
              <tr class="class_1">
                  <td><?php echo $entry_image_order; ?></td>
                  <td>
                      <select name="settings[image_order]">
                          <?php if ($image_order) { ?>
                          <option value="0" <?php if ($image_order == '0') echo 'selected="selected"'; ?> ><?php echo $text_disabled; ?></option>
                          <option value="1" <?php if ($image_order == '1') echo 'selected="selected"'; ?> ><?php echo $text_left; ?></option>
                          <option value="2" <?php if ($image_order == '2') echo 'selected="selected"'; ?> ><?php echo $text_right; ?></option>
                          <option value="3" <?php if ($image_order == '3') echo 'selected="selected"'; ?> ><?php echo $text_center; ?></option>
                          <?php } else { ?>
                          <option value="0" selected="selected"><?php echo $text_disabled ?></option>
                          <option value="1"><?php echo $text_left ?></option>
                          <option value="2"><?php echo $text_right; ?></option>
                          <option value="3"><?php echo $text_center; ?></option>
                          <?php } ?>
                       </select>
                  </td>
              </tr>
              <tr>
                  <td><?php echo $entry_text_order; ?></td>
                  <td>
                      <select name="settings[text_order]">
                          <?php if ($text_order) { ?>
                          <option value="0" <?php if ($text_order == '0') echo 'selected="selected"'; ?> ><?php echo $text_disabled; ?></option>
                          <option value="1" <?php if ($text_order == '1') echo 'selected="selected"'; ?> ><?php echo $text_left; ?></option>
                          <option value="2" <?php if ($text_order == '2') echo 'selected="selected"'; ?> ><?php echo $text_right; ?></option>
                          <option value="3" <?php if ($text_order == '3') echo 'selected="selected"'; ?> ><?php echo $text_center; ?></option>
                          <option value="4" <?php if ($text_order == '4') echo 'selected="selected"'; ?> ><?php echo $text_justify; ?></option>
                          <?php } else { ?>
                          <option value="0" selected="selected"><?php echo $text_disabled ?></option>
                          <option value="1"><?php echo $text_left ?></option>
                          <option value="2"><?php echo $text_right; ?></option>
                          <option value="3"><?php echo $text_center; ?></option>
                          <option value="4"><?php echo $text_justify; ?></option>
                          <?php } ?>
                       </select>
                  </td>
              </tr>
              <tr class="class_1">
                  <td><?php echo $entry_readmore_order; ?></td>
                  <td>
                      <select name="settings[readmore_order]">
                          <?php if ($readmore_order) { ?>
                          <option value="0" <?php if ($readmore_order == '0') echo 'selected="selected"'; ?> ><?php echo $text_disabled; ?></option>
                          <option value="1" <?php if ($readmore_order == '1') echo 'selected="selected"'; ?> ><?php echo $text_left; ?></option>
                          <option value="2" <?php if ($readmore_order == '2') echo 'selected="selected"'; ?> ><?php echo $text_right; ?></option>
                          <option value="3" <?php if ($readmore_order == '3') echo 'selected="selected"'; ?> ><?php echo $text_center; ?></option>
                          <?php } else { ?>
                          <option value="0" selected="selected"><?php echo $text_disabled ?></option>
                          <option value="1"><?php echo $text_left ?></option>
                          <option value="2"><?php echo $text_right; ?></option>
                          <option value="3"><?php echo $text_center; ?></option>
                          <?php } ?>
                       </select>
                  </td>
              </tr>
              <tr>
                  <td><?php echo $entry_text_as_link; ?></td>
                  <td>
                    <?php if ($text_as_link) { ?>
                      <input type="checkbox" name="settings[text_as_link]" value="1" checked="checked" />
                      <?php } else { ?>
                      <input type="checkbox" name="settings[text_as_link]" value="1" />
                    <?php } ?>
                  </td>
                  
              </tr>
              <tr>
                  <td><?php echo $entry_image_as_link; ?></td>
                  <td>
                    <?php if ($image_as_link) { ?>
                      <input type="checkbox" name="settings[image_as_link]" value="1" checked="checked" />
                      <?php } else { ?>
                      <input type="checkbox" name="settings[image_as_link]" value="1" />
                    <?php } ?>
                  </td>
                  
              </tr>
              <tr class="class_2 class_title_as_link">
                  <td><?php echo $entry_title_as_link; ?></td>
                  <td>
                    <?php if ($title_as_link) { ?>
                      <input type="checkbox" name="settings[title_as_link]" value="1" checked="checked" />
                      <?php } else { ?>
                      <input type="checkbox" name="settings[title_as_link]" value="1" />
                    <?php } ?>
                  </td>
                  
              </tr>
              <tr class="class_1">
                  <td><?php echo $entry_disable_author; ?></td>
                  <td>
                    <?php if ($disable_author) { ?>
                      <input type="checkbox" name="settings[disable_author]" value="1" checked="checked" />
                      <?php } else { ?>
                      <input type="checkbox" name="settings[disable_author]" value="1" />
                    <?php } ?>
                  </td>
              </tr>
              <tr class="class_1">
                  <td><?php echo $entry_disable_mod_date; ?></td>
                  <td>
                    <?php if ($disable_mod_date) { ?>
                      <input type="checkbox" name="settings[disable_mod_date]" value="1" checked="checked" />
                      <?php } else { ?>
                      <input type="checkbox" name="settings[disable_mod_date]" value="1" />
                    <?php } ?>
                  </td>
              </tr>
              <tr class="class_1">
                  <td><?php echo $entry_disable_create_date; ?></td>
                  <td>
                    <?php if ($disable_create_date) { ?>
                      <input type="checkbox" name="settings[disable_create_date]" value="1" checked="checked" />
                      <?php } else { ?>
                      <input type="checkbox" name="settings[disable_create_date]" value="1" />
                    <?php } ?>
                  </td>
                  
              </tr>
              <tr class="class_1">
                  <td><?php echo $entry_disable_cat_list; ?></td>
                  <td>
                    <?php if ($disable_cat_list) { ?>
                      <input type="checkbox" name="settings[disable_cat_list]" value="1" checked="checked" />
                      <?php } else { ?>
                      <input type="checkbox" name="settings[disable_cat_list]" value="1" />
                    <?php } ?>
                  </td>
                  
              </tr>
              <tr class="class_1">
                  <td><?php echo $entry_disable_com_count; ?></td>
                  <td>
                    <?php if ($disable_com_count) { ?>
                      <input type="checkbox" name="settings[disable_com_count]" value="1" checked="checked" />
                      <?php } else { ?>
                      <input type="checkbox" name="settings[disable_com_count]" value="1" />
                    <?php } ?>
                  </td>
                  
              </tr>
              <tr>
                  <td><?php echo $entry_max_char_title; ?></td>
                  <td><input type="text" size="6" name="settings[max_char_title]" value="<?php echo $max_char_title; ?>" /></td>
              </tr>
              <tr>
                  <td><?php echo $entry_max_char_content; ?></td>
                  <td><input type="text" size="6" name="settings[max_char_content]" value="<?php echo $max_char_content; ?>" /></td>
              </tr>
              <tr>
                  <td><?php echo $entry_keep_html_format; ?></td>
                  <td>
                    <?php if ($keep_html_format) { ?>
                      <input type="checkbox" name="settings[keep_html_format]" value="1" checked="checked" />
                      <?php } else { ?>
                      <input type="checkbox" name="settings[keep_html_format]" value="1" />
                    <?php } ?>
                  </td>
              </tr>
              <tr>
                  <td><?php echo $entry_news_image_height; ?></td>
                  <td><input type="text" size="6" name="settings[image_height]" value="<?php echo $image_height; ?>" /><span class="hint">px</span></td>
              </tr>
              <tr>
                  <td><?php echo $entry_news_image_width; ?></td>
                  <td><input type="text" size="6" name="settings[image_width]" value="<?php echo $image_width; ?>" /><span class="hint">px</span></td>
              </tr>
              <tr class="class_1">
                  <td><?php echo $entry_news_image_margin; ?></td>
                  <td><input type="text" size="14" name="settings[image_margin]" value="<?php echo $image_margin; ?>" /><span class="hint"></span></td>
              </tr>
              <tr class="class_3">
                  <td><?php echo $entry_slideshow_cm; ?></td>
                  <td><input type="text" size="6" name="settings[slideshow_cm]" value="<?php echo $slideshow_cm; ?>" /><span class="hint">px</span></td>
              </tr>
              <tr class="class_3">
                  <td><?php echo $entry_slideshow_width; ?></td>
                  <td><input type="text" size="6" name="settings[slideshow_width]" value="<?php echo $slideshow_width; ?>" /><span class="hint">px</span></td>
              </tr>
              <tr class="class_3">
                  <td><?php echo $entry_slideshow_height; ?></td>
                  <td><input type="text" size="6" name="settings[slideshow_height]" value="<?php echo $slideshow_height; ?>" /><span class="hint">px</span></td>
              </tr>
          </table>
      </div>
      </form>
  </div>
 </div>
</div>
<?php echo $footer; ?>
<script type="text/javascript"><!--
$('#tabs a').tabs(); 
$('#languages a').tabs();
//--></script>

<script type="text/javascript"><!--
    $(window).scroll(function(){
  if  ($(window).scrollTop() >= 200){
      if($('.alt-heading').is(':hidden'))
      {
        $('.alt-heading').stop(true, true).fadeIn('fast');
      }
  }else{
      if($('.alt-heading').is(':visible'))
      {
        $('.alt-heading').stop(true, true).fadeOut('fast');
      }
  }
});

    
    function apply_submit()
    {
        $('.info-alt .success').stop(true,true).fadeOut();
        $('.info-alt .warning').stop(true,true).fadeOut();
        
        var set_id = $('#set_id').val()
        
        $.ajax({
            url: 'index.php?route=ac_cms/article_set/ajaxsave&id=' +set_id+ '&token=<?php echo $token; ?>',
            dataType: 'json',
            type: 'post',
            data: $("#form").serialize(),
            success: function(json) {
                    if (json['success']) {
                            $('.info-alt .success').show();
                            $('.info-alt .success').html(json['success']);
                            $('.info-alt .success').stop().fadeOut(5000);
                    }
                    if (json['error']) {
                            $('.info-alt .warning').show();
                            $('.info-alt .warning').html(json['error']);
                            $('.info-alt .warning').stop().fadeOut(5000);
                    }
                    if (json['id']) {
                            $('#set_id').val(json['id']);
                    }
                    
            }
        });
    }
//--></script>

<script type="text/javascript"><!--

setDisplay($('#display_type').val());

function setDisplay(display){
    
    switch (display){
        case '1':
            $('.class_1').show();
            $('.class_2').hide();
            $('.class_3').hide();
            $('.class_4').show();
        break;
        
        case '2':;
            $('.class_1').hide();
            $('.class_2').hide();
            $('.class_3').show();
            $('.class_4').show();
            $('.class_title_as_link').show();
            
        break;
        
        case '3':
            $('.class_1').show();
            $('.class_2').hide();
            $('.class_3').hide();
            $('.class_4').show();
        break;
        
        case '4':
            $('.class_1').show();
            $('.class_2').show();
            $('.class_3').hide();
            $('.class_4').hide();
            $('#article-related').empty();
        break;
        
        default:
            $('.class_1').show();
            $('.class_2').show();
            $('.class_3').hide();
            $('.class_4').show();
        break;
    }
}
$('#display_type').change(function(){
    setDisplay($(this).val());
});
//--></script>

<script type="text/javascript"><!--
$(function() {
        $( "#sortable" ).sortable({
            update: function(event, ui) {
				var order = $(this).sortable('toArray').toString();
                                $('#sort').val(order);
			}
        });
        $( "#sortable" ).disableSelection();
        
});
$('[id^=rel_article]').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=ac_cms/article/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.title,
						value: item.b_id
					}
				}));
			}
		});
		
	}, 
	select: function(event, ui) {
		$('#article-related' + ui.item.value).remove();
		
		$('#article-related').append('<div id="article-related' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" /><input type="hidden" name="settings[article_related][]" value="' + ui.item.value + '" /></div>');

		$('#article-related div:odd').attr('class', 'odd');
		$('#article-related div:even').attr('class', 'even');
				
		return false;
	}
});

$('#article-related div img').live('click', function() {
	$(this).parent().remove();
	
	$('#article-related div:odd').attr('class', 'odd');
	$('#article-related div:even').attr('class', 'even');	
});
//--></script>