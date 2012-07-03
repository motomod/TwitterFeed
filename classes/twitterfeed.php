<?php defined('SYSPATH') or die('No direct script access.');

class TwitterFeed {
	
	protected $accounts = array();
	protected $feed_xml = array();
	protected $message_length = 999;
	protected $num_messages = 20;
	
	public static function init()
	{
		return new TwitterFeed;
	}
	
	public function account($username)
	{
		/* Add an account to the list */
		$this->accounts[] = $username;
		return $this;
	}
	
	public function accounts($usernames)
	{
		/* Add a list of accounts to the list */
		$this->accounts = array_merge($this->accounts, $usernames);
		return $this;
	}
	
	private function fetch()
	{
		/* Gets the raw XML data for each account */
		if (function_exists("curl_version") == "Enabled")
		{
			$method = "Curl";
		}
		else
		{
			$method = "Get";
		}
		
		foreach ($this->accounts as $ac)
		{
			$class = "Model_TwitterFeed_Fetch_" . $method;
			$this->feed_xml[$ac] = $class::fetch($ac);
		}
		
		return $this;
	}
	
	private function convert($type)
	{
		$this->fetch();
		$c = Model_TwitterFeed_Convert::factory($this->feed_xml, $this->num_messages, $this->message_length);
		return $c->$type();
	}
	
	public function message_length($num)
	{
		$this->message_length = $num;
		return $this;
	}
	
	public function limit_messages($num)
	{
		$this->num_messages = $num;
		return $this;
	}
	
	public function output($type = "array")
	{
		return $this->convert('to_' . $type);
	}	
}