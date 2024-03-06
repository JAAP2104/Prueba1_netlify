<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('nombre') }}
            {{ Form::text('nombre', $estadosDeLasSolictude->nombre, ['class' => 'form-control' . ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre']) }}
            {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        @if(Route::currentRouteName() === 'estados-de-las-solictudes.edit')
        <div class="form-group">
            <label for="id_estado">Estado</label>
            <select name="id_estado" id="id_estado" class="form-control selectpicker"
            data-style="btn-primary" title="Seleccionar Estado" required>
                @foreach ($estados as $estado)
                <!-- We go through the models of the estado that we previously passed through the controller -->
                <option value="{{ $estado->id }}" {{ ($estadosDeLasSolictude->id_estado ?? '') == $estado->id ? 'selected' : '' }}>
                    {{ $estado->nombre }}
                </option> <!-- We obtain the id and the value -->
                @endforeach
            </select>
        </div>
        @endif

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>