<?php
	require_once('../database.php');
	$user = new User();

	$status = array('status' => '');

	$name = $_POST['name'];
	$email = $_POST['email'];
	$password = $_POST['password'];

	$validemail = $user->validateEmail($email);
	$validpassword = $user->validatePassword($password);
	
	$pass = password_hash($password, PASSWORD_DEFAULT);

	if(empty($name) || empty($email) || empty($password)){
		$status['status'] = 'input field cannot be empty';
	    print_r(json_encode($status));
	    return;
	}else if(!$validemail){
		$status['status'] ='invalid Email';
	    print_r(json_encode($status));
	    return;
	}else if(!$validpassword){
		$status['status'] = 'password requires at least 6 characters';
	    print_r(json_encode($status));
	    return;
	}else{
		$result = $user->registeredUsers($name, $email, $pass);

		if($result == "successfull"){
			$newUser = array('name' => $name,
						 'email'=> $email);
		    print_r(json_encode($newUser));
		}else{
			$status['status'] = '500';
	    	print_r(json_encode($status));
		}
		
	}
?>