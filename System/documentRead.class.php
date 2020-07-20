<?php

class documentRead {
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
            # PDF
            case "pdf": $ctype="application/pdf"; break;
            # Word
            case "doc": $ctype="application/msword"; break;
            case "docx": $ctype="application/vnd.openxmlformats-officedocument.wordprocessingml.document"; break;
            case "odt": $ctype="application/vnd.oasis.opendocument.text"; break;
            # Spreadsheet
            case "xls": $ctype="application/vnd.ms-excel"; break;
            case "xlsx": $ctype="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"; break;
            case "ods": $ctype="application/vnd.oasis.opendocument.spreadsheet"; break;
            # Presentation
            case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
            case "pptx": $ctype="application/vnd.openxmlformats-officedocument.presentationml.presentation"; break;
            case "odp": $ctype="application/vnd.oasis.opendocument.presentation"; break;

            case "rtf": $ctype="application/rtf"; break;
            case "txt": $ctype="text/plain"; break;    
            default:
                $ctype="text/plain"; break;
        }
        header('Content-type: ' . $ctype);
    }
    private function _header($file) {
        header('Content-Disposition: inline; filename="' . basename($file) . '"');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($file));
        header('Accept-Ranges: bytes');
    }
    private function _render($file) {
        readfile($file);
    }
}