<?php

use Naukri\NcRestBundle\Utility\FileInfoUtility;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ResponseCreatorHelper
{

    public function getResponseBody($arrResponse, $format, $status) {
        $responseBody = null;
        switch ($format) {
            case "json":
                $responseBody = json_encode($arrResponse);
                break;
            case "xml":
                $objXmlSerializer = new XmlSerializer();
                $responseBody = $objXmlSerializer->serialize($arrResponse, 'response');
                break;
            case "form-data":
                $responseBody = $this->setResponseBodyFormDataFormat($arrResponse, $format, $status);
                break;
            case "attachment":
                $responseBody = $arrResponse["content"];
                break;

            default: 
                throw new Exception("invalid format: " . $format);
        }

        return $responseBody;
    }

    public function setResponseBodyFormDataFormat($arrResponse, $format, $status) {
        $responseBody = null;
        switch ($status) {
            case 202:
                throw new Exception("invalid format: " . $format);
            case 204:
                $responseBody = http_build_query($arrResponse, '', '&');
                break;
            case 206:                
            case 200:
                $arrTmp = array();
                foreach ($arrResponse as $key1 => $value1) {
                    foreach ($value1 as $key => $value) {
                        $arrTmp[$key1 . "_" . $key] = 'Content-Disposition: form-data; name="' . $key1 . "_" . $key . '"; filename="' . $key1 . "_" . $key . '"' . "\n\n" . $value;
                    }
                }
                $responseBody = "----mainhoonboundary\n" . implode("\n----mainhoonboundary\n", $arrTmp);
                break;
            default:
                throw new Exception("invalid format: " . $format." and status combination ".$status." for setting response body");                
        }
        return $responseBody;
    }

    public function getResponseHeader($status) {
        $responseHeader = null;
        switch ($status) {
            case 206:                
            case 200:
                $responseHeader = array(
                  "Status" => "200 OK",
                  "Content-Type" => "multipart/form-data; boundary=----mainhoonboundary"
                );
                break;
            default:
                throw new Exception("Invalid status ".$status." passed while setting response Header for multipart/form-data format");                
        }
        return $responseHeader;
    }
    
    public function getResponseHeaderOfAttachment($fileName) {
        $fileExtension = FileInfoUtility::getFileExtension($fileName);
        return  array(
                    "Status" => "200 OK",
                    "Content-Disposition" => "attachment; filename=\"" . $fileName . "\"",
                    "Content-Type" => FileInfoUtility::getExtensionContentType($fileExtension)
                );
    }

}


