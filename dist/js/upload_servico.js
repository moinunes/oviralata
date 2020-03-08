
/*-----------------------------------------------------------------------------------
* Controla o upload e exibição das fotos dos Serviços
* 
*-----------------------------------------------------------------------------------*/

/**
* Incluir fotos
*/ 
$(function () {
   id_servico = $('#frm_id_servico').val(); 
   $('#fileupload').fileupload({
      dataType: 'json',
      add: function ( e, data ) {
         //.. zera a barra de progresso
         progress=0;
         $('#progress .progress-bar').css('width', progress + '%')
         //..
         $("#div_status").html("");
         $('#div_status').append(' Aguarde... Fazendo o upload das fotos...' );      
         data.submit(); 
      },
      progressall: function (e, data) {
         var progress = parseInt(data.loaded / data.total * 100, 10);
         $('#progress .progress-bar').css('width', progress + '%');
      },
      done: function (e, data) { 
         $("#div_status").html("");
         $('#div_status').append(' Upload das fotos finalizado.');   
         obter_todas_miniaturas(id_servico);
      },
      error: function (e, data) {
         obter_todas_miniaturas(id_servico);
         progress =0;
         $('#progress .progress-bar').css('width', progress + '%')
         $("#div_status").html("");
         $('#div_status').append('ok,,' ); 
      }

   });
});


/**
* obtém as miniaturas
*/ 
$(document).ready(function() {
   acao          = $('#acao').val();
   comportamento = $('#comportamento').val();
   id_servico     = $('#frm_id_servico').val();
   if (acao=='alteracao' && comportamento=='efetivar') {
      obter_todas_miniaturas(id_servico);      
   }
})

function tratar_string( str ) {
   str = str.replace( ".", '' );
   str = str.replace( / /g, '');      
   return str;
} 

/**
* obtém as miniaturas
*/ 
function obter_todas_miniaturas(id_servico) {
   $("#div_status").html("");
   $('#div_status').append(' Aguarde... Buscando as fotos...' );
   $.ajax({
     url: '../cadastro/fotos_servico.php',
     type: "POST",
     async: true,
     dataType: "html",
     data: {
       id_servico: id_servico,
       nome_foto:'',
       acao: 'obter_miniaturas',
     }
   })
   .done(function(dados){  
      if( dados != '' ) {
         exibir_todas_miniaturas(dados);
      }
   });
   
} // obter_todas_miniaturas

/**
* Exibir as miniaturas
*/ 
function exibir_todas_miniaturas(dados) {
   $("#div_mens_1").html("");
   acao   = $('#acao').val();  
   pasta   ='../fotos_servico/';
   var obj = jQuery.parseJSON( dados );
   var id, str, nome_foto;
   $("#div_fotos").html("");
   $("#div_status").html("");
   $('#div_status').append('Exibindo as fotos na tela...' );
   obj.forEach( function( obj, index ) {         
      
      nome_foto = obj.foto;         
      id        = tratar_string( obj.foto );
      
      tem_essa_foto = $('#'+id).length;      
      
      if( acao=='alteracao' ) {
         foto = '../fotos_servico/tmp_'+id_servico+'/thumbnail/' + nome_foto;
      } else {
         foto = '../fotos_servico/' + id_servico + '/thumbnail/' + nome_foto;
      }
      
      str = "<div id='" + id + "' class='btn'>";
      str += "   <img src='"+foto+ "' width='80' height='80' />";
      str += '   <a href="javascript:excluir_foto(' + "'"+nome_foto+"'"+ ')"><img src="../images/excluir.png"></a>';
      str += "</div>";         
      //..         
      $("#div_fotos").append( str );
   });
   $("#div_status").html("");
   $('#div_status').append('ok' );  
}

function excluir_foto(nome_foto) {
   id = tratar_string( nome_foto );   
   $.ajax({
     url: 'fotos_servico.php',     
     type: "POST",
     async: true,
     dataType: "html",
     data: {       
       nome_foto: nome_foto,
       acao: 'excluir_foto',
     }
   })
   .done(function(msg){     
      $('#'+id).remove();
   });
} //  excluir_foto