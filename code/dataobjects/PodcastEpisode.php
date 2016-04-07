<?php

class PodcastEpisode extends DataObject {
	private static $has_one = array(
		'EpisodeFile' => 'File'
		,'EpisodeImage' => 'Image'
		,'PodcastPage' => 'PodcastPage'
	);

	private static $db = array(
		'EpisodeTitle' => 'VarChar(255)'
		,'EpisodeSubtitle' => 'VarChar(255)'
		,'EpisodeSummary' => 'HTMLText'
		,'EpisodeAuthor' => 'VarChar(127)'
		,'BlockEpisode' => 'Boolean'
		,'ExplicitEpisode' => 'enum("No, Clean, Yes");'
		,'EpisodeDate' => 'SS_Datetime'
		,'EpisodeDuration' => 'Time'
		,'EpisodeKeywords' => 'Text'
	);
	
	
	private static $searchable_fields = array(
		'EpisodeTitle'
		,'EpisodeSubtitle'
		,'EpisodeAuthor'
		,'BlockEpisode'
		,'ExplicitEpisode'
		,'EpisodeDate'
		,'EpisodeKeywords'
	);
	
	private static $summary_fields = array(
		'ID'
		,'EpisodeDate'
		,'EpisodeTitle'
		,'EpisodeDuration'
	);
	
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		
		$fields->fieldByName('Root.Main.EpisodeDate')->dateField->setConfig('showcalendar', true);
		$fields->fieldByName('Root.Main.EpisodeDate')->dateField->setConfig('dateformat', 'dd/MM/YYYY');
		$fields->fieldByName('Root.Main.EpisodeDate')->timeField->setConfig('timeformat', 'HH:MM');
		$fields->fieldByName('Root.Main.EpisodeDate')->setDescription('Date when the episode was published.');
		$fields->fieldByName('Root.Main.EpisodeDate')->setValue(date('r'));
		
		$fields->fieldByName('Root.Main.BlockEpisode')->setDescription('Prevent the <strong>episode</strong> from appearing in the iTunes podcast directory.');
		$fields->fieldByName('Root.Main.ExplicitEpisode')->setDescription("Displays an 'Explicit', 'Clean' or no parental advisory graphic next to your episode in iTunes.");

		$fields->fieldByName('Root.Main.EpisodeFile')
			->setFolderName('podcast/episodes')
			->getValidator()->setAllowedExtensions(array(
				'pdf'
				,'zip'
				,'doc'
				,'docx'
				,'xls'
				,'xlsx'
				,'ppt'
				,'pptx'
				,'mp3'
				,'wav'
				,'m4a'
				,'m4v'
				,'mpeg'
				,'mpg'
				,'mp4'
				,'mpe'
				,'mov'
				,'avi'
				,'3gp'
			));
		
		$fields->fieldByName('Root.Main.EpisodeImage')
			->setFolderName('podcast/episode-images')
			->getValidator()->setAllowedExtensions(array('jpg', 'png'));
		
		return $fields;
	}
	
	/**
	* Returns the absolute link to the episode's page
	* @return string
	*/
	public function EpisodeLink() {
		return $this->PodcastPage()->AbsoluteLink('episode/' . $this->ID);
	}
	
	/**
	* Returns mime type for use in PodcastRSS enclosure
	* @return string
	*/
	public function getMime() {
		$filename = $this->EpisodeFile()->getFilename();
		$filename = explode('.', $filename);
		
		$mime_types = array(
			'pdf' => 'application/pdf'
			,'zip' => 'application/zip'
			,'doc' => 'application/msword'
			,'docx' => 'application/msword'
			,'xls' => 'application/vnd.ms-excel'
			,'xlsx' => 'application/vnd.ms-excel'
			,'ppt' => 'application/vnd.ms-powerpoint'
			,'pptx' => 'application/vnd.ms-powerpoint'
			,'mp3' => 'audio/mpeg'
			,'wav' => 'audio/x-wav'
			,'m4a' => 'audio/x-m4a'
			,'m4v' => 'video/x-m4v'
			,'mpeg' => 'video/mpeg'
			,'mpg' => 'video/mpeg'
			,'mp4' => 'video/mpeg'
			,'mpe' => 'video/mpeg'
			,'mov' => 'video/quicktime'
			,'avi' => 'video/x-msvideo'
			,'3gp' => 'video/3gpp'
		);

		$extension = strtolower(end($filename));

		return $mime_types[$extension];
	}
	
	/**
	* Returns the type for page template for audio, video tags or download link
	* @return string
	*/
	public function getType() {
		// return an empty string if there's no file
		if(!$this->EpisodeFileID){
			return '';
		}
		
		$mime_types = array(
			'mp3' => 'audio'
			,'wav' => 'audio'
			,'m4a' => 'audio'
			,'m4v' => 'video'
			,'mpeg' => 'video'
			,'mpg' => 'video'
			,'mp4' => 'video'
			,'mpe' => 'video'
			,'mov' => 'video'
			,'avi' => 'video'
			,'3gp' => 'video'
		);

		$extension = strtolower($this->EpisodeFile()->getExtension());

		return $mime_types[$extension];
	}
}