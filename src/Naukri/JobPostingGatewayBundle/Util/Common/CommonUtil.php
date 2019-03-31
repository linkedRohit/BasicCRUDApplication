<?php

namespace Naukri\JobPostingGatewayBundle\Util\Common;

use DateTime;
use Exception;
use \ZipArchive;
use \RecursiveIteratorIterator;
use Doctrine\Common\Annotations\AnnotationRegistry;

/**
 * Description of CommonUtil
 *
 * @author rohit
 */
class CommonUtil
{

    const BLANK_DISPLAY_TEXT = "Not Mentioned";
    const DEFAULT_KEY = "0123789Sourcing4";
    const MIN_PAGE_SIZE = 10;
    const MAX_PAGE_SIZE = 160;

    public static $multipleUploadFileExtension = array(0=>'doc',1=>'docx',2=>'pdf',3=>'rtf',5=>'txt');

    public static function getRandomBigIntKey() { 
    
        list($usec, $sec) = explode(' ', microtime());
        return "s" . date('YmdHis', $sec) . ($usec * 1000000);
    }

    public static function getRandomString($length = 16, $prefix = '') { 
    
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $prefix . $str;
    }

    public static function getObjectToArray($obj) { 
    
        $arr = (array) ($obj);
        $clName = get_class($obj);
        $arrNew = array();
        foreach ($arr as $key => $value) {
            $key = str_replace($clName, '', $key);
            $arrNew[trim($key)] = $value;
        }
        return $arrNew;
    }

    public static function getArrayObjectToArray($arrayObj) { 
    
        $arrArray = array();
        foreach ($arrayObj as $obj) {
            $arr = (array) ($obj);
            $clName = get_class($obj);
            $arrNew = array();
            foreach ($arr as $key => $value) {
                $key = str_replace($clName, '', $key);
                $arrNew[trim($key)] = $value;
            }
            $arrArray[] = $arrNew;
        }
        return $arrArray;
    }

    public static function getArrayToObject($array, $className) { 
    
        $obj = new $className;
        $obj->getArrayToObject($array);
        return $obj;
    }

