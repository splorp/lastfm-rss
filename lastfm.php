<?php

// http://simplehtmldom.sourceforge.net/
require_once ('simple_html_dom.php');

// Optionally set the default Last.fm username, real name, artwork
$user = '';
$name = '';
$cover = 'https://lastfm-img2.akamaized.net/i/u/174s/4128a6eb29f94943c9d206c08e625904';

if (isset($_GET['user'])) {
	$user = urlencode ($_GET['user']);
}

// Grab the HTML for the tracks
if (isset($_GET['loved'])) {
	$type = 'loved';
	$html = file_get_html("https://www.last.fm/user/{$user}/loved?page=1");
} else {
	$type = 'played';
	$html = file_get_html("https://www.last.fm/user/{$user}/library?page=1");
}

// Grab the HTML for the real name
$profile_html = file_get_html("https://www.last.fm/user/{$user}");
foreach($profile_html->find('span[class=header-title-display-name]') as $getname) {
	$name = trim($getname->plaintext);
}

// Start the output
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title><?php echo $name ?> on Last.fm</title>
		<meta name="description" content="Recently <?php echo $type ?> tracks scrobbled on Last.fm by <?php echo $name ?>" />
		<meta name="keywords" content="music, lastfm, scrobble, playlist, <?php echo $user . ', ' . $name ?>" />
	</head>
	<body>
		<header>
			<h1><a href="https://www.last.fm/user/<?php echo $user ?>"><?php echo $name ?></a> on <a href="https://www.last.fm/">Last.fm</a></h1>
			<p>Recently <?php echo $type ?> tracks scrobbled by @<?php echo $user ?>.</p>
		</header>
		<section>
			<ul>
<?php

$i = 0;
foreach($html->find('.js-focus-controls-container') as $row) {
	foreach($row->find('.chartlist-image') as $content) {
		$album = $content->find('img',0)->alt;
		$album_link = $content->find('a',0)->href;
		$cover = $content->find('img',0)->src;
	}
	foreach($row->find('.chartlist-artist') as $content) {
		$artist = $content->find('a',0)->plaintext;
		$artist_link = $content->find('a',0)->href;
	}
	foreach($row->find('.chartlist-name') as $content) {
		$track = $content->find('a',0)->plaintext;
		$track_link = $content->find('a',0)->href;
	}

//		$desc = 'https://www.last.fm'. $link;
//		$desc = '<a href="'.$desc.'">'.$artist.'</a>';
		
//		Grab the HTML for the current track page to extract the cover art
//		$track_html = file_get_html("https://www.last.fm" . $content->find('a',1)->href);
//		foreach($track_html->find('.header-avatar-playlink]') as $track_avatar) {
//			$cover = $track_avatar->find('img',0)->src;
//		}

	foreach($row->find('.chartlist-timestamp') as $timestamp) {
		$span = str_get_html(trim($timestamp->innertext)); // don't ask
		$span->find('span');
		$arr = (array)$span;
		$node = (array) $arr['nodes'][1];
		$timestamp = ($node['attr']['title']);
 		$playdate = gmdate("l, F jS Y g:i:s A", strtotime($timestamp));
	}
?>
				<li>
					<a href="https://www.last.fm<?php echo $artist_link ?>"><?php echo $artist ?></a><br>
					<a href="https://www.last.fm<?php echo $album_link ?>"><?php echo $album ?></a><br>
					<a href="https://www.last.fm<?php echo $track_link ?>"><?php echo $track ?></a><br>
					<?php echo $playdate ?><br>
					<a href="https://www.last.fm<?php echo $album_link ?>"><img src="<?php echo $cover ?>" height="64" width="64" alt="<?php echo $album . ' by ' . $artist ?>" /></a>
				</li>
<?php
	$i++;
}
?>
			</ul>
		</section>
	</body>
</html>
