
function iniciar_xmlhttp() {
	
	// Internet Explorer
	if( navegador.indexOf( 'msie' ) != -1 ) {
		
		// Operador ternario que adiciona o objeto padrao do seu navegador (caso for o IE) a variável controle
		var controle = ( navegador.indexOf( 'msie 5' ) != -1 ) ? 'Microsoft.XMLHTTP' : 'Msxml2.XMLHTTP';
		
		try {
			
			// Inicia o objeto no IE
			xmlhttp = new ActiveXObject( controle );
			
		} catch (e) { }
		
	} else {
		
		// Firefox, Safari, Mozilla
		xmlhttp = new XMLHttpRequest();
		
	}
	
	if( xmlhttp == null ) {
			
		mensagem = "<h2>Impossivel iniciar o objeto XMLHttpRequest !</h2>";
		mostra_mensagem( "div_mensagens_erro", mensagem , tempo );
		
		return false;

	}
	
}

function validar_campo_vazio( id ) {
	
	var checa_campo = document.getElementById( id ).value;
	
	if( checa_campo == "" ) {
		
		return true;
		
	}
	
	return false;

}

function mostra_mensagem( _id, _message, _time ) {
	
	var acao_s = "<a onclick=\"return fechar_elemento_timeout( 'div_mensagens_sucesso' );\">";
	var acao_e = "<a onclick=\"return fechar_elemento_timeout( 'div_mensagens_erro' );\">";
	var img    = "<img src=\"img/x.png\" align=\"absmiddle\" />";
	
	$(document).ready(function() {
		
		$("#" + _id).hide();
		$("#" + _id).show();
		
	});
	
	switch( _id ) {
		
		case div_error:
			clearTimeout( control_error );
			document.getElementById( div_error_content ).innerHTML = acao_e + img +  _message + "</a>";
			control_error = setTimeout( function() { fechar_elemento_timeout( _id ); }, _time );
		break;
		
		case div_success:
			clearTimeout( control_sucess );
			document.getElementById( div_success_content ).innerHTML = acao_s + img +  _message + "</a>";
			control_sucess = setTimeout( function() { fechar_elemento_timeout( _id ); }, _time );
		break;
	
	}
	
	return false;
	
}

function fechar_elemento_unico( elemento ) {
	
	document.getElementById( elemento ).style.display = "none";
}

function fechar_elemento_simples( elemento ) {
	
	document.getElementById( elemento ).style.display         = "none";
	document.getElementById( "div_tela_preta" ).style.display = "none";
}

function fechar_elemento_timeout( _id ) {
	
	switch( _id ) {
		
		case div_error:
			clearTimeout( control_error );
		break;
		
		case div_success:
			clearTimeout( control_sucess );
		break;
	
	}
	
	$(document).ready( function() {
		
		$("#" + _id).hide( 'slow' );
		
	});
	
	if( verificar_tag_criada( "div", "tela_preta" ) == true ) {
		
		document.getElementById( "tela_preta" ).style.display = 'none';
		
	}
	
}

function antecipar_fechar_elemento( id ) {
	
	$(document).ready(function() {
		
		$("#" + id).hide( 1000 );
		
	});
	
	if( CheckIfTagExists( "div", "tela_preta" ) == true ) {
		
		document.getElementById( "tela_preta" ).style.display = 'none';
		
	}
	
	return false;

}

function fechar_elemento( id_elemento ) {
					
	// Jquery para mostrar elementos com efeitos
	$(document).ready(function(){
	
		$("#"+id_elemento).fadeOut();
		
	});
	
	if( verificar_tag_criada( "div", "div_tela_preta" ) == true ) {
		
		document.getElementById( "div_tela_preta" ).style.display = "none";
	
	}
	
}

function abrir_elemento( id_elemento ) {
					
	// Jquery para mostrar elementos com efeitos
	$(document).ready(function(){
	
		$("#"+id_elemento).fadeIn( 1000 );
		
	});
	
	if( verificar_tag_criada( "div", "div_tela_preta" ) == true ) {
		
		document.getElementById( "div_tela_preta" ).style.display = "block";
	
	}
	
}

