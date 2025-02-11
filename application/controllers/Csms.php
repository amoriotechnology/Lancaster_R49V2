<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Csms extends CI_Controller {
	
	public $company_id;
	function __construct() {
        parent::__construct(); 
        $this->db->query('SET SESSION sql_mode = ""');
		$this->load->library('auth');
		$this->auth->check_admin_auth();
		$this->load->library('session');
		$this->load->model('Web_settings');
		
		
    }

  
	#===========Purchase search============#
public function configure()
	{

		$CI = & get_instance();

		$CI->load->model('Web_settings');

		$setting_detail = $CI->Web_settings->retrieve_setting_editdata();

		$data['setting_detail'] = $setting_detail;

		$data['configdata'] = $this->db->select('*')->from('sms_settings')->get()->result_array();
		$data['title'] = 'sms configuration';
		$content = $this->parser->parse('sms/configure_form',$data,true);
		$this->template->full_admin_html_view($content);
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function add_update_configure(){
       
      $id = $this->input->post('id');
		$data=array(
				'api_key' 	  => $this->input->post('api_key',true),
				'api_secret'  => $this->input->post('api_secret',true),
				'from'        => $this->input->post('from',true),
				'isinvoice'   => $this->input->post('isinvoice',true),
				'isservice'   => $this->input->post('isservice',true),
				'isreceive'   => $this->input->post('isreceive',true),

				);

	if(!empty($id)){
           $this->db->where('id', $id);
			$this->db->update('sms_settings',$data);
	}else{
      $this->db->insert('sms_settings',$data);
	}
	$this->session->set_userdata(array('message'=>display('successfully_updated')));
	redirect('Csms/configure');
 }
	
}