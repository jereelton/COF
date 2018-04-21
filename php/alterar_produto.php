<?php

session_start();

header("Content-Type: text/xml");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jun 2015 05:00:00 GMT");

include("log.php");
include("calculo_monetario_full.php");

if( isset( $_POST[ 'alterar_produto' ] ) ) {
	
	log_sistema( "----------------------------------------------------------------" );
	log_sistema( "[ Alterar Produto ]" );
	log_sistema( "Dados Recebidos: " . $_POST[ 'alterar_produto' ] );
	
	$processar_info    = explode( ":", trim( $_POST[ 'alterar_produto' ] ) );
	
	# DINHEIRO ATUAL APLICADO
	$dinheiro_atual_aplicado = trim( $processar_info[3] );
	
	log_sistema( "Dinheiro Atual Aplicado: " . $dinheiro_atual_aplicado );
	
	# TOTAL ATUAL COMPRA
	$total_atual_compra = trim( $processar_info[4] );
	
	log_sistema( "Total Atual Compra: " . $total_atual_compra );
	
	# SALDO ATUAL COMPRA
	$saldo_atual_compra = calcular_operacao_monetaria( $dinheiro_atual_aplicado , $total_atual_compra, "-" );
	
	log_sistema( "Saldo Atual Compra: " . $saldo_atual_compra );
	
	# TOTAL ATUAL PRODUTO
	$total_atual_produto = trim( $processar_info[2] );
	
	log_sistema( "Total Atual Produto: " . $total_atual_produto );
	
	# NOVO VALOR PRODUTO
	$novo_valor_produto = trim( $processar_info[1] );
	
	log_sistema( "Novo Valor Produto: " . $novo_valor_produto );
	
	# NOVA QTDE PRODUTO
	$nova_qtde_produto = trim( $processar_info[0] );
	
	log_sistema( "Nova Qtde Produto: " . $nova_qtde_produto );
	
	# NOVO TOTAL PRODUTO
	$novo_total_produto = calcular_operacao_monetaria( $nova_qtde_produto, $novo_valor_produto, "*" );
	
	log_sistema( "Novo Total Produto: " . $novo_total_produto );
	
	# NOVO TOTAL COMPRA
	$novo_total_compra = calcular_operacao_monetaria( $total_atual_compra, $total_atual_produto, "-" );
	$novo_total_compra = calcular_operacao_monetaria( $novo_total_compra, $novo_total_produto, "+" );
	
	log_sistema( "Novo Total Compra: " . $novo_total_compra );
	
	# NOVO SALDO COMPRA
	$novo_saldo_compra = calcular_operacao_monetaria( $dinheiro_atual_aplicado, $novo_total_compra, "-" );
	
	# GERAR O XML RESPONSE PARA VISUALIZAR PELO JS E HTML
	$xml_response  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$xml_response .= "<calculos_compra>\n";
	$xml_response .= "	<novo_total_produto>" .$novo_total_produto. "</novo_total_produto>\n";
	$xml_response .= "	<novo_total_compra>"  .$novo_total_compra.  "</novo_total_compra>\n";
	$xml_response .= "	<novo_saldo_compra>"  .$novo_saldo_compra.  "</novo_saldo_compra>\n";
	$xml_response .= "</calculos_compra>\n";
	
	echo $xml_response;
	
}

?>
