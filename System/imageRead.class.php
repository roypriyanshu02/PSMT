<?php

class imageRead {
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
            case "gif": $ctype="image/gif"; break;
            case "png": $ctype="image/png"; break;
            case "jpeg":
            case "jpg": $ctype="image/jpeg"; break;
            case "svg": $ctype="image/svg+xml"; break;
            case "webp": $ctype="image/webp"; break;
            default:
                $ctype="image/jpeg"; break;
        }
        header('Content-type: ' . $ctype);
    }
    private function _header($file) {
        header('Content-Transfer-Encoding: binary');
        header('Content-Disposition: inline; filename="' . basename($file) . '"');
        header('Content-Length: ' . filesize($file));
        header('Accept-Ranges: bytes');
    }
    private function _render($file) {
        readfile($file);
    }
}