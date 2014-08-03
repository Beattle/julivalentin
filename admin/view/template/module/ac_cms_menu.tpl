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
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table id="module" class="list">
        <thead>
          <tr>
            <td class="left"><?php echo $entry_category; ?></td>
            <td class="left"><?php echo $entry_article; ?></td>
            <td class="left"><?php echo $entry_column; ?></td>
            <td class="left"><?php echo $entry_limit; ?></td>
            <td class="left"><?php echo $entry_status; ?></td>
            <td class="right"><?php echo $entry_sort_order; ?></td>
            <td></td>
          </tr>
        </thead>
        <?php $module_row = 0; ?>
        <?php foreach ($modules as $module) { ;?>
        <tbody id="module-row<?php echo $module_row; ?>">
          <tr>
              <td class="left" >
                  <select  name="ac_cms_menu[<?php echo $module_row; ?>][bc_id]" onchange="fillArticle(<?php echo $module_row; ?>)">
                      <option value="0"> <?php echo $text_select; ?> </option>
                      <?php if(!empty($categories)){ ?>
                       <?php foreach($categories as $bc_id => $name) { ?>
                      <?php if ($bc_id == $module['bc_id']) { ?>
                       <option selected="selected" value="<?php echo $bc_id; ?>"><?php echo $name; ?></option> 
                      <?php } else { ?>
                         <option value="<?php echo $bc_id; ?>"><?php echo $name; ?></option>
                        <?php } ?> 
                       <?php } ?>
                      <?php } ?>
                  </select>
              </td>
              <td class="left" >
                  <select name="ac_cms_menu[<?php echo $module_row; ?>][b_id]">
                      <option value="0"> <?php echo $text_select; ?> </option>
                  </select>
              </td>
            <td class="left"><input type="text" name="ac_cms_menu[<?php echo $module_row; ?>][column]" value="<?php echo (isset($module['column'])) ? $module['column'] : ''; ?>" size="3" /></td>
            <td class="left"><input type="text" name="ac_cms_menu[<?php echo $module_row; ?>][limit]" value="<?php echo (isset($module['limit'])) ? $module['limit'] : ''; ?>" size="3" /></td>
            <td class="left"><select name="ac_cms_menu[<?php echo $module_row; ?>][status]">
                <?php if ($module['status']) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
            <td class="right"><input type="text" name="ac_cms_menu[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" /></td>
            <td class="left"><a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="button"><span><?php echo $button_remove; ?></span></a></td>
          </tr>
        </tbody>
        <?php $module_row++; ?>
        <?php } ?>
        <tfoot>
          <tr>
            <td colspan="6"></td>
            <td class="left"><a onclick="addModule();" class="button"><span><?php echo $button_add_module; ?></span></a></td>
          </tr>
        </tfoot>
      </table>
    </form>
  </div>
</div>
<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;

function addModule() {	
	html  = '<tbody id="module-row' + module_row + '">';
	html += '  <tr>';
        html +=   '<td class="left" >';
        html +=   '<select name="ac_cms_menu[' + module_row + '][bc_id]" onchange="fillArticle(' + module_row + ')">';
        html +=    '<option value="0"><?php echo $text_select; ?></option>';
                      <?php if(!empty($categories)){ ?>
                       <?php foreach($categories as $bc_id => $name) { ?>
        html +=          '<option value="<?php echo $bc_id; ?>"><?php echo htmlentities($name, ENT_QUOTES, "UTF-8");?></option>';
                       <?php } ?>
                      <?php } ?>
        html +=    '</select>';
        html +=   '</td>';
        html +=   '<td class="left" >';
        html +=   '<select name="ac_cms_menu[' + module_row + '][b_id]">';
        html +=    '<option value="0"><?php echo $text_select; ?></option>';
        html +=    '</select>';
        html +=   '</td>';
	html += '    <td class="left"><input type="text" name="ac_cms_menu[' + module_row + '][column]" value="" size="3" /></td>';
        html += '    <td class="left"><input type="text" name="ac_cms_menu[' + module_row + '][limit]" value="" size="3" /></td>';
	html += '    <td class="left"><select name="ac_cms_menu[' + module_row + '][status]">';
    html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
    html += '      <option value="0"><?php echo $text_disabled; ?></option>';
    html += '    </select></td>';
	html += '    <td class="right"><input type="text" name="ac_cms_menu[' + module_row + '][sort_order]" value="" size="3" /></td>';
	html += '    <td class="left"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="button"><span><?php echo $button_remove; ?></span></a></td>';
	html += '  </tr>';
	html += '</tbody>';
	
	$('#module tfoot').before(html);
	
	module_row++;
}
//--></script>
<script type="text/javascript"><!--
<?php $i=0; foreach ($modules as $module) { ?>
   $('select[name=\'ac_cms_menu[<?php echo $i; ?>][b_id]\']').load('index.php?route=ac_cms/article/articles&bc_id='+ $('select[name=\'ac_cms_menu[<?php echo $i; ?>][bc_id]\']').val() +'&b_id=<?php echo $module['b_id'];?>&token=<?php echo $token; ?>');   
<?php $i++; } ?>

function fillArticle(row)
{
    var bc_id = $('select[name=\'ac_cms_menu[' + row + '][bc_id]\']').val();
    if(bc_id)
        $('select[name=\'ac_cms_menu[' + row + '][b_id]\']').load('index.php?route=ac_cms/article/articles&bc_id='+ bc_id +'&token=<?php echo $token; ?>');
}

//--></script> 
<?php echo $footer; ?>