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
		<div class="col-xs-12 active-header-label">
		    Восстановление пароля
		</div>
	    </div>
	    <hr />
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <p class="m-b-20 label-email">Введите E-mail, указанный при регистрации</p>
            <form name="form" novalidate  method="POST" action="{{ route('password.email') }}">
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
                    <div class="col-xs-5">
                        <input type="submit" class="btn btn-xs btn-ol-login" value="Восстановить">
                    </div>
                    <div class="col-xs-4">
                        <a class="btn btn-xs btn-ol-cancel" href="/">Отмена</a>
		    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection
