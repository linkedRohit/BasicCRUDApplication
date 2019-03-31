<?php
namespace Naukri\JobPostingGatewayBundle\Util\Auth;

use JMS\DiExtraBundle\Annotation as DI;
use Naukri\JobPostingGatewayBundle\Dao\ncPDO\DBConnectionFactoryNcPDO;
use PDO;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\PdoSessionHandler;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Naukri\JobPostingGatewayBundle\Resources\model\Recruiter;

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
 * Description of JPSessionHandler
 *
 * @author Rajendra
 */
/** 
 * @DI\Service("jp.session.handler") 
 */
class JPSessionHandler extends PdoSessionHandler
{
     
    /**
     * @DI\InjectParams({ "dbOptions" = @DI\Inject("%session.db_options%") })
     */
    public function __construct(array $dbOptions = array()) { 
    
        $dbConn = DBConnectionFactoryNcPDO::getInstance()->getAccountsDBConnection();
        $pdo = $dbConn->delegate;
        parent::__construct($pdo, $dbOptions);
    }
    
}


