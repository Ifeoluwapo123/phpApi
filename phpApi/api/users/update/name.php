<?php
	require_once('../../database.php');
	$user = new User(); 
	$err = array('error' => '');

    $email = $_POST['email'];
    $new_name = $_POST['name'];
    if(empty($email) || empty($new_name)){
        $err['error'] = 'input field cannot be empty';
        print_r(json_encode($err));
        return;
    }  

    $result = $user->updateName($new_name, $email);

    if($result == 'invalid email'){
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