<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Static extends Controller_Template {
	
	public function action_page()
	{
		$page = $this->request->param('page');
		
		$this->template->title = 'Jelly - a compact, powerful ORM for Kohana 3';		
		
		try 
		{
			$this->template->content = View::factory($page);
		}
		catch (Kohana_Exception $e)
		{
			$this->request->status = 404;
			throw new Kohana_Exception('Sorry, that page doesn\'t exist');
		}
	}

} // End Static Controller