function abrir_elemento_relativamente( id_elemento ) {
					
	// Jquery para mostrar elementos com efeitos
	$(document).ready(function(){
	
		$("#"+id_elemento).fadeIn( 1000 );
		
	});
	
}

function verificar_tag_criada( nome_tag, id_tag ) {
	
	var vetor = document.getElementsByTagName( nome_tag );
	
	for( var i = 0; i < vetor.length; i++ ) {
		
		if( vetor[i].id == id_tag ) {
			
			return true;
			
		}
		
	}
	
	return false;
	
}

function formata_qtde_itens( qtde_itens ) {
	
	var msg_itens = "";
	
	if ( qtde_itens == 0 ) {
		
		msg_itens = "Nenhum Item";
		document.getElementById( "input_hidden_guarda_contador" ).value = 1;
		contador  = 1;
	
	} else if( qtde_itens == 1 ) {
		
		msg_itens = qtde_itens + " item";
		
	} else {
		
		msg_itens = qtde_itens + " itens";
		
	}
	
	return msg_itens;
	
}

function verificar_saldo_atual() {
	
	var input_saldo       = document.getElementById( "input_saldo_compra" );
	var valor_input_saldo = input_saldo.value;
	    valor_input_saldo = valor_input_saldo.replace( ".", "" );
	    valor_input_saldo = valor_input_saldo.replace( ",", "." );
	
	if( valor_input_saldo < 0 ) {
		
		input_saldo.style.color = "#DD0000";
		
	} else if( valor_input_saldo == 0) {
		
		input_saldo.style.color = "#888888";
		
	} else {
		
		input_saldo.style.color = "#00BB00";
		
	}
	
}

function formata_moeda( objTextBox, SeparadorMilesimo, SeparadorDecimal, e ) {
	
	var sep      = 0;
	var key      = '';
	var i        = 0 
	var j        = 0;
	var len      = 0;
	var len2     = 0;
	var strCheck = '0123456789';
	var aux      = '';
	var aux2     = '';
	
	var whichCode = ( window.Event ) ? e.which : e.keyCode;
	
	if( whichCode == 13 || e.keyCode == 13 ) return false; // Retorna falso para [Enter]
	
	key = String.fromCharCode( whichCode ); // Valor para o codigo da Chave
	
	if( strCheck.indexOf( key ) == -1 ) return false; // Chave invalida
	
	len = objTextBox.value.length;
	
	for( i = 0; i < len; i++ ) {
		
		if( ( objTextBox.value.charAt( i ) != '0' ) && ( objTextBox.value.charAt( i ) != SeparadorDecimal ) ) break;
		
	}
	
	aux = '';
	
	for( ; i < len; i++ ) {
		
		if ( strCheck.indexOf( objTextBox.value.charAt( i ) ) != -1 ) aux += objTextBox.value.charAt( i );
		
	}
	
	aux += key;
	
	len = aux.length;
	
	if( len == 0 ) objTextBox.value = '';
	
	if( len == 1 ) objTextBox.value = '0'+ SeparadorDecimal + '0' + aux;
	
	if( len == 2 ) objTextBox.value = '0'+ SeparadorDecimal + aux;
	
	if( len > 2 ) {
		
		aux2 = '';
		
		for ( j = 0, i = len - 3; i >= 0; i-- ) {
			
			if( j == 3 ) {
				
				aux2 += SeparadorMilesimo;
				j = 0;
				
			}
			
			aux2 += aux.charAt( i );
			j++;
			
		}
		
		objTextBox.value = '';
		len2             = aux2.length;
		
		for( i = len2 - 1; i >= 0; i-- ) {
			
			objTextBox.value += aux2.charAt( i );
			
		}
		
		objTextBox.value += SeparadorDecimal + aux.substr( len - 2, len );
		
	}
	
	return false;
	
}

function limpar_campo( id ) {
	
	document.getElementById( id ).value = "0,00";
	document.getElementById( id ).focus();
	
}

