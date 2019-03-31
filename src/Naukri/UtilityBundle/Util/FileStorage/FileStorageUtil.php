<?php
namespace Naukri\UtilityBundle\Util\FileStorage;

use JMS\DiExtraBundle\Annotation as DI;
use FileStorageFactory;
use \Exception;

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
 * Description of FileStorageUtil
 *
 * @author Rohit Sharma
 * @Date 08-Mar-2016
 */

/**
 * @DI\Service("fileStorage.util") 
 */
class FileStorageUtil
{

    // fetch data from sitenew for live jobs
    public function saveFile($empId, $fileName, $imgData, $mimeType) {
        try{
                
            $fss = FileStorageFactory::getInstance()->getFileStorage('NFLFileStorage');
            $imageStorage = $fss->savefile($empId, $fileName, $imgData, $mimeType);
            return $imageStorage;
            //$mobileDetector = new NaukriMobileDetection();
            //return $mobileDetector->isMobile();

        }
        catch(Exception $e){
            echo $e->getMessage();die;
            //throw new JobServiceException($e);
        }
    }
}
