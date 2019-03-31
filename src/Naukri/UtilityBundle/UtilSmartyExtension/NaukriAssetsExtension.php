<?php
namespace Naukri\UtilityBundle\UtilSmartyExtension;

use Naukri\UtilityBundle\Resources\model\UtilConstants;
use NoiseLabs\Bundle\SmartyBundle\Extension\AbstractExtension;
use NoiseLabs\Bundle\SmartyBundle\Extension\Plugin\BlockPlugin;
use Symfony\Component\DependencyInjection\ContainerInterface;

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
 * Description of smAssetsExtension
 *
 * @author prabin
 */
class NaukriAssetsExtension extends AbstractExtension
{
    
    protected $container;
    private $scriptVersions;
    private $cssVersions;
    protected $request;
    
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
        if ($this->container->isScopeActive('request')) {
            $this->request = $this->container->get('request');
        }
    }
    
    public function getPlugins() {
        return array(
            new BlockPlugin('_nscript', $this, 'getSmJavascriptTag'),
            new BlockPlugin('_ncss', $this, 'getSmCssTag'),
            new BlockPlugin('_csrf', $this, 'getCSRFToken')
        );
    }
    
    public function getCSRFToken(array $parameters = array(), $salt = null, $template, &$repeat) {
        if (!$repeat) {
            $csrf = $this->container->get("form.csrf_provider");
            
            if (empty($salt)) {
                $salt = UtilConstants::CSRF_DEFAULT_FORM_KEY;
            }
            $token = $csrf->generateCsrfToken($salt);
        
            return '<input type="hidden" id="csrf" name="'.UtilConstants::CSRF_TOKEN_KEY.'" value="'.$token.'" />';
        }
    }
    
    public function getSmJavascriptTag(array $parameters = array(), $scriptName = null, $template, &$repeat) {   
        if (!$repeat) {
            try {
                $assetVersions = $this->container->getParameter("asset.version");
                $this->scriptVersions = $assetVersions["script.version"];
                $vInfo = $this->scriptVersions[$scriptName];
                $secure = isset($parameters['secure']) ? $parameters['secure'] : 0;
                if (!empty($vInfo)) {
                    $path = $this->container->getParameter($vInfo["type"]."_JS_PATH".($secure?"_SECURE":""))."/".$vInfo["name"];
                    return '<script src="'.$path.'" type="text/javascript"></script>';
                }   
            } catch (Exception $exc) {
            }
            return '<script src="'.$scriptName.' not found" type="text/javascript"></script>';;
        }
    }
    
    public function getSmCssTag(array $parameters = array(), $cssName = null, $template, &$repeat) {   
        if (!$repeat) {
            try {
                $assetVersions = $this->container->getParameter("asset.version");
                $this->cssVersions = $assetVersions["css.version"];
                $vInfo = $this->cssVersions[$cssName];
                $secure = isset($parameters['secure']) ? $parameters['secure'] : 0;
                if (!empty($vInfo)) {
                    $path = $this->container->getParameter($vInfo["type"]."_CSS_PATH".($secure?"_SECURE":""))."/".$vInfo["name"];
                    return '<link rel="stylesheet" type="text/css" href="'.$path.'" media="all"/>';
                }
            } catch (Exception $exc) {
            } 
            return '<link rel="stylesheet" type="text/css" href="'.$cssName.' not found" media="all"/>';;
        }
    }
    
    public function getName() {
        return "naukriAssets";
    }
}

