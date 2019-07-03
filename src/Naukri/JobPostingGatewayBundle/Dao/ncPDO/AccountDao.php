<?php
namespace Naukri\JobPostingGatewayBundle\Dao\ncPDO;

use Naukri\JobPostingGatewayBundle\Dao\ncPDO\BaseDao;
use PDO;
use JMS\DiExtraBundle\Annotation as DI;
use PDOException;

/**
 * Description of AccountDao
 *
 * @author Rohit Sharma
 */
/**
 * @DI\Service("account.dao", parent="base.dao")
 */
class AccountDao extends BaseDao
{

    public function getUsers($page, $limit) {
	$dbConn = $this->getAccountsDBConnection();
        $selectStatement = "select id, name, active from users order by id desc limit $page, $limit";
	$res = $dbConn->prepare($selectStatement);
        $res->execute();
        $rows = $res->fetchAll(PDO::FETCH_ASSOC);
        $res->closeCursor();
	return $rows;
    }

    public function getGroups($page, $limit) {
	$dbConn = $this->getAccountsDBConnection();
        $selectStatement = "select id, name, active from groups order by id desc limit $page, $limit";
        $res = $dbConn->prepare($selectStatement);
        $res->execute();
        $rows = $res->fetchAll(PDO::FETCH_ASSOC);
        $res->closeCursor();
        return $rows;
    }

    public function getAssignedGroups($id) {
	if(empty($id)) return array();
	$dbConn = $this->getAccountsDBConnection();
        $bindedString = $this->getBatchInsertBindStatement(count($id),"","");
	$selectStatement = "select ag.userId, ag.active, g.id, g.name from groups g, assignedGroups ag where ag.userId in (" . $bindedString . ") and g.id = ag.groupId";
	echo $selectStatement;die;
        $res = $dbConn->prepare($selectStatement);
        $this->bindInQueryValues($res, $id);
        $res->execute();
        $rows = $res->fetchAll(PDO::FETCH_ASSOC);
        $res->closeCursor();
        return $rows;
    }

    public function getGroupNames($id) {
	$dbConn = $this->getAccountsDBConnection();
        $bindedString = $this->getBatchInsertBindStatement(count($id));
        $selectStatement = "select name from groups where id in (". $bindedString .") order by groupId desc";
        $res = $dbConn->prepare($selectStatement);
        $this->bindInQueryValues($res, $id);
	$res->execute();
        $rows = $res->fetchAll(PDO::FETCH_ASSOC);
        $res->closeCursor();
        return $rows;
    }

    public function createUser($name) {
        $dbConn = $this->getAccountsDBConnection();
        $updateStatement = "insert into users (name) values(:name)";

        $res = $dbConn->prepare($updateStatement);
        $res->bindValue(":name", $name, PDO::PARAM_STR);
        $res->execute();
    }

    public function deleteUser($id) {
        $dbConn = $this->getAccountsDBConnection();
        $updateStatement = "update users set active='N' where id=:id";
        $res = $dbConn->prepare($updateStatement);
        $res->bindValue(":id", $id, PDO::PARAM_INT);
        $res->execute();
    }

    public function createGroup($name) {
        $dbConn = $this->getAccountsDBConnection();
        $updateStatement = "insert into groups (name) values(:name)";

        $res = $dbConn->prepare($updateStatement);
        $res->bindValue(":name", $name, PDO::PARAM_STR);
        $res->execute();
    }

    public function deleteGroup($id) {
        $dbConn = $this->getAccountsDBConnection();
        $updateStatement = "update groups set active='N' where id=:id";

        $res = $dbConn->prepare($updateStatement);
        $res->bindValue(":id", $id, PDO::PARAM_INT);
        $res->execute();
    }

    public function getGroupMembers($id) {
        $dbConn = $this->getAccountsDBConnection();
        $sql = "select userId from assignedGroups where groupId=:id and active='Y'";

        $res = $dbConn->prepare($sql);
        $res->bindValue(":id", $id, PDO::PARAM_INT);
        $result = $res->fetchAll(PDO::FETCH_ASSOC);
        $res->closeCursor();
	return $result;
    }

    public function assignGroupToUser($id, $groupId) {
        $dbConn = $this->getAccountsDBConnection();
        $updateStatement = "insert into assignedGroups (userId, groupId) values (:user, :group)";

        $res = $dbConn->prepare($updateStatement);
        $res->bindValue(":user", $id, PDO::PARAM_INT);
        $res->bindValue(":group", $groupId, PDO::PARAM_INT);
        $res->execute();
    }

    public function removeUserFromGroup($id, $groupId) {
        $dbConn = $this->getAccountsDBConnection();
        $updateStatement = "delete from assignedGroups where userId=:user and groupId=:group";

        $res = $dbConn->prepare($updateStatement);
        $res->bindValue(":user", $id, PDO::PARAM_INT);
        $res->bindValue(":group", $groupId, PDO::PARAM_INT);
        $res->execute();
    }

}

