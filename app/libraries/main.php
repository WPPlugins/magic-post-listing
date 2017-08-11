<?php
/** no direct access **/
defined('_WBMPLEXEC_') or die();

/**
 * Webilia MPL main class.
 * @author Webilia <info@webilia.com>
 */
class WBMPL_main extends WBMPL_base
{
    /**
     * Constructor method
     * @author Webilia <info@webilia.com>
     */
    public function __construct()
    {
    }
    
    /**
     * Returns full current URL of WordPress
     * @author Webilia <info@webilia.com>
     * @return string
     */
    public function get_full_url()
	{
		// get $_SERVER
		$server = $this->getRequest()->get('SERVER');
		
        // Check protocol
		$page_url = 'http';
		if(isset($server['HTTPS']) and $server['HTTPS'] == 'on') $page_url .= 's';
		
        // Get domain
        $site_domain = (isset($server['HTTP_HOST']) and trim($server['HTTP_HOST']) != '') ? $server['HTTP_HOST'] : $server['SERVER_NAME'];
        
		$page_url .= '://';
		$page_url .= $site_domain.$server['REQUEST_URI'];
		
        // Return full URL
		return $page_url;
	}
    
    /**
     * Returns WordPress authors
     * @author Webilia <info@webilia.com>
     * @param array $args
     * @return array
     */
    public function get_authors($args = array())
	{
		return get_users($args);
	}
    
    /**
     * Returns full URL of an asset
     * @author Webilia <info@webilia.com>
     * @param string $asset
     * @return string
     */
	public function asset($asset)
	{
		return $this->URL('WBMPL').'assets/'.$asset;
	}
    
    /**
     * Returns URL of WordPress items such as site, admin, plugins, MPL plugin etc.
     * @author Webilia <info@webilia.com>
     * @param string $type
     * @return string
     */
	public function URL($type = 'site')
	{
		// Make it lowercase
		$type = strtolower($type);
		
        // Frontend
		if(in_array($type, array('frontend','site'))) $url = site_url().'/';
        // Backend
		elseif(in_array($type, array('backend','admin'))) $url = admin_url();
        // WordPress Content directory URL
		elseif($type == 'content') $url = content_url().'/';
        // WordPress plugins directory URL
		elseif($type == 'plugin') $url = plugins_url().'/';
        // WordPress include directory URL
		elseif($type == 'include') $url = includes_url();
        // Webilia MPL plugin URL
		elseif($type == 'wbmpl')
		{
            // If plugin installed regularly on plugins directory
			if(strpos(_WBMPL_ABSPATH_, 'themes') === false) $url = plugins_url().'/'._WBMPL_BASENAME_.'/';
            // If plugin embeded into one theme
			else $url = get_template_directory_uri().'/plugins/'._WBMPL_BASENAME_.'/';
		}
		
		return $url;
	}
    
    /**
     * Returns a WordPress option
     * @author Webilia <info@webilia.com>
     * @param string $option
     * @param mixed $default
     * @return mixed
     */
    public function get_option($option, $default = NULL)
    {
        return get_option($option, $default);
    }
    
    /**
     * Print upgrade to MPL PRO messages
     * @author Webilia <info@webilia.com>
     * @param string $type
     * @return string
     */
    public function pro_messages($type = 'upgrade')
    {
        $message = '';
        if($type == 'upgrade') $message = '<p class="wbmpl_upgrade_message">'.sprintf(__('This feature is included in %s', 'wbmpl'), '<a href="http://webilia.com/api/mpl/redirect.php?action=upgrade" target="_blank">'.__('Magic Post Listing (MPL) PRO.', 'wbmpl').'</a>').'</p>';
        elseif($type == 'more_layouts') $message = '<p class="wbmpl_upgrade_message">'.sprintf(__('By upgrading to %s you can use more layouts. Click %s to see demos.', 'wbmpl'), '<a href="http://webilia.com/api/mpl/redirect.php?action=upgrade" target="_blank">'.__('MPL PRO', 'wbmpl').'</a>', '<a href="http://webilia.com/api/mpl/redirect.php?action=demo" target="_blank">'.__('here', 'wbmpl').'</a>').'</p>';
        
        return $message;
    }
    
    /**
     * Returns WordPress categories based on arguments
     * @author Webilia <info@webilia.com>
     * @param array $args
     * @return array
     */
    public function get_categories($args = array())
    {
        return get_categories($args);
    }
    
    /**
     * Returns WordPress tags based on arguments
     * @author Webilia <info@webilia.com>
     * @param array $args
     * @return array
     */
    public function get_tags($args = array())
    {
        return get_tags($args);
    }
    
    /**
     * Print MPL PRO upgrade notice for MPL Basic users
     * @author Webilia <info@webilia.com>
     */
    public function upgrade_notice()
    {
        echo '<div class="updated wbmpl_notice_container">'
        . '<div id="wbmpl_upgrade_notice" class="wbmpl_notice wbmpl_upgrade_notice wbmpl_clearfix">'
        . '<img id="wbmpl_close_upgrade_notice" class="wbmpl_close" src="'.$this->URL('WBMPL').'assets/img/x.png" />'
        . '<div class="wbmpl_message">'
        . '<p>'.sprintf(__("It's time to show your support by upgrading your %s to %s version. Quality checked by Envato!", 'wbmpl'), '<strong>'.__('Magic Post Listing', 'wbmpl').'</strong>', '<strong>'.__('PRO', 'wbmpl').'</strong>').'</p>'
        . '<span>'.sprintf(__('Extend basic plugin funtionality with %s, %s, %s and %s layouts, shortcode and other great features. See %s website!', 'wbmpl'), '<strong>'.__('Caption', 'wbmpl').'</strong>', '<strong>'.__('Ticker', 'wbmpl').'</strong>', '<strong>'.__('Animate', 'wbmpl').'</strong>', '<strong>'.__('Masonry', 'wbmpl').'</strong>', '<a href="http://webilia.com/api/mpl/redirect.php?action=demo" target="_blank">'.__('demo', 'wbmpl').'</a>').'</span>'
        . '</div>'
        . '<div class="wbmpl_upgrade_button">'
        . '<a href="http://webilia.com/api/mpl/redirect.php?action=upgrade" target="_blank"><i class="fa fa-arrow-up"></i>'.__('Upgrade for only $17', 'wbmpl').'</a>'
        . '</div>'
        . '</div>'
        . '</div>';
    }
    
    /**
     * Hide MPL PRO upgrade notice for some days, Called by AJAX
     * @author Webilia <info@webilia.com>
     */
    public function hide_upgrade_notice()
    {
        // Extend expiry time of upgrade notice for 30 days
        $_30days = time()+(30*86400);
        update_option('wbmpl_hun', $_30days); # hun = Hide Upgrade Notice
        
        echo '1';
        exit;
    }
    
    /**
     * Get status of upgrade notice
     * @author Webilia <info@webilia.com>
     * @return boolean
     */
    public function get_upgrade_notice_status()
    {
        // Get expiry time of showing MPL upgrade notice from WordPress options
        $expire_time = $this->get_option('wbmpl_hun', 0);
        
        // If the expiry time passed then show the notice otherwise don't show it
        if(time() > $expire_time) return true;
        else return false;
    }
}