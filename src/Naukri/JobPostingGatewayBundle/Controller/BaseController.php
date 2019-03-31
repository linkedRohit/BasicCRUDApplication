<?php

namespace Naukri\JobPostingGatewayBundle\Controller;

use Exception;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as config;
use JMS\DiExtraBundle\Annotation as DI;
use Naukri\JobPostingGatewayBundle\Util\Common\CommonUtil;

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
 * Description of BaseController
 *
 * @author Rajendra
 */
class BaseController extends Controller
{

    private $arrSanitizeRules;
    
    protected $authenticationUtil;
    

    public function getCurrentUser() { 
        return $this->authenticationUtil->getCurrentUser();
    }

    public function getRequestParam($key, $defaultValue = null) { 
        return $this->getRequest()->query->get($key, $defaultValue);
    }

    public function getFileParam($key, $defaultValue = null) { 
        return $this->getRequest()->files->get($key, $defaultValue);
    }

    public function isMethodPost() { 
        return $this->getRequest()->isMethod('POST');
    }

   
    public function getPostRequestParam($key, $defaultValue = null) { 
        return $this->getRequest()->request->get($key, $defaultValue);
    }

    public function getAllPostParams() { 
        return $this->getRequest()->request->all();
    }
    
    public function getAllGetParams() { 
        return $this->getRequest()->query->all();
    }

    public function getRequestAttribute($key, $defaultValue = null) { 
        return $this->getRequest()->attributes->get($key, $defaultValue);
    }

    /**
     * Renders a view. by adding default parameters for current user and current client
     *
     * @param string   $view       The view name
     * @param array    $parameters An array of parameters to pass to the view
     * @param Response $response   A response instance
     *
     * @return Response A Response instance
     */
    public function render($view, array $parameters = array(), Response $response = null) { 
        $parameters = $this->preRenderElements($parameters);
        return parent::render($view, $parameters, $response);
    }

    private function preRenderElements( $parameters ) { 
        $route = $this->getRequest()->get('_route');
        return $parameters;
    }

    public function renderView($view, array $parameters = array()) { 
        return parent::renderView($view, $parameters);
    }

    public function addFlashMessage($name, $message) { 
        $this->get('session')->getFlashBag()->add($name, $message);
    }

    //getRequestHeaders : function to get request headers
    //added on 12 June 2015 by Rohit
    public function getRequestHeaders() { 
        return $this->getRequest()->headers->all();
    }
    
    //getRequestHeaderParam : function to get request headers
    //added on 12 June 2015 by Rohit
    public function getRequestHeaderParam($key, $defaultValue = null) { 
        return $this->getRequest()->headers->get($key, $defaultValue);
    }
    
    //getRequestHeaderParam : function to get REQUEST BODY
    //added on 19 June 2015 by Rohit
    public function getRequestContent() { 
        $this->arrSanitizeRules = $this->getParameter('request_sanitize');
        $arrParams = json_decode($this->getRequest()->getContent(),true);
        $arrRequestBody = array();
        foreach ($arrParams as $key => $value) {
            $value = $this->replaceParams($key, $value);
            $arrRequestBody[$key] = $value;
        }
        return json_encode($arrRequestBody);
    }

    public function prepareHeader(){
        $preparedHeaders =array("Accept: application/json", "Content-Type: application/json");
        $preparedHeaders['SystemId']= $this->getRequestHeaderParam('SystemId', '');
        $preparedHeaders['AppId']= $this->getRequestHeaderParam('AppId', '');
        return $preparedHeaders;
    }
    
    public function getUserDetail($userId=null, $companyId=null) {
        $userDetails =array();
        if($companyId == null && $userId == null) {
            $recruiter = $this->getCurrentUser();
            $companyId = $recruiter->getCompanyId();//168613;
            $userId = $recruiter->getId();//9876854;
            $userDetails['superUser'] = $recruiter->getSuperUser();
        }
        $userDetails['currentUser'] = $userId;
        $userDetails['companyId'] = $companyId;
        return $userDetails;
    }

    private function replaceParams($key, $value) {
        $arrRule = $this->arrSanitizeRules[$key];
        if (!$arrRule) {
            $arrRule = $this->arrSanitizeRules["default"];
        }
        $value = str_replace($arrRule["toBeReplaced"], $arrRule["replaceWith"], $value);
        return $value;
    }
}
