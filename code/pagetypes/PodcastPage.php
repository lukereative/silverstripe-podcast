<?php

class PodcastPage extends Page {
	private static $icon = 'podcast/images/podcast-page.png';
	private static $description = 'A page that allows the input of podcast information and the addition of episodes to generate a working podcast with a generated RSS Feed';

	private static $db = array(
		'PodcastTitle' => 'VarChar(255)'
		,'Subtitle' => 'VarChar(255)'
		,'Language' => 'VarChar(32)'
		,'Author' => 'VarChar(127)'
		,'Summary' => 'HTMLText'
		,'OwnerName' => 'VarChar(127)'
		,'OwnerEmail' => 'VarChar(127)'
		,'Copyright' => 'VarChar(127)'
		,'Complete' => 'Boolean'
		,'Block' => 'Boolean'
		,'Explicit' => 'enum("No, Clean, Yes");'
		,'Keywords' => 'Text'
	);
	
	private static $has_one = array(
		'PodcastImage' => 'Image'
	);
	
	private static $has_many = array(
		'PodcastEpisodes' => 'PodcastEpisode'
	);
	
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		
		$languageField = new DropdownField('Language', 'Language', array(
			'af' => 'Afrikaans'
			,'sq' => 'Albanian'
			,'eu' => 'Basque'
			,'be' => 'Belarusian'
			,'bg' => 'Bulgarian'
			,'ca' => 'Catalan'
			,'zh-cn' => 'Chinese (Simplified)'
			,'zh-tw' => 'Chinese (Traditional)'
			,'hr' => 'Croatian'
			,'cs' => 'Czech'
			,'da' => 'Danish'
			,'nl' => 'Dutch'
			,'nl-be' => 'Dutch (Belgium)'
			,'nl-nl' => 'Dutch (Netherlands)'
			,'en' => 'English'
			,'en-au' => 'English (Australia)'
			,'en-bz' => 'English (Belize)'
			,'en-ca' => 'English (Canada)'
			,'en-ie' => 'English (Ireland)'
			,'en-jm' => 'English (Jamaica)'
			,'en-nz' => 'English (New Zealand)'
			,'en-ph' => 'English (Phillipines)'
			,'en-za' => 'English (South Africa)'
			,'en-tt' => 'English (Trinidad)'
			,'en-gb' => 'English (United Kingdom)'
			,'en-us' => 'English (United States)'
			,'en-zw' => 'English (Zimbabwe)'
			,'et' => 'Estonian'
			,'fo' => 'Faeroese'
			,'fi' => 'Finnish'
			,'fr' => 'French'
			,'fr-be' => 'French (Belgium)'
			,'fr-ca' => 'French (Canada)'
			,'fr-fr' => 'French (France)'
			,'fr-lu' => 'French (Luxembourg)'
			,'fr-mc' => 'French (Monaco)'
			,'fr-ch' => 'French (Switzerland)'
			,'gl' => 'Galician'
			,'gd' => 'Gaelic'
			,'de' => 'German'
			,'de-at' => 'German (Austria)'
			,'de-de' => 'German (Germany)'
			,'de-li' => 'German (Liechtenstein)'
			,'de-lu' => 'German (Luxembourg)'
			,'de-ch' => 'German (Switzerland)'
			,'el' => 'Greek'
			,'haw' => 'Hawaiian'
			,'hu' => 'Hungarian'
			,'is' => 'Icelandic'
			,'in' => 'Indonesian'
			,'ga' => 'Irish'
			,'it' => 'Italian'
			,'it-it' => 'Italian (Italy)'
			,'it-ch' => 'Italian (Switzerland)'
			,'ja' => 'Japanese'
			,'ko' => 'Korean'
			,'mk' => 'Macedonian'
			,'no' => 'Norwegian'
			,'pl' => 'Polish'
			,'pt' => 'Portuguese'
			,'pt-br' => 'Portuguese (Brazil)'
			,'pt-pt' => 'Portuguese (Portugal)'
			,'ro' => 'Romanian'
			,'ro-mo' => 'Romanian (Moldova)'
			,'ro-ro' => 'Romanian (Romania)'
			,'ru' => 'Russian'
			,'ru-mo' => 'Russian (Moldova)'
			,'ru-ru' => 'Russian (Russia)'
			,'sr' => 'Serbian'
			,'sk' => 'Slovak'
			,'sl' => 'Slovenian'
			,'es' => 'Spanish'
			,'es-ar' => 'Spanish (Argentina)'
			,'es-bo' => 'Spanish (Bolivia)'
			,'es-cl' => 'Spanish (Chile)'
			,'es-co' => 'Spanish (Colombia)'
			,'es-cr' => 'Spanish (Costa Rica)'
			,'es-do' => 'Spanish (Dominican Republic)'
			,'es-ec' => 'Spanish (Ecuador)'
			,'es-sv' => 'Spanish (El Salvador)'
			,'es-gt' => 'Spanish (Guatemala)'
			,'es-hn' => 'Spanish (Honduras)'
			,'es-mx' => 'Spanish (Mexico)'
			,'es-ni' => 'Spanish (Nicaragua)'
			,'es-pa' => 'Spanish (Panama)'
			,'es-py' => 'Spanish (Paraguay)'
			,'es-pe' => 'Spanish (Peru)'
			,'es-pr' => 'Spanish (Puerto Rico)'
			,'es-es' => 'Spanish (Spain)'
			,'es-uy' => 'Spanish (Uruguay)'
			,'es-ve' => 'Spanish (Venezuela)'
			,'sv' => 'Swedish'
			,'sv-fi' => 'Swedish (Finland)'
			,'sv-se' => 'Swedish (Sweden)'
			,'tr' => 'Turkish'
			,'uk' => 'Ukranian'
		));
		$languageField
			->setHasEmptyDefault(true)
			->setEmptyString('Select Language');
		
