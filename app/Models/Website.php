<?php

namespace App\Models;

use App\Traits\TransformsViaFractal;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use TransformsViaFractal;

    protected $fillable = ['name', 'url'];
}
