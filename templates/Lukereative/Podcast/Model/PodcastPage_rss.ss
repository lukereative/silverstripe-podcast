<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" xmlns:atom="http://www.w3.org/2005/Atom">
<channel>
<atom:link href="{$AbsoluteLink}rss" rel="self" type="application/rss+xml" />

<% if $PodcastTitle %><title>$PodcastTitle.XML</title><% end_if %>
<link>$AbsoluteLink</link>
<% if $Language %><language>$Language</language><% end_if %>
<% if $Copyright %><copyright>$Copyright.XML</copyright><% end_if %>
<% if $Subtitle %><itunes:subtitle>$Subtitle.XML</itunes:subtitle><% end_if %>
<% if $Author %><itunes:author>$Author.XML</itunes:author><% end_if %>
<% if $Summary %><itunes:summary>$Summary.NoHTML.XML</itunes:summary>
<description>$Summary.NoHTML.XML</description><% end_if %>
<% if $Categories %>$Categories.RAW<% end_if %>
<% if $OwnerName || $OwnerEmail %><itunes:owner>
    <% if $OwnerName %><itunes:name>$OwnerName.XML</itunes:name><% end_if %>
    <% if $OwnerEmail %><itunes:email>$OwnerEmail.XML</itunes:email><% end_if %>
</itunes:owner><% end_if %>
<% if $PodcastImage %><itunes:image href="$PodcastImage.getAbsoluteURL" /><% end_if %>
<% if $Block %><itunes:block>yes</itunes:block><% end_if %>
<% if $Explicit %><itunes:explicit>$Explicit</itunes:explicit><% end_if %>
<% cached 'Podcast', $List(Lukereative\Podcast\Model\PodcastEpisode).max('LastEdited'), $List(Lukereative\Podcast\Model\PodcastEpisode).count() %>
<% if $podcastEpisodes %><% loop $podcastEpisodes %>
<item>
    <% if $Title %><title>$Title.XML</title><% end_if %>
    <% if $Author %><itunes:author>$Author.XML</itunes:author><% end_if %>
    <% if $Subtitle %><itunes:subtitle>$Subtitle.XML</itunes:subtitle><% end_if %>
    <% if $Summary %><itunes:summary>$Summary.NoHTML.XML</itunes:summary>
    <description>$Summary.NoHTML.XML</description><% end_if %>
    <% if $Image %><itunes:image href="$Image.getAbsoluteURL" /><% end_if %>
    <% if $File %><enclosure url="$File.getAbsoluteURL" length="$File.getAbsoluteSize" type="$getMime" />
    <guid>$Link</guid><% end_if %>
    <% if $Date %><pubDate>$Date.Rfc822</pubDate><% else %><pubDate>$Created.Rfc822</pubDate><% end_if %>
    <% if $Duration %><itunes:duration>$Duration</itunes:duration><% end_if %>
    <% if $Block %><itunes:block>yes</itunes:block><% end_if %>
    <% if $Explicit %><itunes:explicit>$Explicit</itunes:explicit><% end_if %>
</item>
<% end_loop %><% end_if %>
<% end_cached %>
</channel>
</rss>
