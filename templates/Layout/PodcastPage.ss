<% include PodcastRequirements %>
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
                        <% if $EpisodeImage %>
                        <% with EpisodeImage.setWidth(200) %>
                        <img src="$URL" alt="$Title">
                        <% end_with %>
                        <% end_if %>
                    </figure>
                    <div class="episode__info">
                        <header class="episode__heading">
                        <% if $EpisodeTitle %>
                            <a href="$EpisodeLink"><h2 class="episode__title">$EpisodeTitle</h2></a>
                        <% end_if %>
                        <% if $EpisodeSubtitle %>
                            <h3 class="episode__subtitle">$EpisodeSubtitle</h3>
                        <% end_if %>
                        <% if $EpisodeAuthor %>
                            <h4 class="episode__author">$EpisodeAuthor</h4>
                        <% end_if %>
                        </header>
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
