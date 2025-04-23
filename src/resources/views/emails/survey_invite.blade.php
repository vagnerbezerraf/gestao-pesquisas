<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Convite para Pesquisa</title>
</head>
<body>
    <p>Olá,</p>
    <p>Você foi convidado para participar da pesquisa "{{ $invite->survey->title }}".</p>
    <p>Clique no link abaixo para responder:</p>
    <p><a href="{{ $url }}">Responder pesquisa</a></p>
    <p>Obrigado!</p>
</body>
</html>
