<x-app-layout>
</x-app-layout>
 @extends('layouts.plantillabase')

 @section('css')
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
 <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
 @endsection

 @section('contenido')
 <h1 class="text-white text-center" >Estantes</h1>
 
 <a href="estantes/create" class="btn btn-success mb-3">Agregar nuevos lugares de Almacenaje</a>
 <a class="btn btn-danger mb-3" href="eliminar">Eliminar lugares de Almacenaje</a>

 <div class="table-responsive">
 <table class="table table-dark table-striped mt-4" id="tabla">
    <thead>
        <tr>
            
            <th scope="col">Letra</th>
            <th scope="col">Lugar</th>
            <th scope="col">Ocupado</th>
            
        </tr>
    </thead>
    <tbody>
        @foreach($estantes as $estante)
        <tr>
            <td>{{$estante->letra}}</td>
            <td>{{$estante->lugar}}</td>
            <td>{{$estante->ocupado}}</td>
           
            
            
        </tr>
        @endforeach
    </tbody>
 </table>
</div>
 @endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
    $('#tabla').DataTable({
        responsive: true,
        autoWidth: false
    });
    </script>
 @endsection
