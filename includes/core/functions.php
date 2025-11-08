<?php
/**
 * Core Functions for Telegram Channel Bot
 *
 * @package Telegram_Channel_Bot
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}
function eastweb_send_post_request($url, $params)
{
	$post=http_build_query($params);
	$user_agent="EWCH";
	$curl = curl_init($url);
	curl_setopt_array($curl, array(
		CURLOPT_SSL_VERIFYPEER => 0,
		CURLOPT_SSL_VERIFYHOST => 0,
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_POST => 1,
		CURLOPT_POSTFIELDS => $post
	));

	$response = curl_exec($curl);
	curl_close($curl);
	return $response;
}
function eastweb_wpchannel_bily($url,$chbot_options)
{
	$params=array(

        'email'=>$chbot_options['email'],
        'key'=>$chbot_options['key'],
		'url'=>$url,
        'print'=>true
	);
	if($shorten_data=eastweb_send_post_request(get_option('chbot_api_root').'bily/',$params))
		if($json=json_decode($shorten_data,true))
			if($json['ok'])
				return $json['short_link'];
	return $url;
}



$wpch_valid_post_type=array("post","download","page","product","portfolio");
//botscript_chbot_settings();
function chbot_download_url($url,$params=false)
{
	if(!$params)
		array('time'=>time());
	$post=http_build_query($params);
	$user_agent="EWBOTCH";
	$curl = curl_init($url);
	curl_setopt_array($curl, array(
		CURLOPT_SSL_VERIFYPEER => 0,
		CURLOPT_SSL_VERIFYHOST => 0,
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_POST => 1,
		CURLOPT_POSTFIELDS => $post
	));

	$response = curl_exec($curl);
	curl_close($curl);
	return $response;
}
function botscript_chbot_settings($get=true,$new_settings=false){
	global $wpch_valid_post_type;
	$defaults=array(
		'token'=>'',
		'channels'=>'',
		'sign'=>'',
		'linkpreview'=>'0',
		'send_image'=>'',
		'template'=>'[bot_post_title]
[bot_post_body]
[bot_post_shortlink]
[bot_sign]',
		'numchars'=>'3000',
		'caption_numchars'=>'800',
		'thumbnail'=>'1',
		'continue'=>'مشاهده مطلب',
		'numtags'=>'3',
		'tagsend'=>'0',
		'photocap'=>'0',
		'imglink'=>' ',
		'post_active'=>'1',
		'edit_active'=>'0',
		'active'=>'1',
		'version'=>'6.0.0',
		'channel_pair'=>'',
		'default_notif'=>FALSE,
		'default_channel'=>'all',
		'nightmode'=>'1',
		'nightmode_min'=>'8',
		'nightmode_max'=>'23',
		'keyboard'=>'1',
		'keyboard_post_link'=>'1',
		'keyboard_blog_link'=>'1',
		'keyboard_post_link_text'=>'',
		'keyboard_blog_link_text'=>'',
		'keyboard_defaults'=>'',

        'localprocess'=>'1',
        'apissl'=>'1',
        'automaticupdate'=>'1',
        'uploadfiles'=>'0',
        'use_googleproxy'=>'0',
        'googleproxy'=>'',
        'use_ewproxy'=>'0',
        'ewproxy'=>'',
        'useproxy'=>'0',
        'proxyaddress'=>'',
        'proxyport'=>'',
        'proxyusername'=>'',
        'proxypassword'=>'',
		'channel_signs'=>array(),
		'contactbtn_group_tooltip'=>array(),
		'contactbtn_channel_tooltip'=>array(),
		'contactbtn_bot_tooltip'=>array(),
		'contactbtn_user_tooltip'=>array(),
		'v52merged'=>'0',

		'eddcurrency'=>'تومان',
		'eddpostanchor'=>'کسب اطلاعات بیشتر',
		'eddproductbtntext'=>'خرید',
		'eddproductbtn'=>'1',
		'eddpricesend'=>'1',

		'woocurrency'=>'تومان',
		'woopostanchor'=>'کسب اطلاعات بیشتر',
		'wooproductbtntext'=>'خرید',
		'wooproductbtn'=>'1',
		'woopricesend'=>'1',
		'woostockstatus'=>'1',
		'woosaleprice'=>'0',
		'wooregprice'=>'1',
        'woostockstatus_prefix'=>'وضعیت موجودی: ',
		'woosaleprice_prefix'=>'قیمت فروش ویژه: ',
		'wooregprice_prefix'=>'قیمت: ',

		'sendtosuperchannel'=>'1',
		'quick_template'=>'default',
		'quick_text'=>'default',
		'quick_bold'=>'0',
		'quick_italic'=>'0',
		'quick_link'=>'0',
		'quick_send_title'=>'1',

		'contactbtn_active'=>'1',
		'contactbtn_hideinmobile'=>'1',
		'contactbtn_position'=>'downright',
		'contactbtn_maincolor'=>'#db4437',
		'contactbtn_subcolor'=>'#00aeef',
		'contactbtn_channel'=>'',
		'contactbtn_user'=>'',
		'contactbtn_group'=>'',
		'contactbtn_bot'=>'',
		
		
		'send_emptymessages'=>'0',
		'remove_duplicate_new_lines'=>'1',
		'bily_enabled'=>'1',


		'valid_post_types'=>'post,page,product,download,portfolio',
		'new_template'=>'{image_anchor}{title}
{main_category}
{post_type_data}
{body}
{tags}
{link_anchor}
{sign}',
        'woocommerce_template'=>'{regular_price}
{sale_price}
{stock_status}',
        'edd_template'=>'قیمت: {price}',

	);
	if($get)
	{
		$sets=get_option('chbot_settings');
		if(@$settings=json_decode($sets,true))
		{
			$wpch_valid_post_type=explode(',',$settings['valid_post_types']);
			return $settings;
		}

	}
	else{
		if($new_settings)
		{
			$wpch_valid_post_type=explode(',',$new_settings['valid_post_types']);
			$sets=json_encode($new_settings);
			update_option('chbot_settings',$sets);
			return $new_settings;
		}
	}

	$wpch_valid_post_type=explode(',',$defaults['valid_post_types']);
	return $defaults;
}


/**
 * Run when plugin is activated
 * Creates/updates database field with default settings
 */
function botscript_chbot_install() {
	$settings = botscript_chbot_settings();
	
	$new_settings = botscript_chbot_settings(false); // Get new defaults
	$merged_settings = array_merge($new_settings, $settings); // Merge old and new settings
	$merged_settings['version'] = '6.0.0';
	$merged_settings['v52merged'] = 1;
	botscript_chbot_settings(false, $merged_settings); // Save new settings
}

function botscript_chbot_remove() {
/* Deletes the database field */

}

function chbot_quick_settings($post,$posted=true,$post_meta=true,$create_meta=true,$update_meta=true)
{
	$settings=botscript_chbot_settings();
	$post_type=get_post_type();
	$quick_options=array();
	/*defaults*/
	$quick_options['template']=$settings['quick_template'];
	$quick_options['send_title']='1';
	$quick_options['send_sign']='1';
	$quick_options['send_links']=$settings['quick_link'];
	$quick_options['send_bolds']=$settings['quick_bold'];
	$quick_options['send_italics']=$settings['quick_italic'];
	$quick_options['send_text']=$settings['quick_text'];
	$quick_options['send_continue']='1';
	$quick_options['channel']=$settings['default_channel'];
	$quick_options['text']='';
	$quick_options['notif']=$settings['default_notif'];
	$quick_options['chfile']=array();

	$quick_options['chbtns']=array();
	$keyboard_buttons=array();/*do not remove this;used below...*/

	if($post_type=='product')
	{
		@$quick_options['chbot_woo_regprice_send']=$settings['wooregprice'];
		@$quick_options['chbot_woo_saleprice_send']=$settings['woosaleprice'];
		@$quick_options['chbot_woo_instock_send']=$settings['woostockstatus'];
		@$quick_options['chbot_woo_buy_send']=$settings['wooproductbtn'];
	}
	if($post_type=='download')
	{
		@$quick_options['chbot_edd_price_send']=$settings['eddpricesend'];
		@$quick_options['chbot_woo_buy_send']=$settings['eddproductbtn'];
	}


	/*read post meta and parse it if exist*/
	if($post_meta)
	{
		$chbot_quick_meta = get_post_meta($post->ID, '_chbot_quick', true);
		if($chbot_quick_meta)
		{
			if($chbot_quick_meta!='')
			{
				$quick_object=json_decode($chbot_quick_meta);
				if($quick_object)
				{
					@$quick_options['template']=$quick_object->template;
					@$quick_options['send_title']=$quick_object->send_title;
					@$quick_options['send_sign']=$quick_object->send_sign;
					@$quick_options['send_links']=$quick_object->send_links;
					@$quick_options['send_bolds']=$quick_object->send_bolds;
					@$quick_options['send_italics']=$quick_object->send_italics;
					@$quick_options['send_text']=$quick_object->send_text;
					@$quick_options['send_continue']=$quick_object->send_continue;
					@$quick_options['channel']=$quick_object->channel;
					@$quick_options['text']=$quick_object->text;
					@$quick_options['notif']=$quick_object->notif;

					@$quick_options['chbtns']=($quick_object->chbtns?$quick_object->chbtns:array());
					@$quick_options['chfile']=($quick_object->chfile?$quick_object->chfile:array());
					
					if($post_type=='product')
					{
						@$quick_options['chbot_woo_regprice_send']=$quick_object->chbot_woo_regprice_send;
						@$quick_options['chbot_woo_saleprice_send']=$quick_object->chbot_woo_saleprice_send;
						@$quick_options['chbot_woo_instock_send']=$quick_object->chbot_woo_instock_send;
						@$quick_options['chbot_woo_buy_send']=$quick_object->chbot_woo_buy_send;
					}
					if($post_type=='download')
					{
						@$quick_options['chbot_edd_price_send']=$quick_object->chbot_edd_price_send;
						@$quick_options['chbot_edd_buy_send']=$quick_object->chbot_edd_buy_send;
					}
				}
			}
		}
	}
	if($posted)
	{
		if(isset($_POST['chbot_template']))
			$quick_options['template']=$_POST['chbot_template'];
		else
			return $quick_options;

		if(isset($_POST['chbot_send_title']))
			$quick_options['send_title']='1';
		else
			$quick_options['send_title']='0';
		if(isset($_POST['chbot_send_sign']))
			$quick_options['send_sign']='1';
		else
			$quick_options['send_sign']='0';
		if(isset($_POST['chbot_send_links']))
			$quick_options['send_links']='1';
		else
			$quick_options['send_links']='0';
		if(isset($_POST['chbot_send_bolds']))
			$quick_options['send_bolds']='1';
		else
			$quick_options['send_bolds']='0';
		if(isset($_POST['chbot_send_italics']))
			$quick_options['send_italics']='1';
		else
			$quick_options['send_italics']='0';
		if(isset($_POST['chbot_send_text']))
			$quick_options['send_text']=$_POST['chbot_send_text'];	
		if(isset($_POST['chbot_send_continue']))
			$quick_options['send_continue']='1';	
		else
			$quick_options['send_continue']='0';
		if(isset($_POST['chbot_channel']))
			$quick_options['channel']=$_POST['chbot_channel'];	
		if(isset($_POST['chbot_box_text']))
			$quick_options['text']=$_POST['chbot_box_text'];

		if(isset($_POST['chbot_disable_notif']))
			$quick_options['notif']=TRUE;
		else
			$quick_options['notif']=FALSE;

		if($post_type=='product')
		{
			if(isset($_POST['chbot_woo_regprice_send']))
				$quick_options['chbot_woo_regprice_send']='1';
			else
				$quick_options['chbot_woo_regprice_send']='0';

			if(isset($_POST['chbot_woo_saleprice_send']))
				$quick_options['chbot_woo_saleprice_send']='1';
			else
				$quick_options['chbot_woo_saleprice_send']='0';

			if(isset($_POST['chbot_woo_instock_send']))
				$quick_options['chbot_woo_instock_send']='1';
			else
				$quick_options['chbot_woo_instock_send']='0';

			if(isset($_POST['chbot_woo_buy_send']))
				$quick_options['chbot_woo_buy_send']='1';
			else
				$quick_options['chbot_woo_buy_send']='0';
		}
		if($post_type=='download')
		{
			if(isset($_POST['chbot_edd_price_send']))
				$quick_options['chbot_edd_price_send']='1';
			else
				$quick_options['chbot_edd_price_send']='0';

			if(isset($_POST['chbot_edd_buy_send']))
				$quick_options['chbot_edd_buy_send']='1';
			else
				$quick_options['chbot_edd_buy_send']='0';
		}

		/*buttons*/
		if(isset($_POST['chbtntitle']) && isset($_POST['chbtnlink']))
		{
			if($_POST['chbtntitle'] && $_POST['chbtnlink'])
			$i=0;

			foreach($_POST['chbtntitle'] as $title)
			{
				if($title!='' && $_POST['chbtnlink'][$i]!='')
				{

					$keyboard_buttons[]=array('title'=>$title,'link'=>$_POST['chbtnlink'][$i++]);
				}

			}
			//$quick_options['chbtns']=$keyboard_buttons;
		}
		$quick_options['chbtns']=$keyboard_buttons;

		/*file*/
		if(isset($_POST['chfiletitle']) && isset($_POST['chfilelink']))
		{
			$quick_options['chfile']=array('title'=>$_POST['chfiletitle'],'link'=>$_POST['chfilelink']);
		}
		/*meta create and update*/
		$chbot_quick_meta = get_post_meta($post->ID, '_chbot_quick', true);
		if($chbot_quick_meta)
		{
			if($update_meta)
			{
				//update existed meta	
				delete_post_meta($post->ID, '_chbot_quick');
				add_post_meta($post->ID, '_chbot_quick', str_replace('\\','\\\\',json_encode($quick_options)) );
			}
		}
		else if($create_meta)
		{
			//create meta :)
			add_post_meta($post->ID, '_chbot_quick', str_replace('\\','\\\\',json_encode($quick_options)));
		}

	}
	else{
		/*not posted*/
		/*default keyboards*/
		$chbot_quick_meta = get_post_meta($post->ID, '_chbot_quick', true);
		if(!$chbot_quick_meta || $chbot_quick_meta=='')
		{
			if(isset($settings['keyboard_defaults']))
				if(is_array($settings['keyboard_defaults']))
				{
					if(count($settings['keyboard_defaults']))
					{
						foreach ($settings['keyboard_defaults'] as $keyboard)
							$keyboard_buttons[]=array('title'=>$keyboard['title'],'link'=>$keyboard['link']);
						$quick_options['chbtns']=$keyboard_buttons;
					}
				}
		}



	}
	return $quick_options;
}
/************************************/	

