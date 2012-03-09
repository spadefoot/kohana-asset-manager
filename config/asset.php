<?php defined('SYSPATH') or die('No direct script access.');

/**
 * This configuration file contains a list of libraries and their respective assets.
 */

$config = array();

/**
 * Blueprint CSS
 * @see http://www.blueprintcss.org/
 */
$config['blueprint'] = array(
    'default' => array(
        array(
	        'type' => 'text/css',
	        'media' => 'screen, projection',
	        'uri' => 'http://YOURSITE.com/lib/packages/blueprint/1.0.1/950/screen.css'
        ),
        array(
	        'type' => 'text/css',
	        'media' => 'print',
	        'uri' => 'http://YOURSITE.com/lib/packages/blueprint/1.0.1/950/print.css'
        ),
        array(
	        'type' => 'text/css',
	        'media' => 'screen, projection',
	        'uri' => 'http://YOURSITE.com/lib/packages/blueprint/1.0.1/950/ie.css',
	        'when' => 'lt IE 8'
        ),
    ),
);

/**
 * Crome Frame
 * @see https://code.google.com/chrome/chromeframe/
 * @see http://code.google.com/apis/libraries/devguide.html
 */
$config['chrome-frame'] = array(
    'default' => array(
        array(
	        'type' => 'text/javascript',
	        'uri' => 'https://ajax.googleapis.com/ajax/libs/chrome-frame/1.0.2/CFInstall.min.js'
        ),
    ),
);

/**
 * Dojo
 * @see http://dojotoolkit.org/
 * @see http://code.google.com/apis/libraries/devguide.html
 */
$config['dojo'] = array(
    'default' => array(
        array(
	        'type' => 'text/javascript',
	        'uri' => 'https://ajax.googleapis.com/ajax/libs/dojo/1.6.1/dojo/dojo.xd.js'
        ),
    ),
);

/**
 * Ext Core
 * @see http://www.sencha.com/products/extjs/
 * @see http://code.google.com/apis/libraries/devguide.html
 */
$config['ext-core'] = array(
    'default' => array(
        array(
	        'type' => 'text/javascript',
	        'uri' => 'https://ajax.googleapis.com/ajax/libs/ext-core/3.1.0/ext-core.js'
        ),
    ),
);

/**
 * jQuery
 * @see http://jquery.com/
 * @see http://code.google.com/apis/libraries/devguide.html
 */
$config['jquery'] = array(
    'default' => array(
        array(
	        'name' => 'jquery',
	        'type' => 'text/javascript',
	        'uri' => 'https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js',
	        'init' => '!window.jQuery && document.write(\'<script src="http://YOURSITE.com/lib/packages/jquery/1.6.2/jquery.min.js"><\/script>\');'
        ),
    ),
);

/**
 * jQuery Tools Plugin
 * @see http://flowplayer.org/tools/
 */
$config['jquery-tools'] = array(
    'default' => array(
        array('type' => 'text/javascript', 'uri' => 'http://cdn.jquerytools.org/1.2.5/jquery.tools.min.js'),
    ),
);

/**
 * jQuery UI Plugin
 * @see http://jquery.com/
 * @see http://code.google.com/apis/libraries/devguide.html
 */
$config['jquery-ui'] = array(
    'default' => array(
        array(
	        'name' => 'jquery',
	        'type' => 'text/javascript',
	        'uri' => 'https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js',
	        'init' => '!window.jQuery && document.write(\'<script src="http://YOURSITE.com/lib/packages/jquery/1.6.2/jquery.min.js"><\/script>\');'
        ),
        array(
	        'type' => 'text/javascript',
	        'uri' => 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js'
        ),
    ),
	'1_8_1' => array(
		array(
			'name' => 'jquery',
			'type' => 'text/javascript',
			'uri' => 'https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js',
			'init' => '!window.jQuery && document.write(\'<script src="http://YOURSITE.com/lib/packages/jquery/1.4.2/jquery.min.js"><\/script>\');'
		),
		array(
			'type' => 'text/javascript',
			'uri' => 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/jquery-ui.min.js'
		),
	),
);

/**
 * MooTools
 * @see http://mootools.net/
 * @see http://code.google.com/apis/libraries/devguide.html
 */
$config['mootools'] = array(
    'default' => array(
        array('type' => 'text/javascript', 'uri' => 'https://ajax.googleapis.com/ajax/libs/mootools/1.3.2/mootools-yui-compressed.js'),
    ),
);

/**
 * Prototype
 * @see http://prototypejs.org/
 * @see https://github.com/sstephenson/prototype
 * @see http://code.google.com/apis/libraries/devguide.html
 */
$config['prototype'] = array(
    'default' => array(
        array('type' => 'text/javascript', 'uri' => 'https://ajax.googleapis.com/ajax/libs/prototype/1.7.0.0/prototype.js'),
    ),
);

/**
 * script.aculo.us
 * @see http://script.aculo.us/
 * @see http://code.google.com/apis/libraries/devguide.html
 */
$config['scriptaculous'] = array(
    'default' => array(
        array('type' => 'text/javascript', 'uri' => 'https://ajax.googleapis.com/ajax/libs/scriptaculous/1.9.0/scriptaculous.js'),
    ),
);

/**
 * SWFObject
 * @see http://code.google.com/p/swfobject/
 * @see http://code.google.com/apis/libraries/devguide.html
 */
$config['swfobject'] = array(
    'default' => array(
        array('type' => 'text/javascript', 'uri' => 'https://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js'),
    ),
);

/**
 * Yahoo! User Interface Library (YUI)
 * @see http://developer.yahoo.com/yui/
 * @see http://code.google.com/apis/libraries/devguide.html
 */
$config['yui'] = array(
    'default' => array(
        array('type' => 'text/javascript', 'uri' => 'https://ajax.googleapis.com/ajax/libs/yui/3.3.0/build/yui/yui-min.js'),
    ),
);

/**
 * WebFont Loader
 * @see http://code.google.com/apis/webfonts/docs/webfont_loader.html
 * @see http://code.google.com/apis/libraries/devguide.html
 */
$config['webfont'] = array(
    'default' => array(
        array('type' => 'text/javascript', 'uri' => 'https://ajax.googleapis.com/ajax/libs/webfont/1.0.22/webfont.js'),
    ),
);

return $config;
