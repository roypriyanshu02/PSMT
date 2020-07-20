<?php

class propertiesRead {
	function __construct($file) {
		if ( !file_exists($file) ) {
			return $this->result = array('Exits' => false);
			die();
		}
		# Path info
		$pathinfof = pathinfo($file);
		# File Size
		function filesize_formatted($path) {$size = filesize($path); $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'); $power = $size > 0 ? floor(log($size, 1024)) : 0; return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power]; }
		# Generating Array
		$result = array(
			'exits' => true,
			'name' => $pathinfof['basename'],
			'type' => mime_content_type($file),
			'size' => filesize_formatted($file),
			'parent_folder' => $pathinfof['dirname'],
			'location' => $pathinfof['dirname'].'/'.$pathinfof['basename'],
			'accessed_date' => date("l d F Y h:i:s A",fileatime($file)),
			'modified_date' => date("l d F Y h:i:s A",filemtime($file)),
			'permissions' => substr(sprintf('%o', fileperms($file)), -4)
		);
		return $this->result = $result;
	}
}