<?php

namespace Lukereative\Podcast\Model;

use GetId3\GetId3Core;
use Lukereative\Podcast\Model\PodcastPage;
use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBDatetime;
use SilverStripe\Security\Permission;

class PodcastEpisode extends DataObject
{
    private static $table_name = 'PodcastEpisode';

    private static $has_one = [
        'File' => File::class,
        'Image' => Image::class,
        'PodcastPage' => PodcastPage::class,
    ];

    private static $owns = [
        'File',
        'Image',
    ];

    private static $db = [
        'Title' => 'Varchar(255)',
        'Subtitle' => 'Varchar(255)',
        'Summary' => 'HTMLText',
        'Author' => 'Varchar(127)',
        'Block' => 'Boolean',
        'Explicit' => 'Enum("No, Clean, Yes");',
        'Date' => 'Datetime',
        'Duration' => 'Time',
    ];

    private static $searchable_fields = [
        'Title',
        'Subtitle',
        'Author',
        'Block',
        'Explicit',
        'Date',
    ];

    private static $summary_fields = [
        'Thumb' => '',
        'Date' => 'Date',
        'Title' => 'Title',
        'Duration' => 'Duration',
    ];

    private static $better_buttons_actions = [
        'getTags'
    ];

    public function populateDefaults()
    {
        parent::populateDefaults();

        $this->Date = DBDatetime::now()->value;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->fieldByName('Root.Main.Date')
            ->setDescription('Date when the episode was published.');

        $fields->fieldByName('Root.Main.Duration')
            ->setHTML5(false)
            ->setTimeFormat('HH:mm:ss')
            ->setDescription('In the format HH:mm:ss e.g. 00:56:18');

        $fields->fieldByName('Root.Main.Block')
            ->setDescription('Prevent the <strong>episode</strong> from appearing in the iTunes podcast directory.');
        $fields->fieldByName('Root.Main.Explicit')
            ->setDescription("Displays an 'Explicit', 'Clean' or no parental advisory graphic next to your episode in iTunes.");

        $fileField = $fields->fieldByName('Root.Main.File');
        $fileField->setFolderName('podcast/episodes')
            ->getValidator()->setAllowedExtensions(
                [
                    'pdf',
                    'epub',
                    'mp3',
                    'wav',
                    'm4a',
                    'm4v',
                    'mp4',
                    'mov',
                ]
            );

        // Show a help message if the episode is not saved or it doesn't have a file added
        if ($this->ID === 0 || !$this->File()->exists()) {
            $fileField->setDescription(
                "If you wish to import episode details from the file ID3 tags, first upload a file and 'Create' the episode.<br>
                Then a 'Get ID3 tags' action will be available"
            );
        }
        $fields->insertBefore('Title', $fileField);

        $imageField = $fields->fieldByName('Root.Main.Image');
        $imageField->setFolderName('podcast/episode-images')
            ->getValidator()->setAllowedExtensions(['jpg', 'png']);
        $fields->insertBefore('Title', $imageField);

        $fields->removeByName('PodcastPageID');
        return $fields;
    }

    /**
     * Returns the absolute link to the episode's page
     *
     * @return string
     */
    public function episodeLink()
    {
        return $this->PodcastPage()->AbsoluteLink('episode/' . $this->ID);
    }

    /**
     * Returns the relative link to the episode's page
     *
     * @return string
     */
    public function relativeEpisodeLink()
    {
        return $this->PodcastPage()->RelativeLink('episode/' . $this->ID);
    }

    /**
     * Returns a thumbnail of the Episode Image
     *
     * @return Image
     */
    public function thumb()
    {
        return $this->Image()->fill(40, 40);
    }

    /**
     * Returns mime type for use in PodcastRSS enclosure
     *
     * @return string
     */
    public function getMime()
    {
        // return an empty string if there's no file
        if (!$this->FileID) {
            return '';
        }

        $filename = $this->File()->getFilename();
        $filename = explode('.', $filename);

        $mime_types = array(
            'pdf' => 'application/pdf',
            'epub' => 'document/x-epub',
            'mp3' => 'audio/mpeg',
            'wav' => 'audio/x-wav',
            'm4a' => 'audio/x-m4a',
            'm4v' => 'video/x-m4v',
            'mp4' => 'video/mp4',
            'mov' => 'video/quicktime',
        );

        $extension = strtolower(end($filename));

        return $mime_types[$extension];
    }

    /**
     * Returns the type for page template for audio, video tags or download link
     *
     * @return string
     */
    public function getType()
    {
        if (!$this->FileID) {
            return '';
        }
        $mime = explode('/', $this->getMime());

        return $mime[0];
    }

    public function canView($member = null)
    {
        return true;
    }

    public function canEdit($member = null)
    {
        return Permission::check('PODCAST_ADMIN');
    }

    public function canDelete($member = null)
    {
        return Permission::check('PODCAST_ADMIN');
    }

    public function canCreate($member = null, $parent = null)
    {
        return Permission::check('PODCAST_ADMIN');
    }
}
