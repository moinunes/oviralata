<html>
  <head>
  <title>My Now Amazing Webpage</title>
  

   <link rel="stylesheet" href="./dist/css/estilo.css" >

    <link rel="stylesheet" href="./dist/bootstrap-4.1/css/bootstrap.min.css">

   <link rel="stylesheet" type="text/css" href="./dist/slick/slick/slick.css"/>
   <link rel="stylesheet" type="text/css" href="./dist/slick/slick/slick-theme.css"/>   







   <style type="text/css">
  
   
   
    .slider {
        width: 100%;        
        margin:0px;
        padding: 0px;
    }

    .slick-slide {
      margin: 0px 0px 0px 1px;

    }

    .slick-slide img {
      width: 100%;
      max-height: 200px;
      min-height: 200px;

    }

    .slick-prev:before,
    .slick-next:before {
      color: black;
    }

    .slick-slide {
      transition: all ease-in-out .3s;
      opacity: .2;
    }
    
    .slick-active {
      opacity: .5;
    }

    .slick-current {
      opacity: 1;
    }

    </style>

  </head>
<body>

   <div class="container-fluid">

      <div class="row">
         <div class="col-md-12">
           <div><img src="fotos/11/IMG-20180728-WA0049.jpg" ></div>
          <div><img src="fotos/11/IMG-20180728-WA0051.jpg" ></div>  
         </div>

      </div>

   </div>

   <script src="./dist/js/jquery-3.3.1.min.js"></script>
   <script src="./dist//jquery-ui/jquery-ui.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
   <script src="./dist/bootstrap-4.1/js/bootstrap.min.js"></script>


  <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

   <script type="text/javascript" src="./dist/slick/slick/slick.min.js"></script>








  <script type="text/javascript">

   $(document).ready(function(){    
   

$('.carousel').slick({
  dots: false,
  infinite: true,
  speed: 500,
  slidesToShow: 1,
  slidesToScroll: 1,
});




    });
  </script>

  </body>
</html>