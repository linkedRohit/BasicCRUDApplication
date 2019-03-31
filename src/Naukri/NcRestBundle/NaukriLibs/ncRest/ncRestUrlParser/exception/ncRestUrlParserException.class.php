<?php

class ncRestUrlParserException extends Exception
{
    public function __construct($e, $message = null, $code = 0) {
        throw new Exception( $message, $code);
    }
}

