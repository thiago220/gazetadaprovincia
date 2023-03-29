<?php get_header(); ?>
<main>
    <div class="container">
        <div class="row">         
            <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
            <?php /* If this is a category archive */ if (is_category()) { ?>
            <h2> Arquivo do Caderno "<?php echo single_cat_title(); ?>" </h2>
            <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
            <h2>    Arquivo de <?php the_time('j de F de Y'); ?> </h2>
            <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
            <h2>    Arquivo de <?php the_time('F de Y'); ?> </h2>
            <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
            <h2>    Arquivo de <?php the_time('Y'); ?></h2>
            <?php /* If this is an author archive */ } elseif (is_author()) { ?>
            <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
            <h2>   Arquivo do jornal </h2>
            <?php } ?>
             
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                    <div class="media py-1 border my-1">                        
                        <?php the_post_thumbnail('thumbnail',['class'=>'mr-3']);?> 
                        <div class="media-body p-2">
                            <a href="<?php the_permalink() ?>">
                                <h5 class="mt-0"><?php the_title(); ?></h5>
                                <small>Postado por <?php the_author() ?> em <?php the_time('d/M/Y') ?></small>
                            </a>
                            <?php $args = array(
                                'title_li' => '',
                                'separator'=> ' > ',
                            );?>
                            <small></small>
                            <a href="<?php the_permalink() ?>">
                                <?php the_excerpt()?>
                            </a>
                        </div>
                    </div>        
            <?php endwhile;
                page_navi("<div class='w-100 p-1 d-flex justify-content-center align-items-center'>","</div>");
                    
            else: ?>
                <div class="artigo">
                    <h2>Arquivo</h2>
                    <p>Erro 404</p>
                    <p>Lamentamos mas não foram encontrados artigos.</p>
                </div>            
            <?php endif; ?>
             
        </div>
         
        <?php get_sidebar();?>
    </div>
</main>
<?php get_footer(); ?>