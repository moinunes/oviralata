
/*-----------------------------------------------------------------------------------
* Controla o cadastro de serviços ou produtos pet
* 
*-----------------------------------------------------------------------------------*/

// global
var dialog;


/*------------------------------------------------------
* Obtém o endereco após digitar o CEP 
*------------------------------------------------------*/
$( "#frm_cep" ).blur(function() {
   var _cep  = $('#frm_cep').val();
   obter_endereco_cep(_cep);
});
 

function obter_endereco_cep(_cep) { 
   $.ajax({
     type: 'POST',
     url: 'endereco_hlp.php',     
     async: true,     
     data: {       
       acao: 'obter_endereco_cep',
       cep: _cep,
     }
   })
   .done(function(data){
      var obj = JSON.parse(data);
      $("#div_endereco").html("");
      $("#div_endereco").removeClass();
      if ( obj.status=='ok' ) {
         $('#frm_id_logradouro').val( obj.id_logradouro );
         $("#div_endereco").addClass("font_preta_p");
         $("#div_endereco").append(obj.endereco );

      } else {
         $("#div_endereco").addClass("font_vermelha_m");
         $('#div_endereco').append( obj.status );         
      }
   });

} // obter_endereco_cep


/*------------------------------------------------------
* Obtém o endereco após clicar na LUPA
*------------------------------------------------------*/
$( "#btnBuscarCep" ).click( function(event) {   
   event.preventDefault();    
   if ( dialog === undefined ) {   
      criar_janela_modal( 450, 10, 'Pesquisar Cep.' ); 
   }
   dialog.dialog( "open" );
   buscar_logradouro();
});
$( "#btnFiltrarPesquisa" ).click(function(event) {
   event.preventDefault();    
   dialog.dialog( "open" );
   buscar_logradouro();
});
function buscar_logradouro( _order = null ) {
      var _filtro_cep          = $("#frm_filtro_cep").val()
      var _filtro_logradouro   = $("#frm_filtro_logradouro").val()
      var _filtro_id_municipio = $("#frm_filtro_id_municipio").val()
      $.ajax({ 
         url: 'buscar_cep.php',
         type: "POST",
         async: false,
         dataType: "html",
         data: { 
            acao: 'obter_logradouros',
            order: 'cep',
            filtro_cep: _filtro_cep,
            filtro_logradouro: _filtro_logradouro,
            filtro_id_municipio: _filtro_id_municipio,
      },
      success: function(resultado){   
         $("#div_buscar").html( resultado );
         $("#frm_filtro_cep").val( _filtro_cep );
         $("#frm_filtro_logradouro").val( _filtro_logradouro );
         $("#frm_filtro_id_municipio").val( _filtro_id_municipio );
      },
      failure: function( errMsg ) { alert(errMsg); } 
   });
} // buscar_logradouro

function PreencherEndereco( _cep, _id_logradouro ) {
   $("#frm_imovel_cep").val( _cep );  
   $("#frm_imovel_id_logradouro").val( _id_logradouro );   
   obter_endereco_por_cep( _cep, _id_logradouro)
   fechar_modal();
}

/*
* cria a janela modal
* param    int    altura  da modal
* param    int    largura da modal         
*/
function criar_janela_modal( _height=550, _width=700, _titulo = 'Pesquisar' ) {
  dialog = $( "#div_buscar" ).dialog( {
      title: _titulo,
      autoOpen: false,
      resizable: true,
      modal:true,
      height: 'auto',
      width: 'auto',
      draggable: true,
      position: {         
            my: "left top",
            at: "left top",
      },
      buttons: [{ 
         text: "Voltar", 
         click: function() { 
             fechar_modal();
         }
      }]     
   });
} // criar_janela_modal

function fechar_modal() {   
   dialog.dialog( "close" ); 
} // sair

$("#frm_descricao" ).keydown( function(event) {
   maxlimit = 450;   
   var _descricao = $('#frm_descricao').val();
   if (_descricao.length > maxlimit ) {
      $('#frm_descricao').val(_descricao.substring(0, maxlimit));
      $("#div_descricao").html("");
      $('#div_descricao').append('A descrição pode ter até 400 caracteres.' ); 
   } else {
     //countfield.value = maxlimit - field.value.length;
     $("#div_descricao").html("");
     $('#div_descricao').append('' );   
   }
 });

function limpa_div_mens() { 
   $("#div_mens_1").html("");
} // sair

function validar_submit() {
   resultado  = true;
   _div_fotos = $("#div_fotos").html();
   limpa_div_mens();
   _tipo_servico = $('#frm_tipo_servico').val();
   _titulo           = $('#frm_titulo').val();
   _descricao        = $('#frm_descricao').val();

   if ( _tipo_servico=='' ) {
      resultado = false;
      $('#div_mens_1').append('Por favor, preencha o Campo Tipo*'+'<br>' );
   }
   if ( _titulo.trim()=='' ) {
      resultado = false;
      $('#div_mens_1').append('Por favor, preencha o Campo Título*'+'<br>' );
   }
   if ( _descricao.trim()=='' ) {
      resultado = false;
      $('#div_mens_1').append('Por favor, preencha o Campo Descrição*'+'<br>' );
   }
   if ( _div_fotos.trim()=='' ) {
      resultado = false;
      $('#div_mens_1').append('Por favor, Adicione pelo menos 1 foto.'+'<br>' );
   }   
   return resultado
}

function exibir_campos() {
   _codigo_tipo_anuncio = $('#frm_tipo_anuncio').find(':selected').attr('data-codigo');
   _codigo_categoria    = $('#frm_categoria').find(':selected').attr('data-codigo');
   $('#div_categoria').show(); 
   if ( _codigo_categoria=='acessorios' || _codigo_categoria=='outropet' ) {
      $('#div_raca').hide();
   } else {
      $('#div_raca').show();
   }

} // exibir_campos

$( document ).ready(function() {      

   if ( $('#acao').val()=='alteracao' ){
     exibir_campos()
   }

});



