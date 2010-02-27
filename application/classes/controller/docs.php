<?php defined('SYSPATH') or die ('No direct script access.');
/**
 * Display our own formatted version of the userguide docs and API - just for Jelly
 * 
 * @author	Paul Banks
 */
class Controller_Docs extends Controller_Userguide
{
	/**
	 * @var	string	Set layout back to the Jelly one
	 */
	//public $template = 'template';
	
	public function before()
	{
		parent::before();
		
		// Override the necessary routes
		$this->api   = Route::get('jelly/docs/api');
		$this->guide = Route::get('jelly/docs/guide');
	}
	
	public function after()
	{
		parent::after();
		
		if ($this->auto_render)
		{
			// Add jelly specific styles
			$this->template->styles += array(
				'css/docs.css'  => 'screen',
			);
		}
	}
	
	public function action_docs()
	{
		// Reset the base URL for links with new routes
		Kodoc_Markdown::$base_url  = URL::site($this->guide->uri()).'/';
		
		$page = $this->request->param('page');

		if ( ! $page)
		{
			// Redirect to the default page
			$this->request->redirect($this->guide->uri(array('page' => 'jelly.getting-started')));
		}

		$file = $this->file($page);

		if ( ! $file)
		{
			throw new Kohana_Exception('User guide page not found: :page',
				array(':page' => $page));
		}

		// Set the page title
		$this->template->title = $this->title($page);

		// Parse the page contents into the template
		$this->template->content = Markdown(file_get_contents($file));

		// Attach the menu to the template
		$this->template->menu = Markdown(file_get_contents($this->file('menu.jelly')));
		
		// Add manual link to API docs
		$this->template->menu .= HTML::anchor($this->api->uri(), 'API Reference', array('class' => 'jelly-api-link'));
		
		// Bind the breadcrumb
		$this->template->bind('breadcrumb', $breadcrumb);

		// Add the breadcrumb
		$breadcrumb = array();
		$breadcrumb['/'] = __('Jelly Home');
		$breadcrumb[$this->guide->uri()] = __('User Guide');
		$breadcrumb[] = $this->section($page);
		$breadcrumb[] = $this->template->title;
	}

	public function action_api()
	{
		// Reset the base URL for links with new routes
		Kodoc_Markdown::$base_url  = URL::site($this->api->uri()).'/';
		
		// Get the class from the request
		$class = $this->request->param('class');
		
		if ( ! $class)
		{
			// Redirect to Jelly class to ensure menu is open
			$this->request->redirect($this->api->uri(array('class' => 'Jelly')));
		}

		// Set the template title
		$this->template->title = $class;

		$this->template->content = View::factory('userguide/api/class')
			->set('doc', Kodoc::factory($class))
			->set('route', $this->request->route);

		// Attach the menu to the template
		$this->template->menu = self::api_menu();

		// Bind the breadcrumb
		$this->template->bind('breadcrumb', $breadcrumb);

		// Add the breadcrumb
		$breadcrumb = array();
		$breadcrumb['/'] = __('Jelly Home');
		$breadcrumb[$this->guide->uri(array('page' => NULL))] = __('User Guide');
		$breadcrumb[$this->request->route->uri()] = __('API Reference');
		$breadcrumb[] = $this->template->title;
	}
	
	public static function api_menu()
	{
		$classes = Kodoc::classes();

		ksort($classes);

		$menu = array();

		$route = Route::get('jelly/docs/api');

		foreach ($classes as $class)
		{
			$class = Kodoc::factory($class);

			$link = HTML::anchor($route->uri(array('class' => $class->class->name)), $class->class->name);
	
			// Only include classes in the Jelly or Jelly Test packages
			if (isset($class->tags['package']))
			{
				foreach ($class->tags['package'] as $package)
				{
					if (in_array($package, array('Jelly', 'Jelly Test')))
					{
						$menu[$package][] = $link;
					}
				}
			}
		}

		// Sort the packages
		ksort($menu);

		$output = array('<ol>');

		foreach ($menu as $package => $list)
		{
			// Sort the class list
			sort($list);

			$output[] =
				"<li><strong>$package</strong>\n\t<ul><li>".
				implode("</li><li>", $list).
				"</li></ul>\n</li>";
		}

		$output[] = '</ol>';

		return implode("\n", $output);
	}
	
	public function section($page)
	{
		$file = $this->file('menu.jelly');

		if ($file AND $text = file_get_contents($file))
		{
			if (preg_match('~\*{2}(.+?)\*{2}[^*]+\[[^\]]+\]\('.preg_quote($page).'\)~mu', $text, $matches))
			{
				return $matches[1];
			}
		}

		return $page;
	}

	public function title($page)
	{
		$file = $this->file('menu.jelly');

		if ($file AND $text = file_get_contents($file))
		{
			if (preg_match('~\[([^\]]+)\]\('.preg_quote($page).'\)~mu', $text, $matches))
			{
				// Found a title for this link
				return $matches[1];
			}
		}

		return $page;
	}
	
} // End  Controller_Docs