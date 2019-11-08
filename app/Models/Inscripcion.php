<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A:deivid
    // D: una inscripcion tiene un corte
    public function corte()
    {
        return $this->belongsTo(Corte::class);
    }
}