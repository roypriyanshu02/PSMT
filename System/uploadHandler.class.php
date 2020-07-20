<?php

class uploadHandler {
	
	private $file;
	private $targetFile;
	private $FileInfo;
	private $Status;
	private $Error;
	public $result;
	# Settings
	function __construct($settings) {
		$this->targetDir = ".Temp/";
		# Formants
		$this->FileAllow = $settings;
		$this->randname = date("ymdHis").substr(md5(rand(100000, 999999)),12,4);
	}

	# Main function to run.
	public function run($file) {
		$this->file = $file;
		if (is_array($file)) {
			$this->targetFile = $this->targetDir . basename($file['name']);
		}
		else {
			$this->targetFile = $this->targetDir . basename($file);
			$data = file_get_contents($file);
			$tmp_dir = tempnam(ini_get('upload_tmp_dir') ? ini_get('upload_tmp_dir') : sys_get_temp_dir(),'php');
			file_put_contents($tmp_dir, $data);
			$this->file = array(
				'name' => basename($file), 
				'type' => pathinfo($tmp_dir,PATHINFO_EXTENSION),
				'tmp_name' => $tmp_dir,
				'error' => 0,
				'size' => filesize($tmp_dir)
			);
		}
		
		# Calling
		$this->_verfiy();
		$this->_upload();
	}
	# File Type & Size verfiyer.
	private function _verfiy() {
		$GFileType = strtolower(pathinfo($this->targetFile,PATHINFO_EXTENSION));
		$FileSize = $this->file["size"];
		$FileInfo=NULL;$error = "Sorry, your $GFileType file not support";$status = "error";
		foreach ($this->FileAllow as $key => $value) {
			if ( in_array($GFileType, $value['extensions']) ) {
				if ( ($FileSize>=$value['minsize']) && ($FileSize<=$value['maxsize']) ) {
					$FileInfo = $value;
					$FileInfo['name'] = $key.$this->randname.'.'.$GFileType;
					$FileInfo['size'] = $FileSize;
					$status = "success";
					$Error = NULL;
					unset($FileInfo['minsize']);
					unset($FileInfo['maxsize']);
					unset($FileInfo['extensions']);
				}
				elseif ( $FileSize>=$value['minsize'] ) {
					$error = "Sorry, your {$value['type']} is too large.";
					$status = "error";
				}
				else {
					$error = "Sorry, your {$value['type']} is too small.";
					$status = "error";
				}
				break;
			}
		}
		$this->FileInfo = $FileInfo;
		$this->Status = $status;
		$this->Error = $error;
	}

	# Uploading to dir and result value
	private function _upload() {
		if ($this->Status=="success") {
			if (!file_exists($this->FileInfo['directory'])) {
				mkdir($this->FileInfo['directory']);
				chmod($this->FileInfo['directory'], 0777);
			}
			$this->targetFile = $this->FileInfo['directory'].$this->FileInfo['name'];
			if (move_uploaded_file($this->file["tmp_name"], $this->targetFile) || rename($this->file["tmp_name"], $this->targetFile)) {
				chmod($this->targetFile, 0777);
				$this->result = array(
					'status' => $this->Status,
					'oldFileName' => $this->file['name'],
					'fileName' => $this->FileInfo['name'],
					'fileType' => $this->FileInfo['type'],
					'fileSize' => $this->FileInfo['size'],
					'location' => $this->targetFile
				);
			}
		}
		else {
			$this->Status = "error";
			$this->result = array('status' => $this->Status, 'error' => $this->Error, 'oldFileName' => $this->file['name']);
		}
	}

}