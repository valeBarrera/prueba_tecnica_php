<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_has_user', 'user_id', 'group_id');
    }
}
