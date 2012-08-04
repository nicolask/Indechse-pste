<?php
if ($CONF['useRecaptcha']) :
    require_once('classes/recaptchalib.php');
    ?>
    <!-- reCAPTCHA -->
    <script>
        var RecaptchaOptions = {
            theme : 'clean'
        };
    </script>
    <div id="recaptcha">
        <?php echo recaptcha_get_html($CONF['pubkey']) . "\n"; ?>
    </div>
<?php endif; ?>