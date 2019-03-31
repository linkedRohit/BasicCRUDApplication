<?php
/**
 * AlertsSender 
 * 
 * @package 
 * @version 
 * @copyright 
 * @author Gaurav Asthana 
 * @license 
 */
class AlertsSender
{

    public static function sendMailAlerts($mailIds = array(), $message = "") {

        if (count($mailIds) > 0) {
            mail(implode(', ', $mailIds), 'Message from Logger', $message);
        }
    }

    public static function sendSmsAlerts($mobileNumbers = array(), $message = "") {
        
        $mobileCount = count($mobileNumbers);
        if ($mobileCount > 0) {
            $message = htmlentities($message, ENT_COMPAT);
            $message = urlencode($message);
            $xml_head = "%3C?xml%20version=%221.0%22%20encoding=%22ISO-8859-1%22?%3E%3C";
            $xml_head .= "!DOCTYPE%20MESSAGE%20SYSTEM%20%22http://127.0.0.1/psms/dtd/";
            $xml_head .= "message.dtd%22%3E%3CMESSAGE%3E%3CUSER%20USERNAME=%22";
            $xml_head .= "naukri02%22%20PASSWORD=%2202api1206%22/%3E";
            $xml_end = "%3C/MESSAGE%3E";
            $xml_code = $xml_head;
            for ($i = 0; $i < $mobileCount; $i++) {
                $phone = $mobileNumbers[$i];
                $phone = substr($phone, - 10);
                if (substr($phone, 0, 2) == '92' || substr($phone, 0, 2) == '93') 
                    $from = "9898989898";
                else 
                    $from = 'Message from Logger';
                $phone = "91".$phone;
                $xml_content = "%3CSMS%20UDH=%220%22%20CODING=%221%22%20TEXT=%22";
                $xml_content .= $message;
                $xml_content .= "%22%20PROPERTY=%220%22%20ID=%22".$i;
                $xml_content .= "%22%3E%3CADDRESS%20FROM=%22$from%22%20TO=%22";
                $xml_content .= $phone."%22%20SEQ=%22".$i."%22%20TAG=%22%22/%3E%3C/SMS%3E";
                $xml_code .= $xml_content;
            }
            $xml_code .= $xml_end;
            $smsUrl = "http://api.myvaluefirst.com/psms/servlet/psms.Eservice2";
            $fd = fopen($smsUrl."?data=$xml_code&action=send", "rb");
            fclose($fd);
        }
    }
   
} 
