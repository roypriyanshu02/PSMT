<?php

/* Required Modules */

require_once 'config.php';
spl_autoload_register(function ($classname) {
	require_once 'System/' . $classname . '.class.php';
});

/* Main Class */

class PSMT {

	/* Config */

	function __construct() {
		$this->config = new Config;
		$this->log = new logHandler($this->config->log);
	}
	
	/* Read functions */

		# Read, Render or Properties
		public function read($file,$properties=NULL) {
			$identifier = $this->config->identifier[$file[0]];
			if ( array_key_exists($file[0],$this->config->identifier) ) {
				if ( ($properties!==NULL && $properties!=='') && ($properties!==false && $properties!==0) ) {
					$properties = new propertiesRead($identifier['directory'].$file);
					print_r(json_encode($properties->result));
				}
				elseif ($identifier['type']=="image") {
					new imageRead($identifier['directory'].$file);
				}
				elseif ($identifier['type']=="video") {
					new videoRead($identifier['directory'].$file);
				}
				elseif ($identifier['type']=="audio") {
					new audioRead($identifier['directory'].$file);
				}
				elseif ($identifier['type']=="document") {
					new documentRead($identifier['directory'].$file);
				}
				else {
					new otherRead($identifier['directory'].$file);
				}
			}
			else {
				$this->log->create('warning','read()', $file[0]." Invalid identifier.");
			}
		}
		# Download
		public function download($file) {
			$identifier = $this->config->identifier[$file[0]];
			new downloadRead($identifier['directory'].$file);
		}

	/* Write functions */

		# Upload
		public function upload($file) {
			$uploadHandler = new uploadHandler($this->config->identifier);
			$uploadHandler->run($file);
			$result = $uploadHandler->result;
			if ($result['status']=='success') {
				$this->log->create('log','upload()',$result['oldFileName']." uploaded successfully. New Path : ".$result['location'],$result);
				$this->transcode($result['fileName'],1);
			}
			else {
				$this->log->create('error','upload()',$result['oldFileName']." unable to upload. Error : ".$result['error']);
			}
		}

		# Transcode
		public function transcode($file,$auto=NULL) {
			$identifier = $this->config->identifier[$file[0]];
			if ( array_key_exists($file[0],$this->config->identifier) ) {
				if ($identifier['type']=="image") {
					if ($this->config->imageTranscoder['enable']==true) {
						$Processor = new imageProcessor($this->config->imageTranscoder);
						$Processor->run($identifier['directory'].$file);
					}
					elseif ($auto==NULL && $auto=="") {
						$this->log->create('warning','transcode()', "imageTranscoder isn't enable.");die();
					}
				}
				elseif ($identifier['type']=="video") {
					if ($this->config->videoTranscoder['enable']==true) {
						$Processor = new videoProcessor($this->config->videoTranscoder);
						$Processor->run($identifier['directory'].$file);
					}
					elseif ($auto==NULL && $auto=="") {
						$this->log->create('warning','transcode()', "videoTranscoder isn't enable.");die();
					}
				}
				elseif ($identifier['type']=="audio") {
					if ($this->config->audioTranscoder['enable']==true) {
						$Processor = new audioProcessor($this->config->audioTranscoder);
						$Processor->run($identifier['directory'].$file);
					}
					elseif ($auto==NULL && $auto=="") {
						$this->log->create('warning','transcode()', "audioTranscoder isn't enable.");die();
					}
				}
				elseif ($auto==NULL && $auto=="") {
					$this->log->create('error','transcode()', "No transcoder available for ".$identifier['type'].'.');die();
				}

				if (@$Processor->result['status']=='success') {
					$this->log->create('log','transcode()', $file." transcoded successfully.",$Processor->result);
				}
				else {
					$this->log->create('error','transcode()', $file." unable to transcode.",$Processor->result);
				}
			}
			else {
				$this->log->create('warning','transcode()', $file[0]." Invalid identifier.");
			}
		}
}