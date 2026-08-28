<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkProcess extends Model
{
    protected $table = 'work_processes';

    protected $fillable = [
        'admin_id',
        'media'
    ];

    protected $casts = [
        'media' => 'array',
    ];

    public function admin(){
        return $this->belongsTo(Admin::class);
    }
}
