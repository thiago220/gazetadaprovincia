<?php get_header(); ?>
<main>
    <div class="container">
        <h1 class="d-none">Gazeta da Província</h1>
        <div class="row">
            <div class="col-12 col-md-9">
                <h2 class="my-1">Últimas Notícias</h2>                
                <p>Não soube das novidades na cidade? Abaixo o que o povo anda comentando.</p>                
                <?php
                if (have_posts()) : $i = 0;
                    while (have_posts()) : the_post();
                        if ($i == 5):
                            ?>
                            <div id="ads"></div>
                            <?php
                        endif;
                        $i++
                        ?>
                        <div class="media py-1 border my-1"> 
                            <?php
                            if (has_post_thumbnail()) {
                                the_post_thumbnail('thumbnail', ['class' => 'mr-3']);
                            } else {
                                echo("<img class='mr-3' src='https://gazetadaprovincia.jor.br/wp-content/themes/gazetadaprovincia/img/sem-imagem.jpg' alt='Sem Imagem' width='150px' height='a50px' />");
                            }
                            ?> 
                            <div class="media-body p-2">
                                <a href="<?php the_permalink() ?>">
                                    <h5 class="mt-0"><?php the_title(); ?></h5>
                                    <small>Postado por <?php the_author_posts_link(); ?> em <?php the_time('d/M/Y') ?></small>
                                </a>
                                <?php
                                $args = array(
                                    'title_li' => '',
                                    'separator' => ' > ',
                                    'style' => ''
                                );
                                ?>
                                <p>
                                    <small><?php wp_get_post_categories($args) ?></small>
                                </p>
                                <a class="d-none d-md-block"  href="<?php the_permalink() ?>">
                                    <?php the_excerpt() ?>
                                </a>
                            </div>
                        </div>                        

                        <?php
                    endwhile;
                    page_navi("<div class='w-100 p-1 d-flex justify-content-center align-items-center'>", "</div>");
                endif;
                wp_reset_query();
                ?>                
            </div>
            <div class="col-12 col-md-3 border my-3">
                <div>
                    <h2>Colunas</h2>
                    <?php
                    $categories = get_terms('category', array(
                        'orderby' => 'title',
                        'parent' => 20
                            )
                    );

                    foreach ($categories as $category):
                        $args = array(
                            'cat' => $category->term_id,
                            'post_type' => 'post',
                            'posts_per_page' => '1',
                            'orderby' => 'date',
                            'order' => 'DESC'
                        );

                        $query = new WP_Query($args);

                        if ($query->have_posts()):
                            while ($query->have_posts()):
                                $query->the_post();
                                ?>
                                <h4><?= $category->name ?></h4><small>por <?php the_author_posts_link(); ?></small><p><a href="<?php the_permalink() ?>"><?php the_title() ?></a></p>
                                <?php
                            endwhile;
                        endif;
                    endforeach;
                    wp_reset_postdata();
                    ?>
                </div>
                <div class="ads-square">

                </div>
                <div> 
                    <?php
                    $args = array(
                        'post_type' => array('post'),
                        'posts_per_page' => 3,
                        'ignore_sticky_posts' => 1,
                        'meta_key' => 'wpb_post_views_count',
                        'orderby' => 'meta_value_num',
                        'order' => 'DESC',
                        'date_query' => array(
                            array(
                                'after' => '1 week ago'
                            )
                        )
                    );
                    // The Query
                    $query_trending = new WP_Query($args);
                    // The Loop
                    if ($query_trending->have_posts()):
                        ?>
                        <h2 class="my-2">Mais visualizadas na semana</h2>
                        <?php while ($query_trending->have_posts()) : $query_trending->the_post(); ?>
                            <p class="my-1">
                                <a href="<?php the_permalink() ?>">
                                    <?php
                                    if (has_post_thumbnail()) {
                                        the_post_thumbnail('medium', ['class' => 'img-fluid d-block mx-auto']);
                                    }
                                    ?> 
                                    <h5><?php the_title(); ?></h5>
                                </a>
                            </p>
                        <?php endwhile; ?>
                        <?php
                    endif;
                    wp_reset_query();
                    ?>
                </div>
            </div>
        </div>         
        <?php
        // WP_Query arguments
        $argsObituario = array(
            'post_type' => array('obituario'),
            'post_status' => array('publish'),
            'orderby' => 'meta_value_num',
            'meta_key' => 'data_do_obito',
            'order' => 'DESC',
            'posts_per_page' => -1,
        );
        $query_obituario = new WP_Query($argsObituario);
        if ($query_obituario->have_posts()):
            ?>
            <h2 class="my-1">Obituário</h2>
            <?php
            $listaMote = array(
                ["Contra vim mortis non est medicamen in hortis", "Contra a morte, não há medicamento nas hortas."],
                ["Crudelius est quam mori semper mortem timere", "É mais cruel temer sempre a morte."],
                ["Mors omni aetate communis est", "A morte é comum a todos os homens."],
                ["Morte nihil certius est, nihil vero incerta quam ejus hora", "A morte é certa, no entanto, é incerto como sua hora."],
                ["Ante mortem ne laudes hominem quemquam", "Antes da morte, não louves qualquer homem."],
                ["Loquor mee menti: factus de materia cinis elementi similis sum folio, de quo lundunt venti", "Falei para mim mesmo: Feito de matéria, da cinza dos elementos, sou como a folha com quem brincam os ventos."],
            );
            ?>
            <div class="text-center">
                <?php $mote = $listaMote[array_rand($listaMote)] ?>
                <cite class="mote-obituario"><?= $mote[0] ?></cite>
                <br><small class="font-italic">"<?= $mote[1] ?>"</small>
            </div>
            <div class="row">
                <div class="d-none d-md-block col-md-3">
                    <img src="<?php echo get_template_directory_uri() . "/img/anjo-esq.png" ?>" class="mx-auto" alt="Gazeta da Província">
                </div>
                <div class="d-block col col-md-6">
                    <div class="row">                
                        <?php while ($query_obituario->have_posts()) : $query_obituario->the_post() ?>                    
                            <div class="col-6 col-md-4 border">
                                <a href="<?= the_permalink() ?>">
                                    <div class="text-center m-1"> 
                                        <h5 class="mt-0"><?= the_title() ?></h5>
                                        <div class="row">
                                            <div class="col-6">
                                                <?php
                                                switch (get_post_meta(get_the_ID(), 'religiao', TRUE)) {
                                                    case 1:
                                                        echo("<img class='img-fluid mx-auto' src='" . get_template_directory_uri() . "/img/cruz-catolica.png'  data-toggle='tooltip' data-placement='right' title='Católico' />");
                                                    default:
                                                        echo("<img class='img-fluid mx-auto' src='" . get_template_directory_uri() . "/img/cruz-catolica.png'  data-toggle='tooltip' data-placement='right' title='Católico' />");
                                                }
                                                ?>
                                            </div>
                                            <div class="col-6" style="background: url('<?= the_post_thumbnail_url() ?>') center center no-repeat; background-size: cover;">
                                            </div>
                                        </div>
                                        Data do óbito <?php echo get_post_meta(get_the_ID(), 'data_do_obito', TRUE); ?>

                                    </div>
                                </a>
                            </div>             
                        <?php endwhile; ?>
                    </div>
                </div>
                <div class="d-none d-md-block col-md-3">                
                    <img src="<?php echo get_template_directory_uri() . "/img/anjo-dir.png" ?>" class="mx-auto" alt="Gazeta da Província">
                </div>
            </div>
        <?php endif; ?>
        <!--  <h2>Entretenimento</h2>
        <div class="row">

            <div class="col-12 col-sm-4">
                <h3 class="text-center">Horóscopo</h3>
                <a href="<?= site_url("horoscopo") ?>">
                    <img class="d-block mx-auto img-fluid" src="<?php echo get_template_directory_uri() . "/img/horoscope.png" ?>" alt="Horóscopo" />
                </a>
            </div>
            <div class="col-12 col-sm-4">
                <h3 class="text-center">Sudoku</h3>
                <a href="<?= site_url("sudoku") ?>">
                    <img class="d-block mx-auto img-fluid" src="<?php echo get_template_directory_uri() . "/img/sudoku.png" ?>" alt="Horóscopo" />
                </a>
            </div>
            <div class="col-12 col-sm-4">
                <h3 class="text-center">Palavras Cruzadas</h3>
                <a href="<?= site_url("cadernos/palavras-cruzadas/") ?>">
                    <img class="d-block mx-auto img-fluid" src="<?php echo get_template_directory_uri() . "/img/palavras_cruzadas.png" ?>" alt="Horóscopo" />
                </a>
            </div>
        </div> -->
    </div>

</main>
<?php get_footer(); ?>