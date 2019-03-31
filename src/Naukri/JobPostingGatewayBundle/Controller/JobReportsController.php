<?php

namespace Naukri\JobPostingGatewayBundle\Controller;

use Exception;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Naukri\JobPostingGatewayBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as config;
use Naukri\NcRestBundle\Controller\NcApiControllerInterface;
use Naukri\NcRestBundle\Utility\ApiResponseUtil;
use Symfony\Component\HttpFoundation\JsonResponse as APIResponse;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * @config\Route("/resource/report")
 */
class JobReportsController extends BaseController implements NcApiControllerInterface
{

    /** @DI\Inject("job.report.service") */
    public $jobReportsService;
   
    /**
     * @config\Route("/{url}",
     * name="ore_jp_reports_get_request",requirements={"url"=".+"})
     * @config\Method("GET")
     */
    public function handleJobGetRequest($url) {
        $data=$this->getAllGetParams();
        $headers=$this->prepareHeader();
        $userDetails=$this->getUserDetail();
        try{
            return new APIResponse(json_encode($this->jobReportsService->sendGetRequestWithHeader($url,$userDetails,$data,$headers)));
        }catch(\Exception $ex) {
            return new APIResponse($ex->getMessage(),$ex->getCode());
        }

    }

   
    /**
     * @config\Route("/{url}",
     * name="ore_jp_reports_post_request",requirements={"url"=".+"})
     * @config\Method("POST")
     */
    public function handleJobPostRequest($url) {
        $data=$this->getRequestContent();
        $headers=$this->prepareHeader();
        $userDetails=$this->getUserDetail();
        try {
            return new APIResponse(json_encode($this->jobReportsService->sendPostRequestWithHeader($url,$userDetails,$data,$headers)));
        }catch(\Exception $ex) {
            return new APIResponse($ex->getMessage(),$ex->getCode());
        }
        
    }
    
    /**
     * @config\Route("/{url}",
     * name="ore_jp_reports_delete_request",requirements={"url"=".+"})
     * @config\Method("DELETE")
     */
    public function handleJobDeleteRequest($url){
        $headers=$this->prepareHeader();
        $userDetails=$this->getUserDetail();
        try {
            return new APIResponse(json_encode($this->jobReportsService->sendDeleteRequestWithHeader($url, $userDetails, $headers)));
        }catch(\Exception $ex) {
            return new APIResponse($ex->getMessage(),$ex->getCode());
        }
    }
    
    /**
     * @config\Route("/{url}",
     * name="ore_jp_reports_put_request",requirements={"url"=".+"})
     * @config\Method("PUT")
     */
    public function handleJobPutRequest($url){
        $data=$this->getRequestContent();
        $headers=$this->prepareHeader();
        $userDetails=$this->getUserDetail();
        try {
            return new APIResponse(json_encode($this->jobReportsService->sendPutRequestWithHeader($url, $userDetails, $data, $headers)));
        }catch(\Exception $ex) {
            return new APIResponse($ex->getMessage(),$ex->getCode());
        }
    }
}
