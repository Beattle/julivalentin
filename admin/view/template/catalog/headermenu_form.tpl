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
      <h1><img src="view/image/headermenu.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <div id="tabs" class="htabs"><a href="#tab-general"><?php echo $tab_general; ?></a></div>
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
                <td><input type="text" name="headermenu_description[<?php echo $language['language_id']; ?>][title]" size="100" value="<?php echo isset($headermenu_description[$language['language_id']]) ? $headermenu_description[$language['language_id']]['title'] : ''; ?>" />
                  <?php if (isset($error_name[$language['language_id']])) { ?>
                  <span class="error"><?php echo $error_name[$language['language_id']]; ?></span>
                  <?php } ?></td>
              </tr>  
		
             
            </table>
          </div>
          <?php } ?>
         <table class="form">
              
             <tr>
			 <td><?php echo $entry_link; ?></td>
			 <td><input type="text" name="link" value="<?php echo $link; ?>" size="100" /></td>
			 </tr>
			 
			 
			 <tr><td><?php echo $entry_level1; ?></td>
			  <td> <select name="level1" >
				<option value=""><?php echo $text_select ?> </option> 
				<?php if($headermenu) { foreach($headermenu as $menu)
				{
				if($menu['headermenu_id']==$level1)
				{
				$sel="selected";
				}
				else
				{
				$sel="";
				}
				
				?>
				<option <?php echo $sel; ?> value="<?php echo $menu['headermenu_id'] ?>"><?php echo $menu['title'] ?></option> 
				<?php
				}}
				?>
			
				
			  </select></td>
			 </tr>

			 <tr><td><?php echo $entry_level2; ?></td>
			  <td> <select name="level2" >
				<option value=""><?php echo $text_select ?> </option> 
				<?php if($headermenu1) { foreach($headermenu1 as $menu)
				{
				if($menu['headermenu_id']==$level2)
				{
				$sel="selected";
				}
				else
				{
				$sel="";
				}
				
				?>
				<option <?php echo $sel; ?> value="<?php echo $menu['headermenu_id'] ?>"><?php echo $menu['title'] ?></option> 
				<?php
				}}
				?>
			
				
			  </select></td>
			 </tr>
			  <tr>
			 <td><?php echo $entry_column; ?></td>
			 <td><input type="text" name="column" value="<?php echo $column; ?>" size="10" /></td>
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
			    <tr>
			 <td><?php echo $entry_sort_order; ?></td>
			 <td><input type="text" name="sort_order" value="<?php echo $sort_order; ?>" size="10" /></td>
			 </tr>
			 
            </table>
          </div>
          
        </div>
       
       
      </form>
    </div>
  </div>
</div>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script> 

<script type="text/javascript"><!--
$('#tabs a').tabs(); 
$('#languages a').tabs(); 
//--></script> 
<?php echo $footer; ?>