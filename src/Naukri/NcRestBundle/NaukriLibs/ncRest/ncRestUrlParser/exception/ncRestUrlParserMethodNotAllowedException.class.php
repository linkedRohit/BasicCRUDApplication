<?php

class ncRestUrlParserMethodNotAllowedException extends ncRestUrlParserException {
    public function __construct($e, $message = null) {
        parent::__construct($e, $message, 405);
    }
}
