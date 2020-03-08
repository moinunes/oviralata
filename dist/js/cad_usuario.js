
/*-----------------------------------------------------------------------------------
* Controla o cadastro de usuários
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
$( "#frm_cep" ).keyup(function() {
   var _cep  = $('#frm_cep').val();
   if ( _cep.length>=9 ) {
      obter_endereco_cep(_cep);
   }

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
         $("#div_endereco").addClass("tit_0");
         $("#div_endereco").append(obj.endereco );

      } else {
         $("#div_endereco").addClass("font_vermelha_m");
         $('#div_endereco').append( obj.status );         
      }
   });

} // obter_endereco_cep


function validar_submit() {
   var _ret = true;
   if( $('#frm_id_logradouro').val()=='' ) {
      _ret = false;
   }
   return _ret    
}

function validar_submit_alteracao() {
   var resultado = true;
   mens          = '';
   mens_sexo     = '';
      
   var ddd_celular  = $('#frm_ddd_celular').val();
   var ddd_whatzapp = $('#frm_ddd_whatzapp').val();
   var ddd_fixo     = $('#frm_ddd_fixo').val();   
   var tel_celular  = $('#frm_tel_celular').val();
   var tel_whatzapp = $('#frm_tel_whatzapp').val();
   var tel_fixo     = $('#frm_tel_fixo').val();
   var apelido      = $('#frm_apelido').val();
     
   $("#div_mens_alteracao").html("");
   $("#div_mens_alteracao").append( '' );
   
   if ( apelido =='' ) {
      mens += 'Preencha o campo Apelido!'+'<br>';
      resultado = false;
   }
   if ( !document.querySelector('input[name="frm_sexo"]:checked') ) {
      mens += 'Preencha o campo Sexo'+'<br>';
      resultado = false;
   }
   
   if ( tel_celular=='' && tel_whatzapp=='' && tel_fixo=='' ) {
      mens += 'Pelo menos 1 telefone é obrigatório!'+'<br>';
      resultado = false;
   }
   if ( ddd_celular=='' && tel_celular!='' ) {
      mens += 'Preencha o DDD do celular!'+'<br>';
      resultado = false;
   }
   if ( ddd_whatzapp=='' && tel_whatzapp!='' ) {
      mens += 'Preencha o DDD do WhatzApp!'+'<br>';
      resultado = false;
   }
   if ( ddd_fixo=='' && tel_fixo!='' ) {
      mens += 'Preencha o DDD do Fixo!'+'<br>';
      resultado = false;
   }
   if ( !document.querySelector('input[name="frm_exibir_tea"]:checked') ) {
      mens += 'Selecione: O que deseja exibir no anúncio?'+'<br>';
      resultado = false;
   }
   if ( mens !='' ) {
      $("#div_mens_alteracao").show();
      $("#div_mens_alteracao").append(mens);
   }
   return resultado    
}


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
      var _filtro_cep        = $("#frm_filtro_cep").val()
      var _filtro_logradouro = $("#frm_filtro_logradouro").val()
      var _filtro_uf         = $("#frm_filtro_uf").val()
      var _filtro_municipio  = $("#frm_filtro_municipio").val()
      $.ajax({ 
         url: 'buscar_cep.php',
         type: "POST",
         async: true,
         dataType: "html",
         data: { 
            order: 'cep',
            filtro_cep: _filtro_cep,
            filtro_uf: _filtro_uf,
            filtro_logradouro: _filtro_logradouro,
            filtro_municipio: _filtro_municipio,
      },
      success: function(resultado){
         $("#div_buscar").html( resultado );
         $("#frm_filtro_cep").val( _filtro_cep );
         $("#frm_filtro_logradouro").val( _filtro_logradouro );
         $("#frm_filtro_municipio").val( _filtro_municipio );
         $("#frm_filtro_uf").val( _filtro_uf );
      },
      failure: function( errMsg ) { alert(errMsg); } 
   });
} // buscar_logradouro

function PreencherEndereco( _cep, _id_logradouro ) {
   $("#frm_cep").val( _cep );  
   $("#frm_id_logradouro").val( _id_logradouro );   
   obter_endereco_cep( _cep );
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


$( document ).ready(function() {
    $("#div_mens_alteracao").hide();
});

