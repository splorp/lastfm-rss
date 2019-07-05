# Last.fm RSS Generator

Generate an RSS feed of the recently played or loved tracks from your [Last.fm](https://www.last.fm/) account.

Requires [PHP Simple HTML DOM Parser](https://simplehtmldom.sourceforge.io/) to reside in the same directory as `lastfmrss.php` file.

Based on a fork of Appie Verschoor’s [lastfmrss](https://github.com/xiffy/lastfmrss).

## Demonstration Feed

[https://splo.me/lastfmrss-working.php?user=ghutchin](splo.me/lastfmrss-working.php?user=ghutchin)

## Future Work

- [ ] Look into changing URI structure to use plain directory as end point: `/lastfm/username`
- [ ] Change file name to `index.php` to accommodate above
- [ ] Determine how the above change works with [Kirby](https://getkirby.com/) install
- [ ] Remove duplicate text for artist, since it’s included with the track information
- [ ] Added filtering modes or features via URI attributes, eg:
	- `&mode=text` - text of artist and track only
	- `&mode=link` - link to track page only
- [ ] Better handling of passing a null username
