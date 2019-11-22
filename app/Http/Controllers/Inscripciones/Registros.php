<?php

namespace App\Http\Controllers\Inscripciones;

use App\DataTables\Inscripciones\RegistrosAprobarDataTable;
use App\Http\Controllers\Controller;
use App\Models\Inscripcion;
use App\Notifications\NotificacionRegistroComprobante;
use Illuminate\Http\Request;

class Registros extends Controller
{
    public function __construct()
    {
        $this->middleware(['role_or_permission:Tesorero']);
    }

    public function index(RegistrosAprobarDataTable $dataTable)
    {
        return $dataTable->render('inscripciones.registro.aprobar');
    }

    public function aprobarRegistroFactura(Request $request)
    {
        $request->validate([
            'inscripcion' => 'required|exists:inscripcions,id',
            'factura' => 'required|max:255|string',
        ]);

        try {
            
            $incripcion=Inscripcion::findOrFail($request->inscripcion);
            $incripcion->numero_factura=$request->factura;
            $incripcion->estado='Aprobado';
            $incripcion->save();

            $incripcion->user->notify(new NotificacionRegistroComprobante($incripcion));
            
            return response()->json(['success'=>'Registro aprobado exitosamente con # de factura '.$request->factura.' se ha enviado informaciión a '.$incripcion->user->email]);
        } catch (\Exception $th) {
            return response()->json(['info'=>'Ocurrion un error vuelva intentar']);
        }
    }
}
