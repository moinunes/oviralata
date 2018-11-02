
/*-----------------------------------------------------------------------------------
* Controla o upload e exibição das fotos
* 
*-----------------------------------------------------------------------------------*/

function upload_fotos() {
   
   var id_imovel = $('#frm_id_imovel').val();
   var files     = document.querySelector('input[type=file]').files;
   total_fotos = files.length;

   //.. thumbnail
   for ( var i = 0, file; file = files[i]; i++) {
      redimensionar( file, 90, 90 , 'thumbnail', i+1 );
   }     

   //.. foto normal
   for ( var i = 0, file; file = files[i]; i++) {
      redimensionar( file, 500, 500,  null, i+1 );
   }  
   
   
   
} // upload_fotos


function redimensionar( file, largura, altura, tipo, i ) {  
   var id_imovel = $('#frm_id_imovel').val();
   var loadingImage = loadImage(
      file,
      function ( img, data ) {
         salvar_foto_na_pasta( img, file, tipo, i );
         if (tipo=='thumbnail') {
            exibir_miniatura(file.name,img);
         }
      },
      {         
         maxWidth: largura,
         maxHeight:altura,
         orientation:true,        
         resize:true,
      }
   );
   if (loadingImage) {      
   }
} // redimensionar

function salvar_foto_na_pasta( img, file, tipo, i  ) {
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

$(document).ready(function() {
   acao          = $('#acao').val();
   comportamento = $('#comportamento').val();
   id_imovel     = $('#frm_id_imovel').val();
   if (acao=='alteracao' && comportamento=='efetivar') {
      obter_todas_miniaturas(id_imovel);      
   }
})

function obter_todas_miniaturas(id_imovel) {  
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
      exibir_todas_miniaturas(dados);
   });
   
} // obter_todas_miniaturas

function exibir_todas_miniaturas(dados) {  
   pasta   ='../fotos/';   
   var obj = jQuery.parseJSON( dados );
   var id, str, nome, nome_foto;
   $("#div_fotos").html("");
   obj.forEach( function( obj, index ) {         
      nome          = obj.foto;
      nome_foto     = obj.foto;         
      id            = nome.replace( ".jpg", '' );
      tem_essa_foto = $('#'+id).length;
      foto_g        = id_imovel+'__'+nome_foto.replace("t_",'');
      //..
      if ( !tem_essa_foto) {     
         str = "<div id='" + id + "' class='btn'>";
         str += '<a href=\"javascript:void(0)\" onmouseover=\"exibir_foto_grande(\''+foto_g+'\')\" >';
         str += "   <img src='"+pasta+id_imovel+"/"+nome_foto+ "' width='50' height='50' />";
         str += "</a>";
         str += '<a href="javascript:excluir_foto(' + "'"+nome_foto+"'"+ ')">Delete</a>';
         str += "</div>";         
         //..         
         $("#div_fotos").append( str );
      }      
   });
}


function exibir_miniatura( nome_foto, img ) {
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


function exibir_foto_grande(nome_foto) { 
   var retorno   = nome_foto.split("__");  
   var id_imovel = retorno[0];
   var nome_foto = retorno[1];
   var pasta     ='../fotos/';   
   str =  "<div>";
   str += "  <img src='"+pasta+id_imovel+"/"+nome_foto+ "' />";
   str += "</div>";  
   $("#div_foto_grande").html("");
   $("#div_foto_grande").html( str );
}


