<?php
/**
	Plugin Name: Magic Post Listing
	Plugin URI: http://webilia.com
	Description: An awesome plugin for listing the posts and creating posts/pages sliders
	Author: Webilia Team
	Version: 2.5
    Text Domain: wbmpl
    Domain Path: /languages
	Author URI: http://webilia.com
**/

/** MPL Execution **/
define('_WBMPLEXEC_', 1);

/** Directory Separator **/
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

/** MPL Absolute Path **/
define('_WBMPL_ABSPATH_', dirname(__FILE__) .DS);

/** Plugin Directory Name **/
define('_WBMPL_BASENAME_', basename(_WBMPL_ABSPATH_));

/** Include Webilia MPL class if not included before **/
if(!class_exists('WBMPL')) require_once _WBMPL_ABSPATH_.'WB.php';

/** Initialize Webilia MPL **/
$WBMPL = WBMPL::instance();
$WBMPL->init();