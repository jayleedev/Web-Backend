<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Docs extends CI_Controller {

	public function __construct() {
		parent::__construct();
		
		$this->load->helper('url');
		
		if (!isset($this->session->userdata['user']))
			header("Location: ".base_url());
		
	}

	public function index() {
		$data['menu'] = "signIn";
		$this->load->view('docs/signIn', $data);
	}

	public function signInView() {
		$data['menu'] = "signIn";
		$this->load->view('docs/signIn', $data);
	}

	public function signUpView() {
		$data['menu'] = "signUp";
		$this->load->view('docs/signUp', $data);
	}

	public function goalListView() {
		$data['menu'] = "goalList";
		$this->load->view('docs/goalList', $data);
	}

	public function courseListView() {
		$data['menu'] = "courseList";
		$this->load->view('docs/courseList', $data);
	}

	public function courseDetailView() {
		$data['menu'] = "courseDetail";
		$this->load->view('docs/courseDetail', $data);
	}

	public function moduleListView() {
		$data['menu'] = "moduleList";
		$this->load->view('docs/moduleList', $data);
	}

	public function moduleDetailView() {
		$data['menu'] = "moduleDetail";
		$this->load->view('docs/moduleDetail', $data);
	}

	public function setModuleStateView() {
		$data['menu'] = "setModuleState";
		$this->load->view('docs/setModuleState', $data);
	}

	public function coursePayView() {
		$data['menu'] = "coursePay";
		$this->load->view('docs/coursePay', $data);
	}

	public function userFirstNameView() {
		$data['menu'] = "userFirstName";
		$this->load->view('docs/userFirstName', $data);
	}
	
	public function userLastNameView() {
		$data['menu'] = "userLastName";
		$this->load->view('docs/userLastName', $data);
	}
	
	public function userEmailView() {
		$data['menu'] = "userEmail";
		$this->load->view('docs/userEmail', $data);
	}

	public function userPhotoView() {
		$data['menu'] = "userPhoto";
		$this->load->view('docs/userPhoto', $data);
	}
	
	public function userBannerView() {
		$data['menu'] = "userBanner";
		$this->load->view('docs/userBanner', $data);
	}

	public function userDescriptionView() {
		$data['menu'] = "userDescription";
		$this->load->view('docs/userDescription', $data);
	}

	public function addHistoryView() {
		$data['menu'] = "addHistory";
		$this->load->view('docs/addHistory', $data);
	}

	public function getHistoryListView() {
		$data['menu'] = "getHistoryList";
		$this->load->view('docs/getHistoryList', $data);
	}

	public function addGroupView() {
		$data['menu'] = "addGroup";
		$this->load->view('docs/addGroup', $data);
	}

	public function getGroupListView() {
		$data['menu'] = "getGroupList";
		$this->load->view('docs/getGroupList', $data);
	}

	public function searchUserView() {
		$data['menu'] = "serachUser";
		$this->load->view('docs/searchUser', $data);
	}

	public function addGroupFriendView() {
		$data['menu'] = "addGroupFriend";
		$this->load->view('docs/addGroupFriend', $data);
	}

	public function setGroupFriendAcceptView() {
		$data['menu'] = "setGroupFriendAccept";
		$this->load->view('docs/setGroupFriendAccept', $data);
	}

	public function setGroupFriendDeclineView() {
		$data['menu'] = "setGroupFriendDecline";
		$this->load->view('docs/setGroupFriendDecline', $data);
	}

	public function removeGroupFriendView() {
		$data['menu'] = "removeGroupFriend";
		$this->load->view('docs/removeGroupFriend', $data);
	}

	public function getGroupFriendView() {
		$data['menu'] = "getGroupFriend";
		$this->load->view('docs/getGroupFriend', $data);
	}

	public function addFriendView() {
		$data['menu'] = "addFriend";
		$this->load->view('docs/addFriend', $data);
	}

	public function setFriendAcceptView() {
		$data['menu'] = "setFriendAccept";
		$this->load->view('docs/setFriendAccept', $data);
	}

	public function setFriendDeclineView() {
		$data['menu'] = "setFriendDecline";
		$this->load->view('docs/setFriendDecline', $data);
	}

	public function removeFriendView() {
		$data['menu'] = "removeFriend";
		$this->load->view('docs/removeFriend', $data);
	}

	public function getFriendListView() {
		$data['menu'] = "getFriendList";
		$this->load->view('docs/getFriendList', $data);
	}
	
	public function getActivityListView() {
		$data['menu'] = "getActivityList";
		$this->load->view('docs/getActivityList', $data);
	}
	
	public function getCommunityListView() {
		$data['menu'] = "getCommunityList";
		$this->load->view('docs/getCommunityList', $data);
	}
	
	public function setCommunityView() {
		$data['menu'] = "setCommunity";
		$this->load->view('docs/setCommunity', $data);
	}
	
	public function getCommentsListView() {
		$data['menu'] = "getCommentsList";
		$this->load->view('docs/getCommentsList', $data);
	}
	
	public function setCommentsView() {
		$data['menu'] = "setComments";
		$this->load->view('docs/setComments', $data);
	}
	
	public function getLikeView() {
		$data['menu'] = "getLike";
		$this->load->view('docs/getLike', $data);
	}
	
	public function setLikeView() {
		$data['menu'] = "setLike";
		$this->load->view('docs/setLike', $data);
	}

}