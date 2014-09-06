<div id="simplecheckout_login">
    <div class="simplecheckout-warning-block"
         <?php if (!$error_login) { ?>style="visibility:hidden;"<?php } ?>><?php echo $error_login ?></div>
    <table class="simplecheckout-login">
        <tbody>
        <tr>
            <td colspan="2" class="simplecheckout-login-left"><?php echo $entry_email; ?></td>
        </tr>
        <tr>
            <td colspan="2" class="simplecheckout-login-right"><input type="text" value="<?php echo $email; ?>"
                                                                      name="email"></td>
        </tr>
        <tr>
            <td colspan="2" class="simplecheckout-login-left"><?php echo $entry_password; ?></td>
        </tr>
        <tr>
            <td colspan="2" class="simplecheckout-login-right"><input type="password" value="" name="password"></td>
        </tr>
        <tr>
            <td class="simplecheckout-login-right fgt-pass"><a
                    href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a></td>
            <td class="simplecheckout-login-right buttons"><a class="button btn" onclick="simplecheckout_login()"
                                                              id="simplecheckout_button_login"><span><?php echo $button_login; ?></span></a>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<script type='text/javascript'>
    $('.simplecheckout-login input').keydown(function (e) {
        if (e.keyCode == 13) {
            simplecheckout_login();
        }
    });
</script>
<?php if ($redirect) { ?>
    <script type='text/javascript'>
        location = '<?php echo $redirect ?>';
    </script>
<?php } ?>
<!-- You can add here the social engine code for login in the simplecheckout_customer.tpl -->
    