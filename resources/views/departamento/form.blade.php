<div class="box box-info padding-1">
    .alert.alert-danger {
        color: #642c78;
    }
    .invalid-feedback{
        color:  #642c78;
    }
    <div class="box-body">
        <div class="form-group">
            {{ Form::label('nombre', null, ['style' => 'font-size: 18px; font-weight: bold ; margin-left: 35px;']) }}
            {{ Form::text('nombre', $departamento->nombre, ['class' => 'form-control' . ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre','style' => 'width: 95%; border-radius: 50px; border-style: solid; border-width:4px; border-color: #ececec; background-color:  #ececec;height:45px; margin-bottom: 10px; margin-left: 25px;']) }}
            {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="box-footer mt20" style="text-align: right;margin-right:3%;">
        <button type="submit" class="btnGuardar"
            >
            {{ __('GUARDAR') }}
            <i class="fa-solid fa-circle-plus fa-sm iconDCR" ></i>
        </button>
    </div>

</div>