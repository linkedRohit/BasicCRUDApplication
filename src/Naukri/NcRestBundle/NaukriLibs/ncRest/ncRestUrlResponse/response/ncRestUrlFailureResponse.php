<?php
/**
 * @author
 */

/**
 * ncRestUrlFailureResponse
 */

require_once(dirname(__FILE__).'/../config/config.php');
abstract class ncRestUrlFailureResponse extends ncRestUrlResponse
{
  protected $format;
  protected $appCode;
  protected $env;

  public function __construct($format, $appCode) {
    $this->format = $format;
    $this->appCode = $appCode;
    $this->env = strtoupper(constant('REST_API_ENV'));
  }

  public function isSuccessful() {
    return false;
  }

  protected function getData($status, $message, $code, $developerMessage, $validationErrors = array(), $customData = array()) {
    $showDeveloperMsg = 0;
    if (in_array($this->env, array('QA', 'DEV', 'STAGING', 'PROD'))){
      $showDeveloperMsg = constant('SHOW_DEVELOPER_MESSAGE_'.$this->env);
    }
    $code = $this->appCode != '' ? $this->appCode : $code;
    $responseBodyArray = array(
      'data' => array(
        'error' => array(
          'status' => $status,
          'message' => $message,
        )
      )
    );
    if(NCREST_SHOW_CODE !== 0) {
        $responseBodyArray['data']['error']['code'] = $code;
    }

    $count = 0;
    $arrError = array();
    foreach ($validationErrors as $validationError) {
      $count++;

      $arrError[][$validationError['field']] = array(
        'message' => $validationError['errorMessage'],
        'code' => $validationError['errorCode'] != '' ? $validationError['errorCode'] : $code.$count
      );
      $responseBodyArray['data']['error']['validationErrorDetails'] = $arrError;
    }
    if($showDeveloperMsg){
      $responseBodyArray['data']['error']['developerMessage'] = $developerMessage;
    }
    if(!empty($customData)){
      $responseBodyArray['data']['error']['customData'] = $customData;
    }

    return $responseBodyArray;
  }

  protected function getConvertedData($responseBodyArray){
      if ($this->format == 'json') {
          return $this->getJsonData($responseBodyArray);
      }
      elseif($this->format == 'form-data') {
          return  http_build_query($responseBodyArray, '', '&');
      }else{
          return $this->getXmlData($responseBodyArray);
      }
  }    

  protected function getXmlData($responseBodyArray) {
      $objXmlSerializer = new XmlSerializer();
      return $objXmlSerializer->serialize($responseBodyArray['data'], 'response');
  }

  protected function getJsonData($responseBodyArray) {
      return json_encode($responseBodyArray['data']);
  }

  protected function getFormat($reqData) {
      $format = '';
      $params = array();

      if (simplexml_load_string($reqData)) {
          $xmlData = simplexml_load_string($reqData['searchParameterData']);
          $format = trim($xmlData->Format);

          return ($format == 'json') ? 'json' : 'xml';
      }
      else {
          $jsonData = json_decode($reqData, true);
          return $jsonData['format'];
      }
  }
}

