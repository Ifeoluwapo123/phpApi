<?php
	define('DB_HOST', 'localhost'); 
	define('DB_USER', 'root'); 
	define('DB_PASSWORD', ''); 
	define('DB_DATABASE', 'php_api');

	class User{

		private $mMysqli;
 
		function __construct(){      
			$this->mMysqli = new mysqli(DB_HOST, 
										DB_USER, 
										DB_PASSWORD, 
										DB_DATABASE
									    );    
		}

		function __destruct(){
			$this->mMysqli->close(); 
		}

		public function registeredUsers($name, $email, $password){
			$query = $this->mMysqli->query("INSERT INTO users (name,email,password) VALUES ('$name','$email','$password')");
			if($query){
				return "successfull";
			}else{
				return "not successfull";
			}
		}

		public function getUser($id){
			$query = $this->mMysqli->query("SELECT id, name, email FROM users WHERE id = ".$id);

			$rows = $query->fetch_all(MYSQLI_ASSOC);
			if($rows == []){
				return "empty";
			}
	    	return json_encode($rows);
		}

		public function retrieveUsers(){
			$query = $this->mMysqli->query("SELECT id, name, email FROM users");
	    	$rows = $query->fetch_all(MYSQLI_ASSOC);

	    	return json_encode($rows);
		}

		public function retrieveProducts(){
			$query = $this->mMysqli->query("SELECT * FROM products");
	    	$rows = $query->fetch_all(MYSQLI_ASSOC);

	    	return json_encode($rows);
		}

		public function retrievePostedProducts(){
			$query = $this->mMysqli->query("SELECT * FROM phone_post");
	    	$rows = $query->fetch_all(MYSQLI_ASSOC);

	    	$que = $this->mMysqli->query("SELECT * FROM system");
	    	$row = $que->fetch_all(MYSQLI_ASSOC);

	    	$array = array('phones' => $rows,
	    	               'systems'=> $row);
	    	return json_encode($array);
		}


		public function validateEmail($value){
		    return (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i', $value)) ? 0 : 1;    
		}

		public function validatePassword($value){
			return (strlen($value) > 5)? 1 : 0;
		}

		public function updatePassword($pass, $email){
			if(!$this->validatePassword($pass)) return "error pass";

			$sel = $this->mMysqli->query("SELECT email FROM users WHERE email = '".$email."'");
			$result = $sel->fetch_row();
			if($result == null) return "invalid email";

			$pass = password_hash($pass, PASSWORD_DEFAULT);

			$query = $this->mMysqli->query("UPDATE users SET password = '$pass' WHERE email ='$email'");
			if($query) return "successfully updated";
			else return "Not successful";
		}

		public function updateName($name, $email){

			$sel = $this->mMysqli->query("SELECT email FROM users WHERE email = '".$email."'");
			$result = $sel->fetch_row();
			if($result == null) return "invalid email";

			$query = $this->mMysqli->query("UPDATE users SET name = '$name' WHERE email ='$email'");
			if($query) return "successfully updated";
			else return "Not successful";
		}

		public function usersLogin($pass, $email){
			$query = $this->mMysqli->query("SELECT id, password FROM users WHERE email ='".$email."'");
			$rows = $query->fetch_row();
		
			if($rows !== null) {
				$password = $rows[1];
				$user_id = $rows[0];
				$res = password_verify($pass, $password);
				$arr = array('status' => 'success',
			                 'user_id' => $user_id);
				if($res) return json_encode($arr);
				else return "error";
			}else{
				return "record not found";
			}
		}

		public function deleteUser($value){
			$result = $this->getUser($value);

			if($result == "empty"){
				return "empty";
			}else{
				$query = $this->mMysqli->query('DELETE FROM users WHERE id="'.$value.'"');
				return $result;
			}
		}
	} 
?>

