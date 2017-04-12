<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Test extends MX_Controller {
    private $CI;

    function __construct() {
        $this->CI = &get_instance();
        $this->table = 'tbl_user';
        $this->load->database();
    }

    // Show view Page
    public function index() {        
        /*$data['result'] = $this->db->select('id,firstname,lastname,email')
                                   ->from($this->table)
                                   ->get()
                                   ->result_array(); */
        $this->load->view("test_view");         
    }

    // This function call from AJAX
    public function user_data_submit() {   
        $data = array();
        if(empty($_POST)) {
            echo json_encode(array('message'=>'please enter all the fields'));           
        } else {
            $data = array(
                    'firstname' => $this->input->post('firstname'),
                    'lastname'=>$this->input->post('lastname'),
                    'email'=>$this->input->post('email')
                );
            if(!empty($_POST['id'])) {
                //check edit mode                
                $id =  $_POST['id'];
                //Either you can print value or you can send value to database
                $unique_check = $this->db->select('id')
                                     ->from($this->table)
                                     ->where(array('email'=>$data['email'],'id!='=>$id))
                                     ->get()
                                     ->num_rows();                 
            
                //Already exist email check
                if($unique_check == 0) {
                    $this->db->update($this->table,$data,array('id'=>$id));                                 
                } else {
                   echo json_encode(array('message'=>'Email already exists.'));                      
                }            
            } else {              

                //Either you can print value or you can send value to database
                $unique_check = $this->db->select('id')
                                     ->from($this->table)
                                     ->where(array('email'=>$data['email']))
                                     ->get()
                                     ->num_rows();                 
            
                //Already exist email check
                if($unique_check == 0) {
                    $this->db->insert($this->table,$data);                                         
                } else {
                   echo json_encode(array('message'=>'please enter unique value for email'));                      
                }
            }        
        }
    }

    public function update_row_data() { 
        $result = $this->db->select('*')
                 ->from($this->table)
                 ->get()
                 ->first_row();
        print_r(json_encode($result));        
    }

    public function delete_row_data(){
        $id = $_POST['id'];
        $result = $this->db->delete($this->table,array('id'=>$id));        
    }

    public function listing_data() {

        $this->datatables->select('id,firstname,lastname,email')
                                   ->from($this->table);
        print_r($this->datatables->generate());        
    }
}     
?>