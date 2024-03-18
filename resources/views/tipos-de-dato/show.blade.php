@extends('layouts.app')

@section('template_title')
    {{ $tiposDeDato->name ?? "__('Show') Tipos De Dato" }}
@endsection

@section('content')

    <section class="container shadow p-4 my-5 bg-light rounded">
        <div class="container">
            <div class="col-sm-12">
                <div class="">
                    <div class="card-header">
                        <div class="float-left">
                            <div class="d-flex mt-3 mb-2">
                                <div>
                                    <h1 class="primeraPalabraFlex" style="font-size: 200%" >{{ __('DETALLE DEL') }}</h1>
                                </div>
                                <div>
                                    <h1 class="segundaPalabraFlex" style="font-size: 200%">{{ __('TIPO DE DATO') }}</h1>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row mb-3">
                        </div>
                        <div class="table-responsive"
                            style="background-color: #DEE2E6; border-radius: 18px; border-style: solid; border-width:2px; border-color: #DEE2E6">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr style="border-width: 2px">
                                        <th>Nombre</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody class="alldata">
                                    <tr>
                                        <td>{{ $tiposDeDato->nombre }}</td>
                                        <td>{{ $tiposDeDato->estado->nombre }}</td>
                                    </tr>
                                </tbody>
                                <!-- Another tbody is created for the search records -->
                                <tbody id="Content" class="dataSearched">

                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
            </div>
           <div class="mt-2 d-flex justify-content-end">
            <a href="{{ route('tipos-de-datos.index') }}" class="btnRegresar">
                {{ __('REGRESAR') }}
                <i class="fa-solid fa-circle-play fa-flip-both iconDCR" ></i>
                </a>
           </div>
        </div>
    </section>
@endsection
