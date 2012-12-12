<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * Log in Controller
 * @author Thaddeus Abraham Along and Paul Edmund Janubas
 * @version 1.0.0
 * 
 *
 */

class Login extends CI_Controller {

	private $_mUser;	//declared a private variable


	public function __construct() {
		parent::__construct();

		$this->_mUser = NULL;	//initialized private variable


	}

	/* Deo Module */
	public function index(){   //the login_view
		
		$data['main_content'] = 'admin/login_view/login_view';  //loads the login view
		$this->load->view('includes/template', $data);	//inserts the default templates for the html
	}
	
	
	public function login_validate(){    //validates that all fields have been filled-up
		
		$this->form_validation->set_rules('login_username','Username', 'required|callback_username_check');   //set rules for username 
		$this->form_validation->set_rules('login_password', 'Password', 'required');    //set rules for password
	
		if($this->form_validation->run() == FALSE){     //if form in fields are incomplete, returns you to login_view
	
			$this->form_validation->set_message('is_email_exist', 'The %s does not exist in the database');
			$this->index();    //the login_view
	
		} else {
			
		if($this->_is_email_exist()) {  //result will depend on what the function will return, TRUe or FALSE
			
				foreach($this->_mUser as $rec) {    //this will fetch values from DB ang put into container
					$currUser['uname'] = $rec->mboos_user_username; //the username existing in the DB will be put in "uname" container
					$currUser['ulvl'] = $rec->mboos_user_cat_id; 
					$currUser['uid'] = $rec->mboos_user_id;
				}
				
				$params = array(   //this is a session
								'sadmin_uname' => $currUser['uname'],   //put the values of the container into another container
								'sadmin_islogin' => TRUE,	
								'sadmin_ulvl' => $currUser['ulvl'],
								'sadmin_uid' => $currUser['uid']
							);
							
				$this->sessionbrowser->setInfo($params);    //sets the values of the container into the sessionbrowser
				redirect('admin/dashboard'); //redirects to the dashboard controller
					
			} else {
				redirect ('admin/login'); //this will redirect you to the login page
			} 			
		} 
	} 
	
	
	public function logout() { //destroys the temporarily used information from the database
			
			$params = array('sadmin_uname', 'sadmin_islogin', 'sadmin_ulvl'); //gets the values of the form and into a container
			
			$this->sessionbrowser->destroy($params); //destroys the values of the container for logout security
			redirect('admin/login');
		}
		
		
	public function username_check($str) { //checks the username if it exists in the DB, if not returns a error message
		
		$params['table'] = array('name' => 'mboos_users', 'criteria_phrase'=> 'mboos_user_username= "' . $str . '"');
		
			$this->mdldata->select($params);

			if($this->mdldata->_mRowCount < 1) {
				$this->form_validation->set_message('username_check', 'This %s  does not exist.');
				return FALSE;
				
				} else {
					echo 'this username is valid.';
					return TRUE;
					}
		}
	
	
	private function _is_email_exist() {	//compare entered fields if existing or not to dummy database
		
		$params['table'] = array('name' => 'mboos_users', 'criteria_phrase' => 'mboos_user_username= "' . $this->input->post('login_username'). '" and mboos_user_password="' . md5($this->input->post('login_password')) .  '" and mboos_user_status="1"');
			//queries the values of username and password form the database
		
		$this->mdldata->select($params);   //selects the queried values from the DB
		
		
		if($this->mdldata->_mRowCount < 1)  //if a username or email exist already in the DB, this will return false therefore invalid
			return FALSE;
		
		$this->_mUser = $this->mdldata->_mRecords;   //if all values are valid, meaning there are no duplicates, it will return TRUE	
		return TRUE;
	} 
	

	/*Deo End Module*/

	/* Paul Module */

	public function forgot_password() { //function to redirect to enter_email_view

		$data['main_content'] = 'admin/forgot_password_view/enter_email_view'; //redirect to this url: admin/forgot_password_view/enter_email_view
		$this->load->view('includes/template', $data); // loads template for html
	}

