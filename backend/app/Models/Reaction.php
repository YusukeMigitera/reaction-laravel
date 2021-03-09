<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    use HasFactory;
    protected $fillable = ['material', 'substrate', 'metal', 'ligand', 'hydride', 'base', 'solvent', 'temperature', 'time', 'yield', 'remarks'];
}
