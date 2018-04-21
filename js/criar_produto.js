
function criar_produto() {
	
	// Variaveis para criar o produto
	var cria_nome_produto  = document.getElementById( "input_cria_produto" ).value;
	var cria_qtde_produto  = document.getElementById( "input_cria_qtde"    ).value;
	var cria_preco_produto = document.getElementById( "input_cria_preco"   ).value;
	var classe_dinamica    = "prod_em_uso";
	
	// Verifica se foi informado nome do produto
	if( cria_nome_produto == "" ) {
		
		mensagem = "<h2>Informe o nome do produto !</h2>";
		mostra_mensagem( "div_mensagens_erro", mensagem, tempo );
		
		return false;
		
	}
	
	// Inicia o objeto XMLHttpRequest e verifica se foi criado corretamente
	iniciar_xmlhttp();
	
	// Calculando o total do produto a ser criado
	var retornoXml = "";
	var params     = "criar_produto=";
	
	// Parametros para calculo de saldo, total compra e qtde de itens
	var dinheiro_aplicado = document.getElementById( "input_dinheiro_compra"   ).value;
	var total_compra      = document.getElementById( "input_total_compra"      ).value;
	var qtde_itens        = document.getElementById( "input_hidden_qtde_itens" ).value;
	
	// Configurando post a ser enviado ao processador.php
	params += cria_qtde_produto + ":" + cria_preco_produto + ":" + dinheiro_aplicado + ":" + total_compra + ":" + qtde_itens;
		
	xmlhttp.open( 'POST', url_criar_produto, true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( params );
	
	// Obtendo o retorno do processamento PHP tipo XML
	xmlhttp.onreadystatechange = function () {
		
		// verifica se o objeto xmlhttprequest esta pronto e correto
		if( xmlhttp.readyState == 4 || xmlhttp.readyState == 0 || xmlhttp.readyState == "complete" ) { 
			
			if ( xmlhttp.status == 200 ) {
				
				// Guarda o retorno do xml
				xmlDoc        = xmlhttp.responseXML;
				
				// Obtem as tags que abrem e fecham o xml <calculando_total></calculando_total>
				xmlTagsName   = xmlDoc.getElementsByTagName( "calculos_compra" );
				
				// Obtem o item zero do indice xml criado <total_calculado>7,50</total_calculado>
				cria_total_produto = xmlTagsName[0].getElementsByTagName( "total_produto"  )[0].firstChild.nodeValue;
				
				// Cria o valor oculto para o produto atual sendo criado
				cria_hidden_produto = cria_nome_produto + ":" + cria_qtde_produto + ":" + cria_preco_produto + ":" + cria_total_produto + ":" + contador;
				
				// Obtem o novo saldo para a compra
				novo_saldo_compra   = xmlTagsName[0].getElementsByTagName( "saldo_novo"  )[0].firstChild.nodeValue;

				// Obtem a nova quantidade de itens na lista de compras
				xml_itens_compra    = xmlTagsName[0].getElementsByTagName( "qtde_itens"  )[0].firstChild.nodeValue;
				qtde_itens_compra   = formata_qtde_itens( xml_itens_compra );

				// Novo total da compra
				novo_total_compra   = xmlTagsName[0].getElementsByTagName( "total_compra"  )[0].firstChild.nodeValue;
				
				if( cria_total_produto == "0,00" || cria_total_produto == "" ) {
					
					classe_dinamica = "prod_nao_usado";
					
				}
				
				// Conteudo a ser inserido dinamicamente
				var conteudo_produto = "\
					<table class=\"tabela_produtos\">\
						<tr id=\"linha_produto_" + contador + "\">\
							<td class=\"td_prod\">\
								<a id=\"nome_produto_" + contador + "\" class=\"a_altera_produto "+ classe_dinamica +"\" onclick=\"return abrir_editor_produto( \'" + contador + "\' );\">" + cria_nome_produto + "</a>\
							</td>\
							<td class=\"td_qtde\">\
								<input type=\"button\" id=\"qtde_produto_" + contador + "\" value=\"" + cria_qtde_produto + "\" class=\"input_text "+ classe_dinamica +"\" onclick=\"return item_no_carrinho( \'" + contador + "\' );\">\
							</td>\
							<td class=\"td_preco\">\
								<input type=\"button\" id=\"preco_produto_" + contador + "\" value=\"" + cria_preco_produto + "\" class=\"input_text "+ classe_dinamica +"\" onclick=\"return item_no_carrinho( \'" + contador + "\' );\">\
							</td>\
							<td class=\"td_total\">\
								<input type=\"button\" id=\"total_produto_" + contador + "\" value=\"" + cria_total_produto + "\" class=\"input_text "+ classe_dinamica +"\" onclick=\"return item_no_carrinho( \'" + contador + "\' );\">\
								<input type=\"hidden\" id=\"info_produto_" + contador + "\" name=\"info_produto\" value=\"" + cria_hidden_produto + "\" />\
								<input type=\"hidden\" id=\"indice_no_carrinho_" + contador + "\" name=\"indice_no_carrinho\" value=\"" + contador + "\" />\
								<input type=\"hidden\" id=\"no_carrinho_" + contador + "\" name=\"no_carrinho\" value=\"nao\" />\
							</td>\
						</tr>\
					</table>";
		
				var objPai    = document.getElementById( 'div_conteiner_lista' );
					
				var objFilho  = document.createElement( 'div' );
					
				objFilho.setAttribute( "id", "div_produto_" + contador );
				
				objPai.appendChild( objFilho );
					
				if( verificar_tag_criada( "div", "div_produto_" + contador ) == true ) {
						
					document.getElementById( "div_produto_" + contador ).innerHTML += conteudo_produto;
					
					document.getElementById( "input_total_compra"          ).value = novo_total_compra;
					document.getElementById( "input_saldo_compra"          ).value = novo_saldo_compra;
					document.getElementById( "input_hidden_guarda_contador").value = contador;
					document.getElementById( "input_hidden_qtde_itens"     ).value = xml_itens_compra;
					document.getElementById( "span_qtde_itens"             ).innerHTML = qtde_itens_compra;
					
					verificar_saldo_atual();
					salvar_lista_automaticamente();
						
					contador += 1;
					
					mensagem = "<h2>Item criado com sucesso</h2>";
					mostra_mensagem( "div_mensagens_sucesso", mensagem, tempo );
					
					exec_focus( "input_cria_produto" );
						
				} else {
					
					mensagem = "<h2>Erro ao tentar criar a div com id div_produto_" + contador + "</h2>";
					mostra_mensagem( "div_mensagens_erro", mensagem, tempo );
						
				}
					
				document.getElementById( "input_cria_produto" ).value = "";
				document.getElementById( "input_cria_qtde"    ).value = "";
				document.getElementById( "input_cria_preco"   ).value = "";
				
			} else { 
				
				mensagem = "<h2>XmlHttpRequest falhou !</h2>";
				mostra_mensagem( "div_mensagens_erro", mensagem, tempo );
				
			}
			
		}
		
	}
	
	return false;
	
}