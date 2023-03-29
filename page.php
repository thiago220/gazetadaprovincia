<?php get_header();?>
<main>
    <div class="container">
        <h1><?=the_title();?></h1> 
        <article>
            <?=the_content()?>
        </article>
    </div>
</main>
<?php get_footer();?>