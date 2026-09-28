<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

// Dikelola Superadmin - lihat wireframe 05-superadmin-risk-scoring-config.html
class RiskScoringConfig extends Model
{
    use HasUuids;

    protected $fillable = ['key', 'value', 'description'];
}
