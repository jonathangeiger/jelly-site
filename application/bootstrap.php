<?php defined('SYSPATH') or die('No direct script access.');

//-- Environment setup --------------------------------------------------------

/**
 * Set the default time zone.
 *
 * @see  http://docs.kohanaphp.com/about.configuration
 * @see  http://php.net/timezones
 */
date_default_timezone_set('America/Chicago');

/**
 * Set the default locale.
 *
 * @see  http://docs.kohanaphp.com/about.configuration
 * @see  http://php.net/setlocale
 */
setlocale(LC_ALL, 'en_US.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @see  http://docs.kohanaphp.com/about.autoloading
 * @see  http://php.net/spl_autoload_register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @see  http://php.net/spl_autoload_call
 * @see  http://php.net/manual/var.configuration.php#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

//-- Configuration and initialization -----------------------------------------

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 */
Kohana::init(array(
	'base_url'		=> '/',
	'index_file'	=> '',
));

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Kohana_Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Kohana_Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
	'jelly'		=> MODPATH.'jelly',		// The reason we are here!
	'database'	=> MODPATH.'database',	// We don't use this but it is necessary for the API docs to generate
	'userguide'	=> MODPATH.'userguide',	// User guide and API documentation
	));

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */

// Jelly specific API Browser
Route::set('jelly/docs/api', 'api(/<class>)', array('class' => '[a-zA-Z0-9_]+'))
	->defaults(array(
		'controller' => 'docs',
		'action'     => 'api',
		'class'      => NULL,
	));

// Translated user guide
Route::set('jelly/docs/guide', 'docs(/<page>)', array(
		'page' => '.+',
	))
	->defaults(array(
		'controller' => 'docs',
		'action'     => 'docs',
	));

// Our static pages
Route::set('default', '(<page>)', array(
		'page' => '.+'
	))
	->defaults(array(
		'controller' => 'static',
		'action'     => 'page',
		'page'     	 => 'index',
	));

/**
 * Execute the main request. A source of the URI can be passed, eg: $_SERVER['PATH_INFO'].
 * If no source is specified, the URI will be automatically detected.
 */
echo Request::instance()
	->execute()
	->send_headers()
	->response;
