<?php get_header(); ?>
<main>
    <div class="container">
        <h1><?= the_title(); ?></h1> 
        <article>
            <h2>Leia aqui seu horóscopo do dia <?= strftime('%d de %B de %Y', strtotime('today')) ?>.</h2>
            <?php

            function getFeed($feed_url) {

                $content = file_get_contents($feed_url);
                $x = new SimpleXmlElement($content);

                echo "<div class='row'>";

                foreach ($x->channel->item as $entry) {
                    echo "<div class='col col-md-6'><h3>$entry->title</h3><p class='text-justify'>$entry->description</p></div>";
                }
                echo "</div>";
            }

            getFeed("http://pt.horoscopofree.com/rss/horoscopofree-pt.rss");
            echo the_content();
            ?>
            <script>
                $(document).ready(function () {
                    $("div").each(function () {
                        $(this).html($(this).html().replace('Inscreve-te ao Horóscopo grástis em e-mail!', ''));
                    });
                });
            </script>
        </article>
    </div>
</main>
<?php get_footer(); ?>