<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//$this->CI->db->escape_str()
class Far_meta {
    private $CI;
    public function __construct(){
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
        $this->CI->load->library('session');
        $this->CI->load->database();
    }
    
    public function get_value($meta){
        $query = $this->CI->db->query('SELECT value FROM far_meta WHERE meta="'.$meta.'" LIMIT 1');
        $value = $query->row()->value;
        
        //replace text
        $mask_text = array("{base_url}", "vegetables", "fiber");
        $replacement_text   = array(base_url(), "beer", "ice cream");
        
        $newvalue = str_replace($mask_text, $replacement_text, $value);
        
        return $newvalue;
    }
    
    public function update_value($meta, $value){
        
        //check is meta available
        $query2 = $this->CI->db->query('SELECT * FROM far_meta WHERE meta="'.$this->CI->db->escape_str($meta).'"');
        $numrow = $query2->num_rows();
        
        //if not available, create meta
        if($numrow == 0){
            $dataInsert = array(
               'meta' => $this->CI->db->escape_str($meta),
               'value' => $this->CI->db->escape_str($value)
            );
            $this->CI->db->insert('far_meta', $dataInsert); 
        }else{
            $data = array(
                'value' => $this->CI->db->escape_str($value)
            );
    
            $this->CI->db->where('meta', $meta);
            $this->CI->db->update('far_meta', $data);
        }
        
         
    }
    
    /**
     * List all meta. return array
     * @param string $meta
     * @param string $type full_array,single_array
     */
    public function get_values($meta, $type = 'full_array'){

        $rows = array();
        $output = array();
        $query = $this->CI->db->query('SELECT * FROM far_meta WHERE meta="'.$meta.'"');
        $rows = $query->result_array();

        if($type == 'array'){
            $output = $rows;
        }elseif($type == 'single_array'){
            foreach($rows as $a => $b){
                $output[] = $b['value'];
            }
        }elseif($type == 'full_array'){

        }
        
        
        return $output;
    }

    function values_array($meta){
        $values = [];
        $query = $this->CI->db->query('SELECT * FROM far_meta WHERE meta="'.$meta.'"');
        if($query->num_rows() > 0){
            $value = $query->row()->value;
            $x = explode(",", $value);
            foreach($x as $a => $b){
                $values[] = ltrim($b);
            }
        }
        return $values;
    }

	
    public function meta_list(){
        $query = $this->CI->db->query('SELECT * FROM far_meta');
        $rows = $query->result_array();
        return $rows;
    }

	
}

?>