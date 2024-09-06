<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NumeroControles extends Model
{
    use HasFactory;
    protected $table = 'numero_controles';

    protected $primaryKey = 'cod_controles';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = ['num_control'];
}
