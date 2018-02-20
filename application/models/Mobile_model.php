<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mobile_model extends CI_Model {

	var $DB_NAME = "shivyo5_backend";

  	function signIn($mail, $password) {
	    $result = array('stat'=>0, 'msg'=>'signIn error!', 'uid'=>'');
		
	    $this->db->select('*');
	    $this->db->where('mail', $mail);
	
	    $query = $this->db->get('user');
	    $user = $query->result();
	    
	    $data = array();
	    if(!empty($user)) {
	        if($password == $user[0]->password){
	        	$data = array(
    				'id' => $user[0]->id,
    				'first_name' => $user[0]->first_name,
    				'last_name' => $user[0]->last_name,
    				'email' => $user[0]->mail,
    				'description' => $user[0]->description,
    				'photo' => $user[0]->photo,
    				'banner' => $user[0]->banner
    			);
    			
    			$sql = "SELECT * FROM upload_files WHERE id='".$data['photo']."'";
        	    $query = $this->db->query($sql);
        	    
        	    foreach ($query->result() as $row) {
        			$data['photo'] = $row->url;
        		}
        		
        		$sql = "SELECT * FROM upload_files WHERE id='".$data['banner']."'";
        	    $query = $this->db->query($sql);
        	    
        	    foreach ($query->result() as $row) {
        			$data['banner'] = $row->url;
        		}
			
    			$sql = "SELECT 
        					c.cid AS cid, d.mid, c.course_name, c.module_name, c.icon 
        				FROM favorite AS d 
        				LEFT JOIN (
        					SELECT 
        						b.name AS course_name, a.name AS module_name, b.icon, a.id, b.id AS cid
        					FROM module AS a 
        					LEFT JOIN course AS b 
        					ON a.parent=b.id) AS c 
        				ON d.mid=c.id
        				WHERE d.uid=".$user[0]->id;
    				
    			$query = $this->db->query($sql);
    		
    			$favorite = array();
    			foreach ($query->result() as $row) {
    				$favorite [] = array(
    					'course_id' => is_null($row->cid) ? '' : $row->cid,
    					'module_id' => is_null($row->mid) ? '' : $row->mid,
    					'course_name' => is_null($row->course_name) ? '' : $row->course_name,
    					'module_name' => is_null($row->module_name) ? '' : $row->module_name,
    					'icon' => is_null($row->icon) ? '' : $row->icon
    				);
    			}
			
	        	$result = array('stat'=>1, 'msg'=>'signIn success', 'data'=>$data, 'favorite'=>$favorite);
	        	
	        }
	    }
		
	    return $result;
  	}
  
	function signup($mail, $password, $first_name, $last_name) {
		$data = array(
			'mail'=>$mail,
			'password'=>$password,
			'first_name'=>$first_name,
			'last_name'=>$last_name,
			'reg_date' => time()
		);
		
		$result = array('stat'=>0, 'msg'=>'signUp error!', 'uid'=>'');
		
		$this->db->insert('user', $data);
	
		$this->db->select('*');
		$this->db->where('mail', $mail);
		$query = $this->db->get('user');
	
		$user = $query->result();
		
		$data = array();
		if(!empty($user)) {
			if($password == $user[0]->password){
				$data = array(
					'id' => $user[0]->id,
					'first_name' => $user[0]->first_name,
					'last_name' => $user[0]->last_name,
					'email' => $user[0]->mail,
					'description' => $user[0]->description,
					'photo' => $user[0]->photo,
					'banner' => $user[0]->banner
				);
				
				$sql = "SELECT * FROM upload_files WHERE id='".$data['photo']."'";
        	    $query = $this->db->query($sql);
        	    
        	    foreach ($query->result() as $row) {
        			$data['photo'] = $row->url;
        		}
        		
        		$sql = "SELECT * FROM upload_files WHERE id='".$data['banner']."'";
        	    $query = $this->db->query($sql);
        	    
        	    foreach ($query->result() as $row) {
        			$data['banner'] = $row->url;
        		}
				
				$sql = "SELECT 
						c.cid AS cid, d.mid, c.course_name, c.module_name, c.icon 
					FROM favorite AS d 
					INNER JOIN (
						SELECT 
							b.name AS course_name, a.name AS module_name, b.icon, a.id, b.id AS cid
						FROM module AS a 
						INNER JOIN course AS b 
						ON a.parent=b.id) AS c 
					ON d.mid=c.id 
					WHERE d.uid=".$user[0]->id;
					
				$query = $this->db->query($sql);
			
				$favorite = array();
				foreach ($query->result() as $row) {
					$favorite [] = array(
						'course_id' => $row->cid,
						'module_id' => $row->mid,
						'course_name' => $row->course_name,
						'module_name' => $row->module_name,
						'icon' => $row->icon
					);
				}
				
		        	$result = array('stat'=>1, 'msg'=>'signUp success', 'data'=>$data, 'favorite'=>$favorite);
			}
		}
		
		return $result;
	}
  
	function isExistEmail($mail) {
		$this->db->select('id');
		$this->db->where('mail', $mail);
		
		$query = $this->db->get('user');
		
		if ($query->num_rows()>0) {
			return true;
		} else {
			return false;
		}
	}
	
	function isExistUserById($id) {
		$this->db->select('id');
		$this->db->where('id', $id);
		
		$query = $this->db->get('user');
		
		if ($query->num_rows()>0) {
			return true;
		} else {
			return false;
		}
	}
	
	function getFavoriteList($uid) {
		$sql = "SELECT 
				d.id, c.course_name, c.module_name, c.icon 
			FROM favorite AS d 
			INNER JOIN (
				SELECT 
					b.name AS course_name, a.name AS module_name, b.icon, a.id 
				FROM module AS a 
				INNER JOIN course AS b 
				ON a.parent=b.id) AS c 
			ON d.mid=c.id 
			WHERE d.uid="+$uid;
			
		$query = $this->db->query($sql);
	
		$data = array();
		foreach ($query->result() as $row) {
			$data[] = array(
				'id' => $row->id,
				'course_name' => $row->course_name,
				'module_name' => $row->module_name,
				'icon' => $row->icon
			);
		}
		
		return $data;
	}
  	
  	/************** tb : category ***************/

 	function getGoalList() {
 		$sql = "SELECT 
			a.id, a.name, a.reg_date, b.url AS icon
		FROM
			(SELECT 
				id, name, reg_date, IF(icon IS NULL OR icon = '', '-1', icon) AS icon  
			FROM category ) AS a
		LEFT JOIN upload_files AS b 
			ON a.icon = b.id";
			
		$query = $this->db->query($sql);
	
		$data = array();
		foreach ($query->result() as $row) {
			$data[] = array(
				'id' => $row->id,
				'name' => $row->name,
				'date' => $row->reg_date,
				'icon' => $row->icon
			);
		}
		
		return $data;
 	}
 	
  	/************** tb : course ***************/

	function getCourseList($cid) {
		$data = array();
		$goal_ids = explode(",", $cid);
		
		if (!empty($goal_ids)) {
	 		$where = "WHERE a.parent=" . $goal_ids[0];
	 		
	 		if (count($goal_ids) > 1) {
	 			for ($i=1; $i<count($goal_ids); $i++) {
	 				$where .= " OR a.parent=" . $goal_ids[$i];
	 			}
	 		}
			
			$sql = "SELECT 
					c.id, c.parent, c.name, c.description, c.reg_date,
					IF(c.module_count IS NULL OR c.module_count='', 0, c.module_count) AS module_count, 
					IF(d.url IS NULL OR d.url='', '', d.url)  AS icon
				FROM
					(SELECT 
						a.id, a.parent, a.name, a.description, a.reg_date, b.module_count,
						IF(a.icon IS NULL OR a.icon = '', '-1', a.icon) AS icon  
					FROM course AS a 
					LEFT JOIN (
						SELECT 
							parent AS course_id, COUNT(id) module_count 
						FROM module 
						GROUP BY parent) AS b 
					ON a.id=b.course_id " . $where . ") AS c
				LEFT JOIN upload_files AS d 
					ON c.icon = d.id";
				
			$query = $this->db->query($sql);
			
			foreach ($query->result() as $row) {
				$data[] = array(
					'id' => $row->id,
					'goal_id' => $row->parent,
					'name' => $row->name,
					'description' => $row->description,
					'date' => $row->reg_date,
					'icon' => $row->icon,
					'count' => $row->module_count
				);
			}
		}
		
		return $data;
 	}
 	
 	function getCourseDetail($cid) {
 		$sql = "SELECT 
				c.id, c.parent, c.name, c.description, c.reg_date, c.module_count, d.url AS icon
			FROM
				(SELECT 
					a.id, a.parent, a.name, a.description, a.reg_date, b.module_count,
					IF(a.icon IS NULL OR a.icon = '', '-1', a.icon) AS icon  
				FROM course AS a 
				LEFT JOIN (
					SELECT 
						parent AS course_id, COUNT(id) module_count 
					FROM module 
					GROUP BY parent) AS b 
				ON a.id=b.course_id WHERE a.id=" . $cid . ") AS c
			LEFT JOIN upload_files AS d 
				ON c.icon = d.id";
			
		$query = $this->db->query($sql);
	
		$data = array();
		foreach ($query->result() as $row) {
			$data = array(
				'id' => $row->id,
				'goal_id' => $row->parent,
				'name' => $row->name,
				'description' => $row->description,
				'date' => $row->reg_date,
				'icon' => $row->icon,
				'count' => $row->module_count
			);
		}
		
		return $data;
 	}
 	
 	/************** tb : module ***************/

 	function getModuleList($uid, $cid) {
 		
		$sql = "SELECT 
				c.id, c.parent, c.name, c.description, c.reg_date, c.duration, c.state, d.url AS audio_file
			FROM 
				(SELECT 
					a.id, a.parent, a.name, a.description, a.reg_date, a.duration, 
					IF(a.audio_file IS NULL OR a.audio_file = '', '-1', a.audio_file) AS audio, 
					IFNULL(b.state, 0) AS state 
				FROM module AS a 
					LEFT JOIN (SELECT MID, state FROM module_state WHERE uid=" . $uid . " AND cid=" . $cid . ") AS b 
						ON a.id = b.mid 
				WHERE a.parent=" . $cid . ") AS c
			LEFT JOIN upload_files AS d
				ON c.audio = d.id";
			 				
		$query = $this->db->query($sql);

		$data = array();
		foreach ($query->result() as $row) {
						
			$data[] = array(
				'id' => $row->id,
				'course_id' => $row->parent,
				'name' => $row->name,
				'description' => $row->description,
				'date' => $row->reg_date,
				'audio' => $row->audio_file,
				'duration' => $row->duration,
				'state' => $row->state
			);
		}
		
		return $data;
 	}
 	
 	function getModuleDetail($uid, $mid) {
 		
		$sql = "SELECT 
				c.id, c.parent, c.name, c.description, c.reg_date, c.duration, c.state, d.url AS audio_file
			FROM 
				(SELECT 
					a.id, a.parent, a.name, a.description, a.reg_date, a.duration, 
					IF(a.audio_file IS NULL OR a.audio_file = '', '-1', a.audio_file) AS audio, 
					IFNULL(b.state, 0) AS state 
				FROM module AS a 
					LEFT JOIN (SELECT MID, state FROM module_state WHERE uid=" . $uid . " AND mid=" . $mid . ") AS b 
						ON a.id = b.mid 
				WHERE a.id=" . $mid . ") AS c
			LEFT JOIN upload_files AS d
				ON c.audio = d.id";
			 				
		$query = $this->db->query($sql);
			
		$data = array();
		foreach ($query->result() as $row) {
			$data = array(
				'id' => $row->id,
				'course_id' => $row->parent,
				'name' => $row->name,
				'description' => $row->description,
				'date' => $row->reg_date,
				'audio' => $row->audio_file,
				'duration' => $row->duration,
				'state' => $row->state
			);
		}
		
		return $data;
 	}
 	
 	/************** tb : module_state ***************/

 	function setModuleState($uid, $cid, $mid, $state='0') {
 		$this->db->select('id');
		$this->db->where('uid', $uid);
 		$this->db->where('cid', $cid);
 		$this->db->where('mid', $mid);
		
		$query = $this->db->get('module_state');
		
		if ($query->num_rows()>0) {
			$this->db->set('state', $state);
	 		$this->db->where('uid', $uid);
	 		$this->db->where('cid', $cid);
	 		$this->db->where('mid', $mid);
	 		$this->db->update('module_state');
		} else {
			$data = array(
				'uid'=>$uid,
				'cid'=>$cid,
				'mid'=>$mid,
				'state'=>$state
			);
			$this->db->insert('module_state', $data);
		}
 	}
 	
 	/************** tb : course_pay ***************/

 	function getCoursePay($uid) {
 		$this->db->select('*');
 		$this->db->where('uid', $uid);
		$query = $this->db->get('course_pay');
	
		$data = array();
		foreach ($query->result() as $row) {
			$data[] = array(
				'id' => $row->id,
				'user_id' => $row->uid,
				'course_id' => $row->cid
			);
		}
		
		return $data;
 	}
 	
 	function setCoursePay($uid, $cid) {
 		$create_time = time();
		$this->db->set('uid', $uid);
		$this->db->set('cid', $cid);
		$this->db->set('reg_date', $create_time);
		$this->db->insert('course_pay');
 	}
 	
 	/************** tb : user ***************/
 	
 	function setUserFirstName($uid, $fname) {
 		$this->db->set('first_name', $fname);
 		$this->db->where('id', $uid);
 		$this->db->update('user');
 	}
 	
 	function setUserLastName($uid, $lname) {
 		$this->db->set('last_name', $lname);
 		$this->db->where('id', $uid);
 		$this->db->update('user');
 	}
 	
 	function setUserMail($uid, $mail) {
 		$this->db->set('mail', $mail);
 		$this->db->where('id', $uid);
 		$this->db->update('user');
 	}
 	
 	function setUserPhoto($uid, $photo) {
 		$this->db->set('photo', $photo);
 		$this->db->where('id', $uid);
 		$this->db->update('user');
 	}
 	
 	function setUserBanner($uid, $photo) {
 		$this->db->set('banner', $photo);
 		$this->db->where('id', $uid);
 		$this->db->update('user');
 	}
 	
 	function setUserDescription($uid, $description) {
 		$this->db->set('description', $description);
 		$this->db->where('id', $uid);
 		$this->db->update('user');
 	}
 	
 	function getUserInfo($uid) {
 		$sql = "SELECT * FROM user WHERE id='".$uid."'";
 		$query = $this->db->query($sql);
 		
		$data = array();
		foreach ($query->result() as $row) {
			$data = array(
				'id' => $row->id,
				'first_name' => $row->first_name,
				'last_name' => $row->last_name,
				'email' => $row->mail,
				'description' => $row->description,
				'banner' => $row->banner,
				'photo' => $row->photo
			);
		}
		
		$sql = "SELECT * FROM upload_files WHERE id='".$data['photo']."'";
	    $query = $this->db->query($sql);
	    
	    foreach ($query->result() as $row) {
			$data['photo'] = $row->url;
		}
		
		$sql = "SELECT * FROM upload_files WHERE id='".$data['banner']."'";
	    $query = $this->db->query($sql);
	    
	    foreach ($query->result() as $row) {
			$data['banner'] = $row->url;
		}
		
		return $data;
 	}
 	
 	function searchUser($keyword='') {
 		$sql = "SELECT * FROM user WHERE level<>1";
 		if ($keyword != '')
 			$sql .= " AND (first_name REGEXP '".$keyword."' OR last_name REGEXP '".$keyword."' OR mail REGEXP '".$keyword."')";
						
		$query = $this->db->query($sql);
	
		$data = array();
		foreach ($query->result() as $row) {
			$data[] = array(
				'id' => $row->id,
				'first_name' => $row->first_name,
				'last_name' => $row->last_name,
				'email' => $row->mail,
				'description' => $row->description,
				'banner' => $row->banner,
				'photo' => $row->photo
			);
		}
		
		for ($i=0; $i<count($data); $i++) {
		    $sql = "SELECT * FROM upload_files WHERE id='" . $data[$i]['photo'] . "'";
    	    $query = $this->db->query($sql);
    	    
    	    foreach ($query->result() as $row) {
    			$data[$i]['photo'] = $row->url;
    		}
    		
    		$sql = "SELECT * FROM upload_files WHERE id='".$data[$i]['banner']."'";
    	    $query = $this->db->query($sql);
    	    
    	    foreach ($query->result() as $row) {
    			$data[$i]['banner'] = $row->url;
    		}
		}
		
		return $data;
 	}
 	
 	/************** tb : history ***************/

 	function addHistory($uid, $cid, $state) {
		$create_time = time();
		$this->db->set('uid', $uid);
		$this->db->set('cid', $cid);
		$this->db->set('state', $state);
		$this->db->set('end_date', $create_time);
		$this->db->insert('history');
 	}
 	
 	function getHistoryList($uid) {
 		$this->db->select('*');
 		$this->db->where('uid', $uid);
		$query = $this->db->get('history');
		
		$data = array();
		foreach ($query->result() as $row) {
						
			$data[] = array(
				'id' => $row->id,
				'user_id' => $row->parent,
				'course_id' => $row->name,
				'state' => $row->description,
				'end_date' => $row->reg_date
			);
		}
		
		return $data;
 	}
 	
 	/************** tb : group ***************/
	
	function addGroup($uid, $cid, $name, $description, $isPrivate, $start_date) {
		$create_time = time();
		$this->db->set('uid', $uid);
		$this->db->set('cid', $cid);
		$this->db->set('name', $name);
		$this->db->set('description', $description);
		$this->db->set('isPrivate', $isPrivate);
		$this->db->set('reg_date', $create_time);
		$this->db->set('start_date', $start_date);
		$this->db->insert('group');
		
		$sql = "SELECT id FROM ".$this->DB_NAME.".group ORDER BY id DESC LIMIT 1";
		$query = $this->db->query($sql);
		
		$result = '';
		foreach ($query->result() as $row) {
			$result = $row->id;
		}
		
		return $result;
 	}
 	
 	function getGroupList($uid) {
 		$this->db->select('*');
 		$this->db->where('uid', $uid);
		$query = $this->db->get('group');
		
		$data = array();
		foreach ($query->result() as $row) {
						
			$data[] = array(
				'id' => $row->id,
				'user_id' => $row->uid,
				'course_id' => $row->cid,
				'name' => $row->name,
				'description' => $row->description,
				'isPrivate' => $row->isPrivate,
				'reg_date' => $row->reg_date,
				'start_date' => $row->start_date,
				'state' => $row->state
			);
		}
		
		return $data;
 	}
 	
 	function getGrouDetail($id) {
 		$this->db->select('*');
 		$this->db->where('id', $id);
		$query = $this->db->get('group');
		
		$data = array();
		foreach ($query->result() as $row) {
						
			$data = array(
				'id' => $row->id,
				'user_id' => $row->uid,
				'course_id' => $row->cid,
				'name' => $row->name,
				'description' => $row->description,
				'isPrivate' => $row->isPrivate,
				'reg_date' => $row->reg_date,
				'start_date' => $row->start_date,
				'state' => $row->state
			);
		}
		
		return $data;
 	}
 	
 	/************** tb : group_friend ***************/
 	
 	function addGroupFriend($gid, $uid) {
		$create_time = time();
		$this->db->set('uid', $uid);
		$this->db->set('gid', $gid);
		$this->db->set('reg_date', $create_time);
		$this->db->insert('group_friend');
		
		$sql = "SELECT id FROM ".$this->DB_NAME.".group_friend ORDER BY id DESC LIMIT 1";
		$query = $this->db->query($sql);
		
		$result = '';
		foreach ($query->result() as $row) {
			$result = $row->id;
		}
		
		return $result;
 	}
 	
 	function setGroupFriendAccept($id, $activity_id) {
 		$this->db->set('state', '1');
 		$this->db->where('id', $id);
 		$this->db->update('group_friend');
 		
 		$this->db->set('state', '1');
 		$this->db->where('id', $activity_id);
 		$this->db->update('activity');
 	}
 	
 	function setGroupFriendDecline($id, $activity_id) {
 		$this->db->set('state', '2');
 		$this->db->where('id', $id);
 		$this->db->update('group_friend');
 		
 		$this->db->set('state', '2');
 		$this->db->where('id', $activity_id);
 		$this->db->update('activity');
 	}
 	
 	function removeGroupFriend($id) {
 		$this->db->where('id', $id);
 		$this->db->delete('group_friend');
 	}
 	
 	function getGroupFriendList($gid) {
 		
 		$sql = "SELECT 
				a.id,  a.state,
				IF(b.first_name IS NULL, '', b.first_name) as first_name, 
				IF(b.last_name IS NULL, '', b.last_name) as last_name, 
				IF(b.mail IS NULL, '', b.mail) as mail, 
				IF(b.description IS NULL, '', b.description) as description, 
				IF(b.banner IS NULL, '', b.banner) as banner, 
				IF(b.photo IS NULL, '', b.photo) as photo
			FROM group_friend AS a 
				LEFT JOIN user AS b 
				ON a.uid=b.id 
			WHERE a.gid=" . $gid;
						
		$query = $this->db->query($sql);
	
		$data = array();
		foreach ($query->result() as $row) {
			$data = array(
				'id' => $row->id,
				'first_name' => $row->first_name,
				'last_name' => $row->last_name,
				'email' => $row->mail,
				'description' => $row->description,
				'state' => $row->state,
				'banner' => $row->banner,
				'photo' => $row->photo
			);
		}
		
		for ($i=0; $i<count($data); $i++) {
		    $sql = "SELECT * FROM upload_files WHERE id='" . $data[$i]['photo'] . "'";
    	    $query = $this->db->query($sql);
    	    
    	    foreach ($query->result() as $row) {
    			$data[$i]['photo'] = $row->url;
    		}
    		
    		$sql = "SELECT * FROM upload_files WHERE id='".$data[$i]['banner']."'";
    	    $query = $this->db->query($sql);
    	    
    	    foreach ($query->result() as $row) {
    			$data[$i]['banner'] = $row->url;
    		}
		}
		
		return $data;
 	}
 	
 	function getGroupFriendByID($gid) {
 		
 		$sql = "SELECT 
				a.id, a.state, 
				IF(b.first_name IS NULL, '', b.first_name) as first_name, 
				IF(b.last_name IS NULL, '', b.last_name) as last_name, 
				IF(b.mail IS NULL, '', b.mail) as mail, 
				IF(b.description IS NULL, '', b.description) as description, 
				IF(b.banner IS NULL, '', b.banner) as banner, 
				IF(b.photo IS NULL, '', b.photo) as photo
			FROM group_friend AS a 
				LEFT JOIN user AS b 
				ON a.uid=b.id 
			WHERE a.gid=" . $gid;
						
		$query = $this->db->query($sql);
	
		$data = array();
		foreach ($query->result() as $row) {
			$data[] = array(
				'id' => $row->id,
				'first_name' => $row->first_name,
				'last_name' => $row->last_name,
				'email' => $row->mail,
				'description' => $row->description,
				'state' => $row->state,
				'banner' => $row->banner,
				'photo' => $row->photo
			);
		}
		
		for ($i=0; $i<count($data); $i++) {
		    $sql = "SELECT * FROM upload_files WHERE id='" . $data[$i]['photo'] . "'";
    	    $query = $this->db->query($sql);
    	    
    	    foreach ($query->result() as $row) {
    			$data[$i]['photo'] = $row->url;
    		}
    		
    		$sql = "SELECT * FROM upload_files WHERE id='".$data[$i]['banner']."'";
    	    $query = $this->db->query($sql);
    	    
    	    foreach ($query->result() as $row) {
    			$data[$i]['banner'] = $row->url;
    		}
		}
		
		return $data;
 	}
 	
 	function getGroupIdByGroupFriendId($group_friend_id) {
 		$sql = "SELECT * FROM group_friend WHERE id=" . $group_friend_id;
						
		$query = $this->db->query($sql);
	
		$data = "-1";
		foreach ($query->result() as $row) {
			$data = $row->gid;
		}
		
		return $data;
 	}

 	/************** tb : friend ***************/

 	function addFriend($uid, $fid) {
 		$create_time = time();
		$this->db->set('uid', $uid);
		$this->db->set('fid', $fid);
		$this->db->set('reg_date', $create_time);
		$this->db->insert('friend'); 
 	}
 	
 	function setFriendState($id, $state) {
 		$this->db->set('state', $state);
 		$this->db->where('id', $id);
 		$this->db->update('friend');
 	}
 	
 	function setFriendAccept($request_id, $request_uid, $response_uid) {
 		$create_time = time();
 		$this->db->set('uid', $request_uid);
 		$this->db->set('fid', $response_uid);
 		$this->db->set('reg_date', $create_time);
 		$this->db->insert('friend');
 		
 		$this->db->set('state', '1');
 		$this->db->where('id', $request_id);
 		$this->db->where('response_id', $response_uid);
 		$this->db->update('activity');
 	}
 	
 	function setFriendDecline($activity_id, $response_id) {
 		$this->db->set('state', '2');
 		$this->db->where('id', $activity_id);
 		$this->db->where('response_id', $response_id);
 		$this->db->update('activity');
 	}
 	
 	function removeFriend($id) {
 		$this->db->where('id', $id);
 		$this->db->delete('friend');
 	}
 	
 	function getFriendList($uid, $s_name="") {
 		
 		$sql = "SELECT 
				b.id,  b.first_name, b.last_name, b.mail, b.description, b.banner, b.photo
			FROM friend AS a 
				LEFT JOIN user AS b 
				ON a.fid=b.id 
			WHERE a.uid=" . $uid;
			
		if ($s_name != '') {
			$sql .= " AND (b.first_name REGEXP '" . $s_name . "' OR b.last_name REGEXP '" . $s_name . "')";
		}
						
		$query = $this->db->query($sql);
	
		$data = array();
		foreach ($query->result() as $row) {
			$data[] = array(
				'id' => $row->id,
				'first_name' => $row->first_name,
				'last_name' => $row->last_name,
				'email' => $row->mail,
				'description' => $row->description,
				'banner' => $row->banner,
				'photo' => $row->photo
			);
		}
		
		$sql = "SELECT 
				b.id,  b.first_name, b.last_name, b.mail, b.description, b.banner, b.photo
			FROM friend AS a 
				LEFT JOIN user AS b 
				ON a.uid=b.id 
			WHERE a.fid=" . $uid;
			
		if ($s_name != '') {
			$sql .= " AND (b.first_name REGEXP '" . $s_name . "' OR b.last_name REGEXP '" . $s_name . "')";
		}
						
		$query = $this->db->query($sql);
	
		foreach ($query->result() as $row) {
			$data[] = array(
				'id' => $row->id,
				'first_name' => $row->first_name,
				'last_name' => $row->last_name,
				'email' => $row->mail,
				'description' => $row->description,
				'banner' => $row->banner,
				'photo' => $row->photo
			);
		}
		
		for ($i=0; $i<count($data); $i++) {
		    $sql = "SELECT * FROM upload_files WHERE id='" . $data[$i]['photo'] . "'";
    	    $query = $this->db->query($sql);
    	    
    	    foreach ($query->result() as $row) {
    			$data[$i]['photo'] = $row->url;
    		}
    		
    		$sql = "SELECT * FROM upload_files WHERE id='".$data[$i]['banner']."'";
    	    $query = $this->db->query($sql);
    	    
    	    foreach ($query->result() as $row) {
    			$data[$i]['banner'] = $row->url;
    		}
		}
		
		return $data;
 	}
 	
 	function isExistFriend($uid, $fid) {
		$sql = "SELECT id FROM friend WHERE uid=".$uid." AND fid=".$fid;
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows()>0) {
			return true;
		} else {
			return false;
		}
	}
	
	/***** tb : activity *****/
	
	function setActivity($type=0, $request_id, $response_id, $state=0, $action_id=-1) {
		$create_time = time();
		$this->db->set('type', $type);
		$this->db->set('action_id', $action_id);
		$this->db->set('request_id', $request_id);
		$this->db->set('response_id', $response_id);
		$this->db->set('reg_date', $create_time);
		$this->db->set('state', $state);
		$this->db->insert('activity');
	}
	
	function getActivityList($uid) {
		$this->db->select('*');
		$this->db->where('response_id', $uid);
		
		$query = $this->db->get('activity');
		
		$data = array();
		foreach ($query->result() as $row) {
			$data[] = array(
				'id' => $row->id,
				'action_id' => $row->action_id,
				'request_id' => $row->request_id,
				'response_id' => $row->response_id,
				'state' => $row->state,
				'reg_date' => $row->reg_date,
				'type' => $row->type
			);
		}
		
		return $data;
	}
	
	function getRequestIdInActivty($activity_id) {
		$this->db->select('*');
		$this->db->where('id', $activity_id);
		
		$query = $this->db->get('activity');
		
		$data = "-1";
		foreach ($query->result() as $row) {
			$data = $row->request_id;
		}
		
		return $data;
	}
	
	/***** tb : community *****/
	
	function getCommunityList($uid) {
	    $sql = "SELECT 
                	* 
                FROM 
                	(SELECT DISTINCT(gid) FROM group_friend WHERE uid='".$uid."') AS a
                LEFT JOIN community AS b
                	ON a.gid = b.gid";
                	
		$query = $this->db->query($sql);
		
		$data = array();
		foreach ($query->result() as $row) {
			$data[] = array(
				'id' => is_null($row->id) ? '' : $row->id,
				'gid' => is_null($row->gid) ? '' : $row->gid,
				'uid' => is_null($row->uid) ? '' : $row->uid,
				'content' => is_null($row->content) ? '' : $row->content,
				'type' => is_null($row->type) ? '' : $row->type
			);
		}
		
		return $data;
	}
	
	function setCommunity($gid, $uid, $content, $type=0) {
	    $this->db->set('gid', $gid);
	    $this->db->set('uid', $uid);
	    $this->db->set('content', $content);
	    $this->db->set('type', $type);
		$this->db->insert('community');
	}
	
	/***** tb : comments *****/
	
	function getCommentsList($community_id) {
	    $this->db->select('*');
		$this->db->where('cid', $community_id);
		
		$query = $this->db->get('community');
		
		$data = array();
		foreach ($query->result() as $row) {
			$data[] = array(
				'id' => $row->id,
				'community_id' => $row->cid,
				'uid' => $row->uid,
				'content' => $row->content
			);
		}
		
		return $data;
	}
	
	function setComments($uid, $community_id, $content) {
	    $this->db->set('cid', $community_id);
	    $this->db->set('uid', $uid);
	    $this->db->set('content', $content);
	    $this->db->insert('comments');
	}
	
	/***** tb : like *****/
	
	function getLike($uid, $community_id) {
	    $sql = "SELECT value FROM like WHERE uid='".$uid."' AND cid='".$community_id."' LIMIT 1";
		$query = $this->db->query($sql);
		
		$result = 0;
		foreach ($query->result() as $row) {
			$result = $row->value;
		}
		
		return $result;
	}
	
	function setLike($uid, $community_id, $value=0) {
	    $this->db->set('cid', $community_id);
	    $this->db->set('uid', $uid);
	    $this->db->set('value', $value);
	    $this->db->insert('like');
	}

} ?>

