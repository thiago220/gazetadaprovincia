<?php get_header(); ?>
    <div class="conteudo py-4">
        <div class="container">
            <article id="artigos">

                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                    <div class="artigo">
                        <h1><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>
                        <?php if(has_post_thumbnail()):?>
                        <div style="min-height: 300px; background: url('<?php the_post_thumbnail_url()?>') center no-repeat; background-size: cover;">
                        </div>
                        <?php endif;?>
                        <p><small>Postado por <?php the_author_posts_link();?> em <a href="<?php echo esc_url( get_day_link( false, false, false ) ); ?>"><?php the_time('d/M/Y') ?></a> - <?php comments_popup_link('Sem Comentários', '1 Comentário', '% Comentários', 'comments-link', ''); ?> <?php edit_post_link('(Editar)'); ?></small></p>
                        <p><?php the_content(); ?></p>
                    </div>

                    <?php comments_template(); ?>

                <?php endwhile; else: ?>
                    <div class="artigo">
                        <h2>Nada Encontrado</h2>
                        <p>Erro 404</p>
                        <p>Lamentamos mas não foram encontrados artigos.</p>
                    </div>            
                <?php endif; ?>

            </article>
        </div> 
        <?php get_sidebar(); ?>
    </div>
<?php get_footer(); ?>
