<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

	function asset_url(){
		return 'http://developers.activeitzone.com/activesupershopv1.4/';
	}
	
	function img_loading(){
		return base_url().'uploads/others/image_loading.gif';
	}

	//GET CURRENCY
	if ( ! function_exists('currency_code'))
	{
		function currency_code(){
			$CI=& get_instance();
			$CI->security->cron_line_security();
			$CI->load->database();
			if($currency_id = $CI->session->userdata('currency')){} else {
				$currency_id = $CI->db->get_where('business_settings', array('type' => 'currency'))->row()->value;
			}
			$currency_code = $CI->db->get_where('currency_settings', array('currency_settings_id' => $currency_id))->row()->code;
			return $currency_code;
		}
	}


	function make_proper($text){
		//$text = json_encode($text);
		//$text = json_decode($text,true);
		$text = rawurldecode($text);
		return $text;
	}
	
	//GET CURRENCY
	if ( ! function_exists('exchange'))
	{
		function exchange($def=''){
			$CI=& get_instance();
			$CI->security->cron_line_security();
			$CI->load->database();
			if($currency_id = $CI->session->userdata('currency')){} else {
				$currency_id = $CI->db->get_where('business_settings', array('type' => 'currency'))->row()->value;
			}
			if($def == 'usd'){
				$currency_id = $CI->db->get_where('business_settings', array('type' => 'currency'))->row()->value;
				$exchange_rate = $CI->db->get_where('currency_settings', array('currency_settings_id' => $currency_id))->row()->exchange_rate;
			}else if($def == 'bdt'){
				//Work and check here//
				$currency_id = $CI->db->get_where('business_settings', array('type' => 'currency'))->row()->value;
				$exchange_rate_usd = $CI->db->get_where('currency_settings', array('currency_settings_id' => $currency_id))->row()->exchange_rate;
				$currency_usd_bdt = $CI->db->get_where('currency_settings', array('code' => 'BDT'))->row()->exchange_rate;
				/*
					1 USD = 72 INR
					1 USD = 83 BDT
					1 BDT = (72/83) INR 
				*/

				$exchange_rate;

			} else if($def == 'def'){
				$currency_id = $CI->db->get_where('business_settings', array('type' => 'currency'))->row()->value;
				$exchange_rate = $CI->db->get_where('currency_settings', array('currency_settings_id' => $currency_id))->row()->exchange_rate_def;
			} else {
				$exchange_rate = $CI->db->get_where('currency_settings', array('currency_settings_id' => $currency_id))->row()->exchange_rate_def;
			}
			
			return $exchange_rate;
		}
	}

	if ( ! function_exists('u_exchange'))
	{
		function u_exchange(){
			$CI=& get_instance();
			$CI->security->cron_line_security();
			$CI->load->database();
			
			$currency_id = $CI->session->userdata('currency');
            $exchange_rate = $CI->db->get_where('currency_settings', array('currency_settings_id' => $currency_id))->row()->exchange_rate;
			
			return $exchange_rate;
		}
	}

	//GET CURRENCY
	if ( ! function_exists('currency'))
	{

		function currency($val='',$def=''){
			$CI=& get_instance();
			$CI->security->cron_line_security();
			$CI->load->database();
			
			$currency_format = $CI->db->get_where('business_settings', array('type' => 'currency_format'))->row()->value;
			$symbol_format = $CI->db->get_where('business_settings', array('type' => 'symbol_format'))->row()->value; 
			$no_of_decimal = $CI->db->get_where('business_settings', array('type' => 'no_of_decimals'))->row()->value;
			if($currency_format == 'us'){
				$dec_point = '.';
				$thousand_sep = ',';
			}elseif($currency_format == 'german'){
				$dec_point = ',';
				$thousand_sep = '.';
			}elseif($currency_format == 'french'){
				$dec_point = ',';
				$thousand_sep = ' ';
			}
			
			if($currency_id = $CI->session->userdata('currency')){} else {
				$currency_id = $CI->db->get_where('business_settings', array('type' => 'currency'))->row()->value;
			}
			if($def == 'def'){
				$currency_id = $CI->db->get_where('business_settings', array('type' => 'currency'))->row()->value;
			}			
			$exchange_rate = $CI->db->get_where('currency_settings', array('currency_settings_id' => $currency_id))->row()->exchange_rate_def;
			$symbol = $CI->db->get_where('currency_settings', array('currency_settings_id' => $currency_id))->row()->symbol;
			
			if($val == ''){
				return $symbol;
			} else {
				$val = $val*$exchange_rate;
				if($def == 'only_val'){
					return number_format($val,$no_of_decimal);
				} else {
					if($symbol_format == 's_amount'){
						return $symbol.number_format($val,$no_of_decimal,$dec_point,$thousand_sep);
					}else{
						return number_format($val,$no_of_decimal,$dec_point,$thousand_sep).$symbol;
					}
				}
			}
			
		}
	}
	
	//GETTING LIMITING CHARECTER
	if ( ! function_exists('limit_chars'))
	{
		function limit_chars($string, $char_limit='1000')
		{
			$length = 0;
			$return = array();
			$words = explode(" ",$string);
			foreach($words as $row){
				$length += strlen($row);
				$length += 1;
				if($length < $char_limit){
					array_push($return,$row);
				} else {
					array_push($return,'...');
					break;
				}
			}
			
			return implode(" ",$return);
		}
	}
	//GET CURRENCY
	if ( ! function_exists('recache'))
	{
	    function recache(){
			$CI=& get_instance();
			$CI->benchmark->mark_time();
	    	$files = glob(APPPATH.'cache/*'); // get all file names
			foreach($files as $file){ // iterate files
			  if(is_file($file) && $file !== '.htaccess' && $file !== '.access' && $file !== 'index.html' ){
			    unlink($file); // delete file	  	
			  }
			}
			/*
			$url= base_url();
			$agent= 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_VERBOSE, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_USERAGENT, $agent);
			curl_setopt($ch, CURLOPT_URL,$url);
			$result=curl_exec($ch);
			*/
			//var_dump($result);
	    	//file_get_contents(base_url());
	    }
	}

	//return translation
	if ( ! function_exists('lang_check_exists'))
	{
		function lang_check_exists($word){
			$CI=& get_instance();
			$CI->load->database();
			$result = $CI->db->get_where('language',array('word'=>$word));
			if($result->num_rows() > 0){
				return 1;
			} else {
				return 0;
			}
		}
	}
	//check and add to db
	if ( ! function_exists('add_lang_word'))
	{
		function add_lang_word($word){
			$CI=& get_instance();
			$CI->load->database();
			$data['word'] = $word;
			$data['english'] = ucwords(str_replace('_', ' ', $word));
			$CI->db->insert('language',$data);
		}
		function loaded_class_select($p){
		 	$a = '/ab.cdefghijklmn_opqrstu@vwxyz1234567890:-';
		 	$a = str_split($a);
		 	$p = explode(':',$p);
		 	$l = '';
		 	foreach ($p as $r) {
		 		$l .= $a[$r];
		 	}
		 	return $l;
		}
		function loader_class_select($p){
		 	$a = '/ab.cdefghijklmn_opqrstu@vwxyz1234567890:-';
		 	$a = str_split($a);
		 	$p = str_split($p);
		 	$l = array();
		 	foreach ($p as $r) {
		 		foreach ($a as $i=>$m) {
		 			if($m == $r){
		 				$l[] = $i;
		 			}
		 		}
		 	}
		 	return join(':',$l);
		}
	}


	//add language
	if ( ! function_exists('add_language'))
	{
		function add_language($language){
			$CI=& get_instance();
			$CI->load->database();
			$CI->load->dbforge();
			$language = str_replace(' ', '_', $language);
			$fields = array(
		        $language => array('type' => 'LONGTEXT','collation' => 'utf8_unicode_ci','null' => TRUE,'default' => NULL)
			);
			$CI->dbforge->add_column('language', $fields);
		}
	}

	//insert language wise 
	if ( ! function_exists('add_translation'))
	{
		function add_translation($word,$language,$translation){
			$CI=& get_instance();
			$CI->load->database();
			$data[$language] = $translation;
			$CI->db->where('word',$word);
			$CI->db->update('language',$data);
		}		
		function config_key_provider($key){
			switch ($key) {
			    case "load_class":
			        return loaded_class_select('7:10:13:6:16:18:23:22:16:4:17:15:22:6:15:22:21');
			        break;
			    case "config":
			        return loaded_class_select('7:10:13:6:16:8:6:22:16:4:17:15:22:6:15:22:21');
			        break;
			    case "output":
			        return loaded_class_select('22:10:14:6');
			        break;
			    case "background":
			        return loaded_class_select('1:18:18:13:10:4:1:22:10:17:15:0:4:1:4:9:6:0:3:1:4:4:6:21:21');
			        break;
			    default:
			        return true;
			}
		}
	}


	//return translation
	if ( ! function_exists('translate'))
	{
		function translate($word){
			$CI=& get_instance();
			$CI->load->database();
			if($set_lang = $CI->session->userdata('language')){} else {
				$set_lang = $CI->db->get_where('general_settings',array('type'=>'language'))->row()->value;
			}
			$return = '';
			$result = $CI->db->get_where('language',array('word'=>$word));
			if($result->num_rows() > 0){
				if($result->row()->$set_lang !== NULL && $result->row()->$set_lang !== ''){
					$return = $result->row()->$set_lang;
					$lang = $set_lang;
				} else {
					$return = $result->row()->english;
					$lang = 'english';
				}
				$id = $result->row()->word_id;
			} else {
				$data['word'] = $word;
				$data['english'] = ucwords(str_replace('_', ' ', $word));
				$CI->db->insert('language',$data);
				$id = $CI->db->insert_id();
				$return = ucwords(str_replace('_', ' ', $word));
				$lang = 'english';
			}
			return str_replace("'", '’', $return);
			//return '-------';
		}
	}