function botscript_chbot_menu() {
	$icon_svg='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABEAAAARCAQAAACRZI9xAAABGklEQVQoz3WSsUtCURTGj0FQW+21+y9EySsqdXhhqwSJEbS6NgRBq9HS0BBiaxENRUW/wbAhewm1NERNEoHkkhKChbfl3tdBjLN89/t+XA7nHEFsDTDJJpcElMgTZ9glDohyQBMT1g8nxDTi8aJiV3UyDony3AcwGBrMIcIghX8Ag+GGEWGCzx77nQv2qdlXVthS4RcP7LGKhx92dyxcWVmjwBopkiSYZpuO9StCYOUhU3gssIiPTzn8uSqUrGxRYR2fFElWeAuRQNhRvXxTJEGcXeWdC/O0lfFBmhmqyskJQ5wpo0uRjBrDE2OCEKOuoCavdK3ukHY7WqbRZ7JtNoj8bXqW6x7gkSUi+hiEUbIcccs9d5ySY9wlv/iZl1XoJxpQAAAAAElFTkSuQmCC';
	/*$icon_url= plugin_dir_url( __FILE__ ).'chbot.png';*/
	add_menu_page( 'تنظیمات کانال خودکار تلگرام', 'کانال خودکار تلگرام', 'manage_options', 'chbot-opt-page', 'chbot_options' , $icon_svg );
	
}

/************************************/


function chbot_post_submitbox_misc_actions(){
		global $post,$wpch_valid_post_type;

	$chbot_options=botscript_chbot_settings();
	if($chbot_options['active']=="0")
		return;

	$chbot_set_meta = get_post_meta($post->ID, '_chbot_set', true);
	
	$chbtpm_exist=false;
	if($chbot_set_meta=="1" || $chbot_set_meta=="0")
		$chbtpm_exist=true;
	if(trim($chbot_set_meta)=="")
		$chbot_set_meta="1";
	$post_type=get_post_type();
	if(!in_array($post_type,$wpch_valid_post_type))
		return;
	//$download = edd_price($post->ID);
	//echo edd_format_amount( edd_get_download_price( $post->ID ) );
	/*global $woocommerce;
	$currency = get_woocommerce_currency_symbol();
	$price = get_post_meta( get_the_ID(), '_regular_price', true);
	$sale = get_post_meta( get_the_ID(), '_sale_price', true);
	var_dump($price,$currency,$sale);*/

	//$product=get_product();
	//var_dump($product->currency_symbol);

?><div class="misc-pub-section chbot-options"><?php
	$check_prop="";
	$value_prop=0;
	if($chbtpm_exist)
	{

		//edit post==>meta exists for this post
		if($chbot_options['edit_active']!="1")
			{$check_prop="checked";$value_prop=1;}
		
	}
	else
	{
		//new post;elzaman gheyre faal
		if($chbot_options['post_active']!="0")
			{$check_prop="checked";$value_prop=1;}
	}
	?><input type="hidden" name="chbot_set" value="0" /><input type="checkbox" id="chbot_set" name="chbot_set" value="1"<?php echo $check_prop; ?>/><label for="chbot_set" >ارسال در کانال </label></div><?php



}
function chbot_save_meta_box_data($postid)
{   
	
		global $post,$wpch_valid_post_type;
		@$postid=$post->ID;
		
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return false;
		
    if ( !current_user_can( 'edit_page', $postid ) ) return false;
		
    if(empty($postid) ||  !in_array(get_post_type(),$wpch_valid_post_type) ) return false;
		
	
    if($_POST['action'] == 'editpost'){
        delete_post_meta($postid, '_chbot_set');

    }
	
    add_post_meta($postid, '_chbot_set', (trim($_POST['chbot_set'])!="1"?"0":"1") );


	
	
	
}

