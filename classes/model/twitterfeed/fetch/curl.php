<?php defined('SYSPATH') or die('No direct script access.');

class Model_TwitterFeed_Fetch_Curl extends Model_TwitterFeed_Fetch {
	
	public static function fetch($username)
	{
		$fetch = new Model_TwitterFeed_Fetch_Curl;
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $fetch->feed_url . $username);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		$data = curl_exec($ch);
		curl_close($ch);
		
		return $data;
	}
	
	
}