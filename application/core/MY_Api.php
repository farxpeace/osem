<?php

class API_Controller extends CI_Controller
{
    public $error = array();
    function __construct()
    {
        
        parent::__construct();
        
        //set language
        $this->_check_language();
        //$this->check_installer();
    }
    
    function error($error_array){
        $this->error[] = $error_array;
    }
    
    function check_installer(){
    	$CI = & get_instance();
    	$CI->load->database();
    	$CI->load->dbutil();
        
		if ($CI->db->database == "") {
		  redirect(base_url().'install');
			//header('Location: install');
		} else {
			if (!$CI->dbutil->database_exists($CI->db->database)){
				header('Location: install/index.php?e=db');
			}else if (is_dir('install')) {
				//header('Location: install/index.php?e=folder');
                //redirect(base_url().'install/index.php?method=mainpage&controller=home&message=direxists');
			}
		}
	}
    
    function _check_language(){
        print_r($_POST);
        $site_lang = ($this->session->site_lang ? $this->session->site_lang : "en");
        $this->session->set_userdata('site_lang', $site_lang);
        $this->lang->load('intelmx_lang', $site_lang);
    }
}

