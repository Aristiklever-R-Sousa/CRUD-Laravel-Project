@extends('layouts.template')
@section('title', 'Consultas')
@section('css-datetime')
<link href="{{ URL::asset('assets/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('js-datetime')
<!-- Scripts DataTables -->
<script type="text/javascript" src="{{ URL::asset('assets/datatables/jquery.dataTables.min.js')}}"> </script>
<script type="text/javascript" src="{{ URL::asset('assets/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/datatables/datatables-demo.js') }}"></script>
@endsection
@section('content')
<?php
    @session_start();
    if(@$_SESSION['id_user'] == NULL) {
        echo "<script>window.location='./'</script>";
    }

    if(!isset($id)) {
        $id = "";
    }
?>
<div class="container">
    <a href="{{route('consult.get.insert')}}" type="button" class="mt-4 mb-4 btn btn-primary">Marcar Consulta</a>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                        <th>Médico</th>
                        <th>Queixa</th>
                        <th>Data e Hora</th>
                        <th>Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($consults as $consult)
                        <tr>
                            <td>{{$consult->name}}</td>
                            <td>{{$consult->desc}}</td>
                            <td>{{$consult->timeMarked}}</td>
                            <td>
                                <a class="ml-1" title="Detalhes da Consulta" href="{{route('consult.get.show', $consult->id)}}"><i class="fas fa-eye text-primary"></i></a>
                                <a class="ml-1" title="Editar Consulta" href="{{route('consult.get.update', $consult->id)}}"><i class="fas fa-edit text-info"></i></a>
                                <a href="{{route('consult.get.remove', $consult->id)}}"  class="ml-1" title="Excluir Consulta"><i class="fas fa-trash text-danger"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#dataTable').dataTable( {
        "ordering": false
    } );
</script>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Deletar Consulta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Deseja realmente excluir essa consulta?
      </div>
      <div class="modal-footer">
        <button onclick="redirect()" type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</a>
        <form method="POST" action="{{route('consult.delete.remove', @$id)}}">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger">Excluir</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
    var redirect = () => {
        window.location = "{{route('consults.get.index')}}";
    }
</script>

<?php
    if(@$id != "") {
        echo "<script type='text/javascript'> $('#exampleModal').modal('show')</script>";
    }
?>

@endsection