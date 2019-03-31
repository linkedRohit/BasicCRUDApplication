<?php
/**
 * @author
 */

/**
 * ncRestUrlServer304RedirectResponse
 */

class ncRestUrlServer304RedirectResponse extends ncRestUrlResponse
{
    public function __construct($format = 'xml') {
        $this->responseHeaders = array(
                "Status" => "304 Not Modified",
                "Content-Type" => "application/$format"
                );
    }

    public function isSuccessful(){
        return true;
    }

}
