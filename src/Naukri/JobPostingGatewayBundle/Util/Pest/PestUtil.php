<?php
namespace Naukri\JobPostingGatewayBundle\Util\Pest;

use JMS\DiExtraBundle\Annotation as DI;
use Naukri\JobPostingGatewayBundle\Util\Exceptions\ApiException;
use PestFactory;
use Exception;
use Pest_Exception;

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
 * Description of ApiUtil
 *
 * @author Rajendra
 */

/**
 * @DI\Service("pest.util") 
 */
class PestUtil
{

    /** @DI\Inject("json.parser.service") */
    public $jsonParser;
    
    public function sendGetRequest($url, $connectTimeOut = CONNECT_TIME_OUT, $requestTimeOut = REQUEST_TIME_OUT) { 
    
        try{ 
            $instance = PestFactory::getInstance()->getPestManager($connectTimeOut, $requestTimeOut);
            return $this->jsonParser->parseJson($instance->get($url));
        }
        catch(Exception $e) {
            throw new ApiException($e->getMessage(), $instance->last_response['meta']['http_code']);
        }
        
    }
    
    public function sendGetRequestWithHeader($url, $data, $header, $connectTimeOut = CONNECT_TIME_OUT, $requestTimeOut = REQUEST_TIME_OUT) { 
    
        try{ 
            $instance = PestFactory::getInstance()->getPestManager($connectTimeOut, $requestTimeOut);
            return $this->jsonParser->parseJson($instance->get($url, $data, $header));
            
        }
        catch(Exception $e) {
            throw new ApiException($e->getMessage(), $instance->last_response['meta']['http_code']);
        }
        
    }
    
    public function sendPostRequest($url, $data, $connectTimeOut = CONNECT_TIME_OUT, $requestTimeOut = REQUEST_TIME_OUT) { 
    
        try{
            $instance = PestFactory::getInstance()->getPestManager($connectTimeOut, $requestTimeOut);
            return $this->jsonParser->parseJson($instance->post($url, $data));
        }catch(Exception $e) {
            throw new ApiException($e->getMessage(), $instance->last_response['meta']['http_code']);
        }
    }
    
    public function sendGetRequestJSON($url, $connectTimeOut = CONNECT_TIME_OUT, $requestTimeOut = REQUEST_TIME_OUT) { 
    
        try{ 
            $instance = PestFactory::getInstance()->getJsonPestManager($connectTimeOut, $requestTimeOut);
            return $this->jsonParser->parseJson($instance->get($url));
        }
        catch(Exception $e) {
            throw new ApiException($e->getMessage(), $instance->last_response['meta']['http_code']);
        }
        
    }
    
    public function sendPostRequestJSON($url, $data, $connectTimeOut = CONNECT_TIME_OUT, $requestTimeOut = REQUEST_TIME_OUT) { 
    
        try{
            $instance = PestFactory::getInstance()->getJsonPestManager($connectTimeOut, $requestTimeOut);
            return $this->jsonParser->parseJson($instance->post($url, $data, array(), 1));
        }
        catch(Exception $e) {
            throw new ApiException($e->getMessage(), $instance->last_response['meta']['http_code']);
        }
    }

    public function sendPostRequestWithHeaders($url, $data, $headers, $connectTimeOut = CONNECT_TIME_OUT, $requestTimeOut = REQUEST_TIME_OUT) { 
    
        try{
            $instance = PestFactory::getInstance()->getPestManager($connectTimeOut, $requestTimeOut);
            return $this->jsonParser->parseJson($instance->post($url, $data, $headers));
        }catch(Exception $e) {
            throw new ApiException($e->getMessage(), $instance->last_response['meta']['http_code']);
        }
    }
    
    public function getPostArrayDataWithHeaders($url, $arrData,$headers, $timeoutConn = PEST_CONNECT_TIMEOUT, $pestCurlTimeOut = PEST_CURLOPT_TIMEOUT) { 
        try{
            $instance = PestFactory::getInstance()->getPestManager($timeoutConn, $pestCurlTimeOut);
            return $this->jsonParser->parseJson($instance->post($url, $arrData, $headers));
        }catch(Exception $e) {
            throw new ApiException($e->getMessage(), $instance->last_response['meta']['http_code']);
        }
    }
    
    public function sendPutRequestWithHeaders($url, $data, $headers, $connectTimeOut = CONNECT_TIME_OUT, $requestTimeOut = REQUEST_TIME_OUT) { 
    
        try{
            $instance = PestFactory::getInstance()->getPestManager($connectTimeOut, $requestTimeOut);
            return $this->jsonParser->parseJson($instance->put($url, $data, $headers));
        }catch(Exception $e) {
            throw new ApiException($e->getMessage(), $instance->last_response['meta']['http_code']);
        }
    }
    
    public function sendDeleteRequestWithHeaders($url, $headers, $connectTimeOut = CONNECT_TIME_OUT, $requestTimeOut = REQUEST_TIME_OUT) { 
    
        try{
            $instance = PestFactory::getInstance()->getPestManager($connectTimeOut, $requestTimeOut);
            return $this->jsonParser->parseJson($instance->delete($url, $headers));
        }catch(Exception $e) {
            throw new ApiException($e->getMessage(), $instance->last_response['meta']['http_code']);
        }
    }
    
    public function handleServiceRequestWithHeaders($url, $requestMethod, $data, $headers) {
        
        switch ($requestMethod) {
            case 'PUT':
                return $this->sendPutRequestWithHeaders($url, $data, $headers);
                break;
            case 'DELETE':
                return $this->sendDeleteRequestWithHeaders($url, $headers);
                break;
            default:
                return $this->sendPostRequestWithHeaders($url,$data,$headers);
                break;
        }
        
    }

}

