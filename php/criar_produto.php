<?php

session_start();

header("Content-Type: text/xml");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jun 2015 05:00:00 GMT");

include("log.php");
include("calculo_monetario_full.php");

if( isset( $_POST[ 'criar_produto' ] ) ) {
	
	# criar_produto = cria_qtde_produto + ":" + cria_preco_produto + ":" + dinheiro_aplicado + ":" + total_compra + ":" + qtde_itens;
	
	log_sistema( "----------------------------------------------------------------" );
	log_sistema( "[ Criar Produto ]" );
	log_sistema( "Dados Recebidos: " . $_POST[ 'criar_produto' ] );
	
	$processar_info = explode( ":", trim( $_POST[ 'criar_produto' ] ) );
	
	# DINHEIRO ATUAL
	$dinheiro_atual_aplicado = trim( $processar_info[2] );
	
	log_sistema( "Dinheiro Atual Aplicado: " . $dinheiro_atual_aplicado );
	
	# TOTAL ATUAL
	$total_atual_compra = trim( $processar_info[3] );
	
	log_sistema( "Total Atual Compra: " . $total_atual_compra );
	
	# SALDO ATUAL
	$saldo_atual_compra = calcular_operacao_monetaria( $dinheiro_atual_aplicado , $total_atual_compra, "-" );
	
	log_sistema( "Saldo Atual Compra: " . $saldo_atual_compra );
	
	# QTDE PRODUTO
	$qtde_produto = trim( $processar_info[0] );
	
	log_sistema( "Qtde Produto: " . $qtde_produto );
	
	# VALOR PRODUTO
	$valor_produto = trim( $processar_info[1] );
	
	log_sistema( "Valor Produto: " . $valor_produto );
	
	# TOTAL PRODUTO
	$total_produto = calcular_operacao_monetaria( $qtde_produto, $valor_produto, "*" );
	
	log_sistema( "Total Produto: " . $total_produto );
	
	# NOVO TOTAL COMPRA
	$novo_total_compra = calcular_operacao_monetaria( $total_atual_compra , $total_produto, "+" );
	
	log_sistema( "Novo Total Compra: " . $novo_total_compra );
	
	# NOVO SALDO COMPRA
	$novo_saldo_compra = calcular_operacao_monetaria( $dinheiro_atual_aplicado, $novo_total_compra, "-" );
	
	log_sistema( "Novo Saldo Compra: " . $novo_saldo_compra );
	
	# QTDE DE ITENS
	$qtde_itens = trim( $processar_info[4] ) + 1;
	
	log_sistema( "Nova Qtde Itens: " . $qtde_itens );
	
	# GERAR O XML RESPONSE PARA VISUALIZAR PELO JS E HTML
	$xml_response  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$xml_response .= "<calculos_compra>\n";
	$xml_response .= "	<total_produto>" .$total_produto. "</total_produto>\n";
	$xml_response .= "	<qtde_itens>"    .$qtde_itens.    "</qtde_itens>\n";
	$xml_response .= "	<saldo_novo>"    .$novo_saldo_compra.    "</saldo_novo>\n";
	$xml_response .= "	<total_compra>"  .$novo_total_compra.  "</total_compra>\n";
	$xml_response .= "</calculos_compra>\n";

	# ZERANDO OPERACAO
	$dinheiro_atual_aplicado = 0;
	$total_atual_compra      = 0;
	$saldo_atual_compra      = 0;
	$valor_produto           = 0;
	$total_produto           = 0;
	$novo_total_compra       = 0;
	$novo_saldo_compra       = 0;
	
	echo $xml_response;
}

?>