function chbot_publish($id,$post=0)
{

	global $wpch_valid_post_type;
	$post_type_values=array();
	$post=get_post($id);
	$post_type=get_post_type();

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return false;
    if ( $post->post_type == 'revision' )
        return false;

    $chbot_options=botscript_chbot_settings();
    if(!isset($chbot_options['v52merged']))
    {
        botscript_chbot_install();
        $chbot_options=botscript_chbot_settings();
    }

    $output=array(
		'{image_anchor}'=>'',
		'{title}'=>'',
		'{post_type_data}'=>'',
		'{body}'=>'',
		'{tags}'=>'',
		'{link_anchor}'=>'',
		'{sign}'=>'',
        '{author}'=>get_the_author_meta( 'display_name', $post->post_author )
);
	$output_woocommerce=array(
		'{regular_price}'=>'',
		'{sale_price}'=>'',
		'{stock_status}'=>''

	);
	$output_edd=array(
		'{price}'=>''
	);
	if($post_type=='product' && function_exists('get_product'))
	{
		if($product=wc_get_product())
		{
			$post_type_values['regular_price']=$product->get_regular_price();
			$post_type_values['sale_price']=$product->get_sale_price();
			$post_type_values['in_stock']=$product->get_stock_status();
			$post_type_values['currency']=get_woocommerce_currency_symbol();
			$post_type_values['on_sale']=$product->is_on_sale();

			if($product->get_type()=='variable') {
				$price_data=$product->get_variation_prices();
				if($price_data) {
					$reg_min = (integer)min($price_data['regular_price']);
					$reg_max = (integer)max($price_data['regular_price']);
					if($reg_max!=$reg_min)
					    $post_type_values['regular_price']=($reg_min || $reg_max?$reg_min.'-'.$reg_max:0);
					else
                        $post_type_values['regular_price']=$reg_min;
				}

				if($post_type_values['on_sale'])
				{
					if($price_data)
					{
						$sale_min=(integer)min($price_data['sale_price']);
						$sale_max=(integer)max($price_data['sale_price']);
						if($sale_max!=$sale_min)
						    $post_type_values['sale_price']=($sale_min || $sale_max?$sale_min.'-'.$sale_max:0);
						else
                            $post_type_values['sale_price']=$sale_min;
					}
				}
			}

		}

	}
	if($post_type=='download' && function_exists('edd_get_download_price'))
	{
		$post_type_values['edd_price']=edd_format_amount( edd_get_download_price( $post->ID ) );
	}

	$quick_settings=chbot_quick_settings($post,$posted=true,$post_meta=true,$create_meta=true,$update_meta=true);
	
	if(isset($_POST['chbot_set']))
	{
		$chbot_set_meta=(trim($_POST['chbot_set'])!="1"?"0":"1");
		
		if($post->post_status!="publish")
			return;
	}
	else
	{
		$chbot_set_meta = get_post_meta($post->ID, '_chbot_set', true);
		if($chbot_set_meta=='')
		{
			
			if($post->post_status=="publish")
			{
				$chbot_set_meta="1";
			}
			elseif($post->post_status=="future")
			{
				$chbot_set_meta="1";
				add_post_meta($post->ID, '_chbot_set', $chbot_set_meta );
				return;
			}
			else{
				return;	
			}
		}
		if(!($post->post_status=="publish" || $post->post_status=="future"))
		{
			return;
		}
		if(!in_array($post->post_type,$wpch_valid_post_type))
			return;
		if ( wp_is_post_autosave( $post->ID ) ) {
			return;
		}
	}

	if(trim($chbot_set_meta)=="1")
	{



		if($chbot_options['nightmode']=='1')
		{
			if(intval(current_time('H'))>=intval($chbot_options['nightmode_max']) || intval(current_time('H'))<intval($chbot_options['nightmode_min'])) {
				$status=array('ok'=>false,'error'=>' عدم ارسال به دلیل فعال بودن حالت شب');
				delete_post_meta($post->ID, '_chbot_status');
				add_post_meta($post->ID, '_chbot_status', str_replace('\\','\\\\',json_encode($status)) );

				return;

			}
		}
		if($chbot_options['active']=="0")
			return;
        $sent_check=get_post_meta($post->ID, '_chbot_date', true);
        $last_channel=get_post_meta($post->ID, '_chbot_last_channel', true);
        if($sent_check!='' && is_numeric($sent_check))
            if((time()-((int)$sent_check))<=60 && $last_channel==$quick_settings['channel'])
                return;
			/*quick settings*/
				if($quick_settings['template']=='caption')
					{$chbot_options['photocap']='1';$chbot_options['thumbnail']='0';}
				elseif($quick_settings['template']=='image_text')
					{$chbot_options['thumbnail']='1';$chbot_options['photocap']='0';}
				elseif($quick_settings['template']=='text')
					{$chbot_options['thumbnail']='0';$chbot_options['photocap']='0';}
			/*quick settings*/
		if($chbot_options['photocap']=="1")
			$chbot_post_photo=get_attached_file( get_post_thumbnail_id($post->ID));
		else
			$chbot_post_photo="";

		/******************Num Chars***************************/
		$chbot_numchars=intval(trim($chbot_options['numchars']));
		if(!is_integer($chbot_numchars))
			$chbot_numchars=3000;
		if($chbot_post_photo!="" || $chbot_post_photo!=false)
			$chbot_numchars=$chbot_options['caption_numchars'];
		/********************SPECIAL CHARS***************************/
		$special_chars=array("&nbsp;","&zwnj;","&#34;","&#33;","&#35;","&#36;","&#37;","&#38;","&amp;","&#39;","&#40;","&#41;","&#42;","&#43;","&#44;","&#45;","&#46;","&#47;","&#64;","&#123;","&#125;","&#124;","&#126;","&#8217;","&#8220;");
		$special_replace=array(" "," ",'\"',"!","#","$","%","&","&","'","(",")","*","+",",","-",".","/","@","{","}","|","~","`","`");
		$special_chars2=array("&#58;","&#59;","&#60;","&lt;","&#61;","&#62;","&gt;","&#63;","&#91;","&#93;","&#8230;","&#95x;");
		$special_replace2=array(":",";","<","<","=",">",">","?","[","]","...","_");
		$tags_to_strip='';
		/*********************Image*********************************/
		$image_flag=false;
		$image_url="";
		if(trim($chbot_options['thumbnail'])=="1" && $chbot_post_photo=="")
		{

			$image_url = trim(wp_get_attachment_url( get_post_thumbnail_id($post->ID) ));
			if($image_url!="")
			{
				$image_flag=true;
			}
		}

		/*****************Excerpt************************/
		$post_E=$post->post_excerpt;
		/****************************/
		if($post_E=="")
		{
			$post_E=apply_filters( 'the_content', $post->post_content );

		}
			$post_E=str_replace("<br></br>","<br></br> \n",$post_E);
			$post_E=str_replace("<br>","<br> \n",$post_E);
			$post_E=str_replace("<br/>","<br/> \n",$post_E);
			$post_E=str_replace("</br>","</br> \n",$post_E);

			$post_E=str_replace("<br />","<br /> \n",$post_E);
			$post_E=str_replace("</p>","</p> \n",$post_E);
			/****************************/

			$post_E=str_replace($special_chars,$special_replace,$post_E);
        if(true)//($chbot_post_photo=="")/*NEW TG PMODE FOR CAPTIONS*/
			{
				$tags_to_strip='';
				if($quick_settings['send_links'])
					$tags_to_strip.='<a>';
				if($quick_settings['send_bolds'])
					$tags_to_strip.='<b><strong><bold>';
				if($quick_settings['send_italics'])
					$tags_to_strip.='<i><em>';
				$post_E=strip_tags($post_E , $tags_to_strip);
			}
			else
				$post_E=strip_tags($post_E , '');

		$post_E=str_replace($special_chars2,$special_replace2,$post_E);
		$post_E = html_entity_decode($post_E, ENT_COMPAT, "UTF-8");

		$post_E_BACK=mb_strimwidth($post_E,0,$chbot_numchars+4,' ...','utf-8');
		$post_E=chbot_fix_string(mb_strimwidth($post_E,0,$chbot_numchars+4,' ...','utf-8'),$tags_to_strip);



		/*****************Full_Content************************/
		$post_C=apply_filters( 'the_content', $post->post_content );
		 $post_C=str_replace("<br></br>","<br></br> \n",$post_C);
		$post_C=str_replace("<br>","<br> \n",$post_C);
		$post_C=str_replace("<br/>","<br/> \n",$post_C);
		$post_C=str_replace("</br>","</br> \n",$post_C);

		$post_C=str_replace("<br />","<br /> \n",$post_C);
		$post_C=str_replace("</p>","</p> \n",$post_C);

		$post_C=str_replace($special_chars,$special_replace,$post_C);
        if(true)//($chbot_post_photo=="")/*NEW TG PMODE FOR CAPTIONS*/
		{
			$tags_to_strip='';
			if($quick_settings['send_links'])
				$tags_to_strip.='<a>';
			if($quick_settings['send_bolds'])
				$tags_to_strip.='<b><strong><bold>';
			if($quick_settings['send_italics'])
				$tags_to_strip.='<i><em>';
			$post_C=strip_tags($post_C , $tags_to_strip);
		}
		else
			$post_C=strip_tags($post_C , '');

		$post_C=str_replace($special_chars2,$special_replace2,$post_C);
		$post_C = html_entity_decode($post_C, ENT_COMPAT, "UTF-8");
		$post_C_BACK=mb_strimwidth($post_C,0,$chbot_numchars+4,' ...','utf-8');
		$post_C=chbot_fix_string(mb_strimwidth($post_C,0,$chbot_numchars+4,' ...','utf-8'),$tags_to_strip);


		/*****************Box_Content************************/
		$post_B="";
		$post_B_BACK="";
		
		if($quick_settings['text']!='' && $quick_settings['send_text']=='chbot_box')
		{
			$post_B=apply_filters( 'the_content', $quick_settings['text'] );
			 $post_B=str_replace("<br></br>","<br></br> \n",$post_B);
			$post_B=str_replace("<br>","<br> \n",$post_B);
			$post_B=str_replace("<br/>","<br/> \n",$post_B);
			$post_B=str_replace("</br>","</br> \n",$post_B);

			$post_B=str_replace("<br />","<br /> \n",$post_B);
			$post_B=str_replace("</p>","</p> \n",$post_B);
		
			$post_B=str_replace($special_chars2,$special_replace2,$post_B);
			if(true)//($chbot_post_photo=="")/*NEW TG PMODE FOR CAPTIONS*/
			{
				$tags_to_strip='';
				if($quick_settings['send_links'])
					$tags_to_strip.='<a>';
				if($quick_settings['send_bolds'])
					$tags_to_strip.='<b><strong><bold>';
				if($quick_settings['send_italics'])
					$tags_to_strip.='<i><em>';
				$post_B=strip_tags($post_B , $tags_to_strip);
			}
			else
				$post_B=strip_tags($post_B , '');

			$post_B=str_replace($special_chars2,$special_replace2,$post_B);
			$post_B = html_entity_decode($post_B, ENT_COMPAT, "UTF-8");
			$chbot_numchars=intval(trim($chbot_options['numchars']));

			$post_B_BACK=mb_strimwidth($post_B,0,$chbot_numchars+4,' ...','utf-8');
			$post_B=chbot_fix_string(mb_strimwidth($post_B,0,$chbot_numchars+4,' ...','utf-8'),$tags_to_strip);

		}
		/*****************Product short description************************/
		$post_PD="";
		if($post_type=='product' && $quick_settings['send_text']=='chbot_product_short_description')
		{
			if($product=wc_get_product())
			{
				$post_PD=apply_filters( 'the_content', $product->short_description );
				 $post_PD=str_replace("<br></br>","<br></br> \n",$post_PD);
				$post_PD=str_replace("<br>","<br> \n",$post_PD);
				$post_PD=str_replace("<br/>","<br/> \n",$post_PD);
				$post_PD=str_replace("</br>","</br> \n",$post_PD);

				$post_PD=str_replace("<br />","<br /> \n",$post_PD);
				$post_PD=str_replace("</p>","</p> \n",$post_PD);

				$post_PD=str_replace($special_chars2,$special_replace2,$post_PD);
                if(true)//($chbot_post_photo=="")/*NEW TG PMODE FOR CAPTIONS*/
				{
					$tags_to_strip='';
					if($quick_settings['send_links'])
						$tags_to_strip.='<a>';
					if($quick_settings['send_bolds'])
						$tags_to_strip.='<b><strong><bold>';
					if($quick_settings['send_italics'])
						$tags_to_strip.='<i><em>';
					$post_PD=strip_tags($post_PD , $tags_to_strip);
				}
				else
					$post_PD=strip_tags($post_PD , '');

				$post_PD=str_replace($special_chars2,$special_replace2,$post_PD);
				$post_PD = html_entity_decode($post_PD, ENT_COMPAT, "UTF-8");
				$chbot_numchars=intval(trim($chbot_options['numchars']));

				$post_PD_BACK=mb_strimwidth($post_PD,0,$chbot_numchars+4,' ...','utf-8');
				$post_PD=chbot_fix_string(mb_strimwidth($post_PD,0,$chbot_numchars+4,' ...','utf-8'),$tags_to_strip);
			}
		}
		
		
		
		/**************************AFTER TEXT PROCESS***************************************/
		if($post_E=="")
			$post_E=$post_E_BACK;
		if($post_C=="")
			$post_C=$post_C_BACK;
		if($post_B=="")
			$post_B=$post_B_BACK;
		if($post_C!="" || $post_E!="" || $post_B!="" || ($post_PD!="" && ($post_type=='product')) || $chbot_options['send_emptymessages'])
		{

			if($chbot_options['remove_duplicate_new_lines'])
			{
				$post_C=preg_replace("/\n+/","\n",$post_C);
				$post_E=preg_replace("/\n+/","\n",$post_E);
				$post_B=preg_replace("/\n+/","\n",$post_B);
				$post_PD=preg_replace("/\n+/","\n",$post_PD);
			}

			$chbot_post_title=trim($post->post_title);
				//$chbot_post_title=$chbot_post_title;

			$chbot_continue_text=trim($chbot_options['continue']);
			$chbot_sendstring='';
			if($quick_settings['send_title'])
				$output['{title}']=$chbot_post_title;
			else
				$chbot_options['new_template']=str_replace(array("{title}\r\n"), '', $chbot_options['new_template']);



			if($post_type=='product')
			{
				$chbot_post_type_appendix=$chbot_options['woocommerce_template'];
				if($quick_settings['chbot_woo_regprice_send'])
					$output_woocommerce['{regular_price}']=($post_type_values['regular_price']?$chbot_options['regprice_prefix'].$post_type_values['regular_price'].$chbot_options['woocurrency']:'رایگان');
				else
					$chbot_post_type_appendix=str_replace(array("{regular_price}\r\n"), '', $chbot_post_type_appendix);
				if($quick_settings['chbot_woo_saleprice_send'] && $post_type_values['on_sale'] /*&& $post_type_values['sale_price']*/)
					$output_woocommerce['{sale_price}']=($post_type_values['sale_price']?$chbot_options['saleprice_prefix'].$post_type_values['sale_price'].$chbot_options['woocurrency']:'رایگان');
				else
					$chbot_post_type_appendix=str_replace(array("{sale_price}\r\n"), '', $chbot_post_type_appendix);
				if($quick_settings['chbot_woo_instock_send'])
					$output_woocommerce['{stock_status}']=$chbot_options['stockstatus_prefix'].($post_type_values['in_stock']=='instock'?'موجود':'ناموجود');
				else
					$chbot_post_type_appendix=str_replace(array("{stock_status}\r\n"), '', $chbot_post_type_appendix);
				$chbot_continue_text=($chbot_options['woopostanchor']?$chbot_options['woopostanchor']:$chbot_continue_text);

				$output['{post_type_data}']=strtr($chbot_post_type_appendix,$output_woocommerce);

			}
			elseif($post_type=='download')
			{
				$chbot_post_type_appendix=$chbot_options['edd_template'];
				if($quick_settings['chbot_edd_price_send'])
					$output_edd['{price}']=($post_type_values['edd_price']?$post_type_values['edd_price'].$chbot_options['eddcurrency']:'رایگان');
				else{
					$chbot_post_type_appendix=str_replace(array("{price}\r\n"), '', $chbot_post_type_appendix);	
					$chbot_post_type_appendix=str_replace(array("{price}"), '', $chbot_post_type_appendix);	
				}
				

				$chbot_continue_text=($chbot_options['eddpostanchor']?$chbot_options['eddpostanchor']:$chbot_continue_text);

				$output['{post_type_data}']=strtr($chbot_post_type_appendix,$output_edd);

			}


			/*quick settings*/
			if($quick_settings['template']!='default')
			{

					if($quick_settings['send_text']=='default')
						$output['{body}']=$post_C;
					elseif($quick_settings['send_text']=='chbot_box')
						$output['{body}']=$post_B;
					elseif($quick_settings['send_text']=='excerpt_box')
						$output['{body}']=$post_E;
					elseif(($quick_settings['send_text']=='chbot_product_short_description') && ($post_type=='product'))
						$output['{body}']=$post_PD;
				
					
			}
			else
			{//normal and default mode

				if($quick_settings['send_text']=='default')
					$output['{body}']=$post_C;
				elseif($quick_settings['send_text']=='chbot_box')
					$output['{body}']=$post_B;
				elseif($quick_settings['send_text']=='excerpt_box')
					$output['{body}']=$post_E;
				elseif(($quick_settings['send_text']=='chbot_product_short_description') && ($post_type=='product'))
					$output['{body}']=$post_PD;
			}

			/*hashtags*/
			if($chbot_options['tagsend']=="1")
			{
				$tag_string="";
				$tag_count=0;
				$total_tag_count=intval(trim($chbot_options['numtags']));
				$tags=false;
				if($post_type=='product')
				{
					$tags = wp_get_post_terms($post->ID, 'product_tag', array("fields" => "all"));
				}
				else{
					$tags = wp_get_post_tags($post->ID);
				}

				if($tags)
				{
					foreach($tags as $tg)
					{
						$tag=$tg->name;
						$tag=str_replace(array(" ","-","_","&nbsp;","&zwnj;"), array("_","_","_","_","_"),$tag);
						$tag_string.="#".$tag." ";

						if($tag_count++>=$total_tag_count-1)
							break;
					}
				}

				if($tag_count>=1)
				{

					if($chbot_options['photocap']!="1")/*needs length calculations*/
						$output['{tags}']=$tag_string;
					else
						$output['{tags}']=$tag_string;
				}

			}
			else
				$chbot_options['new_template']=str_replace(array("{tags}\r\n"), '', $chbot_options['new_template']);

			/*main category*/
            $category=null;
            if($post_type=='product'){
                $category=eastweb_get_wc_primary_cat($post);
            }
            else{
                $perma_cat = get_post_meta($post->ID , '_category_permalink', true);
                if ( $perma_cat != null && is_array($perma_cat) ) {
                    $cat_id = $perma_cat['category'];
                    $category = get_category($cat_id);
                } else {
                    if($categories = get_the_category())
                        if(isset($categories[0]))
                            $category = $categories[0];
                }
            }

            //$category_link = get_category_link($category);
            if(isset($category->name) && !empty($category->name)) {
                $ctag=str_replace(array(" ","-","_","&nbsp;","&zwnj;"), array("_","_","_","_","_"),$category->name);
                $tag_string.="#".$tag." ";
                $output['{main_category}']="#".$ctag." ";
            }
            else
                $chbot_options['new_template']=str_replace(array("{main_category}\r\n","{main_category}"), '', $chbot_options['new_template']);

            /*short link*/
			$short_link=wp_get_shortlink($post->ID);
			if($chbot_options['bily_enabled'])
				if($shortened_link=eastweb_wpchannel_bily($short_link,$chbot_options))
					$short_link=$shortened_link;
			/*send continue*/
			if($quick_settings['send_continue']=='1')
			{

				if($chbot_continue_text!="")
				{
					/*if($chbot_post_photo=="")
						$output['{link_anchor}']='<a href="'.trim($short_link).'" >'.$chbot_continue_text.'</a>';
					else $output['{link_anchor}']= trim($short_link);*/
                    $output['{link_anchor}']='<a href="'.trim($short_link).'" >'.$chbot_continue_text.'</a>';
				}
				else
					$output['{link_anchor}']=trim($short_link);
			}
			else
				$chbot_options['new_template']=str_replace(array("{link_anchor}\r\n"), '', $chbot_options['new_template']);
			/*send sign*/
			if($quick_settings['send_sign']=='1')
				$output['{sign}']=$chbot_options['sign'];
			/*image preview*/
			if($image_flag && $chbot_options['photocap']!="1")
			{
				if($chbot_options['imglink']!="")
					$output['{image_anchor}']='<a href="'.$image_url.'" >'.$chbot_options['imglink'].'</a>';
				else
					$output['{image_anchor}']='<a href="'.$image_url.'" >.</a>';
			}

			//$chbot_sendstring=strstr($chbot_options['new_template'],$output);


			if($post_type!='product' && $post_type!='download')
				$chbot_options['new_template']=str_replace(array("{post_type_data}\r\n"), '', $chbot_options['new_template']);
			//$chbot_sendstring=$chbot_options['new_template'];

            /*customized plugins specific*/
            if(class_exists('Eastweb_wpchannel_customized')){
                if(method_exists('Eastweb_wpchannel_customized','beforeTemplate')){
                    Eastweb_wpchannel_customized::beforeTemplate($post,$output,$chbot_options,$quick_settings);
                }
            }

			$chbot_sendstring=strtr($chbot_options['new_template'],$output);
			$temp_path=false;
			$file=false;
			$upload=$chbot_options['uploadfiles'];
			$params=array(
				'email'=>$chbot_options['email'],
				'key'=>$chbot_options['key'],
				'text'=>$chbot_sendstring,
				'channel'=>$quick_settings['channel'],
				'notif'=>$quick_settings['notif'],
				'token'=>$chbot_options['token'],
				'ver'=>CHBOT_VER,
				'blogname'=>get_option('blogname'),
				'blogurl'=>get_option('siteurl'),
				'admin_email'=>get_option('admin_email'),
				'server_date'=>time(),
				'post_url'=>trim($short_link),
				'post_title'=>trim($chbot_post_title),
				'post_type'=>$post_type,
				'quick_settings'=>json_encode($quick_settings),
				'settings'=>json_encode($chbot_options),
				'post_type_values'=>json_encode($post_type_values)
			);
			if($chbot_options['keyboard']=='1')
				$params['keyboard']='1';
			if($chbot_options['keyboard_post_link']=='1')
				$params['keyboard_post_link']='1';
			if($chbot_options['keyboard_blog_link']=='1')
				$params['keyboard_blog_link']='1';

			/*customized plugins specific*/
            if(class_exists('Eastweb_wpchannel_customized')){
                if(method_exists('Eastweb_wpchannel_customized','afterPack')){
                    Eastweb_wpchannel_customized::afterPack($post,$params,$chbot_options,$quick_settings);
                }
            }
			if($chbot_options['channels'])
			{
				$post_categories = wp_get_post_categories( $post->ID );
				$chbot_channels=explode(';',$chbot_options['channels']);
				if($chbot_channels)
				{
					if($chbot_post_photo=="")
					{
						$params['operation']='send_text';
						if($quick_settings['channel']=='auto')
						{
								foreach($chbot_channels as $channel)
								{
                                    $reoutput=array(
                                        '{channel_sign}'=>''
                                    );
                                    if(isset($chbot_options['channel_signs'][$channel]))
                                        $reoutput['{channel_sign}']=$chbot_options['channel_signs'][$channel];
                                    $params['text']=strtr($chbot_sendstring,$reoutput);

									$result = array_intersect($chbot_options['channel_pair'][$channel], $post_categories);

									if($result)
									{
										$params['channel']=$channel;
										//if($sent=chbot_download_url(get_option('chbot_api'),$params))
                                        if($sent=eastweb_wpch_local($params))
											if($jsent=json_decode($sent,true))
											{
												$status=array('ok'=>$jsent['ok']);
												if(!$status['ok'])
													$status['error']=$jsent['error'];
												else
												{
                                                    if(isset($jsent['error']) && !empty($jsent['error']))
												        $status['error']=$jsent['error'];
													if(isset($jsent['tgpid']))
													{
														if(substr($params['channel'],0,1)=='@')
														{
															$channellink=get_post_meta($post->ID,'_chbot_channellink',true);
															if((!$channellink) || $channellink=='')
																$channellink=array();
															else
																$channellink=json_decode($channellink,true);
															$channellink[$params['channel']]=$jsent['tgpid'];
															delete_post_meta($post->ID, '_chbot_channellink');
															add_post_meta($post->ID, '_chbot_channellink', str_replace('\\','\\\\',json_encode($channellink)) );
														}
														delete_post_meta($post->ID, '_chbot_tgpid');
														add_post_meta($post->ID, '_chbot_tgpid', str_replace('\\','\\\\',json_encode($jsent['tgpid'])) );
													}
													if(isset($jsent['plink']))
													{
														delete_post_meta($post->ID, '_chbot_plink');
														add_post_meta($post->ID, '_chbot_plink', str_replace('\\','\\\\',json_encode($jsent['plink'])) );
													}
													if(isset($quick_settings['chfile']['link']))
														if(trim($quick_settings['chfile']['link'])!=='')
														{
															if(!$file)
															{

                                                                $ext = pathinfo($quick_settings['chfile']['link'], PATHINFO_EXTENSION);
                                                                $path_with_query=$quick_settings['chfile']['link'];
                                                                $path=explode("?",$path_with_query);
                                                                $filename=basename($path[0]);
                                                                if(!in_array($ext,array('pdf','zip','gif')) || $chbot_options['localprocess'])
                                                                {
                                                                    $temp_directory=CHBOT_DIR;
                                                                    $temp_file=chbot_download_url($quick_settings['chfile']['link']);

                                                                    $hash=eastweb_c_code();
                                                                    $temp_path=$temp_directory.$hash.'.'.$ext;/*randomize*/
                                                                    if(!empty($filename))
                                                                    {//preserve original file name
                                                                        $temp_path=$temp_directory.$filename;
                                                                    }

                                                                    file_put_contents($temp_path,$temp_file);
                                                                    $file =$temp_path;
                                                                    $upload=true;
                                                                }

															}
															if($res=eastweb_wpch_make_request($params['token'], array('chat_id'=>$params['channel'],'document'=>$file,'caption'=>$quick_settings['chfile']['title'],'notification'=>$quick_settings['notif']), $upload))
															{
																if($jsn=json_decode($res))
																	if($jsn->ok)
																	{
																		$file=$jsn->result->document->file_id;
																		$upload=$chbot_options['uploadfiles'];
																		unlink($temp_path);
																	}

															}
															
														}

												}

												delete_post_meta($post->ID, '_chbot_status');
												add_post_meta($post->ID, '_chbot_status', str_replace('\\','\\\\',json_encode($status)) );

												if(isset($jsent['settings']))
													update_api($jsent['settings']);
											}


									}

								}

						}
						elseif($quick_settings['channel']=='all')
						{

							foreach($chbot_channels as $channel)
							{
                                $reoutput=array(
                                    '{channel_sign}'=>''
                                );
                                if(isset($chbot_options['channel_signs'][$channel]))
                                    $reoutput['{channel_sign}']=$chbot_options['channel_signs'][$channel];
                                $params['text']=strtr($chbot_sendstring,$reoutput);

								$params['channel']=$channel;
                                //if($sent=chbot_download_url(get_option('chbot_api'),$params))
                                if($sent=eastweb_wpch_local($params))
									if($jsent=json_decode($sent,true))
									{
										$status=array('ok'=>$jsent['ok']);
										if(!$status['ok'])
                                        {
                                            $status['error']=$jsent['error'];
                                            add_action( 'admin_notices', 'eastweb_wpch_notice_error' );

                                        }
										else
										{
                                            if(isset($jsent['error']) && !empty($jsent['error']))
                                                $status['error']=$jsent['error'];
											if(isset($jsent['tgpid']))
											{
												if(substr($params['channel'],0,1)=='@')
												{
													$channellink=get_post_meta($post->ID,'_chbot_channellink',true);
													if((!$channellink) || $channellink=='')
														$channellink=array();
													else
														$channellink=json_decode($channellink,true);
													$channellink[$params['channel']]=$jsent['tgpid'];
													delete_post_meta($post->ID, '_chbot_channellink');
													add_post_meta($post->ID, '_chbot_channellink', str_replace('\\','\\\\',json_encode($channellink)) );
												}
												delete_post_meta($post->ID, '_chbot_tgpid');
												add_post_meta($post->ID, '_chbot_tgpid', str_replace('\\','\\\\',json_encode($jsent['tgpid'])) );
											}
											if(isset($jsent['plink']))
											{
												delete_post_meta($post->ID, '_chbot_plink');
												add_post_meta($post->ID, '_chbot_plink', str_replace('\\','\\\\',json_encode($jsent['plink'])) );
											}
											if(isset($quick_settings['chfile']['link']))
												if(trim($quick_settings['chfile']['link'])!=='')
												{
													if(!$file)
													{

                                                        $ext = pathinfo($quick_settings['chfile']['link'], PATHINFO_EXTENSION);
                                                        $path_with_query=$quick_settings['chfile']['link'];
                                                        $path=explode("?",$path_with_query);
                                                        $filename=basename($path[0]);
                                                        if(!in_array($ext,array('pdf','zip','gif')) || $chbot_options['localprocess'])
                                                        {
                                                            $temp_directory=CHBOT_DIR;
                                                            $temp_file=chbot_download_url($quick_settings['chfile']['link']);

                                                            $hash=eastweb_c_code();
                                                            $temp_path=$temp_directory.$hash.'.'.$ext;/*randomize*/
                                                            if(!empty($filename))
                                                            {//preserve original file name
                                                                $temp_path=$temp_directory.$filename;
                                                            }

                                                            file_put_contents($temp_path,$temp_file);
                                                            $file =$temp_path;
                                                            $upload=true;
                                                        }

													}
													if($res=eastweb_wpch_make_request($params['token'], array('chat_id'=>$params['channel'],'document'=>$file,'caption'=>$quick_settings['chfile']['title'],'notification'=>$quick_settings['notif']), $upload))
													{
														if($jsn=json_decode($res))
															if($jsn->ok)
															{
																$file=$jsn->result->document->file_id;
																$upload=$chbot_options['uploadfiles'];
																unlink($temp_path);
															}
													}

												}

										}
										delete_post_meta($post->ID, '_chbot_status');
										add_post_meta($post->ID, '_chbot_status', str_replace('\\','\\\\',json_encode($status)) );

										if(isset($jsent['settings']))
											update_api($jsent['settings']);
									}
							}

						}
						elseif($quick_settings['channel']!='')
                        {
                            $reoutput=array(
                                '{channel_sign}'=>''
                            );
                            if(isset($chbot_options['channel_signs'][$quick_settings['channel']]))
                                $reoutput['{channel_sign}']=$chbot_options['channel_signs'][$quick_settings['channel']];
                            $params['text']=strtr($chbot_sendstring,$reoutput);
                            //if($sent=chbot_download_url(get_option('chbot_api'),$params))
                            if($sent=eastweb_wpch_local($params))
                                if($jsent=json_decode($sent,true))
                                {
                                    $status=array('ok'=>$jsent['ok']);
                                    if(!$status['ok'])
                                        $status['error']=$jsent['error'];
                                    else
                                    {
                                        if(isset($jsent['error']) && !empty($jsent['error']))
                                            $status['error']=$jsent['error'];
                                        if(isset($jsent['tgpid']))
                                        {
                                            if(substr($params['channel'],0,1)=='@')
                                            {
                                                $channellink=get_post_meta($post->ID,'_chbot_channellink',true);
                                                if((!$channellink) || $channellink=='')
                                                    $channellink=array();
                                                else
                                                    $channellink=json_decode($channellink,true);
                                                $channellink[$params['channel']]=$jsent['tgpid'];
                                                delete_post_meta($post->ID, '_chbot_channellink');
                                                add_post_meta($post->ID, '_chbot_channellink', str_replace('\\','\\\\',json_encode($channellink)) );
                                            }
                                            delete_post_meta($post->ID, '_chbot_tgpid');
                                            add_post_meta($post->ID, '_chbot_tgpid', str_replace('\\','\\\\',json_encode($jsent['tgpid'])) );
                                        }
                                        if(isset($jsent['plink']))
                                        {
                                            delete_post_meta($post->ID, '_chbot_plink');
                                            add_post_meta($post->ID, '_chbot_plink', str_replace('\\','\\\\',json_encode($jsent['plink'])) );
                                        }
                                        if(isset($quick_settings['chfile']['link']))
                                            if(trim($quick_settings['chfile']['link'])!=='')
                                            {
                                                if(!$file)
                                                {

                                                    $ext = pathinfo($quick_settings['chfile']['link'], PATHINFO_EXTENSION);
                                                    if(!in_array($ext,array('pdf','zip','gif')))
                                                    {
                                                        $temp_directory=CHBOT_DIR;
                                                        $temp_file=chbot_download_url($quick_settings['chfile']['link']);

                                                        $hash=eastweb_c_code();
                                                        $temp_path=$temp_directory.$hash.'.'.$ext;/*randomize*/
                                                        file_put_contents($temp_path,$temp_file);
                                                        $file =$temp_path;
                                                        $upload=true;
                                                    }

                                                }
                                                if($res=eastweb_wpch_make_request($params['token'], array('chat_id'=>$params['channel'],'document'=>$file,'caption'=>$quick_settings['chfile']['title'],'notification'=>$quick_settings['notif']), $upload))
                                                {
                                                    if($jsn=json_decode($res))
                                                        if($jsn->ok)
                                                        {
                                                            $file=$jsn->result->document->file_id;
                                                            $upload=$chbot_options['uploadfiles'];
                                                            unlink($temp_path);
                                                        }
                                                }

                                            }

                                    }
                                    delete_post_meta($post->ID, '_chbot_status');
                                    add_post_meta($post->ID, '_chbot_status', str_replace('\\','\\\\',json_encode($status)));

                                    if(isset($jsent['settings']))
                                        update_api($jsent['settings']);
                                }

                        }

					}
					else
					{
						$params['operation']='send_image';
						/*$image_url = trim(wp_get_attachment_url( get_post_thumbnail_id($post->ID) ));*/
						/*if (has_post_thumbnail( $post->ID ) )
							$image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );*/
                        $image_url=wp_get_attachment_url( get_post_thumbnail_id($post->ID), 'thumbnail' );
						if(!$chbot_options['use_ewproxy'] && $chbot_options['uploadfiles'] && $image_url!='')
                        {
                            $params['photo']=eastweb_return_image_path(get_post_thumbnail_id($post->ID));
                        }
                        elseif($image_url!="")
						{
							$params['photo']=$image_url;
						}
						$params['caption']=$params['text'];
						$params['text']='';
						if($quick_settings['channel']=='auto')
						{
							foreach($chbot_channels as $channel)
							{
								$result = array_intersect($chbot_options['channel_pair'][$channel], $post_categories);

								if($result)
								{
                                    $reoutput=array(
                                        '{channel_sign}'=>''
                                    );
                                    if(isset($chbot_options['channel_signs'][$channel]))
                                        $reoutput['{channel_sign}']=$chbot_options['channel_signs'][$channel];
                                    $params['caption']=strtr($chbot_sendstring,$reoutput);

									$params['channel'] = $channel;
                                    //if($sent=chbot_download_url(get_option('chbot_api'),$params))
                                    if($sent=eastweb_wpch_local($params))
										if ($jsent = json_decode($sent, true)) {
											$status = array('ok' => $jsent['ok']);
											if (!$status['ok'])
												$status['error'] = $jsent['error'];
											else
											{
                                                if(isset($jsent['error']) && !empty($jsent['error']))
                                                    $status['error']=$jsent['error'];
												if(isset($jsent['tgpid']))
												{
													if(substr($params['channel'],0,1)=='@')
													{
														$channellink=get_post_meta($post->ID,'_chbot_channellink',true);
														if((!$channellink) || $channellink=='')
															$channellink=array();
														else
															$channellink=json_decode($channellink,true);
														$channellink[$params['channel']]=$jsent['tgpid'];
														delete_post_meta($post->ID, '_chbot_channellink');
														add_post_meta($post->ID, '_chbot_channellink', str_replace('\\','\\\\',json_encode($channellink)) );
													}
													delete_post_meta($post->ID, '_chbot_tgpid');
													add_post_meta($post->ID, '_chbot_tgpid', str_replace('\\','\\\\',json_encode($jsent['tgpid'])) );
												}
												if(isset($jsent['plink']))
												{
													delete_post_meta($post->ID, '_chbot_plink');
													add_post_meta($post->ID, '_chbot_plink', str_replace('\\','\\\\',json_encode($jsent['plink'])) );
												}
												if(isset($quick_settings['chfile']->link))
													if(trim($quick_settings['chfile']->link)!=='')
													{
														if(!$file)
														{
                                                            $ext = pathinfo($quick_settings['chfile']['link'], PATHINFO_EXTENSION);
                                                            $path_with_query=$quick_settings['chfile']['link'];
                                                            $path=explode("?",$path_with_query);
                                                            $filename=basename($path[0]);
                                                            if(!in_array($ext,array('pdf','zip','gif')) || $chbot_options['localprocess'])
                                                            {
                                                                $temp_directory=CHBOT_DIR;
                                                                $temp_file=chbot_download_url($quick_settings['chfile']['link']);

                                                                $hash=eastweb_c_code();
                                                                $temp_path=$temp_directory.$hash.'.'.$ext;/*randomize*/
                                                                if(!empty($filename))
                                                                {//preserve original file name
                                                                    $temp_path=$temp_directory.$filename;
                                                                }

                                                                file_put_contents($temp_path,$temp_file);
                                                                $file =$temp_path;
                                                                $upload=true;
                                                            }
														}
														if($res=eastweb_wpch_make_request($params['token'], array('chat_id'=>$params['channel'],'document'=>$file,'caption'=>$quick_settings['chfile']['title'],'notification'=>$quick_settings['notif']), true))
														{
															if($jsn=json_decode($res))
																if($jsn->ok)
																{
																	$file=$jsn->result->document->file_id;
																	$upload=$chbot_options['uploadfiles'];
																	unlink($temp_path);
																}
														}

													}

											}
											delete_post_meta($post->ID, '_chbot_status');
											add_post_meta($post->ID, '_chbot_status', str_replace('\\','\\\\',json_encode($status)));

											if(isset($jsent['settings']))
												update_api($jsent['settings']);
										}
								}
							}

						}
						elseif($quick_settings['channel']=='all')
						{
							foreach($chbot_channels as $channel)
							{
                                $reoutput=array(
                                    '{channel_sign}'=>''
                                );
                                if(isset($chbot_options['channel_signs'][$channel]))
                                    $reoutput['{channel_sign}']=$chbot_options['channel_signs'][$channel];
                                $params['caption']=strtr($chbot_sendstring,$reoutput);

								$params['channel']=$channel;
                                //if($sent=chbot_download_url(get_option('chbot_api'),$params))
                                if($sent=eastweb_wpch_local($params))
									if($jsent=json_decode($sent,true))
									{
										$status=array('ok'=>$jsent['ok']);
										if(!$status['ok'])
											$status['error']=$jsent['error'];
										else
										{
                                            if(isset($jsent['error']) && !empty($jsent['error']))
                                                $status['error']=$jsent['error'];
											if(isset($jsent['tgpid']))
											{
												if(substr($params['channel'],0,1)=='@')
												{
													$channellink=get_post_meta($post->ID,'_chbot_channellink',true);
													if((!$channellink) || $channellink=='')
														$channellink=array();
													else
														$channellink=json_decode($channellink,true);
													$channellink[$params['channel']]=$jsent['tgpid'];
													delete_post_meta($post->ID, '_chbot_channellink');
													add_post_meta($post->ID, '_chbot_channellink', str_replace('\\','\\\\',json_encode($channellink)) );
												}
												delete_post_meta($post->ID, '_chbot_tgpid');
												add_post_meta($post->ID, '_chbot_tgpid', str_replace('\\','\\\\',json_encode($jsent['tgpid'])) );
											}
											if(isset($jsent['plink']))
											{
												delete_post_meta($post->ID, '_chbot_plink');
												add_post_meta($post->ID, '_chbot_plink', str_replace('\\','\\\\',json_encode($jsent['plink'])) );
											}
											if(isset($quick_settings['chfile']['link']))
												if(trim($quick_settings['chfile']['link'])!=='')
												{
													if(!$file)
													{

														$ext = pathinfo($quick_settings['chfile']['link'], PATHINFO_EXTENSION);
                                                        $path_with_query=$quick_settings['chfile']['link'];
                                                        $path=explode("?",$path_with_query);
                                                        $filename=basename($path[0]);
                                                        if(!in_array($ext,array('pdf','zip','gif')) || $chbot_options['localprocess'])
                                                        {
                                                            $temp_directory=CHBOT_DIR;
                                                            $temp_file=chbot_download_url($quick_settings['chfile']['link']);

                                                            $hash=eastweb_c_code();
                                                            $temp_path=$temp_directory.$hash.'.'.$ext;/*randomize*/
                                                            if(!empty($filename))
                                                            {//preserve original file name
                                                                $temp_path=$temp_directory.$filename;
                                                            }

                                                            file_put_contents($temp_path,$temp_file);
                                                            $file =$temp_path;
                                                            $upload=true;
                                                        }

													}
													if($res=eastweb_wpch_make_request($params['token'], array('chat_id'=>$params['channel'],'document'=>$file,'caption'=>$quick_settings['chfile']['title'],'notification'=>$quick_settings['notif']), $upload))
													{
														if($jsn=json_decode($res))
															if($jsn->ok)
															{
																$file=$jsn->result->document->file_id;
																$upload=false;
																unlink($temp_path);
															}
													}

												}

										}
										delete_post_meta($post->ID, '_chbot_status');
										add_post_meta($post->ID, '_chbot_status', str_replace('\\','\\\\',json_encode($status)) );

										if(isset($jsent['settings']))
											update_api($jsent['settings']);
									}
							}

						}
						elseif($quick_settings['channel']!='')
                        {
                            $reoutput=array(
                                '{channel_sign}'=>''
                            );
                            if(isset($chbot_options['channel_signs'][$quick_settings['channel']]))
                                $reoutput['{channel_sign}']=$chbot_options['channel_signs'][$quick_settings['channel']];
                            $params['caption']=strtr($chbot_sendstring,$reoutput);

                            //if($sent=chbot_download_url(get_option('chbot_api'),$params))
                            if($sent=eastweb_wpch_local($params))
                                if($jsent=json_decode($sent,true))
                                {
                                    $status=array('ok'=>$jsent['ok']);
                                    if(!$status['ok'])
                                        $status['error']=$jsent['error'];
                                    else
                                    {
                                        if(isset($jsent['error']) && !empty($jsent['error']))
                                            $status['error']=$jsent['error'];
                                        if(isset($jsent['tgpid']))
                                        {
                                            if(substr($quick_settings['channel'],0,1)=='@')
                                            {
                                                $channellink=get_post_meta($post->ID,'_chbot_channellink',true);
                                                if((!$channellink) || $channellink=='')
                                                    $channellink=array();
                                                else
                                                    $channellink=json_decode($channellink,true);
                                                $channellink[$quick_settings['channel']]=$jsent['tgpid'];
                                                delete_post_meta($post->ID, '_chbot_channellink');
                                                add_post_meta($post->ID, '_chbot_channellink', str_replace('\\','\\\\',json_encode($channellink)) );
                                            }

                                            delete_post_meta($post->ID, '_chbot_tgpid');
                                            add_post_meta($post->ID, '_chbot_tgpid', str_replace('\\','\\\\',json_encode($jsent['tgpid'])) );
                                        }
                                        if(isset($jsent['plink']))
                                        {
                                            delete_post_meta($post->ID, '_chbot_plink');
                                            add_post_meta($post->ID, '_chbot_plink', str_replace('\\','\\\\',json_encode($jsent['plink'])) );
                                        }
                                        if(isset($quick_settings['chfile']['link']))
                                            if(trim($quick_settings['chfile']['link'])!=='')
                                            {
                                                if(!$file)
                                                {

                                                    $ext = pathinfo($quick_settings['chfile']['link'], PATHINFO_EXTENSION);
                                                    $path_with_query=$quick_settings['chfile']['link'];
                                                    $path=explode("?",$path_with_query);
                                                    $filename=basename($path[0]);
                                                    if(!in_array($ext,array('pdf','zip','gif')) || $chbot_options['localprocess'])
                                                    {
                                                        $temp_directory=CHBOT_DIR;
                                                        $temp_file=chbot_download_url($quick_settings['chfile']['link']);

                                                        $hash=eastweb_c_code();
                                                        $temp_path=$temp_directory.$hash.'.'.$ext;/*randomize*/
                                                        if(!empty($filename))
                                                        {//preserve original file name
                                                            $temp_path=$temp_directory.$filename;
                                                        }

                                                        file_put_contents($temp_path,$temp_file);
                                                        $file =$temp_path;
                                                        $upload=true;
                                                    }

                                                }
                                                if($res=eastweb_wpch_make_request($params['token'], array('chat_id'=>$params['channel'],'document'=>$file,'caption'=>$quick_settings['chfile']['title'],'notification'=>$quick_settings['notif']), $upload))
                                                {
                                                    if($jsn=json_decode($res))
                                                        if($jsn->ok)
                                                        {
                                                            $file=$jsn->result->document->file_id;
                                                            $upload=$chbot_options['uploadfiles'];
                                                            unlink($temp_path);
                                                        }
                                                }

                                            }


                                    }
                                    delete_post_meta($post->ID, '_chbot_status');
                                    add_post_meta($post->ID, '_chbot_status', str_replace('\\','\\\\',json_encode($status)) );

                                    if(isset($jsent['settings']))
                                        update_api($jsent['settings']);
                                }
                        }
					}
				}
			}
		}
		
	}
}
function eastweb_return_image_path($thumbID) {

    /*$image= wp_get_attachment_image_src($thumbID);
    $imagepath= str_replace(site_url('','https'), $_SERVER['DOCUMENT_ROOT'], $image[0]);
    $imagepath= str_replace(site_url('','http'), $_SERVER['DOCUMENT_ROOT'], $imagepath);

    if($imagepath) return $imagepath;*/
    /*global $post;
    $url = wp_get_attachment_url( $post->ID );
    $uploads = wp_upload_dir();
    $file_path = str_replace( $uploads['baseurl'], $uploads['basedir'], $url );
    if($file_path)
        return $file_path;*/
    return get_attached_file($thumbID);
    return false;

}
function wpchbot_settings_meta_box_markup()
{
	global $post;
	$post_type=get_post_type();
	$quick_options=chbot_quick_settings($post,$posted=false,$post_meta=true,$create_meta=false,$update_meta=false);
	$chbot_options=botscript_chbot_settings();
	if($post_type=="product")
     require_once(CHBOT_DIR.'channel-bot-meta-box.php');
	elseif($post_type=="download")
		require_once(CHBOT_DIR.'channel-bot-meta-box.php');
	else/*something else*/
		require_once(CHBOT_DIR.'channel-bot-meta-box.php');
}
function wpchbot_custom_text_meta_box_markup()
{
	global $post;
	$quick_options=chbot_quick_settings($post,$posted=false,$post_meta=true,$create_meta=false,$update_meta=false);
    require_once(CHBOT_DIR.'channel-bot-text-box.php');
}
function wpchbot_sent_preview_meta_box_markup()
{
	global $post;
	$quick_options=chbot_quick_settings($post,$posted=false,$post_meta=true,$create_meta=false,$update_meta=false);
	require_once(CHBOT_DIR.'channel-bot-preview-box.php');
}

