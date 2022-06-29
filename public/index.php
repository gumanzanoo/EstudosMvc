<?php

require __DIR__ . '/../vendor/autoload.php';

use Alura\Cursos\Controller\InterfaceControladorRequisicao;

$caminho = $_SERVER['PATH_INFO'];
$rotas = require __DIR__ . '/../config/routes.php';

if (!array_key_exists($caminho, $rotas)) {
    http_response_code(404);
    exit();
}

session_start();

/*str_contains busca uma string dentro da outra que você fornece a ela por parâmetro.
Aramazeno em $RotaDeLogin o retorno da função stripos, se o caminho tiver 'login' ele retorna true se não 
retorna false. Abaixo, chamo a função e peço se na string armazenada em $caminho existe a string 'login'. */

$RotaDeLogin = str_contains($caminho, 'login');

/*abaixo verifico, se não há sessão e o caminho não contém a palavra 'login', redireciono o usuário devolta para /login
se há sessão, o usuário é redirecionado para /listar-cursos (comportamento processaRequisicao do objeto do tipo RealizarLogin
que processa e retorna o cabeçalho http /listar-cursos se o login estiver correto). */

if (!isset($_SESSION['logado']) && $RotaDeLogin === false) {
    header('Location: /login');
    exit();
}

$classeControladora = $rotas[$caminho];
/** @var InterfaceControladorRequisicao $controlador */
$controlador = new $classeControladora();
$controlador->processaRequisicao();
