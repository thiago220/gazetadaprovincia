<?php get_header(); ?>
<div class="conteudo py-4">
    <div class="container">
        <div id="artigos">
         
            <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
            <?php /* If this is a category archive */ if (is_category()) { ?>
                Arquivo da Categoria "<?php echo single_cat_title(); ?>"
            <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
                Arquivo de <?php the_time('j de F de Y'); ?>
            <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
                Arquivo de <?php the_time('F de Y'); ?>
            <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
                Arquivo de <?php the_time('Y'); ?>
            <?php /* If this is an author archive */ } elseif (is_author()) { ?>
                Arquivo do Autor
            <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
                Arquivo do Blog
            <?php } ?>
             
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <div class="media my-5">
                        <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail('thumbnail', ['class' => 'rounded-circle']);?>
                        <?php else: ?>
                        <img class="rounded-circle wp-post-image" src="<?=get_template_directory_uri()?>/img/no-image.png" alt="Imagem indisponível" width="150px" height="150px">
                            <?php endif;?>                
                        <div class="ml-2 media-body">
                            <h5 class="mt-0"><?php the_title()?></h5>
                            <?php the_excerpt()?>
                            <a class="leia-mais text-center px-2 font-regular" href="<?php  the_permalink()?>">Leia mais...</a>
                        </div>
                </div>            
            <?php endwhile?>
                <div class="navegacao">
                    <div class="recentes"><?php next_posts_link('&laquo; Artigos Anteriores') ?></div>
                    <div class="anteriores"><?php previous_posts_link('Artigos Recentes &raquo;') ?></div>
                </div>
            <?php else: ?>
                <div class="artigo">
                    <h2>Nada Encontrado</h2>
                    <p>Erro 404</p>
                    <p>Lamentamos mas não foram encontrados artigos.</p>
                </div>            
            <?php endif; ?>
             
        </div>
         
        <?php get_sidebar(); ?>
    </div>
</div>
<?php get_footer();