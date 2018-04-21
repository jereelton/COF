
function carregar_recursos_aplicados( id_div ) {
	
	// Inicia o objeto XMLHttpRequest e verifica se foi criado corretamente
	iniciar_xmlhttp();
	
	// Variaveis para processar
	var retornoXml = "";
	var params     = "carregar_recursos_aplicados=carregarRecursosXml";
	
	// Configurando envio dos parametros para processamento
	xmlhttp.open( 'POST', url_carregar_recursos_aplicados, true );
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
				xmlTagsName = xmlDoc.getElementsByTagName( "recursos_aplicados" );
				
				// Obtem as tags que contem ou nao o retorno da pesquisa
				recursos_salvos = xmlTagsName[0].getElementsByTagName( "recurso" );
				
				// Quantidade de listas salvas
				try  {
					
					qtde_recurso_salvos = recursos_salvos[0].getElementsByTagName( "nome" )[0].firstChild.nodeValue;
					
				} catch(e) {
					
					qtde_recurso_salvos = "Nada Encontrado";
					
				}
				
				// Zerando a lista de listas salvas
				document.getElementById( id_div ).innerHTML = "";
				
				if( recursos_salvos.length >= 1 && qtde_recurso_salvos != "Nada encontrado" ) {
					
					for( var i = 0; i < recursos_salvos.length; i++ ) {
						
						var nome_recurso  = recursos_salvos[i].getElementsByTagName( "nome"  )[0].firstChild.nodeValue;
						var valor_recurso = recursos_salvos[i].getElementsByTagName( "valor" )[0].firstChild.nodeValue;
						
						var conteudo = '\
							<div class="div_mostra_recursos_salvos">\
								<p>\
									<a onclick="return expandir_tamanho( \'div_adicional_' + i + '\' );">\
										<span class="span_nome_recurso">'  + nome_recurso  + '</span>\
										<span class="span_valor_recurso">R$ ' + valor_recurso + '</span>\
									</a>\
								</p>\
								<div class="div_adicional" id="div_adicional_'+ i +'">\
									<p class="p_produto">\
										<input class="input_button input_fechar"  type="button" onclick="return expandir_tamanho( \'div_adicional_' + i + '\' );" />\
										<input class="input_button input_remover" type="button" onclick="return confirmar_excluir_recurso( \'' + nome_recurso + '\', \'' + valor_recurso + '\' );" />\
									</p>\
								</div>\
							</div>';
						
						document.getElementById( id_div ).innerHTML += conteudo;
						
					}
				
				} else {
					
					document.getElementById( id_div ).innerHTML = "<h4>Nao existem recursos aplicados !</h4>";
					
					}
				
			} else { 
				
				mensagem = "<h2>XmlHttpRequest falhou !</h2>";
				mostra_mensagem( "div_mensagens_erro", mensagem, tempo );
				
			}
			
		}
		
	}
	
	return false;
	
}
