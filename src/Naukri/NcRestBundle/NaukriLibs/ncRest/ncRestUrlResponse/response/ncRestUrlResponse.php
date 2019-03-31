<?php

/**
 * @author
 */

/**
 * ncRestUrlResponse class
 */
abstract class ncRestUrlResponse
{

    protected $responseHeaders;
    protected $responseBody;

    abstract public function isSuccessful();

    public function sendHeaders($arrAdditionalHeaders = array()) {
        $this->responseHeaders = array_merge($this->responseHeaders, $arrAdditionalHeaders);
        foreach ($this->responseHeaders as $headerName => $headerValue) {
            if ($headerName == 'Status') {
                header($headerName . ": " . $headerValue, true, $headerValue);
            } else {
                header($headerName . ": " . $headerValue);
            }
        }
    }

    public function display() {
         ob_clean();
        echo $this->responseBody;
    }

    public function getResponse() {
        return $this->responseBody;
    }    
        
}
