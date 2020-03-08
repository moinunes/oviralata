/*-----------------------------------------------------------------------------------
* Controla exibir_detalhes_carousel_servico
* 
*-----------------------------------------------------------------------------------*/

// global
var dialog;

function exibir_detalhes_carousel_servico(id_servico) {
   $("#div_buscar").html( ' Amor e Respeito aos Animais...' );
   $('#div_buscar').show();
   obter_detalhes_servico( id_servico );
}

function obter_detalhes_servico( id_servico ) {
      $.ajax({ 
         url: 'servico_galeria_detalhes.php',
         type: "GET",
         async: true,
         dataType: "html",
         data: { 
         frm_id_servico: id_servico,
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