<?php
/** no direct access **/
defined('_WBMPLEXEC_') or die();

/**
 * Webilia MPL Base class.
 * @author Webilia <info@webilia.com>
 * @abstract
 */
abstract class WBMPL_base extends WBMPL
{
    /**
     * Returns WBMPL_db instance
     * @final
     * @author Webilia <info@webilia.com>
     * @return \WBMPL_db instance
     */
	final public function getDB()
    {
        return WBMPL::getInstance('app.libraries.db');
    }
    
    /**
     * Returns WBMPL_posts instance
     * @final
     * @author Webilia <info@webilia.com>
     * @return \WBMPL_posts instance
     */
    final public function getPosts()
    {
        return WBMPL::getInstance('app.libraries.posts');
    }
    
    /**
     * Returns WBMPL_request instance
     * @final
     * @author Webilia <info@webilia.com>
     * @return \WBMPL_request instance
     */
    final public function getRequest()
    {
        return WBMPL::getInstance('app.libraries.request');
    }
    
    /**
     * Returns WBMPL_file instance
     * @final
     * @author Webilia <info@webilia.com>
     * @return \WBMPL_file instance
     */
    final public function getFile()
    {
        return WBMPL::getInstance('app.libraries.filesystem', 'WBMPL_file');
    }
    
    /**
     * Returns WBMPL_folder instance
     * @final
     * @author Webilia <info@webilia.com>
     * @return \WBMPL_folder instance
     */
    final public function getFolder()
    {
        return WBMPL::getInstance('app.libraries.filesystem', 'WBMPL_folder');
    }
    
    /**
     * Returns WBMPL_path instance
     * @final
     * @author Webilia <info@webilia.com>
     * @return \WBMPL_path instance
     */
    final public function getPath()
    {
        return WBMPL::getInstance('app.libraries.filesystem', 'WBMPL_path');
    }
    
    /**
     * Returns WBMPL_main instance
     * @final
     * @author Webilia <info@webilia.com>
     * @return \WBMPL_main instance
     */
    final public function getMain()
    {
        return WBMPL::getInstance('app.libraries.main');
    }
    
    /**
     * Returns WBMPL_factory instance
     * @final
     * @author Webilia <info@webilia.com>
     * @return \WBMPL_factory instance
     */
    final public function getFactory()
    {
        return WBMPL::getInstance('app.libraries.factory');
    }
    
    /**
     * Returns WBMPL_pro instance
     * @final
     * @author Webilia <info@webilia.com>
     * @return \WBMPL_pro instance
     */
    final public function getPRO()
    {
        return WBMPL::getInstance('app.libraries.pro');
    }
}