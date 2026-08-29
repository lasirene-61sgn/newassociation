<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkProcess extends Model
{
    protected $table = 'work_processes';

    protected $fillable = [
        'admin_id',
        'images',
        'videos'
    ];

    protected $casts = [
        'images' => 'array',
        'videos' => 'array',
    ];

    public function admin(){
        return $this->belongsTo(Admin::class);
    }
}
