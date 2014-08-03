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
        <h1><img src="view/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
        <div class="buttons">
            <a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a>
            <a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
    </div>
        <div class="content">
            <div id="tabs" class="htabs">
                <a href="#tab-general"><?php echo $tab_general; ?></a>
                <a href="#tab-data"><?php echo $tab_data; ?></a>
                <a href="#tab-comment"><?php echo $tab_comment; ?></a>
                <a href="#tab-links"><?php echo $tab_links; ?></a>
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
                            <td><span class="required">*</span> <?php echo $entry_title; ?></td>
                            <td><input type="text" name="ac_cms_description[<?php echo $language['language_id']; ?>][title]" size="100" value="<?php echo isset($ac_cms_description[$language['language_id']]) ? $ac_cms_description[$language['language_id']]['title'] : ''; ?>" />
                              <?php if (isset($error_title[$language['language_id']])) { ?>
                              <span class="error"><?php echo $error_title[$language['language_id']]; ?></span>
                              <?php } ?>
                            </td>
                          </tr>
                          <tr>
                            <td><span class="required">*</span> <?php echo $entry_content; ?></td>
                            <td><textarea name="ac_cms_description[<?php echo $language['language_id']; ?>][intro]" id="description<?php echo $language['language_id']; ?>"><?php echo isset($ac_cms_description[$language['language_id']]) ? $ac_cms_description[$language['language_id']]['intro'] : ''; ?></textarea>
                                <input style="padding: 5px;" id="readmore-hr<?php echo $language['language_id']; ?>" onclick="readmoreTag(<?php echo $language['language_id']; ?>)" type="button" value="<?php echo $text_read_more_tag; ?>"/>
                            <?php if (isset($error_intro[$language['language_id']])) { ?>
                              <span class="error"><?php echo $error_intro[$language['language_id']]; ?></span>
                              <?php } ?>
                            </td>
                          </tr>
                          <tr>
                            <td><?php echo $meta_description; ?></td>
                            <td><textarea style="width: 99%" name="ac_cms_description[<?php echo $language['language_id']; ?>][meta_description]" cols="40" rows="5"><?php echo isset($ac_cms_description[$language['language_id']]) ? $ac_cms_description[$language['language_id']]['meta_description'] : ''; ?></textarea></td>
                          </tr>
                          <tr>
                            <td><?php echo $meta_keywords; ?></td>
                            <td><textarea style="width: 99%" name="ac_cms_description[<?php echo $language['language_id']; ?>][meta_keyword]" cols="40" rows="5"><?php echo isset($ac_cms_description[$language['language_id']]) ? $ac_cms_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea></td>
                          </tr>
                          <tr>
                              <td><?php echo $entry_article_tags; ?></td>
                              <td><input type="text" name="article_tag[<?php echo $language['language_id']; ?>]" value="<?php echo isset($article_tag[$language['language_id']]) ? $article_tag[$language['language_id']] : ''; ?>" size="80" /></td>
                          </tr>
                        </table>
                      </div>
                    <?php } ?>
                </div>
                <div id="tab-data">
                    <table class="form">
                        <tr>
                            <td><?php echo $entry_date_active; ?></td>
                            <td><input class="datetime" type="text" name="date_active" size="50" value="<?php echo $date_active; ?>" />
                              <?php if (isset($error_name[$language['language_id']])) { ?>
                              <span class="error"><?php echo $error_name[$language['language_id']]; ?></span>
                              <?php } ?>
                            </td>
                          </tr>
                          <tr>
                            <td><?php echo $entry_date_expr; ?></td>
                            <td><input class="datetime" type="text" name="date_expr" size="50" value="<?php echo $date_expr; ?>" />
                              <?php if (isset($error_name[$language['language_id']])) { ?>
                              <span class="error"><?php echo $error_name[$language['language_id']]; ?></span>
                              <?php } ?>
                            </td>
                          </tr>
                          <tr>
                              <td><?php echo $entry_seo; ?></td>
                              <td><input type="text" name="keyword" size="50" value="<?php echo $keyword; ?>" /></td>
                          </tr>
                          <tr>
                              <td><?php echo $entry_image; ?></td>
                              <td><div class="image"><img src="<?php echo $thumb; ?>" alt="" id="thumb" /><br />
                                   <input type="hidden" name="image" value="<?php echo $image; ?>" id="image" />
                                   <a onclick="image_upload('image', 'thumb');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#thumb').attr('src', '<?php echo $no_image; ?>'); $('#image').attr('value', '');"><?php echo $text_clear; ?></a>
                                  </div>
                              </td>
                          </tr>
                          <tr>
                            <td><?php echo $entry_sort_order; ?></td>
                            <td><input type="text" name="sort_order" size="1" value="<?php echo $sort_order; ?>" />
                            </td>
                          </tr>
                          <tr>
                              <td><?php echo $entry_not_for_blog; ?></td>
                              <td>
                              <?php if ($not_for_blog) { ?>
                                <input type="checkbox" name="not_for_blog" value="1" checked="checked" />
                                <?php } else { ?>
                                <input type="checkbox" name="not_for_blog" value="1" />
                              <?php } ?>
                              </td>
                          </tr>
                          <tr>
                            <td><?php echo $entry_access_level; ?></td>
                            <td><select name="access_level">
                              <?php if ($access_level) { ?>
                              <option value="0"><?php echo $text_public; ?></option>
                              <option value="1" selected="selected"><?php echo $text_registred; ?></option>
                              <?php } else { ?>
                              <option value="0"><?php echo $text_public; ?></option>
                              <option value="1"><?php echo $text_registred; ?></option>
                              <?php } ?>
                            </select>
                           </td>
                          </tr>
                          <tr>
                            <td><?php echo $entry_status; ?></td>
                            <td><select name="status">
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
                <div id="tab-comment">
                  <table class="form">
                    <tr>
                        <td><?php echo $entry_allow_comments; ?></td>
                        <td>
                        <select name="allow_comments">
                            <?php if ($allow_comments) { ?>
                            <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                            <option value="0"><?php echo $text_no; ?></option>
                            <?php } else { ?>
                            <option value="1"><?php echo $text_yes; ?></option>
                            <option value="0" selected="selected"><?php echo $text_no; ?></option>
                            <?php } ?>
                        </select>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_com_need_apr; ?></td>
                        <td>
                        <select name="com_need_apr">
                            <?php if ($com_need_apr) { ?>
                            <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                            <option value="0"><?php echo $text_no; ?></option>
                            <?php } else { ?>
                            <option value="1"><?php echo $text_yes; ?></option>
                            <option value="0" selected="selected"><?php echo $text_no; ?></option>
                            <?php } ?>
                        </select>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_com_notify; ?></td>
                        <td>
                        <select name="com_notify">
                            <?php if ($com_notify) { ?>
                            <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                            <option value="0"><?php echo $text_no; ?></option>
                            <?php } else { ?>
                            <option value="1"><?php echo $text_yes; ?></option>
                            <option value="0" selected="selected"><?php echo $text_no; ?></option>
                            <?php } ?>
                        </select>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_access_level; ?></td>
                        <td><select name="com_access_level">
                            <?php if ($com_access_level) { ?>
                            <option value="0"><?php echo $text_public; ?></option>
                            <option value="1" selected="selected"><?php echo $text_registred; ?></option>
                            <?php } else { ?>
                            <option value="0"><?php echo $text_public; ?></option>
                            <option value="1"><?php echo $text_registred; ?></option>
                            <?php } ?>
                        </select>
                        </td>
                    </tr>
                  </table>
                </div>
                <div id="tab-links">
                    <table class="form">
                        <tr>
                          <td><?php echo $entry_category; ?></td>
                          <td><div class="scrollbox">
                              <?php $class = 'odd'; ?>
                              <?php foreach ($categories as $category) { ?>
                              <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                              <div class="<?php echo $class; ?>">
                                <?php if (in_array($category['bc_id'], $article_category)) { ?>
                                <input type="checkbox" name="article_category[]" value="<?php echo $category['bc_id']; ?>" checked="checked" />
                                <?php echo $category['name']; ?>
                                <?php } else { ?>
                                <input type="checkbox" name="article_category[]" value="<?php echo $category['bc_id']; ?>" />
                                <?php echo $category['name']; ?>
                                <?php } ?>
                              </div>
                              <?php } ?>
                            </div>
                            <a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a>
                          </td>
                        </tr>
                        <tr>
                          <td><?php echo $entry_store; ?></td>
                          <td><div class="scrollbox">
                              <?php $class = 'even'; ?>
                              <div class="<?php echo $class; ?>">
                                <?php if (in_array(0, $article_store)) { ?>
                                <input type="checkbox" name="article_store[]" value="0" checked="checked" />
                                <?php echo $text_default; ?>
                                <?php } else { ?>
                                <input type="checkbox" name="article_store[]" value="0" />
                                <?php echo $text_default; ?>
                                <?php } ?>
                              </div>
                              <?php foreach ($stores as $store) { ?>
                              <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                              <div class="<?php echo $class; ?>">
                                <?php if (in_array($store['store_id'], $article_store)) { ?>
                                <input type="checkbox" name="article_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                                <?php echo $store['name']; ?>
                                <?php } else { ?>
                                <input type="checkbox" name="article_store[]" value="<?php echo $store['store_id']; ?>" />
                                <?php echo $store['name']; ?>
                                <?php } ?>
                              </div>
                              <?php } ?>
                            </div></td>
                        </tr>
                        <tr>
                          <td><?php echo $entry_related_products; ?></td>
                          <td><input type="text" id="rel_prod" name="rel_prod" value="" /></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td><div class="scrollbox" id="product-related">
                              <?php $class = 'odd'; ?>
                              <?php foreach ($product_related as $product_related) { ?>
                              <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                              <div id="product-related<?php echo $product_related['product_id']; ?>" class="<?php echo $class; ?>"> <?php echo $product_related['name']; ?><img src="view/image/delete.png" />
                                <input type="hidden" name="product_related[]" value="<?php echo $product_related['product_id']; ?>" />
                              </div>
                              <?php } ?>
                            </div></td>
                        </tr>
                        <tr>
                          <td><?php echo $entry_related_articles; ?></td>
                          <td><input type="text" id="rel_article" name="rel_article" value="" /></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td><div class="scrollbox" id="article-related">
                              <?php $class = 'odd'; ?>
                              <?php foreach ($article_related as $article_related) { ?>
                              <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                              <div id="article-related<?php echo $article_related['b_id']; ?>" class="<?php echo $class; ?>"> <?php echo $article_related['title']; ?><img src="view/image/delete.png" />
                                <input type="hidden" name="article_related[]" value="<?php echo $article_related['b_id']; ?>" />
                              </div>
                              <?php } ?>
                            </div></td>
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
                        <td class="left"><select name="article_layout[0][layout_id]">
                            <option value=""></option>
                            <?php foreach ($layouts as $layout) { ?>
                            <?php if (isset($article_layout[0]) && $article_layout[0] == $layout['layout_id']) { ?>
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
                      <tr>
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
                      </tr>
                     </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script> 
<script type="text/javascript"><!--
    function readmoreTag(lang_id){
        var data = eval('CKEDITOR.instances.description' + lang_id + '.getData()');
        var tag = '<hr id="readmore" />';
        if(data.indexOf(tag)>0){
            alert('<?php echo $text_read_more_tag_err ?>');
        }else if(data == ''){
            alert('<?php echo $text_read_more_tag_err2 ?>');
        }
        else{
            eval ('CKEDITOR.instances.description' + lang_id + '.insertHtml' + '(\'<hr id="readmore" />\')');
        }
    }
    
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
<?php foreach ($languages as $language) { ?>
CKEDITOR.replace('description<?php echo $language['language_id']; ?>', {
        toolbar : 'ACCMS',
	filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
        height: '350px'
});
    CKEDITOR.config.toolbar_ACCMS =
[
	{ name: 'document', items : [ 'Source','-','Save','NewPage','DocProps','Preview','Print' ] },
	{ name: 'tools', items : [ 'Maximize', 'ShowBlocks' ] },
        { name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] },
	'/',
	
	{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','- ','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
	{ name: 'links', items : [ 'Link','Unlink','Anchor' ] },
        { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
	
	'/',
	
	{ name: 'colors', items : [ 'TextColor','BGColor' ] },
        { name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
	{ name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },	
        { name: 'insert', items : [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar' ] }
];

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
<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script> 
<script type="text/javascript"><!--
$('.date').datepicker({dateFormat: 'yy-mm-dd'});
$('.datetime').datetimepicker({
	dateFormat: 'yy-mm-dd',
	timeFormat: 'hh:mm'
});
$('.time').timepicker({timeFormat: 'h:m'});
//--></script> 
<script type="text/javascript"><!--
$('#tabs a').tabs(); 
$('#languages a').tabs();
//--></script> 
<script type="text/javascript"><!--
$('[id^=rel_prod]').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=ac_cms/article/autocomplete&type=product&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.product_id
					}
				}));
			}
		});
		
	}, 
	select: function(event, ui) {
		$('#product-related' + ui.item.value).remove();
		
		$('#product-related').append('<div id="product-related' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" /><input type="hidden" name="product_related[]" value="' + ui.item.value + '" /></div>');

		$('#product-related div:odd').attr('class', 'odd');
		$('#product-related div:even').attr('class', 'even');
				
		return false;
	}
});

$('#product-related div img').live('click', function() {
	$(this).parent().remove();
	
	$('#product-related div:odd').attr('class', 'odd');
	$('#product-related div:even').attr('class', 'even');	
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
		
		$('#article-related').append('<div id="article-related' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" /><input type="hidden" name="article_related[]" value="' + ui.item.value + '" /></div>');

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
<?php echo $footer; ?>