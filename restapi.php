<?php

/* STMP main class */
require_once getcwd() . '/' . "fileHandler.php";
require_once getcwd() . '/' . "PSMT.php";
@include_once getcwd() . '/' . "authorization.php";

/* Requests */
	$requests = $_REQUEST;

/* Authorization */
function authorization($authlevel) {
	if (defined('Authorization')) {
		if (!isset($_SERVER['PHP_AUTH_USER'])) {
	    	header('WWW-Authenticate: Basic realm="Anplay Application"');
	    	header('HTTP/1.0 401 Unauthorized');
	    	$message = 'Please set Basic Authorization.';
	    	$PSMT = new PSMT;
	    	$PSMT->log->create('warning','api()', $message);
	    	exit();
		}
		else {
			$user = isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : '';
			$pass = isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : '';
			$pass = md5($pass);
			$PSMT = new PSMT;
			foreach (Authorization as $keys) {
				if ($keys['user']==$user && $keys['password']==$pass) {
					$status = true;
					$level = $keys['authlevel'];
					break;
				}
				elseif ($keys['user']==$user) {
					$status = false;
					$error = 'wrong password';
					break;
				}
				else {
					$status = false;
					$error = 'wrong user & password';
				}
			}
			if ( $status == false) {
				header('WWW-Authenticate: Basic realm="Anplay Application"');
	    		header('HTTP/1.0 401 Unauthorized');
	    		$PSMT->log->create('warning','api()', 'Entered '.$error);
				exit();
			}
			if ($level>=$authlevel) {
				return true;
			}
			else {
				
				$PSMT->log->create('warning','api()', 'Not permitted for this method.');
				die();
				return false;
			}
		}
	}
}


/* GET */
	if ($_SERVER['REQUEST_METHOD']=="GET") {
		if ( isset($requests['file']) && !empty($requests['file']) ) {
			if ( isset($requests['download']) ) {
				$PSMT = new PSMT;
				$PSMT->download($requests['file']);
			}
			elseif ( isset($requests['properties']) ) {
				$PSMT = new PSMT;
				$PSMT->read($requests['file'],1);
			}
			else {
				$PSMT = new PSMT;
				$PSMT->read($requests['file']);
			}
		}
		elseif ( isset($requests['ls']) && !empty($requests['ls']) ) {
			authorization(1);
			$fileHandler = new fileHandler;
			$fileHandler->ls($requests['ls']);
		}
		elseif ( isset($requests['check_file']) && !empty($requests['check_file']) ) {
			authorization(1);
			$fileHandler = new fileHandler;
			$fileHandler->check_file($requests['check_file']);
		}
		elseif ( isset($requests['log_read']) ) {
			authorization(1);
			$PSMT = new PSMT;
			$PSMT->log->read();
		}
		else {
			http_response_code(400);
			echo json_encode(array('status' => 'error', 'message' => 'This API request not available.'));
		}

	}

/* POST */

	// Put methods
	elseif ( $_SERVER['REQUEST_METHOD']=="POST" ) {
		if ( isset($_REQUEST['put']) ) {
			authorization(2);
			if (isset($_FILES['file']) || isset($_POST['file'])) {
				if (isset($_FILES['file'])) {
					$PSMT = new PSMT;
					$PSMT->upload($_FILES['file']);
				}
				elseif (!empty($_POST['file'])) {
					$PSMT = new PSMT;
					$PSMT->upload($_POST['file']);
				}
			}
			elseif ( isset($requests['create']) && !empty($requests['create']) ) {
				$fileHandler = new fileHandler;
				$fileHandler->create($requests['create'],@$requests['fill']? $requests['fill'] : NULL,@$requests['chmod']? $requests['chmod'] : 0777);
			}
			else {
				http_response_code(400);
				echo json_encode(array('status' => 'error', 'message' => 'This API request not available.'));
			}
		}

		// Patch methods
		elseif ( isset($_REQUEST['patch']) ) {
			authorization(2);
			if ( isset($requests['transcode']) && ( isset($requests['file']) && !empty($requests['file']) ) ) {
				$PSMT = new PSMT;
				$PSMT->transcode($requests['file']);
			}
			elseif ( isset($requests['write']) && !empty($requests['write']) ) {
				$fileHandler = new fileHandler;
				$fileHandler->write($requests['write'],$requests['fill'],@$requests['mode']? $requests['mode'] : 'a');
			}
			elseif ( ( isset($requests['cp']) && !empty($requests['cp']) )  && ( isset($requests['dst']) && !empty($requests['dst']) ) ) {
				$fileHandler = new fileHandler;
				$fileHandler->cp($requests['cp'],$requests['dst']);
			}
			elseif ( ( isset($requests['mv']) && !empty($requests['mv']) )  && ( isset($requests['dst']) && !empty($requests['dst']) ) ) {
				$fileHandler = new fileHandler;
				$fileHandler->mv($requests['mv'],$requests['dst']);
			}
			elseif ( ( isset($requests['chmod']) && !empty($requests['chmod']) ) && ( isset($requests['file']) && !empty($requests['file']) ) ) {
				$fileHandler = new fileHandler;
				$fileHandler->chmod($requests['chmod'],$requests['file'],1);
			}
			else {
				http_response_code(400);
				echo json_encode(array('status' => 'error', 'message' => 'This API request not available.'));
			}
		}

		// Delete methods
		elseif ( isset($_REQUEST['delete']) ) {
			authorization(3);
			if (@strtolower($requests['confirm'])=='y' || @strtolower($requests['confirm'])==1) {
				$fileHandler = new fileHandler;
				if ( isset($requests['rm']) && !empty($requests['rm']) ) {
					$fileHandler->rm($requests['rm'],1);
				}
				elseif ( isset($requests['rmdir']) && !empty($requests['rmdir']) ) {
					$fileHandler->rmdir($requests['rmdir'],1);
				}
				elseif ( isset($requests['clear_temp']) ) {
					$fileHandler->clear_temp();
				}
				elseif ( isset($requests['log_clear']) ) {
					$PSMT = new PSMT;
					$PSMT->log->clear(1);
				}
			}
			else {
				http_response_code(400);
				echo json_encode(array('status' => 'error', 'message' => 'This API request not available.'));
			}
		}
		else {
			http_response_code(400);
			echo json_encode(array('status' => 'error', 'message' => 'This API request not available.'));
		}
	}
	else {
		http_response_code(400);
		echo json_encode(array('status' => 'error', 'message' => 'This Method not available. Please try GET/POST method.'));
	}