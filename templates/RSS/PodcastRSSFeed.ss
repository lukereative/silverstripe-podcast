<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd">
<channel>
<atom:link href="{$AbsoluteLink}rss" rel="self" type="application/rss+xml" />

<% if $Title %><title>$Title</title><% end_if %>
<link>$AbsoluteLink</link>
<% if $Language %><language>$Language</language><% end_if %>
<% if $Copyright %><copyright>$Copyright.XML</copyright><% end_if %>
<% if $Subtitle %><itunes:subtitle>$Subtitle.XML</itunes:subtitle><% end_if %>
<% if $Author %><itunes:author>$Author.XML</itunes:author><% end_if %>
<% if $Summary %>
<itunes:summary>$Summary.NoHTML.XML</itunes:summary>
<description>$Summary.NoHTML.XML</description>
<% end_if %>
<% if $OwnerName || $OwnerEmail %>
<itunes:owner>
	<% if $OwnerName %><itunes:name>$OwnerName.XML</itunes:name><% end_if %>
	<% if $OwnerEmail %><itunes:email>$OwnerEmail.XML</itunes:email><% end_if %>
</itunes:owner>
<% end_if %>
<% if $PodcastImage %><itunes:image href="$PodcastImage.getAbsoluteURL" /><% end_if %>
<% if $Block %><itunes:block>yes</itunes:block><% end_if %>
<% if $Explicit %><itunes:explicit>$Explicit</itunes:explicit><% end_if %>

<% if $podcastEpisodes %><% loop $podcastEpisodes %>
<item>
	<% if $EpisodeTitle %><title>$EpisodeTitle.XML</title><% end_if %>
	<% if $EpisodeAuthor %><itunes:author>$EpisodeAuthor.XML</itunes:author><% end_if %>
	<% if $EpisodeSubtitle %><itunes:subtitle>$EpisodeSubtitle.XML</itunes:subtitle><% end_if %>
	<% if $EpisodeSummary %>
	<itunes:summary>$EpisodeSummary.NoHTML.XML</itunes:summary>
	<description>$EpisodeSummary.NoHTML.XML</description>
	<% end_if %>
	<% if $EpisodeImage %><itunes:image href="$EpisodeImage.getAbsoluteURL" /><% end_if %>
	<% if $EpisodeFile %><enclosure url="$EpisodeFile.getAbsoluteURL" length="$EpisodeFile.getAbsoluteSize" type="$getMime" />
	<guid>$EpisodeLink</guid><%end_if %>
	<% if $EpisodeDate %><pubDate>$EpisodeDate.Rfc822</pubDate><% else %><pubDate>$Created.Rfc822</pubDate><% end_if %>
	<% if $EpisodeDuration %><itunes:duration>$EpisodeDuration</itunes:duration><% end_if %>
	<% if $BlockEpisode %><itunes:block>yes</itunes:block><% end_if %>
	<% if $ExplicitEpisode %><itunes:explicit>$ExplicitEpisode</itunes:explicit><% end_if %>
</item>
<% end_loop %><% end_if %>
</channel>
</rss>