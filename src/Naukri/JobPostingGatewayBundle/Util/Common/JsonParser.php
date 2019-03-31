<?php
namespace Naukri\JobPostingGatewayBundle\Util\Common;
/**
 * Description of ResponseParser
 *
 * @author damanpreet
 */
use JMS\DiExtraBundle\Annotation as DI;
use stdClass;
/**
 * @DI\Service("json.parser.service")
 */
class JsonParser {
    
    private function replaceObjectConstant(&$complex_array){
        foreach ($complex_array as $k => $v){
            if (is_array($v) && count($v)>0){
                $complex_array[$k] = $this->replaceObjectConstant($v);
            }
            else if($v === OBJECT_IDENTIFIER) {
                 $complex_array[$k] = new stdClass();
                }
            }
            return $complex_array;
    }
    
    public function parseJson($jsonString) {
        if (count(json_decode($jsonString, true)) == 0) return json_decode($jsonString);
        $updt = str_replace("{}",'"'.OBJECT_IDENTIFIER.'"',$jsonString);
        $updtArr = json_decode($updt, true);
        return $this->replaceObjectConstant($updtArr);
    }
}