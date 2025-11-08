<?php
/**
 * Settings Page for Telegram Channel Bot
 *
 * @package Telegram_Channel_Bot
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

function chbot_options() {
    //if is admin must be added instead
    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'شما مجوز دسترسی به این صفحه را ندارید.' ) );
    }
    $errors=array();
    $success=array();
    $settings=botscript_chbot_settings();
    if(!isset($settings['v52merged']))
    {
        botscript_chbot_install();
        $settings=botscript_chbot_settings();
    }
    if(isset($_POST['reset_default_submit']) && isset($_POST['reset_default']))
    {
        if($settings=botscript_chbot_settings(false,botscript_chbot_settings(false)))
            $success[]='تنظیمات با موفقیت به حالت پیشفرض درآمد';
    }

    if(isset($_POST['submit']))
    {
        $new_settings=$settings;
        if(isset($_POST['channel']) && isset($_POST['channel_cat']))
        {
            $i=0;
            $all_channels=array();
            $channels=array();
            $channel_signs=array();
            foreach($_POST['channel'] as $channel)
            {
                if($channel!='')
                {
                    if(!$cat_array=explode(',',$_POST['channel_cat'][$i++]))
                        $cat_array=array();
                    $channels[$channel]=$cat_array;
                    $all_channels[]=$channel;
                    if(isset($_POST['channel_sign'][$i-1]))
                        $channel_signs[$channel]=$_POST['channel_sign'][$i-1];
                }

            }
            if(count($channels))
                $new_settings['channel_pair']=$channels;
            if(count($all_channels))
                $new_settings['channels']=implode(';',$all_channels);
            if(count($channel_signs))
                $new_settings['channel_signs']=$channel_signs;
        }
        if(isset($_POST['contactbtn']))
        {
            if(isset($_POST['contactbtn']['group']))
            {
                $to_save=array();
                foreach($_POST['contactbtn']['group'] as $item)
                {
                    if($item!='')
                    {
                        $to_save[]=$item;
                    }
                }
                if(count($to_save))
                    $new_settings['contactbtn_group']=$to_save;
            }
            if(isset($_POST['contactbtn']['grouptooltip']))
            {
                $to_save=array();
                $counter=0;
                foreach($_POST['contactbtn']['grouptooltip'] as $item)
                {
                    if($_POST['contactbtn']['group'][$counter++]!='')
                        $to_save[]=$item;
                }
                if(count($to_save))
                    $new_settings['contactbtn_group_tooltip']=$to_save;
            }
            if(isset($_POST['contactbtn']['channel']))
            {
                $to_save=array();
                foreach($_POST['contactbtn']['channel'] as $item)
                {
                    if($item!='')
                    {
                        $to_save[]=$item;
                    }
                }
                if(count($to_save))
                    $new_settings['contactbtn_channel']=$to_save;
            }
            if(isset($_POST['contactbtn']['channeltooltip']))
            {
                $to_save=array();
                $counter=0;
                foreach($_POST['contactbtn']['channeltooltip'] as $item)
                {
                    if($_POST['contactbtn']['channel'][$counter++]!='')
                        $to_save[]=$item;
                }
                if(count($to_save))
                    $new_settings['contactbtn_channel_tooltip']=$to_save;
            }
            if(isset($_POST['contactbtn']['bot']))
            {
                $to_save=array();
                foreach($_POST['contactbtn']['bot'] as $item)
                {
                    if($item!='')
                    {
                        $to_save[]=$item;
                    }
                }
                if(count($to_save))
                    $new_settings['contactbtn_bot']=$to_save;
            }
            if(isset($_POST['contactbtn']['bottooltip']))
            {
                $to_save=array();
                $counter=0;
                foreach($_POST['contactbtn']['bottooltip'] as $item)
                {
                    if($_POST['contactbtn']['bot'][$counter++]!='')
                        $to_save[]=$item;
                }
                if(count($to_save))
                    $new_settings['contactbtn_bot_tooltip']=$to_save;
            }
            if(isset($_POST['contactbtn']['user']))
            {
                $to_save=array();
                foreach($_POST['contactbtn']['user'] as $item)
                {
                    if($item!='')
                    {
                        $to_save[]=$item;
                    }
                }
                if(count($to_save))
                    $new_settings['contactbtn_user']=$to_save;
            }
            if(isset($_POST['contactbtn']['usertooltip']))
            {
                $to_save=array();
                $counter=0;
                foreach($_POST['contactbtn']['usertooltip'] as $item)
                {
                    if($_POST['contactbtn']['user'][$counter++]!='')
                        $to_save[]=$item;
                }
                if(count($to_save))
                    $new_settings['contactbtn_user_tooltip']=$to_save;
            }


        }

        if(isset($_POST['contactbtn_position']))
            $new_settings['contactbtn_position']=$_POST['contactbtn_position'];

        $new_settings['contactbtn_hideinmobile']=FALSE;
        if(isset($_POST['contactbtn_hideinmobile']))
            $new_settings['contactbtn_hideinmobile']=$_POST['contactbtn_hideinmobile'];
        $new_settings['contactbtn_active']=FALSE;
        if(isset($_POST['contactbtn_active']))
            $new_settings['contactbtn_active']=$_POST['contactbtn_active'];

        if(isset($_POST['contactbtn_maincolor']))
            $new_settings['contactbtn_maincolor']=$_POST['contactbtn_maincolor'];
        if(isset($_POST['contactbtn_subcolor']))
            $new_settings['contactbtn_subcolor']=$_POST['contactbtn_subcolor'];



        if(isset($_POST['default_channel']))
            $new_settings['default_channel']=$_POST['default_channel'];
        if(isset($_POST['token']))
            $new_settings['token']=$_POST['token'];
        /*if(isset($_POST['channels']))
            $new_settings['channels']=$_POST['channels'];*/
        if(isset($_POST['sign']))
            $new_settings['sign']=$_POST['sign'];

        $new_settings['default_notif']=TRUE;//its reversed ==> means disable notification->YES do ITFALSE;//its reversed ==> means disable notification->NO do NOT
        if(isset($_POST['default_notif']))
        {
            //NOTIFICATIONS ARE ON
            $new_settings['default_notif']=FALSE;//its reversed ==> means disable notification->NO do NOT
        }

        if(isset($_POST['photocap']))
        {

            $new_settings['thumbnail']='0';
            $new_settings['photocap']='1';
        }
        else
        {
            $new_settings['thumbnail']='1';
            $new_settings['photocap']='0';
        }

        if(isset($_POST['valid_post_types']))
            $new_settings['valid_post_types']=$_POST['valid_post_types'];

        if(isset($_POST['numchars']))
            $new_settings['numchars']=$_POST['numchars'];
        if(isset($_POST['caption_numchars']))
            $new_settings['caption_numchars']=$_POST['caption_numchars'];

        $new_settings['tagsend']='0';
        if(isset($_POST['tagsend']))
        {
            $new_settings['tagsend']='1';
        }

        $new_settings['send_emptymessages']='0';
        if(isset($_POST['send_emptymessages']))
            $new_settings['send_emptymessages']='1';

        if(isset($_POST['numtags']))
            $new_settings['numtags']=$_POST['numtags'];

        $new_settings['post_active']='0';
        if(isset($_POST['post_active']))
            $new_settings['post_active']='1';

        $new_settings['edit_active']='0';
        if(isset($_POST['edit_active']))
            $new_settings['edit_active']='1';

        $new_settings['active']='0';
        if(isset($_POST['active']))
            $new_settings['active']='1';

        if(isset($_POST['template']))
            $new_settings['template']=$_POST['template'];
        if(isset($_POST['new_template']))
            $new_settings['new_template']=$_POST['new_template'];
        if(isset($_POST['continue']))
            $new_settings['continue']=$_POST['continue'];
        if(isset($_POST['imglink']))
            $new_settings['imglink']=$_POST['imglink'];

        $new_settings['nightmode']='0';
        if(isset($_POST['nightmode']))
            $new_settings['nightmode']='1';
        if(isset($_POST['nightmode_min']))
            $new_settings['nightmode_min']=$_POST['nightmode_min'];
        if(isset($_POST['nightmode_max']))
            $new_settings['nightmode_max']=$_POST['nightmode_max'];

        $new_settings['sendtosuperchannel']='0';
        if(isset($_POST['sendtosuperchannel']))
            $new_settings['sendtosuperchannel']='1';

        $new_settings['keyboard']='0';
        if(isset($_POST['keyboard']))
            $new_settings['keyboard']='1';
        $new_settings['keyboard_post_link']='0';
        if(isset($_POST['keyboard_post_link']))
            $new_settings['keyboard_post_link']='1';
        $new_settings['keyboard_blog_link']='0';
        if(isset($_POST['keyboard_blog_link']))
            $new_settings['keyboard_blog_link']='1';

        $new_settings['keyboard_post_link_text']=$settings['keyboard_post_link_text'];
        if(isset($_POST['keyboard_post_link_text']))
            $new_settings['keyboard_post_link_text']=$_POST['keyboard_post_link_text'];

        $new_settings['keyboard_blog_link_text']=$settings['keyboard_blog_link_text'];
        if(isset($_POST['keyboard_blog_link_text']))
            $new_settings['keyboard_blog_link_text']=$_POST['keyboard_blog_link_text'];

        $new_settings['keyboard_defaults']='';
        if(isset($_POST['keyboard_defaults']))
        {
            $defaults_to_save=array();
            $posted_keyboards=$_POST['keyboard_defaults'];

            $i=0;
            for($i=0;$i<count($posted_keyboards['title']);$i++){
                if(isset($posted_keyboards['title'][$i]))
                {
                    if(trim($posted_keyboards['title'][$i])!='' && trim($posted_keyboards['link'][$i])!='')
                        $defaults_to_save[]=array(
                            'title'=>$posted_keyboards['title'][$i],
                            'link'=>$posted_keyboards['link'][$i]
                        );
                }

            }
            /*while((count($posted_keyboards)-1)>=$i)
            {
                if(isset($posted_keyboards['title'][$i]))
                {
                    if(trim($posted_keyboards['title'][$i])!='' && trim($posted_keyboards['link'][$i])!='')
                        $defaults_to_save[]=array(
                            'title'=>$posted_keyboards['title'][$i],
                            'link'=>$posted_keyboards['link'][$i]
                        );
                }

                $i++;
            }*/
            if(count($defaults_to_save))
                $new_settings['keyboard_defaults']=$defaults_to_save;
        }

        $new_settings['wooregprice']='0';
        if(isset($_POST['wooregprice']))
            $new_settings['wooregprice']='1';
        $new_settings['woosaleprice']='0';
        if(isset($_POST['woosaleprice']))
            $new_settings['woosaleprice']='1';
        $new_settings['woostockstatus']='0';
        if(isset($_POST['woostockstatus']))
            $new_settings['woostockstatus']='1';
        $new_settings['wooproductbtn']='0';
        if(isset($_POST['wooproductbtn']))
            $new_settings['wooproductbtn']='1';

        if(isset($_POST['wooregprice_prefix']))
            $new_settings['wooregprice_prefix']=$_POST['wooregprice_prefix'];
        if(isset($_POST['woosaleprice_prefix']))
            $new_settings['woosaleprice_prefix']=$_POST['woosaleprice_prefix'];
        if(isset($_POST['woostockstatus_prefix']))
            $new_settings['woostockstatus_prefix']=$_POST['woostockstatus_prefix'];

        if(isset($_POST['wooproductbtntext']))
            $new_settings['wooproductbtntext']=$_POST['wooproductbtntext'];
        if(isset($_POST['woopostanchor']))
            $new_settings['woopostanchor']=$_POST['woopostanchor'];
        if(isset($_POST['woocurrency']))
            $new_settings['woocurrency']=$_POST['woocurrency'];
        if(isset($_POST['woocommerce_template']))
            $new_settings['woocommerce_template']=$_POST['woocommerce_template'];

        $new_settings['eddpricesend']='0';
        if(isset($_POST['eddpricesend']))
            $new_settings['eddpricesend']='1';
        $new_settings['eddproductbtn']='0';
        if(isset($_POST['eddproductbtn']))
            $new_settings['eddproductbtn']='1';
        if(isset($_POST['eddproductbtntext']))
            $new_settings['eddproductbtntext']=$_POST['eddproductbtntext'];
        if(isset($_POST['eddpostanchor']))
            $new_settings['eddpostanchor']=$_POST['eddpostanchor'];
        if(isset($_POST['eddcurrency']))
            $new_settings['eddcurrency']=$_POST['eddcurrency'];

        $new_settings['quick_link']='0';
        if(isset($_POST['quick_link']))
            $new_settings['quick_link']='1';
        $new_settings['quick_bold']='0';
        if(isset($_POST['quick_bold']))
            $new_settings['quick_bold']='1';
        $new_settings['quick_italic']='0';
        if(isset($_POST['quick_italic']))
            $new_settings['quick_italic']='1';

        $new_settings['quick_template']=$settings['quick_template'];
        if(isset($_POST['quick_template']))
            $new_settings['quick_template']=$_POST['quick_template'];
        $new_settings['quick_text']=$settings['quick_text'];
        if(isset($_POST['quick_text']))
            $new_settings['quick_text']=$_POST['quick_text'];

        $new_settings['bily_enabled']='0';
        if(isset($_POST['bily_enabled']))
            $new_settings['bily_enabled']='1';

        $new_settings['remove_duplicate_new_lines']='0';
        if(isset($_POST['remove_duplicate_new_lines']))
        {
            $new_settings['remove_duplicate_new_lines']='1';
        }

        $new_settings['localprocess']='0';
        if(isset($_POST['localprocess']))
        {
            $new_settings['localprocess']='1';
        }
        $new_settings['apissl']='0';
        if(isset($_POST['apissl']))
        {
            $new_settings['apissl']='1';
            //update api addresses
            $api_addr=get_option('chbot_api');
            $api_addr_root=get_option('chbot_api_root');
            if(substr($api_addr,0,5)!='https')
                update_option("chbot_api", str_replace('http', 'https', $api_addr));
            if(substr($api_addr,0,5)!='https')
                update_option("chbot_api_root", str_replace('http', 'https', $api_addr_root));

        }
        else{
            //update api addresses
            $api_addr=get_option('chbot_api');
            $api_addr_root=get_option('chbot_api_root');
            if(substr($api_addr,0,5)=='https')
                update_option("chbot_api", str_replace('https', 'http', $api_addr));
            if(substr($api_addr,0,5)=='https')
                update_option("chbot_api_root", str_replace('https', 'http', $api_addr_root));
        }
        $new_settings['automaticupdate']='0';
        if(isset($_POST['automaticupdate']))
            $new_settings['automaticupdate']='1';
        $new_settings['uploadfiles']='0';
        if(isset($_POST['uploadfiles']))
            $new_settings['uploadfiles']='1';
        $new_settings['useproxy']='0';
        if(isset($_POST['useproxy']))
            $new_settings['useproxy']='1';
        $new_settings['proxyaddress']=$settings['proxyaddress'];
        if(isset($_POST['proxyaddress']))
            $new_settings['proxyaddress']=$_POST['proxyaddress'];
        $new_settings['proxyport']=$settings['proxyport'];
        if(isset($_POST['proxyport']))
            $new_settings['proxyport']=$_POST['proxyport'];
        $new_settings['proxyusername']=$settings['proxyusername'];
        if(isset($_POST['proxyusername']))
            $new_settings['proxyusername']=$_POST['proxyusername'];
        $new_settings['proxypassword']=$settings['proxypassword'];
        if(isset($_POST['proxypassword']))
            $new_settings['proxypassword']=$_POST['proxypassword'];

        $new_settings['use_ewproxy']='0';
        if(isset($_POST['use_ewproxy']))
            $new_settings['use_ewproxy']='1';
        $new_settings['ewproxy']=$settings['ewproxy'];
        if(isset($_POST['ewproxy']))
            $new_settings['ewproxy']=$_POST['ewproxy'];

        $new_settings['use_googleproxy']='0';
        if(isset($_POST['use_googleproxy']))
            $new_settings['use_googleproxy']='1';
        $new_settings['googleproxy']=$settings['googleproxy'];
        if(isset($_POST['googleproxy']))
            $new_settings['googleproxy']=$_POST['googleproxy'];

        $settings=botscript_chbot_settings(false,$new_settings);

    }

    ?>
