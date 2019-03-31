<?php
namespace Naukri\UtilityBundle\UtilSmartyExtension;

use NoiseLabs\Bundle\SmartyBundle\Extension\AbstractExtension;
use Symfony\Component\DependencyInjection\ContainerInterface;
use NoiseLabs\Bundle\SmartyBundle\Extension\Plugin\BlockPlugin;
use NoiseLabs\Bundle\SmartyBundle\Extension\Plugin\ModifierPlugin;
use NoiseLabs\Bundle\SmartyBundle\Extension\Filter\PreFilter;
use Symfony\Component\HttpKernel\Kernel as Symfony;
use Smarty;
use Smarty_Internal_Template;

/**
 * This is a copy of ActionsExtension from the smarty bundle, with a minor patch to 
 * solve the following error on render with url :
 *             'You have requested a non-existent service "http". Did you mean one of these: "http_kernel", "security.http_utils"?'
 * Changed method is : 
 * 				renderBlockAction(array $parameters = array(), $controller, $template, &$repeat)
 * Once this bug is fixed by Symfony or Smarty we should 
 * revert to using the smarty render extension
 *
 * @author prabin
 */
class CustomRenderExtension  extends AbstractExtension
{
	
    protected $container;
    
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
	
    }
    
    public function getFilters() {
        $filters = array();
        if (!($this->container->hasParameter("_strip.template.whitespace") 
            && $this->container->getParameter("_strip.template.whitespace") == false)
        ) {
            $filters[] = new PreFilter("nstrip", $this, 'nstrip');
        }
        return $filters;
    }

    public function nstrip($source, Smarty_Internal_Template $template) {
        return $this->trimwhitespace($source);
    }

    /**
	 * {@inheritdoc}
	 */
    public function getPlugins() {
        return array(
        new BlockPlugin('_nrender', $this, 'renderBlockAction'),
        new ModifierPlugin('_nrender', $this, 'renderModifierAction')
        );
    }
	
    /**
	 * Returns the Response content for a given controller or URI.
	 *
	 * @param string $controller A controller name to execute (a string like BlogBundle:Post:index), or a relative URI
	 *
	 * @see Symfony\Bundle\FrameworkBundle\Templating\Helper\ActionsHelper::render()
	 * @see Symfony\Bundle\TwigBundle\Extension\ActionsExtension::renderAction()
	 */
    public function renderBlockAction(array $parameters = array(), $controller, $template, &$repeat) {
        // only output on the closing tag
        if (!$repeat) {
            return ('1' == Symfony::MINOR_VERSION) ?
            $this->getActionsHelper()->render($controller, $parameters, $parameters) :
            $this->render($controller, $parameters, $parameters);
        }
    }
	
    /**
	 * Returns the Response content for a given controller or URI.
	 *
	 * @param string $controller A controller name to execute (a string like BlogBundle:Post:index), or a relative URI
	 *
	 * @see Symfony\Bundle\FrameworkBundle\Templating\Helper\ActionsHelper::render()
	 * @see Symfony\Bundle\TwigBundle\Extension\ActionsExtension::renderAction()
	 */
    public function renderModifierAction($controller, array $attributes = array(), array $options = array()) {
        return ('1' == Symfony::MINOR_VERSION) ?
        $this->getActionsHelper()->render($controller, $attributes, $options) :
        $this->render($controller, $attributes, $options);
    }
	
    /**
	 * @param $controller
	 * @param array $attributes
	 * @param array $options
	 * @return mixed
	 *
	 * @since Symfony-2.2
	 */
    protected function render($controller, array $attributes = array(), array $options = array()) {
        $renderOptions = array();
        if (isset($options['standalone']) && true === $options['standalone']) {
            $renderOptions['strategy'] = 'esi';
            unset($options['standalone']);
        }
        return $this->getActionsHelper()->render($controller,$renderOptions);
        //		return $this->getActionsHelper()->render(
        //				$this->getActionsHelper()->controller($controller, $attributes, $options),
        //				$renderOptions
        //		);
    }
	
    /**
	 * @return ActionsHelper
	 */
    protected function getActionsHelper() {
        return $this->container->get('templating.helper.actions');
    }
	
    /**
	 * Returns the name of the extension.
	 *
	 * @return string The extension name
	 *
	 * @since  0.1.0
	 */
    public function getName() {
        return 'customRenderActions';
    }
    
    function trimwhitespace($source) {
        $store = array();
        $_store = 0;
        $_offset = 0;

        // Unify Line-Breaks to \n
        $source = preg_replace("/\015\012|\015|\012/", "\n", $source);

        // capture Internet Explorer Conditional Comments
        if (preg_match_all('#<!--\[[^\]]+\]>.*?<!\[[^\]]+\]-->#is', $source, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $store[] = $match[0][0];
                $_length = strlen($match[0][0]);
                $replace = '@!@COMMENTS:' . $_store . ':COMMENTS@!@';
                $source = substr_replace($source, $replace, $match[0][1] - $_offset, $_length);

                $_offset += $_length - strlen($replace);
                $_store++;
            }
        }

        // Strip all HTML-Comments
        // yes, even the ones in <script> - see http://stackoverflow.com/a/808850/515124
        $source = preg_replace('#<!--.*?-->#ms', '', $source);

        // capture html elements not to be messed with
        $_offset = 0;
        if (preg_match_all('#<(script|pre|textarea)[^>]*>.*?</\\1>#is', $source, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $store[] = $match[0][0];
                $_length = strlen($match[0][0]);
                $replace = '@!@SMARTY:' . $_store . ':SMARTY@!@';
                $source = substr_replace($source, $replace, $match[0][1] - $_offset, $_length);

                $_offset += $_length - strlen($replace);
                $_store++;
            }
        }

        $expressions = array(
            // replace multiple spaces between tags by a single space
            // can't remove them entirely, becaue that might break poorly implemented CSS display:inline-block elements
            '#(:SMARTY@!@|>)\s+(?=@!@SMARTY:|<)#s' => '\1 \2',
            // remove spaces between attributes (but not in attribute values!)
            '#(([a-z0-9]\s*=\s*(["\'])[^\3]*?\3)|<[a-z0-9_]+)\s+([a-z/>])#is' => '\1 \4',
            // note: for some very weird reason trim() seems to remove spaces inside attributes.
            // maybe a \0 byte or something is interfering?
            '#^\s+<#Ss' => '<',
            '#>\s+$#Ss' => '>',
        );
        
        $source = preg_replace(array_keys($expressions), array_values($expressions), $source);
        $source = preg_replace('!\s+!'. Smarty::$_UTF8_MODIFIER , ' ',$source);
        // note: for some very weird reason trim() seems to remove spaces inside attributes.
        // maybe a \0 byte or something is interfering?
        // $source = trim( $source );

        // capture html elements not to be messed with
        $_offset = 0;
        if (preg_match_all('#@!@COMMENTS:([0-9]+):COMMENTS@!@#is', $source, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $store[] = $match[0][0];
                $_length = strlen($match[0][0]);
                $replace = array_shift($store);
                $source = substr_replace($source, $replace, $match[0][1] + $_offset, $_length);

                $_offset += strlen($replace) - $_length;
                $_store++;
            }
        }
        $_offset = 0;
        if (preg_match_all('#@!@SMARTY:([0-9]+):SMARTY@!@#is', $source, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $store[] = $match[0][0];
                $_length = strlen($match[0][0]);
                $replace = array_shift($store);
                $source = substr_replace($source, $replace, $match[0][1] + $_offset, $_length);

                $_offset += strlen($replace) - $_length;
                $_store++;
            }
        }

        return $source;
    }
    
    
}

