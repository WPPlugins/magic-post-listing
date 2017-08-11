<?php
/** no direct access **/
defined('_WBMPLEXEC_') or die();

// Define the default AJAX class if not defined before
if(!class_exists('WBMPL_MPL_default_actions'))
{
    /**
     * Webilia MPL default actions class
     * @author Webilia <info@webilia.com>
     */
    class WBMPL_MPL_default_actions extends WBMPL_base
    {
        /**
        * Constructor method
        * @author Webilia <info@webilia.com>
        */
       public function __construct()
       {
           // MPL Main library
           $this->main = $this->getMain();

           // MPL Request library
           $this->request = $this->getRequest();
       }
    
        /**
         * Load AJAX Items
         * @author Webilia <info@webilia.com>
         * @static
         * @param array $instance
         * @return array
         */
        public function load_items()
        {
            $instance = $this->request->getVar('instance', array());
            $instance['mpl_return_items'] = true;
            $instance['widget_id'] = $this->request->getVar('widget_id', mt_rand(1000, 2000));
            
            $output = '';
            
            // Check MPL PRO
            $pro = $this->getPRO();
            
            // If it is MPL PRO, then load the items
            if($pro)
            {
                $JSON = $pro->mpl($instance);
                $results = json_decode($JSON, true);
                
                $output = isset($results['html']) ? $results['html'] : '';
            }
            
            echo json_encode(array('success'=>1, 'html'=>$output));
            exit;
        }
    }
    
    $WBMPL_MPL_default_actions = new WBMPL_MPL_default_actions();
    
    // Add default AJAX actions
    $this->action('wp_ajax_wbmpl_load_items_default', array($WBMPL_MPL_default_actions, 'load_items'));
    $this->action('wp_ajax_nopriv_wbmpl_load_items_default', array($WBMPL_MPL_default_actions, 'load_items'));
}