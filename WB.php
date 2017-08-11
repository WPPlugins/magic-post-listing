<?php
/** no direct access **/
defined('_WBMPLEXEC_') or die();

/**
 * Webilia MPL main class
 * @author Webilia <info@webilia.com>
 */
class WBMPL
{
    /**
     * Instance of this class. This is a singleton class
     * @var object
     */
    private static $instance = NULL;
    
    /**
     * Constructor method
     * @author Webilia <info@webilia.com>
     */
    protected function __construct()
    {
        /** Define MPL Text Domain for localization **/
        if(!defined('WBMPL_TEXTDOMAIN')) define('WBMPL_TEXTDOMAIN', 'wbmpl');
        
        /** MPL Version **/
        if(!defined('WBMPL_VERSION')) define('WBMPL_VERSION', '2.5');
        
        /** Pagination Types **/
        if(!defined('WBMPL_PG_NO')) define('WBMPL_PG_NO', 0);
        if(!defined('WBMPL_PG_LOAD_MORE')) define('WBMPL_PG_LOAD_MORE', 1);
        if(!defined('WBMPL_PG_INFINITE_SCROLL')) define('WBMPL_PG_INFINITE_SCROLL', 2);
    }
    
    private function __clone()
    {
    }
    
    private function __wakeup()
    {
    }
    
    /**
     * Getting instance. This Class is a singleton class
     * @author Webilia <info@webilia.com>
     * @return \static
     */
    public static function instance()
	{
        // Get an instance of Class
        if(!self::$instance) self::$instance = new self();
        
        // Return the instance
        return self::$instance;
	}
    
    /**
     * This method initialize the MPL, This add WordPress Actions, Filters and Widgets
     * @author Webilia <info@webilia.com>
     */
    public function init()
    {
        // Import Base library
        $this->import('app.libraries.base');
        
        // Import Widget Class
        $this->import('app.libraries.widgets');
        
        // Import MPL Factory, This file will do the rest
        $factory = WBMPL::getInstance('app.libraries.factory');
        
        // Registering MPL actions
        $factory->load_actions();
        
        // Registering MPL filter methods
        $factory->load_filters();
        
        // Registering MPL hooks such as activate, deactivate and uninstall hooks
        $factory->load_hooks();
        
        // Register MPL Widget
        $factory->action('widgets_init', array($factory, 'load_widgets'));
        
        // Include needed assets (CSS, JavaScript etc) in the WordPress backend
        $factory->action('admin_enqueue_scripts', array($factory, 'load_backend_assets'), 0);
        
        // Include needed assets (CSS, JavaScript etc) in the website frontend
		$factory->action('wp_enqueue_scripts', array($factory, 'load_frontend_assets'), 0);
        
        // Register the shortcodes
        $factory->action('init', array($factory, 'load_shortcodes'));
        
        // Register language files for localization
        $factory->action('plugins_loaded', array($factory, 'load_languages'));
    }
    
    /**
     * Getting a instance of a MPL library
     * @author Webilia <info@webilia.com>
     * @static
     * @param string $file
     * @param string $class_name
     * @return object|boolean
     */
    public static function getInstance($file, $class_name = NULL)
    {
        /** Import the file using import method **/
        $override = self::import($file);
        
        /** Generate class name if not provided **/
        if(!trim($class_name))
        {
            $ex = explode('.', $file);
            $file_name = end($ex);
            $class_name = 'WBMPL_'.$file_name;
        }
        
        if($override) $class_name .= '_override';
        
        /** Generate the object **/
        if(class_exists($class_name)) return new $class_name();
        else return false;
    }
    
    /**
     * Imports the MPL file
     * @author Webilia <info@webilia.com>
     * @static
     * @param string $file Use 'app.libraries.base' for including /path/to/plugin/app/libraries/base.php file
     * @param boolean $override include overridden file or not (if exists)
     * @param boolean $return_path Return the file path or not
     * @return boolean|string
     */
    public static function import($file, $override = true, $return_path = false)
    {
        // Converting the MPL path to normal path (app.libraries.base to /path/to/plugin/app/libraries/base.php)
        $original_exploded = explode('.', $file);
        $file = implode(DS, $original_exploded) . '.php';
        
        $path = _WBMPL_ABSPATH_ . $file;
        $overridden = false;
        
        // Including override file from theme
        if($override)
        {
            // Search the file in the main theme
            $wp_theme_path = get_template_directory();
            $theme_path = $wp_theme_path .DS. 'webilia' .DS. _WBMPL_BASENAME_ .DS. $file;
            
            /**
             * If overridden file exists on the main theme, then use it instead of normal file
             * For example you can override /path/to/plugin/app/libraries/base.php file in your theme by adding a file into the /path/to/theme/webilia/magic-post-listing-pro/app/libraries/base.php
             */
            if(file_exists($theme_path))
            {
                $overridden = true;
                $path = $theme_path;
            }
            
            // If the theme is a child theme then search the file in child theme
            if(get_template_directory() != get_stylesheet_directory())
            {
                // Child theme overriden file
                $child_theme_path = get_stylesheet_directory() .DS. 'webilia' .DS. _WBMPL_BASENAME_ .DS. $file;

                /**
                * If overridden file exists on the child theme, then use it instead of normal or main theme file
                * For example you can override /path/to/plugin/app/libraries/base.php file in your theme by adding a file into the /path/to/child/theme/webilia/magic-post-listing-pro/app/libraries/base.php
                */
                if(file_exists($child_theme_path))
                {
                    $overridden = true;
                    $path = $child_theme_path;
                }
            }
        }
        
        // Return the file path without importing it
        if($return_path) return $path;
        
        // Import the file and return override status
        if(file_exists($path)) require_once $path;
        return $overridden;
    }
    
    /**
     * Load MPL language file from plugin language directory or WordPress language directory
     * @author Webilia <info@webilia.com>
     */
    public function load_languages()
    {
        // MPL File library
        $file = WBMPL::getInstance('app.libraries.filesystem', 'WBMPL_file');
        
        // Get current locale
        $locale = apply_filters('plugin_locale', get_locale(), 'wbmpl');
        
        // WordPress language directory /wp-content/languages/wbmpl-en_US.mo
		$language_filepath = WP_LANG_DIR.DS.'wbmpl'.'-'.$locale.'.mo';
        
        // If language file exists on WordPress language directory use it
		if($file->exists($language_filepath))
        {
            load_textdomain('wbmpl', $language_filepath);
        }
        // Otherwise use MPL plugin directory /path/to/plugin/languages/wbmpl-en_US.mo
		else
        {
			load_plugin_textdomain('wbmpl', false, dirname(plugin_basename(__FILE__)).DS.'languages'.DS);
        }
    }
}