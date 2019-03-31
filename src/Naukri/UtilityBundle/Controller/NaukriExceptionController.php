<?php
namespace Naukri\UtilityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Templating\TemplateReference;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\FlattenException;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
 * Description of NaukriExceptionController
 *
 * @author prabin
 */
class NaukriExceptionController extends ContainerAware
{
    public function showAction(FlattenException $exception, DebugLoggerInterface $logger = null, $format = 'html') {
var_dump($exception);die;
        $this->container->get('request')->setRequestFormat($format);
        $currentContent = $this->getAndCleanOutputBuffering();

        $templating = $this->container->get('templating');
        $code = $exception->getStatusCode();
        
        $isAjax = $this->container->get('request')->get('ajax');
        if ($isAjax == '1') {
            $tplName = new TemplateReference('NaukriUtilityBundle', 'Exception', 'errorAJAX', 'html', 'tpl');
        } else {
            $tplName = $this->findTemplate($templating, $format, $code, $this->container->get('kernel')->isDebug());
        }
        return $templating->renderResponse(
            $tplName,
            array(
                'status_code'    => $code,
                'status_text'    => isset(Response::$statusTexts[$code]) ? Response::$statusTexts[$code] : '',
                'exception'      => $exception,
                'logger'         => $logger,
                'currentContent' => $currentContent,
            )
        );
    }
    
    protected function getAndCleanOutputBuffering() {
        // ob_get_level() never returns 0 on some Windows configurations, so if
        // the level is the same two times in a row, the loop should be stopped.
        $previousObLevel = null;
        $startObLevel = $this->container->get('request')->headers->get('X-Php-Ob-Level', -1);

        $currentContent = '';

        while (($obLevel = ob_get_level()) > $startObLevel && $obLevel !== $previousObLevel) {
            $previousObLevel = $obLevel;
            $currentContent .= ob_get_clean();
        }

        return $currentContent;
    }
    public function getNcLoggerTag() {
        return 'JP Exception';
    }
    protected function findTemplate($templating, $format, $code, $debug) {
        $name = $debug ? 'exception' : 'error';
        if ($debug && 'html' == $format) {
            $name = 'exception_full';
        }
        if ($code == 404) {
            $name = 'error';
        }
        // when not in debug, try to find a template for the specific HTTP status code and format
        if (!$debug || $code == 404) {
            $template = new TemplateReference('NaukriUtilityBundle', 'Exception', $name.$code, $format, 'tpl');
            if ($templating->exists($template)) {
                return $template;
            }
        }

        // try to find a template for the given format
        $template = new TemplateReference('NaukriUtilityBundle', 'Exception', $name, $format, 'tpl');
        if ($templating->exists($template)) {
            return $template;
        }

        // default to a generic HTML exception
        $this->container->get('request')->setRequestFormat('html');

        return new TemplateReference('NaukriUtilityBundle', 'Exception', $name, 'html', 'tpl');
    }
}

