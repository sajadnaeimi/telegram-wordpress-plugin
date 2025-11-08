<?php
{
?><link href="<?=plugins_url( 'admin/emoji-picker-master/lib/css/emoji.css', __FILE__ ) ?>" rel="stylesheet">
    <script src="<?=plugins_url( 'admin/emoji-picker-master/lib/js/config.js', __FILE__ ) ?>"></script>
    <script src="<?=plugins_url( 'admin/emoji-picker-master/lib/js/util.js', __FILE__ ) ?>"></script>
    <script src="<?=plugins_url( 'admin/emoji-picker-master/lib/js/jquery.emojiarea.js', __FILE__ ) ?>"></script>
    <script src="<?=plugins_url( 'admin/emoji-picker-master/lib/js/emoji-picker.js', __FILE__ ) ?>"></script>
    <style>
        .lead.emoji-picker-container {
            width: 100%;
            display: block;
            text-align: left;
            float: left;
            font-size: inherit;
            white-space: pre-wrap;
        }
        .lead.emoji-picker-container input {
            width: 100%;
            height: 50px;
        }
        .clear-fix{
            clear:both;
        }

    </style><div><p>استفاده از تگ های بولد، ایتالیک و لینک مجاز است.</p><div class="lead emoji-picker-container"><textarea style="width:90%" name="chbot_box_text" placeholder="متن مورد نظر جهت ارسال به کانال را اینجا وارد کنید..." data-emoji-input="unicode" data-emojiable="true" aria-multiline="true"><?php  echo $quick_options['text'];?></textarea></div><div class="clear-fix"></div><br /><b>در صورتی که مایل هستید محتوای این باکس به کانال تلگرام شما ارسال گردد از جعبه تنظیمات در همین صفحه گزینه ی "محتوای باکس افزونه کانال خودکار" را انتخاب نمایید.</b></div><script>
    jQuery(document).ready(function($) {
        // Initializes and creates emoji set from sprite sheet

        window.emojiPicker = new EmojiPicker({
            emojiable_selector: '[data-emojiable=true]',
            assetsPath: 'http://onesignal.github.io/emoji-picker/lib/img/',
            popupButtonClasses: 'fa fa-smile-o'
        });
        // Finds all elements with `emojiable_selector` and converts them to rich emoji input fields
        // You may want to delay this step if you have dynamically created input fields that appear later in the loading process
        // It can be called as many times as necessary; previously converted input fields will not be converted again
        window.emojiPicker.discover();
    });
</script><?php
}
?>