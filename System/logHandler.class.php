<?php

class logHandler {
	/* Var */
		private $display = NULL;

	/* Settings */

	function __construct($settings) {
		$this->settings = $settings;
	}

	/* Log functions */

		# Creating log
		public function create($type,$method,$messages,$return=NULL) {
			# Log File
			$file = $this->settings['file'];
			if (!file_exists($file)) {touch($file);file_put_contents($file, '{}');}
			if (@$this->settings['type_log'][$type]!==true || @$this->settings['method_log'][$method]!==true) {die();}
			# Generate
			$logen = array('Type' => $type, 'DateTime' => date("Y-m-d H:i:s"), 'IPaddress' => $_SERVER['REMOTE_ADDR'], 'Method' => $method, 'Message' => $messages);
			# Saving
			if ($this->settings['save']==true) {
				$inp = file_get_contents($file);
				$tempArray = json_decode($inp,true);
				array_push($tempArray, $logen);
				$jsonData = json_encode($tempArray);
				file_put_contents($file, $jsonData);
			}
			# Displaying
			if ($this->settings['display']==true) {
				$logen['Return'] = $return;
				$this->display[] = $logen;
			}
			else { $this->display[] = $return; }
		}

		# Read log file
		public function read($auto=NULL) {
			# Log File
			$file = $this->settings['file'];
			# Reading
			$inp = file_get_contents($file);
			if ($auto==NULL && $auto=="") {
				print_r($inp);
			}
			else {
				return $inp;
			}
		}

		# Clear log file
		public function clear($con=0) {
			if ($con==1) {
				# Log File
				$file = $this->settings['file'];
				# Clear
				file_put_contents($file, '{}');
				$this->create('Log','log_clear()','Logs were cleared.');
			}
			else { $this->create('Warning','log_clear()',"Forgot to give permission!"); }
		}
		public function __destruct() {
			if ($this->display!==NULL && $this->display!=="") {
				print_r(json_encode($this->display));
			}
		}
}