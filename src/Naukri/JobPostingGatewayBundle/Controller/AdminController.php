<?php

namespace Naukri\JobPostingGatewayBundle\Controller;

use Exception;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Naukri\JobPostingGatewayBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as config;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Naukri\NcRestBundle\Controller\NcApiControllerInterface;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * @config\Route("/admin")
 */
class AdminController extends BaseController
{

    /** @DI\Inject("account.service") */
    public $accountService;

    /**
     * @config\Route("/manage",
     * name="admin_manage")
     */
    public function loadAdminModule() {
        $response = $this->accountService->initializeDashboard();
#var_dump($response);die;
        return $this->render("NaukriJobPostingGatewayBundle:Default:index.html.tpl", $response);
    }

}
