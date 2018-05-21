<% require css("lukereative/silverstripe-podcast:client/dist/styles/podcast-page.css") %>
<% with $PodcastEpisode %><% if not $Block %>
<article class="episode">
    <div class="episode__info">
        <figure class="episode__image">
            <% if $Image %>
            <% with $Image.Fill(200, 200) %>
            <img src="$URL" alt="$Title">
            <% end_with %>
            <% end_if %>
        </figure>
        <div class="episode__info">
            <header class="episode__heading">
            <% if $Title %>
                <h1 class="episode__title">$Title</h1>
            <% end_if %>
            <% if $Subtitle %>
                <h2 class="episode__subtitle">$Subtitle</h2>
            <% end_if %>
            <% if $Author %>
                <h3 class="episode__author">$Author</h2>
            <% end_if %>
            </header>
            <% if $Summary %>
            <section class="episode__summary">
                $Summary
            </section>
            <% end_if %>
            <% if $Date || $File %>
            <footer class="episode__details">
                <% if $Date %>
                <time datetime="$Date.Rfc822" class="episode__date">$Date.Format('eeee, d MMM')</time>
                <% else %>
                <time datetime="$Created.Rfc822" class="episode__date">$Created.Format('eeee, d MMM')</time>
                <% end_if %>
                <% if $getType == 'audio' || $getType == 'video' %>
                <% if $Date %>| <% end_if %>
                <a href="$File.Link" class="episode__download" download>Download</a> <sub class="episode__download__size">$File.getSize</sub>
                <% end_if %>
            </footer>
            <% end_if %>
        </div>
        <% if $File %>
        <div class="episode__media">
            <% if $getType == 'audio' %>
            <audio controls>
                <source src="$File.Link" type="$Mime">
            </audio>
            <% else_if $getType == 'video' %>
            <video controls>
                <source src="$File.Link" type="$Mime">
            </video>
            <% else %>
            <a href="$File.Link" class="episode__download">Download $File.Name</a> <sub class="episode__download__size">$File.getSize</sub>
            <% end_if %>
        </div>
        <% end_if %>
    </div>
</article>
<% else %>
<h2>This episode has been blocked by the podcast manager.</h2>
<p>Please return to the main <a href="$Top.Link">podcast page</a>.</p>
<% end_if %><% end_with %>
