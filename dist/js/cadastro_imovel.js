
/*-----------------------------------------------------------------------------------
* Controla o cadastro de imóveis
* 
*-----------------------------------------------------------------------------------*/

// global
var dialog;


/*------------------------------------------------------
* Obtém o endereco após digitar o CEP 
*------------------------------------------------------*/
$( "#frm_imovel_cep" ).blur(function() {
   var _cep           = $('#frm_imovel_cep').val();
   var _id_logradouro = '';
   obter_endereco_por_cep( _cep, _id_logradouro );
});  //  obter_endereco   
function obter_endereco_por_cep( _cep, _id_logradouro ) {
   $.ajax({
     type: 'POST',
     url: 'endereco_hlp.php',     
     async: false,     
     data: {       
       acao: 'obter_endereco_por_cep',
       filtro_cep: _cep,
       filtro_id_logradouro: _id_logradouro,
     }
   })
   .done(function(data){
      var obj = JSON.parse(data);
      if ( obj.status=='ok' ) {        
        $('#frm_imovel_nome_logradouro').val( obj.nome_logradouro );
        $('#frm_imovel_nome_bairro').val( obj.nome_bairro);
        $('#frm_imovel_nome_municipio').val( obj.nome_municipio);
        $('#frm_imovel_local').val( obj.local+' | '+obj.complemento );
        $('#frm_imovel_id_logradouro').val( obj.id_logradouro );
        
      } else {
         $('#frm_imovel_nome_logradouro').val( obj.status );         
         $('#frm_imovel_nome_bairro').val( '' );
         $('#frm_imovel_nome_municipio').val( '' );
         $('#frm_imovel_local').val( '' );
      }
   })
} // obter_endereco_por_cep


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