	public function forgotpass_email_validate() { 	//request for email address

		$ad_email = $this->input->post('email'); // post from enter_email_view

		$this->load->library('form_validation'); // loads form_validation from library
		$validation = $this->form_validation;	// initializes form_validation

		$validation->set_rules('email', 'Email Address', 'required'); // setting validation rules

		if($validation->run() === FALSE) { // redirect to forgot_password if false, otherwise check _isExists() function
			redirect ('admin/login/forgot_password'); // redirect to admin/login/forgot_password
		} else {
			if($this->_isExists()) { // check if email inputed exists

				$params['querystring'] = 'SELECT mboos_users.mboos_user_secret_question FROM mboos_users WHERE mboos_user_email = "' . $this->input->post('email') . '"'; //query from database
				$this->mdldata->select($params); //selects the queried values from the DB
				$data['my_question'] = $this->mdldata->_mRecords; //$data initializes container 'my_question' to be loaded on enter_secret_question_view

				$data['main_content'] = 'admin/forgot_password_view/enter_secretquestion_view'; //redirect to this url: admin/forgot_password_view/enter_secretquestion_view
				$this->load->view('includes/template', $data); // load templates in html
			} else {
				redirect ('admin/login/forgot_password'); // redirect to this url: admin/login/forgot_password 
			}
		}
	}
	
	public function _isExists() { //check if email exist

		$params['table'] = array('name' => 'mboos_users', 'criteria_phrase' => 'mboos_user_email="' . $this->input->post('email') . '"'); // queries mboos_user_email as $this->input->post('email') in the DB

		$this->mdldata->select($params); //selects the queried values from the DB

		if($this->mdldata->_mRowCount < 1) //returns falls if email already exist
			return FALSE;

		$this->_mUser = $this->mdldata->_mRecords; //reutrns true if email is valid and have no duplicates

		return TRUE;
	}

	public function secret_question_validate() { //validate answer for secret question

		$secret_answer = $this->input->post('secret_answer'); //initialize post 'secret_answer' from enter_secretquestion_view
		$admin_email = $this->input->post('email'); //initialize post 'email' enter_secretquestion_view

		$this->load->library('form_validation'); //loads form_validation from library
		$validation = $this->form_validation; //initialize form_validation

		$validation->set_rules('secret_answer', 'Answer', 'required'); // set rules
		if($validation->run() === FALSE) { //returns falls if validation rules are violated
		
			$params['querystring'] = 'SELECT mboos_users.mboos_user_secret_question FROM mboos_users WHERE mboos_user_email = "' . $this->input->post('email') . '"'; // queries mboos_user_secret_question from mboos_users in selected email
			$this->mdldata->select($params); //selects the queried values from the DB
			$data['my_question'] = $this->mdldata->_mRecords; //$data initializes container 'my_question' to be loaded on enter_secret_question_view

			$data['main_content'] = 'admin/forgot_password_view/enter_secretquestion_view';
			$this->load->view('includes/template', $data);
			
		} else {
		
				if($this->_is_answer_exist()) { // check if answer exist

				$this->_setSession(); // set session for pass_track
				$session_id = $this->session->userdata('session_id'); //initialize session userdata
				$params = array( // process to send email
					'sender' => 'mboosCOM@gmail.com',
					'receiver' => $admin_email,
					'from_name' => 'Web Master', // OPTIONAL
					'cc' => '', // OPTIONAL
					'subject' => 'Reset Password', // OPTIONAL
					'msg' => 'Click <a href = "http://localhost/MBOOS/admin/login/reset_password/' . strencode($admin_email) . '/' . $session_id . '">here</a> to reset your password.', // OPTIONAL
					'email_temp_account' => TRUE, // OPTIONAL. Uses your specified google account only. Please see this method "_tmpEmailAccount" below (line 111).
				);

				$this->load->library('emailutil', $params); // loads emailutil from library

				if($this->emailutil->send()){ // send if library is loaded
					echo "message sent";
				}else{
					echo "message not sent"; // does not send if not loaded
					}
				} else {
					echo "Invalid answer!"; // echo invalid if answer is not valid
				}
			}
	}

	private function _setSession() { //set session pass_track

		$params = array('pass_track' => 1); // set pass_track value to 1

		$this->sessionbrowser->setInfo($params); //send value of pass_track to 1 into sessionbrowser
		return TRUE;
	}

