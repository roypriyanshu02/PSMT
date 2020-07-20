<?php

class downloadRead {
    function __construct($file) {
        if (file_exists($file)) {
            $this->_header($file);
            $this->_render($file);
        }
        else {
            http_response_code(404);
            header('HTTP/1.0 404 Not Found');
            exit;
        }
    }
    private function _header($file) {
    	header('Content-Description: File Transfer');
    	header('Content-Type: application/octet-stream');
    	header('Content-Disposition: attachment; filename="'.basename($file).'"');
    	header("Expires: ".gmdate('D, d M Y H:i:s', time()+86400) . ' GMT');
    	header('Cache-Control: must-revalidate');
    	header('Pragma: public');
    	header('Content-Length: ' . filesize($file));
    }
    private function _render($file) {
        readfile($file);
        exit;
    }
}