@extends('layouts.template')
@section('css')
<link href="{{ URL::asset('assets/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
@endsection
@section('js')
<script src="{{ URL::asset('assets/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.min.js') }}"> </script>
<script src="{{ URL::asset('assets/bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.pt-BR.js') }}"> </script>
@endsection
@section('title', 'Edição de Consulta')
@section('content')
<div class="container mt-5">
    <form method="POST" action="{{ route('consult.put.update', $consult->id) }}">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Médico</label>
                    <select class="form-control" id="exampleFormControlSelect1" name="idDoctor">
                        <option value="{{$consult->doctor}}" selected>{{$consult->name}}</option>
                        @foreach($doctors as $doctor)
                            <option value="{{$doctor->id}}">{{$doctor->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label for="exampleInputDateTime">Data e Hora</label>
                    <div class="input-group date" data-date="{{$consult->timeMarked}}" data-date-format="dd-mm-yyyy HH:ii">
                        <input type="text" id="datetimepicker" class="form-control datetimepicker"
                            size="16" value="{{$consult->timeMarked}}" name="dateTime" placeholder="Data e Hora para a consulta" readonly
                        >
                        <span class="input-group-text" id="basic-addon2">
                            <i class="fas fa-calendar-day"></i>
                        </span>
                        <span class="input-group-text" id="basic-addon2">
                            <i class="fas fa-times"></i>
                        </span>
                    </div>
                    
                    <script type="text/javascript">
                        $(".datetimepicker").datetimepicker({
                            format: "dd/mm/yyyy hh:ii",
                            weekstart: 0,
                            autoclose: 1,
                            language: "pt-BR",
                            startDate: '+0d'
                        });
                    </script>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Queixa:</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="desc">{{$consult->desc}}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Salvar Mudanças</button>
    </form>
</div>
@endsection