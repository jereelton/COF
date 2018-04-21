
function carregar_listas_salvas( id_div ) {
	
	// Inicia o objeto XMLHttpRequest e verifica se foi criado corretamente
	iniciar_xmlhttp();
	
	// Variaveis para processar
	var retornoXml = "";
	var params     = "carregar_listas_salvas=carregarListasXml";
	
	// Configurando envio dos parametros para processamento
	xmlhttp.open( 'POST', url_carregar_listas_salvas, true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( params );
	
	// Obtendo o retorno do processamento PHP tipo XML
	xmlhttp.onreadystatechange = function () {
	
		// verifica se o objeto xmlhttprequest esta pronto e correto
		if( xmlhttp.readyState == 4 || xmlhttp.readyState == 0 || xmlhttp.readyState == "complete" ) {
			
			if ( xmlhttp.status == 200 ) {
				
				// Guarda o retorno do xml
				xmlDoc      = xmlhttp.responseXML;
				
				// Obtem as tags que abrem e fecham o xml
				xmlTagsName = xmlDoc.getElementsByTagName( "lista_listas_salvas" );
				
				// Obtem as tags que contem ou nao o retorno da pesquisa
				listas_salvas = xmlTagsName[0].getElementsByTagName( "lista_xml_salva" );
				
				// Quantidade de listas salvas
				status_listas_salavs = listas_salvas[0].getElementsByTagName( "acessar_lista" )[0].firstChild.nodeValue;
				
				// Zerando a lista de listas salvas
				document.getElementById( id_div ).innerHTML = "";
				
				if( listas_salvas.length >= 1 && status_listas_salavs != "Nada encontrado" ) {
					
					for( var i = 0; i < listas_salvas.length; i++ ) {
						
						var acessar_lista = listas_salvas[i].getElementsByTagName( "acessar_lista" )[0].firstChild.nodeValue;
						var nome_lista    = listas_salvas[i].getElementsByTagName( "nome_lista"    )[0].firstChild.nodeValue;
						var qtde_itens    = listas_salvas[i].getElementsByTagName( "qtde_itens"    )[0].firstChild.nodeValue;
						var total_compra  = listas_salvas[i].getElementsByTagName( "total_compra"  )[0].firstChild.nodeValue;
						var limite_compra = listas_salvas[i].getElementsByTagName( "limite_compra" )[0].firstChild.nodeValue;
						
						var saldo_compra  = listas_salvas[i].getElementsByTagName( "saldo_compra"  )[0].firstChild.nodeValue;
						var xxx_compra    = listas_salvas[i].getElementsByTagName( "xxx_compra"    )[0].firstChild.nodeValue;
						
						var conteudo = '\
							<div class="div_links_listas_salvas">\
								<p>\
									<a onclick="return expandir_tamanho( \'div_adicional_' + i + '\' );">\
										<span class="span_nome_lista_compra">' + nome_lista  + '</span>\
										<span class="span_qtd_itens_compra">' + formata_qtde_itens( qtde_itens )  + '</span>\
										<br />\
										<span class="span_total_compra">TOTAL R$ ' + total_compra + '</span>\
										<span class="span_limite_compra">MAX R$ ' + limite_compra + '</span>\
										<br />\
										<span class="span_saldo_compra">SALDO R$ ' + saldo_compra + '</span>\
										<span class="span_xxx_compra">XXX R$ ' + xxx_compra + '</span>\
									</a>\
								</p>\
								<div class="div_adicional" id="div_adicional_'+ i +'">\
									<p class="p_produto">\
										<input class="input_button input_aplicar" type="button" onclick="return acessar_lista_salva( \'' + acessar_lista + '\' );" />\
										<input class="input_button input_fechar" type="button" onclick="return expandir_tamanho( \'div_adicional_' + i + '\' );" />\
										<input class="input_button input_remover" type="button" onclick="return confirmar_excluir( \'' + acessar_lista + '\' );" />\
									</p>\
								</div>\
							</div>';
						
						document.getElementById( id_div ).innerHTML += conteudo;
						
					}
				
				} else {
					
					document.getElementById( id_div ).innerHTML = "<h4>Nao existem listas salvas!</h4>";
					
					}
				
			} else { 
				
				mensagem = "<h2>XmlHttpRequest falhou !</h2>";
				mostra_mensagem( "div_mensagens_erro", mensagem, tempo );
				
			}
			
		}
		
	}
	
	return false;
	
}
