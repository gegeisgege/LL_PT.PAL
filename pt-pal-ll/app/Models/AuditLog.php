<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id', 'action', 'auditable_type', 'auditable_id', 'result'];

    public static function record(string $action, $auditable = null, string $result = 'SUCCESS'): void
    {
        static::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'auditable_type' => $auditable ? get_class($auditable) : null,
            'auditable_id' => $auditable?->id,
            'result' => $result,
            'created_at' => now(),
        ]);
    }
}