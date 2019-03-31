<?php

namespace Naukri\JobPostingGatewayBundle\Service;

/**
 * Description of accountService
 *
 * @author Rohit Sharma
 */
use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\Service("account.service")
 */
class AccountService
{

    /** @DI\Inject("account.dao") */
    public $accountDao;

    public function getUsers($page=0, $limit=20) {
        return $this->accountDao->getUsers($page, $limit);
    }

    public function createUser($name)
    {
        $this->accountDao->createUser($name);
    }

    public function deleteUser($id)
    {
        $this->accountDao->deleteUser($id);
    }

    public function getGroups($page=0, $limit=20) {
        return $this->accountDao->getGroups($page, $limit);
    }

    public function createGroup($name)
    {
        $this->accountDao->createGroup($name);
    }

    public function deleteGroup($id)
    {
        $groupMembers = $this->accountDao->getGroupMembers($id);
        if(count($groupMembers)>0) throw new \Exception("Can not delete groups with active members", 400);
        $this->accountDao->deleteGroup($id);
    }

    public function assignGroupToUser($userId, $groupId)
    {
	foreach($groupId as $group) 
            $this->accountDao->assignGroupToUser($userId, $group);
    }

    public function removeUserFromGroup($userId, $groupId)
    {
        $this->accountDao->removeUserFromGroup($userId, $groupId);
    }

    public function initializeDashboard() {
	$users = $this->getUsers();
        $groups = $this->getGroups();
	$assignedGroups = $this->getUserGroups($users);
	$map = array();
	foreach($assignedGroups as $uId=>$group) {
	    foreach($group as $g) {
  	        $map[$uId][] = array("id"=>$g['id'],"name"=>$g['name']);
	    }
	}
	$resp["groups"] = $groups;
	$resp["users"] = $users;
	$resp["map"] = $map;
	return $resp;
    }

    public function getUserGroups($users) {
        $userIds = array();
        foreach($users as $user) {
	    $userIds[] = $user['id'];
        }
	$assignedGroups = $this->accountDao->getAssignedGroups($userIds);
        $assUserGroupMapping = array();
        foreach($assignedGroups as $userId=>$group) {
            $assUserGroupMapping[$group['userId']][] = array("id"=>$group['id'], "name"=>$group['name']);
        }
        return $assUserGroupMapping;
    }

}

