<% include PodcastRequirements %>
<% with $PodcastEpisode %><% if not $BlockEpisode %>
<article class="episode">
    <div class="episode__info">
        <figure class="episode__image">
            <% if $EpisodeImage %>
            <% with EpisodeImage.setWidth(200) %>
            <img src="$URL" alt="$Title">
            <% end_with %>
            <% end_if %>
        </figure>
        <div class="episode__info">
            <header class="episode__heading">
            <% if $EpisodeTitle %>
                <h1 class="episode__title">$EpisodeTitle</h1>
            <% end_if %>
            <% if $EpisodeSubtitle %>
                <h2 class="episode__subtitle">$EpisodeSubtitle</h2>
            <% end_if %>
            <% if $EpisodeAuthor %>
                <h3 class="episode__author">$EpisodeAuthor</h2>
            <% end_if %>
            </header>
            <% if EpisodeSummary %>
            <section class="episode__summary">
                $EpisodeSummary
            </section>
            <% end_if %>
            <% if $EpisodeDate || $EpisodeFile %>
            <footer class="episode__details">
                <% if $EpisodeDate %>
                <time datetime="$EpisodeDate.Rfc822" class="episode__date">$EpisodeDate.Format('l jS M')</time>
                <% else %>
                <time datetime="$Created.Rfc822" class="episode__date">$Created.Format('l jS M')</time>
                <% end_if %>
                <% if $getType == 'audio' || $getType == 'video' %>
                <% if EpisodeDate %>, <% end_if %>
                <a href="$EpisodeFile.Link" class="episode__download" download>Download</a> <sub class="episode__download__size">$EpisodeFile.getSize</sub>
                <% end_if %>
            </footer>
            <% end_if %>
        </div>
        <% if $EpisodeFile %>
        <div class="episode__media">
            <% if $getType == 'audio' %>
            <div class="plyr">
                <audio controls>
                    <source src="$EpisodeFile.Link" type="$Mime">
                </audio>
            </div>
            <% else_if $getType == 'video' %>
            <div class="plyr">
                <video controls>
                    <source src="$EpisodeFile.Link" type="$Mime">
                </video>
            </div>
            <% else %>
            <a href="$EpisodeFile.Link" class="episode__download">Download $EpisodeFile.Name</a> <sub class="episode__download__size">$EpisodeFile.getSize</sub>
            <% end_if %>
        </div>
        <% end_if %>
    </div>
</article>
<% else %>
<h2>This episode has been blocked by the podcast manager.</h2>
<p>Please return to the main <a href="$Top.Link">podcast page</a>.</p>
<% end_if %><% end_with %>
