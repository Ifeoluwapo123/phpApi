<?php
	require_once('..update/database.php');
	$user = new User(); 
	$err = array('error' => '');

    $email = $_POST['email'];
    $newPass = $_POST['password'];
    if(empty($email) || empty($newPass)){
    	$err['error'] = 'input field cannot be empty';
	    print_r(json_encode($err));
	    return;
    }  

    $result = $user->updatePassword($newPass, $email);

    if($result == 'error pass'){
    	$err['error'] = 'Requires at least 6 characters';
	    print_r(json_encode($err));
	    return;
    }else if($result == 'invalid email'){
    	$err['error'] = $result;
	    print_r(json_encode($err));
	    return;
    }else if($result == 'successfully updated'){
    	$success = array('status' => $result);
    	print_r(json_encode($success));
	    return;
    }else if($result == 'Not successful'){
    	$err['error'] = '505';
    	print_r(json_encode($err));
	    return;
    }  
?>