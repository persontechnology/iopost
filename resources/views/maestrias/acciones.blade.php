<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
    <a href="{{ route('informacionMaestria',$maestria->id) }}" class="btn btn-dark"  data-toggle="tooltip" data-placement="top" title="Información de {{ $maestria->nombre }}">
        <i class="fas fa-eye"></i>
    </a>
    <a  href="{{ route('editarMaestria', $maestria->id) }}" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editar {{ $maestria->nombre }}">
        <i class="fas fa-edit"></i>
    </a>
    <button type="button" onclick="eliminar(this);" data-url="{{ route('eliminarMaestria', $maestria->id) }}" class="btn btn-danger" data-toggle="tooltip" data-placement="top" data-title="Eliminar {{ $maestria->nombre }}" title="Eliminar {{ $maestria->nombre }}">
        <i class="fas fa-trash-alt"></i>
    </button>    
</div>