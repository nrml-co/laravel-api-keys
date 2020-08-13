<?php

namespace NrmlCo\LaravelApiKeys;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{
    protected $with = ['user'];

    protected $fillable = [
        'user_id', 'type', 'api_key', 'name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
