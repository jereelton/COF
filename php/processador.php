<?php

session_start();

header("Content-Type: text/xml");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jun 2015 05:00:00 GMT");

if( isset( $_POST[ 'remover_produto' ] ) ) {
	
	#log_sistema( "------------------------------------------------------------" );
	#log_sistema( "[ Subtrair Produto ]" );
	
	//total_produto_subtrair + ":" + dinheiro_aplicado + ":" + total_compra_atual + ":" + saldo_compra + ":" + qtde_itens
	$processar_info         = explode( ":", trim( $_POST[ 'remover_produto' ] ) );
	
	#log_sistema( "Dados Recebidos: " . $processar_info );
	#log_sistema( "Dados Processados: " );
	
	$total_produto_subtrair = trim( $processar_info[0] );
	$dinheiro_aplicado      = trim( $processar_info[1] );
	$total_compra_atual     = trim( $processar_info[2] );
	$saldo_compra           = trim( $processar_info[3] );
	$qtde_itens             = trim( $processar_info[4] );
	
	#log_sistema( "Total Produto Subtrair : " . $total_produto_subtrair );
	#log_sistema( "Dinheiro Aplicado      : " . $dinheiro_aplicado );
	#log_sistema( "Total Compra Atual     : " . $total_compra_atual );
	#log_sistema( "Saldo Compra           : " . $saldo_compra );
	#log_sistema( "Qtde Itens             : " . $qtde_itens );
	
	// Recalculando total compra - subtraindo
	$tmp_total_produto_subtrair = str_replace( ".", "",  $total_produto_subtrair );
	$tmp_total_produto_subtrair = str_replace( ",", ".", $tmp_total_produto_subtrair );
	#log_sistema( "Tmp Total Produto Subtrair : " . $tmp_total_produto_subtrair );
	
	$tmp_total_compra           = str_replace( ".", "",  $total_compra_atual );
	$tmp_total_compra           = str_replace( ",", ".", $tmp_total_compra );
	#log_sistema( "Tmp Total Compra : " . $tmp_total_compra );
	
	$tmp_subtotal_compra        = $tmp_total_compra - $tmp_total_produto_subtrair;
	
	$novo_total_compra          = number_format( $tmp_subtotal_compra, 2, ',', '.' );
	#log_sistema( "Novo Total Compra : " . $novo_total_compra );
	
	// Recalculando qtde de itens na compra
	$nova_qtde_itens            = $qtde_itens - 1;
	
	// Recalculando saldo compra
	$tmp_dinheiro_aplicado = str_replace( ".", "",  $dinheiro_aplicado );
	$tmp_dinheiro_aplicado = str_replace( ",", ".", $tmp_dinheiro_aplicado );
	
	$tmp_subtotal_saldo    = $tmp_dinheiro_aplicado - $tmp_subtotal_compra;
	$novo_saldo_compra     = number_format( $tmp_subtotal_saldo, 2, ',', '.' );
	#log_sistema( "Novo Saldo Compra : " . $novo_saldo_compra );
	
	// Gerar o xml response para visualizar pelo js e html
	$calculo_xml  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$calculo_xml .= "<calculos_compra>\n";
	$calculo_xml .= "	<novo_total_compra>" .$novo_total_compra. "</novo_total_compra>\n";
	$calculo_xml .= "	<nova_qtde_itens>"   .$nova_qtde_itens.   "</nova_qtde_itens>\n";
	$calculo_xml .= "	<novo_saldo_compra>" .$novo_saldo_compra. "</novo_saldo_compra>\n";
	$calculo_xml .= "</calculos_compra>\n";
	
	echo $calculo_xml;
	
}