function add_wpch_meta_box()
{
	global $wpch_valid_post_type;
	$settings=botscript_chbot_settings();

	add_meta_box("wpch-settings-meta-box", "تنظیمات ارسال به کانال", "wpchbot_settings_meta_box_markup", $wpch_valid_post_type, "side", "high", null);
	add_meta_box("wpch-custom_text-meta-box", "متن کانال", "wpchbot_custom_text_meta_box_markup", $wpch_valid_post_type, "advanced", "high", null);
	add_meta_box("wpch-preview-meta-box", "پیش نمایش پست(کانال خودکار شرق وب)", "wpchbot_sent_preview_meta_box_markup", $wpch_valid_post_type, "advanced", "high", null);
}
function chbot_fix_string($html,$strip='')
{
	/*
	libxml_use_internal_errors(true);

	$dom = new DOMDocument();
	@$dom->loadHTML('<?xml encoding="utf-8" ?>' . $html , LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
	@$xpath = new DOMXPath($dom);

	foreach( @$xpath->query('//*[not(node())]') as $node ) {
		@$node->parentNode->removeChild($node);
	}
	return strip_tags(substr(@$dom->saveHTML(), 25),$strip);
*/
	return strip_tags(closetags($html),$strip);
}
function closetags($html) {

	preg_match_all('#<([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);

	$openedtags = $result[1];   #put all closed tags into an array

	preg_match_all('#</([a-z]+)>#iU', $html, $result);

	$closedtags = $result[1];

	$len_opened = count($openedtags);



	if (count($closedtags) == $len_opened) {

		return $html;

	}

	$openedtags = array_reverse($openedtags);



	for ($i=0; $i < $len_opened; $i++) {

		if (!in_array($openedtags[$i], $closedtags)){

			$html .= '</'.$openedtags[$i].'>';

		} else {

			unset($closedtags[array_search($openedtags[$i], $closedtags)]);    }

	}
	return $html;
}

function eastweb_wpch_prepare($post_params){
    //update_option('WPCHPRP','begin');
    global $post;
    $params=$post_params;
    $params['settings']=json_decode($post_params['settings']);
    $params['quick_settings']=json_decode($post_params['quick_settings']);
    $params['post_type_values']=json_decode($post_params['post_type_values']);
    $params['reply_markup']=0;


    if($params['keyboard']) {


        /*if($this->input->post('post_title') && $this->input->post('post_url'))
            $params['reply_markup']['inline_keyboard']=array(array(array('text'=>$this->input->post('post_title'),
                                                                'url'=> $this->input->post('post_url')
                                                            )
                                                        )
            );*/
        /*getting keyboard settings*/
        $inline_rows = array();

        if ($params['post_type'] == 'product') {
            if ($params['quick_settings']->chbot_woo_buy_send) {
                $inline_rows[] = array(array('text' => ($params['settings']->wooproductbtntext != '' ? $params['settings']->wooproductbtntext : 'خرید'),
                    'url' => $params['post_url']
                ));
            }
        } elseif ($params['post_type'] == 'download') {
            if ($params['quick_settings']->chbot_edd_buy_send) {
                $inline_rows[] = array(array('text' => ($params['settings']->eddproductbtntext != '' ? $params['settings']->eddproductbtntext : 'خرید'),
                    'url' => $params['post_url']
                ));
            }
        }


        if (isset($params['keyboard_post_link']) && $params['keyboard_post_link'])
            if ($params['post_title'] && $params['post_url']) {
                $button_title = $params['post_title'];
                if ($params['settings']->keyboard_post_link_text != '') {
                    $button_title = str_replace('{post_title}', $params['post_title'], $params['settings']->keyboard_post_link_text);
                }
                @$inline_rows[] = array(array(
                    'text' => $button_title,
                    'url' => $params['post_url']
                ));
            }
        if (isset($params['keyboard_blog_link']) && $params['keyboard_blog_link'])
            if ($params['blogname'] && $params['blogurl']) {
//                                                                    @$inline_rows[]=array(array('text'=>($params['settings']->keyboard_blog_link_text!=''?$params['settings']->keyboard_blog_link_text:$this->input->post('blogname')),
//                                                                        'url'=> $this->bily($this->input->post('blogurl'))
//                                                                    ));

                $button_title = $params['blogname'];
                if ($params['settings']->keyboard_blog_link_text != '') {
                    $button_title = str_replace('{site_name}', $params['blogname'], $params['settings']->keyboard_blog_link_text);
                    //error_log('BTN:'.$button_title);
                }
                if ($button_title != '') {
                    @$inline_rows[] = array(array(
                        'text' => $button_title,
                        'url' => $params['blogurl']
                    ));
                }

            }

        if ($params['quick_settings']->chbtns) {
            //$params['quick_settings']->chbtns= $params['quick_settings']->chbtns;
            foreach ($params['quick_settings']->chbtns as $chbtn) {
                $params['text'] .= 'ROUND: ' . $index++;
                if ($chbtn->title != '' && $chbtn->link != '') {
                    $link = $chbtn->link;
                    if ($params['settings']->bily_enabled)
                        if ($shortened_link = eastweb_wpchannel_bily($link, (array)$params['settings']))
                            $link = $shortened_link;
                }
                $inline_rows[] = array(array('text' => $chbtn->title,
                    'url' => $link
                ));
            }

        }

        if (count($inline_rows))
            //$params['reply_markup']=json_encode(array('inline_keyboard'=>$inline_rows));
            $params['reply_markup'] = array('inline_keyboard' => $inline_rows);

    }
        //check for proxy settings & if enabled send request to server with bundled request;else return bundle
        if($params['settings']->use_ewproxy){
            /*$params['settings']=json_encode($post_params['settings']);
            $params['quick_settings']=json_encode($post_params['quick_settings']);
            $params['post_type_values']=json_encode($post_params['post_type_values']);
*/
            $result=chbot_download_url(get_option('chbot_api'),$params);
            //update_option('WPCHPRP',$result);
            return json_decode($result,true);
        }

    //server simulation
    $output=array(
        'ok'=>true,
        'params'=>$params,
        'local'=>true,
    );

    return $output;
}
function eastweb_wpch_local($post_params){
    global $post;
    /*last activity*/
    delete_post_meta($post->ID, '_chbot_date');
    add_post_meta($post->ID, '_chbot_date',time() );

    delete_post_meta($post->ID, '_chbot_last_channel');
    add_post_meta($post->ID, '_chbot_last_channel',$post_params['channel'] );

    //if($sent=chbot_download_url(get_option('chbot_api'),$post_params))
    if($jsent=eastweb_wpch_prepare($post_params))
    {$settings=json_decode($post_params['settings'],true);
        if(!isset($jsent['local']))
            $jsent['local']=false;
        if($jsent['ok'] && $jsent['local']){//update_option('WPCHPRP','localprocess detected');

            $jsent['ok']=false;
            $server_params=$jsent['params'];
            $server_params['reply_markup']=json_encode($server_params['reply_markup']);
            if($post_params['operation']=='send_text' && $server_params['text']!='' )
            {
                $start = microtime(true);
                //$response=$tg->send_text($server_params['text'],$server_params['notif']);/*var_dump($tg->send_message($data['token'],$data['channel'],'hello'));*/
                $response=eastweb_wpch_make_request_local($post_params['token'],'sendmessage', $server_params,false,$settings);
                $time_elapsed_secs = microtime(true) - $start;
                if($response['ok'])
                {
                    $jsent['ok']=true;
                    $jsent['tgpid']=$response['result']['message_id'];
                    if(substr($post_params['channel'],0,1)=='@')
                        $output['channellink']=$post_params['channel'].'/'.$jsent['tgpid'];

                }

                elseif(!is_null($response))
                    $jsent['error']='پیام از سوی تلگرام مورد پذیرش قرار نگرفت.'.'<br />خطای: '. $response['error_code'].'<br />'.$response['description'];
                else
                    $jsent['error']='خطا در برقراری ارتباط با تلگرام'.'.'.$response;

            }
            elseif($post_params['operation']=='send_image')
            {
                $caption='';
                if(isset($server_params['caption']))
                {
                    $caption=$server_params['caption'];
                }
                if(!isset($server_params['photo']))
                    $server_params['photo']='';
                $start = microtime(true);

                $response=eastweb_wpch_make_request_local($post_params['token'],'sendphoto', $server_params, $settings['uploadfiles'],$settings);
                $time_elapsed_secs = microtime(true) - $start;
                if($response)
                {
                    if($response['ok'])
                    {
                        $jsent['ok']=true;
                        $jsent['tgpid']=$response['result']['message_id'];
                        if(substr($post_params['channel'],0,1)=='@')
                            $jsent['channellink']=$post_params['channel'].'/'.$jsent['tgpid'];
                    }
                    else
                        $jsent['error']='پیام از سوی تلگرام مورد پذیرش قرار نگرفت.'.'<br />خطای: '. $response['error_code'].'<br />'.$response['description'];
                }
                else
                    $jsent['error']='خطا در برقراری ارتباط با تلگرام.';

            }
            else
                $jsent['error']='درخواست نامعتبر است...';

            $sent=json_encode($jsent);
        }
    }

    return json_encode($jsent);
}

function eastweb_wpch_shortcode($args=null,$content=null){
	$post=get_post();
	$output='';
	if($content!=null)
	{
		/*check for valid url*/

		$url_parts=explode('/',$content);
		if(count($url_parts)==5)
		{
			if(is_numeric($url_parts[4]))
				$output.='<script async src="https://telegram.org/js/telegram-widget.js?2" data-telegram-post="'.$url_parts[3].'/'.$url_parts[4].'" data-width="100%"></script>';

		}


	}
	elseif($post){
		$channellink=get_post_meta($post->ID,'_chbot_channellink',true);
		if((!$channellink) || $channellink=='')
			$channellink=array();
		else
			$channellink=json_decode($channellink,true);
		if(is_array($channellink))
		{
			foreach($channellink as $key=>$value)
			{
				//var_dump($channellink);
				$output.='<script async src="https://telegram.org/js/telegram-widget.js?2" data-telegram-post="'.substr($key,1).'/'.$value.'" data-width="100%"></script>';
			}
		}

	}


	return $output;
}

class Eastweb_wpch_telegram_Widget extends WP_Widget {

	function __construct() {
		parent::__construct(

		// base ID of the widget
			'wpch_channel_post_widget',

			// name of the widget
			__('پیش نمایش پست تلگرام', 'شرق وب' ),

			// widget options
			array (
				'description' => __( 'نمایش پست ارسال شده در کانال تلگرام توسط افزونه کانال خودکار شرق وب', 'شرق وب' )
			)

		);
	}

	function form( $instance ) {

		$defaults = array(
			'link' => ''
		);
		if(isset($instance['link']))
			$link = $instance[ 'link' ];
		else
			$link=$defaults['link'];

		// markup for form ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'link' ); ?>">لینک یک پست خاص را وارد کنید(توجه: کانال بایستی عمومی باشد)(اختیاری):</label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" value="<?php echo esc_attr( $link ); ?>">
			<div><b>مثال:</b></div>
			<div>https://t.me/wpchannelplugin/206</div>
		<div>در صورتی که لینکی وارد نکنید، در هر صفحه ای که هستید پیش نمایش(های) همان پست/صفحه/محصول را(در صورتی که توسط کانال خودکار ارسال شده باشد) خواهید دید.</div>
		</p>

		<?php
	}

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance[ 'link' ] = strip_tags( $new_instance[ 'link' ] );
		return $instance;

	}

	function widget( $args, $instance ) {

		// kick things off
		extract( $args );
		$link=null;
		if(isset($instance['link']))
			if($instance['link']!='')
				$link=$instance['link'];
		echo eastweb_wpch_shortcode(null,$link);
	}

}
function eastweb_register_wpch_widget() {

	register_widget( 'Eastweb_wpch_telegram_Widget' );

}

