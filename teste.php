<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Everson da Luz">
        <title>Mostrar imagem ao passar mouse no link</title>
        <style type="text/css">
            *{
                margin:0px;
                padding:0px;
                border:0px;
            }
            ul{
                margin: 20px 0 0 20px;
                list-style:none;
            }
            a{
                position: relative; /* Para que a imagem não saia fora do link */
                display:block;
                width:100px;
                padding:5px 0;
                border:1px #999999 solid;
                background-color:#CCCCCC;
                text-decoration:none;
                color:#FFFFFF;
            }
            a:hover{
                background-color:#999999;
            }
            a tag1{
                display:none; /* Aqui você define que todo span que estiver dentro de um a estara invisivel */
            }
            a:hover tag1{
                display:block; /* Aqui você diz que ao passar o mouse sobre o link, colocar um display no span dentro desse link */
                position:absolute; /* Para você poder posicionar ao queira, sem quebrar o layour em volta */
                top: 0px; /* Para ficar na mesma altura do link */
                left: 100%; /* Empurra a imagem para fora do link, ficando ao seu lado */
                border:1px #CCCCCC solid; /* Estilo extra, lembrando que você pode colocar qualquer estilo nesse elemento */
            }
        </style>
    </head>
    <body>
        <ul>
            <li>
                <a href="#">Gato<tag1><img src="images/gato.jpg" alt="gato" /></tag1></a>
            </li>
            <li>
                <a href="#">Cachorro<tag1><img src="fotos/20/IMG-20180728-WA0056.jpg" alt="cachorro" /></tag1></a>
            </li>
            <li>
                <a href="#">Papagaio<tag1><img src="fotos/20//IMG-20180728-WA0058.jpg" alt="papagaio" /></tag1></a>
            </li>
            <li>
                <a href="#">Coruja<tag1><img src="images/coruja.jpg" alt="coruja" /></tag1></a>
            </li>
             <li>
                <a href="#">Papagaio<span><img src="fotos/20//IMG-20180728-WA0058.jpg" alt="papagaio" /></span></a>
            </li>
        </ul>
    </body>
</html>
