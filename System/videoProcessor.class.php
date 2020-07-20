<?php

/*
*	Must be included "ffmpeg static builds"
*	url: https://johnvansickle.com/ffmpeg/
*/

class videoProcessor {

	# Returning
	public $result=[];

	function __construct($setting=NULL) {

		// setting
		if ( ($setting!==NULL && $setting!=='') && is_array($setting) ) {
			$this->settings = $setting;
		}
		else {
			die();
		}

		// Settings Error Handling
		if (!file_exists($this->settings['library'])) {
			die("Error : Library not found.");
		}
		elseif (!file_exists($this->settings['directory'])) {
			mkdir($this->settings['directory']);
			chmod($this->settings['directory'], 0777);
		}
		elseif (@!is_array($this->settings['transcode'])) {
			die("Error : Transcode not found.");
		}
	}

	public function run($video) {
		$mfilename = pathinfo($video, PATHINFO_FILENAME);
		$this->result["status"]="error";
		foreach ($this->settings['transcode'] as $transcode_name => $transcode_info) {
			# Create video title
			$outputv = $mfilename."-".$transcode_name.'.'.$transcode_info['c_type'];
			$outputd = $this->settings["directory"].$outputv;
			# Create video
			exec($this->settings['library']." -i '$video' ".$transcode_info['command']." '$outputd'  > /dev/null 2>/dev/null &");
			$this->result['files'][$transcode_name]=$outputv;
			$this->result["status"]="success";
			@chmod($this->settings['directory'].$outputv, 0777);
		}
	}

}