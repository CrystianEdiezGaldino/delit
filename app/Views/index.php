<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Página Inicial</title>
</head>
<body>
    <h1>Bem-vindo, <?= session()->get('nome') ?>!</h1>
    <p>Você está na página inicial.</p>
    <a href="/logout">Sair</a>
</body>
</html>