function eastweb_telegram_floating_button_wpch()
{

	$settings=botscript_chbot_settings();

	if($settings['contactbtn_active'])
	{
		$button_position=$settings['contactbtn_position'];
		$button_hideinmobile=$settings['contactbtn_hideinmobile'];
		$button_maincolor=$settings['contactbtn_maincolor'];
		$button_subcolor=$settings['contactbtn_subcolor'];

		$channels=$settings['contactbtn_channel'];
		$users=$settings['contactbtn_user'];
		$groups=$settings['contactbtn_group'];
		$bots=$settings['contactbtn_bot'];

        $channeltooltips=$settings['contactbtn_channel_tooltip'];
        $usertooltips=$settings['contactbtn_user_tooltip'];
        $grouptooltips=$settings['contactbtn_group_tooltip'];
        $bottooltips=$settings['contactbtn_bot_tooltip'];
        $tooltip_position='left';

		if($button_position=='downright')
        {
            $style_position='right';
            $tooltip_position='left';
        }
		if($button_position=='downleft')
        {
            $style_position='left';
            $tooltip_position='right';
        }

		$styles='';
		if($button_hideinmobile)
			$styles.='@media screen and (max-width: 600px)  { .eflbcontact-button{display:none !important;}} ';
		$styles.=".eflbcontact-button{
        font-family: 'Roboto';
        text-align: center;
        background: #f1f1f1;
    }
    #floating-button{
        width: 55px;
        height: 55px;
        border-radius: 50%;
        background: ".$button_maincolor.";
        position: fixed;
        bottom: 30px;
        ".$style_position.": 30px;
        cursor: pointer;
        box-shadow: 0px 2px 5px #666;
    }

    .eflbplus{
        color: white;
        position: absolute;
        top: 0;
        display: block;
        bottom: 0;
        left: 0;
        right: 0;
        text-align: center;
        padding: 0;
        margin: 0;
        line-height: 55px;
        font-size: 38px;
        font-family: 'Roboto';
        font-weight: 300;
        animation: eflbplus-out 0.3s;
        transition: all 0.3s;
        background-image: url('".plugin_dir_url( __FILE__ )."assets"."/telegram2629.png') ;
        /*background-size: 80%;*/
        background-repeat: no-repeat;
        background-position: center;
    }

    #container-floating{
        position: fixed;
        width: 70px;
        height: 70px;
        bottom: 30px;
        ".$style_position.": 30px;
        z-index: 5000000000;
    }

    

    #container-floating:hover .eflbplus{
        animation: eflbplus-in 0.15s linear;
        animation-fill-mode: forwards;
    }

    .eflbedit{
        position: absolute;
        top: 0;
        display: block;
        bottom: 0;
        left: 0;
        display: block;
        right: 0;
        padding: 0;
        opacity: 0;
        margin: auto;
        line-height: 65px;
        transform: rotateZ(-70deg);
        transition: all 0.3s;
        animation: eflbedit-out 0.3s;
    }

    #container-floating:hover .eflbedit{
        animation: eflbedit-in 0.2s;
        animation-delay: 0.1s;
        animation-fill-mode: forwards;
    }

    @keyframes eflbedit-in{
        from {opacity: 0; transform: rotateZ(-70deg);}
        to {opacity: 1; transform: rotateZ(0deg);}
    }

    @keyframes eflbedit-out{
        from {opacity: 1; transform: rotateZ(0deg);}
        to {opacity: 0; transform: rotateZ(-70deg);}
    }

    @keyframes eflbplus-in{
        from {opacity: 1; transform: rotateZ(0deg);}
        to {opacity: 0; transform: rotateZ(180deg);}
    }

    @keyframes eflbplus-out{
        from {opacity: 0; transform: rotateZ(180deg);}
        to {opacity: 1; transform: rotateZ(0deg);}
    }

    .eflbnds{
        width: 40px;
        height: 40px;
        border-radius: 50%;
        position: fixed;
        z-index: 300;
        transform:  scale(0);
        cursor: pointer;

        background-color: ".$button_subcolor.";
        border:solid white 2px;
    }
    @keyframes bounce-eflbnds{
        from {opacity: 0;}
        to {opacity: 1; transform: scale(1);}
    }

    @keyframes bounce-out-eflbnds{
        from {opacity: 1; transform: scale(1);}
        to {opacity: 0; transform: scale(0);}
    } 
    #container-floating:hover .eflbnds{

        animation: bounce-eflbnds 0.1s linear;
        animation-fill-mode:  forwards;
    }
    
    