	private function _updateSession() {	//set session update pass_track

		$params = array('pass_track' => 0); // set pass_track value to 0

		$this->sessionbrowser->setInfo($params); //send value of pass_track to 0 into session browser
		return TRUE;
	}

	private function _checkSession(){ //check session pass track
		$params = array('pass_track');
		$this->sessionbrowser->getInfo($params); // returns TRUE if successful, otherwise

		$arr = $this->sessionbrowser->mData; // returns array

		if($arr['pass_track'] == 1) //returns true if pass_track value is 1
			return TRUE;

		return FALSE;
		//call_debug($arr);
	}

	public function _is_answer_exist() { //check if secret answer exist

		$params['table'] = array('name' => 'mboos_users', 'criteria_phrase' => 'mboos_user_secret_answer="' . $this->input->post('secret_answer') . '"'); // queries mboos_user_secret_answer from mboos_users

		$this->mdldata->select($params); //selects the queried values from the DB

		if($this->mdldata->_mRowCount < 1) 
			return FALSE;

		$this->_mUser = $this->mdldata->_mRecords;

		return TRUE;
	}

	public function reset_password() { // function to reset password

		if($this->_checkSession()){ // check if session pass_track from dabase is = 1
			
			$this->_updateSession(); // update session pass_track from dabase to 0
			$this->_setSession_reset_pass_track(); // set session for reset_pass_track value to 1

			$data['main_content'] = 'admin/forgot_password_view/reset_password_view'; //load this page
			$this->load->view('includes/template', $data); // load template

		}else{

			$data['main_content'] = 'admin/forgot_password_view/session_expired_view'; // load this page
			$this->load->view('includes/template', $data); // load template
		}
	}

	public function reset_password_validate() { // validate reset password

		$newpass = $this->input->post('new_password'); // initialize post 'new_password' from reset_password_view

		$this->load->library('form_validation'); // load form_validation from library


		$this->form_validation->set_rules('confirm_password', 'Confrim Password', 'required|matches[new_password]'); // set validation rules


		if($this->form_validation->run() == FALSE) { //returns false if validation rules are violated

			$this->load->view('admin/forgot_password_view/reset_password_view'); //load this page

			} else {

				$email = $this->input->post('email'); //initialize post 'email' from reset_password_view
				//call_debug($decode_email);
				if($this->_checkSession_reset_pass_track()){  //check session reset_pass_track
					
					$this->_updateSession_reset_pass_track(); //update reset_pass_track value to 0
					$params = array(
                        'table' => array('name' => 'mboos_users','criteria_phrase' => 'mboos_user_email="' .  strdecode($email) . '"'),
                        'fields' => array('mboos_user_password' => md5($this->input->post('new_password'))));

					$this->mdldata->reset();
					$this->mdldata->update($params);

					$data['main_content'] = 'admin/forgot_password_view/resetpass_success_view';
					$this->load->view('includes/template', $data);

				} else {
				
					$data['main_content'] = 'admin/forgot_password_view/session_expired_view'; //load this page
					$this->load->view('includes/template', $data); //load template
				
				}
	}
	
	}
	private function _setSession_reset_pass_track() { // set session reset_pass_track

		$params = array('reset_pass_track' => 1); //set reset_pass_track value to 1

		$this->sessionbrowser->setInfo($params);
		return TRUE;
	}

	private function _updateSession_reset_pass_track() { //update session reset_pass_track

		$params = array('reset_pass_track' => 0); //set reset_pass_track value to 0

		$this->sessionbrowser->setInfo($params); //send value to sessionbrowser
		return TRUE;
	}

	private function _checkSession_reset_pass_track(){ //check session reset_pass_track
		$params = array('reset_pass_track');
		$this->sessionbrowser->getInfo($params); // returns TRUE if successful, otherwise

		$arr = $this->sessionbrowser->mData; // returns array

		if($arr['reset_pass_track'] == 1) //returns true if reset_pass_track = 1
			return TRUE;

		return FALSE;
		//call_debug($arr);
	}
	/*Paul End Module*/
}