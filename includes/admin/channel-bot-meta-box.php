    <?php
    {
        ?><div>
                <div>
                    <b>تنظیمات قالب ارسال</b>
                </div>
                <input type="radio" name="chbot_template" value="default" <?php  if($quick_options['template']=='default') echo 'checked';?> >پیشفرض</input><br />
                <input type="radio" name="chbot_template" value="caption" <?php  if($quick_options['template']=='caption') echo 'checked';?>>تصویر+کپشن</input><br />
                <input type="radio" name="chbot_template" value="image_text" <?php  if($quick_options['template']=='image_text') echo 'checked';?>>متن بلند و تصویر</input><br />
                <input type="radio" name="chbot_template" value="text" <?php  if($quick_options['template']=='text') echo 'checked';?>  >فقط متن</input><br />
                <!--<input type="hidden" name="chbot_send_sign"  value="0" />-->
                <input type="checkbox" name="chbot_send_title" id="chbot_send_title" value="<?php  if($quick_options['send_title']=='1') echo '1'; else echo '0';?>" <?php  if($quick_options['send_title']=='1') echo 'checked';?> />ارسال عنوان<br />
                <input type="checkbox" name="chbot_send_sign" id="chbot_send_sign" value="<?php  if($quick_options['send_sign']=='1') echo '1'; else echo '0';?>" <?php  if($quick_options['send_sign']=='1') echo 'checked';?> />ارسال امضاء<br />
                <input type="checkbox" name="chbot_send_continue" id="chbot_send_continue" value="<?php  if($quick_options['send_continue']=='1') echo '1'; else echo '0';?>" <?php  if($quick_options['send_continue']=='1') echo 'checked';?> />درج لینک ادامه<br />
        <input type="checkbox" name="chbot_disable_notif" id="chbot_disable_notif" value="<?php  if($quick_options['notif']=='1') echo '1'; else echo '0';?>" <?php  if($quick_options['notif']==TRUE) echo 'checked';?> />بدون اعلان<br />
                    <!--<input type="hidden" name="chbot_send_continue"  value="0"  />-->
                <hr />
                <div>
                    <b>تنظیمات لینک و استایل</b>
                </div>
                <input type="checkbox" name="chbot_send_links" value="<?php  if($quick_options['send_links']=='1') echo '1'; else echo '0';?>" <?php  if($quick_options['send_links']=='1') echo 'checked';?> /><a href="#">لینک ها</a> را ارسال کن<br />
                    <!--<input type="hidden" name="chbot_send_links" id="chbot_send_links" value="0" />-->
                <input type="checkbox" name="chbot_send_bolds" value="<?php  if($quick_options['send_bolds']=='1') echo '1'; else echo '0';?>" <?php  if($quick_options['send_bolds']=='1') echo 'checked';?> />متن های <b>بولد</b> را حفظ کن<br />
                    <!--<input type="hidden" name="chbot_send_bolds" id="chbot_send_bolds" value="0" />-->
                <input type="checkbox" name="chbot_send_italics" value="<?php  if($quick_options['send_italics']=='1') echo '1'; else echo '0';?>" <?php  if($quick_options['send_italics']=='1') echo 'checked';?> />متن های <i>ایتالیک</i> را حفظ کن<br />
                    <!--<input type="hidden" name="chbot_send_italics" id="chbot_send_italics" value="0" />-->
                <div>
                    <b>نکته:</b>فعلا در کلاینت های تلگرام تنها متن های انگلیسی با استایل بولد و ایتالیک نمایش داده می شوند.
                </div>
                <hr />
                <div>
                    <b>کدام متن ارسال شود؟</b>
                </div>
                <input type="radio" name="chbot_send_text" value="title" <?php  if($quick_options['send_text']=='title') echo 'checked';?> >فقط عنوان</input><br />
                <input type="radio" name="chbot_send_text" value="default" <?php  if($quick_options['send_text']=='default') echo 'checked';?> >چکیده خودکار(در تصویر+کپشن) یا متن برش خورده(متن بلند)</input><br />
                <input type="radio" name="chbot_send_text" value="excerpt_box" <?php  if($quick_options['send_text']=='excerpt_box') echo 'checked';?>>محتوای باکس چکیده</input><br />
                <input type="radio" name="chbot_send_text" value="chbot_box" <?php  if($quick_options['send_text']=='chbot_box') echo 'checked';?>>محتوای باکس افزونه کانال خودکار</input><br />
                    <?php
                    if($post_type=='product'):
                    ?>
                        <input type="radio" name="chbot_send_text" value="chbot_product_short_description" <?php  if($quick_options['send_text']=='chbot_product_short_description') echo 'checked';?>>توضیحات کوتاه محصول</input><br />
                    <?php
                    endif;
                    ?>
        <hr />
                    <div>
                        <b>آپلود فایل</b>
                        <div>
                            پس از ارسال نوشته در کانال تان، می توانید یک فایل نیز بفرستید. کافیست لینک مستقیم آن را در جعبه زیر وارد کنید(حداکثر حجم 50مگابایت)
                        </div>

                    </div>
                    <div id="file-area">
                                <div class="fields" style="border:1px gray dashed;padding:3px;border-radius: 5px">

                                    <div class="dual-col"><input type="text" name="chfiletitle" value="<?=($quick_options['chfile']?$quick_options['chfile']->title:''); ?>"
                                                                 placeholder="کپشن فایل را وارد کنید"></div>
                                    <div class="dual-col"><input type="text" name="chfilelink" value="<?=($quick_options['chfile']?$quick_options['chfile']->link:''); ?>" placeholder="http://...">
                                    </div>
                                </div>

                    </div>
                    <hr />
                    <div>
                        <b>دکمه شیشه ای</b>
                    </div>
                    <div id="btn-area">
                        <?php if($quick_options['chbtns']){
                                    foreach($quick_options['chbtns'] as $chbtn){
                                        if(is_array($chbtn))
                                            $chbtn=(object)$chbtn;

                            ?>
                        <div class="fields" style="border:1px gray dashed;padding:3px;border-radius: 5px">
                            <button class="close-field-btn btn">&times;</button>
                            <br>
                            <div class="dual-col"><input type="text" name="chbtntitle[]" value="<?=$chbtn->title; ?>"
                                                         placeholder="عنوان را وارد کنید"></div>
                            <div class="dual-col"><input type="text" name="chbtnlink[]" value="<?=$chbtn->link; ?>" placeholder="http://...">
                            </div>
                        </div>
                        <?php } } ?>

                    </div>
                    <button id="add-chbtn">افزودن دکمه</button>
                    <script type="text/javascript">
                        jQuery(document).ready(function($) {
                            $( "body" ).delegate( "#add-chbtn", "click", function(event) {
                                event.preventDefault();
                                $('#btn-area').append('<div class="fields" style="border:1px gray dashed;padding:3px;border-radius: 5px"><button class="close-field-btn btn">&times;</button><br><div class="dual-col"><input type="text"  name="chbtntitle[]" value="" placeholder="عنوان را وارد کنید"></div><div class="dual-col"><input type="text"  name="chbtnlink[]" value="" placeholder="http://..."></div></div>');
                            });
                            $( "body" ).delegate( ".close-field-btn", "click", function(event) {
                                event.preventDefault();
                                $(this).closest('.fields').remove();
                            });
                        });

                    </script>
                <hr />

                <?php if($post_type=='product'):  ?>
                    <div>
                        <b>تنظیمات ووکامرس</b>
                    </div>
                    <input type="checkbox" name="chbot_woo_regprice_send" value="<?php  if($quick_options['chbot_woo_regprice_send']=='1') echo '1'; else echo '0';?>" <?php  if($quick_options['chbot_woo_regprice_send']=='1') echo 'checked';?> />ارسال قیمت<br />
                    <input type="checkbox" name="chbot_woo_saleprice_send" value="<?php  if($quick_options['chbot_woo_saleprice_send']=='1') echo '1'; else echo '0';?>" <?php  if($quick_options['chbot_woo_saleprice_send']=='1') echo 'checked';?> />ارسال قیمت حراج(در صورت حراج)<br />
                    <input type="checkbox" name="chbot_woo_instock_send" value="<?php  if($quick_options['chbot_woo_instock_send']=='1') echo '1'; else echo '0';?>" <?php  if($quick_options['chbot_woo_instock_send']=='1') echo 'checked';?> />ارسال وضعیت موجودی<br />
                    <input type="checkbox" name="chbot_woo_buy_send" value="<?php  if($quick_options['chbot_woo_buy_send']=='1') echo '1'; else echo '0';?>" <?php  if($quick_options['chbot_woo_buy_send']=='1') echo 'checked';?> />ارسال دکمه لینک شده به صفحه نوشته با عنوان "خرید"<br />
                    <hr />
                <?php endif; ?>
                <?php if($post_type=='download'): ?>
                    <div>
                        <b>تنظیمات EDD</b>
                    </div>
                    <input type="checkbox" name="chbot_edd_price_send" value="<?php  if($quick_options['chbot_edd_price_send']=='1') echo '1'; else echo '0';?>" <?php  if($quick_options['chbot_edd_price_send']=='1') echo 'checked';?> />ارسال قیمت<br />
                    <input type="checkbox" name="chbot_edd_buy_send" value="<?php  if($quick_options['chbot_edd_buy_send']=='1') echo '1'; else echo '0';?>" <?php  if($quick_options['chbot_edd_buy_send']=='1') echo 'checked';?> />ارسال دکمه لینک شده به صفحه نوشته با عنوان "خرید"<br />
                    <hr />
                <?php endif; ?>
                <div>
                    <b>انتخاب کانال</b>
                </div>
                <select name="chbot_channel"><?php

                    if(trim($chbot_options['channels'])!='')
                    {
                        $chbot_channels=explode(';',$chbot_options['channels']);
                        echo '<option value="auto" '.($quick_options['channel']=='auto'?'selected':'').'>دسته خودکار</option>';
                        echo '<option value="all" '.($quick_options['channel']=='all'?'selected':'').'>همه کانال ها</option>';
                        foreach($chbot_channels as $ch)
                            echo'<option value="'.$ch.'" '.($quick_options['channel']==$ch?'selected':'').'>'.$ch.'</option>';
                    }
                    else echo'<option value="">بدون کانال</option>';
                ?></select>
                <hr />
                <div>
                    <b>وضعیت ارسال</b><br />
                    <?php

                    $chbot_set_meta = get_post_meta($post->ID, '_chbot_status', true);
                    if($status=json_decode($chbot_set_meta,true))
                    {
                        if($status['ok'])
                        {
                            echo '<i class="success alert-success">ارسال شده</i>';
                            if(isset($status['error']) && !empty($status['error']))
                                echo '<br/><i class="danger alert-error">'.$status['error'].'</i>';

                        }
                        else
                            echo '<i class="danger alert-error">'.$status['error'].'</i>';
                    }
                    else
                        echo '<i>ارسال نشده</i>';

                    ?>
                </div>
        <?php
        /*$chbot_meta_check_box_print=false;
        if(isset($wp_version))
            if($wp_version>='5.0.0')
                $chbot_meta_check_box_print=true;
        if($chbot_meta_check_box_print)*/
            chbot_post_submitbox_misc_actions();//wp5
        ?>
            </div><?php
    }
    ?>