<link rel="stylesheet" type="text/css" href="<?php echo plugins_url( 'style.css', __FILE__ ) ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo plugins_url( 'font-awesome.min.css', __FILE__ ) ?>">
<script type='text/javascript' src="<?php echo plugins_url( 'js/jquery.min.js', __FILE__ ) ?>"></script>
<script type='text/javascript' src="<?php echo plugins_url( 'js/plugin.js', __FILE__ ) ?>"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

    <link href="<?=plugins_url( 'emoji-picker-master/lib/css/emoji.css', __FILE__ ) ?>" rel="stylesheet">
    <script src="<?=plugins_url( 'emoji-picker-master/lib/js/config.js', __FILE__ ) ?>"></script>
    <script src="<?=plugins_url( 'emoji-picker-master/lib/js/util.js', __FILE__ ) ?>"></script>
    <script src="<?=plugins_url( 'emoji-picker-master/lib/js/jquery.emojiarea.js', __FILE__ ) ?>"></script>
    <script src="<?=plugins_url( 'emoji-picker-master/lib/js/emoji-picker.js', __FILE__ ) ?>"></script>
    <style>
        .lead.emoji-picker-container {
            width: 300px;
            display: block;
            text-align: left;
            float: left;
            font-size: inherit;
            direction: ltr;
            white-space: pre-wrap;
        }
        .lead.emoji-picker-container textarea {


        }
        .clear-fix{
            clear:both;
        }
        .emoji-picker-icon {
            top: 55px;
        }

    </style>
    <div style="margin: 15px auto; width: 98%;"><?php //settings_errors();
         ?></div>
    <?php
    if(count($success))
        foreach($success as $sc)
        echo '<div class="alert" style="margin-bottom: 8px;">'.$sc.'</div>';
    if(count($errors))
        foreach($errors as $er)
            echo '<div class="alert-danger" style="margin-bottom: 8px;">'.$er.'</div>';
    ?>
    <div class="wrap" style="direction: rtl">
        <form method="post" action="">
            <?php

            $active_tab='activation';
            if($settings['license_activation']==1)
                $active_tab='general';
            if(isset($_POST['active_tab']))
                $active_tab=$_POST['active_tab'];
            ?>
            <input type="text" name="active_tab" id="ew_active_tab" value="<?=(isset($_POST['active_tab'])?$_POST['active_tab']:'activation'); ?>" hidden >
            <div class="atitle">افزونه کانال خودکار<span>نسخه 5.2.1</span> <span style="background:gainsboro;"><a href="https://eastweb.ir/wp-channel-plugin" target="_blank">دیدن خانه ی افزونه</a></span>&nbsp;<span style="background:gainsboro;"><a href="https://billing.eastweb.ir" target="_blank">پنل کاربری</a></span></div>
            <div class="wtitle">پنل اختصاصی مدیریت تنظیمات</div>
            <div class="tabs">
                <?php if($settings['license_activation']!=1): ?>
                <p id="tabactivation" href="#activation" data-target="activation"><i class="fa fa-check-circle eicon <?=($active_tab=='activation'?'active':'') ?>"></i> فعال سازی</p>
                <?php endif; ?>
                <p id="tabgeneral" href="#general" data-target="general"><i class="fa fa-gears eicon <?=($active_tab=='general'?'active':'') ?>"></i> تنظیمات همگانی</p>
                <p id="tabchannels" href="#channels" data-target="channels"><i class="fa fa-telegram eicon <?=($active_tab=='channels'?'active':'') ?>"></i> کانال ها</p>
                <p id="tabcontent" href="#content" data-target="content"><i class="fa fa-edit eicon <?=($active_tab=='content'?'active':'') ?>"></i> تنظیمات نوشته</p>
                <p id="tabquick" href="#quick" data-target="quick"><i class="fa fa-toggle-off eicon" <?=($active_tab=='quick'?'active':'') ?>></i> تنظیمات سریع</p>
                <p id="tabkeyboards" href="#keyboards" data-target="keyboards"><i class="fa fa-keyboard-o eicon <?=($active_tab=='keyboards'?'active':'') ?>"></i> کیبورد شیشه ای</p>
                <p id="tabwoocommerce" href="#woocommerce" data-target="woocommerce"><i class="fa fa-shopping-cart eicon <?=($active_tab=='woocommerce'?'active':'') ?>"></i> افزونه ووکامرس</p>
                <p id="tabedd" href="#edd" data-target="edd"><i class="fa fa-download eicon <?=($active_tab=='edd'?'active':'') ?>"></i> افزونه دانلود دیجیتال</p>
                <p id="tabchannel_widget" href="#channel_widget" data-target="channel_widget"><i class="fa fa-code eicon <?=($active_tab=='channel_widget'?'active':'') ?>"></i> ویجت و شرت کد</p>
                <p id="tabcontactbtn" href="#contactbtn" data-target="contactbtn"><i class="fa fa-circle-o-notch eicon <?=($active_tab=='contactbtn'?'active':'') ?>"></i> دکمه تماس شناور</p>
                <p id="tabbily" href="#bily" data-target="bily"><i class="fa fa-link eicon <?=($active_tab=='bily'?'active':'') ?>"></i> کوتاه کننده لینک</p>
                <p id="tabadvancedsettings" href="#advancedsettings" data-target="advancedsettings"><i class="fa fa-wrench eicon <?=($active_tab=='advancedsettings'?'active':'') ?>"></i> تنظیمات پیشرفته</p>
                <p id="tababout" href="#about" data-target="about"><i class="fa fa-info-circle eicon <?=($active_tab=='about'?'active':'') ?>"></i> درباره</p>

                <a title="شرق وب" href="https://eastweb.ir" target="_blank">
                    <div class="chbot">
                        <img src=" data:image/png;base64,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">
                    </div>
                </a>
            </div>
            <?php if($settings['license_activation']!=1): ?>
            <div class="tabs1 " id="activation" style="<?=($active_tab!='activation'?'display:none':'') ?>">
                <div class="content">
                        <?php
                        if($settings['license_activation']=='1')
                            echo '<div class="alert" style="margin-bottom: 8px;">افزونه شما با موفقیت فعال شده است.</div>';
                        else
                            echo '<div class="alert-danger" style="margin-bottom: 8px;">افزونه فعال نیست. جهت دریافت کد فعال سازی افزونه از بخش درخواست کد فعال سازی اقدام نمایید</div>';

                        ?>

                    <div class="fields">
                        <label class="title" for="sitename">ایمیل :</label>
                        <input type="text" dir="ltr" id="email" name="email" value="<?=$settings['email'];?>" placeholder="ایمیل خود را وارد کنید">
                        <div class="des">
                            <a href="https://eastweb.ir/wp-channel-plugin/" target="_blank">
   اگر ایمیل خود را در سامانه شرق وب ثبت کرده اید آن را وارد کنید. یا از طریق بخش درخواست کد فعال سازی اقدام نمایید
                                </a>
                        </div>

                    </div>
                    <div class="fields">
                        <label class="title" for="sitename">کلیدفعالسازی :</label>
                        <input type="text" dir="ltr" id="key" name="key" value="<?=$settings['key'];?>" placeholder="کدفعالسازی را وارد کنید">
                        <div class="des">
                            <a href="https://eastweb.ir/wp-channel-plugin/" target="_blank"> اگر کلید فعالسازی را از سامانه شرق وب دریافت کرده اید آن را وارد کنید. یا از طریق بخش درخواست کد اقدام کنید</a>
                        </div>

                    </div>

                        <?php
                        if($settings['license_activation']!='1'):
                        ?><div class="etext" style="text-align: center;">
                        پس از وارد کردن ایمیل و کد فعال سازی بر روی دکمه ذخیره تنظیمات کلیک کنید
                            <button type="submit" name="submit" id="submit" >بررسی کلید و ذخیره تنظیمات</button>
                        </div>
                        <?php endif; ?>

                    <?php if($settings['license_activation']!='1'): ?>
                        <h3 class="ehead">درخواست کد لایسنس فعال سازی</h3>
                        <div class="etext">
                            اگر افزونه را به صورت رسمی از شرق وب تهیه نموده اید یک کلید فعال سازی در اختیار شما قرار داده شده است که به وسیله آن می توانید افزونه را فعال و رجیستر کنید و اگر افزونه را از طریق ژاکت(zhaket.ir) خریداری نموده اید. لطفا شماره سفارش خود را از طریق فیلدهای زیر ارسال نمایید تا پس از بررسی لایسنس فعال سازی برایتان ارسال گردد. <a href="https://eastweb.ir/wp-channel-plugin/" target="_blank" style="color:#0c96d7;"> (اگر هنوز افزونه کانال خودکار را خریداری نکرده اید کلیک کنید.)</a>
                        </div>
                        <div class="fields">
                            <label class="title" for="request_email">ایمیل :</label>
                            <input type="text" id="request_email" name="request_email" value="" placeholder="ایمیل خود را وارد کنید">
                            <div class="des">
                                 درصورتی که خرید شما از ژاکت تایید شود، به وسیله این ایمیل در پنل پشتیبانی شرق وب ثبت نام خواهید شد.
                            </div>

                        </div>
                        <div class="fields">
                            <label class="title" for="purchase_code">شماره سفارش در مارکت وردپرس :</label>
                            <input type="text" id="purchase_code" name="purchase_code" value="" placeholder="کد سفارش خرید را وارد کنید">
                            <div class="des">
                                اگر افزونه را به صورت رسمی از ژاکت(zhaket.ir) خریداری کرده اید، با ارائه شماره سفارش و درصورت تایید شناسه فعال سازی دریافت خواهید کرد.
                            </div>

                        </div>
                        <div style="text-align: center">
                            <button class="requestbutton" type="submit" name="request_code" id="request_code" style="float: unset;background: #3cc919;" <?=($settings['license_activation']!='1'?'':'disabled'); ?>>ارسال درخواست کدفعال سازی</button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
            <div class="tabs1" id="general" style="<?=($active_tab!='general'?'display:none':'') ?>">
                <div class="content">
                    <div class="fields">
                        <label class="title" for="active">افزونه فعال باشد :</label>
                        <div class="checkbox">
                            <input type="checkbox" value="0"  id="active"
                                   name="active" <?php echo $settings['active'] == '1' ? "checked" : ""; ?>
                                   onclick="validate()">
                            <label for="active"></label>
                        </div>
                        <div class="des">اگر نمی خواهید افزونه به فعالیت خود ادامه دهد این گزینه را غیرفعال کنید.</div>
                    </div>
                    <div class="fields">
                        <label class="title" for="nightmode">حالت شب :</label>
                        <div class="checkbox">
                            <input type="checkbox" value="0"  id="nightmode"
                                   name="nightmode" <?php echo $settings['nightmode'] == '1' ? "checked" : ""; ?>
                                   onclick="validate()">
                            <label for="nightmode"></label>
                        </div>
                        <div class="night-mode-settings">
                            ساعت شروع و پایان را مشخص کنید(فرمت 0-23): <input class="nightmode" type="number" name="nightmode_max" min="0" max="23" value="<?= $settings['nightmode_max'] ?>" placeholder="پس از" <?php echo $settings['nightmode'] == '1' ? "" : "disabled"; ?>>
                            <input class="nightmode" type="number" name="nightmode_min" min="0" max="23" value="<?= $settings['nightmode_min'] ?>" placeholder="قبل از" <?php echo $settings['nightmode'] == '1' ? "" : "disabled"; ?>>
                        </div>
                        <div class="des">با فعال سازی این گزینه می توانید ارسال به کانال را در طول شب متوقف کنید.</div>
                    </div>
                    <script type="text/javascript">
                        jQuery(document).ready(function($) {
                            $( "body" ).delegate( "#nightmode", "click", function(event) {
                                if($(this).is(':checked'))
                                {
                                    $('.nightmode').prop('disabled', function(i, v) { return !v; });
                                }
                            });

                            $( "body" ).delegate( "#tg_token_tester", "click", function(event) {
                                event.preventDefault();
                                if($('#token').val()!==''){
                                    //send ajax request to server for check the token
                                    var data = {
                                        'action': 'wpch_settings',
                                        'operation': 'check_token',
                                        'token':$('#token').val()
                                    };

                                    // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
                                    $('#token_tester_result').text('در حال بررسی...')
                                    jQuery.post(ajaxurl, data, function(response) {
                                        var resp=JSON.parse(response);
                                        if(resp){
                                            if(resp.ok)
                                                $('#token_tester_result').html(resp.message);
                                            else
                                                $('#token_tester_result').html(resp.error);
                                        }

                                    });

                                }
                                else
                                    $('#token_tester_result').html('لطفا ابتدا یک توکن معتبر وارد کنید!');
                            });

                        });

                    </script>
                    <div class="fields">
                        <label class="title" for="token">توکن ربات :</label>
                        <input type="text" id="token" name="token" value="<?= $settings['token'] ?>" placeholder="توکن ربات تلگرام خود را وارد کنید" dir="ltr">
                        <button id="tg_token_tester" role="button" class="btn btn-sm">تست توکن</button>
                        <div class="des">
                            (مثال. 123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11)
                        </div>
                        <p id="token_tester_result"></p>

                    </div>
                    <div class="fields">
                        <label class="title" for="sign">امضای دلخواه :</label>
                        <textarea id="sign" name="sign"  placeholder="امضای دلخواهی را وارد کنید"><?= $settings['sign'] ?></textarea>
                        <div class="des">
                            مثال: شرق وب پیشتاز در نوآوری
                        </div>

                    </div>
                    <div class="fields">
                        <label class="title" for="valid_post_types">پست تایپ های مجاز :</label>
                        <input type="text" dir="ltr" id="valid_post_types" name="valid_post_types" value="<?= $settings['valid_post_types'] ?>" placeholder="نامک پست تایپ(ها) را وارد کنید">
                        <div class="des">
                            مثال: post,page,product,download دقت داشته باشید که پست تایپ ها را بایستی با کاما(ویرگول) انگلیسی از یکدیگر جدا کنید.
                        </div>

                    </div>

                    <div class="fields">
                        <label class="title" for="sendtosuperchannel">ارسال پست های شما به سوپرکانال ایران(صرفا با ewproxy) :</label>
                        <div class="checkbox">
                            <input type="checkbox" value="0"  id="sendtosuperchannel"
                                   name="sendtosuperchannel" <?php echo $settings['sendtosuperchannel'] == '1' ? "checked" : ""; ?>
                                   onclick="validate()">
                            <label for="sendtosuperchannel"></label>
                        </div>
                        <div class="des">سرویس کانال خودکار در اختیار بسیاری از سایت های ایرانی قرار دارد. به جهت افزایش بهره وری و بیشتر دیده شدن می توانید با فعال نمودن این گزینه نوشته های تان را در یک کانال دسته جمعی به همراه سایر سایت ها ارسال نمایید.این گزینه ممکن است فقط با پراکسی اختصاصی در دسترس باشد.</div>
                    </div>
                    <div class="etext">
                        <a href="https://t.me/irsuper" target="_blank" style="color:dodgerblue">مشاهده سوپر کانال ایران</a>
                    </div>

                </div>
            </div>
            <div class="tabs1 " id="channels" style="<?=($active_tab!='channels'?'display:none':'') ?>">
                <div class="content" id="">
                    <div class="fields">
                        <label class="title" for="default_channel">حالت پیش فرض :</label>
                        <select name="default_channel" class="postform">
                            <option value="all" <?=($settings['default_channel']=='all'?'selected':'') ?>>همه کانال ها</option>
                            <option value="auto" <?=($settings['default_channel']=='auto'?'selected':'') ?>>بر اساس دسته بندی</option>
                        </select>
                        <div class="des">
