
function alterar_produto() {
	
	// Variaveis para alteracao de produto
	var novo_nome    = document.getElementById( "input_edita_produto"      ).value;
	var nova_qtde    = document.getElementById( "input_edita_qtde"         ).value;
	var novo_preco   = document.getElementById( "input_edita_preco"        ).value;
	var antigo_total = document.getElementById( "input_hidden_edita_total" ).value;
	var indice_item  = document.getElementById( "input_hidden_edita_item"  ).value;
	
	// Para recalcular saldo e total da compra
	var dinheiro_aplicado  = document.getElementById( "input_dinheiro_compra" ).value;
	var total_compra       = document.getElementById( "input_total_compra" ).value;
	
	// O nome do produto nao pode ser vazio ou nulo
	if( novo_nome == "" || ! novo_nome ) { return false; }
	
	// Inicia o objeto XMLHttpRequest e verifica se foi criado corretamente
	iniciar_xmlhttp();
	
	// Calculando novo total do produto, novo saldo
	var retornoXml = "";
	var params     = "alterar_produto=" + nova_qtde + ":" + novo_preco + ":" + antigo_total + ":" + dinheiro_aplicado + ":" + total_compra;
		
	xmlhttp.open( 'POST', url_alterar_produto, true );
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
				
				// Obtem o novo total para o produto
				novo_total_produto = xmlTagsName[0].getElementsByTagName( "novo_total_produto"  )[0].firstChild.nodeValue;
				
				// Obtem o novo total para a compra
				novo_total_compra = xmlTagsName[0].getElementsByTagName( "novo_total_compra"  )[0].firstChild.nodeValue;
				
				// Obtem o novo saldo para a compra
				novo_saldo_compra = xmlTagsName[0].getElementsByTagName( "novo_saldo_compra"  )[0].firstChild.nodeValue;
				
				// Mostra os novos valores do produto
				var info_produto = novo_nome+":"+nova_qtde+":"+novo_preco+":"+novo_total_produto+":"+indice_item;
				
				document.getElementById( "nome_produto_"  + indice_item ).innerHTML = novo_nome;
				document.getElementById( "qtde_produto_"  + indice_item ).value     = nova_qtde;
				document.getElementById( "preco_produto_" + indice_item ).value     = novo_preco;
				document.getElementById( "total_produto_" + indice_item ).value     = novo_total_produto;
				document.getElementById( "info_produto_"  + indice_item ).value     = info_produto;
				
				// Mostra o novo total para a compra
				document.getElementById( "input_total_compra" ).value = novo_total_compra;
				
				// Mostra o novo saldo
				document.getElementById( "input_saldo_compra" ).value = novo_saldo_compra;
				
				if ( novo_total_produto == "0,00" || novo_total_produto == "" ) {
					
					document.getElementById( "nome_produto_"  + indice_item ).className = "a_altera_produto prod_nao_usado";
					document.getElementById( "qtde_produto_"  + indice_item ).className = "input_text prod_nao_usado";
					document.getElementById( "preco_produto_" + indice_item ).className = "input_text prod_nao_usado";
					document.getElementById( "total_produto_" + indice_item ).className = "input_text prod_nao_usado";
					
				} else {
					
					document.getElementById( "nome_produto_"  + indice_item ).className = "a_altera_produto prod_em_uso";
					document.getElementById( "qtde_produto_"  + indice_item ).className = "input_text prod_em_uso";
					document.getElementById( "preco_produto_" + indice_item ).className = "input_text prod_em_uso";
					document.getElementById( "total_produto_" + indice_item ).className = "input_text prod_em_uso";
					
				}
				
				verificar_saldo_atual();
				salvar_lista_automaticamente();
				
				mensagem = "<h2>Produto alterado com sucesso !</h2>";
				mostra_mensagem( "div_mensagens_sucesso", mensagem, tempo );
				
			} else {
				
				mensagem = "<h2>XmlHttpRequest falhou !</h2>";
				mostra_mensagem( "div_mensagens_sucesso", mensagem, tempo );
				
			}
			
		}
		
	}
	
	// Fecha a div apos aplicar o novo dinheiro e calcular o novo saldo
	fechar_elemento( "div_edita_produto" );
	
	return false;
	
}