    public function toObject($array) { 
    
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $array[$key] = toObject($value); 
            } 
        }
        return (object) $array;
    }

    public static function getprintArray($arr) { 
    
        $result = array();
        foreach ($arr as $key => $value) {
            if (is_object($value) || is_array($value)) {
                $result[] = self::getprintArray($value);
            } else {
                $result[] = $key . '=>\'' . $value . '\'';
            }
        }
        return join(',', $result);
    }

    /**
     * <b>To save a list of objects into a db column</b><br/>
     */
    public static function serialize($objList) { 
    
        $objArray = array();
        if (is_null($objList) || empty($objList)) {
            return json_encode($objArray);
        }
        foreach ($objList as $obj) {
            if (is_string($obj)) {
                $objArray[] = $obj;
            } else {
                $objArray[] = self::getObjectAsArrayWithoutNull($obj);
            }
        }
        return json_encode($objArray);
    }

    /**
     * <b>To repopulate a list of objects from its serialized form from db</b><br/>
     *         <ul>
     *             <li>Should have been serialised using the above method : serialize($objList)</li>
     *             <li>implementation of getArrayToObject method should be written in the model object whose className is passed as second arg</li>
     *         </ul>
     */
    public static function unserialize($serealized, $className) { 
    
        $objList = array();
        if (self::isNullOrEmptyString($serealized)) {
            return $objList;
        }
        $multiArray = json_decode($serealized, true);
        if (is_null($multiArray) || empty($multiArray)) {
            return $objList;
        }
        foreach ($multiArray as $array) {
            if (is_string($array)) {
                $objList[] = $array;
            } else {
                $objList[] = self::getArrayToObject($array, $className);
            }
        }
        return $objList;
    }

    public static function getObjectAsArrayWithoutNull($obj) { 
    
        $arr = (array) ($obj);
        $clName = get_class($obj);
        $arrNew = array();
        foreach ($arr as $key => $value) {
            if (!is_null($value)) {
                $key = str_replace($clName, '', $key);
                //TODO : Look for a better way. This happens in hierarchy
                $key = str_replace('*', '', $key);
                $arrNew[trim($key)] = $value;
            }
        }
        return $arrNew;
    }

    public static function getBoolean($val) { 
    
        if (is_array($val) || is_object($val)) {
            return true;
        }
        if (is_bool($val)) {
            return $val;
        }
        if (empty($val)) {
            return false;
        }
        $val = trim(strtolower($val));
        if ($val == '1' || $val == 'true' || $val == 'yes' || $val == 'on') {
            return true;
        }
        return false;
    }

    public static function mergeTwoStrings($toString, $fromString, $charLimit, $appendMultiple = false) { 
    
        if ((count($toString) + count($fromString)) < $charLimit) {
            return $toString . ' ' . $fromString;
        } else {
            return $toString;
        }
    }

    public static function mergeProjectField($toField, $fromField) { 
    
        return (is_null($toField) ? $fromField : $toField);
    }

    public static function mergeArrays($toArray, $fromArray) { 
    
        return (count($toArray) ? (count($fromArray) ? array_merge($fromArray, $toArray) : $toArray ) : $fromArray);
    }

    public static function getFileExtension($file) { 
    
        return pathinfo($file, PATHINFO_EXTENSION);
    }

    public static function getFileExtensionFromFileName($fileName) { 
    
        $pos = strrpos($fileName, ".");
        $len = strlen($fileName);
        $extension = substr($fileName, $pos + 1, $len - $pos);
        return $extension;
    }

    public static function getFileExtensionFromMimeType($mimeType) { 
    
        $pos = strrpos($mimeType, "/");
        $len = strlen($mimeType);
        $extension = substr($mimeType, $pos + 1, $len - $pos);
        return $extension;
    }

    public static function getJsonObj($arrData) { 
    
        return json_encode($arrData);
    }

    public static function getArrayFromJsonObj($strString, $flag = true) { 
    
        return empty($strString) ? array() : json_decode($strString, $flag);
    }

    public static function getArrayObjToJson($arrObj) { 
    

        return json_encode(self::getArrayObjectToArray($arrObj));
    }

    public static function isNullOrEmptyString($string) { 
    
        return (is_null($string) || !isset($string) || trim($string) === '');
    }

    public static function isNotEmptyString($string) { 
    
        return (!self::isNullOrEmptyString($string));
    }

    public static function isValueSet($string) { 
    
        return isset($string);
    }

    public static function convertDateStringToTime($dateString) { 
    
        if ($dateString != "") {
            return strtotime($dateString);
        }
        return '';
    }

    public static function parseStringToDateString($format, $dateString) { 
    
        $timeStamp = self::convertDateStringToTime($dateString);
        if ($timeStamp != "") {
            return date($format, $timeStamp);
        }
        return '';
    }

    public static function parseStringToDate($format, $dateString) { 
    
        $date = date_create_from_format($format, $dateString);
        if (!$date) {
            return null;
        }
        return $date;
    }

    public static function parseStringToDateWithCommonFormats($dateString) { 
    
        $formats = array(
            "d-m-Y",
            "d-m-y",
            "d/m/Y",
            "d/m/y",
            "d.m.Y",
            "d.m.y",
            "dS M Y",
            "dS M y",
            "M Y",
            "M y"
        );
        foreach ($formats as $format) {
            $date = self::parseStringToDate($format, $dateString);
            if (!is_null($date)) {
                return $date;
            }
        }
        return null;
    }

    public static function getDateDisplayFormat($dateString, $format = 'd-m-Y') { 
    
        if (is_array($dateString)) {
            $dateString = $dateString['date'];
        }

        if ($dateString) {
            $date = new DateTime($dateString);
            return $date->format($format);
        }
        return null;
    }

    public static function getYearFromDate($date) { 
    
        if (!is_null($date)) {
            $val = date_format($date, "Y");

            $preYear = substr($val, 0, 2);
            if ($preYear != '00') {
                return $val;
            } else if ($preYear == '00') {

                $curYrPre = date("Y");
                $yrStart = substr($curYrPre, 0, 2) - 1;
                return $yrStart . date_format($date, "y");
            }
        }
        return null;
    }

    public static function getDayFromDate($date) { 
    
        if (!is_null($date)) {
            $val = date_format($date, "d");
            if ($val) {
                return $val;
            }
        }
        return null;
    }

    public static function getMonthFromDate($date) { 
    
        if (!is_null($date)) {
            $val = date_format($date, "m");
            if ($val) {
                return $val;
            }
        }
        return null;
    }

    public static function getDateDifferenceInDays(DateTime $firstDate, DateTime $secondDate) { 
    
        if (is_null($firstDate) || is_null($secondDate)) {
            return 0;
        }
        $firstDate->setTime(0, 0);
        $dDiff = $firstDate->diff($secondDate, true);
        return $dDiff->days;
    }

    public static function getDate($dayDiff = 0) { 
    
        $today = new DateTime();
        return self::addToDate($today, $dayDiff);
    }

    public static function getCurrentDate($format = 'd-m-Y') { 
    
        return date($format);
    }

    public static function addToDate(DateTime $date, $day = 0, $mth = 0, $yr = 0) { 
    
        if (is_null($date)) {
            return null;
        }
        $timeStamp = $date->format("U");
        $newdate = date('Y-m-d h:i:s', mktime(date('h', $timeStamp), date('i', $timeStamp), date('s', $timeStamp), date('m', $timeStamp) + $mth, date('d', $timeStamp) + $day, date('Y', $timeStamp) + $yr));
        $retDate = new DateTime($newdate);
        return $retDate;
    }

    public static function getYearRangeAsArray($yearsBack, $yearsFront = 4) { 
    
        $today = new DateTime();
        $currYear = ($yearsFront > 1000) ? $yearsFront : (self::getYearFromDate(self::addToDate($today, 0, 0, $yearsFront)));
        $backYear = ($yearsBack > 1000) ? $yearsBack : (self::getYearFromDate(self::addToDate($today, 0, 0, $yearsBack)));
        $dateRangearr = range($currYear, $backYear, -1);
        return $dateRangearr;
    }

    public static function resetSeconds(DateTime $date) { 
    
        $date->setTime($date->format("H"), $date->format("i"), 0);
        return $date;
    }

    /**
     * returns true if secondDate comes after firstDate
     *
     * @param DateTime $firstDate
     * @param DateTime $secondDate
     */
    public static function isDateComesAfter(DateTime $firstDate, DateTime $secondDate) { 
    
        if (is_null($firstDate) || is_null($secondDate)) {
            return false;
        }
        if ($firstDate == $secondDate) {
            return false;
        }
        $dDiff = $firstDate->diff($secondDate, false);
        if (!$dDiff) {
            return $dDiff;
        }
        return ($dDiff->invert == 1 ? false : true);
    }

    public static function isEmpty($obj) { 
    
        if (is_null($obj)) {
            return true;
        }
        return empty($obj);
    }

    public static function getCurrentDbFormatDate($time = true) { 
    
        if ($time) {
            return date('Y-m-d H:i:s');
        } else {
            return date('Y-m-d');
        }
    }

    public static function getCurrencyArray() { 
    
        return array('Rupees' => 'Rupees.', 'U.S Dollars' => 'US $');
    }

    public static function checkEmptyArray($input, $deepCheck = false) { 
    
        foreach ($input as $value) {
            if (is_array($value) && $deepCheck) {
                if (CommonUtil::checkEmptyArray($value, $deepCheck)) {
                    return true; 
                }
            } elseif (!empty($value) && !is_array($value)) {
                return true; 
            }
        }
        return false;
    }

    public static function checkArrayEmpty($arrData) { 
    
        if (empty($arrData) || !is_array($arrData) || count($arrData) == 0) {
            return true;
        }
        return false;
    }

    public static function checkValueExistsInArray($val, $arr) { 
    
        if (is_array($arr) && count($arr) > 0) {
            return in_array($val, $arr) ? true : false;
        }
        return false;
    }

    // all elements of  firstArray should be present in secondArray
    // firstArray empty no need to check for intersection and result is success
    public static function compareTwoArrays($firstArray, $secondArray) { 
    
        if (!is_array($firstArray) || empty($firstArray)) {
            return true;
        }
        if (is_array($secondArray)) {
            if (!empty($secondArray)) {
                return (count(array_intersect($firstArray, $secondArray)) == count($secondArray)) ? true : false;
            }
        }
        return false;
    }

    public static function compareTwoDates($firstDate, $secondDate) { 
    
        if ($firstDate == '' && $secondDate != '') {
            return false;
        } else if ($firstDate != '' && $secondDate == '') {
            return true;
        } else if ($firstDate == '') {
            return false;
        }
        if (strtotime($firstDate) > strtotime($secondDate)) {
            return true;
        }
        return false;
    }

    // any elements of  firstArray should be present in secondArray
    // firstArray empty no need to check for intersection and result is success
    public static function compareAnyValueInArrays($firstArray, $secondArray) { 
    
        if (!is_array($firstArray) || empty($firstArray)) {
            return true;
        }
        if (is_array($secondArray)) {
            if (!empty($secondArray)) {
                return (count(array_intersect($firstArray, $secondArray)) > 0) ? true : false;
            }
        }
        return false;
    }

    public static function compareAllValueInArrays($firstArray, $secondArray) { 
    
        if (!is_array($firstArray) || empty($firstArray)) {
            return true;
        }
        if (is_array($secondArray)) {
            if (!empty($secondArray)) {
                return (count(array_intersect($firstArray, $secondArray)) == count($firstArray)) ? true : false;
            }
        }
        return false;
    }

    public static function getFileUniqueKey($fileToRead) { 
    
        if (file_exists($fileToRead)) {
            return md5_file($fileToRead);
        } else {
            return '';
        }
    }

    public static function truncateString($string, $limit, $break = "", $pad = " ...") { 
    
        // return with no change if string is shorter than $limit
        if (strlen($string) <= $limit) {
            return $string; 
        }
        $string = substr($string, 0, $limit);
        if (false !== ($breakpoint = strrpos($string, $break))) {
            $string = substr($string, 0, $breakpoint);
        }
        return $string . $pad;
    }

    
    public static function replaceSpecialCharacters($target, $replacement = '') { 
    
        try {
            return preg_replace('/[^a-zA-Z0-9_-]/s', $replacement, $target);
        } catch (Exception $e) {
            return $target;
        }
    }

    public static function stringCotains($string, $subString) { 
    
        $length = strlen($subString);
        if ($length == 0) {
            return true;
        }
        if (preg_match("/$subString/", $string)) {
            return true;
        } else {
            return false;
        }
    }

    public static function isValidEmail($email) { 
    
        if (CommonUtil::isNotEmptyString($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    //    public static function isValidEmail($email) {
    //
    //        if (self::isNotEmptyString($email) && preg_match('/^([0-9a-zA-Z]([\-\.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,4})$/', $email)) {
    //                return true;
    //        }
    //        return false;
    //    }

    public static function isValidPhoneNumber($phoneNo) { 
    

        if (CommonUtil::isNotEmptyString($phoneNo) && is_numeric(CommonUtil::replaceStringValues(array("+" => "", "-" => ""), $phoneNo)) && preg_match('/^([,+0-9\-])*$/', $phoneNo) && strlen($phoneNo) <= 15) {
            return true;
        }
        return false;
    }


    public static function getArrayValueSafe($array, $key, $default = null,$isCaseCheck=false) { 
    
        if (empty($array)) {
            return $default;
        }
        if (!$isCaseCheck) {
            if (array_key_exists($key, $array)) {
                return $array[$key];
            } else {
                return $default;
            }
        } else {
            return self::arrayCaseInsensiteCheck($array, $key);
        }
    }

    private static function arrayCaseInsensiteCheck($arrayData,$key,$default = null) { 
    
        foreach ($arrayData as $keyVal=>$val) {
            if (strtolower($keyVal) == strtolower($key)) {
                return $val;
            }
        }
        return $default;
    }

    public static function prepareSearchText($keyword) { 
    
        $keyword = preg_replace('/^([^a-zA-Z0-9_])*/', '', $keyword);
        return preg_quote($keyword);
    }

    public static function stringContains($hayStack, $needle) { 
    
        if (strpos($hayStack, $needle) !== false) {
            return true;
        }
        return false;
    }

    public static function isInterger($val) { 
    
        return is_int($val);
    }

    public static function replaceStringValues($paramArray, $target) { 
    
        if (empty($target) || !is_array($paramArray)) {
            return $target;
        }
        $searchArr = array();
        $replaceArr = array();
        foreach ($paramArray as $key => $value) {
            $searchArr[] = $key;
            $replaceArr[] = $value;
        }
        return str_replace($searchArr, $replaceArr, $target);
    }

    public static function removeElementFromArray($needle, $haystack) { 
    
        if (empty($haystack) || empty($needle)) {
            return $haystack;
        }
        $ret = array();
        foreach ($haystack as $hay) {
            if ($hay != $needle) {
                $ret[] = $hay;
            }
        }
        return $ret;
    }

    public static function decryption($sStr, $sKey) { 
    
        $decrypted= mcrypt_decrypt(
            MCRYPT_RIJNDAEL_128,
            $sKey,
            base64_decode($sStr),
            MCRYPT_MODE_ECB
        );
        $decS = strlen($decrypted);
        $padding = ord($decrypted[$decS-1]);
        $decrypted = substr($decrypted, 0, -$padding);
        return $decrypted;
    }


    public static function encryption($sStr, $sKey) { 
    
        $decrypted= mcrypt_encrypt(
            MCRYPT_RIJNDAEL_128,
            $sKey,
            base64_decode($sStr),
            MCRYPT_MODE_ECB
        );
        $decS = strlen($decrypted);
        $padding = ord($decrypted[$decS-1]);
        $decrypted = substr($decrypted, 0, -$padding);
        return $decrypted;
    }


    // encrypt Function
    public static function encrypt($stringToEncrypt, $key = self::DEFAULT_KEY) { 
    
        //$encrypt = trim($stringToEncrypt);
        // $passcrypt = trim(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $encrypt, MCRYPT_MODE_ECB));
        return self::encryption($stringToEncrypt, $key);
        // return base64_encode($stringToEncrypt);
    }

    // decrypt Function
    public static function decrypt($stringToDecrypt, $key = self::DEFAULT_KEY) { 
    
        return self::decryption($stringToDecrypt, $key);
        return $decoded = base64_decode($stringToDecrypt);
        //$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CFB), MCRYPT_RAND);
        //return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, trim($decoded), MCRYPT_MODE_ECB));
    }

    public function getAllPageSizes() { 
    
        return array(40, 60, 80, 160);
    }

    public static function isErrorExist($error) { 
    
        foreach ($error as $key => $value) {
            if (is_object($value) || $value != '') {
                return true;
            }
        }

        return false;
    }


    public static function getBeforeDaysDate($daysBefore) { 
    
        return date("Y-m-d", mktime(0, 0, 0, date("m", self::getCurrentDbFormatDate(false)), date("d", self::getCurrentDbFormatDate(false)) - $daysBefore, date("Y", self::getCurrentDbFormatDate(false))));
    }

    public static function removeMultipleSpaces($str) { 
    
        $str = preg_replace('/\s+/', ' ', $str);
        return $str;
    }


    public static function generateFileNameFormat($name = '') { 
    
        if ($name != "") {
            return str_replace(' ', '_', $name) . date('YmdHisu');
        }
        return date('YmdHisu') . uniqid();
    }

    public static function clean($string) { 
    
        $stringTmp = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        $strArr = explode('-', $stringTmp);
        if (strtolower(trim($strArr[count($strArr) - 1])) == 'other') {
            unset($strArr[count($strArr) - 1]);
            $textVal = implode('', $strArr);
            $textVal = str_replace(' ', '', $textVal);
            $string = $textVal . " Other";
        }
        return self::removeMultipleSpaces(preg_replace('/[^A-Za-z\s]/', '', $string)); // Removes special chars.
    }

    public static function validateImageExtension($extension) { 
    
        $allowedExtensions = array('jpg', 'jpeg', 'gif', 'png');
        if (!self::isEmpty($extension) && in_array(strtolower($extension), $allowedExtensions)) {
            return true;
        } else {
            return false;
        }
    }

    public static function validateFileExtension($extension) { 
    
        $allowedExtensions = array("pdf", "doc", "docx", "txt", "rtf", "zip", "jpeg", "jpg");
        if (!self::isEmpty($extension) && in_array(strtolower($extension), $allowedExtensions)) {
            return true;
        } else {
            return false;
        }
    }

    public function validateImageSize($size) { 
    
        $maxSize = 1048576;
        if ($size != 0 && $size < $maxSize) {
            return true;
        } else {
            return false;
        }
    }

    public static function isJson($string) { 
    
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }


    public static function encodeBase64($sData) { 
    
        $sBase64 = base64_encode($sData);
        return strtr($sBase64, '+/', '-_');
    }

    public static function decodeBase64($sData) { 
    
        $sBase64 = strtr($sData, '-_', '+/');
        return base64_decode($sBase64);
    }


    public static function parseGivenUrl($url) { 
    
        return parse_url($url);
    }

    public static function validateSortOrder($sortOrder) { 
    
        $validSortOrder = 'DESC';
        if (strcasecmp($sortOrder, 'ASC') == 0 || strcasecmp($sortOrder, 'DESC') == 0) {
            $validSortOrder = $sortOrder;
        }
        return $validSortOrder;
    }

    public static function vaildPageSize($pageSize) { 
    
        $validPageSize = self::MIN_PAGE_SIZE;
        if ($pageSize >= 10 && $pageSize <= 160) {
            $validPageSize = $pageSize;
        }
        return ((int) $validPageSize);
    }


    public static function getNumericValue($val) { 
    
        if (is_numeric($val)) {
            $val = intval($val);
        } else {
            $val = null;
        }
        return $val;
    }


    public static function getCurrentTime($format = "H:i:s") { 
    
        return date($format);
    }

    public static function getBoomrangDesktopConfig($tag) { 
    
        $config = array(
            'device' => 'desktop',
            'tag' => $tag
        );

        return $config;
    }

    public static function isValidDomainName($domainName) { 
    
        return (preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $domainName) //valid chars check
                && preg_match("/^.{1,253}$/", $domainName) //overall length check
                && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domainName) ); //length of each label
    }


    public static function convertYearAndDayPosition($dateStr) { 
    
        $tmpArr = explode('-', $dateStr);
        return $tmpArr[2].'-'.$tmpArr[1].'-'.$tmpArr[0];
    }


    public static function isValidFileSize($content) { 
    
        $totalBytes = strlen($content);
        $kilobytes = intval($totalBytes)/1024;
        $validFileSize = intval(3072);
        if ($kilobytes > $validFileSize) {
            return false;
        } else {
            return true;
        }
    }

    public static function isValidFileExtension($fileName) { 
    
        $extension = self::getFileExtensionFromFileName($fileName);
        if (self::checkValueExistsInArray($extension, self::$multipleUploadFileExtension)) {
            return true;
        } else {
            return false;
        }
    }

    public static function getFileBaseName($fileName) { 
    
        $extension = ".".end(explode(".", $fileName));
        $baseFilename  = basename($fileName, $extension);
        return $baseFilename;
    }

    
    //function added By Rohit sharma on June 11 2015
    //This can be used to write content to any file
    //params $filePath is path of the file to be written content into
    //$text is the text you want to write to.
    //Returns nothing
    public static function writeToFile($filePath, $text) { 
    
        try
        {
            $fp = fopen($filePath, 'a+');
            fwrite($fp, $text);
            fclose($fp);
        }
        catch (Exception $ex) {
            echo "Exception while writing to file ". $filePath . ", ex - " . $ex->getMessage();die;
        }
    }

    public static function downloadDocument($attachedDoc, $fileName, $format = 'docx') {
       try{ 
        ob_get_clean();
        ob_start();

        $fileName = trim($fileName);
        $fileName = str_replace(',', '', $fileName);

        self::setContentHeaderByExtension($format);

        header("Content-Disposition:attachment; filename=\"" . $fileName . "\"");
        header('Pragma: no-cache');
        header('Expires: 0');

        echo $attachedDoc;
        ob_end_flush();
        return true;
       }
       catch(Exception $e){
           return false;
       }
    }
    
    private static function setContentHeaderByExtension($format) {
        $format = trim($format);
        if ($format == 'docx'  ) {
            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        } else if($format == 'doc') {
            header('Content-Type: application/msword');
        } elseif ($format == 'pdf') {
            header('Content-Type: application/pdf');
        } elseif ($format == 'rtf') {
            header('Content-Type: application/rtf');
        } elseif ($format == 'image' || $format == 'png' || $format=='gif' || $format=='jpg' || $format=='jpeg') {
            header('Content-Type: application/image');
        } elseif ($format == 'xls') {
            header('Content-Type: application/vnd.ms-excel');
        } elseif ( $format=='xlsx') {
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        } elseif ($format == 'zip') {
            header('Content-Type: application/octet-stream');
        } elseif($format=='csv'){
            header('Content-Type: application/csv');
        }else {
            header('Content-Type: application/octet-stream');
        }
    }

    public static function getIST() {
        $gmt = gmdate("H-i-s-m-d-Y");
        $ga = explode("-", $gmt);
        $gmtm = mktime($ga[0], $ga[1], $ga[2], $ga[3], $ga[4], $ga[5]);
        //adding 5:30 mins to gmt to get ist
        $toadd = 19800;
        $retime = $gmtm + $toadd;
        return $retime;
    }

}