if( isset( $_POST[ 'alterar_produto' ] ) ) {
	
	log_sistema( "------------------------------------------------------------" );
	log_sistema( "[ Alterar Produto ]" );
	log_sistema( "Dados Recebidos: " . $_POST[ 'alterar_produto' ] );
	
	$processar_info    = explode( ":", trim( $_POST[ 'alterar_produto' ] ) );
	
	log_sistema( "Dados Processados: " );
	
	$nova_qtde         = trim( $processar_info[0] );
	$novo_preco        = trim( $processar_info[1] );
	$antigo_total      = trim( $processar_info[2] );
	$dinheiro_aplicado = trim( $processar_info[3] );
	$total_compra      = trim( $processar_info[4] );
	
	log_sistema( "Nova Qtde         : " . $nova_qtde );
	log_sistema( "Novo Preco        : " . $novo_preco );
	log_sistema( "Antigo Total      : " . $antigo_total );
	log_sistema( "Dinheiro Aplicado : " . $dinheiro_aplicado );
	log_sistema( "Total Compra      : " . $total_compra );
	
	// Calculo de novo total para o produto
	$novo_preco         = str_replace( ".", "",  $novo_preco );
	$novo_preco         = str_replace( ",", ".", $novo_preco );
	
	$subtotal_produto   = $nova_qtde * $novo_preco;
	log_sistema( "Subtotal Produto  : " . $subtotal_produto );
	
	$novo_total_produto = number_format( $subtotal_produto, 2, ',', '.' );
	log_sistema( "Novo Total Produto: " . $novo_total_produto );
	
	// Calculo de novo total para a compra
	$total_compra      = str_replace( ".", "",  $total_compra );
	$total_compra      = str_replace( ",", ".", $total_compra );
	$antigo_total      = str_replace( ".", "",  $antigo_total );
	$antigo_total      = str_replace( ",", ".", $antigo_total );
	log_sistema( "Calculando subtotal compra : (" . $total_compra . " - " . $antigo_total . ") + " . $novo_total_produto );
	
	$subtotal_compra   = ( $total_compra - $antigo_total ) + $novo_total_produto;
	log_sistema( "Subtotal Compra   : " . $subtotal_compra );
	
	$novo_total_compra = number_format( $subtotal_compra, 2, ',', '.' );
	log_sistema( "Novo Total Compra : " . $novo_total_compra );
	
	// Calculo de novo saldo
	$dinheiro_aplicado = str_replace( ".", "",  $dinheiro_aplicado );
	$dinheiro_aplicado = str_replace( ",", ".", $dinheiro_aplicado );
	
	$subtotal_saldo    = $dinheiro_aplicado - $novo_total_compra;
	log_sistema( "Dinheiro Aplicado " . $dinheiro_aplicado . " - Subtotal Compra " . $novo_total_compra );
	
	$novo_saldo_compra = number_format( $subtotal_saldo, 2, ',', '.' );
	log_sistema( "Novo Saldo Compra  : " . $novo_saldo_compra );
	
	// Gerar o xml response para visualizar pelo js e html
	$calculo_xml  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$calculo_xml .= "<calculos_compra>\n";
	$calculo_xml .= "	<novo_total_produto>" .$novo_total_produto. "</novo_total_produto>\n";
	$calculo_xml .= "	<novo_total_compra>"  .$novo_total_compra.  "</novo_total_compra>\n";
	$calculo_xml .= "	<novo_saldo_compra>"  .$novo_saldo_compra.  "</novo_saldo_compra>\n";
	$calculo_xml .= "</calculos_compra>\n";
	
	echo $calculo_xml;
	
}

if( isset( $_POST[ 'recalcular_calcular_saldo' ] ) ) {
	
	log_sistema( "------------------------------------------------------------" );
	log_sistema( "[ Recacular Saldo ]" );
	log_sistema( "Dados Recebidos: " . $_POST[ 'recalcular_calcular_saldo' ] );
	
	$processar_info  = explode( ":", trim( $_POST[ 'recalcular_calcular_saldo' ] ) );
	
	log_sistema( "Dados Processados: " );
	
	$dinheiro_compra = str_replace( ".", "",  trim( $processar_info[0] ) );
	$dinheiro_compra = str_replace( ",", ".", $dinheiro_compra );
	log_sistema( "Dinheiro Compra  : " . $dinheiro_compra );
	
	$total_compra    = str_replace( ".", "",  trim( $processar_info[1] ) );
	$total_compra    = str_replace( ",", ".", $total_compra );
	log_sistema( "Total Compra     : " . $total_compra );
	
	$saldo_compra    = number_format( ( $dinheiro_compra - $total_compra ), 2, ',', '.' );
	log_sistema( "Saldo Compra     : " . $saldo_compra );
	
	// Gerar o xml response para visualizar pelo js e html
	$calculo_xml  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$calculo_xml .= "<calculos_compra>\n";
	$calculo_xml .= "	<saldo_compra>" .$saldo_compra. "</saldo_compra>\n";
	$calculo_xml .= "</calculos_compra>\n";
	
	echo $calculo_xml;
	
}

