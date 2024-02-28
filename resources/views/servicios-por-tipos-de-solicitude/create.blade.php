@extends('layouts.app')

@section('template_title')
    {{ __('Create') }} Servicios Por Tipos De Solicitude
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Create') }} Servicios Por Tipos De Solicitude</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('servicios-por-tipos-de-solicitudes.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('servicios-por-tipos-de-solicitude.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
