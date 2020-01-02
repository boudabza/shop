<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once APPPATH."libraries/PhpSpreadsheet/vendor/autoload.php";
class Store extends CI_Controller
{

    /*
     *  Developed by: Active IT zone
     *  Date    : 14 July, 2015
     *  Active Supershop eCommerce CMS
     *  http://codecanyon.net/user/activeitezone
     */

    function __construct()
    {
        parent::__construct();
        //$this->output->enable_profiler(TRUE);
        $this->load->database();
        $this->load->library('paypal');
        $this->load->library('twoCheckout_Lib');
        $this->load->library('vouguepay');
        $this->load->library('pum');
        /*cache control*/
        //ini_set("user_agent","My-Great-Marketplace-App");
        $cache_time  =  $this->db->get_where('general_settings',array('type' => 'cache_time'))->row()->value;
        if(!$this->input->is_ajax_request()){
            $this->output->set_header('HTTP/1.0 200 OK');
            $this->output->set_header('HTTP/1.1 200 OK');
            $this->output->set_header('Last-Modified: '.gmdate('D, d M Y H:i:s', time()).' GMT');
            $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
            $this->output->set_header('Cache-Control: post-check=0, pre-check=0');
            $this->output->set_header('Pragma: no-cache');
            if($this->router->fetch_method() == 'index' ||
                $this->router->fetch_method() == 'featured_item' ||
                $this->router->fetch_method() == 'others_product' ||
                $this->router->fetch_method() == 'bundled_product' ||
                $this->router->fetch_method() == 'all_brands' ||
                $this->router->fetch_method() == 'all_category' ||
                $this->router->fetch_method() == 'all_vendor' ||
                $this->router->fetch_method() == 'blog' ||
                $this->router->fetch_method() == 'blog_view' ||
                $this->router->fetch_method() == 'vendor' ||
                $this->router->fetch_method() == 'category'){
                $this->output->cache($cache_time);
            }
        }
        $this->config->cache_query();
        $currency = $this->session->userdata('currency');
        setcookie('lang', $this->session->userdata('language'), time() + (86400), "/");
        setcookie('curr', $this->session->userdata('currency'), time() + (86400), "/");
        //echo $_COOKIE['lang'];
    }

    /* FUNCTION: Loads Homepage*/
    public function index()
    {
        $this->load->view('new/index');
    }
}