		$podcastImage = new UploadField('PodcastImage', 'Podcast Image');
		$podcastImage
			->setFolderName('podcast/podcast-artwork')
			->setDescription("iTunes recommends a size of at least 1400x1400")
			->getValidator()->setAllowedExtensions(array('jpg', 'png'));
		
		$completeField = new CheckboxField('Complete');
		$completeField->setDescription('This podcast is complete. No more episodes will be added to the podcast.');
		
		$blockField = new CheckboxField('Block');
		$blockField->setDescription('Prevent the <strong>entire</strong> podcast from appearing in the iTunes podcast directory.');
		
		$explicitField = new DropdownField('Explicit', 'Explicit', $this->dbObject('Explicit')->enumValues());
		$explicitField->setDescription("Displays an 'Explicit', 'Clean' or no parental advisory graphic next to your podcast artwork in iTunes.");
		
		$fields->addFieldsToTab('Root.Podcast', array(
			new TextField('PodcastTitle', 'Podcast Title')
			,new TextField('Subtitle')
			,$languageField
			,new TextField('Author')
			,new TextAreaField('Summary')
			,new TextField('OwnerName', 'Owner Name')
			,new EmailField('OwnerEmail', 'Owner Email')
			,new TextField('Copyright')
			,$completeField
			,$blockField
			,$explicitField
			,new TextAreaField('Keywords')
			,$podcastImage
		));
		
		$config = GridFieldConfig_RelationEditor::create();
		
		$episodesTable = new GridField(
			'PodcastEpisodes'
			,'Podcast Episodes'
			,$this->PodcastEpisodes()->sort('EpisodeDate', 'DESC')
			,$config
		);
		
		$fields->addFieldToTab('Root.Episodes', $episodesTable);
		
		return $fields;
	}
}

class PodcastPage_Controller extends Page_Controller {
	private static $allowed_actions = array(
		'rss', 'episode'
	);

	public function init() {
		// Provides a link to the Podcast RSS in the HTML head
		RSSFeed::linkToFeed($this->Link('rss'));
		
		parent::init();
	}
	
	/**
	 * Returns the RSS Feed at the URL /rss
	 * @return SiteTree
	 */
	public function rss() {
		return $this->renderWith("PodcastRSSFeed");
	}
	
	/**
	 * Returns a SS_list of podcast episodes for use in the RSS template
	 * @return SS_List
	 */
	public function podcastEpisodes() {
		return PodcastEpisode::get()
			->filter(array('PodcastPageID' => $this->ID))
			->sort('EpisodeDate', 'DESC')
		;
	}
	

	/**
	 * Returns a paginated list of podcast episodes for use on the podcast page
	 * @return SS_List
	 */
	public function paginatedPodcastEpisodes() {
		$paginatedList = new PaginatedList(
			$this->podcastEpisodes()
				->filter(array('BlockEpisode' => '0'))
				->sort('EpisodeDate', 'DESC')
				, $this->request
		);
		$paginatedList->setPageLength(5);
		return $paginatedList;
	}
	
	/**
	 * Returns an episode as a page based on ID parameter at the URL -> $PodcastPage/episode/$ID
	 * @return SiteTree
	 */
	public function episode() {
		$episode = PodcastEpisode::get()->byID($this->Request->param("ID"));
		if(!$episode) return $this->httpError(404);
		return array("PodcastEpisode" => $episode);
	}
}