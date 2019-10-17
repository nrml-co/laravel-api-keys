<?php

namespace NrmlCo\LaravelApiKeys;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{
    protected $with = ['user'];

    protected $fillable = [
        'user_id', 'type', 'key'
        ];

    public function user()
    {
        return $this->belongsTo(User::class);

    }

}
