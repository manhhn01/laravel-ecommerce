<?php

namespace App\Models;

use App\Traits\StatusScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory, StatusScope;

    protected $hidden = ['product_id', 'user_id'];

    protected $fillable = [
        'comment', 'rating', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'user_review_like', 'user_id', 'review_id');
    }
}
