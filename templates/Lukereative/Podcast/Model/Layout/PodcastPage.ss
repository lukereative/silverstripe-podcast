<% require css("lukereative/silverstripe-podcast:client/dist/styles/podcast-page.css") %>
<section class="PodcastPage">
    <div class="section__image">
        <h1 class="section__title">$Title</h1>
        <% if $Subtitle %><h2 class="podcast__subtitle">$Subtitle</h2><% end_if %>
    </div>
    <div class="section__content">
        <ol class="podcast__episode__list">
            <% loop $paginatedPodcastEpisodes %>
            <li>
                <article class="episode">
                    <figure class="episode__image">
                        <% if $Image %>
                        <% with $Image.Fill(200,200) %>
                        <img src="$URL" alt="$Title">
                        <% end_with %>
                        <% end_if %>
                    </figure>
                    <div class="episode__info">
                        <header class="episode__heading">
                        <% if $Title %>
                            <a href="$EpisodeLink"><h2 class="episode__title">$Title</h2></a>
                        <% end_if %>
                        <% if $Subtitle %>
                            <h3 class="episode__subtitle">$Subtitle</h3>
                        <% end_if %>
                        <% if $Author %>
                            <h4 class="episode__author">$Author</h4>
                        <% end_if %>
                        </header>
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
            </li>
            <% end_loop %>
        </ol>
        <footer class="pagination podcast__pagination">
        <% if $paginatedPodcastEpisodes.MoreThanOnePage %>
            <% if $paginatedPodcastEpisodes.NotFirstPage %><a href="$paginatedPodcastEpisodes.PrevLink" class="pag pag--prev" title="Previous Page">◀︎</a><% end_if %>
            <% loop $paginatedPodcastEpisodes.PaginationSummary(5) %>
            <% if $CurrentBool %><span class="pag pag--current">$PageNum</span>
            <% else_if $Link %><a href="$Link" title="Page $PageNum" class="pag pag--number">$PageNum</a>
            <% else %><span class="pag pag--elip">…</span>
            <% end_if %>
            <% end_loop %>
            <% if $paginatedPodcastEpisodes.NotLastPage %><a href="$paginatedPodcastEpisodes.NextLink" class="pag pag--next" title="Next Page">▶</a><% end_if %>
        <% end_if %>
        </footer>
    </div>
</section>
