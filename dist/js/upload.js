
/*-----------------------------------------------------------------------------------
* Controla o upload e exibição das fotos
* 
*-----------------------------------------------------------------------------------*/

function upload_fotos() {
   var files = document.querySelector('input[type=file]').files;
   // thumbnail
   for ( var i = 0, file; file = files[i]; i++) {
      redimensionar( file, 90, 90 , 'thumbnail' );
   }
   // foto normal
   for ( var i = 0, file; file = files[i]; i++) {
      redimensionar( file, 500,500,  null   );
   }   

} // upload_fotos

function redimensionar( file, largura, altura, tipo ) {  
   var loadingImage = loadImage(
      file,
      function ( img, data ) {
         if (tipo=='thumbnail') {
            exibir_miniatura(file.name,img); //.. exibe as miniaturas na tela            
         }
         salvar_foto_na_pasta( img, file, tipo );
      },
      {         
         maxWidth: largura,
         maxHeight:altura,
         orientation:true,        
         resize:true,
      }
   );
   if (loadingImage) {      
      //.. antes
   }
} // redimensionar

function salvar_foto_na_pasta( img, file, tipo ) {
   var url = "fotos.php";
   nome    = file.name;
   base64  = img.toDataURL("image/jpeg", 0.8 )
   $.ajax({
     url: url,
     type: "POST",
     data: {
       imagem: base64,
       nome: nome,
       tipo: tipo,
       acao: 'incluir_foto',
     },     
     beforeSend: function( xhr ) {
        // alert('antes')
     }
   })
   .done(function(){
      // nada
   });

} // salvar

function exibir_miniatura( nome_foto, img ) {
   var nome, id, str;
   nome      = nome_foto;
   id        = 't_'+nome.replace( ".jpg", '' );
   nome_foto = 't_'+nome_foto;
   tem_essa_foto = $('#'+id).length;
   if ( !tem_essa_foto) {
      str  = "<div id='"+id+"' class='btn' >";
      str += '<a href="javascript:excluir_foto(' + "'"+nome_foto+"'"+ ')">Delete</a>';
      str += "</div>";
      $( "#div_fotos" ).append( str );
      $( "#div_fotos" ).find( '#'+id ).prepend( img );
   }   
} // exibir_miniatura

function excluir_foto(nome_foto) {
   var url  = "fotos.php";
   var nome = nome_foto;
   id       = nome.replace( ".jpg", '' );
   //alert(id)
   $.ajax({
     url: url,     
     type: "POST",
     data: {       
       nome_foto: nome_foto,       
       acao: 'excluir_foto',
     }
   })
   .done(function(msg){      
      $('#'+id).remove();
   });
} //  excluir_foto


function carregar_todas_miniaturas(id_imovel) {
   var url  = "fotos.php";   
   $.ajax({
     url: url,
     type: "POST",
     data: {
       id_imovel: id_imovel,       
       acao: 'obter_miniaturas',
     }
   })
   .done(function(dados){
      exibir_todas_miniaturas(dados);
   });
} // carregar_todas_miniaturas

function exibir_todas_miniaturas(dados) {
   //.. define a pasta das fotos
   url = window.location.pathname;
   pasta = url.split("/");   
   pasta = '/'+pasta[1]+'/fotos/';
   
   var obj = jQuery.parseJSON( dados );
   var str, nome, nome_foto, resultado;
   obj.forEach( function( obj, index ) {         
      nome      = obj.foto;
      nome_foto = obj.foto;         
      id        = nome.replace( ".jpg", '' );
      tem_essa_foto = $('#'+id).length;
      if ( !tem_essa_foto) {         
         str = "<div id='" + id + "' class='btn'>";
         str += "<img src='"+pasta+id_imovel+"/"+nome_foto+ "'/>";
         str += '<a href="javascript:excluir_foto(' + "'"+nome_foto+"'"+ ')">Delete</a>';
         str += "</div>";         
         $("#div_fotos").append( str );
      }
   });   
} // exibir_todas_miniaturas


$(document).ready(function() {

   acao          = $('#acao').val();
   comportamento = $('#comportamento').val();
   id_imovel     = $('#frm_id_imovel').val();

   if (acao=='alteracao' && comportamento=='efetivar') {
      carregar_todas_miniaturas(id_imovel);
   } 

})