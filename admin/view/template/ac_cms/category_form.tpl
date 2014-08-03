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
    <div id="tabs" class="htabs">
        <a href="#tab-general"><?php echo $tab_general; ?></a>
        <a href="#tab-data"><?php echo $tab_data; ?></a>
        <a href="#tab-design"><?php echo $tab_design; ?></a>
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
                <td><span class="required">*</span> <?php echo $entry_cat_name; ?></td>
                <td><input type="text" name="category_description[<?php echo $language['language_id']; ?>][name]" size="100" value="<?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['name'] : ''; ?>" />
                  <?php if (isset($error_name[$language['language_id']])) { ?>
                  <span class="error"><?php echo $error_name[$language['language_id']]; ?></span>
                  <?php } ?>
                </td>
              </tr>
              <tr>
                <td> <?php echo $entry_content; ?></td>
                <td><textarea name="category_description[<?php echo $language['language_id']; ?>][description]" id="description<?php echo $language['language_id']; ?>"><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['description'] : ''; ?></textarea>
                </td>
              </tr>
              <tr>
                <td><?php echo $meta_description; ?></td>
                <td><textarea style="width: 99%" name="category_description[<?php echo $language['language_id']; ?>][meta_description]" cols="40" rows="5"><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['meta_description'] : ''; ?></textarea></td>
              </tr>
              <tr>
                <td><?php echo $meta_keywords; ?></td>
                <td><textarea style="width: 99%" name="category_description[<?php echo $language['language_id']; ?>][meta_keyword]" cols="40" rows="5"><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea></td>
              </tr>
            </table>
          </div>
        <?php } ?>
      </div>
      <div id="tab-data">
          <table class="form">
              <tr>
                  <td><?php echo $entry_parent; ?></td>
                  <td>
                  <select name="parent">
                      <option value="0"><?php echo $text_none; ?></option>
                      <?php foreach ($categories as $category) { ?>
                      <?php if ($category['bc_id'] == $parent) { ?>
                      <option value="<?php echo $category['bc_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $category['bc_id']; ?>"><?php echo $category['name']; ?></option>
                      <?php } ?>
                      <?php } ?>
                </select></td>
              </tr>
              <tr>
               <td><?php echo $entry_store; ?></td>
               <td><div class="scrollbox">
                  <?php $class = 'even'; ?>
                  <div class="<?php echo $class; ?>">
                    <?php if (in_array(0, $category_store)) { ?>
                    <input type="checkbox" name="category_store[]" value="0" checked="checked" />
                    <?php echo $text_default; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="category_store[]" value="0" />
                    <?php echo $text_default; ?>
                    <?php } ?>
                  </div>
                  <?php foreach ($stores as $store) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    <?php if (in_array($store['store_id'], $category_store)) { ?>
                    <input type="checkbox" name="category_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                    <?php echo $store['name']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="category_store[]" value="<?php echo $store['store_id']; ?>" />
                    <?php echo $store['name']; ?>
                    <?php } ?>
                  </div>
                  <?php } ?>
                </div></td>
            </tr>
              <tr>
                  <td><?php echo $entry_seo; ?></td>
                  <td><input type="text" name="cat_keyword" size="50" value="<?php echo $cat_keyword; ?>" /></td>
              </tr>
              <tr>
                  <td><?php echo $entry_image; ?></td>
                  <td>
                      <div class="image"><img src="<?php echo $thumb; ?>" alt="" id="thumb" /><br />
                       <input type="hidden" name="image" value="<?php echo $image; ?>" id="image" />
                       <a onclick="image_upload('image', 'thumb');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#thumb').attr('src', '<?php echo $no_image; ?>'); $('#image').attr('value', '');"><?php echo $text_clear; ?></a>
                      </div>
                  </td>
              </tr>
              <tr>
                  <td><?php echo $entry_sort_order; ?></td>
                  <td><input type="text" name="sort_order" value="<?php echo $sort_order; ?>" size="1" /></td>
              </tr>
              <tr>
                  <td><?php echo $entry_rss; ?></td>
                  <td><select name="cat_rss">
                      <?php if ($rss) { ?>
                      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                      <option value="0"><?php echo $text_disabled; ?></option>
                      <?php } else { ?>
                      <option value="1"><?php echo $text_enabled; ?></option>
                      <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                      <?php } ?>
                    </select>
                   </td>
              </tr>
