<?php
/**
 * @author
 */

/**
 * ncRestUrlResponseValidator
 */

class ncRestUrlResponseValidator
{
    private $objncRestUrlResponseRequest;
    private $objNcRestUrlResponseAuthorizer;

    public function __construct(ncRestUrlResponseRequest $objncRestUrlResponseRequest) {
        $this->objncRestUrlResponseRequest = $objncRestUrlResponseRequest;
        $this->objNcRestUrlResponseAuthorizer = new ncRestUrlResponseAuthorizer($objncRestUrlResponseRequest);
    }

    public function isValidRequest(&$validationErrors) {
        $headerInfo = $this->objncRestUrlResponseRequest->getHeaders();
        $authTokenValue = $headerInfo['X-Job-Search-Auth-Token'];

        $validationErrors = array();
        if (!$this->objNcRestUrlResponseAuthorizer->isAuthorizedRequest()) {
            $validationErrors[] = array(
                'field' => 'X-Job-Search-Auth-Token',
                'value' => $authTokenValue,
                'errorMessage' => 'You are not authorized to use this API',
            );
        }

        return empty($validationErrors);
    }
}

