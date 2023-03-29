<?php get_header();?>
<div class="pg-404">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-7 py-5">
                <h1>Aconteceu um erro!</h1>

                <h3>A página que você procura não foi encontrada!</h3>

                <p class="text-justify">Notamos um erro 404, mas fique calmo pode ser que só digitou errado o que procurava.</p>
                <p class="text-justify">O erro 404 é um código de resposta HTTP que indica que o cliente pôde comunicar com o servidor, mas ou o servidor não pôde encontrar o que foi pedido, ou foi configurado para não cumprir o pedido e não revelar a razão, ou a página não existe mais. Eles não devem ser confundidos com outros erros nos quais uma conexão para o servidor de destino não pôde ser feita. </p>
            </div>
            <div class="hidden col-md-5">
                <img src="<?php echo get_template_directory_uri()."/img/nao-encontrado.png"?>" class="d-inline-block align-top img-fluid" alt="Não encontrado">
            </div> 
        </div>
    </div>
</div>
<?php get_footer();?>