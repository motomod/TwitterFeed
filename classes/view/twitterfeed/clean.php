<?php defined('SYSPATH') or die('No direct script access.');

class View_TwitterFeed_Clean {
	
	public function __construct($item, $message_length)
	{
		$this->link = (string)$item->link;
		$this->message($item, $message_length);
		$this->dateify($item);
	}
	
	private function message($item, $message_length)
	{
		$message = substr($item->title, (strpos($item->title, ':') + 2));
		
		if (strlen($message) > $message_length)
		{
			$message = substr($message, 0, $message_length);
		}
		
		$message = $this->link_replace($message);
		$message = $this->user_replace($message);
		$message = $this->hash_replace($message);
		$this->message = $message;		
	}
	
	function dateify($item) {
		$date = $item->pubDate;
		$this->timeago = $this->timeago(strtotime($date));
	}
	
	private function link_replace($message)
	{
		preg_match_all('^((https?|ftp|gopher|telnet|file|notes|ms-help):((//)|(\\\\))+[\w\d:#@%/;$()~_?\+-=\\\.&]*)^', $message, $urls);
		if (count($urls) > 0)
		{
			foreach ($urls[0] as $i => $url) {
				$message = str_replace($url, '<a target="_blank" href="'. $url .'">'. $url .'</a>', $message);
			}
		}
		
		return $message;
	}
	
	private function user_replace($message)
	{
		preg_match_all('/(^|\s)@(\w+)/', $message, $names);
		if (count($names) > 0)
			{
				foreach ($names[0] as $i => $name) {
				$message = str_replace($name, '<a target="_blank" href="https://twitter.com/#!/'. ltrim($name, " @") .'">'. $name .'</a>', $message);
			}
		}
		
		return $message;
	}
	
	private function hash_replace($message)
	{
		preg_match_all('^#([A-Za-z0-9_]+)^', $message, $tags);
		if (count($tags) > 0)
		{
			foreach ($tags[0] as $i => $tag) {
				$message = str_replace($tag, '<a target="_blank" href="http://search.twitter.com/search?q='. $tags[1][$i] .'">'. $tag .'</a>', $message);
			}
		}
		
		return $message;
	}
	
	private function timeago($t) {
			$d = time() - $t;
			switch ($d) {
				case ($d > 86400):
				return date('d M y', $t);
				case ($d < 60):
				return $d . ' seconds ago';
				case ($d < 3600):
				return round($d / 60) . ' minutes ago';
				case ($d < 86400):
				return round($d / 3600) . ' hours ago';
			}
		}
	
}