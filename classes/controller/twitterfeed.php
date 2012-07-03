<?php defined('SYSPATH') or die('No direct script access.');

class Controller_TwitterFeed extends Controller {

	public function action_view()
	{
		$this->response->body(Kostache::factory('twitterfeed'));
	}

}