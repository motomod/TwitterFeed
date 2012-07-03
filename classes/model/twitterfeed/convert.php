<?php defined('SYSPATH') or die('No direct script access.');

class Model_TwitterFeed_Convert {
	
	private $clean_feed = NULL;
	private $num_messages = 20;
	private $message_length = 999;
		
	public static function factory($xml, $num_messages, $message_length)
	{
		$convert = new Model_TwitterFeed_Convert;
		$convert->num_messages = $num_messages;
		$convert->message_length = $message_length;
		
		foreach ($xml as $k => $v)
		{		
			$convert->clean_feed[$k] = $convert->read_xml($k, $v);
		}
		
		return $convert;
	}
	
	private function read_xml($username, $xml)
	{
		$sxe = new SimpleXMLElement($xml);
		return $this->clean($sxe->channel);
	}

	private function clean($xml)
	{
		for ($i=0; $i < $this->num_messages; $i++)
		{
			$item = $xml->item[$i];
			$items[$i] = new View_TwitterFeed_Clean($item, $this->message_length);
		}
		
		return $items;
	}
	
	public function to_array()
	{
		$array = array();
		foreach($this->clean_feed as $account => $feed)
		{
			foreach($feed as $i => $f)
			{
				$array[$account][$i]['link'] = $f->link;
				$array[$account][$i]['message'] = $f->message;
				$array[$account][$i]['timeago'] = $f->timeago;
			}
		}

		return $array;
	}

}