<?php
/**
 * @author
 */

/**
 * ncRestUrlResponseAuthorizer class
 */

class ncRestUrlResponseAuthorizer
{
    private $objncRestUrlResponseRequest,
        $_SECRET_KEYS = array(
            "fn_pubkey_FN7791cFN"   => "fn_secretkey_DFN3RtVIfB9R",
        );

    public function __construct(ncRestUrlResponseRequest $objncRestUrlResponseRequest) {
        $this->objncRestUrlResponseRequest = $objncRestUrlResponseRequest;
    }

    public function isAuthorizedRequest() {
        return true;
        $requestHeaders = $this->objncRestUrlResponseRequest->getHeaders();
        $requestBody = $this->objncRestUrlResponseRequest->getBody();
        $originalRequestBody = $requestBody["originalRequestData"];
        $authToken = $requestHeaders["ncOauth_consumer_key"];
        $authSignature = $requestHeaders["ncOauth_signature"];
        if (!empty($authToken) && !empty($authSignature)) {
            $secretKey = $this->getSecretKey($authToken);
            if ($secretKey) {
                $requestUri = $_SERVER["REQUEST_URI"];
                $objAuthorizer = ncRestUrlResonseRealmFactory::getInstance()->getRealmClass($requestHeaders["realm"]);
                if(!$this->checkReplayAttack($requestHeaders["ncOauth_timestamp"],$requestHeaders["ncOauth_nonce"])){
                    return $objAuthorizer->isRequestAuthorize($requestHeaders["ncOauth_signature_method"], $requestUri. $originalRequestBody.$secretKey, $authSignature, $secretKey);
                }else{
                    return false;
                }
        /*$toVerifyDecryptedAuthSignature = hash('sha256', $requestUri. $originalRequestBody.$secretKey);
        if ($authSignature == $toVerifyDecryptedAuthSignature) {
          echo "ASdasdasdsa";die;
          return true;
        }*/
            }
        }

        return false;
    }

    private function checkReplayAttack($timestamp, $nonce){
        if((time()- $timestamp)  > (15*60)){
            return true;
        }
        return $this->checkinDb($timestamp, $nonce);
/*    check in db the combination of nonce + timestamp
if exist return true*/
        return false;
    }

    private function checkinDb($timestamp, $nonce){
        global $_GLOBAL_ARRAY,$objGlobal,$APP_PATH;
        include_once("$APP_PATH/classes/js_mysql.class.php");
        $objMysql = new jsMysql();

        $sql = "select nonce, timestamp, client, entry_time from hotjobs1.ncOauth where timestamp=:TIMESTAMP and nonce=:NONCE";
        $arrBindArray[':TIMESTAMP']['value']=$timestamp;
        $arrBindArray[':TIMESTAMP']['type']="PARAM_INT";
        $arrBindArray[':NONCE']['value']=$nonce;
        $arrBindArray[':NONCE']['type']="PARAM_STR";
        $stmt = $objMysql->jsGetConnectionForPDO("js_jobdetails.class.php","jsCreateStaticTemplate",$sql,"homepdodb",$dieFlag,$arrBindArray);
        unset($arrBindArray);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(is_array($row) && count($row)>0){
            $flag= true;
        }else{
            $this-> insertinDb($timestamp, $nonce);
            $flag = false;
        }

        $stmt->closeCursor();
        return $flag;
    }

    private function insertinDb($timestamp, $nonce){
        global $_GLOBAL_ARRAY,$objGlobal,$APP_PATH;
        include_once("$APP_PATH/classes/js_mysql.class.php");
        $objMysql = new jsMysql();

        $sql = " insert into hotjobs1.ncOauth values (:NONCE, :TIMESTAMP, :CLIENT, now())";

        $arrBindArray[':TIMESTAMP']['value']=$timestamp;
        $arrBindArray[':TIMESTAMP']['type']="PARAM_INT";
        $arrBindArray[':NONCE']['value']=$nonce;
        $arrBindArray[':NONCE']['type']="PARAM_STR";
        $arrBindArray[':CLIENT']['value']=1;
        $arrBindArray[':CLIENT']['type']="PARAM_STR";
        $stmt = $objMysql->jsGetConnectionForPDO("js_jobdetails.class.php","jsCreateStaticTemplate",$sql,"homepdodb",$dieFlag,$arrBindArray);
        unset($arrBindArray);
        $stmt->closeCursor();
    }

    private function getSecretKey($authToken) {
        return $this->_SECRET_KEYS[$authToken];

        $conn = PublicKeyManagerDAOFactory::getInstance()->createDAO('nijobs');
        $privateKey = $conn->getPrivateKey($authToken);
        return $privateKey;
    }
}
