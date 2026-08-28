<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Labh extends Model
{
    protected $table = 'labhs';

    protected $fillable = [
        'admin_id',
        'heading',
        'description',
    ];

    public function admin(){
        return $this->belongsTo(Admin::class);
    }
}