حالت پیشفرض ارسال به کانال ها را مشخص کنید. نگران نباشید این تنظیم در هر نوشته قابل شخصی سازی است.
                        </div>

                    </div>
                    <div id="channels_area">
                        <?php
                        $channel_flag=false;
                        $channels=array();
                        if($settings['channels'])
                        {
                            $channels=explode(';',$settings['channels']);
                        }
                            if(count($channels))
                                foreach ($channels as $channel):

                                    $channel_flag=true;
                        ?>
                                    <div class="fields">
                                        <button class="close-field-btn btn">&times;</button>
                                        <br>
                                        <div class="dual-col">
                                            <label>آدرس عمومی کانال: </label>
                                            <input type="text" dir="ltr" class="channel-username"   name="channel[]" value="<?=$channel; ?>" placeholder="نام کاربری کانال تلگرام خود را وارد کنید">
                                            <div class="des">
                                                نام کاربری کانال خود را با فرمت @channelname وارد نمایید.
                                            </div>
                                        </div>
                                        <div class="dual-col">
                                            <label>ID دسته های مخصوص این کانال: </label>
                                            <input type="text" dir="ltr"   name="channel_cat[]" value="<?=implode(',',$settings['channel_pair'][$channel]); ?>" placeholder="ID دسته ها را وارد کنید">
                                            <div class="des">
                                                ID دسته هایی را که می خواهید فقط در این کانال ارسال شوند را با کاما جدا کرده و وارد نمایید. مثال: 17,23,45 <a href="https://eastweb.ir/?p=3073">*آموزش به دست آوردن ID دسته*</a>
                                            </div>
                                        </div>
                                        <div class="dual-col">
                                            <label>امضای کانال: </label>
                                            <textarea dir="ltr"   name="channel_sign[]" placeholder="امضای مخصوص این کانال تلگرام را وارد کنید"><?=(isset($settings['channel_signs'][$channel])?$settings['channel_signs'][$channel]:''); ?></textarea>
                                            <div class="des">
