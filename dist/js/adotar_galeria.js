/*-----------------------------------------------------------------------------------
* Controla exibir_detalhes_carousel_adotar
* 
*-----------------------------------------------------------------------------------*/

// global
var dialog;

function exibir_detalhes_carousel_adotar(id_anuncio) {
   $("#div_buscar").html( ' Amor e Respeito aos Animais...' );
   $('#div_buscar').show();
   obter_detalhes( id_anuncio );
}

function obter_detalhes( id_anuncio ) {
      $.ajax({ 
         url: 'adotar_galeria_detalhes.php',
         type: "GET",
         async: true,
         dataType: "html",
         data: { 
         frm_id_anuncio: id_anuncio,
      },
      success: function(resultado){
         $("#div_buscar").html( resultado );
         $("html, body").animate({ scrollTop:399 }, "slow" );
         $('#div_buscar').show();
      },
      failure: function( errMsg ) { alert(errMsg); } 
   });
}


function fechar() {   
   $('#div_buscar').hide();
   $('html,body').scrollTop(0); 
} // sair