if( isset( $_POST[ 'calcular_adicao_produto' ] ) ) {
	
	log_sistema( "------------------------------------------------------------" );
	log_sistema( "[ Adicao de Produto ]" );
	log_sistema( "Dados Recebidos: " . $_POST[ 'calcular_adicao_produto' ] );
	
	$processar_info = explode( ":", trim( $_POST[ 'calcular_adicao_produto' ] ) );
	
	// Parametros para processar
	$qtde_produto    = trim( $processar_info[0] );
	$preco_produto   = trim( $processar_info[1] );
	$dinheiro_compra = trim( $processar_info[2] );
	$total_compra    = trim( $processar_info[3] );
	$qtde_itens      = trim( $processar_info[4] );
	
	log_sistema( "Dados Processados: " );
	log_sistema( "Qtde Produto     : " . $qtde_produto );
	log_sistema( "Preco Produto    : " . $preco_produto );
	log_sistema( "Dinheiro Compra  : " . $dinheiro_compra );
	log_sistema( "Total Compra     : " . $total_compra );
	log_sistema( "Qtde Itens       : " . $qtde_itens );
	
	// Calcular total do produto atual
	$preco_produto = str_replace( ".", "",  $preco_produto );
	$preco_produto = str_replace( ",", ".", $preco_produto );
	log_sistema( "Preco Produto    : " . $preco_produto );
	
	$subtotal      = $qtde_produto * $preco_produto;
	log_sistema( "Subtotal Produto : " . $subtotal );
	
	$total_produto = number_format( $subtotal, 2, ',', '.' );
	log_sistema( "Total Produto    : " . $total_produto );
	
	// Calculando qtde de itens
	$qtde_itens    = $qtde_itens + 1;
	log_sistema( "Qtde Itens       : " . $qtde_itens );
	
	// Calculando total da compra
	$calc_total_compra = str_replace( ".", "",  $total_compra );
	$calc_total_compra = str_replace( ",", ".", $total_compra );
	
	$subtotal_compra   = $calc_total_compra + $subtotal;
	log_sistema( "Subtotal Compra  : " . $subtotal_compra );
	
	$total_compra      = number_format( $subtotal_compra, 2, ',', '.' );
	log_sistema( "Total Compra     : " . $total_compra );
	
	// Calculando saldo compra
	$dinheiro_compra = str_replace( ".", "",  $dinheiro_compra );
	$dinheiro_compra = str_replace( ",", ".", $dinheiro_compra );
	
	$saldo_compra    = $dinheiro_compra - $subtotal_compra;
	log_sistema( "Saldo Compra     : " . $saldo_compra );
	
	$saldo_novo      = number_format( $saldo_compra, 2, ',', '.' );
	log_sistema( "Saldo Novo       : " . $saldo_novo );
	
	// Gerar o xml response para visualizar pelo js e html
	$calculo_xml  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$calculo_xml .= "<calculos_compra>\n";
	$calculo_xml .= "	<total_produto>" .$total_produto. "</total_produto>\n";
	$calculo_xml .= "	<qtde_itens>"    .$qtde_itens.    "</qtde_itens>\n";
	$calculo_xml .= "	<saldo_novo>"    .$saldo_novo.    "</saldo_novo>\n";
	$calculo_xml .= "	<total_compra>"  .$total_compra.  "</total_compra>\n";
	$calculo_xml .= "</calculos_compra>\n";

	$subtotal         = 0;
	$subtotal_compra  = 0;
	$subtotal_produto = 0;
	$subtotal_saldo   = 0;
	$qtde_produto     = 0;
	$preco_produto    = 0;
	$total_produto    = 0;
	$dinheiro_compra  = 0;
	$total_compra     = 0;
	$qtde_itens       = 0;
	
	echo $calculo_xml;
}

function log_sistema( $dado_gravar ) {
	
	$data_operacao = date('d/m/Y'); // Resultado: 12/12/2015
	$data_log      = str_replace( "/", "", $data_operacao );
	$nome_log      = "log_operacoes_".$data_log.".txt";
	$arquivo_log   = fopen( "../log/" . $nome_log, "a+" );
	
	if( ! fwrite( $arquivo_log, $data_operacao . " -> " . $dado_gravar . "\n" ) ) {
		
		die("<h2>ERROR: Log nao gravado " . $data_operacao . " !</h2>");
		
	}
	
	fclose( $arquivo_log );
	
}

?>
