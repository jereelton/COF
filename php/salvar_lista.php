<?php

session_start();

header("Content-Type: text/xml");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jun 2015 05:00:00 GMT");

if( isset( $_POST[ 'salvar_lista' ] ) && isset( $_POST[ 'salvar_saldos' ] ) && isset( $_POST[ 'nome_lista' ] ) && isset( $_POST[ 'salvar_recursos' ]) ) {
	
	$dados_lista    = trim( $_POST[ 'salvar_lista'    ] );
	$dados_saldo    = trim( $_POST[ 'salvar_saldos'   ] );
	$nome_lista     = trim( $_POST[ 'nome_lista'      ] );
	$dados_recursos = trim( $_POST[ 'salvar_recursos' ] );
	
	$retorno_xml = salvar_lista_xml( $dados_lista, $dados_saldo, $nome_lista, $dados_recursos );
	
	$xml         = "";
	$resposta    = "SIM";
	
	// Verifica se a lista foi salva ou nao
	if( $retorno_xml == false ) { $resposta = "NAO"; }
		
	$xml  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$xml .= "<lista_salva>\n";
	$xml .= "	<resposta>" .$resposta. "</resposta>\n";
	$xml .= "</lista_salva>\n";
	
	echo $xml;

} else {
	
	die( "Erro na passagem dos parametros : _POST" );
	
	}

function salvar_lista_xml( $lista_produtos, $saldos, $nome_lista, $lista_recursos ) {
	
	/* SALVANDO PRODUTOS */
	
	// Array com os produtos a serem salvos
	$array_produtos = explode( ";", $lista_produtos );
	sort( $array_produtos );
	
	// Inicia o conteudo xml
	$conteudo_xml   = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$conteudo_xml  .= "<lista_produtos>\n";
	
	// Percorre a lista de produtos a serem salvos
	foreach ( $array_produtos as $produto ) {
		
		if( $produto <> "" ) {
			
			// Obtem os parametros referentes ao produto
			$array_produto  = explode( ":", $produto );
			$nome_produto   = strtolower( $array_produto[0] );
			$qtde_produto   = $array_produto[1];
			$preco_produto  = $array_produto[2];
			$total_produto  = $array_produto[3];
			$indice_produto = $array_produto[4];
			
			// Criando o conteudo a ser salvo no formato xml
			$conteudo_xml .= "	<produto>\n";
			$conteudo_xml .= "		<nome_produto>"   . $nome_produto   . "</nome_produto>\n";
			$conteudo_xml .= "		<qtde_produto>"   . $qtde_produto   . "</qtde_produto>\n";
			$conteudo_xml .= "		<preco_produto>"  . $preco_produto  . "</preco_produto>\n";
			$conteudo_xml .= "		<total_produto>"  . $total_produto  . "</total_produto>\n";
			$conteudo_xml .= "		<indice_produto>" . $indice_produto . "</indice_produto>\n";
			$conteudo_xml .= "	</produto>\n";
			
		}
		
	}
	
	/* SALVANDO SALDOS */
	
	// Array com os saldos da lista de compra
	$array_saldos      = explode( ":", $saldos );
	$total_compra      = $array_saldos[0];
	$saldo_compra      = $array_saldos[1];
	$qtde_itens        = $array_saldos[2];
	$dinheiro_aplicado = $array_saldos[3];
	$guardar_contador  = $array_saldos[4];
	
	// Ajustando contador
	if( $qtde_itens == "Nenhum Item" || $qtde_itens == 0 ) {
		
		$guardar_contador = 1;
		
	}
	
	// Parametros referente a lista de compra atual
	$conteudo_xml .= "	<saldos>\n";
	$conteudo_xml .= "		<total_compra>"      .$total_compra.      "</total_compra>\n";
	$conteudo_xml .= "		<saldo_compra>"      .$saldo_compra.      "</saldo_compra>\n";
	$conteudo_xml .= "		<qtde_itens>"        .$qtde_itens.        "</qtde_itens>\n";
	$conteudo_xml .= "		<dinheiro_aplicado>" .$dinheiro_aplicado. "</dinheiro_aplicado>\n";
	$conteudo_xml .= "		<contador>"          .$guardar_contador.  "</contador>\n";
	$conteudo_xml .= "	</saldos>\n";
	
	/* SALVANDO OS RECURSOS */
	
	if( $lista_recursos != "" ) {
		
		// Obtendo a lista de recursos por nome e valor
		$array_recursos = explode( ";", $lista_recursos );
		
		foreach ( $array_recursos as $recurso ) {
			
			if( $recurso <> "" ) {
				
				// Obtem os parametros referentes ao recurso: [nome|valor]
				$array_recurso = explode( ":", $recurso );
				$nome_recurso  = $array_recurso[0];
				$valor_recurso = $array_recurso[1];
				
				// Criando o conteudo a ser salvo no formato xml
				$conteudo_xml .= "	<recurso>\n";
				$conteudo_xml .= "		<nome>"  . $nome_recurso  . "</nome>\n";
				$conteudo_xml .= "		<valor>" . $valor_recurso . "</valor>\n";
				$conteudo_xml .= "	</recurso>\n";
			
			}
			
		}
		
	}
	
	// Finaliza a estrutura xml
	$conteudo_xml .= "</lista_produtos>\n";
	
	// Tratando o nome da lista
	$nome_lista_salvar = str_replace( " ", "_", $nome_lista );
	
	// Local onde a lista sera salva
	$arquivo_xml = fopen( "../listas/" . $nome_lista_salvar . ".xml", "w+" );
	
	// Salvando a lista
	if( ! fwrite( $arquivo_xml, $conteudo_xml ) ) {
		
		return false;
		
	}
	
	$_SESSION[ 'nome_lista' ] = $nome_lista_salvar;
	
	fclose( $arquivo_xml );
	
	return true;
	
}

?>
