<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, HasUuids, Notifiable, SoftDeletes, HasRoles;

    protected $fillable = ['tenant_id', 'name', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function isSuperadmin(): bool
    {
        return is_null($this->tenant_id);
    }
}
