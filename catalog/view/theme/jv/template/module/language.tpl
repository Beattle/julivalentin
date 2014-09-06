<?php if (count($languages) > 1) { ?>
    <?php  foreach ($languages as $key => $val) {
        if ($val['code'] === $language_code) {
            $first_key = $key;
            $value = $val;
        }
    }
    $languages = array_merge(array($first_key => $value) + $languages);
    ?>
    <div id="language">
        <form class="language" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">

            <?php foreach ($languages as $language) { ?>
                <a class="top-icons language" href="javascript:void(0);" title="<?php echo $language['name']; ?>"
                   onclick="$('input[name=\'language_code\']').attr('value', '<?php echo $language['code']; ?>'); $(this).parent().submit();">
                    <?php echo $language['code']; ?>
                </a>
            <?php } ?>
            <input type="hidden" name="language_code" value=""/>
            <input type="hidden" name="redirect" value="<?php echo $redirect; ?>"/>
        </form>
    </div>
<?php } ?>
