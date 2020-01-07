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
    public function account()
    {    
        $this->load->view('new/account');
    }
        /* FUNCTION: Concerning Login */
    function login($para1 = '', $para2 = '', $para3 = '')
        {
    
            if ($this->session->userdata('user_login') == "yes") {
                redirect(base_url().'home/profile', 'refresh');
            }
            if($this->crud_model->get_settings_value('general_settings','captcha_status','value') == 'ok'){
                $this->load->library('recaptcha');
            }
            $this->load->library('form_validation');

            $page_data    = array();
            $page_data['page_name'] = "login";
    
            if ($para1 == '') {
                $page_data['page_name'] = "user/login";
                $page_data['asset_page'] = "login";
                $page_data['page_title'] = translate('login');
                if($para2 == 'modal'){
                    $page_data['page'] = $para3;
                    $this->load->view('front/user/login/quick_modal', $page_data);
                } else {
                    $this->load->view('front/index', $page_data);
                }
            } elseif ($para1 == 'registration') {
                if($this->crud_model->get_settings_value('general_settings','captcha_status','value') == 'ok'){
                    $page_data['recaptcha_html'] = $this->recaptcha->render();
                }
                $page_data['page_name'] = "user/register";
                $page_data['asset_page'] = "register";
                $page_data['page_title'] = translate('registration');
                if($para2 == 'modal'){
                    $this->load->view('front/user/register/index', $page_data);
                } else {
                    $this->load->view('front/index', $page_data);
                }
            }
            if ($para1 == "do_login") {
                $this->form_validation->set_rules('email', 'Email', 'required');
                $this->form_validation->set_rules('password', 'Password', 'required');
    
                if ($this->form_validation->run() == FALSE)
                {
                    redirect(base_url().'store', 'refresh');
                }
                else
                {
                    $signin_data = $this->db->get_where('user', array(
                        'email' => $this->input->post('email'),
                        'password' => sha1($this->input->post('password'))
                    ));
                    if ($signin_data->num_rows() > 0) {
                        foreach ($signin_data->result_array() as $row) {
                            $this->session->set_userdata('user_login', 'yes');
                            $this->session->set_userdata('user_id', $row['user_id']);
                            $this->session->set_userdata('user_name', $row['username']);
                            $this->session->set_flashdata('alert', 'successful_signin');
                            $this->db->where('user_id', $row['user_id']);
                            $this->db->update('user', array(
                                'last_login' => time()
                            ));
                            redirect(base_url().'home/profile', 'refresh');
                        }
                    } else {
                        redirect(base_url().'store', 'refresh');
                    }
                }
            } else if ($para1 == 'forget') {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('email', 'Email', 'required');
    
                if ($this->form_validation->run() == FALSE)
                {
                    echo validation_errors();
                }
                else
                {
                    $query = $this->db->get_where('user', array(
                        'email' => $this->input->post('email')
                    ));
                    if ($query->num_rows() > 0) {
                        $user_id          = $query->row()->user_id;
                        $password         = substr(hash('sha512', rand()), 0, 12);
                        $data['password'] = sha1($password);
                        $this->db->where('user_id', $user_id);
                        $this->db->update('user', $data);
                        if ($this->email_model->password_reset_email('user', $user_id, $password)) {
                            echo 'email_sent';
                        } else {
                            echo 'email_not_sent';
                        }
                    } else {
                        echo 'email_nay';
                    }
                }
            }
            //$this->load->view('front/index', $page_data);
        }
}