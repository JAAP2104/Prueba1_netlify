@extends('layouts.app')

@section('template_title')
    {{ $tiposDeSolicitude->name ?? " __('Show') Tipos De Solicitude" }}
@endsection

@section('content')
    <section class="container shadow p-4 my-5 bg-light rounded">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="">
                        <div class="">
                            <div class="float-left">
                                <div class="d-flex mt-3 mb-4">
                                    <div>
                                        <h1 class="primeraPalabraFlex" style="font-size: 200%">{{ __('DETALLE DEL') }}</h1>
                                    </div>
                                    <div>
                                        <h1 class="segundaPalabraFlex" style="font-size: 200%">{{ __('TIPO DE SOLICITUD') }}
                                        </h1>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="card-body">
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
                                            <td>{{ $tiposDeSolicitude->nombre }}</td>
                                            <td>{{ $tiposDeSolicitude->estado->nombre }}</td>
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
            </div>
            <a href="{{ route('tipos-de-solicitudes.index') }}" class="btn btn-outline"
                    style="color:#00324D; border:2px solid #82DEF0; height: 40px; width:130px; cursor: pointer; border-radius: 35px; margin-top:18px; justify-content: center; justify-items: center; margin-left: 90%;"
                    onmouseover="this.style.backgroundColor='#b2ebf2';" onmouseout="this.style.backgroundColor='#FFFF';">
                    {{ __('REGRESAR') }}
                    <i class="fa-solid fa-circle-play fa-flip-both" style="color: #642c78;"></i>
                </a>
        </div>
    </section>
@endsection
