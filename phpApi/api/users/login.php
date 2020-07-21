<?php
	require_once('../database.php');
	$user = new User(); 
	$status = array('loginStatus' => '');

    $email = $_POST['email'];
    $password = $_POST['password'];

    if(empty($email) || empty($password)){
        $status['loginStatus'] = 'input field cannot be empty';
        print_r(json_encode($status));
        return;
    }  

    $result = $user->usersLogin($password, $email); 
	    
    if($result == 'error'){
    	$status['loginStatus'] = 'incorrect Password';
    	print_r(json_encode($status));
	    return;
    }else if($result == 'record not found'){
    	$status['loginStatus'] = 'invalid Email';
    	print_r(json_encode($status));
	    return;
    }else{
        print_r(($result));
        return;
    }
?>