
<!DOCTYPE html>
<html>
<head>
    <!-- Standard Meta -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <title>Мебель61</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.7.8/semantic.min.css" />
    <style type="text/css">
        body {
            background-color: #DADADA;
        }
        body > .grid {
            height: 100%;
        }
        .image {
            margin-top: -100px;
        }
        .column {
            max-width: 450px;
        }
    </style>
</head>
<body>
<div class="ui middle aligned center aligned grid">
    <div class="column">
        <h2 class="ui teal image header">

            <div class="content">
                Мебель61 Админ            </div>
        </h2>

            <form class="ui large form" method="POST" action="{{ route('login') }}">
                @csrf

            <div class="ui stacked segment">

                <div class="field">
                    <div class="ui left icon input">
                        <i class="user icon"></i>
                        <input
                            value="{{ old('email') }}" required autofocus
                            id="email" type="email" name="email" placeholder="E-mail">

{{--                        <input--}}
{{--                            value="{{ old('login') }}" required autofocus--}}
{{--                            id="email"   name="login" placeholder="login">--}}

                    </div>
                </div>
                <div class="field">
                    <div class="ui left icon input">
                        <i class="lock icon"></i>
                        <input  placeholder="пароль" id="password" type="password" class="@error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                    </div>
                </div>
                <button type="submit"  class="ui fluid large teal submit button">
                  Войти
                </button>
            </div>

{{--                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>--}}

{{--                <label class="form-check-label" for="remember">--}}
{{--                    {{ __('Remember Me') }}--}}
{{--                </label>--}}

            <div class="ui error message">
                @error('email')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
                @error('password')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>

        </form>

{{--        <object style="width: 60px;" type="image/svg+xml" data="//grinas.ru/design/logo1.svg">--}}

    </div>
</div>



</body>

</html>
