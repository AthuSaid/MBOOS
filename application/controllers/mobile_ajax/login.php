<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	

	public function __construct() {
		parent::__construct();

	
	}
	
	public function index() {
		
		if($this->_isExists()) {
			echo "1";
		} else {
			echo "0";
		}
	
	}
	
	public function _isExists() {
	
		$email = $this->input->post('email');
		$pword = md5($this->input->post('pword'));
	
		$string = "mboos_customer_email='" . $email . "' and mboos_customer_pword='". $pword . "' and mboos_customer_status='1'";
	
		$params['table'] = array('name' => 'mboos_customers', 'criteria_phrase' => $string );
	
		$this->mdldata->select($params);
		
	
		if($this->mdldata->_mRowCount < 1)
			return FALSE;
	
		return TRUE;
	}
}

