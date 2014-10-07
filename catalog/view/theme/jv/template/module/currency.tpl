<?php if (count($currencies) > 1) { ?>
    <?php
    foreach ($currencies as $key => $val) {
        if ($val['code'] === $currency_code) {
            $first_key = $key;
            $value = $val;
        }
    }
    $currencies = array_merge(array($first_key => $value) + $currencies);
    ?>
    <div id="currency">
        <form class="currency" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            <?php foreach ($currencies as &$currency) { ?>
                <?php if($currency['symbol_right'] == 'Р' ){
                    $currency['symbol_right'] = '<span class="r">Р</span>';
                } ?>
                <?php if ($currency['code'] == $currency_code) { ?>
                    <?php if ($currency['symbol_left']) { ?>
                        <a class="top-icons currency"
                           title="<?php echo $currency['title']; ?>"><?php echo $currency['symbol_left']; ?></a>
                    <?php } else { ?>
                        <a class="top-icons currency"
                           title="<?php echo $currency['title']; ?>"><?php echo $currency['symbol_right']; ?></a>
                    <?php } ?>
                <?php } else { ?>
                    <?php if ($currency['symbol_left']) { ?>
                        <a class="top-icons currency" title="<?php echo $currency['title']; ?>"
                           onclick="$('input[name=\'currency_code\']').attr('value', '<?php echo $currency['code']; ?>'); $(this).parent().submit();"><?php echo $currency['symbol_left']; ?></a>
                    <?php } else { ?>
                        <a class="top-icons currency" title="<?php echo $currency['title']; ?>"
                           onclick="$('input[name=\'currency_code\']').attr('value', '<?php echo $currency['code']; ?>'); $(this).parent().submit();"><?php echo $currency['symbol_right']; ?></a>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
            <input type="hidden" name="currency_code" value=""/>
            <input type="hidden" name="redirect" value="<?php echo $redirect; ?>"/>
        </form>
    </div>
<?php } ?>
