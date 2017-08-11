<?php
/** no direct access **/
defined('_WBMPLEXEC_') or die();

/**
 * Webilia MPL factory class.
 * @author Webilia <info@webilia.com>
 */
class WBMPL_factory extends WBMPL_base
{
    /**
     * @static
     * @var array
     */
    public static $params = array();
    
    /**
     * Constructor method
     * @author Webilia <info@webilia.com>
     */
    public function __construct()
    {
        // MPL Main library
        $this->main = $this->getMain();
        
        // MPL File library
        $this->file = $this->getFile();
        
        // MPL Folder library
        $this->folder = $this->getFolder();
        
        // Import MPL Controller Class
        $this->import('app.controller');
    }
    
    /**
     * Register Webilia MPL actions
     * @author Webilia <info@webilia.com>
     */
    public function load_actions()
    {
        // Register MPL function to be called in WordPress footer hook
        $this->action('wp_footer', array($this, 'load_footer'), 9999);
        
        // Call MPL Layout Actions
		$mpl_layouts = $this->folder->files(_WBMPL_ABSPATH_ .DS. 'app' .DS. 'widgets' .DS. 'MPL' .DS. 'tmpl', '.php$', false, false);
        foreach($mpl_layouts as $mpl_layout)
        {
            $mpl_layout = strtolower(trim($mpl_layout, '.php '));
            $action_file = _WBMPL_ABSPATH_ .DS. 'app' .DS. 'widgets' .DS. 'MPL' .DS. 'assets' .DS. $mpl_layout .DS. 'actions.php';
            
            if($this->file->exists($action_file)) include_once $action_file;
        }
        
        // MPL PRO library
        $PRO = $this->main->getPRO();
        
        // PRO update API
        if($PRO) $PRO->update();
        // Show upgrade notice
        elseif($this->main->get_upgrade_notice_status())
        {
            $this->action('admin_notices', array($this->main, 'upgrade_notice'), 10);
            $this->action('wp_ajax_wbmpl_hide_upgrade_notice', array($this->main, 'hide_upgrade_notice'), 10);
        }
    }
    
    /**
     * Register Webilia MPL hooks such as activate, deactivate and uninstall hooks
     * @author Webilia <info@webilia.com>
     */
    public function load_hooks()
    {
        register_activation_hook(_WBMPL_ABSPATH_.'MPL.php', array($this, 'activate'));
		register_deactivation_hook(_WBMPL_ABSPATH_.'MPL.php', array($this, 'deactivate'));
		register_uninstall_hook(_WBMPL_ABSPATH_.'MPL.php', array('WBMPL_factory', 'uninstall'));
    }
    
    /**
     * load MPL filters
     * @author Webilia <info@webilia.com>
     */
    public function load_filters()
    {
        // MPL PRO library
        $PRO = $this->main->getPRO();
        
        if(!$PRO)
        {
            // Load MPL Plugin links such as upgrade to PRO etc.
            $this->filter('plugin_row_meta', array($this, 'load_plugin_links'), 10, 2);
        }
    }
    
    /**
     * load MPL menus
     * @author Webilia <info@webilia.com>
     */
    public function load_menus()
    {
    }
    
    /**
     * Inserting MPL plugin links such as upgrade to MPL PRO etc.
     * @author Webilia <info@webilia.com>
     */
    public function load_plugin_links($links, $file)
    {
        if(strpos($file, _WBMPL_BASENAME_) !== false)
        {
            $links[] = '<strong class="wbmpl-upgrade"><a href="http://webilia.com/api/mpl/redirect.php?action=upgrade" target="_blank">'.__('Upgrade to MPL PRO', 'wbmpl').'</a></strong>';
            $links[] = '<a href="http://webilia.com/api/mpl/redirect.php?action=demo" target="_blank">'.__('MPL PRO Demo website', 'wbmpl').'</a>';
        }
        
        return $links;
    }
    
    /**
     * Load MPL Backend assets such as CSS or JavaScript files
     * @author Webilia <info@webilia.com>
     */
    public function load_backend_assets()
    {
        // Include WordPress jQuery
        wp_enqueue_script('jquery');
        
        // Include WordPress color picker JavaScript file
        wp_enqueue_script('wp-color-picker');
        
        // Include MPL backend script file
        wp_enqueue_script('wbmpl-backend-script', $this->main->asset('js/backend.js'));
        
        // Include WordPress color picker CSS file
        wp_enqueue_style('wp-color-picker');
        
        // Include MPL backend CSS file
        wp_enqueue_style('wbmpl-backend-style', $this->main->asset('css/backend.css'));
        
        // Include Font Awesome CSS file
        $fa_include = apply_filters('WBMPL_MPL_fa_include', true);
        if($fa_include) wp_enqueue_style('font-awesome', $this->main->asset('packages/font-awesome/css/font-awesome.min.css'));
    }
    
