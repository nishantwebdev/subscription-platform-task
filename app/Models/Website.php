<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use HasFactory;

    public function usersSubscribed()
    {
        return $this->belongsToMany(User::class, 'subscriptions', 'website_id', 'user_id');
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
