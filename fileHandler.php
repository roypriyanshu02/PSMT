<?php

/* Required Modules */
require_once 'config.php';
require_once "System/logHandler.class.php";

class fileHandler {

	function __construct(){
		$config = new Config;
		$this->identifier = $config->identifier;
		$this->log = new logHandler($config->log);
	}

	# Totol List of a type directory or all directorys
	public function ls($type) {
		if ( array_key_exists($type[0],$this->identifier) ) {
			$list = scandir($this->identifier[$type[0]]['directory']);
		}
		else {
			foreach ($this->identifier as $value) {
				$list[$value['directory']] = scandir($value['directory']);
			}
		}
		print_r(json_encode($list));
	}
	# Create file or directory
		public function create($file,$fill=NULL,$chmod=0777) {
			if (file_exists($file)) {
				$this->log->create('warning','create()',"$file already exists!");exit();
			}
			strpos($file, ".");
			if (strpos($file, ".") == false) {
				if (mkdir(getcwd().'/'.$file)) {
					chmod(getcwd().'/'.$file, $chmod);
					$this->log->create('log','create()',"$file Created successfully.");
				}
				else {
					$this->log->create('error','create()',"Unable to create $file!");
				}
			}
			else {
				if (touch(getcwd().'/'.$file)) {
					chmod(getcwd().'/'.$file, $chmod);
					$this->log->create('log','create()',"$file Created successfully.");
					if ($fill!==NULL) {
						$this->write($file,$fill,'w');
					}
				}
				else {
					$this->log->create('error','create()',"Unable to create $file!");
				}
			}

		}
		# Write
		public function write($file,$values,$mode='a') {
			$filed = $this->check_file($file,1);
			if ($filed['writeable']==false) {$this->log->create('warning','check_file()',"$file is not writable.");die();}
			if ($thatfile = fopen( $filed['file_path'], $mode )) {
				fwrite($thatfile, $values);
				fclose($thatfile);
				$this->log->create('log','write()',"$file Write successfully.");
			}
			else {
				$this->log->create('warning','write()',"Unable to write $file!");
			}
			
		}

		# Move
		public function mv($src,$dst) {
			$filed = $this->check_file($src,1);
			if ($filed['writeable']==false) {$this->log->create('warning','check_file()',"$src is not writable.");die();}
			if ($filed['executable']==false) {$this->log->create('warning','check_file()',"$src is not executable.");die();}
			if ( @rename($filed['file_path'],getcwd().'/'.$dst) ) {
				$this->log->create('log','mv()',"$src Moved successfully to $dst.");
			}
			else {
				$this->log->create('error','mv()',"$src failed move to $dst!");
			}
		}

		# Copy
		public function cp($src,$dst) {
			$filed = $this->check_file($src,1);
			if ($filed['readable']==false) {$this->log->create('warning','check_file()',"$src is not readable.");die();}
			if ($filed['writeable']==false) {$this->log->create('warning','check_file()',"$src is not writable.");die();}

			if (file_exists($src)) {
				if (strpos($src, ".") == false) {
					$dir = opendir($src); 
					@mkdir($dst); 
					while(false !== ( $file = readdir($dir)) ) { 
					    if (( $file != '.' ) && ( $file != '..' )) { 
					    	if ( is_dir($src . '/' . $file) ) { 
					    		$this->cp($src . '/' . $file,$dst . '/' . $file); 
					    	} 
					    	else { 
					    		copy($src . '/' . $file,getcwd().'/'.$dst . '/' . $file);
					    	} 
					    } 
					} 
					closedir($dir);
					$this->log->create('log','cp()',"$src Copied successfully to $dst.");
				}
				else {
					if (copy(getcwd().'/'.$src,getcwd().'/'.$dst)) {
						$this->log->create('log','cp()',"$src Copied successfully to $dst.");
					}
					else {
						$this->log->create('error','cp()',"$src failed copy to $dst!");
					}
				}
			}
			elseif ( array_key_exists($src[0],$this->identifier) ) {
				if ( @copy($this->identifier[$src[0]]['directory'].$src,getcwd().'/'.$dst) ) {
					$this->log->create('log','cp()',"$src - ".$this->identifier[$src[0]]['type']." Copied successfully to $dst.");
				}
				else {
					$this->log->create('error','cp()',"$src - ".$this->identifier[$src[0]]['type']." failed copy to $dst!");
				}
			}
			else {
				$this->log->create('warning','cp()',"$src Not found!");
			}
		}

