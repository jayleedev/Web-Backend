<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . 'libraries/Stripe/Stripe.php');

class Mobile extends CI_Controller {

	var $ACTIVITY_COURSE = 0;
	var $ACTIVITY_FRIEND = 1;
	var $ACTIVITY_GROUP = 2;
	
	var $COMMUNITY_CREATE = 0;
	var $COMMUNITY_ACHIEVE = 1;
	
	var $UPLOAD_PATH = 'upload/';
	var $GOAL_TYPE = 2;
	var $COURSE_TYPE = 1;
	var $MODULE_TYPE = 0;
	var $USER_TYPE = 3;

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');

		$this->load->model('mobile_model','model',TRUE);
		$this->load->model('admin_model', 'admin_model',TRUE);
	}
	
	public function index()
	{
		$this->load->view('home');
	}

  
	public function signIn() {
		
		$mail = $this->input->get_post('mail');
		$pwd = $this->input->get_post('pwd');
		
		if ($mail==='' || $pwd==='') {
			echo json_encode(array('stat'=>0, 'msg'=>'signIn error!', 'uid'=>''));
			exit;
		}
		
		if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
			echo json_encode(array('stat'=>0, 'msg'=>'email address is considered invalid!', 'uid'=>''));
			exit;
		}
		
		echo json_encode($this->model->signIn($mail, md5($pwd)));
	}
	
	public function signUp() {
		$mail = $this->input->get_post('mail');
		$pwd = $this->input->get_post('pwd');
		$first_name = $this->input->get_post('first_name');
		$last_name = $this->input->get_post('last_name');
		
		if ($mail==='' || $pwd==='') {
			echo json_encode(array('stat'=>0, 'msg'=>'signIn error!', 'uid'=>''));
			exit;
		}
		
		if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
			echo json_encode(array('stat'=>0, 'msg'=>'email address is considered invalid!', 'uid'=>$mail));
			exit;
		}
		
		
		if (!$this->model->isExistEmail($mail)) {
			echo json_encode($this->model->signUp($mail, md5($pwd), $first_name, $last_name));
			exit;
		} 
		
		echo json_encode(array('stat'=>0, 'msg'=>'The data exist already.', 'uid'=>''));
		
	}
	
	public function getGoalList() {
		$uid = $this->input->get_post('uid');
		
		echo json_encode(array('stat'=>1, 'msg'=>'', 'uid'=>$uid, 'data'=>$this->model->getGoalList()));
	}
	
	public function getCourseList() {
		$uid = $this->input->get_post('uid');
		$pid = $this->input->get_post('goal_id');
		
		$data = $this->model->getCourseList($pid);
		
		$result = array();
		
		if (!empty($data)) {
			foreach ($data as $item) {
				$item['module'] = $this->model->getModuleList($uid, $item['id']);
				$result[] = $item;
			}
		}
		
		echo json_encode(array('stat'=>1, 'msg'=>'', 'uid'=>$uid, 'data'=>$result));
	}
	
	public function getCourseDetail() {
		$uid = $this->input->get_post('user_id');
		$cid = $this->input->get_post('course_id');
		
		$data = $this->model->getCourseDetail($cid);
		$module = (!empty($data)) ? $this->model->getModuleList($uid, $data['id']) : array();
		$data['module'] = $module;
		
		echo json_encode(array('stat'=>1, 'msg'=>'', 'uid'=>$uid, 'data'=>$data));
	}
	
	public function getModuleList() {
		$uid = $this->input->get_post('user_id');
		$pid = $this->input->get_post('course_id');
		
		echo json_encode(array('stat'=>1, 'msg'=>'', 'uid'=>$uid, 'data'=>$this->model->getModuleList($uid, $pid)));
	}
	
	public function getModuleDetail() {
		$uid = $this->input->get_post('user_id');
		$mid = $this->input->get_post('module_id');
		
		$data = $this->model->getModuleDetail($uid, $mid);
		$course = (!empty($data)) ? $this->model->getCourseDetail($data['parent_id']) : array();
		$data['course'] = $course;
		
		echo json_encode(array('stat'=>1, 'msg'=>'', 'uid'=>$uid, 'data'=>$data));
	}
	
	public function setModuleState() {
		$uid = $this->input->get_post('user_id');
		$cid = $this->input->get_post('course_id');
		$mid = $this->input->get_post('module_id');
		$state = $this->input->get_post('state');
		
		$this->model->setModuleState($uid, $cid, $mid, $state);
		
		echo json_encode(array('stat'=>1, 'msg'=>'Update data.', 'uid'=>$uid));
	}
	
	public function getCoursePay() {
		$uid = $this->input->get_post('uid');
		
		echo json_encode(array('stat'=>1, 'msg'=>'', 'uid'=>$uid, 'data'=>$this->model->getCoursePay($uid)));
	}
	
	public function setCoursePay() {
		$uid = $this->input->get_post('uid');
		$cid = $this->input->get_post('course_id');
		
		$this->model->setCoursePay($uid, $cid);
		
		echo json_encode(array('stat'=>1, 'msg'=>'Insert pay data.', 'uid'=>$uid, 'course_id'=>$cid));
	}
	
	public function setUserFirstName() {
		$uid = $this->input->get_post('uid');
		$fname = $this->input->get_post('fname');
		
		$this->model->setUserFirstName($uid, $fname);
		
		echo json_encode(array('stat'=>1, 'msg'=>'Insert data.', 'uid'=>$uid));
	}
	
	public function setUserLastName() {
		$uid = $this->input->get_post('uid');
		$lname = $this->input->get_post('lname');
		
		$this->model->setUserLastName($uid, $lname);
		
		echo json_encode(array('stat'=>1, 'msg'=>'Insert data.', 'uid'=>$uid));
	}
	
	public function setUserMail() {
		$uid = $this->input->get_post('uid');
		$mail = $this->input->get_post('mail');
		
		$this->model->setUserMail($uid, $mail);
		
		echo json_encode(array('stat'=>1, 'msg'=>'Insert data.', 'uid'=>$uid));
	}
	
	public function getUserInfo() {
	    $uid = $this->input->get_post('uid');
	    echo json_encode( array('stat'=>1, 'msg'=>'Update user photo.', 'uid'=>$uid, 'data'=>$this->model->getUserInfo($uid)));
	}
	
	public function setUserPhoto() {
		$uid = $this->input->get_post('uid');
		
		$result = array();
		
		if (!empty($_FILES) && isset($uid)) {
		    
			$file_name = time();
			$file_ext = $_FILES['file']['name'];
			$full_name = $file_name . '.' . $file_ext;
			
			$upload_file = $_FILES['file']['tmp_name'];
			$target_file = $this->UPLOAD_PATH . $full_name;
			
			if (move_uploaded_file($upload_file, $target_file)) {
			    $full_path = base_url().$target_file;
			    
				$this->model->setUserPhoto($uid, $file_name);
				$this->admin_model->setUploadFile($file_name, $full_path, $this->USER_TYPE);
			}
			
			$result = array('stat'=>1, 'msg'=>'Update user photo.', 'uid'=>$uid, 'data'=>$this->model->getUserInfo($uid));
		
		} else {
		    $result = array('stat'=>0, 'msg'=>"Can't upload file.", 'uid'=>$uid);
		}
		
		echo json_encode($result);
	}
	
	public function setUserBanner() {
		$uid = $this->input->get_post('uid');
		
		$result = array();
		
		if (!empty($_FILES) && isset($uid)) {
		
			$file_name = time();
			$file_ext = $_FILES['file']['name'];
			$full_name = $file_name . '.' . $file_ext;
			
			$upload_file = $_FILES['file']['tmp_name'];
			$target_file = $this->UPLOAD_PATH . $full_name;
			
			if (move_uploaded_file($upload_file, $target_file)) {
			    $full_path = base_url().$target_file;
			    
				$this->model->setUserBanner($uid, $file_name);
				$this->admin_model->setUploadFile($file_name, $full_path, $this->USER_TYPE);
			}
		    
		    $result = array('stat'=>1, 'msg'=>'Update user banner.', 'uid'=>$uid, 'data'=>$this->model->getUserInfo($uid));
		
		} else {
		    $result = array('stat'=>0, 'msg'=>"Can't upload file.", 'uid'=>$uid);
		}
		
		echo json_encode($result);
	}
	
	public function setUserDescription() {
		$uid = $this->input->get_post('uid');
		$description = $this->input->get_post('description');
		
		$this->model->setUserDescription($uid, $description);
		
		echo json_encode(array('stat'=>1, 'msg'=>'Insert the data.', 'uid'=>$uid));
	}
	
	public function addHistory() {
		$uid = $this->input->get_post('uid');
		$cid = $this->input->get_post('course_id');
		$state = $this->input->get_post('state');
		
		$this->model->addHistory($uid, $cid, $state);
		
		echo json_encode(array('stat'=>1, 'msg'=>'Insert the data.', 'uid'=>$uid));
	}
	
	public function getHistoryList() {
		$uid = $this->input->get_post('uid');
		
		echo json_encode(array('stat'=>1, 'msg'=>'', 'uid'=>$uid, 'data'=>$this->model->getHistoryList($uid)));
	}
	
	public function addGroup() {
		$uid = $this->input->get_post('uid');
		$cid = $this->input->get_post('course_id');
		$name = $this->input->get_post('name');
		$description = $this->input->get_post('description');
		$isPrivate = $this->input->get_post('isPrivate');
		$start_date = $this->input->get_post('start_date');
		$friends = $this->input->get_post('friends');
		
		$gid = $this->model->addGroup($uid, $cid, $name, $description, $isPrivate, $start_date);
		
		$stat = "1";
		$msg = "Insert Data.";
		$error_id = "";
		
		if ($gid != '') {
			$uids = explode(",", $friends);
			
			if (!empty($uids)) {
				for ($i=0; $i<count($uids); $i++) {
					if ($this->model->isExistUserById($uids[$i])) {
						$action_id = $this->model->addGroupFriend($gid, $uids[$i]);
						$this->model->setActivity($this->ACTIVITY_GROUP, $uid, $uids[$i], 0, $action_id);
					} else {
						$stat = "0";
						$error_id .= $fids[$i] . " ";
					}
				}
				
				$content = "This group is created on " . date("h:i:sa") . " " . date("Y/m/d");
				$this->model->setCommunity($gid, $uid, $content, $this->COMMUNITY_CREATE);
			}
		}
		
		if ($error_id != "") {
			$msg = "Insert Error. The " . $error_id . " are not exist.";
		}
		
		$result = array('stat'=>$stat, 'msg'=>$msg, 'uid'=>$uid);
		
		echo json_encode($result);
	}
	
	public function getGroupList() {
		$uid = $this->input->get_post('uid');
		
		$data = array();
		$tmp = $this->model->getGroupList($uid);
		
		foreach ($tmp as $item) {
			$item['friends'] = $this->model->getGroupFriendByID($item['id']);
			$data[] = $item;
		}
		
		echo json_encode(array('stat'=>1, 'msg'=>'', 'uid'=>$uid, 'data'=>$data));
	}
	
	public function searchUser() {
		$keyword = $this->input->get_post('keyword');
		
		echo json_encode(array('stat'=>1, 'msg'=>'Insert the data.', 'data'=>$this->model->searchUser($keyword)));
	}
	
	public function addGroupFriend() {
		$fid = $this->input->get_post('fid');
		$gid = $this->input->get_post('group_id');
		
		$stat = "1";
		$msg = "Insert Data.";
		$error_id = "";
		
		$fids = explode(",", $fid);
		if (!empty($fids)) {
			for ($i=0; $i<count($fids); $i++) {
				if ($this->model->isExistUserById($fids[$i])) {
					$action_id = $this->model->addGroupFriend($gid, $fids[$i]);
					$this->model->setActivity($this->ACTIVITY_GROUP, $uid, $fids[$i], 0, $action_id);
				} else {
					$stat = "0";
					$error_id .= $fids[$i] . " ";
				}
			}
		}
		
		if ($error_id != "") {
			$msg = "Insert Error. The " . $error_id . " are not exist.";
		}
		
		$result = array('stat'=>$stat, 'msg'=>$msg, 'uid'=>$uid);
		
		echo json_encode($result);
	}
	
	public function setGroupFriendAccept() {
		$id = $this->input->get_post('id');
		$activity_id = $this->input->get_post('request_id');
		
		$this->model->setGroupFriendAccept($id, $activity_id);

		echo json_encode(array('stat'=>1, 'msg'=>'Update the data.', 'uid'=>''));
	}
	
	public function setGroupFriendDecline() {
		$id = $this->input->get_post('id');
		$activity_id = $this->input->get_post('request_id');
		
		$this->model->setGroupFriendDecline($id, $activity_id);

		echo json_encode(array('stat'=>1, 'msg'=>'Update the data.', 'uid'=>''));
	}
	
	public function removeGroupFriend() {
		$id = $this->input->get_post('id');
		
		$this->model->removeGroupFriend($id);

		echo json_encode(array('stat'=>1, 'msg'=>'Update the data.', 'uid'=>''));
	}

	public function getGroupFriendList() {
		$gid = $this->input->get_post('group_id');
		
		echo json_encode(array('stat'=>1, 'msg'=>'', 'uid'=>$uid, 'data'=>$this->model->getGroupFriendList($gid)));
	}
	
	public function addFriend() {
		$uid = $this->input->get_post('uid');
		$fid = $this->input->get_post('friend_id');
		
		$stat = "1";
		$msg = "Insert Data.";
		$error_id = "";
		
		$fids = explode(",", $fid);
		if (!empty($fids)) {
			for ($i=0; $i<count($fids); $i++) {
				if ($this->model->isExistUserById($fids[$i])) {
					$this->model->setActivity($this->ACTIVITY_FRIEND, $uid, $fids[$i], 0);
				} else {
					$stat = "0";
					$error_id .= $fids[$i] . " ";
				}
			}
		}
		
		if ($error_id != "") {
			$msg = "Insert Error. The " . $error_id . " are not exist.";
		}
		
		$result = array('stat'=>$stat, 'msg'=>$msg, 'uid'=>$uid);
		
		echo json_encode($result);
	}
	
	public function setFriendAccept() {
		$activity_id = $this->input->get_post('request_id');
		$response_id = $this->input->get_post('uid');
		$request_id = $this->model->getRequestIdInActivty($activity_id);
		
		$result = array();
		if ($request_id != '-1') {
			$this->model->setFriendAccept($activity_id, $request_id, $response_id);
			$result = array('stat'=>1, 'msg'=>'Update the data.', 'uid'=>'');
		} else {
			$result = array('stat'=>0, 'msg'=>'Invalid RequestID.', 'uid'=>'');
		}

		echo json_encode($result);
		
	}
	
	public function setFriendDecline() {
		$response_id = $this->input->get_post('uid');
		$activity_id = $this->input->get_post('request_id');
		
		$this->model->setFriendDecline($activity_id , $response_id );

		echo json_encode(array('stat'=>1, 'msg'=>'Update the data.', 'uid'=>''));
	}
	
	public function removeFriend() {
		$id = $this->input->get_post('id');
		
		$this->model->removeFriend($id);

		echo json_encode(array('stat'=>1, 'msg'=>'Update the data.', 'uid'=>''));
	}

	public function getFriendList() {
		$uid = $this->input->get_post('uid');
		$s_name = $this->input->get_post('s_name');
		
		echo json_encode(array('stat'=>1, 'msg'=>'', 'uid'=>$uid, 'data'=>$this->model->getFriendList($uid, $s_name)));
	}
	
	/**** Activity ****/
	
	public function getActivities() {
		$uid = $this->input->get_post('uid');
		
		$result = array();
		$data = $this->model->getActivityList($uid);
		
		foreach ($data as $item) {
			if ($item['type'] == $this->ACTIVITY_FRIEND) {
				$item['request_msg'] = "John sent you friend request.";
			}
				
			if ($item['type'] == $this->ACTIVITY_GROUP) {
				$gid = $this->model->getGroupIdByGroupFriendId($item['action_id']);
				
				if ($gid != "-1") {
					$item['group_info'] = $this->model->getGrouDetail($gid);
				}
			}
				
			$item['request_user'] = $this->model->getUserInfo($item['request_id']);
			$result[] = $item;
		}
		
		echo json_encode(array('stat'=>1, 'uid'=>$uid, 'data'=>$result));
	}
	
	/***** Community *****/
	
	public function getCommunityList() {
	    $uid = $this->input->get_post('uid');
	    
	    $data = $this->model->getCommunityList($uid);
		
		echo json_encode(array('stat'=>1, 'msg'=>'', 'uid'=>$uid, 'data'=>$data));
	}
	
	public function setCommunity() {
	    $gid = $this->input->get_post('gid');
	    $uid = $this->input->get_post('uid');
	    $content = $this->input->get_post('content');
	    $type = $this->input->get_post('type');
	    
	    $this->model->setCommunity($gid, $uid, $content, $type);

		echo json_encode(array('stat'=>1, 'msg'=>'Insert the data.', 'uid'=>$uid));
	}
	
	public function getCommentsList() {
	    $community_id = $this->input->get_post('community_id');
	    
	    $data = $this->model->getCommentsList($community_id);
		
		echo json_encode(array('stat'=>1, 'msg'=>'', 'uid'=>'', 'data'=>$data));
	}
	
	public function setComments() {
	    $community_id = $this->input->get_post('community_id');
	    $uid = $this->input->get_post('uid');
	    $content = $this->input->get_post('content');
	    
	    $this->model->setComments($uid, $community_id, $content);

		echo json_encode(array('stat'=>1, 'msg'=>'Insert the data.', 'uid'=>$uid));
	}
	
	public function getLike() {
	    $uid = $this->input->get_post('uid');
	    $community_id = $this->input->get_post('community_id');
	    
	    $data = $this->model->getLike($uid, $community_id);
		
		echo json_encode(array('stat'=>1, 'msg'=>'', 'uid'=>'', 'data'=>$data));
	}
	
	public function setLike() {
	    $uid = $this->input->get_post('uid');
	    $community_id = $this->input->get_post('community_id');
	    $value = $this->input->get_post('value');
	    
	    $this->model->setLike($uid, $community_id, $value);

		echo json_encode(array('stat'=>1, 'msg'=>'Insert the data.', 'uid'=>$uid));
	}

}
