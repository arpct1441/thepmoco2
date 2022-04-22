<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timestamp extends Model
{
    use HasFactory;

     public function property()
     {
        return $this->belongsTo(Property::class, 'property_uuid');
     }

       public function user()
       {
       return $this->belongsTo(User::class, 'user_id');
       }
}