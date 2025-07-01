<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cronjob_tac extends CI_controller {
    function __construct(){
        parent::__construct();
        $this->load->database();
    }

    function minutely_tac_expired(){
        $date_now = date("Y-m-d H:i:s");

        $query = $this->db->query("SELECT tac_id FROM far_tac WHERE expired_dttm BETWEEN '2019-01-01 00:00:00' AND '".$date_now."' AND tac_status='unused'");
        $rows = $query->result_array();

        foreach($rows as $a => $b){
            $data = array(
                'tac_status' => 'expired'
            );
            $this->db->where('tac_id', $b['tac_id']);
            $this->db->update('far_tac', $data);
        }

        header("HTTP/1.1 200 OK");
        echo "RECEIVEOK";
    }
}