@extends('layouts.app')


@section('content')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8" style="width: 40%">
            <div class="card_login">
                <div class="card-body" >
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <H1 class="titulo">Brief</H1>
                        <h3 class="subtitulo">Plataforma de solicitudes</h3>
                        <br>
                        <br>
                        <div class="row mb-3 ">   
                            <div class="col-md-9 ">
                                <input style="margin-left: 65px"  id="email" placeholder="CORREO" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-9">
                                <input style="margin-left: 65px"  id="password" placeholder="CONTRASEÑA" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <br>
                                <div  class="forgot">
                                    <!-- Alinea el enlace a la derecha -->
                                    <a class="btn btn-link" href="{{ route('password.request') }}" style="white-space: nowrap;">
                                        <!-- Evita el salto de línea -->
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                </div>
                        
                      <div class="row mb-0">
                            <div class="col-md-8 offset-md-2">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('ENTRAR') }}
                                </button>

                               
                            </div>
                        </div>
                        <div class="div_logo">
                            <img class="logo" src="../images/RedTecno.png"alt="">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/app.js') }}"></script>
@endsection

