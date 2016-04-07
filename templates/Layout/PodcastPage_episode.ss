<% include PodcastRequirements %>
<div class="PodcastEpisode">
<% with PodcastEpisode %><% if not $BlockEpisode %>
	<% if $EpisodeTitle %><h1>$EpisodeTitle</h1><% end_if %>
	<% if $EpisodeImage %><% with EpisodeImage.setWidth(200) %><img src="$URL" alt="$Title" class="left"><% end_with %><% end_if %>
	<% if $EpisodeSubtitle %><h2>$EpisodeSubtitle</h2><% end_if %>
	<% if $EpisodeDate || $EpisodeFile %>
	<div class="episode-details">
		<% if $EpisodeDate %><time datetime="$EpisodeDate.Rfc822">$EpisodeDate.Nice</time><% else %><time datetime="$Created.Rfc822">$Created.Nice</time><% end_if %><% if $getType == 'audio' || $getType == 'video' %><% if EpisodeDate %>, <% end_if %>
		<a href="$EpisodeFile.Link">Download</a> $EpisodeFile.getSize<% end_if %>
	</div>
	<% end_if %>
	<% if EpisodeSummary %><p>$EpisodeSummary</p><% end_if %>
	<% if $EpisodeFile %>
	<div class="episode-media">
		<% if $getType == 'audio' %><audio src="$EpisodeFile.Link" preload="none" controls></audio>
		<% else_if $getType == 'video' %><video src="$EpisodeFile.Link" preload="none" controls width="360"></video>
		<% else %><a href="$EpisodeFile.Link">Download $EpisodeFile.Name</a>
		<% end_if %>
	</div>
	<%end_if %>
	<% else %>
	<h2>This episode has been blocked by the podcast manager.</h2>
	<p>Please return to the main <a href="$Top.Link">podcast page</a>.</p>
<% end_if %><% end_with %>
</div>