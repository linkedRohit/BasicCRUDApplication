<?php

/**
 * @author
 */

/**
 * ncRestUrlServer303RedirectResponse
 */
class ncRestUrlServer303RedirectResponse extends ncRestUrlResponse
{

    public function __construct($arrResponse, $format = 'json') {
        $this->responseHeaders = array(
          "Status" => "303 See Other",
          "Content-Type" => "application/$format",
        );
        switch ($format) {
            case "json": $this->responseBody = json_encode($arrResponse);
                break;
        }
    }

    public function isSuccessful() {
        return true;
    }

}
