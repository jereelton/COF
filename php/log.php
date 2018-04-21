<?php

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
