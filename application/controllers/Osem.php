<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Osem extends MY_Controller
{
    private $user;

    function __construct()
    {
        parent::__construct();

        // To load the CI benchmark and memory usage profiler - set 1==1.
        if (1 == 2) {
            $sections = array(
                'benchmarks' => TRUE, 'memory_usage' => TRUE,
                'config' => FALSE, 'controller_info' => FALSE, 'get' => FALSE, 'post' => FALSE, 'queries' => FALSE,
                'uri_string' => FALSE, 'http_headers' => FALSE, 'session_data' => FALSE
            );
            $this->output->set_profiler_sections($sections);
            $this->output->enable_profiler(TRUE);
        }

        // Load required CI libraries and helpers.
        $this->load->helper('cookie');
        $this->load->database();

        // IMPORTANT! This global must be defined BEFORE the flexi auth library is loaded!
        // It is used as a global that is accessible via both models and both libraries, without it, flexi auth will not work.
        $this->auth = new stdClass;

        // Load 'standard' flexi auth library by default.
        $this->load->library('flexi_auth');


        // Define a global variable to store data that is then used by the end view page.
        $this->data = null;

    }

    function crawl(){

        $last_crawl_dttm = $this->far_meta->get_value('last_crawl_dttm');
        $this->data['last_crawl_dttm'] = $last_crawl_dttm;

        $this->load->view('osem/crawl', $this->data);
    }
    function ajax_crawl(){
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();

        $crawl = $this->far_osem->crawl();


        if(count($error) == 0){



            $output['status'] = 'success';
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }
    function list_all(){
        $list_all_product = $this->far_osem->list_all_product();
        $this->data['list_all_product'] = $list_all_product;
        $this->load->view('osem/list_all', $this->data);
    }
}