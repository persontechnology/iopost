<?php

namespace App\DataTables\Inscripciones;

use App\Models\Inscripcion;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RegistrosAprobarDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('user_id',function($inscripcion){
                return $inscripcion->user->nombres.' '.$inscripcion->user->apellidos;
            })
            ->filterColumn('user_id',function($query, $keyword){
                $query->whereHas('user', function($query) use ($keyword) {
                    $query->whereRaw("concat(nombres,' ',apellidos) like ?", ["%{$keyword}%"]);
                });            
            })
            ->editColumn('updated_at',function($inscripcion){
                return $inscripcion->user->identificacion;
            })
            ->filterColumn('updated_at',function($query, $keyword){
                $query->whereHas('user', function($query) use ($keyword) {
                    $query->whereRaw("identificacion like ?", ["%{$keyword}%"]);
                });            
            })
            ->editColumn('estado',function($inscripcion){
                return $inscripcion->user->email;
            })
            ->filterColumn('estado',function($query, $keyword){
                $query->whereHas('user', function($query) use ($keyword) {
                    $query->whereRaw("email like ?", ["%{$keyword}%"]);
                });            
            })
            
            ->editColumn('maestria',function($inscripcion){
                return $inscripcion->corte->maestria->nombre;
            })
            
            ->filterColumn('corte_id',function($query, $keyword){
                $query->whereHas('corte', function($query) use ($keyword) {
                    $query->whereHas('maestria', function($query) use ($keyword) {
                        $query->whereRaw("nombre like ?", ["%{$keyword}%"]);
                    });
                });
            })
            ->editColumn('comprobante',function($inscripcion){
                return view('inscripciones.registro.comprobante',['inscripcion'=>$inscripcion])->render();
            })
            
            ->addColumn('action', function($inscripcion){
                return view('inscripciones.registro.acciones',['inscripcion'=>$inscripcion])->render();
            })
            ->rawColumns(['action','comprobante']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Inscripciones/RegistrosAprobar $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Inscripcion $model)
    {
        return $model->where('estado','!=','Aprobado');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('inscripciones-registrosaprobar-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('frtip')
                    ->orderBy(1)
                    ->parameters($this->getBuilderParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center')
                  ->title('Acciones'),
            Column::make('comprobante')
                  ->addClass('text-center')
                  ->exportable(false)
                  ->printable(false),
            Column::make('id')
            ->title('# de registro'),
            Column::make('user_id')->title('Aspirante'),
            Column::make('updated_at')->title('Identificación'),
            Column::make('estado')->title('Email'),
            Column::make('numero_factura')->title('# factura'),
            Column::make('created_at')->title('Fecha de registro'),
            Column::computed('maestria')->title('Maestría'),
            Column::make('corte_id')->title('Corte'),
            
            
            
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Inscripciones_RegistrosAprobar_' . date('YmdHis');
    }
}