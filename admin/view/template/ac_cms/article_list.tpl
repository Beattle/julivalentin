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
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
          <a onclick="location = '<?php echo $insert; ?>';" class="button" ><span><?php echo $button_insert; ?></span></a>
          <a onclick="$('#form').attr('action', '<?php echo $copy; ?>');$('#form').submit();" class="button"><span><?php echo $button_copy; ?></span></a>
          <a onclick="$('#form').submit();" class="button"><span><?php echo $button_delete; ?></span></a>
          <a class="button" href="<?php echo $module; ?>"><span><?php echo $button_cp; ?></span></a>
      </div>
    </div>
    <div class="content">
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">         
          <table class="list">
              <thead>
                  <tr>
                      <td width="1" align="center"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
                      <td class="left"><?php echo $text_column_name ; ?></td>
                      <td class="left"><?php echo $text_column_author; ?></td>
                      <td class="left"><?php echo $text_column_access_level; ?></td>
                      <td class="left"><?php echo $text_column_status; ?></td>
                      <td class="left"><?php echo $text_column_date_add; ?></td>
                      <td class="right"><?php echo $text_column_action; ?></td>
                  </tr>
              </thead>
              <tbody>
                  <tr class="filter">
              <td></td>
              <td>
                  <input type="text" name="filter_title" value="<?php echo $filter_title; ?>" />
                    <select name="filter_category">
                      <option value="*"></option>
                      <?php foreach ($categories as $category) { ?>
                      <?php if ($category['bc_id'] == $filter_category) { ?>
                      <option value="<?php echo $category['bc_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $category['bc_id']; ?>"><?php echo $category['name']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select>
              </td>
              <td><input type="text" name="filter_author" value="<?php echo $filter_author; ?>" /></td>
              <td><select name="filter_access_level">
                  <option value="*"></option>
                  <?php if ($filter_access_level) { ?>
                  <option value="1" selected="selected"><?php echo $text_registred; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_registred; ?></option>
                  <?php } ?>
                  <?php if (!is_null($filter_access_level) && !$filter_access_level) { ?>
                  <option value="0" selected="selected"><?php echo $text_public; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $text_public; ?></option>
                  <?php } ?>
                </select></td>
              <td><select name="filter_status">
                  <option value="*"></option>
                  <?php if ($filter_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <?php } ?>
                  <?php if (!is_null($filter_status) && !$filter_status) { ?>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
              <td align="left"></td>
              <td align="right"><a onclick="filter();" class="button"><span><?php echo $button_filter; ?></span></a></td>
            </tr>
                  <?php $class = "odd"; ?>
                  <?php if($articles){?>
                      <?php foreach ($articles as $article) { ?>
                      <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                      <tr class="<?php echo $class; ?>">
                          <td align="center"><?php if ($article['selected']) { ?>
                            <input type="checkbox" name="selected[]" value="<?php echo $article['b_id']; ?>" checked="checked" />
                            <?php } else { ?>
                            <input type="checkbox" name="selected[]" value="<?php echo $article['b_id']; ?>" />
                            <?php } ?>
                          </td>
                          <td class="left"><?php echo $article['title']; ?></td>
                          <td class="left"><?php echo $article['author']; ?></td>
                          <td class="left"><?php echo $article['access_level']; ?></td>
                          <td class="left"><?php echo $article['status']; ?></td>
                          <td class="left"><?php echo $article['date_added']; ?></td>
                          <td class="right"><?php foreach ($article['action'] as $action) { ?>
                            [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
                            <?php } ?>
                          </td>
                      </tr>
                      <?php } ?>
                  <?php } else {?>
                      <tr>
                          <td class="center" colspan="8"><?php echo $text_no_results; ?></td>
                      </tr>
                  <?php } ?>
              </tbody>
          </table>
      </form>
        <div class="pagination"><?php echo $pagination; ?></div>
    </div>
    
  </div>
<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=ac_cms/article/admin&token=<?php echo $token; ?>';
	
	var filter_title = $('input[name=\'filter_title\']').attr('value');
	
	if (filter_title) {
		url += '&filter_title=' + encodeURIComponent(filter_title);
	}
	
	var filter_author = $('input[name=\'filter_author\']').attr('value');
	
	if (filter_author) {
		url += '&filter_author=' + encodeURIComponent(filter_author);
	}
	
	var filter_status = $('select[name=\'filter_status\']').attr('value');
	
	if (filter_status != '*') {
		url += '&filter_status=' + encodeURIComponent(filter_status);
	}
        
        var filter_access_level = $('select[name=\'filter_access_level\']').attr('value');
	
	if (filter_access_level != '*') {
		url += '&filter_access_level=' + encodeURIComponent(filter_access_level);
	}

        var filter_category = $('select[name=\'filter_category\']').attr('value');
	
	if (filter_category != '*') {
		url += '&filter_category=' + encodeURIComponent(filter_category);
	}

	location = url;
}
//--></script> 
<script type="text/javascript"><!--
$('#form input').keydown(function(e) {
	if (e.keyCode == 13) {
		filter();
	}
});
//--></script> 
<script type="text/javascript"><!--
$('input[name=\'filter_title\']').autocomplete({
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
		$('input[name=\'filter_title\']').val(ui.item.label);
						
		return false;
	}
});

//--></script> 
<?php echo $footer; ?>