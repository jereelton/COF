
function remover_produto() {
	
	// Obtendo os parametros do produto que sera removido
	var contador_item_remover  = document.getElementById( "input_hidden_edita_item" ).value;
	var parametros_produto     = document.getElementById( "info_produto_" + contador_item_remover ).value;
	var array_info_produto     = parametros_produto.split( ":" );
	
	// Configurando parametros para remover produto e recalcular valores
	var total_produto_subtrair = array_info_produto[3];
	var dinheiro_aplicado      = document.getElementById( "input_dinheiro_compra"   ).value;
	var total_compra_atual     = document.getElementById( "input_total_compra"      ).value;
	var saldo_compra           = document.getElementById( "input_saldo_compra"      ).value;
	var qtde_itens             = document.getElementById( "input_hidden_qtde_itens" ).value;
	
	// Inicia o objeto XMLHttpRequest e verifica se foi criado corretamente
	iniciar_xmlhttp();
	
	// Variaveis para enviar para o objeto xmlhttprequest
	var retornoXml = "";
	var params     = "remover_produto=" + total_produto_subtrair + ":" + dinheiro_aplicado + ":" + total_compra_atual + ":" + saldo_compra + ":" + qtde_itens;
		
	xmlhttp.open( 'POST', url_remover_produto, true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( params );
	
	// Obtendo o retorno do processamento PHP tipo XML
	xmlhttp.onreadystatechange = function () {
		
		// verifica se o objeto xmlhttprequest esta pronto e correto
		if( xmlhttp.readyState == 4 || xmlhttp.readyState == 0 || xmlhttp.readyState == "complete" ) { 
			
			if ( xmlhttp.status == 200 ) {
				
				// Guarda o retorno do xml
				xmlDoc      = xmlhttp.responseXML;
				
				// Obtem as tags que abrem e fecham o xml <calculando_total></calculando_total>
				xmlTagsName = xmlDoc.getElementsByTagName( "calculos_compra" );
				
				// Obtem o novo total da compra
				novo_total_compra = xmlTagsName[0].getElementsByTagName( "novo_total_compra" )[0].firstChild.nodeValue;
				
				// Obtem a nova qtde de itens
				xml_itens_compra  = xmlTagsName[0].getElementsByTagName( "nova_qtde_itens"   )[0].firstChild.nodeValue;
				nova_qtde_itens   = formata_qtde_itens( xml_itens_compra );
				
				// Obtem o novo saldo para a compra
				novo_saldo_compra = xmlTagsName[0].getElementsByTagName( "novo_saldo_compra" )[0].firstChild.nodeValue;
				
				// Mostra o novo total da compra
				document.getElementById( "input_total_compra" ).value = novo_total_compra;
				
				// Mostra a nova qtde de itens
				document.getElementById( "input_hidden_qtde_itens" ).value     = xml_itens_compra;
				document.getElementById( "span_qtde_itens"         ).innerHTML = nova_qtde_itens;
				
				// Mostra o novo saldo
				document.getElementById( "input_saldo_compra" ).value = novo_saldo_compra;
				
				verificar_saldo_atual();
				
				salvar_lista_automaticamente();
				
			} else { 
				
				mensagem = "<h2>XmlHttpRequest falhou !</h2>";
				mostra_mensagem( "div_mensagens_sucesso", mensagem, tempo );
				
			}
			
		}
		
	}
	
	// Removendo o elemento da lista
	var objPai   = document.getElementById( "div_conteiner_lista" );
	var objFilho = document.getElementById( "div_produto_" + contador_item_remover );
	objPai.removeChild( objFilho );
				
	mensagem = "<h2>Item removido com sucesso !</h2>";
	mostra_mensagem( "div_mensagens_sucesso", mensagem, tempo );
	
	// Fecha a div que edita produtos
	fechar_elemento( "div_edita_produto" );
	
}
