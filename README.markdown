# TwitterFeed

A quick and simple Feed parser for Kohana 3.2. Written quickly to provide the results that I specifically needed for my project.

## Features

* Multiple accounts
* Automatic #hasbang and @link replacement
* Timeago timestamp

## Usage

Either call as a new Class:

    $twitter = new TwitterFeed;
	$twitter->account('asdaprice');
	$twitter->output();
	
Alternatively, use the init function:

    $twitter = TwitterFeed::init()->account('asdaprice')->output();

That's about it for now, will comment and update shortly.