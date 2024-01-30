<!DOCTYPE html>

<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Title / Icon -->
        <title>Gerenciador CEP LOGIN</title>
        <link rel="icon" href="https://i.pinimg.com/736x/2e/d5/7a/2ed57accf63d08e5ebb1ee853bed1832.jpg">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('assets/frameworks/materialize/css/materialize.css') }}">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="{{ asset('assets/css/estilo.css') }}" rel="stylesheet">
    </head>

    <body class="antialiased">  
        <a href="{{ route('welcome') }}">Voltar</a>
        <div class="grey lighten-2 login container">
            <img class="logo-login" src="https://i.pinimg.com/736x/2e/d5/7a/2ed57accf63d08e5ebb1ee853bed1832.jpg">
            <h3>Login</h3>
            <!-- Form -->
            <div class="row">
                <form method="POST" action="{{ route('user.login') }}" class="col s12">
                    @csrf

                    <!-- email -->
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="email" name="email" type="email" class="validate">
                            <label for="email">Email</label>

                            @error('email')
                                <div class="red-text">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Senha -->
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="senha" name="senha" type="password" class="validate">
                            <label for="senha">Senha</label>

                            @error('senha')
                                <div class="red-text">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s2"></div>
                        <div class="col s7">
                            <button class="btn waves-effect waves-light blue darken-4" type="submit" name="action">Logar</button>
                        </div>
                        <div class="col s2"></div>
                    </div>
                </form>
            </div>
        </div>
        <!-- scripts -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="{{ asset('assets/frameworks/materialize/js/materialize.js') }}"></script>
        <script src="{{ asset('assets/js/teste.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
    </body>
</html>