
/*-----------------------------------------------------------------------------------
* Controla o upload e exibição das fotos
* 
*-----------------------------------------------------------------------------------*/


/**
* Incluir fotos
*/ 
$(function () {
   id_imovel = $('#frm_id_imovel').val();

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
         obter_todas_miniaturas(id_imovel);
      },
      error: function (e, data) {
            progress =0;
            $('#progress .progress-bar').css('width', progress + '%')
            $("#div_status").html("");
            $('#div_status').append('fim' ); 
            //console.log(e.readyState) 
            //console.log(data)
        }

   });
});

/**
* obtém as miniaturas
*/ 
$(document).ready(function() {
   acao          = $('#acao').val();
   comportamento = $('#comportamento').val();
   id_imovel     = $('#frm_id_imovel').val();
   if (acao=='alteracao' && comportamento=='efetivar') {
      obter_todas_miniaturas(id_imovel);      
   }
})


/**
* obtém as miniaturas
*/ 
function obter_todas_miniaturas(id_imovel) {
   $("#div_status").html("");
   $('#div_status').append(' Aguarde... Buscando as fotos...' );
   $.ajax({
     url: 'fotos.php',
     type: "POST",
     async: true,
     dataType: "html",
     data: {
       id_imovel: id_imovel,
       nome_foto:'',
       acao: 'obter_miniaturas',
     }
   })
   .done(function(dados){    
      if( dados != '' ) {
         exibir_todas_miniaturas(dados);
      }
   });''
   
} // obter_todas_miniaturas



/**
* Exibir as miniaturas
*/ 
function exibir_todas_miniaturas(dados) {  
   pasta   ='../fotos/';
   var obj = jQuery.parseJSON( dados );
   var id, str, nome, nome_foto;
   $("#div_fotos").html("");
   $("#div_status").html("");
   $('#div_status').append('Exibindo as fotos na tela...' );
   obj.forEach( function( obj, index ) {         
      nome          = obj.foto;
      nome_foto     = obj.foto;         
      id            = nome.replace( ".jpg", '' );
      tem_essa_foto = $('#'+id).length;      
      foto = './server/php/files/' + id_imovel + '/thumbnail/' + nome_foto;

      str = "<div id='" + id + "' class='btn'>";
      str += '<a href=\"javascript:void(0)\" onmouseover=\"exibir_foto_grande(\''+nome_foto+'\')\" >';
      str += "   <img src='"+foto+ "' width='50' height='50' />";
      str += "</a>";
      str += '<a href="javascript:excluir_foto(' + "'"+nome_foto+"'"+ ')">Delete</a>';
      str += "</div>";         
      //..         
      $("#div_fotos").append( str );
   });
   $("#div_status").html("");
   $('#div_status').append('fim' );  
}


/**
* Exibir foto grande
*/ 
function exibir_foto_grande(nome_foto) { 
   var retorno   = nome_foto.split("__");  
   id_imovel = $('#frm_id_imovel').val();

   //var nome_foto = retorno[1];
   var pasta     ='../fotos/';   

   foto = './server/php/files/' + id_imovel + '/media/' + nome_foto;

   str =  "<div>";
   //str += "  <img src='"+pasta+id_imovel+"/"+nome_foto+ "' />";
   str += "  <img src='"+foto+ "' />";
   str += "</div>";  
   $("#div_foto_grande").html("");
   $("#div_foto_grande").html( str );
}


function excluir_foto(nome_foto) {
   var nome = nome_foto;
   id       = nome.replace( ".jpg", '' );
   $.ajax({
     url: 'fotos.php',     
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



function salvar_foto_na_pastaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx( img, file, tipo, i  ) {
   nome   = file.name;
   base64 = img.toDataURL( "image/jpeg", 1.0 )
   base64 = encodeURIComponent(base64);
   $.ajax({
     type: "POST",
     url: 'fotos.php',
     async: true,
     data: {
       imagem: base64,
       nome: nome,
       tipo: tipo,
       acao: 'incluir_foto',
     },     
     beforeSend: function( xhr ) {
        //.. antes de salvar
     }
   })
   .done(function(){
      // nada
      $('#frm_status').val( i+'/'+total_fotos );
   });

} // salvar


function exibir_miniaturaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx( nome_foto, img ) {
   id            = 't_'+nome.replace( ".jpg", '' );
   nome_foto     = 't_'+nome_foto;
   tem_essa_foto = $('#'+id).length;
   foto_g        = id_imovel+'__'+nome_foto.replace("t_",'');
   
   if ( !tem_essa_foto) {
      str = "<div id='" + id + "' class='btn'>";
      str += '<a href=\"javascript:void(0)\" onmouseover=\"exibir_foto_grande(\''+foto_g+'\')\" >';
      str += "   <img src='"+img.toDataURL()+ "' width='50' height='50' >";
      str += '</a>';
      str += '<a href="javascript:excluir_foto(' + "'"+nome_foto+"'"+')"'+'>Delete</a>';
      str += "</div>"; 
      $("#div_fotos").append( str );
   }

} // exibir_miniatura


