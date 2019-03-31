<?php

namespace Naukri\NcRestBundle\Utility;

class FileInfoUtility {
    
    const FILE_EXTENSION_CONTENT_TYPE_MAP = ["docx" => "Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document",
      "doc" => "Content-Type: application/msword",
      "pdf" => "Content-Type: application/pdf",
      "rtf" => "Content-Type: application/rtf",
      "xls" => "Content-Type: application/vnd.ms-excel",
      "xlsx" => "Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
      "zip" => "Content-Type: application/octet-stream",
      "csv" => "Content-Type: application/csv"];
    
    public static function getFileExtension($fileName) {
        $fileInfo = pathinfo($fileName);
        return $fileInfo['extension'];
    }
    
    public static function getExtensionContentType($format = 'docx') {
        $format = trim($format);
        return self::FILE_EXTENSION_CONTENT_TYPE_MAP[$format];
    }
    
}
