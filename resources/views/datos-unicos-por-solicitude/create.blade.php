@extends('layouts.app')

@section('template_title')
    {{ __('Create') }} Datos Unicos Por Solicitude
@endsection

@section('content')

    <section class="container shadow p-4  my-5 bg-light rounded">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="">
                    <div class="">
                        <div class="d-flex mt-3 mb-4">
                            <div>
                                <h1 class="primeraPalabraFlex" style="font-size: 200%">{{ __('CREAR') }}</h1>
                            </div>
                            <div>
                                <h1 class="segundaPalabraFlex" style="font-size: 200%">{{ __('DATO ÚNICO POR TIPO DE SOLICITUD') }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('datos-unicos-por-solicitudes.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('datos-unicos-por-solicitude.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
