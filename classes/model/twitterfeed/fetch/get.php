<?php defined('SYSPATH') or die('No direct script access.');

class Model_TwitterFeed_Fetch_Get extends Model_TwitterFeed_Fetch {
	
	public static function fetch($username)
	{
		$fetch = new Model_TwitterFeed_Fetch_Get;
		return file_get_contents($fetch->feed_url . $username);
	}
	
	
}