	// Execute functions
		# Rm
		public function rm($file,$con=0) {
			if ($con===1 || $con==='Y' || $con==='y') {
				$filed = $this->check_file($file,1);
				if ($filed['executable']==false) {$this->log->create('warning','check_file()',"$file is not executable.");die();}
				if ( @unlink($filed['file_path']) ) {
					$this->log->create('log','rm()',"$file deleted successfully.");
				}
				else {
					$this->log->create('warning','rm()',"$file failed to deleted!");
				}
			}
			else {
				$this->log->create('warning','rm()',"Forgot to give permission!");
			}
		}
		# Rmdir
		public function rmdir($directory,$con=0) {
			if ($con===1 || $con==='Y' || $con==='y') {
				$directoryd = $this->check_file($directory,1);
				if ($directoryd['executable']==false) {$this->log->create('warning','check_file()',"$directory is not executable.");die();}
				if (file_exists($directory)) {
					$files = glob($directory.'/*');
					foreach($files as $file){
						if(is_file($file))
						unlink($file);
					}
					if (rmdir($directory)) {
						$this->log->create('log','rmdir()',"$directory directory deleted successfully.");
					}
				}
				else {
					$this->log->create('warning','rmdir()',"$directory directory not found.");
				}
			}
			else {
				$this->log->create('warning','rmdir()',"Forgot to give permission.");
			}
		}

		public function clear_temp() {
			$files = glob('.Temp/*');
			foreach($files as $file){
				if(is_file($file)){
					unlink($file);
				}
			}
			$this->log->create('log','clear_temp()',"Temp cleared successfully.");
		}

	// Permissions & Onwership functions

		# Check permission & define file path
		public function check_file($file,$auto=NULL) {
			if (file_exists($file)) { 
				$file = getcwd().'/'.$file;
			}
			elseif ( array_key_exists($file[0],$this->identifier) ) {
				$file = $this->identifier[$file[0]]['directory'].$file;
			}
			else {
				$this->log->create('warning','check_file()',"$file not found.");die();
			}
			$result = array(
				'file_path' => $file,
				'file_exist' => file_exists($file),
				'readable' => is_readable($file),
				'writeable' => is_writable($file),
				'executable' => is_executable($file)
			);
			if ($auto==NULL && $auto=="") {
				print_r(json_encode($result));
			}
			else {
				return $result;
			}
		}
		# Chmod
		public function chmod($file,$chmod,$con=0) {
			if ( !is_int($chmod) ) {
				$this->log->create('error','chmod()',"Chmod value must be int.");
			}
		 	else {
			 	if ($con===1 || $con==='Y' || $con==='y') {
			 		if ( ( ($file[0] == '/') || (substr($file,-1) == '/') ) ) {
			 			if (file_exists($file)) {
			 				if (@chmod($file,$chmod)) {
			 					$this->log->create('log','chmod()',"$file $chmod chmod successfully.");
			 				}
			 				else {
			 					$this->log->create('error','chmod()',"$file failed to chmod.");
			 				}
						}
						else {
							$this->log->create('warning','chmod()',"$file directory not found.");
						}
			 		}
			 		else {
			 			if ( array_key_exists($file[0],$this->identifier) ) {
			 				if ( file_exists($this->identifier[$file[0]]['directory'].$file) ) {
			 					if (chmod($this->identifier[$file[0]]['directory'].$file,$chmod)) {
			 						$this->log->create('log','chmod()',"$file - ".$this->identifier[$file[0]]['type']." $chmod chmod successfully.");
			 					}
			 					else {
			 						$this->log->create('error','chmod()',"$file - ".$this->identifier[$file[0]]['type']." failed to chmod.");
			 					}
			 				}
			 				else {
			 					$this->log->create('warning','chmod()',"$file - ".$this->identifier[$file[0]]['type']." Not found.");
			 				}
			 			}
			 			else {
			 				$this->log->create('warning','chmod()',"Identifier not found.");
			 			}
			 		}
			 	}
			 	else {
			 		$this->log->create('warning','chmod()',"Forgot to give permission.");
			 	}
			}
		}
}