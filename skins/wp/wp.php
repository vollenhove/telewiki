<?php

/**
 * wp Skin
 *
 * @file
 * @ingroup Skins
 * @author Garrick Van Buren, Jamie Thingelstad
 * @license 2-clause BSD
 */

if( ! defined( 'MEDIAWIKI' ))
{
	die("Wiki Wonders What You're Doing");
}


$wgExtensionCredits['skin'][] = array(
	'path'		 => __FILE__,
	'name'		 => 'wp',
	'url'		 => 'http://something/',
	'author'	 => array(
		'Garrick Van Buren',
		'Jamie Thingelstad',
		'...'
		),
	'descriptionmsg' => 'wp-desc'
);

$wgValidSkinNames['wp'] = 'wp';

$wgAutoloadClasses['Skinwp'] = __DIR__.'/wp.skin.php';

$wgExtensionMessagesFiles['Skinwp'] = __DIR__.'/wp.i18n.php';

$wgResourceModules['skins.wp'] = array(
	'styles'         => array(
    	'wp/assets/stylesheets/normalize.css',
        'wp/assets/stylesheets/font-awesome.css',
    	'wp/assets/stylesheets/foundation.css',
    	'wp/assets/stylesheets/wp.css',
        'wp/assets/stylesheets/wp-print.css',
    	'wp/assets/stylesheets/jquery.autocomplete.css',
    	'wp/assets/stylesheets/responsive-tables.css'
    ),
    'scripts'        => array(
        'wp/assets/scripts/vendor/custom.modernizr.js',
        'wp/assets/scripts/vendor/fastclick.js',
        'wp/assets/scripts/vendor/responsive-tables.js',
        'wp/assets/scripts/foundation/foundation.js',
        'wp/assets/scripts/foundation/foundation.topbar.js',
        'wp/assets/scripts/foundation/foundation.dropdown.js',
        'wp/assets/scripts/foundation/foundation.section.js',
        'wp/assets/scripts/foundation/foundation.clearing.js',
        'wp/assets/scripts/foundation/foundation.cookie.js',
        'wp/assets/scripts/foundation/foundation.placeholder.js',
        'wp/assets/scripts/foundation/foundation.forms.js',
        'wp/assets/scripts/foundation/foundation.alerts.js',
        'wp/assets/scripts/wp.js'
    ),
    'remoteBasePath' => &$GLOBALS['wgStylePath'],
    'localBasePath'  => &$GLOBALS['wgStyleDirectory']
);
