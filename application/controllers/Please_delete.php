<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Please_delete extends MY_Controller
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
        $this->load->database();
        // IMPORTANT! This global must be defined BEFORE the flexi auth library is loaded!
        // It is used as a global that is accessible via both models and both libraries, without it, flexi auth will not work.
        $this->auth = new stdClass;
        // Load 'standard' flexi auth library by default.
        $this->load->library('flexi_auth');

    }

    function test_construct($uacc_id){
        $this->far_unilevel->construct_all_upline($uacc_id);

        //$list_all_upline = $this->far_unilevel->get_all_upline($uacc_id);
        //echo "<pre>"; print_r($list_all_upline);
    }

    function fix_all_upline(){
        $query = $this->db->query("SELECT * FROM user_accounts ORDER BY uacc_id DESC");
        foreach($query->result_array() as $a => $b){
            $this->far_unilevel->construct_all_upline($b['uacc_id']);
        }
    }

    function get_downline_number(){
        $level_number = $this->far_unilevel->get_downline_number(2263,2261);
        echo $level_number;
    }

    function calculate_shift_date(){
        $simulated_date = "2025-03-20";
        $simulated_dttm_array = [];
        for($i = 0; $i <= 23; $i++){
            $simulated_hour = sprintf("%02d", $i).":00:00";
            $simulated_dttm_array[] = $simulated_date." ".$simulated_hour;
        }

        foreach($simulated_dttm_array as $a => $b){
            $a = $this->far_attendance->calculate_shift_date($b);
            echo "<pre>"; print_r($a); echo "</pre>"; echo "<hr>";
        }


    }

    function calculate_working_hour(){
        $scenario = [
            'scenario_1' => [
                'title' => "Clockin before 4PM<br>Clockout before 4PM",
                'clockin_dttm' => '2025-03-01 09:00:00',
                'clockout_dttm' => '2025-03-01 14:25:00'
            ],
            'scenario_2' => [
                'title' => "Clockin before 4PM<br>Clockout after 4PM, but before 12AM",
                'clockin_dttm' => '2025-03-01 15:00:00',
                'clockout_dttm' => '2025-03-01 17:25:00'
            ],
            'scenario_3' => [
                'title' => "Clockin before 4PM<br>Clockout after 4PM, and before 12AM",
                'clockin_dttm' => '2025-03-01 14:00:00',
                'clockout_dttm' => '2025-03-01 22:25:00'
            ],
            'scenario_4' => [
                'title' => "Clockin before 4PM<br>Clockout after 12PM, and before 2AM",
                'clockin_dttm' => '2025-03-01 15:00:00',
                'clockout_dttm' => '2025-03-02 01:25:00'
            ],
            'scenario_5' => [
                'title' => "Clockin after 4PM<br>Clockout before 12PM",
                'clockin_dttm' => '2025-03-01 16:05:00',
                'clockout_dttm' => '2025-03-01 23:25:00'
            ],
            'scenario_7' => [
                'title' => "Clockin after 4PM<br>Clockout after 12PM, but before 1AM",
                'clockin_dttm' => '2025-03-01 16:00:00',
                'clockout_dttm' => '2025-03-02 00:25:00'
            ],
            'scenario_8' => [
                'title' => "Clockin after 4PM<br>Clockout after 12PM, but before 2AM",
                'clockin_dttm' => '2025-03-01 16:00:00',
                'clockout_dttm' => '2025-03-02 01:25:00'
            ],
            'scenario_9' => [
                'title' => "Clockin after 4PM<br>Clockout after 12PM, but after 2AM",
                'clockin_dttm' => '2025-03-01 16:00:00',
                'clockout_dttm' => '2025-03-02 02:25:00'
            ],

        ];

        for($i = 1; $i <= 27; $i++){

            $scenario_random = [];
            $scenario_random[] = $scenario[array_rand($scenario)];
            //print_r($scenario_random); exit();

            foreach($scenario_random as $a => $b){
                $title = $b['title'];
                $clockin_dttm = $this->far_date->add_days($i,$b['clockin_dttm']);
                $clockout_dttm = $this->far_date->add_days($i,$b['clockout_dttm']);

                $calculate_shift_date = $this->far_attendance->calculate_shift_date($clockin_dttm);

                $this->db->insert('attendance_detail', [
                    'uacc_id' => 2178,
                    'shift_date' => $this->far_date->convert_format($clockin_dttm, "Y-m-d"),
                    'shift_start_dttm' => $calculate_shift_date['shift_start_dttm'],
                    'shift_end_dttm' => $calculate_shift_date['shift_end_dttm'],
                    'clockin_dttm' => $clockin_dttm,
                    'clockout_dttm' => $clockout_dttm
                ]);
                $attendance_id = $this->db->insert_id();
                $this->far_attendance->start_clockout($attendance_id, $clockout_dttm);

                $calculated = $this->far_attendance->calculate_working_hour($clockin_dttm, $clockout_dttm);
                $calculated['title'] = $b['title'];
                $scenario[$a] = $calculated;

                echo $title; echo "<br>";


                echo "<pre>"; print_r($scenario); echo "</pre>";
                echo "<hr>";

            }
        }



        $this->data['scenario'] = $scenario;
        $this->load->view('please_delete/calculate_working_hour', $this->data);


    }

    function test_scenario_old(){

        echo '<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Courier+Prime:ital,wght@0,400;0,700;1,400;1,700&family=Noto+Sans+Symbols:wght@100..900&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
<style>
body {
  font-family: "Courier Prime", monospace;
}
pre {
font-family: "Courier Prime", monospace;
}
</style>
';
        /*
        $scenario = [
            'scenario_1' => [
                'title' => "Clockin before 4PM<br>Clockout before 4PM",
                'clockin_dttm' => '2025-03-01 09:00:00',
                'clockout_dttm' => '2025-03-01 14:25:00'
            ],
            'scenario_2' => [
                'title' => "Clockin before 4PM<br>Clockout after 4PM, but before 12AM",
                'clockin_dttm' => '2025-03-01 15:00:00',
                'clockout_dttm' => '2025-03-01 17:25:00'
            ],
            'scenario_3' => [
                'title' => "Clockin before 4PM<br>Clockout after 4PM, and before 12AM",
                'clockin_dttm' => '2025-03-01 14:00:00',
                'clockout_dttm' => '2025-03-01 22:25:00'
            ],
            'scenario_4' => [
                'title' => "Clockin before 4PM<br>Clockout after 12PM, and before 2AM",
                'clockin_dttm' => '2025-03-01 15:00:00',
                'clockout_dttm' => '2025-03-02 01:25:00'
            ],
            'scenario_5' => [
                'title' => "Clockin after 4PM<br>Clockout before 12PM",
                'clockin_dttm' => '2025-03-01 16:05:00',
                'clockout_dttm' => '2025-03-01 23:25:00'
            ],
            'scenario_7' => [
                'title' => "Clockin after 4PM<br>Clockout after 12PM, but before 1AM",
                'clockin_dttm' => '2025-03-01 16:00:00',
                'clockout_dttm' => '2025-03-02 00:25:00'
            ],
            'scenario_8' => [
                'title' => "Clockin after 4PM<br>Clockout after 12PM, but before 2AM",
                'clockin_dttm' => '2025-03-01 16:00:00',
                'clockout_dttm' => '2025-03-02 01:25:00'
            ],
            'scenario_9' => [
                'title' => "Clockin after 4PM<br>Clockout after 12PM, but after 2AM",
                'clockin_dttm' => '2025-03-01 16:00:00',
                'clockout_dttm' => '2025-03-02 02:25:00'
            ],

        ];

        $scenario = [
            'scenario91' => [
                'title' => "Clockin work early 15 mins",
                'clockin_dttm' => '2025-03-01 15:32:00',
                'clockout_dttm' => '2025-03-01 02:25:00'
            ]
        ];
        */

        $query = $this->db->query("SELECT * FROM attendance_scenario ORDER BY attendance_scenario_id ASC");
        if($query->num_rows() > 0){
            foreach($query->result_array() as $a => $b){
                $scenario['scenario_'.($a+11)] = [
                    'title' => "Scenario ".($a+1),
                    'clockin_dttm' => $b['clockin_dttm'],
                    'clockout_dttm' => $b['clockout_dttm'],
                    'database' => "yes",
                    'attendance_scenario_id' => $b['attendance_scenario_id']
                ];
            }
        }

        /*
        foreach($scenario as $a => $b){
            echo $b['title']."<br>";
            echo "Clock-In &nbsp;: ".$b['clockin_dttm']."<br>";
            echo "Clock-Out : ".$b['clockout_dttm']."<br>";

            $processed = $this->far_attendance->process_clockout($b['clockin_dttm'], $b['clockout_dttm']);
            echo "<pre>"; print_r($processed); echo "</pre>";

            echo "<hr>";

        }
        */


        foreach($scenario as $a => $b){


            $processed = $this->far_attendance->process_clockout_latest($b['clockin_dttm'], $b['clockout_dttm']);
            $scenario[$a]['processed'] = $processed;

        }

        $this->data['scenario'] = $scenario;


        $this->load->view('please_delete/test_scenario', $this->data);

    }
    function test_scenario(){

        echo '<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Courier+Prime:ital,wght@0,400;0,700;1,400;1,700&family=Noto+Sans+Symbols:wght@100..900&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
<style>
body {
  font-family: "Courier Prime", monospace;
}
pre {
font-family: "Courier Prime", monospace;
}
</style>
';
        /*
        $scenario = [
            'scenario_1' => [
                'title' => "Clockin before 4PM<br>Clockout before 4PM",
                'clockin_dttm' => '2025-03-01 09:00:00',
                'clockout_dttm' => '2025-03-01 14:25:00'
            ],
            'scenario_2' => [
                'title' => "Clockin before 4PM<br>Clockout after 4PM, but before 12AM",
                'clockin_dttm' => '2025-03-01 15:00:00',
                'clockout_dttm' => '2025-03-01 17:25:00'
            ],
            'scenario_3' => [
                'title' => "Clockin before 4PM<br>Clockout after 4PM, and before 12AM",
                'clockin_dttm' => '2025-03-01 14:00:00',
                'clockout_dttm' => '2025-03-01 22:25:00'
            ],
            'scenario_4' => [
                'title' => "Clockin before 4PM<br>Clockout after 12PM, and before 2AM",
                'clockin_dttm' => '2025-03-01 15:00:00',
                'clockout_dttm' => '2025-03-02 01:25:00'
            ],
            'scenario_5' => [
                'title' => "Clockin after 4PM<br>Clockout before 12PM",
                'clockin_dttm' => '2025-03-01 16:05:00',
                'clockout_dttm' => '2025-03-01 23:25:00'
            ],
            'scenario_7' => [
                'title' => "Clockin after 4PM<br>Clockout after 12PM, but before 1AM",
                'clockin_dttm' => '2025-03-01 16:00:00',
                'clockout_dttm' => '2025-03-02 00:25:00'
            ],
            'scenario_8' => [
                'title' => "Clockin after 4PM<br>Clockout after 12PM, but before 2AM",
                'clockin_dttm' => '2025-03-01 16:00:00',
                'clockout_dttm' => '2025-03-02 01:25:00'
            ],
            'scenario_9' => [
                'title' => "Clockin after 4PM<br>Clockout after 12PM, but after 2AM",
                'clockin_dttm' => '2025-03-01 16:00:00',
                'clockout_dttm' => '2025-03-02 02:25:00'
            ],

        ];
        */
        $scenario['scenario_91'] = [
            'title' => "Clockin after 4PM<br>Clockout after 12PM, but after 2AM",
            'clockin_dttm' => '2025-03-01 16:00:00',
            'clockout_dttm' => '2025-03-02 02:25:00'
        ];


        $query = $this->db->query("SELECT * FROM attendance_scenario ORDER BY attendance_scenario_id ASC");
        if($query->num_rows() > 0){
            foreach($query->result_array() as $a => $b){
                $scenario['scenario_'.($a+11)] = [
                    'title' => "Scenario ".($a+1),
                    'clockin_dttm' => $b['clockin_dttm'],
                    'clockout_dttm' => $b['clockout_dttm'],
                    'database' => "yes",
                    'attendance_scenario_id' => $b['attendance_scenario_id']
                ];
            }
        }

        /*
        foreach($scenario as $a => $b){
            echo $b['title']."<br>";
            echo "Clock-In &nbsp;: ".$b['clockin_dttm']."<br>";
            echo "Clock-Out : ".$b['clockout_dttm']."<br>";

            $processed = $this->far_attendance->process_clockout($b['clockin_dttm'], $b['clockout_dttm']);
            echo "<pre>"; print_r($processed); echo "</pre>";

            echo "<hr>";

        }
        */


        foreach($scenario as $a => $b){


            $processed = $this->far_attendance->process_clockout_latest($b['clockin_dttm'], $b['clockout_dttm']);
            $scenario[$a]['processed'] = $processed;

        }

        $this->data['scenario'] = $scenario;

        //echo "<pre>"; print_r($scenario); exit();


        $this->load->view('please_delete/test_scenario', $this->data);

    }

    function update_far_meta(){
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();

        if(!$postdata['prep_minimum_minutes_to_mark_as_eligible']){
            $error['prep_minimum_minutes_to_mark_as_eligible'] = "Please check prep_minimum_minutes_to_mark_as_eligible";
        }
        if(!$postdata['ot_minimum_minutes_to_mark_as_eligible']){
            $error['ot_minimum_minutes_to_mark_as_eligible'] = "Please check ot_minimum_minutes_to_mark_as_eligible";
        }

        if(count($error) == 0){

            $this->far_meta->update_value('prep_minimum_minutes_to_mark_as_eligible', $postdata['prep_minimum_minutes_to_mark_as_eligible']);
            $this->far_meta->update_value('ot_minimum_minutes_to_mark_as_eligible', $postdata['ot_minimum_minutes_to_mark_as_eligible']);

            $output['status'] = 'success';
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }
    function add_new_scenario(){
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();


        if(count($error) == 0){
            $clockin_dttm = $postdata['new_clockin_date']." ".$postdata['new_clockin_time'];
            $clockout_dttm = $postdata['new_clockout_date']." ".$postdata['new_clockout_time'];
            $this->db->insert('attendance_scenario', ['title' => "", 'clockin_dttm' => $clockin_dttm, 'clockout_dttm' => $clockout_dttm]);

            $output['status'] = 'success';
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }

    function delete_scenario(){
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();


        if(count($error) == 0){
            $this->db->delete('attendance_scenario', array('attendance_scenario_id' => $postdata['attendance_scenario_id']));

            $output['status'] = 'success';
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }
}