<?php

// http://simplehtmldom.sourceforge.net/
require_once ('simple_html_dom.php');

// Set the default Last.fm account to be used if no user is specified
$user = '';

if (isset($_GET['user'])) {
	$user = urlencode ($_GET['user']);
}
if (isset($_GET['loved'])) {
	$type = 'loved';
	$html = file_get_html("http://www.last.fm/user/{$user}/loved?page=1");
} else {
	$type = 'played';
	$html = file_get_html("http://www.last.fm/user/{$user}/library?page=1");
}


// Start the output
header("Content-Type: application/rss+xml");
header("Content-type: text/xml; charset=utf-8");
?>

<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
	<channel>
		<lastBuildDate><?php echo gmdate(DATE_RFC822, time()) ?></lastBuildDate>
		<language>en</language>
		<title>Last.fm : <?php echo $user ?> just <?php echo $type ?></title>
		<description>
			Last.fm : <?php echo $user ?> just <?php echo $type ?>
		</description>
		<link>http://www.last.fm/user/<?php echo $user ?></link>
		<ttl>960</ttl>
		<generator>lastfmrss</generator>
		<category>Personal</category>
<?php

$i = 0;
foreach($html->find('.js-focus-controls-container') as $row) {
	foreach($row->find('.chartlist-name') as $content) {
		$artist = $content->find('a',0)->plaintext;
		$title = $content->find('a',1)->plaintext;
		$link = $content->find('a',1)->href;

		$desc = 'https://www.last.fm'. $link;
		$desc = '<a href="'.$desc.'">'.$artist.'</a>';
	}
	foreach($row->find('.chartlist-timestamp') as $timestamp) {
		$span = str_get_html(trim($timestamp->innertext)); // don't ask
		$span->find('span');
		$arr = (array)$span;
		$node = (array) $arr['nodes'][1];
		$da_time = ($node['attr']['title']);

 		$playdate = gmdate(DATE_RFC822, strtotime($da_time));
	}
?>
		<item>
			<title><?php echo $artist.' — '.$title ?> </title>
			<pubDate><?php echo $playdate; ?></pubDate>
			<link>http://www.last.fm<?php echo $link ?></link>
			<guid isPermaLink='false'><?php echo $link ?></guid>
			<description><![CDATA[<?php echo $desc?>]]></description>
		</item>

<?php
	$i++;
}
?>
	</channel>
</rss>
