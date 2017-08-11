<?php
/** no direct access **/
defined('_WBMPLEXEC_') or die();

/**
 * Webilia MPL widgets class.
 * @author Webilia <info@webilia.com>
 */
class WBMPL_widgets extends WP_Widget
{
    /**
     * Constructor method
     * @author Webilia <info@webilia.com>
     */
    function __construct($widget_id = null, $widget_name = '', $options = array())
	{
        // MPL main library
        $this->main = WBMPL::getInstance('app.libraries.main');
        
        // MPL posts library
        $this->posts = $this->main->getPosts();
        
        // MPL request library
        $this->request = $this->main->getRequest();
        
        // MPL DB library
        $this->db = $this->main->getDB();
        
        // MPL file library
        $this->file = $this->main->getFile();
        
        // MPL folder library
        $this->folder = $this->main->getFolder();
        
        // MPL factory library
        $this->factory = $this->main->getFactory();
        
        // AJAX actions
        $this->factory->action('wp_ajax_wbmpl_widget_layout_form', array($this, 'render_layout_form'));
        
        // Call WordPress Widget Constructor for initializing the widget
		parent::__construct($widget_id, $widget_name, $options);
	}
    
    /**
     * Generate layout form, Each layout may has some custom options, This function renders them AJAXly after switching the layout
     * @author Webilia <info@webilia.com>
     */
    public function render_layout_form()
    {
        // Widget ID base
        $this->id_base = $this->request->getVar('id_base', NULL);
        
        // Widget unique number
		$this->number = $this->request->getVar('number', NULL);
        
        // Selected widget layout
		$layout = $this->request->getVar('layout', NULL);
		
        // Get layout form path
        $path = $this->main->import('app.widgets.MPL.forms.'.str_replace('.php', '', $layout), true, true);
        
        // If the layout doesn't have any form, show nothing
		if(!$this->file->exists($path))
        {
            exit;
        }
		
		// Get widget instance from WordPress options
		$result = $this->main->get_option('widget_wbmpl_post_listing_widget');
		$instance = $result[$this->number];
		
        // Include the form
		ob_start();
		include $path;
		echo $output = ob_get_clean();
        exit;
    }
    
    /**
     * Returns field ID
     * @author Webilia <info@webilia.com>
     * @param string $field_name
     * @return string
     */
    public function get_field_id($field_name)
	{
		return 'widget-' . $this->id_base . '-' . $this->number . '-' . $field_name;
	}
	
    /**
     * Returns field name
     * @author Webilia <info@webilia.com>
     * @param string $field_name
     * @return string
     */
	public function get_field_name($field_name)
	{
		return 'widget-' . $this->id_base . '[' . $this->number . '][' . $field_name . ']';
	}
    
    /**
     * Generate WordPress pages dropdown in the widget option form
     * @author Webilia <info@webilia.com>
     * @param array $args
     * @param array $params
     * @return string
     */
    public function pages_selectbox($args = array(), $params = array())
    {
        // Setting the options
        $default_args = array('echo'=>false, 'show_option_none'=>__('Root', 'wbmpl'), 'option_none_value'=>'0');
        $args = array_merge($default_args, $args);
        
        // Get WordPress pages dropdown
        $html = wp_dropdown_pages($args);
        
        // Add a class to the dropdown
        if(isset($params['class'])) $html = str_replace('<select', '<select class="'.$params['class'].'"', $html);
        
        // Replace spaces by - character for better understanding
        $html = str_replace('">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', '">------', $html);
        $html = str_replace('">&nbsp;&nbsp;&nbsp;&nbsp;', '">----', $html);
        $html = str_replace('">&nbsp;&nbsp;', '">--', $html);
        
        return $html;
    }
    
    /**
     * Generates WordPress categories dropdown in the widget option form
     * @author Webilia <info@webilia.com>
     * @param array $args
     * @param array $params
     * @return string
     */
    public function categories_selectbox($args = array(), $params = array())
    {
        // Setting the options
        $default_args = array('echo'=>false, 'show_option_none'=>__('-----', 'wbmpl'), 'option_none_value'=>'-1', 'hierarchical'=>true);
        $args = array_merge($default_args, $args);
        
        // Get WordPress categories dropdown
        $html = wp_dropdown_categories($args);
        
        // Add a class to the dropdown
        if(isset($params['class'])) $html = str_replace('<select', '<select class="'.$params['class'].'"', $html);
        
        // Replace spaces by - character for better understanding
        $html = str_replace('">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', '">------', $html);
        $html = str_replace('">&nbsp;&nbsp;&nbsp;&nbsp;', '">----', $html);
        $html = str_replace('">&nbsp;&nbsp;', '">--', $html);
        
        return $html;
    }
    
    /**
     * Check if MPL rans as a widget
     * @author Webilia <info@webilia.com>
     * @return boolean
     */
    public function isWidget()
    {
        return true;
    }
}