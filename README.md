# lastfmrss

Generate an RSS feed of the recently played or loved tracks from your Last.fm account.

Requires [PHP Simple HTML DOM Parser](http://simplehtmldom.sourceforge.net/) to reside in the same directory as `lastfmrss.php` file.

Based on a fork of Appie Verschoor’s [lastfmrss](https://github.com/xiffy/lastfmrss).

To do:

- [ ] Strip trailing spaces from `realname`
- [ ] Possibly change URI to use plain directory as end point: `/lastfm/username`
- [ ] Change file name to `index.php` to accommodate above
- [ ] Determine whether file name change is affected on [Kirby](https://getkirby.com/) installs
- [ ] Added filtering/features via URI attributes (see below)
- [ ] Remove duplicate text for artist, since it’s included with the track information

+ `&simple` - text of track titles only
+ `&links` - links to track only
