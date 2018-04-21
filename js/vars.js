
var contador                = parseInt( document.getElementById( "input_hidden_guarda_contador" ).value ) + 1;
var navegador               = navigator.userAgent.toLowerCase();
var xmlhttp                 = null;

var mensagem                = "";
var tempo                   = 7000;
var control_error;
var control_sucess;

var div_success                = "div_mensagens_sucesso";
var div_error                  = "div_mensagens_erro";
var div_success_content        = "div_content_sucess";
var div_error_content          = "div_content_erro";

var url_processamento          = "php/processador.php";
var url_criar_produto          = "php/criar_produto.php";
var url_alterar_produto        = "php/alterar_produto.php";
var url_remover_produto        = "php/remover_produto.php";
var url_aplicar_dinheiro       = "php/aplicar_dinheiro.php";
var url_salvar_lista           = "php/salvar_lista.php";
var url_criar_nova_lista       = "php/criar_nova_lista.php";
var url_lista_ja_existe        = "php/lista_ja_existe.php";
var url_acessar_lista_salva    = "php/acessar_lista_salva.php";
var url_pesquisar_produto      = "php/pesquisar_produto.php";
var url_carregar_listas_salvas = "php/carregar_listas_salvas.php";
var url_deletar_arquivo        = "php/deletar_arquivo.php";

var url_carregar_recursos_aplicados = "php/carregar_recursos_aplicados.php";
var url_excluir_recurso_confirmado  = "php/excluir_recurso_confirmado.php";
