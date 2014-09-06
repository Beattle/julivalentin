<div id="tabs<?php echo $module; ?>" class="htabs tab-category">
    <?php $c_h = 0;
    foreach ($categories_tabs as $category) {
        ; ?>
        <a href="#tabs<?php echo $module; ?>-<?php echo $c_h; ?>"><?php echo $category['name']; ?>
            <input type="hidden" class="tab_href"
                   value="index.php?route=module/ac_cms_set/tabitem&bc_id=<?php echo $category['bc_id']; ?>&module=<?php echo $module; ?>&bs_id=<?php echo $bs_id; ?>"/>
        </a>
        <?php $c_h++;
    } ?>
</div>
<?php for ($z = 0; $z < $c_h; $z++) { ?>
    <div id="tabs<?php echo $module . '-' . $z; ?>" class="tab-content"></div>
<?php } ?>

<script type="text/javascript"><!--
    $(function () {
        $("#tabs<?php echo $module;?> a").tabs_m();
    });
    $("#tabs<?php echo $module;?> a").click(function () {
        var elem = $(this).attr('href');
        var ajax_load = '<img src="<?php echo (defined('HTTP_IMAGE')) ? HTTP_IMAGE.'data/ajax-loader.gif':HTTP_SERVER . 'image/data/ajax-loader.gif' ;?>" alt="" />';

        if ($(elem).is(':empty')) {
            $(elem).append(ajax_load).load($(this).find('.tab_href').val(), function () {

                if (typeof window.DqCount == 'function') {
                    DqCount();
                }
            });

        }

    });
    --></script>