    /**
     * Load MPL frontend assets such as CSS or JavaScript files
     * @author Webilia <info@webilia.com>
     */
    public function load_frontend_assets()
    {
        // Include WordPress jQuery
        wp_enqueue_script('jquery');
        
        // Include MPL frontend script file
        wp_enqueue_script('wbmpl-frontend-script', $this->main->asset('js/frontend.js'));
        
        // Include MPL frontend CSS file
        wp_enqueue_style('wbmpl-frontend-style', $this->main->asset('css/frontend.css'));
        
        // Include Font Awesome CSS file
        $fa_include = apply_filters('WBMPL_MPL_fa_include', true);
        if($fa_include) wp_enqueue_style('font-awesome', $this->main->asset('packages/font-awesome/css/font-awesome.min.css'));
    }
    
    /**
     * Load MPL widget
     * @author Webilia <info@webilia.com>
     */
    public function load_widgets()
    {
        // Import MPL Widget Class
        $this->import('app.widgets.MPL.main');
        
        // Register MPL Widget in WordPress
        register_widget('WBMPL_post_listing_widget');
    }
    
    /**
     * Register MPL shortcode in WordPress
     * @author Webilia <info@webilia.com>
     */
    public function load_shortcodes()
    {
        // Check MPL PRO
        $pro = $this->getPRO();
        
        // If it is MPL PRO, then add the shortcode
        if($pro) add_shortcode('WBMPL', array($pro, 'mpl'));
    }
    
    /**
     * Add strings (CSS, JavaScript, etc.) to website sections such as footer etc.
     * @author Webilia <info@webilia.com>
     * @param string $key
     * @param string $string
     * @return boolean
     */
    public function params($key = 'footer', $string)
	{
		$string = (string) $string;
		if(trim($string) == '') return false;
		
        // Register the key for removing PHP notices
        if(!isset(self::$params[$key])) self::$params[$key] = array();
        
        // Add it to the MPL params
        array_push(self::$params[$key], $string);
	}
    
    /**
     * Insert MPL assets into the website footer
     * @author Webilia <info@webilia.com>
     * @return void
     */
    public function load_footer()
    {
		if(!isset(self::$params['footer']) or (isset(self::$params['footer']) and !count(self::$params['footer']))) return;
        
        // Print the assets in the footer
        foreach(self::$params['footer'] as $key=>$string) echo PHP_EOL.$string.PHP_EOL;
    }
    
    /**
     * Add MPL actions to WordPress
     * @author Webilia <info@webilia.com>
     * @param string $hook
     * @param string $function
     * @param int $priority
     * @param int $accepted_args
     * @return boolean
     */
    public function action($hook, $function, $priority = 10, $accepted_args = 1)
    {
        // Check Parameters
        if(!trim($hook) or !$function) return false;
        
        // Add it to WordPress actions
        return add_action($hook, $function, $priority, $accepted_args);
    }
    
    /**
     * Add MPL filters to WordPress filters
     * @author Webilia <info@webilia.com>
     * @param string $tag
     * @param string $function
     * @param int $priority
     * @param int $accepted_args
     * @return boolean
     */
    public function filter($tag, $function, $priority = 10, $accepted_args = 1)
    {
        // Check Parameters
        if(!trim($tag) or !$function) return false;
        
        // Add it to WordPress filters
        return add_filter($tag, $function, $priority, $accepted_args);
    }
    
    /**
     * Runs on plugin activation
     * @author Webilia <info@webilia.com>
     */
    public function activate()
	{
        // Show MPL PRO upgrade notice 3 days after installation
        $_3days = time()+(3*86400);
        update_option('wbmpl_hun', $_3days); # hun = Hide Upgrade Notice
	}
    
    /**
     * Runs on plugin deactivation
     * @author Webilia <info@webilia.com>
     */
    public function deactivate()
	{
	}
    
    /**
     * Runs on plugin uninstallation
     * @author Webilia <info@webilia.com>
     */
    public static function uninstall()
	{
        // Remove MPL PRO upgrade notice
        delete_option('wbmpl_hun');
	}
}