<?php

class ncRestUrlParserManager
{
  private $objncRestUrlParameter;
  private $allRequestHeaders;

  public function __construct($objncRestUrlParameter) {
    $this->objncRestUrlParameter = $objncRestUrlParameter;
    $this->allRequestHeaders = getallheaders();
  }

  public function parseData($arrRequestdata, $arrMandatoryData) {
    $arrMatchedData = $this->getMatchedNode($arrRequestdata, $arrMandatoryData);
    $callingClass = trim($arrMatchedData["class"]);
    $requestMethod = $this->getRequestMethod();
    $callingMethod = $this->getCallingMethod($arrMatchedData["method"], $requestMethod);

    $this->objncRestUrlParameter->setClassName($callingClass);
    $this->objncRestUrlParameter->setMethodName($callingMethod);
    $arrMandatoryDataFromRequest = $this->getMandatoryDataFromRequest($arrMatchedData["args"], $arrMandatoryData);
    $this->objncRestUrlParameter->setArrMandatoryRequestData($arrMandatoryDataFromRequest);

    //patch to set the client id received from header to $_GET, $_POST nd $_REQUEST
    $this->setClientId();

    $this->setOptionalRequestData($requestMethod);
    $this->setOriginalRequestData($requestMethod);
    $this->objncRestUrlParameter->setRequestMethod($requestMethod);
    $contentType = $this->getRequestContentType();
    $this->objncRestUrlParameter->setRequestContentType($contentType);

    $objNcRestUrlParserValidator = new ncRestUrlParserValidator();
    $objNcRestUrlParserValidator->validateRequest($this->objncRestUrlParameter);
    return $this->objncRestUrlParameter;
  }


  private function setClientId(){
    if($this->allRequestHeaders["clientId"]){
      $clientId = $this->allRequestHeaders["clientId"];
      $_GET["clientId"] = $clientId;
      $_POST["clientId"] = $clientId;
      $_REQUEST["clientId"] = $clientId;
      $_GET["client"] = $clientId;
      $_POST["client"] = $clientId;
      $_REQUEST["client"] = $clientId;
    } 
  }

  private function setOptionalRequestData($requestMethod) {
    $response = array();

    switch($requestMethod) {
    case "GET" : $response = $_GET;
      break;
    case "POST": $body = file_get_contents('php://input');            
      if($body != '') {
        $body = $this->parseRequestData($body);
      } else {
        $body = array_merge($_POST, $_FILES);
      }
      $response = $body;
      break;
    case "PUT": $body = file_get_contents('php://input');
      if($body != '') {
        $body = $this->parseRequestData($body);
      }
      $response = $body;
      break;
    case "DELETE": $body = file_get_contents('php://input');
      if($body != '') {
        $body = $this->parseRequestData($body);
      }
      $response = $body;
      break;
    default : $response = array();
    }

    $this->objncRestUrlParameter->setArrOptionalRequestData($response);
  }

  private function setOriginalRequestData($requestMethod) {
    $response = '';

    switch($requestMethod) {
    case "GET" : $response= '';
      break;
    case "POST": $body = file_get_contents('php://input');
      if($body != '') {
        $contentType = $this->getRequestContentType();
        if($contentType == 'form') {
          //$response = http_build_query($_POST);
          $response = http_build_query(array_merge($_POST, $_FILES));
        }
        else{
          $response = $body;
        }
      }
      break;
    case "PUT" : $response = file_get_contents('php://input');
      break;
    case "DELETE" : $response = file_get_contents('php://input');
      break;
    default : $response = '';
    }

    $this->objncRestUrlParameter->setOriginalRequestData($response);
  }

  private function parseRequestData($body) {
    $contentType = $this->getRequestContentType();

    switch($contentType) {
    case 'xml':  try{
      $objXmlSerializer = new XmlSerializer();
      return $objXmlSerializer->unserialize($body);
    }catch(Exception$e) {
      throw new ncRestUrlParserInvalidRequestException(null, 'Invalid XML in the request ' . $body);
    }
    break;
  case 'json': return json_decode($body, true);
    break;
  case 'form': parse_str($body, $arrBody);
    return $arrBody;
    break;
  case 'default': return $body;
    break;
    }
  }

  private function getRequestContentType() {
    $contentType = $this->allRequestHeaders['Content-Type'];
    if(preg_match('/application\/xml/', $contentType, $matches)) {
      return 'xml';
    }
    elseif(preg_match('/text\/xml/', $contentType, $matches)) {
      return 'xml';
    }
    elseif(preg_match('/application\/json/', $contentType, $matches)) {
      return 'json';
    }
    elseif(preg_match('/application\/x-www-form-urlencode/', $contentType, $matches)) {
      return 'form';
    }
    else{
      return $contentType;
    }
  }

  private function keysAreEqual($array1, $array2) {
    return !array_diff_key($array1, $array2) && !array_diff_key($array2, $array1);
  }

  private function keysAreEqualAndInSameOrder($array1, $array2) {
    if($this->keysAreEqual($array1, $array2)) {
      if((implode(',', array_keys($array1))) == (implode(',', array_keys($array2)))) {
        return true;
      }
    }
    return false;
  }

  private function getMatchedNode($arrRequestdata, $arrMandatoryData) {
    foreach($arrRequestdata as  $key=>$value) {
      if(isset($value["order"]) && !($value["order"])) {
        if($this->keysAreEqual($value["args"], $arrMandatoryData)) {
          return $value;
        }
      }
      else{
        if($this->keysAreEqualAndInSameOrder($value["args"], $arrMandatoryData)) {
          return $value;
        }
      }
    }

    throw new ncRestUrlParserInvalidPathException(null, 'invalid url');
  }

  private function getCallingMethod($arrRequest, $requestMethod) {
    foreach($arrRequest as $strMethod) {
      $arrMethod = explode(':', $strMethod);
      if($requestMethod == trim($arrMethod[0])) {
        return trim($arrMethod[1]);
      }
    }
    return '';
  }

  private function getRequestMethod() {
    return   $this->allRequestHeaders["X-HTTP-Method-Override"] ? $this->allRequestHeaders["X-HTTP-Method-Override"] : ($_GET["_method"] ? $_GET["_method"] : $_SERVER['REQUEST_METHOD']);
  }

  private function getMandatoryDataFromRequest($arrAttributes, $arrInput) {
    $arrMandatoryData = array();

    foreach($arrAttributes as $key=>$value) {
      $newKey = $value[0];
      $newValue = $arrInput[$key]?$arrInput[$key]:$value[1];
      $arrMandatoryData[$newKey] = $newValue;
    }

    return $arrMandatoryData;
  }
}

