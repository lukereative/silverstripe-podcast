# SilverStripe Podcast

A module for adding a podcast or multiple podcasts to your SilverStripe site. With support for audio, video and/or other files.

## Requirements

* SilverStripe 4.1

## Installation

1. Download the Podcast module and place it in your site root. Ensure the module folder name is 'podcast'.
2. Visit your site at `http://example.co.nz/dev/build` to rebuild the database.
3. You will now be able to add a new page type 'Podcast Page'

## Usage

1. Add a 'Podcast Page' in the site tree.
2. Add your desired podcast details under the 'Podcast' tab and attach a podcast artwork
3. Add episodes in the 'Episodes' tab by pressing the green 'Add Podcast Episode Button'. On the resulting page enter your desired episode details, attach the episode file and if you want, an episode image.
4. Once you have added the project page, filled in details and added episodes, you will be able to view your podcast and play/view episodes at the podcast page url. Your RSS Feed http://example.co.nz/$PodcastPage/rss
5. Single episodes are linkable/viewable at http://example.co.nz/$PodcastPage/episode/$ID – $PodcastPage being your podcast page URL and $ID being the unique ID of the podcast (viewable in the CMS)

## Contact
Feel free to email me at <luke@silverstripe.com> with any suggestions, comments or to say thanks. Log any issues on the [GitHub repository](https://github.com/lukereative/silverstripe-podcast) or feel free to issue a pull request with a fix.
