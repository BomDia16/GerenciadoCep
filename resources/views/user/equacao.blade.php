<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equação 2 Grau</title>
</head>
<body>
    <form action="{{ route('equacao.envia') }}" method="post">
        @csrf
        <h1>Equação 2 Grau</h1>
        <p>Numero a:</p>
        <input type="number" name="a">
        
        <p>Numero b:</p>
        <input type="number" name="b">

        <p>Numero c:</p>
        <input type="number" name="c">

        <input type="submit" name="action">
    </form>
</body>
</html>