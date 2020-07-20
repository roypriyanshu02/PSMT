<?php

class config {

	public $identifier;
	public $log;
	public $imageTranscoder;
	public $videoTranscoder;
	public $audioTranscoder;

	/* Config */
	function __construct() {
		// Directory & Identifiers

			# Storage Directory
			$StorageDirectory = getcwd().'/Storage/';
			# File Identifiers
			$this->identifier = array(
				'I' => array(
					'type' => 'image', 
					'directory' => $StorageDirectory.'Image/',
					'extensions' => array('jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'),
					'minsize' => 0,
					'maxsize' => 3 * 1000 * 1000 * 2
				),
				'V' => array(
					'type' => 'video', 
					'directory' => $StorageDirectory.'Video/',
					'extensions' => array('mp4', 'avi', 'mkv', 'webm', 'mpg', 'wmv', 'mov'),
					'minsize' => 0,
					'maxsize' => 3 * 1000 * 1000 * 1000
				),
				'A' => array(
					'type' => 'audio',
					'directory' => $StorageDirectory.'Audio/',
					'extensions' => array('mp3', 'wav', 'm4a', 'aac', 'ogg', 'wma', 'flac', 'alac', 'wma'),
					'minsize' => 0,
					'maxsize' => 3 * 1000 * 1000 * 100
				),
				'D' => array(
					'type' => 'document',
					'directory' => $StorageDirectory.'Document/',
					'extensions' => array('pdf', 'doc', 'docx', 'odt', 'xls', 'xlsx', 'ods', 'ppt', 'pptx', 'odp', 'rtf', 'txt'),
					'minsize' => 0,
					'maxsize' => 3 * 1000 * 1000 * 100
				),
				'C' => array(
					'type' => 'compressed', 
					'directory' => $StorageDirectory.'Compressed/',
					'extensions' => array('zip', '7z', 'rar', 'tar', 'tar.gz', 'iso', 'dmg'),
					'minsize' => 0,
					'maxsize' => 3 * 1000 * 1000 * 1000 * 1000
				),
				'E' => array(
					'type' => 'executable', 
					'directory' => $StorageDirectory.'Executable/',
					'extensions' => array('apk', 'bin', 'bat', 'cgi', 'pl', 'com', 'exe', 'jar', 'msi', 'py', 'wsf', 'deb', 'rpm'),
					'minsize' => 0,
					'maxsize' => 3 * 1000 * 1000 * 100
				)
			);

		// Baisc Settings

			# Log Settings
			$this->log = array(
				'file' => getcwd().'/.log',
				'display' => true,
				'save' => true,
				'type_log' => array(
					'log' => true,
					'warning' => true,
					'error' => true 
				),
				'method_log' => array(
					'log_read()' => true,
					'log_clear()' => true,
					'read()' => true,
					'upload()' => true,
					'transcode()' => true,
					'ls()' => true,
					'create()' => true,
					'write()' => true,
					'mv()' => true,
					'cp()' => true,
					'rm()' => true,
					'rmdir()' => true,
					'clear_temp()' => true,
					'check_file()' => true,
					'chmod()' => true,
					'api()' => true
				)
			);
			
		// Transcoder Settings

			# Image Transcoder Settings
			$this->imageTranscoder = array(
				'enable' => true, # Transcoder on / off key
				'directory' => $this->identifier['I']['directory'], # directory file compressed output
				'file_type' => array( # file format allowed
					'image/jpeg',
					'image/png',
					'image/gif'
				),
				'transcode' => array(
					'middle' => array('c_type' => 'jpg', 'level' => 5),
					'low' => array('c_type' => 'jpg', 'level' => 8)
				)
			);
			# Video Transcoder Settings
			$this->videoTranscoder = array(
				'enable' => true, # Transcoder on / off key
				'library' => 'System/ffmpeg/ffmpeg', # Library Path
				'directory' => $this->identifier['V']['directory'], # directory file compressed output
				'transcode' => array(
					# name => ( file formart, resolution bitrates ffmpeg commands )
					'720p' => array(
						'c_type' => 'mp4', 
						'command' => '-s hd720 -b:v 7.5M -bufsize 7.5M -b:a 192K'
					),
					'480p' => array(
						'c_type' => 'mp4', 
						'command' => '-s hd480 -b:v 4M -bufsize 4M -b:a 128K'
					),
					'360p' => array(
						'c_type' => 'mp4', 
						'command' => '-s 640x360 -b:v 1.5M -bufsize 1.5M -b:a 128K'
					),
					'240p' => array(
						'c_type' => 'mp4', 
						'command' => '-s 426x240 -b:v 1.5M -bufsize 1.5M -b:a 64K'
					)
				)
			);
			# Audio Transcoder Settings
			$this->audioTranscoder = array(
				'enable' => true, # Transcoder on / off key
				'library' => 'System/ffmpeg/ffmpeg', # Library Path Full Address
				'directory' => $this->identifier['A']['directory'], # directory file compressed output
				'transcode' => array(
					# name => ( file formart, resolution bitrates ffmpeg commands )
					'720p' => array(
						'c_type' => 'mp3', 
						'command' => '-b:a 192K'
					),
					'480p' => array(
						'c_type' => 'mp3', 
						'command' => '-b:a 128K'
					),
					'360p' => array(
						'c_type' => 'mp3', 
						'command' => '-b:a 128K'
					),
					'240p' => array(
						'c_type' => 'mp3', 
						'command' => '-b:a 64K'
					)
				)
			);
	}
}