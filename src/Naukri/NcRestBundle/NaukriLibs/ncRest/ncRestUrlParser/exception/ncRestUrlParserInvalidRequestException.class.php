<?php

class ncRestUrlParserInvalidRequestException extends ncRestUrlParserException {
    public function __construct($e, $message = null, $code = 0) {
        parent::__construct($e, $message, $code);
    }
}
