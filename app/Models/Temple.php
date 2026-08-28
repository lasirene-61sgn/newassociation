<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Temple extends Model
{
    protected $table = 'temples';

    protected $fillable = [
        'admin_id',
        'images',
        'description',
    ];

    protected $casts = [
        'images' => 'array'
    ];

    public function admin(){
        return $this->belongsTo(Admin::class);
    }
}
