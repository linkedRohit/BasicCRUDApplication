<?php

namespace Naukri\JobPostingGatewayBundle\Dao\ncPDO;

use JMS\DiExtraBundle\Annotation as DI;
use Naukri\JobPostingGatewayBundle\Dao\ncPDO\DBConnectionFactoryNcPDO;
use PDOException;
use Naukri\JobPostingGatewayBundle\Util\Exceptions\DBConnectionException;
use Naukri\JobPostingGatewayBundle\Util\Exceptions\DBException;

/**
 * Description of BaseDao
 *
 * @author Rohit Sharma
 */
/** 
 * @DI\Service("base.dao", public=true, abstract=true) 
 */
abstract class BaseDao
{
    
    public function getAccountsDBConnection() { 
        return DBConnectionFactoryNcPDO::getInstance()->getAccountsDBConnection();
    }        
        
    public function throwPDOException(PDOException $exc) { 
    
        $code = (int) $exc->getCode();
        if (8003 == $code || 8004 == $code || 8006 == $code) {
            throw new DBConnectionException($exc);
        }
        throw new DBException($exc);
    }
        
    protected function bindInQueryValues($pdoStmt, $dataArr) { 
    
        $count = count($dataArr);
        for ($i=0;$i<$count;$i++) {
            $pdoStmt->bindValue(":inval_$i", $dataArr[$i]);
        }
    }
    
    protected function getBatchInsertBindStatement($count, $prefix, $suffix) { 
    
        $arr = array();
        for ($index = 0; $index < $count; $index++) {
            $arr[] = $prefix.':inval_'.$index.$suffix;
        }
        return implode(',', $arr);
    }
        
    
}
