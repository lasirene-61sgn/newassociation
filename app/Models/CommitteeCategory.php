<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommitteeCategory extends Model
{
    protected $fillable = ['admin_id', 'name', 'status'];

    public function committeePeople()
    {
        return $this->hasMany(CommitteePerson::class, 'committee_category_id');
    }
}
