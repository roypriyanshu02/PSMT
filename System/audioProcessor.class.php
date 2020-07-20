<?php

/*
*	Must be included "ffmpeg static builds"
*	url: https://johnvansickle.com/ffmpeg/
*/

class audioProcessor {

	# Returning
	public $result=[];

	function __construct($setting=NULL) {

		// Setting
		if ( ($setting!==NULL && $setting!=='') && is_array($setting) ) {
			$this->setting = $setting;
		}
		else {
			die();
		}

		// setting Error Handling
		if (!file_exists($this->setting['library'])) {
			die("Error : Library not found.");
		}
		elseif (!file_exists($this->setting['directory'])) {
			mkdir($this->setting['directory']);
			chmod($this->setting['directory'], 0777);
		}
		elseif (@!is_array($this->setting['transcode'])) {
			die("Error : Transcode not found.");
		}
	}

	public function run($audio) {
		$mfilename = pathinfo($audio, PATHINFO_FILENAME);
		$this->result["status"]="error";
		foreach ($this->setting['transcode'] as $transcode_name => $transcode_info) {
			# Create audio title
			$outputv = $mfilename."-".$transcode_name.'.'.$transcode_info['c_type'];
			$outputd = $this->setting["directory"].$outputv;
			# Create audio
			exec($this->setting['library']." -i '$audio' ".$transcode_info['command']." '$outputd'  > /dev/null 2>/dev/null &");
			$this->result['files'][$transcode_name]=$outputv;
			$this->result["status"]="success";
			@chmod($this->setting['directory'].$outputv, 0777);
		}
	}

}