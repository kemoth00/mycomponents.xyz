<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Component extends Model
{
    use HasUuid;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