<!--              <tr>
                  <td><?php echo $entry_archive; ?></td>
                  <td><select name="settings[archive]">
                      <?php if ($archive) { ?>
                      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                      <option value="0"><?php echo $text_disabled; ?></option>
                      <?php } else { ?>
                      <option value="1"><?php echo $text_enabled; ?></option>
                      <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                      <?php } ?>
                    </select>
                   </td>
              </tr>-->
              <tr>
                  <td><?php echo $entry_status; ?></td>
                  <td><select name="cat_status">
                      <?php if ($status) { ?>
                      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                      <option value="0"><?php echo $text_disabled; ?></option>
                      <?php } else { ?>
                      <option value="1"><?php echo $text_enabled; ?></option>
                      <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                      <?php } ?>
                    </select>
                   </td>
              </tr>
          </table> 
      </div>
      <div id="tab-design">
       <table class="list">
        <thead>
          <tr>
            <td class="left"><?php echo $entry_store; ?></td>
            <td class="left"><?php echo $entry_layout; ?></td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="left"><?php echo $text_default; ?></td>
            <td class="left"><select name="category_layout[0][layout_id]">
                <option value=""></option>
                <?php foreach ($layouts as $layout) { ?>
                <?php if (isset($category_layout[0]) && $category_layout[0] == $layout['layout_id']) { ?>
                <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
        </tbody>
        <?php foreach ($stores as $store) { ?>
        <tbody>
          <tr>
            <td class="left"><?php echo $store['name']; ?></td>
            <td class="left"><select name="article_layout[<?php echo $store['store_id']; ?>][layout_id]">
                <option value=""></option>
                <?php foreach ($layouts as $layout) { ?>
                <?php if (isset($article_layout[$store['store_id']]) && $article_layout[$store['store_id']] == $layout['layout_id']) { ?>
                <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
        </tbody>
        <?php } ?>
      </table> 
      <table id="override-gs-table" class="list">
          <thead>
          <tr>
            <td colspan="2" class="left">
                <?php echo $entry_override_gs;?>
                <?php if ($override_gs) { ?>
                  <input id="override-gs" type="checkbox" name="settings[override_gs]" value="1" checked="checked" />
                  <?php } else { ?>
                  <input id="override-gs" type="checkbox" name="settings[override_gs]" value="1" />
                <?php } ?>
            </td>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td class="left"><?php echo $entry_disable_author; ?></td>
              <td class="left">
                <?php if ($disable_author) { ?>
                  <input type="checkbox" name="settings[disable_author]" value="1" checked="checked" />
                  <?php } else { ?>
                  <input type="checkbox" name="settings[disable_author]" value="1" />
                <?php } ?>
              </td>
          </tr>
          <tr>
              <td class="left"><?php echo $entry_disable_create_date; ?></td>
              <td class="left">
                <?php if ($disable_create_date) { ?>
                  <input type="checkbox" name="settings[disable_create_date]" value="1" checked="checked" />
                  <?php } else { ?>
                  <input type="checkbox" name="settings[disable_create_date]" value="1" />
                <?php } ?>
              </td>
          </tr>
          <tr>
              <td class="left"><?php echo $entry_disable_cat_list; ?></td>
              <td class="left">
                <?php if ($disable_cat_list) { ?>
                  <input type="checkbox" name="settings[disable_cat_list]" value="1" checked="checked" />
                  <?php } else { ?>
                  <input type="checkbox" name="settings[disable_cat_list]" value="1" />
                <?php } ?>
              </td>

          </tr>
          <tr>
              <td class="left"><?php echo $entry_disable_com_count; ?></td>
              <td class="left">
                <?php if ($disable_com_count) { ?>
                  <input type="checkbox" name="settings[disable_com_count]" value="1" checked="checked" />
                  <?php } else { ?>
                  <input type="checkbox" name="settings[disable_com_count]" value="1" />
                <?php } ?>
              </td>
          </tr>
          <tr>
              <td class="left"><?php echo $entry_disable_mod_date; ?></td>
              <td class="left">
                <?php if ($disable_mod_date) { ?>
                  <input type="checkbox" name="settings[disable_mod_date]" value="1" checked="checked" />
                  <?php } else { ?>
                  <input type="checkbox" name="settings[disable_mod_date]" value="1" />
                <?php } ?>
              </td>
          </tr>
<!--          <tr>
              <td class="left"><?php echo $entry_disable_share; ?></td>
              <td class="left">
                <?php if ($disable_share) { ?>
                  <input type="checkbox" name="settings[disable_share]" value="1" checked="checked" />
                  <?php } else { ?>
                  <input type="checkbox" name="settings[disable_share]" value="1" />
                <?php } ?>
              </td>
          </tr>
          <tr>
              <td class="left"><?php echo $entry_disable_fblike; ?></td>
              <td class="left">
                <?php if ($disable_fblike) { ?>
                  <input type="checkbox" name="settings[disable_fblike]" value="1" checked="checked" />
                  <?php } else { ?>
                  <input type="checkbox" name="settings[disable_fblike]" value="1" />
                <?php } ?>
              </td>
          </tr>
          <tr>
              <td class="left"><?php echo $entry_disable_viewed; ?></td>
              <td class="left">
                <?php if ($disable_viewed) { ?>
                  <input type="checkbox" name="settings[disable_viewed]" value="1" checked="checked" />
                  <?php } else { ?>
                  <input type="checkbox" name="settings[disable_viewed]" value="1" />
                <?php } ?>
              </td>
          </tr>-->
         </tbody>
      </table>
    </div>
  </form>
  </div>
 </div>
</div>
<?php echo $footer; ?>
<script type="text/javascript"><!--
    
    checkOverrideGs($('#override-gs').is(':checked'));
    
    $('#override-gs').change(function(){
        checkOverrideGs($(this).is(':checked'));
    });
    
    function checkOverrideGs(data){
        if(data){
            $('#override-gs-table tbody tr').show();
        }else{
            $('#override-gs-table tbody tr').hide();
        }
    }
//--></script> 
<script type="text/javascript"><!--
$('#tabs a').tabs(); 
$('#languages a').tabs();
//--></script>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script> 
<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
CKEDITOR.replace('description<?php echo $language['language_id']; ?>', {
	filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});
<?php } ?>
//--></script> 
<script type="text/javascript"><!--
function image_upload(field, thumb) {
	$('#dialog').remove();
	
	$('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
	
	$('#dialog').dialog({
		title: '<?php echo $text_image_manager; ?>',
		close: function (event, ui) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).val()),
					dataType: 'text',
					success: function(data) {
						$('#' + thumb).replaceWith('<img src="' + data + '" alt="" id="' + thumb + '" />');
					}
				});
			}
		},	
		bgiframe: false,
		width: 800,
		height: 400,
		resizable: false,
		modal: false
	});
};
//--></script> 