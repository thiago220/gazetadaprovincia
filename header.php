<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-62256256-18"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'UA-62256256-18');
        </script>
        
        <meta name="google-site-verification" content="tgdK7D7IhUZjEujlgNBIKUtaC2bUAC60bNuokil7gRQ" />

        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <title><?php bloginfo('name'); wp_title(); ?></title>
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
        <?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <?php wp_head(); ?>
        <link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/img/logo50x50.png" type="image/x-icon" />
        
    </head>
    <body>        
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark pt-0">
            <div class="container d-flex align-items-center">
                <a class="navbar-brand" href="<?=get_site_url()?>">
                    <img src="<?php echo get_template_directory_uri()."/img/Logotipo_branca_sem_fundo120x50.png"?>" class="d-inline-block align-top" alt="Folhetim Desinformativo Provinciano Boca do Inferno">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse h-100" id="navbarNav" >
                    <?php
                        wp_nav_menu( array(
                            'theme_location' => 'menu-principal', // Defined when registering the menu
                            'menu_id'        => 'primary-menu',
                            'container'      => false,
                            'depth'          => 3,
                            'menu_class'     => 'navbar-nav ml-auto h-100',
                            'walker'         => new Bootstrap_NavWalker(), // This controls the display of the Bootstrap Navbar
                            'fallback_cb'    => 'Bootstrap_NavWalker::fallback', // For menu fallback
                        ) );
                    ?>
                </div>
            </div>
        </nav>
        <div class="container">
            <?=get_breadcrumb()?>
        </div>