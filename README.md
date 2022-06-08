# Last.fm RSS Generator

Generate an RSS feed of the recently played or loved tracks from your [Last.fm](https://www.last.fm/) account.

Requires [PHP Simple HTML DOM Parser](https://simplehtmldom.sourceforge.io/) to reside in the same directory as `lastfmrss.php` file.

Based on a fork of Appie Verschoor’s [lastfmrss](https://github.com/xiffy/lastfmrss).

## Demonstration Feed

[splo.me/lastfmrss-working.php?user=ghutchin](https://splo.me/lastfmrss-working.php?user=ghutchin)

## Future Work

- [ ] Look into changing URI structure to use plain directory as end point: `/lastfm/username`
- [ ] Perhaps `/lastfm/username` generates HTML, `/lastfm/username/rss` generates a feed
- [ ] Change file name to `index.php` to accommodate above or handle via .htaccess rewrite
- [ ] Determine how the above changes work with [Kirby](https://getkirby.com/) install
- [ ] Remove duplicate text for artist, since it’s included with the track information
- [ ] Add filtering modes or features via query string attributes, eg:
	- `&mode=text` - text of artist and track only
	- `&mode=link` - link to track page only
- [ ] Add thumbnail size setting via query string attribute ([PR #1](https://github.com/splorp/lastfm-rss/pull/1)), eg:
	- `&size=300` - set the thumbnail size to 300x300 pixels
- [ ] Better handling of passing a null username
- [ ] Add `atom:link` with `rel="self"` per W3C Feed Validator [recommendations](https://validator.w3.org/feed/docs/warning/MissingAtomSelfLink.html)
