<?php

namespace Naukri\JobPostingGatewayBundle\Controller;

use Exception;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Naukri\JobPostingGatewayBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as config;
use Naukri\NcRestBundle\Controller\NcApiControllerInterface;
use Naukri\NcRestBundle\Utility\ApiResponseUtil;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * @config\Route("/accounts")
 */
class AccountsController extends BaseController implements NcApiControllerInterface
{

    /** @DI\Inject("account.service") */
    public $accountService;

    /**
     * @config\Route("/user",
     * name="create_user")
     * @config\Method("POST") 
     */
    public function createUser() {
        $name = $this->getPostRequestParam("name", null);
	if($name== null) return new Response("Name should not be null", 400);
        try {
            $this->accountService->createUser($name);
            return new Response("ok", 201);
        } catch(Exception $ex) {
            return new Response($ex->getMessage(),$ex->getCode());
        }
    }

    /**
     * @config\Route("/user/{id}",
     * name="delete_user", requirements={"id"=".*"})
     * @config\Method("DELETE") 
     */
    public function deleteUser($id) {
        if($id == null) return new Response("User id must be provided", 400);
        try {
            $this->accountService->deleteUser($id);
            return new Response("ok", 200);
        } catch(Exception $ex) {
            return new Response($ex->getMessage(),$ex->getCode());
        }
    }

    /**
     * @config\Route("/group",
     * name="create_group")
     * @config\Method("POST") 
     */
    public function createGroup() {
        $name = $this->getPostRequestParam("name", null);
        if($name == null) return new Response("Group name must be provided", 400);
        try {
            $this->accountService->createGroup($name);
            return new Response("ok", 201);
        } catch(Exception $ex) {
            return new Response($ex->getMessage(),$ex->getCode());
        }
    }

    /**
     * @config\Route("/group/{id}",
     * name="delete_group", requirements={"id"=".*"})
     * @config\Method("DELETE") 
     */
    public function deleteGroup($id) {
        if($id == null) return new Response("Id must be provided", 400);
        try {
            $this->accountService->deleteGroup($id);
            return new Response("ok", 200);
        } catch(Exception $ex) {
            return new Response($ex->getMessage(),$ex->getCode());
        }
    }

    /**
     * @config\Route("/user/assign",
     * name="assign_user_to_group")
     * @config\Method("POST") 
     */
    public function assignGroupToUser() {
        $id = $this->getPostRequestParam("userId", null);
        $groupId = $this->getPostRequestParam("groupId", null);
        if($id == null || $groupId == null) return new Response("Both userId and groupId must be provided", 400);
        try {
            $this->accountService->assignGroupToUser($id, $groupId);
            return new Response("ok", 200);
        } catch(Exception $ex) {
            return new Response($ex->getMessage(),$ex->getCode());
        }
    }

    /**
     * @config\Route("/user/remove",
     * name="remove_user_from_group")
     * @config\Method("POST") 
     */
    public function removeGroupFromUser() {
        $id = $this->getPostRequestParam("userId", null);
        $groupId = $this->getPostRequestParam("groupId", null);
        if($id == null || $groupId == null) return new Response("Both userId and groupId must be provided", 400);
        try {
            $this->accountService->removeUserFromGroup($id, $groupId);
            return new Response("ok", 200);
        } catch(Exception $ex) {
            return new Response($ex->getMessage(),$ex->getCode());
        }
    }

}
