<?php
namespace Naukri\JobpostingBundle\Util\Exceptions;

use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
 * Description of JPExceptionHandler
 *
 * @author Rajendra
 */
class JPExceptionHandler extends ExceptionHandler
{
    
    public function getContent(FlattenException $exception) { 
    
    
        return <<<EOF
            <div class="wrap">
                <div class="perror mt10">
                    <div style="padding-top:3px;"> 
                        <em></em> 
                        <span class="etxt">
                            Your actions could not be completed at the moment. Please try again later.
                            Go to home page by <a href="/admin/homePage">clicking here</a> !
                        </span> 
                    </div>
                </div>
            </div>
EOF;
        
    }
    
    public function getStylesheet(FlattenException $exception) { 
    
    
        return <<<EOF
            .wrap { width:966px; margin:0 auto }
            .perror, .psuccess, .pwarn { background:#f9d6d8; padding:11px 9px 9px 9px; color:#be1e2d; overflow:hidden; position:relative; z-index:9; _width:100% }
            .perror em, .psuccess em { width:23px; height:23px; background-position:0 -210px; float:left; padding-right:5px }
            .perror span.etxt, .psuccess span.etxt, .pwarn span.etxt { display:inline-block; vertical-align:top; max-width:96%; padding-top:3px; color:#be1e2d }
            .psuccess span.etxt { color:#39b54a }
            .perror strong, .psuccess strong, .pwarn strong { font-size:14px }
EOF;
    }
}

