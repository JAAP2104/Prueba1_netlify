<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('nombre') }}
            {{ Form::text('nombre', $ciudade->nombre, ['class' => 'form-control' . ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre']) }}
            {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        @if(Route::currentRouteName() === 'ciudades.create')
            <div class="form-group">
                <label for="id_departamento">Departamento</label>
                <select name="id_departamento" id="id_departamento" class="form-control selectpicker"
                data-style="btn-primary" title="Seleccionar Departamento" required>
                    @foreach ($departamentos as $departamento)
                    <!-- We go through the models of the Departamentos that we previously passed through the controller -->
                        <option value="{{ $departamento->id }}">{{ $departamento-> nombre }}</option> <!-- We obtain the id and the value -->
                    @endforeach
                </select>
            </div>
        @endif

        @if(Route::currentRouteName() === 'ciudades.edit')
            <div class="form-group">
                <label for="id_departamento">Departamento</label>
                <select name="id_departamento" id="id_departamento" class="form-control selectpicker"
                data-style="btn-primary" title="Seleccionar Departamento" required>
                    @foreach ($departamentos as $departamento)
                        <option value="{{ $departamento->id }}" {{ ($ciudade->id_departamento ?? '') == $departamento->id ? 'selected' : '' }}>
                            {{ $departamento->nombre }}
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