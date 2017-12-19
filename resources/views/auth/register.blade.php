@extends('layouts.start')

@section('content')

<div class="container">
<div class="row m-b-40">
    <div class="col-md-4">
	&nbsp;
    </div>
    <div class="form-container col-md-4">
        <div class="block">
            <div class="row">
		<div class="col-xs-4 noactive-header-label mycontent-left">
		    <a href="{{ url('/login') }}">Войти</a>
		</div>
		<div class="col-xs-8 active-header-label">
		     Регистрация
		</div>
	    </div>
	    <hr />
            <div class="row">
                <div class="col-xs-6 label-ss">
		    Используя: 
		</div>
                <div class="col-xs-6">
                    <a class="btn btn-sm btn-ol-ss m-r-5" href="{{ url('/login/facebook') }}"><i class="fa fa-facebook color-white"></i></a>
                    <a class="btn btn-sm btn-ol-ss m-r-5" href="{{ url('/login/vk') }}"><i class="fa fa-vk color-white"></i> </a>
                    <a class="btn btn-sm btn-ol-ss m-r-5" href="{{ url('/login/gp') }}"><i class="fa fa-google-plus color-white"></i> </a>
		</div>
            </div>
	    <hr />
            <p class="m-b-20 label-email">Или с помощью E-mail:</p>
            <form name="form" novalidate  method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group floating-labels">
                            <label for="email-1">Почта</label>
                            <input id="email-1" autocomplete="off" type="email" name="email">
			    <p class="error-block">
			    </p>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        {{ $errors->first('email') }}
                                    </span>
                                @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group floating-labels">
                            <label for="password-1">Пароль</label>
                            <input id="password-1" autocomplete="off" type="password" name="password">
			    <p class="error-block">
			    </p>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        {{ $errors->first('password') }}
                                    </span>
                                @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group floating-labels">
                            <label for="confirm-password-1">Пароль еще раз</label>
                            <input id="confirm-password-1" autocomplete="off" type="password" name="password_confirmation">
			    <p class="error-block">
			    </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <input type="submit" class="btn btn-xs btn-ol-login" value="Зарегистрироваться">
                    </div>
                    <div class="col-xs-6">
			&nbsp;
		    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection
