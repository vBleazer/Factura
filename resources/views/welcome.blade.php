@extends('layouts.app')

@section('head')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12 my-5">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-0">Clientes registrados</h2>
                        </div>
                        <div>
                            <button onclick="add()" type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modalAdd">
                                Agregar
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">RFC</th>
                            <th scope="col">Razón Social</th>
                            <th scope="col">Dirección</th>
                            <th scope="col">Codigo postal</th>
                            <th scope="col">CFDI</th>
                            <th scope="col">Consumo</th>
                            <th scope="col">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($clientes as $cliente)
                        <tr>
                            <th scope="row">{{ $cliente -> id }}</th>
                            <td>{{ $cliente -> nombre }}</td>
                            <td>{{ $cliente -> rfc }}</td>
                            <td>{{ $cliente -> razonSocial }}</td>
                            <td>{{ $cliente -> direccion }}</td>
                            <td>{{ $cliente -> cp }}</td>
                            <td>{{ $cliente -> cfdi }}</td>
                            <td>{{ $cliente -> consumo }}</td>
                            <td>
                                <button onclick="edit('{{ $cliente -> id }}')" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalAdd">Editar</button>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Button trigger modal -->

  
  <!-- Modal -->
  <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="title_modal">Agregar registro</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ url('/') }}" method="POST" name="formAdd" id="formAdd">
            @csrf
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="form-row justify-content-center">
                        <div class="form-group col-md-12">
                            <label for="inputEmail4">Nombre</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="inputEmail4">RFC</label>
                            <input type="text" class="form-control" name="rfc" id="rfc" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="inputPassword4">Razon Social</label>
                            <input type="text" class="form-control" name="razonSocial" id="razonSocial" required> 
                        </div>
                        <div class="form-group col-md-12">
                            <label for="inputAddress">Dirección</label>
                            <input type="text" class="form-control" name="direccion" id="direccion" placeholder="" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="inputAddress2">Codigo postal</label>
                            <input type="text" class="form-control" name="cp" id="cp" placeholder="" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="inputCity">CDFI</label>
                            <input type="text" class="form-control" name="cfdi" id="cfdi" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="inputState">Consumo</label>
                            <textarea class="form-control" name="consumo" id="consumo" cols="30" rows="4" required></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
    <script>
        function add()
        {
            $("#title_modal").text('Añadir cliente');
            $("#method_put").remove();
            $("#id_target").remove();
            document.getElementById("formAdd").reset(); 
        }
        function edit(id)
        {
            $("#title_modal").text('Editar cliente');
            $("#method_put").remove();
            $("#id_target").remove();
            $("#modal-footer").append('<input name="_method" type="hidden" id="method_put" value="PUT">')
            $("#modal-footer").append('<input name="id" type="hidden" id="id_target" value="">')
            document.getElementById("formAdd").reset(); 

            $.ajax({
                url: '/' + id,
                method: 'get',  
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(data){

                    info = data; 
                    $("#id_target").val(info.id); 

                    $("#nombre").val(info.nombre);
                    $("#rfc").val(info.rfc); 
                    $("#razonSocial").val(info.razonSocial);
                    $("#direccion").val(info.direccion);
                    $("#cp").val(info.cp); 
                    $("#cfdi").val(info.cfdi); 
                    $("#consumo").val(info.consumo); 

            },
                error: function(data){
                    swal("Error","No encontramos lo que buscaba!","error")
                    .then((value) => {
                    $('#modalAdd').modal('toggle');
                    }); 
                }
            });
        }
    </script>
@endsection