function formata_string( elemento ) {
	
	var alvo          = document.getElementById( elemento );
	var entrada       = alvo.value.length;
	var string        = alvo.value.substr( entrada - 1, entrada );
	var valida_digito = new RegExp(/^[0-9a-zA-Z ]$/);
	
	if ( ! valida_digito.test( string ) ) {
		
		alvo.value = alvo.value.substr( 0, entrada - 1 );
		
	}
	
}

function formata_decimal( elemento ) {
	
	var alvo          = document.getElementById( elemento );
	var entrada       = alvo.value.length;
	var digito        = alvo.value.substr( entrada - 1, entrada );
	var valida_digito = new RegExp(/^[0-9]$/);
	
	if ( ! valida_digito.test( digito ) ) {
		
		alvo.value = alvo.value.substr( 0, entrada - 1 );
		
	}
	
}

function exec_focus( id ) {
	
	document.getElementById( id ).focus();
	
}

function confirmar_excluir( nome_arquivo ) {
	
	document.getElementById( "div_tela_preta" ).style.display     = "block";
	document.getElementById( "div_excluir"    ).style.display     = "block";
	document.getElementById( "nome_arquivo"   ).innerHTML         = "<h2>" + nome_arquivo + "</h2>";
	
	document.getElementById( "input_hidden_excluir_lista" ).value = nome_arquivo;
	
}

function confirmar_excluir_recurso( nome_recurso, valor_recurso ) {
	
	document.getElementById( "div_tela_preta"      ).style.display  = "block";
	document.getElementById( "div_excluir_recurso" ).style.display  = "block";
	document.getElementById( "nome_recurso"        ).innerHTML      = "<h2>" + nome_recurso + "</h2>";
	
	document.getElementById( "input_hidden_excluir_recurso" ).value = nome_recurso;
	document.getElementById( "input_hidden_valor_recurso"   ).value = valor_recurso;
	
}

function resolucao_tela() {
	
	var x = screen.width;
	var y = screen.height;
	
	alert( x +"x"+ y );
	
}

function configurar_parametros( opcao ) {
	
	var produtos = document.getElementsByName( "info_produto" );
	var params   = "salvar_lista=";
	
	for( var i = 0; i < produtos.length; i++ ) {
	
		params += produtos.item( i ).value + ";";
	
	}
	
	var salvar_total_compra      = document.getElementById( "input_total_compra"           ).value;
	var salvar_saldo_compra      = document.getElementById( "input_saldo_compra"           ).value;
	var salvar_qtde_itens        = document.getElementById( "input_hidden_qtde_itens"      ).value;
	var salvar_dinheiro_aplicado = document.getElementById( "input_dinheiro_compra"        ).value;
	var salvar_contador          = document.getElementById( "input_hidden_guarda_contador" ).value;
	var salvar_recursos          = document.getElementById( "input_hidden_guarda_recursos" ).value;
	
	params += "&salvar_saldos=";
	params += salvar_total_compra + ":" + salvar_saldo_compra + ":" + salvar_qtde_itens + ":" + salvar_dinheiro_aplicado + ":" + salvar_contador;
	
	params += "&salvar_recursos=" + salvar_recursos;
	
	var nome_lista = "";

	switch ( opcao ) {
		
		// Cria uma nova lista com o conteudo corrente que esta na tela
		case "nova_lista":
			nome_lista = document.getElementById( "input_cria_nova_lista" ).value;
			
			// Atualiza o valor do input com o novo nome da lista - session PHP tambem e atualizada
			document.getElementById( "input_hidden_nome_lista" ).value = nome_lista;
			break;
		
		// Mantem o nome da lista atual e sobrescreve seu conteudo
		case "sobrescrever":
			nome_lista = document.getElementById( "input_hidden_nome_lista" ).value;
			break;
	}
	
	params += "&nome_lista=" + nome_lista;
	
	return params;
	
}

function expandir_tamanho( elemento ) {
	
	var array_elementos = document.getElementsByClassName( 'div_adicional' );
	
	for( var i = 0; i < array_elementos.length; i++ ) {
		
		var elemento_atual = "div_adicional_" + i;
		
		if( elemento_atual != elemento ) {
			
			document.getElementById( 'div_adicional_' + i ).style.height = "0px";
			
		}
		
	}
	
	if( document.getElementById( elemento ).style.height == "100px" ) {
	 
		document.getElementById( elemento ).style.height = "0px";
		
	} else {
		
		document.getElementById( elemento ).style.height = "100px";
		
	}
	
}

