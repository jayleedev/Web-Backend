<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

	/****** login ******/
	function signIn($mail, $password) {
	    $result = array('stat'=>0, 'msg'=>'signIn error!', 'uid'=>'');
		
	    $this->db->select('*');
	    $this->db->where('mail', $mail);
	
	    $query = $this->db->get('user');
	
	    $user = $query->result();
	
	    if(!empty($user)) {
	        if($password == $user[0]->password && $user[0]->level == 1){
				$result["stat"] = 1;
				$result["msg"] = "signIn success";
				$result["uid"] = $user[0]->id;
				
				return true;
	        }
	    }
		
	    return false;
	}
	
	/****** goal *******/
	
	function getGoalList() {
		$sql = "SELECT * FROM category";
 		$query = $this->db->query($sql);
	
		$data = array();
		foreach ($query->result() as $row) {
			$data[] = array(
				'DT_RowId' => $row->id,
				'name' => $row->name,
				'icon' => $row->icon,
				'date' => gmdate("Y-m-d", $row->reg_date)
			);
		}
		
		return $data;
	}
	
	function getGoalDetail($id) {
		$sql = "SELECT * FROM category WHERE id=" . $id;
 		$query = $this->db->query($sql);
	
		$data = array();
		foreach ($query->result() as $row) {
			$data[] = array(
				'DT_RowId' => $row->id,
				'name' => $row->name,
				'icon' => $row->icon,
				'date' => gmdate("Y-m-d", $row->reg_date)
			);
		}
		
		return $data;
	}
	
	function getGoalItems() {
		$sql = "SELECT * FROM category";
 		$query = $this->db->query($sql);
	
		$data = array();
		foreach ($query->result() as $row) {
			$data[] = array(
				'label' => $row->name,
				'value' => $row->id
			);
		}
		
		return array('goal_id' => $data);
	}
	
	function createGoal($name, $icon) {
		$create_time = time();
		$this->db->set('name', $name);
		$this->db->set('icon', $icon);
		$this->db->insert('category');
	}
	
	function updateGoal($id, $name, $icon) {
		$this->db->set('name', $name);
		$this->db->set('icon', $icon);
		$this->db->set('reg_date', time());
		$this->db->where('id', $id);
		$this->db->update('category');
	}
	
	function deleteGoal($id) {
		$this->db->where('id', $id);
		$this->db->delete('category');
	}
	
	/****** course *******/
	
	function getCourseList() {
		$sql = "SELECT a.*, b.name AS goal_name FROM course AS a LEFT JOIN category AS b ON a.parent=b.id";
 		$query = $this->db->query($sql);
	
		$data = array();
		foreach ($query->result() as $row) {
			$data[] = array(
				'DT_RowId' => $row->id,
				'goal_id' => $row->parent,
				'name' => $row->name,
				'goal_name' => $row->goal_name,
				'description' => $row->description,
				'date' => gmdate("Y-m-d", $row->reg_date),
				'icon' => $row->icon
			);
		}
		
		return $data;
	}
	
	function getCourseDetail($id) {
		$sql = "SELECT a.*, b.name AS goal_name FROM course AS a LEFT JOIN category AS b ON a.parent=b.id WHERE a.id=" . $id;
 		$query = $this->db->query($sql);
	
		$data = array();
		foreach ($query->result() as $row) {
			$data[] = array(
				'DT_RowId' => $row->id,
				'goal_id' => $row->parent,
				'name' => $row->name,
				'goal_name' => $row->goal_name,
				'description' => $row->description,
				'date' => gmdate("Y-m-d", $row->reg_date),
				'icon' => $row->icon
			);
		}
		
		return $data;
	}
	
	function getCourseItems() {
		$sql = "SELECT * FROM course";
 		$query = $this->db->query($sql);
	
		$data = array();
		foreach ($query->result() as $row) {
			$data[] = array(
				'label' => $row->name,
				'value' => $row->id
			);
		}
		
		return array('course_id' => $data);
	}
	
	function createCourse($gid, $name, $description, $icon) {
		$create_time = time();
		$this->db->set('parent', $gid);
		$this->db->set('name', $name);
		$this->db->set('description', $description);
		$this->db->set('reg_date', $create_time);
		$this->db->set('icon', $icon);
		$this->db->insert('course');
	}
	
	function updateCourse($id, $gid, $name, $description, $icon) {
		$this->db->set('parent', $gid);
		$this->db->set('name', $name);
		$this->db->set('description', $description);
		$this->db->set('icon', $icon);
		$this->db->set('reg_date', time());
		$this->db->where('id', $id);
		$this->db->update('course');
	}
	
	function deleteCourse($id) {
		$this->db->where('id', $id);
		$this->db->delete('course');
	}
	
	/****** module *******/
	
	function getModuleList() {
		$sql = "SELECT a.*, b.name AS course_name FROM module AS a LEFT JOIN course AS b ON a.parent=b.id";
 		$query = $this->db->query($sql);
	
		$data = array();
		foreach ($query->result() as $row) {
			$data[] = array(
				'DT_RowId' => $row->id,
				'course_id' => $row->parent,
				'name' => $row->name,
				'course_name' => $row->course_name,
				'description' => $row->description,
				'date' => gmdate("Y-m-d", $row->reg_date),
				'audio' => $row->audio_file,
				'duration' => $row->duration
			);
		}
		
		return $data;
	}
	
	function getModuleDetail($id) {
		$sql = "SELECT a.*, b.name AS course_name FROM module AS a LEFT JOIN course AS b ON a.parent=b.id WHERE a.id=" . $id;
 		$query = $this->db->query($sql);
	
		$data = array();
		foreach ($query->result() as $row) {
			$data[] = array(
				'DT_RowId' => $row->id,
				'course_id' => $row->parent,
				'name' => $row->name,
				'course_name' => $row->course_name,
				'description' => $row->description,
				'date' => gmdate("Y-m-d", $row->reg_date),
				'audio' => $row->audio_file,
				'duration' => $row->duration
			);
		}
		
		return $data;
	}
	
	function createModule($cid, $name, $description, $duration, $audio) {
		$create_time = time();
		$this->db->set('parent', $cid);
		$this->db->set('name', $name);
		$this->db->set('description', $description);
		$this->db->set('reg_date', $create_time);
		$this->db->set('audio_file', $audio);
		$this->db->set('duration', $duration);
		$this->db->insert('module');
	}
	
	function updateModule($id, $cid, $name, $description, $duration, $audio) {
		$this->db->set('parent', $cid);
		$this->db->set('name', $name);
		$this->db->set('description', $description);
		$this->db->set('audio_file', $audio);
		$this->db->set('duration', $duration);
		$this->db->set('reg_date', time());
		$this->db->where('id', $id);
		$this->db->update('module');
	}
	
	function deleteModule($id) {
		$this->db->where('id', $id);
		$this->db->delete('module');
	}
	
	/****** user *******/
	
	function getUserList() {
		$sql = "SELECT * FROM user WHERE level=0";
 		$query = $this->db->query($sql);
	
		$data = array();
		foreach ($query->result() as $row) {
			$data[] = array(
				'DT_RowId' => $row->id,
				'first_name' => $row->first_name,
				'last_name' => $row->last_name,
				'name' => $row->first_name . " " . $row->last_name,
				'mail' => $row->mail,
				'password' => $row->password,
				'description' => $row->description,
				'date' => gmdate("Y-m-d", $row->reg_date),
				'banner' => $row->banner,
				'photo' => $row->photo
			);
		}
		
		return $data;
	}
	
	function getUserDetail($id) {
		$sql = "SELECT * FROM user WHERE id=" .$id;
 		$query = $this->db->query($sql);
	
		$data = array();
		foreach ($query->result() as $row) {
			$data[] = array(
				'DT_RowId' => $row->id,
				'first_name' => $row->first_name,
				'last_name' => $row->last_name,
				'name' => $row->first_name . " " . $row->last_name,
				'mail' => $row->mail,
				'description' => $row->description,
				'date' => gmdate("Y-m-d", $row->reg_date),
				'banner' => $row->banner,
				'photo' => $row->photo
			);
		}
		
		return $data;
	}
	
	function createUser($first_name, $last_name, $mail, $password, $description, $banner, $photo) {
		$create_time = time();
		$this->db->set('first_name', $first_name);
		$this->db->set('last_name', $last_name);
		$this->db->set('mail', $mail);
		$this->db->set('password', $password);
		$this->db->set('description', $description);
		$this->db->set('reg_date', $create_time);
		$this->db->set('banner', $banner);
		$this->db->set('photo', $photo);
		$this->db->insert('user');
	}
	
	function updateUser($id, $first_name, $last_name, $mail, $description, $banner, $photo) {
		$this->db->set('first_name', $first_name);
		$this->db->set('last_name', $last_name);
		$this->db->set('mail', $mail);
		$this->db->set('description', $description);
		$this->db->set('banner', $banner);
		$this->db->set('photo', $photo);
		$this->db->where('id', $id);
		$this->db->update('user');
	}
	
	function deleteUser($id) {
		$this->db->where('id', $id);
		$this->db->delete('user');
	}
	
	function isExistMail($mail) {
		$this->db->select('id');
		$this->db->where('mail', $mail);
		
		$query = $this->db->get('user');
		
		if ($query->num_rows()>0) {
			return true;
		} else {
			return false;
		}
	}
	
	/****** admin *******/
	
	function getAdminID() {
		
		$sql = "SELECT id FROM user WHERE level=1 ORDER BY id DESC LIMIT 1";
		$query = $this->db->query($sql);
		
		$result = '';
		foreach ($query->result() as $row) {
			$result = $row->id;
		}
		
		return $result;
	}
	
	function getAdminDetail($id) {
		$sql = "SELECT 
				a.first_name, a.last_name, a.mail, a.description, b.url as photo 
			FROM (SELECT 
					first_name, last_name, mail, description,  
					IF(photo IS NULL OR photo = '', '-1', photo) AS photo
				  FROM user WHERE id=" .$id . ") AS a 
				LEFT JOIN upload_files AS b 
					ON a.photo = b.id";
 		$query = $this->db->query($sql);
	
		$data = array();
		foreach ($query->result() as $row) {
			$data = array(
				'id' => $id,
				'first_name' => $row->first_name,
				'last_name' => $row->last_name,
				'name' => $row->first_name . " " . $row->last_name,
				'mail' => $row->mail,
				'description' => $row->description,
				'photo' => $row->photo
			);
		}
		
		return $data;
	}
	
	function setAdminInfo($id, $first_name, $last_name, $mail, $description) {
		$this->db->set('first_name', $first_name);
		$this->db->set('last_name', $last_name);
		$this->db->set('mail', $mail);
		$this->db->set('description', $description);
		$this->db->where('id', $id);
		$this->db->update('user');
	}
	
	function setPassword($id, $pwd) {
		$this->db->set('password', $pwd);
		$this->db->where('id', $id);
		$this->db->update('user');
	}
	
	function checkPassword($id, $pwd) {
		$sql = "SELECT id FROM user WHERE id=" . $id . " AND password='" . $pwd . "' LIMIT 1";
		$query = $this->db->query($sql);
		
		return ($query->num_rows() > 0) ? true : false;
	}
	
	function setPhoto($id, $photo) {
		$this->db->set('photo', $photo);
		$this->db->where('id', $id);
		$this->db->update('user');
	}
	
	/****** File Upload / register *******/

	function setUploadFile($id, $url='', $type=-1) {
		$this->db->set('id', $id);
		$this->db->set('url', $url);
		$this->db->set('type', $type);
		$this->db->insert('upload_files');
	}
	
	function getUploadFileList($type=-1) { // 0:module 1:course 2:user
		$this->db->select('*');
		$this->db->where('type', $type);
 		$query = $this->db->get('upload_files');
		
		$data = array();
		foreach ($query->result() as $row) {
			$data[$row->id] = array(
				'id' => $row->id,
				'web_path' => $row->url
			);
		}
		
		return array('files' => $data);
	}
	
	/****** Util *********/
	
	function getLastIDFromTB($tb_name) {
		
		$sql = "SELECT id FROM " . $tb_name . " ORDER BY id DESC LIMIT 1";
		$query = $this->db->query($sql);
		
		$result = '';
		foreach ($query->result() as $row) {
			$result = $row->id;
		}
		
		return $result;
	}
  
}
