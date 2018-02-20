<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	var $UPLOAD_PATH = 'upload/';
	var $GOAL_TYPE = 2;
	var $COURSE_TYPE = 1;
	var $MODULE_TYPE = 0;
	var $USER_TYPE = 3;
	
	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper(array('form', 'url'));
		$this->load->model('admin_model','model',TRUE);
	}

	public function index() {
		$this->load->view('login');
	}
	
	public function signIn() {
		$mail = $this->input->post('mail');
		$password = $this->input->post('password');
		
		if ($this->model->signIn($mail, md5($password))) {
			$user = array('mail'=>$mail, 'password'=>$password);
			$this->session->set_userdata('user',$user);
			
			echo json_encode(array('stat'=>1, 'msg'=>'ok.', 'url'=>base_url().'index.php/admin/goalView'));
			exit();
		} 
		
		echo json_encode(array('stat'=>0, 'msg'=>'Not registered user.', 'url'=>''));
	}
	
	public function signOut() {
		$this->session->unset_userdata('user');
		header("Location: " . base_url());
	}
	
	public function goalView() { 
		if (!isset($this->session->userdata['user']))
			header("Location: " . base_url());
			
		$data['menu'] = "goal"; 
		$this->load->view('goal', $data); 
	}
	
	public function getGoalList() {
		if (!isset($this->session->userdata['user']))
			header("Location: " . base_url());
			
		$data = $this->model->getGoalList();
		$files = $this->model->getUploadFileList($this->GOAL_TYPE);
		
		echo json_encode(array('data'=>$data, 'files'=>$files));
	}
	
	public function getGoalItems() {
		if (!isset($this->session->userdata['user']))
			header("Location: " . base_url());
			
		echo json_encode(array('options'=>$this->model->getGoalItems()));
	}
	
	public function setGoal() {
		if (!isset($this->session->userdata['user']))
			header("Location: " . base_url());
			
		$action = $this->input->get_post('action');
		$id = '';
		$name = '';
		$icon = '';
		
		$result = array();
		
		if ($action == 'create') {
			$name = $this->input->get_post('data[0][name]');
			$icon = $this->input->get_post('data[0][icon]');
			
			$this->model->createGoal($name, $icon);
			$result['data'] = $this->model->getGoalDetail($this->model->getLastIDFromTB('category'));
		}
		
		if ($action == 'edit') {
			$post_val = '';
			foreach ( $_POST as $key => $value ) {
				$post_val = $value;
			}
			
			$id = key($post_val);
			
			$sub_val = $post_val[$id];
			
			$name        = $sub_val['name'];
			$icon    = $sub_val['icon'];
			
			$this->model->updateGoal($id, $name, $icon);
			
			$result['data'] = $this->model->getGoalDetail($id);
		}

		if ($action == 'remove') {
			$post_val = array();
			foreach ( $_POST as $key => $value ) {
				$post_val = $value;
			}
			
			foreach ($post_val as $item) {
				$id = $item['DT_RowId'];
				$this->model->deleteGoal($id);
			}
			
		}

		if ($action == 'upload') {
			$file_name = time();
			$file_ext = pathinfo($_FILES['upload']['name'], PATHINFO_EXTENSION);
			$full_name = $file_name . '.' . $file_ext;
			
			$upload_file = $_FILES['upload']['tmp_name'];
			$target_file = $this->UPLOAD_PATH . $full_name;
			
			if (move_uploaded_file($upload_file, $target_file)) {
				$full_path = base_url().$target_file;
				$file = array('id'=>$file_name, 'filename'=>$full_name, 'filesize'=>'', 'web_path'=>$target_file, 'system_path'=>'');
				$files = array($file_name => $file);
				$files_1 = array('files' => $files);
				$files_2 = array('files' => $files_1);
				
				$result['data'] = array();
				$result['files'] = $files_1;
				$result['upload'] = array('id' => $file_name);
				
				$this->model->setUploadFile($file_name, $full_path, $this->GOAL_TYPE);
			} else {
				$result['fieldErrors'] = array('name'=>'audio', 'status'=>'File can not upload.');
				$result['data'] = array();
			}
		}
		
		echo json_encode($result);
	}

	public function courseView() { 
		if (!isset($this->session->userdata['user']))
			header("Location: " . base_url());
			
		$data['menu'] = "course"; 
		$this->load->view('course', $data); 
	}
	
	public function getCourseList() {
		if (!isset($this->session->userdata['user']))
			header("Location: " . base_url());
			
		$data = $this->model->getCourseList();
		$files = $this->model->getUploadFileList($this->COURSE_TYPE);
		
		echo json_encode(array('data'=>$data, 'files'=>$files));
	}
	
	public function getCourseItems() {
		if (!isset($this->session->userdata['user']))
			header("Location: " . base_url());
			
		echo json_encode(array('options'=>$this->model->getCourseItems()));
	}

	public function setCourse() {
		if (!isset($this->session->userdata['user']))
			header("Location: " . base_url());
			
		$action = $this->input->get_post('action');
		$id = '';
		$gid = '';
		$name = '';
		$description = '';
		$icon = '';
		
		$result = array();
		
		if ($action == 'create') {
			$gid = $this->input->get_post('data[0][goal_id]');
			$name = $this->input->get_post('data[0][name]');
			$description = $this->input->get_post('data[0][description]');
			$icon = $this->input->get_post('data[0][icon]');
			
			$this->model->createCourse($gid, $name, $description, $icon);
			$result['data'] = $this->model->getCourseDetail($this->model->getLastIDFromTB('course'));
		}
		
		if ($action == 'edit') {
			$post_val = '';
			foreach ( $_POST as $key => $value ) {
				$post_val = $value;
			}
			
			$id = key($post_val);
			
			$sub_val = $post_val[$id];
			
			$gid 	     = $sub_val['goal_id'];
			$name        = $sub_val['name'];
			$description = $sub_val['description'];
			$icon 	     = $sub_val['icon'];
			
			$this->model->updateCourse($id, $gid, $name, $description, $icon);
			
			$result['data'] = $this->model->getCourseDetail($id);
		}

		if ($action == 'remove') {
			$post_val = array();
			foreach ( $_POST as $key => $value ) {
				$post_val = $value;
			}
			
			foreach ($post_val as $item) {
				$id = $item['DT_RowId'];
				$this->model->deleteCourse($id);
			}
			
		}

		if ($action == 'upload') {
			$file_name = time();
			$file_ext = pathinfo($_FILES['upload']['name'], PATHINFO_EXTENSION);
			$full_name = $file_name . '.' . $file_ext;
			
			$upload_file = $_FILES['upload']['tmp_name'];
			$target_file = $this->UPLOAD_PATH . $full_name;
			
			if (move_uploaded_file($upload_file, $target_file)) {
				$full_path = base_url().$target_file;
				$file = array('id'=>$file_name, 'filename'=>$full_name, 'filesize'=>'', 'web_path'=>$target_file, 'system_path'=>'');
				$files = array($file_name => $file);
				$files_1 = array('files' => $files);
				$files_2 = array('files' => $files_1);
				
				$result['data'] = array();
				$result['files'] = $files_1;
				$result['upload'] = array('id' => $file_name);
				
				$this->model->setUploadFile($file_name, $full_path, $this->COURSE_TYPE);
			} else {
				$result['fieldErrors'] = array('name'=>'audio', 'status'=>'File can not upload.');
				$result['data'] = array();
			}
		}
		
		echo json_encode($result);
	}
	
	public function moduleView() { 
		if (!isset($this->session->userdata['user']))
			header("Location: " . base_url());
			
		$data['menu'] = "module"; 
		$this->load->view('module', $data); 
	}
	
	public function getModuleList() {
		if (!isset($this->session->userdata['user']))
			header("Location: " . base_url());
			
		$data = $this->model->getModuleList();
		$files = $this->model->getUploadFileList($this->MODULE_TYPE);
		
		echo json_encode(array('data'=>$data, 'files'=>$files));
	}
	
	public function setModule() {
		if (!isset($this->session->userdata['user']))
			header("Location: " . base_url());
			
		$action = $this->input->get_post('action');
		$id = '';
		$cid = '';
		$name = '';
		$description = '';
		$audio = '';
		$duration = '';
		
		$result = array();
		
		if ($action == 'create') {
			$cid = $this->input->get_post('data[0][course_id]');
			$name = $this->input->get_post('data[0][name]');
			$description = $this->input->get_post('data[0][description]');
			$audio = $this->input->get_post('data[0][audio]');
			$duration = $this->input->get_post('data[0][duration]');
			
			$this->model->createModule($cid, $name, $description, $duration, $audio);
			$result['data'] = $this->model->getModuleDetail($this->model->getLastIDFromTB('module'));
		}
		
		if ($action == 'edit') {
			$post_val = '';
			foreach ( $_POST as $key => $value ) {
				$post_val = $value;
			}
			
			$id = key($post_val);
			
			$sub_val = $post_val[$id];
			
			$cid 	     = $sub_val['course_id'];
			$name        = $sub_val['name'];
			$description = $sub_val['description'];
			$audio 	     = $sub_val['audio'];
			$duration    = $sub_val['duration'];
			
			$this->model->updateModule($id, $cid, $name, $description, $duration, $audio);
			
			$result['data'] = $this->model->getModuleDetail($id);
		}

		if ($action == 'remove') {
			$post_val = array();
			foreach ( $_POST as $key => $value ) {
				$post_val = $value;
			}
			
			foreach ($post_val as $item) {
				$id = $item['DT_RowId'];
				$this->model->deleteModule($id);
			}
			
		}

		if ($action == 'upload') {
			$file_name = time();
			$file_ext = pathinfo($_FILES['upload']['name'], PATHINFO_EXTENSION);
			$full_name = $file_name . '.' . $file_ext;
			
			$upload_file = $_FILES['upload']['tmp_name'];
			$target_file = $this->UPLOAD_PATH . $full_name;
			
			if (move_uploaded_file($upload_file, $target_file)) {
				$full_path = base_url().$target_file;
				$file = array('id'=>$file_name, 'filename'=>$full_name, 'filesize'=>'', 'web_path'=>$target_file, 'system_path'=>'');
				$files = array($file_name => $file);
				$files_1 = array('files' => $files);
				$files_2 = array('files' => $files_1);
				
				$result['data'] = array();
				$result['files'] = $files_1;
				$result['upload'] = array('id' => $file_name);
				
				$this->model->setUploadFile($file_name, $full_path, $this->MODULE_TYPE);
			} else {
				$result['fieldErrors'] = array('name'=>'audio', 'status'=>'File can not upload.');
				$result['data'] = array();
			}
		}
		
		echo json_encode($result);
	}
	
	public function userView() { 
		if (!isset($this->session->userdata['user']))
			header("Location: " . base_url());
		$data['menu'] = "user"; 
		$this->load->view('user', $data); 
	}
	
	public function getUserList() {
		if (!isset($this->session->userdata['user']))
			header("Location: " . base_url());
			
		$data = $this->model->getUserList();
		$files = $this->model->getUploadFileList($this->USER_TYPE);
		
		echo json_encode(array('data'=>$data, 'files'=>$files));
	}
	
	public function isExistMail() {
		if (!isset($this->session->userdata['user']))
			header("Location: " . base_url());
			
		$mail = $this->input->get_post('mail');
		
		$result = array();
		
		if ($this->model->isExistMail($mail)) {
			$result = array('state'=>1, 'msg'=>'The mail insert already.');
		} else {
			$result = array('state'=>0, 'msg'=>'');
		}
		
		echo json_encode($result);
	}
	
	public function setUser() {
		if (!isset($this->session->userdata['user']))
			header("Location: " . base_url());
			
		$action = $this->input->get_post('action');
		$id = '';
		$first_name = '';
		$last_name = '';
		$mail = '';
		$password = '';
		$description = '';
		$banner = '';
		$photo = '';
		
		$result = array();
		
		if ($action == 'create') {
			$first_name = $this->input->get_post('data[0][first_name]');
			$last_name = $this->input->get_post('data[0][last_name]');
			$mail = $this->input->get_post('data[0][mail]');
			$password = $this->input->get_post('data[0][password]');
			$description = $this->input->get_post('data[0][description]');
			$banner = $this->input->get_post('data[0][banner]');
			$photo = $this->input->get_post('data[0][photo]');
			
			$this->model->createUser($first_name, $last_name, $mail, $password, $description, $banner, $photo);
			$result['data'] = $this->model->getUserDetail($this->model->getLastIDFromTB('user'));
		}
		
		if ($action == 'edit') {
			$post_val = '';
			foreach ( $_POST as $key => $value ) {
				$post_val = $value;
			}
			
			$id = key($post_val);
			
			$sub_val = $post_val[$id];
			
			$first_name = $sub_val['first_name'];
			$last_name = $sub_val['last_name'];
			$mail = $sub_val['mail'];
			$description = $sub_val['description'];
			$banner = $sub_val['banner'];
			$photo = $sub_val['photo'];
			
			$this->model->updateUser($id, $first_name, $last_name, $mail, $description, $banner, $photo);
			
			$result['data'] = $this->model->getUserDetail($id);
		}

		if ($action == 'remove') {
			$post_val = array();
			foreach ( $_POST as $key => $value ) {
				$post_val = $value;
			}
			
			foreach ($post_val as $item) {
				$id = $item['DT_RowId'];
				$this->model->deleteUser($id);
			}
			
		}

		if ($action == 'upload') {
			$file_name = time();
			$file_ext = pathinfo($_FILES['upload']['name'], PATHINFO_EXTENSION);
			$full_name = $file_name . '.' . $file_ext;
			
			$upload_file = $_FILES['upload']['tmp_name'];
			$target_file = $this->UPLOAD_PATH . $full_name;
			
			if (move_uploaded_file($upload_file, $target_file)) {
				$full_path = base_url().$target_file;
				$file = array('id'=>$file_name, 'filename'=>$full_name, 'filesize'=>'', 'web_path'=>$target_file, 'system_path'=>'');
				$files = array($file_name => $file);
				$files_1 = array('files' => $files);
				$files_2 = array('files' => $files_1);
				
				$result['data'] = array();
				$result['files'] = $files_1;
				$result['upload'] = array('id' => $file_name);
				
				$this->model->setUploadFile($file_name, $full_path, $this->USER_TYPE);
			} else {
				$result['fieldErrors'] = array('name'=>'audio', 'status'=>'File can not upload.');
				$result['data'] = array();
			}
		}
		
		echo json_encode($result);
	}
	
	public function adminView() { 
		if (!isset($this->session->userdata['user']))
			header("Location: " . base_url());
			
		$data['menu'] = "admin"; 
		$data['msg'] = "";
		$data['info'] = $this->model->getAdminDetail($this->model->getAdminID());
		$this->load->view('admin', $data); 
	}
	
	public function setAdminInfo() {
		if (!isset($this->session->userdata['user']))
			header("Location: " . base_url());
			
		$first_name = $this->input->get_post('first_name');
		$last_name = $this->input->get_post('last_name');
		$mail = $this->input->get_post('mail');
		$description = $this->input->get_post('description');
		$id = $this->model->getAdminID();
		
		$this->model->setAdminInfo($id, $first_name, $last_name, $mail, $description);
	}
	
	public function setPassword() {
		if (!isset($this->session->userdata['user']))
			header("Location: " . base_url());
			
		$old_pwd = $this->input->get_post('old_password');
		$new_pwd = $this->input->get_post('new_password');
		$id = $this->model->getAdminID();
		
		$result = array();
		
		if ($this->model->checkPassword($id, md5($old_pwd))) {
			$this->model->setPassword($id, md5($new_pwd));
			$result = array('stat'=>1, 'msg'=>'ok.', 'url'=>base_url().'admin/adminView');
		} else {
			//$result = array('stat'=>0, 'msg'=>'Please input old password correctly.', 'url'=>'');
			$result = array('stat'=>0, 'msg'=>$old_pwd, 'url'=>'');
		}
		
		echo json_encode($result); 
	}
	
	public function setPhoto() {
		if (!isset($this->session->userdata['user']))
			header("Location: " . base_url());
			
		$photo = $this->input->get_post('photo');
		$id = $this->model->getAdminID();
		
		$this->model->setPhoto($id, $photo);
	}
}
