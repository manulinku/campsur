@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Loguearse</div>

                <div class="panel-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('CODIGO') ? ' has-error' : '' }}">
                            <label for="CODIGO" class="col-md-4 control-label">Código de Cliente</label>

                            <div class="col-md-6">
                                <input id="CODIGO" type="text" class="form-control" name="CODIGO" value="{{ old('CODIGO') }}" required>

                                @if ($errors->has('CODIGO'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('CODIGO') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('PASSWORD') ? ' has-error' : '' }}">
                            <label for="PASSWORD" class="col-md-4 control-label">Contraseña</label>

                            <div class="col-md-6">
                                <input id="PASSWORD" type="password" class="form-control" name="PASSWORD" required>

                                @if ($errors->has('PASSWORD'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('PASSWORD') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Recordarme
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>

                                {{-- Lo dejamos comentado porque si pierden la contraseña se la reseteamos nosotros manualmente --}}
                                {{-- <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a> --}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