[tooltip]::before {
    content: \"\";
    position: absolute;
    /*top:-6px;*/
    left:50%;
    transform: translateX(-50%);
    border-width: 4px 6px 0 6px;
    border-style: solid;
    border-color: rgba(0,0,0,0.7) transparent transparent     transparent;
    z-index: 99;
    opacity:0;
}

[tooltip-position='left']::before{
  left:50%;
  /*top:50%;*/
  margin-left:-12px;
  transform:translatey(-50%) rotate(-90deg) 
}
[tooltip-position='top']::before{
  left:50%;
}
[tooltip-position='buttom']::before{
  /*top:100%;*/
  margin-top:8px;
  transform: translateX(-50%) translatey(-100%) rotate(-180deg)
}
[tooltip-position='right']::before{
  left:50%;
  /*top:50%;*/
  margin-left:1px;
  transform:translatey(-50%) rotate(90deg)
}

[tooltip]::after {
    content: attr(tooltip);
    position: absolute;
    left:50%;
    /*top:-6px;*/
    transform: translateX(-50%)   translateY(-100%);
    background: rgba(0,0,0,0.7);
    text-align: center;
    color: #fff;
    white-space: nowrap;
    font-size: 12px;
    min-width: 80px;
    border-radius: 5px;
    pointer-events: none;
    padding: 4px 4px;
    z-index:99;
    opacity:0;
}

[tooltip-position='left']::after{
  left:50%;
  /*top:50%;*/
  margin-left:-8px;
  transform: translateX(-100%)   translateY(-50%);
}
[tooltip-position='top']::after{
  left:50%;
}
[tooltip-position='buttom']::after{
  top:100%;
  margin-top:8px;
  transform: translateX(-50%) translateY(0%);
}
[tooltip-position='right']::after{
  left:50%;
  /*top:50%;*/
  margin-left:8px;
  transform: translateX(0%)   translateY(-50%);
}

[tooltip]:hover::after,[tooltip]:hover::before {
   opacity:1
}
   ";
		$buttons='';
		if($channels!='' || $groups!=='' || $bots!=='' || $users!='' )
		{
			$i=0;
			$margin=37;$mlevel=60;
			$delay=0.2;$dlevel=0.1;
			$delay_out=0.3;$dolevel=0.02;
			$delay_hover=0.08;$dhlevel=0.04;
			$ttbbottom=83;$ttabottom=60;$ttbottomlevel=60;
			$counter=0;
			if($channels)
				foreach ($channels as $item)
				{
					$i++;
					$margin+=$mlevel;
					$delay+=$dlevel;
					$delay_out+=$dolevel;
					$delay_hover+=$dhlevel;
					$styles.=" .eflbnd".($i)."{
							background-image: url('".plugin_dir_url( __FILE__ )."assets"."/channel-t45.png');
							background-size: 100%;
							".$style_position.": 37px;
							bottom: ".($margin)."px;
							animation-delay: ".($delay)."s;
							animation: bounce-out-eflbnds ".($delay_out)."s linear;
							animation-fill-mode:  forwards;
						} 
						#container-floating:hover .eflbnd".$i."{
							animation-delay: ".$delay_hover."s;
						}
						";
					$tooltip='';
					if(isset($channeltooltips[$counter++]))
                    {
                        $styles.=" .eflbnda".$i."::before{
                            bottom:".$ttbbottom."px;
                        }";
                        $styles.=" .eflbnda".$i."::after{
                            bottom:".$ttabottom."px;
                        }";
                        $ttbbottom+=$ttbottomlevel;
                        $ttabottom+=$ttbottomlevel;
                        $tooltip='tooltip="'.$channeltooltips[$counter-1].'" tooltip-position="'.$tooltip_position.'"';
                    }
					$buttons.='<a href="'.$item.'" class="eflbnda'.$i.'" rel="nofollow" target="_blank" '.$tooltip.'><div class="eflbnd'.$i.' eflbnds" ></div></a>';
				}
            $counter=0;
			if($groups)
				foreach ($groups as $item)
				{
					$i++;
					$margin+=$mlevel;
					$delay+=$dlevel;
					$delay_out+=$dolevel;
					$delay_hover+=$dhlevel;

					$styles.=" .eflbnd".($i)."{
							background-image: url('".plugin_dir_url( __FILE__ )."assets"."/group-t45.png');
							background-size: 100%;
							".$style_position.": 37px;
							bottom: ".($margin)."px;
							animation-delay: ".($delay)."s;
							animation: bounce-out-eflbnds ".($delay_out)."s linear;
							animation-fill-mode:  forwards;
						} 
						#container-floating:hover .eflbnd".$i."{
							animation-delay: ".$delay_hover."s;
						}
						";
                    $tooltip='';
                    if(isset($grouptooltips[$counter++]))
                    {
                        $styles.=" .eflbnda".$i."::before{
                            bottom:".$ttbbottom."px;
                        }";
                        $styles.=" .eflbnda".$i."::after{
                            bottom:".$ttabottom."px;
                        }";
                        $ttbbottom+=$ttbottomlevel;
                        $ttabottom+=$ttbottomlevel;
                        $tooltip='tooltip="'.$grouptooltips[$counter-1].'" tooltip-position="'.$tooltip_position.'"';
                    }
                    $buttons.='<a href="'.$item.'" class="eflbnda'.$i.'" rel="nofollow" target="_blank" '.$tooltip.'><div class="eflbnd'.$i.' eflbnds" ></div></a>';
				}
            $counter=0;
			if($bots)
				foreach ($bots as $item)
				{
					$i++;
					$margin+=$mlevel;
					$delay+=$dlevel;
					$delay_out+=$dolevel;
					$delay_hover+=$dhlevel;
					$styles.=" .eflbnd".($i)."{
							background-image: url('".plugin_dir_url( __FILE__ )."assets"."/bot-t45.png');
							background-size: 100%;
							".$style_position.": 37px;
							bottom: ".($margin)."px;
							animation-delay: ".($delay)."s;
							animation: bounce-out-eflbnds ".($delay_out)."s linear;
							animation-fill-mode:  forwards;
						} 
						#container-floating:hover .eflbnd".$i."{
							animation-delay: ".$delay_hover."s;
						}
						";
                    $tooltip='';
                    if(isset($bottooltips[$counter++]))
                    {
                        $styles.=" .eflbnda".$i."::before{
                            bottom:".$ttbbottom."px;
                        }";
                        $styles.=" .eflbnda".$i."::after{
                            bottom:".$ttabottom."px;
                        }";
                        $ttbbottom+=$ttbottomlevel;
                        $ttabottom+=$ttbottomlevel;
                        $tooltip='tooltip="'.$bottooltips[$counter-1].'" tooltip-position="'.$tooltip_position.'"';
                    }
                    $buttons.='<a href="'.$item.'" class="eflbnda'.$i.'" rel="nofollow" target="_blank" '.$tooltip.'><div class="eflbnd'.$i.' eflbnds" ></div></a>';
				}
			$counter=0;
			if($users)
				foreach ($users as $item)
				{
					$i++;
					$margin+=$mlevel;
					$delay+=$dlevel;
					$delay_out+=$dolevel;
					$delay_hover+=$dhlevel;
					$styles.=" .eflbnd".($i)."{
							background-image: url('".plugin_dir_url( __FILE__ )."assets"."/user-t45.png');
							background-size: 100%;
							".$style_position.": 37px;
							bottom: ".($margin)."px;
							animation-delay: ".($delay)."s;
							animation: bounce-out-eflbnds ".($delay_out)."s linear;
							animation-fill-mode:  forwards;
						} 
						#container-floating:hover .eflbnd".$i."{
							animation-delay: ".$delay_hover."s;
						}
						";
                    $tooltip='';
                    if(isset($usertooltips[$counter++]))
                    {
                        $styles.=" .eflbnda".$i."::before{
                            bottom:".$ttbbottom."px;
                        }";
                        $styles.=" .eflbnda".$i."::after{
                            bottom:".$ttabottom."px;
                        }";
                        $ttbbottom+=$ttbottomlevel;
                        $ttabottom+=$ttbottomlevel;
                        $tooltip='tooltip="'.$usertooltips[$counter-1].'" tooltip-position="'.$tooltip_position.'"';
                    }
                    $buttons.='<a href="'.$item.'" class="eflbnda'.$i.'" rel="nofollow" target="_blank" '.$tooltip.'><div class="eflbnd'.$i.' eflbnds" ></div></a>';
				}
			
			if($i)
			{
				$styles.=' #container-floating:hover{
        height: '.($margin+50).'px;
        width: 90px;
        padding: 30px;
    } ';
				echo '<style>'.$styles.'</style><div class="eflbcontact-button">

    <div id="container-floating">'.$buttons.'<div id="floating-button" >
            <p class="eflbplus"></p>
            <img class="eflbedit" src="'.plugin_dir_url( __FILE__ )."assets".'/times-t24.png">
        </div>

    </div>

</div>';
			}
		}
		
	}
}
function eastweb_wpch_make_request($bot_token, array $params = array(), $file_upload = false,$settings=false)
{
	if (function_exists('curl_init')) {
		$curl = curl_init('https://api.telegram.org/bot'.$bot_token.'/senddocument');
		if (PHP_MAJOR_VERSION >= 5 && PHP_MINOR_VERSION >= 5){
			curl_setopt($curl, CURLOPT_SAFE_UPLOAD, true);
		}
		if ($file_upload) {
			/*if (class_exists('CURLFile')) {
				$params['document'] = new CURLFile($params['document']);
			} else*/ {
				$params = eastweb_wpch_curl_custom_postfields($curl, array('chat_id'  => $params['chat_id'], 'caption' => $params['caption']), array('document' => $params['document']));
			}
		} else {
			$params = http_build_query($params);
		}
		$curl_opts=array(
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $params
        );
        $curl_opts=eastweb_curl_opts($curl_opts);
		curl_setopt_array($curl, $curl_opts);
		$response = curl_exec($curl);
		curl_close($curl);
	} else {
		$context = stream_context_create(array(
			'http' => array(
				'method' => 'POST',
				'header' => "Content-type: application/x-www-form-urlencoded\r\n",
				'content' => $params['caption'],
				'timeout' => 10,
			),
		));
		$response = file_get_contents('https://api.telegram.org/bot'.$bot_token.'/senddocument', false, $context);
	}
	return $response;
}
function eastweb_wpch_make_request_local($bot_token,$method, array $params = array(), $img_upload = false,$settings=false)
{
    if(isset($params['reply_markup']))
        if(!$params['reply_markup'])
            unset($params['reply_markup']);
    if (function_exists('curl_init')) {
        if($settings['use_googleproxy'] && !empty($settings['googleproxy'])){

            //$curl = curl_init($settings['googleproxy'].'?bot_token='.$bot_token.'&method='.$method.'&args='.json_encode($params));
            $curl = curl_init($settings['googleproxy']);


        }
        else
            $curl = curl_init('https://api.telegram.org/bot'.$bot_token.'/'.$method);
        if (PHP_MAJOR_VERSION >= 5 && PHP_MINOR_VERSION >= 5){
            curl_setopt($curl, CURLOPT_SAFE_UPLOAD, true);
        }
        if ($img_upload && !$settings['use_googleproxy']) {
            /*if (class_exists('CURLFile') && $method=='sendphoto') {
                $params['photo'] = new CURLFile($params['photo']);
            } else */{
                if($method=='sendphoto')
                {
                    $params_to_create=array('chat_id'=>$params['channel'],'caption'=>$params['caption'],'disable_notification'=>$params['notif'],'parse_mode'=>'HTML');
                    if(isset($params['reply_markup']))
                    {
                        //$params['reply_markup']=json_encode($params['reply_markup']);
                        $params_to_create['reply_markup']=$params['reply_markup'];

                    }
                    $params = eastweb_wpch_curl_custom_postfields($curl, $params_to_create, array('photo' => $params['photo']));
                }
                else
                {
                    $params_to_create=array('chat_id'=>$params['channel'],'text'=>$params['text'],'disable_notification'=>$params['notif'],'parse_mode'=>'HTML');
                    if(isset($params['reply_markup']))
                    {
                        //$params['reply_markup']=json_encode($params['reply_markup']);
                        $params_to_create['reply_markup']=$params['reply_markup'];

                    }
                    $params = eastweb_wpch_curl_custom_postfields($curl, $params_to_create, array('photo' => $params['photo']));
                }

            }
        } else {

            if(isset($params['channel']))
                $params['chat_id']=$params['channel'];

            if(isset($params['notif']))
                $params['disable_notification']=$params['notif'];
            $params['parse_mode']='HTML';
            if($settings['use_googleproxy'] && !empty($settings['googleproxy'])) {
                //$params['reply_markup']=json_encode($params['reply_markup']);
                $newparams = [
                    'method' => $method,
                    'bot_token' => $bot_token,
                    'args' => json_encode($params)
                ];
                $params = $newparams;
            }
            $params = http_build_query($params);

        }


        $curl_opts=array(
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $params,
            CURLOPT_FOLLOWLOCATION =>1
        );
        $curl_opts=eastweb_curl_opts($curl_opts);
        curl_setopt_array($curl, $curl_opts);
        $response = curl_exec($curl);
        curl_close($curl);
    } else {
        $context = stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'content' => $params['caption'],
                'timeout' => 10,
            ),
        ));
        $response = file_get_contents('https://api.telegram.org/bot'.$bot_token.'/'.$method, false, $context);
    }//update_option('CHBTCER',json_encode(curl_error($curl)));

    return json_decode($response,true);
}
function eastweb_curl_opts($opts_array=array()){
    $settings=botscript_chbot_settings();

    if($settings['useproxy'] && is_numeric($settings['proxyport']) && !empty($settings['proxyaddress'])
        && ((filter_var($settings['proxyaddress'], FILTER_VALIDATE_IP)) || true || filter_var($settings['proxyaddress'], FILTER_VALIDATE_URL) !== false)
    )
    {
        $opts_array[CURLOPT_PROXYTYPE]=CURLPROXY_SOCKS5;
        //$opts_array[CURLOPT_PROXYPORT]=$settings['proxyport'];
        $opts_array[CURLOPT_PROXY]=$settings['proxyaddress'].':'.$settings['proxyport'];
        //$opts_array[CURLOPT_PROXYAUTH]=CURLAUTH_ANY ;
        if($settings['proxyusername'] && $settings['proxypassword']){
            $opts_array[CURLOPT_PROXYUSERPWD]=$settings['proxyusername'].':'.$settings['proxypassword'];
        }  $opts_array[CURLOPT_FOLLOWLOCATION]=1;//$opts_array[CURLOPT_HTTPPROXYTUNNEL]=1;

    }


    return $opts_array;
}
function eastweb_wpch_curl_custom_postfields(& $ch, array $assoc = array(), array $files = array()) {

	// invalid characters for "name" and "filename"
	static $disallow = array("\0", "\"", "\r", "\n");

	// initialize body
	$body = array();

	// build normal parameters
	foreach ($assoc as $k => $v) {
		$k = str_replace($disallow, "_", $k);
		$body[] = implode("\r\n", array(
			"Content-Disposition: form-data; name=\"{$k}\"",
			"",
			filter_var($v),
		));
	}

	// build file parameters
	foreach ($files as $k => $v) {
		switch (true) {
			case false === $v = realpath(filter_var($v)):
			case !is_file($v):
			case !is_readable($v):
				continue 2; // or return false, throw new InvalidArgumentException
		}
		$data = file_get_contents($v);
		$v = call_user_func("end", explode(DIRECTORY_SEPARATOR, $v));
		list($k, $v) = str_replace($disallow, "_", array($k, $v));
		$body[] = implode("\r\n", array(
			"Content-Disposition: form-data; name=\"{$k}\"; filename=\"{$v}\"",
			"Content-Type: application/octet-stream",
			"",
			$data,
		));
	}

	// generate safe boundary
	do {
		$boundary = "---------------------" . md5(mt_rand() . microtime());
	} while (preg_grep("/{$boundary}/", $body));

	// add boundary for each parameters
	array_walk($body, function (&$part) use ($boundary) {
		$part = "--{$boundary}\r\n{$part}";
	});

	// add final boundary
	$body[] = "--{$boundary}--";
	$body[] = "";

	// set options
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			"Expect: 100-continue",
			"Content-Type: multipart/form-data; boundary={$boundary}", // change Content-Type
		)
	);
	return implode("\r\n", $body);
}
function eastweb_c_code($length = 10)
{
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}
function eastweb_wpch_notice_success($message='ارسال به کانال با موفقیت انجام شد',$type='success') {
    ?>
    <div class="notice notice-<?=$type;?> is-dismissible">
        <p><?php _e( $message, 'ewpch-plugin' ); ?></p>
    </div>
    <?php
}
function eastweb_wpch_notice_error($message='ارسال به کانال با خطا رو به رو شد',$type='error') {
    ?>
    <div class="notice notice-<?=$type;?> is-dismissible">
        <p><?php _e( $message, 'ewpch-plugin' ); ?></p>
    </div>
    <?php
}
function eastweb_wpch_settings_ajax() {
    $settings=botscript_chbot_settings();
    $output=[
      'ok'=>false,
      'error'=>'عملیاتی تشخیص داده نشد'
    ];
    if(isset($_POST['operation'])){
        if($_POST['operation']=='check_token' && isset($_POST['token'])){
            //use plugin settings to send request[proxies]
            $requestParams=[

            ];
            $method='getme';
            if($reqresult=eastweb_wpch_make_request_local($_POST['token'],$method, $requestParams, false,$settings)){
                if(isset($reqresult['ok']))
                {
                    if($reqresult['ok']){
                        $output['ok']=true;
                        $output['message']='توکن صحیح است و مربوط به ربات '.$reqresult['result']['firstname'].' با شناسه @'.$reqresult['result']['username'].' می باشد.';
                    }
                    else
                        $output['error']='توکن اشتباه است!';
                }
                else
                    $output['error']='خطا در برقرای ارتباط با تلگرام.';
            }
            else
                $output['error']='خطا در برقرای ارتباط با تلگرام';
        }
        elseif($_POST['operation']=='check_channel' && isset($_POST['token']) && isset($_POST['channel'])){
            //use plugin settings to send request[proxies]
            $requestParams=[

            ];
            $method='getme';
            if($reqresult=eastweb_wpch_make_request_local($_POST['token'],$method, $requestParams, false,$settings)){
                if(isset($reqresult['ok']))
                {
                    if($reqresult['ok']){
                        $bot_user_id=$reqresult['result']['id'];
                        $requestParams=[
                            'chat_id'=>$_POST['channel']
                        ];
                        $method='getchatadministrators';
                        if($reqresult=eastweb_wpch_make_request_local($_POST['token'],$method, $requestParams, false,$settings)){
                            if(isset($reqresult['ok']))
                            {
                                if($reqresult['ok']){
                                    foreach ($reqresult['result'] as $admin){
                                        if($admin['user']['id']==$bot_user_id){
                                            if($admin['can_post_messages']){
                                                $output['ok']=true;
                                                $output['message']='عملیات موفقیت آمیز بود. ربات در این کانال دسترسی نوشتن دارد.';
                                            }
                                        }
                                    }
                                    if(!$output['ok'])
                                        $output['error']='خطا: ربات در این کانال ادمین نیست و یا دسترسی ارسال پست ندارد.';
                                }
                                else
                                    $output['error']='خطا: ربات به این کانال دسترسی ندارد و یا نام کاربری کانال به درستی وارد نشده است.';

                            }
                            else
                                $output['error']='خطا در برقرای ارتباط با تلگرام.';
                        }
                        else
                            $output['error']='خطا در برقرای ارتباط با تلگرام';
                    }
                    else
                        $output['error']='توکن اشتباه است.';

                }
                else
                    $output['error']='خطا در برقراری ارتباط با تلگرام.';
            }
            else
                $output['error']='خطا در برقرای ارتباط با تلگرام';


        }
        elseif($_POST['operation']=='bily_login'){
            // Default Bily login link
            $bily_login_link='https://bily.ir/login/';
            $output['ok']=true;//always true
            $output['link']=$bily_login_link;
        }
    }

    if($output['ok'])
        unset($output['error']);
    echo json_encode($output);
    wp_die(); // this is required to terminate immediately and return a proper response
}
function eastweb_get_wc_primary_cat($post){
    $term_list = wp_get_post_terms($post->ID, 'product_cat', ['fields' => 'all']);
    $primary_id=get_post_meta($post->ID, '_yoast_wpseo_primary_product_cat',true);
    foreach($term_list as $term) {
        if(  $primary_id == $term->term_id ) {
            // this is a primary category
            return $term;
        }
    }

    return null;
}
?>