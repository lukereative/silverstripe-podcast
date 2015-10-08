<% include PodcastRequirements %>
div class="podcast">
	<header class="podcast-details">
		<% if $PodcastTitle %><h1>$PodcastTitle</h1><% end_if %>
		<% if $PodcastImage %><% with PodcastImage.setWidth(200) %><img src="$URL" alt="$Title" class="left"><% end_with %><% end_if %>
		<% if $Subtitle %><h2>$Subtitle</h2><% end_if %>
		<% if $Summary %><p>$Summary</p><% end_if %>
	</header>
	<ol class="podcast-episodes">
	<% loop $paginatedPodcastEpisodes %>
	<li class="episode">
		<% if $EpisodeTitle %><a href="$EpisodeLink"><h3>$EpisodeTitle</h3></a><% end_if %>
		<% if $EpisodeImage %><% with EpisodeImage.setWidth(75) %><img src="$URL" alt="$Title" class="left"><% end_with %><% end_if %>
		<% if $EpisodeSubtitle %><h4>$EpisodeSubtitle</h4><% end_if %>
		<% if $EpisodeDate || $EpisodeFile %>
		<div class="episode-details">
			<% if $EpisodeDate %><time datetime="$EpisodeDate.Rfc822">$EpisodeDate.Nice</time><% else %><time datetime="$Created.Rfc822">$Created.Nice</time><% end_if %><% if $getType == 'audio' || $getType == 'video' %><% if EpisodeDate %>, <% end_if %>
			<a href="$EpisodeFile.Link">Download</a> $EpisodeFile.getSize<% end_if %>
		</div>
		<% end_if %>
		<% if $EpisodeFile %>
		<div class="episode-media">
			<% if $getType == 'audio' %><audio src="$EpisodeFile.Link" preload="none" controls></audio>
			<% else_if $getType == 'video' %><video src="$EpisodeFile.Link" preload="none" controls width="360"></video>
			<% else %><a href="$EpisodeFile.Link">Download $EpisodeFile.Name</a>
			<% end_if %>
		</div>
		<%end_if %>
	</li>
	<% end_loop %>
	</ol>
	<footer class="episode-pagination">
	<% if $paginatedPodcastEpisodes.MoreThanOnePage %>
		<% if $paginatedPodcastEpisodes.NotFirstPage %><a href="$paginatedPodcastEpisodes.PrevLink" class="prev" title="Previous Page">◀</a><% end_if %>
		<% loop $paginatedPodcastEpisodes.PaginationSummary(5) %>
		<% if $CurrentBool %>$PageNum
		<% else_if $Link %><a href="$Link" title="Page $PageNum">$PageNum</a>
		<% else %>…
		<% end_if %>
		<% end_loop %>
		<% if $paginatedPodcastEpisodes.NotLastPage %><a href="$paginatedPodcastEpisodes.NextLink" class="next" title="Next Page">▶</a><% end_if %>
	<% end_if %>
	</footer>
</div>