می توانید برای هر کانال به صورت جداگانه امضایی در نظر بگیرید، کد {channel_sign} در قالب ارسال، این امضاء را تداعی می کند.                                            </div>
                                        </div>
                                        <div class="dual-col">
                                            <button role="button" class="tg_check_channel btn btn-sm">تست دسترسی ربات به کانال</button>
                                            <p class="tg_check_channel_result"></p>
                                        </div>

                                    </div>

                                    <?php

                                endforeach;

                        if(!$channel_flag)
                        {
                        ?>
                        <div class="fields">
                            <button class="close-field-btn btn">&times;</button>
                            <br>
                            <div class="dual-col">
                                <label>آدرس عمومی کانال: </label>
                                <input type="text" dir="ltr" class="channel-username"  name="channel[]" value="" placeholder="نام کاربری کانال تلگرام خود را وارد کنید">
                                <div class="des">
                                    نام کاربری کانال خود را با فرمت @channelname وارد نمایید.
                                </div>
                            </div>
                            <div class="dual-col">
                                <label>ID دسته های مخصوص این کانال: </label>
                                <input type="text" dir="ltr"   name="channel_cat[]" value="" placeholder="ID دسته ها را وارد کنید">
                                <div class="des">
                                    ID دسته هایی را که می خواهید فقط در این کانال ارسال شوند را با کاما جدا کرده و وارد نمایید. مثال: 17,23,45 <a href="https://eastweb.ir/?p=3073">*آموزش به دست آوردن ID دسته*</a>
                                </div>
                            </div>
                            <div class="dual-col">
                                <label>امضای کانال: </label>
                                <textarea  dir="ltr"   name="channel_sign[]" value="" placeholder="امضای مخصوص این کانال تلگرام را وارد کنید"></textarea>
                                <div class="des">
                                    می توانید برای هر کانال به صورت جداگانه امضایی در نظر بگیرید، کد {channel_sign} در قالب ارسال، این امضاء را تداعی می کند.                                                </div>
                            </div>
                            <div class="dual-col">
                                <button role="button" class="btn btn-sm tg_check_channel">تست دسترسی ربات به کانال</button>
                                <p class="tg_check_channel_result"></p>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                    </div>

                    <div class="add-channel-btn-container">
                        <button class="btn" id="add-channel"><i class="fa fa-plus"></i> افزودن یک کانال دیگر</button>
                    </div>
                    <script type="text/javascript">
                        jQuery(document).ready(function($) {
                            $( "body" ).delegate( "#add-channel", "click", function(event) {
                                event.preventDefault();
                                $('#channels_area').append('<div class="fields"> <button class="close-field-btn btn">&times;</button> <br> <div class="dual-col"> <label>آدرس عمومی کانال: </label> <input type="text" class="channel-username" name="channel[]" dir="ltr"  value="" placeholder="نام کاربری کانال تلگرام خود را وارد کنید"> <div class="des"> نام کاربری کانال خود را با فرمت @channelname وارد نمایید. </div> </div> <div class="dual-col"> <label>ID دسته های مخصوص این کانال: </label> <input type="text"  name="channel_cat[]" dir="ltr"  value="" placeholder="ID دسته ها را وارد کنید"> <div class="des"> ID دسته هایی را که می خواهید فقط در این کانال ارسال شوند را با کاما جدا کرده و وارد نمایید. مثال: 17,23,45 <a href="https://eastweb.ir/?p=3073">*آموزش به دست آوردن ID دسته*</a> </div> </div><div class="dual-col"><label>امضای کانال: </label><textarea dir="ltr"   name="channel_sign[]" value="" placeholder="امضای مخصوص این کانال تلگرام را وارد کنید"></textarea>><div class="des">می توانید برای هر کانال به صورت جداگانه امضایی در نظر بگیرید، کد {channel_sign} در قالب ارسال، این امضاء را تداعی می کند.                                           </div></div><div class="dual-col"> <button  role="button" class="tg_check_channel btn btn-sm">تست دسترسی ربات به کانال</button><p class="tg_check_channel_result"></p></div></div>');
                            });
                            $( "body" ).delegate( ".close-field-btn", "click", function(event) {
                                event.preventDefault();
                                $(this).closest('.fields').remove();
                            });

                            $( "body" ).delegate( ".tg_check_channel", "click", function(event) {
                                event.preventDefault();
                                if($('#token').val()!==''){
                                    if($(this).closest('.fields').find('input.channel-username').val()!==''){
                                        var data = {
                                            'action': 'wpch_settings',
                                            'operation': 'check_channel',
                                            'token':$('#token').val(),
                                            'channel':$(this).closest('.fields').find('input.channel-username').val()
                                    };
                                        //alert($(this).closest('.fields').find('input.channel-username').val());

                                        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
                                        $(this).siblings('.tg_check_channel_result').text('در حال بررسی...')
                                        var element=$(this);
                                        jQuery.post(ajaxurl, data, function(response) {
                                            var resp=JSON.parse(response);
                                            if(resp){
                                                if(resp.ok)
                                                    element.siblings('.tg_check_channel_result').text(resp.message);
                                                else
                                                    element.siblings('.tg_check_channel_result').text(resp.error);
                                            }

                                        });
                                    }
                                    else
                                        $(this).siblings('.tg_check_channel_result').html('نام کاربری کانال خالی است!');

                                }
                                else
                                    $(this).siblings('.tg_check_channel_result').html('لطفا ابتدا یک توکن معتبر وارد کنید!');
                            });
                        });

                    </script>
                </div>
            </div>
            <div class="tabs1 " id="content" style="<?=($active_tab!='content'?'display:none':'') ?>">
                <div class="content">
                    <div class="fields">
                        <label class="title" for="star_ratings">حالت اعلان(Notification) :</label>

                        <div class="checkbox">
                            <input type="checkbox" value="0"  id="default_notif"
                                   name="default_notif" <?php echo $settings['default_notif'] == FALSE ? "checked" : ""; ?>
                                   onclick="validate()">
                            <label for="default_notif"></label>
                        </div>
                        <div class="des">این گزینه نشان می دهد که به صورت پیش فرض، پیامی که در تلگرام ارسال می شود اعلان داشته باشد یا خیر</div>
                    </div>
                    <div class="fields">
                        <label class="title" for="star_ratings">حالت کپشن(آپلود عکس) :</label>

                        <div class="checkbox">
                            <input type="checkbox" value="0"  id="photocap"
                                   name="photocap" <?php echo $settings['photocap'] == '1' ? "checked" : ""; ?>
                                   onclick="validate()">
                            <label for="photocap"></label>
                        </div>
                        <div class="des">اگر این گزینه را فعال کنید متن کمتری همراه با تصویر بزرگ در کانال به نمایش در خواهد آمد</div>
                    </div>
                    <div class="fields">
                        <label class="title" for="post_active">ارسال به کانال در نوشته های جدید :</label>
                        <div class="checkbox">
                            <input type="checkbox" value="0"  id="post_active"
                                   name="post_active" <?php echo $settings['post_active'] == '1' ? "checked" : ""; ?>
                                   onclick="validate()">
                            <label for="post_active"></label>
                        </div>
                        <div class="des">این گزینه نشان می دهد که به صورت پیش فرض تیک ارسال به کانال در چه وضعیتی باشد.</div>
                    </div>
                    <div class="fields">
                        <label class="title" for="edit_active">خاموش نگه داشتن ارسال به کانال در ویرایش نوشته :</label>
                        <div class="checkbox">
                            <input type="checkbox" value="0"  id="edit_active"
                                   name="edit_active" <?php echo $settings['edit_active'] == '1' ? "checked" : ""; ?>
                                   onclick="validate()">
                            <label for="edit_active"></label>
                        </div>
                        <div class="des">این گزینه نشان می دهد که به صورت پیش فرض تیک ارسال به کانال در هنگام ویرایش یک نوشته قدیمی در چه وضعیتی باشد. برای عدم ارسال، این گزینه را روشن کنید.</div>
                    </div>
                    <div class="fields">
                        <label class="title" for="send_emptymessages">ارسال پست های بدون متن :</label>
                        <div class="checkbox">
                            <input type="checkbox" value="0"  id="send_emptymessages"
                                   name="send_emptymessages" <?php echo $settings['send_emptymessages'] == '1' ? "checked" : ""; ?>
                                   onclick="validate()">
                            <label for="send_emptymessages"></label>
                        </div>
                        <div class="des">اگر می خواهید پست های بدون متن نیز ارسال شود این گزینه را فعال کنید.</div>
                    </div>
                    <div class="fields">
                        <label class="title" for="remove_duplicate_new_lines">حذف خطوط خالی اضافه :</label>
                        <div class="checkbox">
                            <input type="checkbox" value="0"  id="remove_duplicate_new_lines"
                                   name="remove_duplicate_new_lines" <?php echo $settings['remove_duplicate_new_lines'] == '1' ? "checked" : ""; ?>
                                   onclick="validate()">
                            <label for="remove_duplicate_new_lines"></label>
                        </div>
                        <div class="des">اگر می خواهید فواصل ایجاد شده در خطوط از متن حذف شوند این گزینه را روشن کنید.</div>
                    </div>
                    <div class="fields">
                        <label class="title" for="tagsend">ارسال تگ(برچسب) :</label>
                        <div class="checkbox">
                            <input type="checkbox" value="0"  id="tagsend"
                                   name="tagsend" <?php echo $settings['tagsend'] == '1' ? "checked" : ""; ?>
                                   onclick="validate()">
                            <label for="tagsend"></label>
                        </div>
                        <div class="des">اگر می خواهید تگ های نوشته نیز ارسال شود این گزینه را فعال کنید.</div>
                    </div>
                    <div class="fields">
                        <label class="title" for="numtags">تعداد تگ های ارسالی :</label>
                        <input type="number" id="numtags" name="numtags" value="<?= $settings['numtags'] ?>" placeholder="تعداد تگ ها را وارد کنید">
                        <div class="des">
حداکثر تعداد تگ قابل ارسال را مشخص کنید.                        </div>

                    </div>
                    <div class="fields">
                        <label class="title" for="continue">متن ادامه مطلب :</label>
                        <input type="text" id="continue" name="continue" value="<?= $settings['continue'] ?>" placeholder="ادامه مطلب...">
                        <div class="des">
                            متنی که در لینک به نوشته ی شما درج می شود را از این قسمت می توانید تنظیم کنید. اگر نمی خواهید پیوندی به نوشته ی شما وجود داشته باشد کد {link_anchor} را از قالب ارسال حذف نمایید. در صورتی که این فیلد خالی باشد پیوندک نوشته ی شما در محل مورد نظر قرار خواهد گرفت.(این پیوند در هنگام ارسال تصویر همراه با عنوان(caption)، در عنوان تصویر قابل درج نیست)
                        </div>

                    </div>
                    <div class="fields">
                        <label class="title" for="imglink">کاراکتر تصویر :</label>
                        <input type="text" id="imglink" name="imglink" value="<?= $settings['imglink'] ?>" placeholder="#">
                        <div class="des">
                            در روش ارسال تصویر به همراه متن بلند، جهت دور زدن محدودیت تلگرام یعنی تعداد کاراکترها، جهت نمایش تصویر شاخص از لینک مستقیم به این تصویر در ابتدای پیام استفاده می شود. این لینک جهت کوتاه شدن می تواند در یک کاراکتر یا متنی خاص مستتر باشد. در صورت خالی بودن، لینک در کاراکتر . یا همان نقطه، درج خواهد شد.
                        </div>

                    </div>
                   <!-- <div class="fields">
                        <label class="title" for="template">قالب پیام ارسالی :</label>
                        <textarea id="template" name="template" style="direction: ltr "><?= $settings['template'] ?></textarea>
                        <div class="des">کدهای کوتاه قابل استفاده: [bot_post_title] , [bot_post_body] , [bot_post_excerpt] , [bot_post_shortlink] , [bot_sign],[bot_post_tags]
                                                    </div>

                    </div>-->
                    <div class="fields">
                        <label class="title" for="new_template">قالب پیام ارسالی :</label>
                        <div class="lead emoji-picker-container">
                            <textarea id="new_template" name="new_template" style="direction: ltr " dir="ltr" aria-multiline="true" data-emoji-input="unicode" data-emojiable="true"><?= $settings['new_template'] ?></textarea>
                        </div>
                        <div class="clear-fix"></div>
                        <?php

                        ?>

                        <div class="des">کدهای کوتاه قابل استفاده: {image_anchor},{title},{post_type_data},{body},{tags},{link_anchor},{sign},{author},{channel_sign},{main_category}
                        </div>

                    </div>
                    <div class="fields">
                        <label class="title" for="caption_numchars">تعداد کاراکتر در هر کپشن :</label>
                        <input type="number" max="900" min="0" id="caption_numchars" name="caption_numchars" value="<?= $settings['caption_numchars'] ?>" placeholder="تعداد تگ ها را وارد کنید">
                        <div class="des">
                            تعداد کاراکتر در هر پیام ارسالی توسط این افزونه را مشخص کنید.حداکثر تعداد کاراکتر 900 می باشد. هرچه تعداد کمتری انتخاب کنید احتمال دریافت خطای کمتری خواهید داشت.                         </div>

                    </div>
                    <div class="fields">
                        <label class="title" for="numchars">تعداد کاراکتر در هر پیام(متن خالی) :</label>
                        <input type="number" max="3000" min="0" id="numchars" name="numchars" value="<?= $settings['numchars'] ?>" placeholder="تعداد تگ ها را وارد کنید">
                        <div class="des">
                            تعداد کاراکتر در هر پیام ارسالی توسط این افزونه را مشخص کنید.حداکثر تعداد کاراکتر 3000 می باشد.                         </div>

                    </div>


                </div>
            </div>
            <div class="tabs1 " id="quick" style="<?=($active_tab!='quick'?'display:none':'') ?>">
                <div class="content">
                    <div class="fields">
                        <div class="dual-col">
                        <label>حالت پیشفرض قالب ارسال :</label>
                        <div class="des">شاید بخواهید از این پس در هنگام ایجاد نوشته تنظیمات کمتری را انجام دهید. حالت پیشفرض باکس تنظیمات سریع را انتخاب نمایید.</div>
                    </div>
                        <div class="dual-col quick-inputs">
                            <input type="radio" id="qt1" name="quick_template" value="default" <?php  if($settings['quick_template']=='default') echo 'checked';?> />پیشفرض<br />
                            <input type="radio" id="qt2" name="quick_template" value="caption" <?php  if($settings['quick_template']=='caption') echo 'checked';?>/>تصویر+کپشن<br />
                            <input type="radio" id="qt3" name="quick_template" value="image_text" <?php  if($settings['quick_template']=='image_text') echo 'checked';?>/>متن بلند و تصویر<br />
                            <input type="radio" id="qt4" name="quick_template" value="text" <?php  if($settings['quick_template']=='text') echo 'checked';?> />فقط متن<br />

                        </div>
                    </div>
                    <div class="fields">
                        <div class="dual-col">
                            <label>حالت پیشفرض متن ارسالی :</label>
                            <div class="des">شاید بخواهید از این پس در هنگام ایجاد نوشته تنظیمات کمتری را انجام دهید. حالت پیشفرض باکس تنظیمات سریع را انتخاب نمایید.</div>
                        </div>
                        <div class="dual-col quick-inputs">
                        <input type="radio" name="quick_text" value="title" <?php  if($settings['quick_text']=='title') echo 'checked';?> >فقط عنوان</input><br />
                        <input type="radio" name="quick_text" value="default" <?php  if($settings['quick_text']=='default') echo 'checked';?> >چکیده خودکار(در تصویر+کپشن) یا متن برش خورده(متن بلند)</input><br />
                        <input type="radio" name="quick_text" value="excerpt_box" <?php  if($settings['quick_text']=='excerpt_box') echo 'checked';?>>محتوای باکس چکیده</input><br />
                        <input type="radio" name="quick_text" value="chbot_box" <?php  if($settings['quick_text']=='chbot_box') echo 'checked';?>>محتوای باکس افزونه کانال خودکار</input>

                        </div>
                    </div>
                    <div class="fields">
                        <label class="title" for="quick_link">ارسال لینک HTML :</label>
                        <div class="checkbox">
                            <input type="checkbox" value="1"  id="quick_link"
                                   name="quick_link" <?php echo $settings['quick_link'] == '1' ? "checked" : ""; ?>
                                   onclick="validate()">
                            <label for="quick_link"></label>
                        </div>
                        <div class="des">اگر نمی خواهید لینک های درون متن به صورت قابل کلیک به تلگرام ارسال شوند این گزینه را غیرفعال کنید.</div>
                    </div>
                    <div class="fields">
                        <label class="title" for="quick_bold">ارسال متون <b>BOLD</b> :</label>
                        <div class="checkbox">
                            <input type="checkbox" value="1"  id="quick_bold"
                                   name="quick_bold" <?php echo $settings['quick_bold'] == '1' ? "checked" : ""; ?>
                                   onclick="validate()">
                            <label for="quick_bold"></label>
                        </div>
                        <div class="des">اگر نمی خواهید متن های <b>درشت(بولد)</b> به تلگرام ارسال شوند این گزینه را غیرفعال کنید.</div>
                    </div>
                    <div class="fields">
                        <label class="title" for="quick_italic">ارسال متون <i>italic</i> :</label>
                        <div class="checkbox">
                            <input type="checkbox" value="1"  id="quick_italic"
                                   name="quick_italic" <?php echo $settings['quick_italic'] == '1' ? "checked" : ""; ?>
                                   onclick="validate()">
                            <label for="quick_italic"></label>
                        </div>
                        <div class="des">اگر نمی خواهید متن های <i>مورب(ایتالیک)</i> به تلگرام ارسال شوند این گزینه را غیرفعال کنید.</div>
                    </div>


                </div>
            </div>
            <div class="tabs1 " id="keyboards" style="<?=($active_tab!='keyboards'?'display:none':'') ?>">
                <div class="content">
                    <div class="fields">
                        <label class="title" for="keyboard">کیبورد شیشه ای فعال باشد :</label>
                        <div class="checkbox">
                            <input type="checkbox" value="1"  id="keyboard"
                                   name="keyboard" <?php echo $settings['keyboard'] == '1' ? "checked" : ""; ?>
                                   onclick="validate()">
                            <label for="keyboard"></label>
                        </div>
                        <div class="des">اگر نمی خواهید نوشته های ارسالی به کانال تان کیبورد شیشه ای داشته باشد این گزینه را غیرفعال کنید.</div>
                    </div>
                    <div class="fields">
                        <label class="title" for="keyboard_post_link">دکمه لینک مستقیم به نوشته در کیبورد شیشه ای :</label>
                        <div class="checkbox">
                            <input type="checkbox" value="1"  id="keyboard_post_link"
                                   name="keyboard_post_link" <?php echo $settings['keyboard_post_link'] == '1' ? "checked" : ""; ?>
                                   onclick="validate()">
                            <label for="keyboard_post_link"></label>
                        </div>
                        <div class="des">اگر نمی خواهید لینک مستقیم به نوشته در کیبورد شیشه ای درج شود این گزینه را غیرفعال کنید.</div>
                    </div>
                    <div class="fields">
                        <label class="title" for="keyboard_post_link_text">متن دکمه لینک مستقیم به نوشته :</label>
                        <input type="text" id="keyboard_post_link_text" name="keyboard_post_link_text" value="<?= $settings['keyboard_post_link_text'] ?>" placeholder="عنوان را وارد کنید">
                        <div class="des">
عنوان دکمه لینک مستقیم به نوشته را مشخص کنید. در صورت خالی بودن سیستم از عنوان پیشفرض استفاده خواهد کرد.کد قابل استفاده: {post_title}                        </div>

                    </div>
                    <div class="fields">
                        <label class="title" for="keyboard_blog_link">دکمه لینک مستقیم به صفحه اصلی سایت در کیبورد شیشه ای :</label>
                        <div class="checkbox">
                            <input type="checkbox" value="1"  id="keyboard_blog_link"
                                   name="keyboard_blog_link" <?php echo $settings['keyboard_blog_link'] == '1' ? "checked" : ""; ?>
                                   onclick="validate()">
                            <label for="keyboard_blog_link"></label>
                        </div>
                        <div class="des">اگر نمی خواهید لینک مستقیم به صفحه اصلی سایت در کیبورد شیشه ای درج شود این گزینه را غیرفعال کنید.</div>
                    </div>
                    <div class="fields">
                        <label class="title" for="keyboard_blog_link_text">متن دکمه لینک مستقیم به صفحه اصلی سایت :</label>
                        <input type="text" id="keyboard_blog_link_text" name="keyboard_blog_link_text" value="<?= $settings['keyboard_blog_link_text'] ?>" placeholder="عنوان را وارد کنید">
                        <div class="des">
                            عنوان دکمه لینک مستقیم به صفحه اصلی سایت را مشخص کنید. در صورت خالی بودن سیستم از عنوان پیشفرض استفاده خواهد کرد. کد قابل استفاده: {site_name}                        </div>

                    </div>

                    <h3 class="ehead">دکمه های پیش فرض</h3>
                    <div id="keyboards_area">
                        <?php
                        $keyboard_flag=false;
                        $keyboards=array();
                        if(isset($settings['keyboard_defaults']))
                        {
                            if(is_array($settings['keyboard_defaults']))
                                $keyboards=$settings['keyboard_defaults'];
                        }
                        if(is_array($keyboards))
                        {
                            if(@count($keyboards))
                                foreach ($keyboards as $keyboard):

                                    $keyboard_flag=true;
                                    ?>
                                    <div class="fields">
                                        <button class="close-field-btn btn">&times;</button>
                                        <br>
                                        <div class="dual-col">
                                            <label>عنوان لینک شیشه ای: </label>
                                            <input type="text"  name="keyboard_defaults[title][]" value="<?=$keyboard['title'] ?>" placeholder="برای لینک شیشه ای یک عنوان وارد کنید">
                                            <div class="des">
                                                این عنوان روی دکمه ظاهر و به کاربر نشان داده خواهد شد
                                            </div>
                                        </div>
                                        <div class="dual-col">
                                            <label>لینک دکمه</label>
                                            <input type="text" dir="ltr"  name="keyboard_defaults[link][]" value="<?=$keyboard['link'] ?>" placeholder="لینک این دکمه را وارد کنید.">
                                            <div class="des">
                                                کاربر پس از کلیک روی دکمه به این لینک هدایت می شود. لینک باید معتبر و استاندارد باشد.
                                            </div>
                                        </div>

                                    </div>

                                <?php

                                endforeach;
                        }

                        if(!$keyboard_flag)
                        {
                            ?>
                            <div class="fields">
                                <button class="close-field-btn btn">&times;</button>
                                <br>
                                <div class="dual-col">
                                    <label>عنوان لینک شیشه ای: </label>
                                    <input type="text"  name="keyboard_defaults[title][]" value="" placeholder="برای لینک شیشه ای یک عنوان وارد کنید">
                                    <div class="des">
                                        این عنوان روی دکمه ظاهر و به کاربر نشان داده خواهد شد
                                    </div>
                                </div>
                                <div class="dual-col">
                                    <label>لینک دکمه</label>
                                    <input type="text" dir="ltr"  name="keyboard_defaults[link][]" value="" placeholder="لینک این دکمه را وارد کنید.">
                                    <div class="des">
                                        کاربر پس از کلیک روی دکمه به این لینک هدایت می شود. لینک باید معتبر و استاندارد باشد.
                                    </div>
                                </div>

                            </div>
                            <?php
                        }
                        ?>
                    </div>

                    <div class="add-channel-btn-container">
                        <button class="btn" id="add-keyboard"><i class="fa fa-plus"></i> افزودن یک کلید</button>
                    </div>
                    <script type="text/javascript">
                        jQuery(document).ready(function($) {
                            $( "body" ).delegate( "#add-keyboard", "click", function(event) {
                                event.preventDefault();
                                $('#keyboards_area').append('<div class="fields"> <button class="close-field-btn btn">&times;</button> <br><div class="dual-col"> <label>عنوان لینک شیشه ای: </label> <input type="text" name="keyboard_defaults[title][]" value="" placeholder="برای لینک شیشه ای یک عنوان وارد کنید"> <div class="des"> این عنوان روی دکمه ظاهر و به کاربر نشان داده خواهد شد </div></div><div class="dual-col"> <label>لینک دکمه</label> <input dir="ltr"  type="text" name="keyboard_defaults[link][]" value="" placeholder="لینک این دکمه را وارد کنید."> <div class="des"> کاربر پس از کلیک روی دکمه به این لینک هدایت می شود. لینک باید معتبر و استاندارد باشد. </div></div></div>');
                            });

                        });

                    </script>

                </div>
            </div>
            <div class="tabs1 " id="woocommerce" style="<?=($active_tab!='woocommerce'?'display:none':'') ?>">
                <div class="content">
                    <div class="fields">
                        <label class="title" for="woocommerce_template">قالب دیتای محصول :</label>
                        <div class="lead emoji-picker-container">
                            <textarea id="woocommerce_template" name="woocommerce_template" style="direction: ltr " aria-multiline="true"  data-emoji-input="unicode" data-emojiable="true"><?= $settings['woocommerce_template'] ?></textarea>
                        </div>
                        <div class="clear-fix"></div>

                        <div class="des">کدهای کوتاه قابل استفاده: {stock_status} , {sale_price} , {regular_price}
                        </div>

                    </div>
                    <div class="fields">
                        <label class="title" for="wooregprice">ارسال قیمت همیشه روشن باشد :</label>
                        <div class="checkbox">
                            <input type="checkbox" value="1"  id="wooregprice"
                                   name="wooregprice" <?php echo $settings['wooregprice'] == '1' ? "checked" : ""; ?>
                                   onclick="validate()">
                            <label for="wooregprice"></label>
                        </div>
                        <div class="des">اگر نمی خواهید قیمت محصولتان در کانال ارسال شود این گزینه را غیرفعال کنید. دقت داشته باشید این تنظیم از طریق منوی تنظیمات سریع در نوشته قابل تغییر است.</div>
                    </div>
                    <div class="fields">
                        <label class="title" for="wooregprice_prefix">متن پیشوند قیمت :</label>
                        <input type="text" id="wooregprice_prefix" name="wooregprice_prefix" value="<?= (isset($settings['wooregprice_prefix'])?$settings['wooregprice_prefix']:'') ?>" placeholder="قیمت: ">
                        <div class="des">
                            متنی که قرار است درست قبل از قیمت درج شود را در این قسمت وارد کنید. مثال: "قیمت: "
                        </div>

                    </div>
                    <div class="fields">
                        <label class="title" for="woosaleprice">ارسال قیمت فروش ویژه همیشه روشن باشد :</label>
                        <div class="checkbox">
                            <input type="checkbox" value="1"  id="woosaleprice"
                                   name="woosaleprice" <?php echo $settings['woosaleprice'] == '1' ? "checked" : ""; ?>
                                   onclick="validate()">
                            <label for="woosaleprice"></label>
                        </div>
                        <div class="des">اگر نمی خواهید قیمت حراج محصولتان در کانال ارسال شود این گزینه را غیرفعال کنید. دقت داشته باشید این تنظیم از طریق منوی تنظیمات سریع در نوشته قابل تغییر است.</div>
                    </div>
                    <div class="fields">
                        <label class="title" for="woosaleprice_prefix">متن پیشوند فروش ویژه :</label>
                        <input type="text" id="woosaleprice_prefix" name="woosaleprice_prefix" value="<?= (isset($settings['woosaleprice_prefix'])?$settings['woosaleprice_prefix']:'') ?>" placeholder="قیمت ویژه: ">
                        <div class="des">
                            متنی که قرار است درست قبل از قیمت فروش ویژه درج شود را در این قسمت وارد کنید. مثال: "قیمت فروش ویژه: "
                        </div>

                    </div>
                    <div class="fields">
                        <label class="title" for="woostockstatus">ارسال وضعیت موجودی محصول همیشه روشن باشد :</label>
                        <div class="checkbox">
                            <input type="checkbox" value="1"  id="woostockstatus"
                                   name="woostockstatus" <?php echo $settings['woostockstatus'] == '1' ? "checked" : ""; ?>
                                   onclick="validate()">
                            <label for="woostockstatus"></label>
                        </div>
                        <div class="des">اگر نمی خواهید وضعیت موجود یا ناموجود بودن محصولتان در کانال ارسال شود این گزینه را غیرفعال کنید. دقت داشته باشید این تنظیم از طریق منوی تنظیمات سریع در نوشته قابل تغییر است.</div>
                    </div>
                    <div class="fields">
                        <label class="title" for="woostockstatus_prefix">متن پیشوند وضعیت موجودی :</label>
                        <input type="text" id="woostockstatus_prefix" name="woostockstatus_prefix" value="<?= (isset($settings['woostockstatus_prefix'])?$settings['woostockstatus_prefix']:'') ?>" placeholder="وضعیت موجودی: ">
                        <div class="des">
                            متنی که قرار است درست قبل از وضعیت موجودی درج شود را در این قسمت وارد کنید. مثال: "وضعیت موجودی: "
                        </div>

                    </div>
                    <div class="fields">
                        <label class="title" for="wooproductbtn">دکمه شیشه ای لینک شده به صفحه محصول همیشه ارسال شود :</label>
                        <div class="checkbox">
                            <input type="checkbox" value="1"  id="wooproductbtn"
                                   name="wooproductbtn" <?php echo $settings['wooproductbtn'] == '1' ? "checked" : ""; ?>
                                   onclick="validate()">
                            <label for="wooproductbtn"></label>
                        </div>
                        <div class="des">اگر نمی خواهید یک دکمه شیشه ای لینک شده به صفحه محصولتان در کانال ارسال شود این گزینه را غیرفعال کنید. دقت داشته باشید این تنظیم از طریق منوی تنظیمات سریع در نوشته قابل تغییر است.</div>
                    </div>
                    <div class="fields">
                        <label class="title" for="wooproductbtntext">متن دکمه لینک به محصول :</label>
                        <input type="text" id="wooproductbtntext" name="wooproductbtntext" value="<?= $settings['wooproductbtntext'] ?>" placeholder="خرید">
                        <div class="des">
                            دکمه شیشه ای لینک شده به محصول چه عنوانی داشته باشد؟ آن را در فیلد بالا وارد نمایید.
                        </div>

                    </div>

                    <div class="fields">
                        <label class="title" for="woopostanchor">متن لینک به محصول :</label>
                        <input type="text" id="woopostanchor" name="woopostanchor" value="<?= $settings['woopostanchor'] ?>" placeholder="کسب اطلاعات بیشتر">
                        <div class="des">
                            اگر توضیحات محصولتان بلند باشد و یا به هر دلیلی بخواهید کاربر را برای خواندن ادامه توضیحات به وب سایت تان بفرستید، یک لینک در انتهای نوشته تان درج میگردد. متن آن لینک را می توانید از این مکان تنظیم نمایید. مثلا : "کسب اطلاعات بیشتر درباره این محصول"
                        </div>

                    </div>

                    <div class="fields">
                        <label class="title" for="woocurrency">واحد قیمت :</label>
                        <input type="text" id="woocurrency" name="woocurrency" value="<?= $settings['woocurrency'] ?>" placeholder="تومان">
                        <div class="des">
قیمت محصولات(پسوند قیمت ها) ارسالی به کانال تان با چه ارزی محاسبه می شوند؟ مثلا: تومان                        </div>

                    </div>



                </div>
            </div>
            <div class="tabs1 " id="edd" style="<?=($active_tab!='edd'?'display:none':'') ?>">
                <div class="content">
                    <div class="fields">
                        <label class="title" for="eddpricesend">ارسال قیمت محصول همیشه روشن باشد :</label>
                        <div class="checkbox">
                            <input type="checkbox" value="1"  id="eddpricesend"
                                   name="eddpricesend" <?php echo $settings['eddpricesend'] == '1' ? "checked" : ""; ?>
                                   onclick="validate()">
                            <label for="eddpricesend"></label>
                        </div>
                        <div class="des">اگر نمی خواهید قیمت محصول دانلود دیجیتال تان در کانال ارسال شود این گزینه را غیرفعال کنید. دقت داشته باشید این تنظیم از طریق منوی تنظیمات سریع در نوشته قابل تغییر است.</div>
                    </div>
                    <div class="fields">
                        <label class="title" for="eddproductbtn">دکمه شیشه ای لینک شده به صفحه محصول همیشه ارسال شود :</label>
                        <div class="checkbox">
                            <input type="checkbox" value="1"  id="eddproductbtn"
                                   name="eddproductbtn" <?php echo $settings['eddproductbtn'] == '1' ? "checked" : ""; ?>
                                   onclick="validate()">
                            <label for="eddproductbtn"></label>
                        </div>
                        <div class="des">اگر نمی خواهید یک دکمه شیشه ای لینک شده به صفحه محصولتان در کانال ارسال شود این گزینه را غیرفعال کنید. دقت داشته باشید این تنظیم از طریق منوی تنظیمات سریع در نوشته قابل تغییر است.</div>
                    </div>
                    <div class="fields">
                        <label class="title" for="eddproductbtntext">متن دکمه لینک به محصول :</label>
                        <input type="text" id="eddproductbtntext" name="eddproductbtntext" value="<?= $settings['eddproductbtntext'] ?>" placeholder="خرید">
                        <div class="des">
                            دکمه شیشه ای لینک شده به محصول چه عنوانی داشته باشد؟ آن را در فیلد بالا وارد نمایید.
                        </div>

                    </div>

                    <div class="fields">
                        <label class="title" for="eddpostanchor">متن لینک به محصول :</label>
                        <input type="text" id="eddpostanchor" name="eddpostanchor" value="<?= $settings['eddpostanchor'] ?>" placeholder="کسب اطلاعات بیشتر">
                        <div class="des">
                            اگر توضیحات محصولتان بلند باشد و یا به هر دلیلی بخواهید کاربر را برای خواندن ادامه توضیحات به وب سایت تان بفرستید، یک لینک در انتهای نوشته تان درج میگردد. متن آن لینک را می توانید از این مکان تنظیم نمایید. مثلا : "کسب اطلاعات بیشتر درباره این محصول"
                        </div>

                    </div>

                    <div class="fields">
                        <label class="title" for="eddcurrency">واحد قیمت :</label>
                        <input type="text" id="eddcurrency" name="eddcurrency" value="<?= $settings['eddcurrency'] ?>" placeholder="تومان">
                        <div class="des">
                            قیمت محصولات ارسالی به کانال تان با چه ارزی محاسبه می شوند؟ مثلا: تومان                        </div>

                    </div>
                </div>
            </div>
            <div class="tabs1 " id="channel_widget" style="<?=($active_tab!='channel_widget'?'display:none':'') ?>">
                <div class="content">
                    <h3 class="ehead">ویجت و شرتکد نمایش پست تلگرام</h3>

                    <div class="etext">

                        <div class="etext">ویجت و شرت کد کانال خودکار به شما این امکان را می دهد تا به راحتی هرچه تمام تر، پست تلگرام تان را با همان شکل و شمایل(نام و تصویر کانال+لینک و تعداد بازدید ها. در صفحه سایت تان به نمایش بگذارید. کافیست به یکی از شیوه های زیر از آن استفاده نمایید.</div>
                        <div class="etext"><b>ویجت کانال خودکار</b></div>
                        <div class="etext">با مراجعه به منوی ابزارک ها(زیرمنوی نمایش)، قادر خواهید بود تا ویجت "پیش نمایش پست کانال" را جهت درج در محل های گوناگون موردنظرتان بیابید. این ویجت قادر است تا هم پست مربوط به صفحه ای که کاربر باز می کند را نشان دهد و هم پست دلخواه شما را</div><hr />
                        <div class="etext"><b>شرت کد</b></div>
                        <div class="etext">با استفاده از شرت کد [eastweb_channel_post] قادر خواهید بود تا پیش نمایش پست فعلی، یا پست دلخواه را در هرجای متنی نوشته اید مشاهده کنید.</div>
                        <div class="etext"><b>مثال:</b> [eastweb_channel_post] پست فعلی را(در صورت منتشر شدن در تلگرام) به نمایش می گذارد</div>
                        <div class="etext"><b>مثال2:</b> <span style="direction: ltr !important;display: inline-block;">[eastweb_channel_post]link of post[/eastweb_channel_post]</span> به شما این امکان را می دهد تا پیش نمایش پست دلخواه تان را ببینید.</div>

                        <div class="etext">در صورتی که قصد دارید درون کدهای قالب از این شرت کد استفاده کنید حتما با استفاده از کد زیر این کار را انجام دهید.</div>
                        <div class="etext" dir="ltr" style="direction:ltr !important">
                            &lt;?php echo do_shortcode('[eastweb_channel_post]'); ?&gt;
                        </div>


                    </div>

                </div>
            </div>
            <div class="tabs1 " id="contactbtn" style="<?=($active_tab!='contactbtn'?'display:none':'') ?>">
                <div class="content" id="">
                    <div class="fields">
                        <label class="title" for="contactbtn_active">دکمه شناور فعال باشد :</label>
                        <div class="checkbox">
                            <input type="checkbox" value="1"  id="contactbtn_active"
                                   name="contactbtn_active" <?php echo $settings['contactbtn_active'] == '1' ? "checked" : ""; ?>
                                   onclick="validate()">
                            <label for="contactbtn_active"></label>
                        </div>
                        <div class="des">در صورتی که می خواهید دکمه شناور را غیرفعال کنید تا در وب سایت شما به نمایش درنیاید، این گزینه را در وضعیت غیرفعال قرار دهید.</div>
                    </div>
                    <div class="fields">
                        <label class="title" for="contactbtn_hideinmobile">مخفی شدن در صفحه نمایش کوچک(موبایل) :</label>
                        <div class="checkbox">
                            <input type="checkbox" value="1"  id="contactbtn_hideinmobile"
                                   name="contactbtn_hideinmobile" <?php echo $settings['contactbtn_hideinmobile'] == '1' ? "checked" : ""; ?>
                                   onclick="validate()">
                            <label for="contactbtn_hideinmobile"></label>
                        </div>
                        <div class="des">در صورتی که می خواهید دکمه شناور را در صفحه نمایش هایی که کوچک هستند(مانند موبایل ها) غیرفعال کنید تا در وب سایت شما به نمایش درنیاید، این گزینه را در وضعیت فعال قرار دهید.</div>
                    </div>
                    <div class="fields">
                        <label class="title" for="contactbtn_position">محل قرارگیری :</label>
                        <select name="contactbtn_position" class="postform">
                            <option value="downright" <?=($settings['contactbtn_position']=='downright'?'selected':'') ?>>پایین-راست</option>
                            <option value="downleft" <?=($settings['contactbtn_position']=='downleft'?'selected':'') ?>>پایین-چپ</option>
                        </select>
                        <div class="des">
محل قرارگیری دکمه ی تماس را در صفحه مشخص کنید.
                        </div>

                    </div>
                    <div class="fields">
                        <label class="title" for="contactbtn_maincolor">رنگ دکمه شناور :</label>
                        <input type="text" dir="ltr"  id="contactbtn_maincolor" name="contactbtn_maincolor" value="<?= $settings['contactbtn_maincolor'] ?>" placeholder="#db4437" dir="ltr">
                        <div class="des">
رنگ دکمه شناور را وارد کنید(مثال: <span style="direction: ltr;display: inline-block">#db4437</span> )                        </div>

                    </div>
                    <div class="fields">
                        <label class="title" for="contactbtn_subcolor">رنگ سایر دکمه ها :</label>
                        <input type="text" dir="ltr" id="contactbtn_subcolor" name="contactbtn_subcolor" value="<?= $settings['contactbtn_subcolor'] ?>" placeholder="#00aeef" dir="ltr">
                        <div class="des">
                            رنگ سایر دکمه ها را وارد کنید(مثال: <span style="direction: ltr;display: inline-block">#00aeef</span> )                        </div>

                    </div>
                    <div id="contactbtn_area">

                        <?php
                        $items_flag=false;
                        $channels=array();
                        $counter=0;
                        if(isset($settings['contactbtn_channel'])) {
                            if(is_array($settings['contactbtn_channel']))
                            {
                                if (@count($settings['contactbtn_channel']))
                                    foreach ($settings['contactbtn_channel'] as $channel):

                                        $items_flag = true;
                                        ?>
                                        <div class="fields">
                                            <button class="close-field-btn btn">&times;</button>
                                            <br>
                                            <div class="dual-col">
                                                <label>دکمه کانال: </label>
                                                <input type="text" dir="ltr" name="contactbtn[channel][]" value="<?= $channel; ?>"
                                                       placeholder="لینک کانال تان را وارد کنید">
                                                <br />
                                                <div class="des">
                                                    لینک کانال تان را وارد کنید. مثال: https://t.me/eastweb
                                                </div>
                                            </div>
                                            <div class="dual-col">
                                                <label>توضیح بالنی: </label>
                                                <input type="text" dir="ltr" name="contactbtn[channeltooltip][]" value="<?= (isset($settings['contactbtn_channel_tooltip'][$counter++])?$settings['contactbtn_channel_tooltip'][$counter-1]:'') ?>"
                                                       placeholder="توضیح یک یا دو کلمه ای، جهت راهنمایی کاربر">
                                                <br />
                                                <div class="des">
                                                    توضیح یک یا دو کلمه ای، جهت راهنمایی کاربر. مثال: کانال شرق وب
                                                </div>
                                            </div>

                                        </div>

                                    <?php

                                    endforeach;
                            }


                        }
                        $counter=0;
                        if(isset($settings['contactbtn_group'])) {
                            if(is_array($settings['contactbtn_group']))
                            {
                                if (@count($settings['contactbtn_group']))
                                    foreach ($settings['contactbtn_group'] as $group):

                                        $items_flag = true;
                                        ?>
                                        <div class="fields">
                                            <button class="close-field-btn btn">&times;</button>
                                            <br>
                                            <div class="dual-col">
                                                <label>دکمه گروه: </label>
                                                <input type="text"  dir="ltr" name="contactbtn[group][]" value="<?=$group ?>" placeholder="لینک دعوتت گروه تان را وارد کنید">
                                                <br />
                                                <div class="des">
                                                    لینک دعوت گروه تان را وارد کنید تا کاربران پس از کلیک بر روی آن به گروه شما بیایند.                                       </div>
                                            </div>
                                            <div class="dual-col">
                                                <label>توضیح بالنی: </label>
                                                <input type="text" dir="ltr" name="contactbtn[grouptooltip][]" value="<?= (isset($settings['contactbtn_group_tooltip'][$counter++])?$settings['contactbtn_group_tooltip'][$counter-1]:'') ?>"
                                                       placeholder="توضیح یک یا دو کلمه ای، جهت راهنمایی کاربر">
                                                <br />
                                                <div class="des">
                                                    توضیح یک یا دو کلمه ای، جهت راهنمایی کاربر. مثال: گروه شرق وب
                                                </div>
                                            </div>

                                        </div>

                                    <?php

                                    endforeach;
                            }


                        }
                        $counter=0;
                        if(isset($settings['contactbtn_bot'])) {
                            if(is_array($settings['contactbtn_bot'])){
                                if (@count($settings['contactbtn_bot']))
                                    foreach ($settings['contactbtn_bot'] as $bot):

                                        $items_flag = true;
                                        ?>
                                        <div class="fields">
                                            <button class="close-field-btn btn">&times;</button>
                                            <br>
                                            <div class="dual-col">
                                                <label>دکمه ربات: </label>
                                                <input type="text"  dir="ltr" name="contactbtn[bot][]" value="<?=$bot?>" placeholder="لینک ربات تان را وارد کنید">
                                                <br />
                                                <div class="des">
                                                    لینک ربات تلرگامی تان را وارد کنید.مثال: https://t.me/eastwebot
                                                </div>
                                            </div>
                                            <div class="dual-col">
                                                <label>توضیح بالنی: </label>
                                                <input type="text" dir="ltr" name="contactbtn[bottooltip][]" value="<?= (isset($settings['contactbtn_bot_tooltip'][$counter++])?$settings['contactbtn_bot_tooltip'][$counter-1]:'') ?>"
                                                       placeholder="توضیح یک یا دو کلمه ای، جهت راهنمایی کاربر">
                                                <br />
                                                <div class="des">
                                                    توضیح یک یا دو کلمه ای، جهت راهنمایی کاربر. مثال: ربات شرق وب
                                                </div>
                                            </div>

                                        </div>

                                    <?php

                                    endforeach;
                            }


                        }
                        $counter=0;
                        if(isset($settings['contactbtn_user'])) {
                            if(is_array($settings['contactbtn_user']))
                            {
                                if (@count($settings['contactbtn_user']))
                                    foreach ($settings['contactbtn_user'] as $user):

                                        $items_flag = true;
                                        ?>
                                        <div class="fields">
                                            <button class="close-field-btn btn">&times;</button>
                                            <br>
                                            <div class="dual-col">
                                                <label>دکمه تماس با پشتیبانی(کاربر): </label>
                                                <input type="text"  dir="ltr" name="contactbtn[user][]" value="<?=$user; ?>" placeholder="لینک حساب تان را وارد کنید">
                                                <br />
                                                <div class="des">
                                                    لینک تلگرام تان را وارد کنید.مثال: https://t.me/ew_ir
                                                </div>
                                            </div>
                                            <div class="dual-col">
                                                <label>توضیح بالنی: </label>
                                                <input type="text" dir="ltr" name="contactbtn[usertooltip][]" value="<?= (isset($settings['contactbtn_user_tooltip'][$counter++])?$settings['contactbtn_user_tooltip'][$counter-1]:'') ?>"
                                                       placeholder="توضیح یک یا دو کلمه ای، جهت راهنمایی کاربر">
                                                <br />
                                                <div class="des">
                                                    توضیح یک یا دو کلمه ای، جهت راهنمایی کاربر. مثال: پشتیبانی شرق وب
                                                </div>
                                            </div>

                                        </div>

                                    <?php

                                    endforeach;
                            }


                        }
                        ?>

                    </div>

<br />
                    <div class="add-channel-btn-container" style="text-align:center;">
                        <label class="title" for="contactbtn_add">نوع دکمه :</label>
                        <select id="contactbtn_add" name="contactbtn_add" class="postform" style="float:none;">
                            <option value="channel" >دکمه کانال</option>
                            <option value="group" >دکمه گروه</option>
                            <option value="bot" >دکمه ربات</option>
                            <option value="user" >دکمه کاربر</option>
                        </select>
                        <button class="btn" id="add-contact_btn"><i class="fa fa-plus"></i> افزودن دکمه تماس</button>
                    </div>
                    <script type="text/javascript">
                        jQuery(document).ready(function($) {
                            $( "body" ).delegate( "#add-contact_btn", "click", function(event) {
                                event.preventDefault();
                                var type = $("#contactbtn_add option:selected").val();
                                if(type=='channel')
                                    $('#contactbtn_area').append('<div class="fields"> <button class="close-field-btn btn">&times;</button> <br><div class="dual-col"> <label>دکمه کانال: </label> <input type="text" dir="ltr" name="contactbtn[channel][]" value="" placeholder="لینک کانال تان را وارد کنید"> <br /> <div class="des"> لینک کانال تان را وارد کنید. مثال: https://t.me/eastweb</div> </div> <div class="dual-col"> <label>توضیح بالنی: </label> <input type="text" dir="ltr" name="contactbtn[channeltooltip][]" value=""placeholder="توضیح یک یا دو کلمه ای، جهت راهنمایی کاربر"> <br /> <div class="des"> توضیح یک یا دو کلمه ای، جهت راهنمایی کاربر. مثال: کانال شرق وب </div> </div></div>');
                                else if(type=='group')
                                $('#contactbtn_area').append('<div class="fields"> <button class="close-field-btn btn">&times;</button> <br> <div class="dual-col"> <label>دکمه گروه: </label> <input type="text"  dir="ltr" name="contactbtn[group][]" value="" placeholder="لینک دعوتت گروه تان را وارد کنید"> <br /> <div class="des"> لینک دعوت گروه تان را وارد کنید تا کاربران پس از کلیک بر روی آن به گروه شما بیایند.                                      </div> </div> <div class="dual-col"> <label>توضیح بالنی: </label> <input type="text" dir="ltr" name="contactbtn[grouptooltip][]" value="" placeholder="توضیح یک یا دو کلمه ای، جهت راهنمایی کاربر"> <br /> <div class="des"> توضیح یک یا دو کلمه ای، جهت راهنمایی کاربر. مثال: گروه شرق وب </div> </div> </div>');
                                else if(type=='bot')
                                $('#contactbtn_area').append('<div class="fields"> <button class="close-field-btn btn">&times;</button> <br> <div class="dual-col"> <label>دکمه ربات: </label> <input type="text"  dir="ltr" name="contactbtn[bot][]" value="" placeholder="لینک ربات تان را وارد کنید"> <br /> <div class="des"> لینک ربات تلرگامی تان را وارد کنید.مثال: https://t.me/eastwebot</div> </div> <div class="dual-col"> <label>توضیح بالنی: </label> <input type="text" dir="ltr" name="contactbtn[bottooltip][]" value="" placeholder="توضیح یک یا دو کلمه ای، جهت راهنمایی کاربر"> <br /> <div class="des"> توضیح یک یا دو کلمه ای، جهت راهنمایی کاربر. مثال: ربات شرق وب </div> </div> </div>');
                                else if(type=='user')
                                $('#contactbtn_area').append('<div class="fields"> <button class="close-field-btn btn">&times;</button> <br> <div class="dual-col"> <label>دکمه تماس با پشتیبانی(کاربر): </label> <input type="text"  dir="ltr" name="contactbtn[user][]" value="" placeholder="لینک حساب تان را وارد کنید"> <br /> <div class="des"> لینک تلگرام تان را وارد کنید.مثال: https://t.me/ew_ir</div> </div> <div class="dual-col"> <label>توضیح بالنی: </label> <input type="text" dir="ltr" name="contactbtn[usertooltip][]" value="" placeholder="توضیح یک یا دو کلمه ای، جهت راهنمایی کاربر"> <br /> <div class="des"> توضیح یک یا دو کلمه ای، جهت راهنمایی کاربر. مثال: پشتیبانی شرق وب </div> </div> </div>');
                                else alert(type);
                            });
                        });

                    </script>
                </div>
            </div>
            <div class="tabs1 " id="bily" style="<?=($active_tab!='bily'?'display:none':'') ?>">
                <style>
                    .tabs1#bily{
                        height: 520px;
                        background: url('<?=plugin_dir_url( __FILE__ );?>../assets/bily-charts.jpg');
                        background-size: auto auto;
                        background-size: cover;
                        background-repeat:no-repeat;
                        color:black;
                    }
                </style>
                <h3 class="ehead">کوتاه کننده هوشمند Bily.ir</h3>

                <div class="etext">

                    <div class="etext">کوتاه کننده لینک هوشمند bily.ir به شما این امکان را می دهد تا لینک های کوتاه و به خاطر ماندنی با ویژگی های پیشرفته آماری بسازید. سرعت و دقت این سرویس مثال زدنی است و همچنین می توانید نمایش لینک تان را به صورت هوشمند مدیریت کنید و با استفاده از مطالبی که در دنیای وب منتشر می کنید، برای برند خود ارزش آفرینی کنید.</div>

                </div>
                <div class="content">
                    <div class="fields">
                        <label class="title" for="bily_enabled">کوتاه کننده لینک فعال باشد :</label>
                        <div class="checkbox">
                            <input type="checkbox" value="1"  id="bily_enabled"
                                   name="bily_enabled" <?php echo $settings['bily_enabled'] == '1' ? "checked" : ""; ?>
                                   onclick="validate()">
                            <label for="bily_enabled"></label>
                        </div>
                        <div class="des">اگر نمی خواهید لینک های شما به وسیله کوتاه کننده هوشمند bily.ir کوتاه شود این گزینه را غیرفعال کنید.</div>
                    </div>

                    <script type="text/javascript">
                        jQuery(document).ready(function($) {
                            $( "body" ).delegate( "#bily_fast_login_generate", "click", function(event) {
                                event.preventDefault();
                                if($('#token').val()!==''){
                                    //send ajax request to server for check the token
                                    var data = {
                                        'action': 'wpch_settings',
                                        'operation': 'bily_login'
                                    };

                                    // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
                                    $('#bily_fast_login_link').text('در حال ایجاد...')
                                    jQuery.post(ajaxurl, data, function(response) {
                                        var resp=JSON.parse(response);
                                        if(resp){
                                            if(resp.ok)
                                            {
                                                $('#bily_fast_login_link').html(resp.link);
                                                $('#bily_fast_login_link').attr('href',resp.link);
                                                $('#bily_fast_login_generate').css('display','none')

                                            }
                                            else
                                            {
                                                $('#bily_fast_login_link').html(resp.error);
                                            }
                                        }

                                    });

                                }
                                else
                                    $('#bily_fast_login_link').html('لطفا ابتدا یک توکن معتبر وارد کنید!');
                            });

                        });

                    </script>
                    <h3 class="ehead" align="center" style="" ><button id="bily_fast_login_generate" style="color:deepskyblue !important;border:1px solid deepskyblue;border-radius: 5px;padding: 5px;">ایجاد لینک ورود سریع به پنل کوتاه کننده لینک</button></h3>
                    <h3 class="ehead" align="center" style="color:deepskyblue !important;" >
                        <a href="#" id="bily_fast_login_link" target="_blank" style="color:deepskyblue !important;"></a>
                    </h3>
                </div>
            </div>
            <div class="tabs1 " id="advancedsettings" style="<?=($active_tab!='advancedsettings'?'display:none':'') ?>">

                <div class="etext">
                </div>
                <div class="content">
                    <div class="fields">
                        <label class="title" for="uploadfiles">آپلود فایل ها :</label>
                        <div class="checkbox">
                            <input type="checkbox" value="1"  id="uploadfiles"
                                   name="uploadfiles" <?php echo $settings['uploadfiles'] == '1' ? "checked" : ""; ?>
                                   onclick="validate()">
                            <label for="uploadfiles"></label>
                        </div>
                        <div class="des">با روشن بودن این گزینه افزونه از لینک مستقیم به تصویر شاخص و برخی فایل ها جهت آپلود استفاده نمی کند(این گزینه ممکن است توسط پراکسی نادیده گرفته شود).</div>
                    </div>
                    <div class="fields">
                        <label class="title" for="apissl">پروتکل امن ارتباط با سرور مرکزی :</label>
                        <div class="checkbox">
                            <input type="checkbox" value="1"  id="apissl"
                                   name="apissl" <?php echo $settings['apissl'] == '1' ? "checked" : ""; ?>
                                   onclick="validate()">
                            <label for="apissl"></label>
                        </div>
                        <div class="des">با روشن بودن این گزینه از پروتکل HTTPS در ارتباطات بین سروری افزونه استفاده می شود؛ چنانچه این گزینه را خاموش نمایید کلیه ارتباطات بدون SSL انجام خواهند گرفت.</div>
                    </div>
                    <div class="fields">
                        <label class="title" for="automaticupdate">آپدیت خودکار شرق وب :</label>
                        <div class="checkbox">
                            <input type="checkbox" value="1"  id="automaticupdate"
                                   name="automaticupdate" <?php echo $settings['automaticupdate'] == '1' ? "checked" : ""; ?>
                                   onclick="validate()">
                            <label for="automaticupdate"></label>
                        </div>
                        <div class="des">با روشن بودن این گزینه به محض قرار گرفتن آپدیت جدید[نسخه پایدار شده] به صورت اتوماتیک، افزونه شما نیز در اولین تراکنش کارکردی اش، به روزرسانی نیز می گردد.</div>
                    </div>

                </div>
                <div class="content">
                    <script type="text/javascript">
                        jQuery(document).ready(function($) {
                            $( "body" ).delegate( "#use_ewproxy", "change", function(event) {

                                if($(this).prop('checked') === true){
                                    $('#useproxy').prop('checked',false);
                                    $('#use_googleproxy').prop('checked',false);
                                }

                            });
                        });

                    </script>
                    <div class="fields">
                        <label class="title" for="use_ewproxy">استفاده از پراکسی EWPROXY :(توصیه شده برای هاست های داخلی + پشتیبانی از ارسال تصویر شاخص)</label>
                        <div class="checkbox">
                            <input type="checkbox" value="1"  id="use_ewproxy"
                                   name="use_ewproxy" <?php echo $settings['use_ewproxy'] == '1' ? "checked" : ""; ?>
                                   onclick="validate()">
                            <label for="use_ewproxy"></label>
                        </div>
                        <div class="des">
                            با روشن بودن این گزینه کلیه عملیات ارسال، به وسیله یک پراکسی EWPROXY صورت می پذیرد. تکمیل تنظیمات زیرالزامیست.
                            >>><a style="color:blue" href="https://billing.eastweb.ir/cart.php?p=12" target="_blank">خرید یا تمدید پراکسی</a><<<
                        </div>
                    </div>
                    <div class="fields">
                        <label class="title" for="ewproxy">کلید پراکسی EWPROXY :</label>
                        <input type="text" dir="ltr" id="ewproxy" name="ewproxy" value="<?=$settings['ewproxy'];?>" placeholder="کلید پراکسی را وارد کنید." <?=$settings['ewproxy'] ? '':'checked';?>>
                        <div class="des">
                            <i style="color:red">*</i> کلید مخصوص پراکسی ای را که از شرق وب خریداری کرده اید را در این قسمت وارد کنید.
                            >>><a style="color:blue" href="https://billing.eastweb.ir/cart.php?p=12" target="_blank">خرید یا تمدید پراکسی</a><<<
                        </div>

                    </div>

                </div>
                <div class="content">
                    <script type="text/javascript">
                        jQuery(document).ready(function($) {
                            $( "body" ).delegate( "#use_googleproxy", "change", function(event) {

                                if($(this).prop('checked') === true){
                                    $('#useproxy').prop('checked',false);
                                    $('#use_ewproxy').prop('checked',false);
                                }

                            });
                        });

                    </script>
                    <div class="fields">
                        <label class="title" for="use_googleproxy">استفاده از پراکسی گوگل(<a href="https://eastweb.ir/?p=3071" target="_blank">راهنمای ایجاد پراکسی</a>) :</label>
                        <div class="checkbox">
                            <input type="checkbox" value="1"  id="use_googleproxy"
                                   name="use_googleproxy" <?=(isset($settings['use_googleproxy'])?($settings['use_googleproxy'] == '1' ? "checked" : ""):'') ?>
                                   onclick="validate()">
                            <label for="use_googleproxy"></label>
                        </div>
                        <div class="des">
                            با روشن بودن این گزینه کلیه عملیات ارسال، به وسیله یک پراکسی که روی گوگل بارگزاری شده صورت می پذیرد. این نوع پراکسی از لینک مستقیم جهت ارائه فایل به تلگرام استفاده می کند و ممکن است تصویر شاخص ارسال نشود.
                            >>><a style="color:blue" href="https://eastweb.ir/?p=3071" target="_blank">راهنمای ایجاد پراکسی</a><<<
                        </div>
                    </div>
                    <div class="fields">
                        <label class="title" for="googleproxy">لینک پراکسی گوگل :</label>
                        <input type="text" dir="ltr" id="googleproxy" name="googleproxy" value="<?=(isset($settings['googleproxy'])?$settings['googleproxy']:'') ?>" placeholder="کلید پراکسی را وارد کنید." >
                        <div class="des">
                            <i style="color:red">*</i> لینک پراکسی ایجاد شده طبق راهنما را در این قسمت وارد کنید.
                            >>><a style="color:blue" href="https://eastweb.ir/?p=3071" target="_blank">راهنمای ایجاد پراکسی</a><<<
                        </div>

                    </div>

                </div>
                <div class="etext">
                    دقت داشته باشید که استفاده از پراکسی های SOCKS5 در برخی از هاست های داخل کشور محدود شده است و عملیات احرازهویت و دست تکانی در پراکسی استاندارد PHP شکسته می شود.
                </div>
                <div class="content">
                    <script type="text/javascript">
                        jQuery(document).ready(function($) {
                            $( "body" ).delegate( "#useproxy", "change", function(event) {

                                if($(this).prop('checked') === true){
                                    $('#use_ewproxy').prop('checked',false);
                                    $('#use_googleproxy').prop('checked',false);
                                }

                            });
                        });

                    </script>
                    <div class="fields">
                        <label class="title" for="useproxy">استفاده از پراکسی SOCKS5(پردازش محلی) :</label>
                        <div class="checkbox">
                            <input type="checkbox" value="1"  id="useproxy"
                                   name="useproxy" <?php echo $settings['useproxy'] == '1' ? "checked" : ""; ?>
                                   onclick="validate()">
                            <label for="useproxy"></label>
                        </div>
                        <div class="des">
                            با روشن بودن این گزینه کلیه عملیات ارسال، به وسیله یک پراکسی SOCKS5 صورت می پذیرد. تکمیل تنظیمات زیرالزامیست.
                        </div>
                    </div>
                    <div class="fields">
                        <label class="title" for="proxyaddress">آدرس پراکسی :</label>
                        <input type="text" dir="ltr" id="proxyaddress" name="proxyaddress" value="<?=$settings['proxyaddress'];?>" placeholder="آدرس یا IP مرتبط با پراکسی را وارد کنید" <?=$settings['useproxy'] ? '':'checked';?>>
                        <div class="des">
                            <i style="color:red">*</i> آدرس یا IP مرتبط با پراکسی را وارد کنید.مثال: http://proxy.com یا 127.0.0.1
                        </div>

                    </div>
                    <div class="fields">
                        <label class="title" for="proxyport">پورت :</label>
                        <input type="text" dir="ltr" id="proxyport" name="proxyport" value="<?=$settings['proxyport'];?>" placeholder="پورت مرتبط با پراکسی را وارد کنید. مثلا: 8080" <?=$settings['useproxy'] ? '':'checked';?>>
                        <div class="des">
                            <i style="color:red">*</i> پورت مورد استفاده در پراکسی را وارد نمایید. به عنوان مثال: 8080
                        </div>

                    </div>
                    <div class="fields">
                        <label class="title" for="proxyusername">نام کاربری پراکسی :</label>
                        <input type="text" dir="ltr" id="proxyusername" name="proxyusername" value="<?=$settings['proxyusername'];?>" placeholder="نام کاربری مرتبط با پراکسی را وارد نمایید" <?=$settings['useproxy'] ? '':'checked';?>>
                        <div class="des">
                            نام کاربری مرتبط با پراکسی را وارد نمایید. در صورتی که نام کاربری و رمز عبور وارد نشود، احراز هویت پراکسی Anonymous خواهد بود.
                        </div>

                    </div>
                    <div class="fields">
                        <label class="title" for="proxypassword">گذرواژه پراکسی :</label>
                        <input type="text" dir="ltr" id="proxypassword" name="proxypassword" value="<?=$settings['proxypassword'];?>" placeholder="گذرواژه مرتبط با پراکسی را وارد نمایید" <?=$settings['useproxy'] ? '':'checked';?>>
                        <div class="des">
                            گذرواژه مرتبط با پراکسی را وارد نمایید. در صورتی که نام کاربری و رمز عبور وارد نشود، احراز هویت پراکسی Anonymous خواهد بود.
                        </div>

                    </div>

                </div>
            </div>
            <div class="tabs1 " id="about" style="<?=($active_tab!='about'?'display:none':'') ?>">
                <div class="content">

                    <h3 class="ehead">درباره افزونه کانال خودکار <span class="ehead">نسخه 5.2.1</span></h3>

                    <div class="etext">
                        افزونه کانال خودکار به عنوان اولین افزونه ارسال نوشته های وردپرس به کانال تلگرام توسط شرق وب طراحی گردیده و به فروش می رسد. هر گونه کپی برداری و یا فروش این افزونه بدون کسب مجوز از سوی شرق وب خلاف قوانین و اخلاق حرفه ای می باشد.
                    </div>
                    <div class="etext">
                        اگر افزونه را به صورت رسمی از شرق وب تهیه نموده اید یک کلید فعال سازی در اختیار شما قرار داده شده است که به وسیله آن می توانید افزونه را فعال و رجیستر کنید و همچنین در این صورت می توانید از پشتیبانی آنی و ارسال گزارشات و دریافت پاسخ جهت رفع موارد از سوی شرق وب برخوردار باشید.
                    </div>

                    <div class="etext">
                        <a href="https://eastweb.ir/wp-channel-plugin" target="_blank" style="color:dodgerblue">دیدن خانه ی افزونه</a>
                    </div>
                    <div class="etext">
                        <a href="https://telegram.me/wpchannelplugin" target="_blank" style="color:dodgerblue">اطلاع از به روز رسانی ها و اخبار افزونه</a>
                    </div>
                    <div class="etext">
                        <a href="https://billing.eastweb.ir/" target="_blank" style="color:dodgerblue">پنل کاربری شرق وب</a>
                    </div>
                    <br/>
                        <?php
                        if($settings['license_activation']=='1')
                            echo '<div class="alert" style="margin-bottom: 8px;">افزونه شما با موفقیت فعال شده است.</div>';
                        else
                            echo '<div class="alert-danger" style="margin-bottom: 8px;">افزونه فعال نیست. جهت دریافت کد فعال سازی افزونه به بخش فعال سازی مراجعه کنید. </div>';

                        ?>
                    <br/>
                    <div class="fields">
                        <label class="title" for="channels">ثبت درخواست پشتیبانی :</label>
                        <textarea id="ticket" name="ticket" <?=($settings['license_activation']=='1'?'':'disabled'); ?> placeholder="<?=($settings['license_activation']=='1'?'هرچه می خواهد دل تنگت بگو...':'به دلیل عدم فعال سازی افزونه، نمی توانید تیکت پشتیبانی ثبت کنید'); ?>"></textarea>
                        <div class="des">
                            <?=($settings['license_activation']=='1'?'از این طریق می توانید یک تیکت پشتیبانی جدید باز کنید. تیکت های ایجاد شده در حساب کاربری شرق وب شما قابل دسترسی هستند(خریداران محترمی که از ژاکت خریداری کرده اند، صرفا از طریق ژاکت تیکت درج نمایند). امیدواریم مفید واقع شود.':'به دلیل عدم فعال سازی افزونه، نمی توانید تیکت پشتیبانی ثبت کنید'); ?>
                        </div>

                    </div>
                    <div style="text-align: center">
                    <button class="ticketbutton" type="submit" name="send_ticket" id="send_ticket" style="float: unset;background: #3cc919;" <?=($settings['license_activation']=='1'?'':'disabled'); ?>>ارسال درخواست پشتیبانی</button>
                    </div>
                </div>
            </div>

            <div class="footer">
                <input type="checkbox" name="reset_default" id="reset_default"  hidden>
                <input type="submit" name="reset_default_submit" id="reset_default_submit"  hidden>
                <button type="button" onclick="reset_chbot();">ریست تنظیمات</button>
                <button type="submit" name="submit" id="submit" >ذخیره تنظیمات</button>
            </div>
        </form>
        <script>
            function reset_chbot(event) {
                /*event.preventDefault();*/
                var validation = confirm("تمام تنظیمات شما ریست خواهد شد می خواید ادامه دهید؟");
                if (validation) {

                    $("#reset_default").prop('checked', true);
                    $("#reset_default_submit").click();
                }
                return false;
            }
            jQuery(document).ready(function () {
                $('#tab<?=$active_tab ?>').click()
            });

        </script>
    </div>
    <div style="border-radius:10px;" class="updated">
        دیدن <a href="http://eastweb.ir/wp-channel-plugin" target="_blank">خانه ی افزونه</a>
    </div>
    <div style="border-radius:10px;" class="updated">
        <a href="https://telegram.me/wpchannelplugin" target="_blank">اطلاع از به روز رسانی ها و اخبار افزونه</a>
    </div>
    <script>
        jQuery(document).ready(function ($) {
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
    </script>
<?php } ?>