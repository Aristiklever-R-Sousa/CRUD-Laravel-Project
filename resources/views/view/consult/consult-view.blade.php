@extends('view.layouts.index')
@section('title', 'Vizualização de Consulta')
@section('content')
<div class="jumbotron">
  <h1 class="display-4">Consulta com {{$consult->name}} - {{$consult->speciality}}</h1>
  <p class="lead">{{$consult->timeMarked}}</p>
  <hr class="my-4">
  <p>Queixas: {{$consult->desc}}</p>
  <p class="lead">
    <a class="btn btn-primary btn-lg" href="{{route('consults.get.view')}}" role="button">Ver Consultas</a>
  </p>
</div>
@endsection