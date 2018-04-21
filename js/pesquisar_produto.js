
function pesquisar_produto() {

	var chave_pesquisa = document.getElementById( 'input_pesquisar_produto').value;
	
	if( validar_campo_vazio( "input_pesquisar_produto" ) == true ) {
		
		mensagem = "<h2>O campo de pesquisa nao pode ser vazio !</h2>";
		mostra_mensagem( "div_mensagens_erro", mensagem, tempo );
				
		return false;
		
	}
	
	// Inicia o objeto XMLHttpRequest e verifica se foi criado corretamente
	iniciar_xmlhttp();
	
	// Variaveis para processar
	var retornoXml = "";
	var params     = "pesquisar_produto=" + chave_pesquisa;
	
	// Configurando envio dos parametros para processamento
	xmlhttp.open( 'POST', url_pesquisar_produto, true );
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
				xmlTagsName = xmlDoc.getElementsByTagName( "retorno_pesquisa" );
				
				// Obtem as tags que contem ou nao o retorno da pesquisa
				retorno_pesquisa = xmlTagsName[0].getElementsByTagName( "resposta" );
				
				if( retorno_pesquisa.length >= 1 && retorno_pesquisa[0].firstChild.nodeValue != "Nada encontrado" ) {
					
					abrir_elemento( 'div_mostrar_pesquisas' );
					
					document.getElementById( 'div_mostrar_pesquisas' ).innerHTML = "";
					
					for( var i = 0; i < retorno_pesquisa.length; i++ ) {
						
						var tmp            = retorno_pesquisa[i].firstChild.nodeValue.split( ":" );
						var info_produto   = retorno_pesquisa[i].firstChild.nodeValue;
						var nome_produto   = tmp[0];
						var qtde_produto   = tmp[1];
						var preco_produto  = tmp[2];
						var total_produto  = tmp[3];
						var indice_produto = tmp[4];
						
						var conteudo = '<input type="button" id="" name="" onclick="return abrir_editor_pos_pesquisa( \'' +info_produto+ '\' );" value="' +nome_produto+ '" />';
						
						document.getElementById( 'div_mostrar_pesquisas' ).innerHTML += conteudo + "<br />";
						
					}
				
				} else {
				
					abrir_elemento( 'div_mostrar_pesquisas' );
					
					document.getElementById( 'div_mostrar_pesquisas' ).innerHTML = "Nada encontrado para " + chave_pesquisa;
					
					}
				
			} else { 
				
				mensagem = "<h2>XmlHttpRequest falhou !</h2>";
				mostra_mensagem( "div_mensagens_erro", mensagem, tempo );
				
			}
			
		}
		
	}
	
	return false;

}
