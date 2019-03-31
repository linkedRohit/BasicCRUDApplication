<?php

class ncRestUrlNaukriApiAuthorizer{

    public function isRequestAuthorize($hashAlgo, $body, $authSignature, $key){
        switch ($hashAlgo) {
        case 'HMAC-SHA256' :
            $toVerifyDecryptedAuthSignature = hash('sha256', $body);
            if ($authSignature == $toVerifyDecryptedAuthSignature) {
                return true;
            }else{
                return false;
            }
            break;
        default: return false;
        }
    }
}
