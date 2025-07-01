<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include APPPATH . 'third_party/mpdf/vendor/autoload.php';
class Far_mpdf
{
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
        $this->CI->load->library('session');
        $this->CI->load->database();

    }

    function generate_score_report_meter($score_report_id){
        $score_report_detail = $this->CI->far_score->get_score_report_detail($score_report_id);

        $meter_bar_fullurl = FCPATH.'assets/score_report/score_report_meter_bar.png';

        $meter_bar = @imagecreatefrompng($meter_bar_fullurl);
        $meter_cursor = @imagecreatefrompng(FCPATH.'assets/score_report/score_report_meter_cursor.png');

        $myloan_score = $score_report_detail['income_detail']['initialized']['myloan_score']['formatted'];
        $cursor_calc_step_1 = ($myloan_score/500)*100;

        list($width, $height, $type, $attr) = getimagesize($meter_bar_fullurl);

        $cursor_calc_step_2 = ($cursor_calc_step_1/100)*$width;

        // Copy and merge
        imagecopy($meter_bar, $meter_cursor, $cursor_calc_step_2, 0, 0, 0, 69, 89);

        // Output and free from memory
        //header('Content-Type: image/png');
        imagepng($meter_bar, FCPATH.'assets/score_report/meter/'.$score_report_detail['score_report_code'].'.png');

        imagedestroy($meter_bar);
        imagedestroy($meter_cursor);
    }

    function generate_score_report_pdf($score_report_id, $output = "I"){

        $score_report_detail = $this->CI->far_score->get_score_report_detail($score_report_id);
        $user_detail = $this->CI->far_users->get_user('uacc_id', $score_report_detail['owner_uacc_id']);

        //echo '<pre>'; print_r($score_report_detail['income_detail']['initialized']); exit();

        $this->generate_score_report_meter($score_report_id);

        //echo "<pre>"; print_r($user_detail); exit();
        $mpdf = new \Mpdf\Mpdf();

        // set the sourcefile
        //$mpdf->SetImportUse(); // <--- required for mPDF versions < 8.0
        $mpdf->SetSourceFile(FCPATH.'assets/score_report/score_report_template.pdf'); // absolute path to pdf file

        // import page 1
        $tplIdx = $mpdf->ImportPage(1);

        // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
        $mpdf->UseTemplate($tplIdx);

        //name
        $mpdf->SetTextColor(0, 0, 0);
        $mpdf->SetFont('Arial', 'B', 8);
        //$mpdf->SetXY(80, 256);
        $mpdf->WriteText(40, 60, $user_detail['user_profile']['fullname_as_per_mykad']);
        $mpdf->WriteText(40, 67, $user_detail['user_profile']['nric_number']);
        $mpdf->WriteText(40, 74, $user_detail['user_address'][0]['address_line_1']);
        $mpdf->WriteText(40, 78, $user_detail['user_address'][0]['address_line_2']);
        $mpdf->WriteText(40, 82, $user_detail['user_address'][0]['area_name'].', '.$user_detail['user_address'][0]['post_office'].', '.$user_detail['user_address'][0]['state_code']);

        $init = $score_report_detail['income_detail']['initialized'];

        //Employment type
        $mpdf->WriteText(15, 101, $init['employment_type']['item_text']);
        //Gross Monthly Income
        $mpdf->WriteText(58, 101, 'RM '.$init['monthly_gross_income']['formatted']);
        //Allowance
        $mpdf->WriteText(15, 114, 'RM '.$init['monthly_allowance']['formatted']);
        //Net Monthly Income (After Deduction)
        $mpdf->WriteText(58, 114, 'RM '.$init['monthly_net_income']['formatted']);

        //Higher Purchase
        $mpdf->WriteText(15, 137, 'RM '.$init['monthly_hire_purchase']['formatted']);
        //Mortgage
        $mpdf->WriteText(52, 137, 'RM '.$init['monthly_mortgage']['formatted']);
        //Personal Loan
        $mpdf->WriteText(15, 150, 'RM '.$init['monthly_personal_loan']['formatted']);
        //Credit Card
        $mpdf->WriteText(52, 150, 'RM '.$init['monthly_credit_card']['formatted']);
        //Others
        $mpdf->WriteText(90, 150, 'RM '.$init['monthly_others_outgoing']['formatted']);

        //eligibility
        //Personal Loan
        $mpdf->WriteText(30, 176, 'RM '.$init['ability']['personal_loan']['personal_loan']['formatted']);
        //Housing Loan (Mortgage)
        $mpdf->WriteText(30, 192, 'RM '.$init['ability']['mortgage_loan']['mortgage_loan']['formatted']);
        //Car Loan (Higher Purchase)
        $mpdf->WriteText(30, 208, 'RM '.$init['ability']['car_loan']['car_loan']['formatted']);

        //DSR
        $mpdf->SetFont('Arial', 'B', 16);
        $mpdf->WriteText(140, 185, $init['dsr_used_net']['formatted'].'%');
        $mpdf->WriteText(170, 185, $init['dsr_balance_net']['formatted'].'%');

        //Qrcode
        $mpdf->Image(FCPATH.'assets/score_report/qrcode/'.$score_report_detail['score_report_code'].'.png', 144, 244, 42, 42, 'png', '', true, false);

        //Myloan Score
        $mpdf->Image(FCPATH.'assets/score_report/meter/'.$score_report_detail['score_report_code'].'.png', 140, 103, 52, 8, 'png', '', true, false);

        //Myloan Score Text
        $mpdf->SetFont('Arial', 'B', 10);
        $mpdf->WriteText(139, 128, $init['myloan_score_text']['formatted']);

        //Myloan Score number
        $mpdf->SetFont('Arial', 'B', 30);
        $mpdf->WriteText(168, 128, $init['myloan_score_number']['formatted']);


        //$new_pdf_filename = "CONSENT-LETTER-".$this->CI->far_helper->sanitizeFileName($user_detail['user_profile']['fullname_as_per_mykad']).'.pdf';
        $new_pdf_filename = $score_report_detail['score_report_code'].'.pdf';
        $fullpath_save = FCPATH.'assets/score_report/pdf/';
        $file_fullpath = $fullpath_save.$new_pdf_filename;
        //$mpdf->Output($new_pdf_filename, $output);
        $mpdf->Output($file_fullpath, 'F');
    }

    function generate_consent_letter_pdf($uacc_id, $output = "I"){

        $user_detail = $this->CI->far_users->get_user('uacc_id', $uacc_id);
        $signature_filename_array = explode("/", $user_detail['user_profile']['signature_url']);
        $signature_filename = end($signature_filename_array);
        //echo "<pre>"; print_r($user_detail); exit();
        $mpdf = new \Mpdf\Mpdf();

        // set the sourcefile
        //$mpdf->SetImportUse(); // <--- required for mPDF versions < 8.0
        $mpdf->SetSourceFile(FCPATH.'assets/myloan/consent_template.pdf'); // absolute path to pdf file

        // import page 1
        $tplIdx = $mpdf->ImportPage(1);

        // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
        $mpdf->UseTemplate($tplIdx, 10, 10, 200);

        //signature
        $mpdf->Image(FCPATH.'assets/uploads/signature/'.$signature_filename, 46, 236, 38, 17.4, 'png', '', true, false);

        //name
        $mpdf->SetTextColor(86, 86, 86);
        $mpdf->SetFont('Arial', 'B', 8);
        //$mpdf->SetXY(80, 256);
        $mpdf->WriteText(60, 258, $user_detail['user_profile']['fullname_as_per_mykad']);
        $mpdf->WriteText(60, 264, $user_detail['user_profile']['nric_number']);
        $mpdf->WriteText(60, 269, $user_detail['user_profile']['mobile_number']);
        $mpdf->WriteText(60, 274, $this->CI->far_date->convert_format($user_detail['user_profile']['signature_create_dttm'], 'D, j M y g:i A'));

        $new_pdf_filename = "CONSENT-LETTER-".$this->CI->far_helper->sanitizeFileName($user_detail['user_profile']['fullname_as_per_mykad']).'.pdf';
        $mpdf->Output($new_pdf_filename, $output);
    }
}