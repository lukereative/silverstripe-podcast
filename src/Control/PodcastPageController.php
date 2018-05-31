<?php

namespace Lukereative\Podcast\Control;

use Lukereative\Podcast\Model\PodcastEpisode;
use SilverStripe\CMS\Controllers\ContentController;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Control\RSS\RSSFeed;
use SilverStripe\ORM\PaginatedList;
use SilverStripe\View\Requirements;

class PodcastPageController extends ContentController
{
    private static $allowed_actions = [
        'rss',
        'episode',
    ];

    public function init()
    {
        parent::init();

        // Provides a link to the Podcast RSS in the HTML head
        RSSFeed::linkToFeed($this->Link('rss'));
    }

    /**
     * Returns the RSS Feed at the URL /rss
     * @return SiteTree
     */
    public function rss()
    {
        $this->response->addHeader("Content-Type", "application/xml");
        return $this->renderWith($this->ClassName . '_rss');
    }

    /**
     * Returns a SS_list of podcast episodes for use in the RSS template
     * @return SS_List
     */
    public function podcastEpisodes()
    {
        return PodcastEpisode::get()
            ->filter(['PodcastPageID' => $this->ID])
            ->sort('Date', 'DESC');
    }

    /**
     * Returns a paginated list of podcast episodes for use on the podcast page
     * @return SS_List
     */
    public function paginatedPodcastEpisodes()
    {
        $paginatedList = PaginatedList::create(
            $this->podcastEpisodes()
                ->filter(['Block' => '0'])
                ->sort('Date', 'DESC'),
            $this->request
        );
        $paginatedList->setPageLength(5);
        return $paginatedList;
    }

    /**
     * Returns an episode as a page based on ID parameter at the URL -> $PodcastPage/episode/$ID
     * @return SiteTree
     */
    public function episode(HTTPRequest $request)
    {
        $episode = PodcastEpisode::get()->byID($request->param('ID'));
        if (!$episode) {
            return $this->httpError(404, 'That episode could not be found');
        } return [
            'PodcastEpisode' => $episode
        ];
    }
}
