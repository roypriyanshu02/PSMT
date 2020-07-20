<?php

class otherRead {
    function __construct($file) {
        if (file_exists($file)) {
            $this->_type($file);
            $this->_header($file);
            $this->_render($file);
        }
        else {
            http_response_code(404);
            header('HTTP/1.0 404 Not Found');
            exit;
        }
    }
    private function _type($file) {
        $file_extension = strtolower(substr(strrchr($file,"."),1));
        switch( $file_extension ) {
            default:
            $ctype="";
        }
        header('Content-type: ' . $ctype);
    }
    private function _header($file) {
        header('Content-Transfer-Encoding: binary');
        header('Content-length: ' . filesize($file));
        header('Content-Disposition: inline; filename="'.basename($file).'"');
        header("Cache-Control: max-age=86400, public");
        header("Expires: ".gmdate('D, d M Y H:i:s', time()+86400) . ' GMT');
        header("Last-Modified: ".gmdate('D, d M Y H:i:s', @filemtime($this->path)) . ' GMT' );
        header('Accept-Ranges: bytes');
    }
    private function _render($file) {
        readfile($file);
    }
}