<?php
	require_once('../database.php');
	$user = new User(); 

    if(isset($_GET['id'])){
    	$id = $_GET['id'];
    	if($id != ''){
    		$result = $user->getUser($id);
    		if($result == "empty"){
    			$emp = array('status' => '404');
    			print_r(json_encode($emp));
    		}else{
    			print_r($result);
    		} 
    	}else{
            $emp = array('status' => '404');
                print_r(json_encode($emp));
        }
    	exit();
    }
    
    $data = $user->retrievePostedProducts();
    print_r($data);
?>