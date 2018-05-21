<?php

namespace Lukereative\Podcast\Extensions;

use GetId3\GetId3Core;
use SilverStripe\Control\Director;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\FormAction;
use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\ValidationResult;
use SilverStripe\Versioned\VersionedGridFieldItemRequest;

class GetID3Tags extends DataExtension
{
    /**
     * Build the set of form field actions for this DataObject
     *
     * @return FieldList
     */
    public function updateFormActions(FieldList $actions)
    {
        $record = $this->owner->getRecord();
        $canEdit = $record->canEdit();

        if ($record instanceof PodcastEpisode && $canEdit && $record->File()->exists()) {
            $actions->push(FormAction::create('getTags', 'Get ID3 Tags')
                ->setUseButtonTag(true)
                ->addExtraClass('btn-primary font-icon-tag'));
        }
    }

    public function getTags($data, $form)
    {
        $record = $this->owner->getRecord();
        
        if (!$record->File()->exists() ||
            !Director::publicFolder() ||
            !file_exists(Director::publicFolder() . $record->File()->getURL())) {
            // Check if the file exists on the local filesystem
            // Show a warning if one isn't found (remote files are not supported)
            $message = [
                'text' => 'Could not retreive tags, please check the episode file',
                'type' => 'warning',
            ];
            $form->sessionMessage($message['text'], $message['type'], ValidationResult::CAST_HTML);
            return $form->forTemplate();
        }

        $getID3 = new GetId3Core;
        $file = $getID3->analyze(Director::publicFolder() . $record->File()->getURL());

        // This maps the raw ID3 tag names to the field names of the PodcastEpisode dataobject
        $mappings = [
            'title' => 'Title',
            'artist' => 'Author',
            'comment' => 'Summary',
            'playtime_seconds' => 'Duration',
        ];

        if ($file
            && isset($file['tags'])
            && array_key_exists('id3v2', $file['tags'])
            && !empty($file['tags']['id3v2'])) {
            // If we get a valid list of tags from the file, map the tag values to the correct field
            $tags = $file['tags']['id3v2'];

            if (array_key_exists('playtime_seconds', $file)) {
                $tags['playtime_seconds'] = [gmdate('H:i:s', $file['playtime_seconds'])];
            }

            foreach ($mappings as $tag => $field) {
                if (array_key_exists($tag, $tags) && !empty($tags[$tag])) {
                    $data[$field] = $tags[$tag][0];
                }
            }

            // Load the new values into the form
            $form->loadDataFrom($data);

            $message = [
                'text' => 'Successfully retrieved tags, verify or edit changes before',
                'type' => 'good',
            ];
        } else {
            $message = [
                'text' => 'Could not retreive tags, please check the episode file',
                'type' => 'warning',
            ];
        }

        $form->sessionMessage($message['text'], $message['type'], ValidationResult::CAST_HTML);

        // Return the form with a status message and if successful, the new field values
        return $form->forTemplate();
    }
}
