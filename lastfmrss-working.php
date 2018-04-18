<?php

// http://simplehtmldom.sourceforge.net/
require_once ('simple_html_dom.php');

// Optionally set the default Last.fm username and real name
$user = '';
$name = '';

if (isset($_GET['user'])) {
	$user = urlencode ($_GET['user']);
}

// Grab the HTML for the tracks
if (isset($_GET['loved'])) {
	$type = 'loved';
	$html = file_get_html("http://www.last.fm/user/{$user}/loved?page=1");
} else {
	$type = 'played';
	$html = file_get_html("http://www.last.fm/user/{$user}/library?page=1");
}

// Grab the HTML for the real name
$profile_html = file_get_html("http://www.last.fm/user/{$user}");
foreach($profile_html->find('span[class=header-title-display-name]') as $getname) {
	$name = trim($getname->plaintext);
}

// Start the output
header("Content-Type: application/rss+xml");
header("Content-type: text/xml; charset=utf-8");
?>

<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
	<channel>
		<lastBuildDate><?php echo gmdate(DATE_RFC822, time()) ?></lastBuildDate>
		<language>en</language>
		<title><?php echo $name ?> on Last.fm</title>
		<description>
			<?php echo $name ?> on Last.fm
		</description>
		<link>http://www.last.fm/user/<?php echo $user ?></link>
		<ttl>960</ttl>
		<generator>splo.me</generator>
		<category>Personal</category>
<?php

$i = 0;
foreach($html->find('.js-focus-controls-container') as $row) {
	foreach($row->find('.chartlist-name') as $content) {
		$artist = $content->find('a',0)->plaintext;
		$title = $content->find('a',1)->plaintext;
		$link = $content->find('a',1)->href;
		$cover = 'https://lastfm-img2.akamaized.net/i/u/174s/4128a6eb29f94943c9d206c08e625904';

//		$desc = 'https://www.last.fm'. $link;
//		$desc = '<a href="'.$desc.'">'.$artist.'</a>';
		
//		Grab the HTML for the current track page to extract the cover art
//		$track_html = file_get_html("http://www.last.fm" . $content->find('a',1)->href);
//		foreach($track_html->find('.header-avatar-playlink]') as $track_avatar) {
//			$cover = $track_avatar->find('img',0)->src;
//		}
	}
	foreach($row->find('.chartlist-timestamp') as $timestamp) {
		$span = str_get_html(trim($timestamp->innertext)); // don't ask
		$span->find('span');
		$arr = (array)$span;
		$node = (array) $arr['nodes'][1];
		$timestamp = ($node['attr']['title']);
 		$playdate = gmdate(DATE_RFC822, strtotime($timestamp));
 		$desc = gmdate("l, F jS g:i:s A", strtotime($timestamp));
	}
?>
		<item>
			<title><?php echo $artist.' — '.$title ?></title>
			<pubDate><?php echo $playdate; ?></pubDate>
			<link>http://www.last.fm<?php echo $link ?></link>
			<guid isPermaLink="false"><?php echo $link ?></guid>
			<description><![CDATA[<?php echo $desc?>]]></description>
			<media:content 
				xmlns:media="http://search.yahoo.com/mrss/" 
				url="<?php echo $cover ?>" 
				medium="image" 
				type="image/jpeg" 
				width="174" 
				height="174" />
		</item>

<?php
	$i++;
}
?>
	</channel>
</rss>