function abrir_editor_produto( contador ) {
	
	// Mostra div para edicao de produto
	abrir_elemento( "div_edita_produto" );
	
	// Configura dados para inputar no form de edicao
	var parametros_edicao = document.getElementById( "info_produto_" + contador ).value;
	var campos_produto    = parametros_edicao.split( ":" );
	var nome_produto      = campos_produto[0];
	var qtde_produto      = campos_produto[1];
	var preco_produto     = campos_produto[2];
	var total_produto     = campos_produto[3];
	
	// Input os dados configurados no form
	document.getElementById( "input_edita_produto"      ).value = nome_produto;
	document.getElementById( "input_edita_qtde"         ).value = qtde_produto;
	document.getElementById( "input_edita_preco"        ).value = preco_produto;
	document.getElementById( "input_hidden_edita_total" ).value = total_produto;
	document.getElementById( "input_hidden_edita_item"  ).value = contador;
	
}

function abrir_editor_pos_pesquisa( info_produto ) {
	
	fechar_elemento( "div_pesquisar_produto" );
	fechar_elemento( "div_mostrar_pesquisas" );
	abrir_elemento( "div_edita_produto" );
	
	// Configura dados para inputar no form de edicao
	var parametros_edicao = info_produto.split( ":" );
	var nome_produto      = parametros_edicao[0];
	var qtde_produto      = parametros_edicao[1];
	var preco_produto     = parametros_edicao[2];
	var total_produto     = parametros_edicao[3];
	var indice_produto    = parametros_edicao[4];
	
	// Input os dados configurados no form
	document.getElementById( "input_edita_produto"      ).value = nome_produto;
	document.getElementById( "input_edita_qtde"         ).value = qtde_produto;
	document.getElementById( "input_edita_preco"        ).value = preco_produto;
	document.getElementById( "input_hidden_edita_total" ).value = total_produto;
	document.getElementById( "input_hidden_edita_item"  ).value = indice_produto;
	
}

function fechar_pesquisar_produto( id_elemento ) {
					
	// Jquery para mostrar elementos com efeitos
	$(document).ready(function(){
	
		$("#"+id_elemento).fadeOut();
		
	});
	
	if( verificar_tag_criada( "div", "div_tela_preta" ) == true ) {
		
		document.getElementById( "div_tela_preta" ).style.display = "none";
	
	}
	
	fechar_elemento( "div_mostrar_pesquisas" );
	
}

function item_no_carrinho( indice_item ) {
	
	var no_carrinho   = document.getElementById( "no_carrinho_" + indice_item ).value;
	var total_produto = document.getElementById( "total_produto_" + indice_item ).value;
	
	if ( total_produto == "0,00" ) {
		
		return false;
		
	}
	
	if ( no_carrinho == "nao" ) {
		
		document.getElementById( "no_carrinho_" + indice_item ).value = "sim";
		
		document.getElementById( "nome_produto_"  + indice_item ).className = "a_altera_produto prod_no_carrinho";
		document.getElementById( "qtde_produto_"  + indice_item ).className = "input_text prod_no_carrinho";
		document.getElementById( "preco_produto_" + indice_item ).className = "input_text prod_no_carrinho";
		document.getElementById( "total_produto_" + indice_item ).className = "input_text prod_no_carrinho";
		
	} else {
		
		document.getElementById( "no_carrinho_" + indice_item ).value = "nao";
		
		document.getElementById( "nome_produto_"  + indice_item ).className = "a_altera_produto prod_em_uso";
		document.getElementById( "qtde_produto_"  + indice_item ).className = "input_text prod_em_uso";
		document.getElementById( "preco_produto_" + indice_item ).className = "input_text prod_em_uso";
		document.getElementById( "total_produto_" + indice_item ).className = "input_text prod_em_uso";
		
	}
	
	fechar_elemento( "div_edita_produto" );
	
	return false;
	
}
