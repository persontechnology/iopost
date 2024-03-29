<?php

namespace App;

use App\Models\Corte;
use App\Models\Domicilio\Parroquia;
use App\Models\Maestria;
use App\Models\Pago;
use App\Models\Usuario\InformacionLaboral;
use App\Models\Usuario\RegistroAcademico;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','estado',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    // A:Deivid
    // D: un usuario pertenece a una parroquia
    public function parroquia()
    {
        return $this->belongsTo(Parroquia::class);
    }



    // A:Deivid
    // D: un usuario estudiante tiene un informacion laboral
    public function informacionLaboral()
    {
        return $this->hasOne(InformacionLaboral::class);
    }

    // A:Deivid
    // D: un usuario estudiante tiene un registro académmico
    public function registrosAcademicos()
    {
        return $this->hasMany(RegistroAcademico::class);
    }

    // A:deivid
    // D:un estudiante puede tener varias incripciones
    public function inscripciones()
    {
        return $this->belongsToMany(Corte::class, 'inscripcions', 'user_id', 'corte_id')
        ->as('inscripcion')
        ->withPivot('id','estado')
        ->withTimestamps();
    }


    // A:deivid
    // D:un coordinador de maestria tienes varias cortes de maestria asignados
    public function cortes()
    {
        return $this->belongsToMany(Corte::class, 'coordinador_cortes', 'user_id', 'corte_id');
    }


    // A:deivid
    // D: un usuario tiene pagos
    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

}
