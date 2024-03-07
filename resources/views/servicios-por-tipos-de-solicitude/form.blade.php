<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('nombre') }}
            {{ Form::text('nombre', $serviciosPorTiposDeSolicitude->nombre, ['class' => 'form-control' . ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre']) }}
            {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        @if(Route::currentRouteName() === 'servicios-por-tipos-de-solicitudes.create')
        <div class="form-group">
            <label for="id_tipo_de_solicitud">Tipo de Solicitud</label>
            <select name="id_tipo_de_solicitud" id="id_tipo_de_solicitud" class="form-control selectpicker"
            data-style="btn-primary" title="Seleccionar Tipo de Solicitud" required>
                @foreach ($solicitudes as $solicitud )
                <!-- We go through the models of the solicitudes that we previously passed through the controller -->
                    <option value="{{ $solicitud->id }}">{{ $solicitud-> nombre }}</option> <!-- We obtain the id and the value -->
                @endforeach
            </select>
        </div>
        @endif

        @if(Route::currentRouteName() === 'servicios-por-tipos-de-solicitudes.edit')
            <div class="form-group">
                <label for="id_tipo_de_solicitud">Tipo de Solicitud</label>
                <select name="id_tipo_de_solicitud" id="id_tipo_de_solicitud" class="form-control selectpicker"
                data-style="btn-primary" title="Seleccionar Tipo de Solicitud" required>
                    @foreach ($solicitudes as $solicitud)
                        <option value="{{ $solicitud->id }}" {{ ($serviciosPorTiposDeSolicitude->id_tipo_de_solicitud ?? '') == $solicitud->id ? 'selected' : '' }}>
                            {{ $solicitud->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif

        @if(Route::currentRouteName() === 'servicios-por-tipos-de-solicitudes.edit')
            <div class="form-group">
                <label for="id_estado">Estado</label>
                <select name="id_estado" id="id_estado" class="form-control selectpicker"
                data-style="btn-primary" title="Seleccionar el Estado" required>
                    @foreach ($estados as $estado)
                        <option value="{{ $estado->id }}" {{ ($serviciosPorTiposDeSolicitude->id_estado ?? '') == $estado->id ? 'selected' : '' }}>
                            {{ $estado->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif




    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>