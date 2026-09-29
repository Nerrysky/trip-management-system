<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'model_type',
        'model_id',
        'action',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function log($action, $description = null, $model = null)
    {
        return self::create([
            'user_id' => auth()->id(),
            'model_type' => $model ? get_class($model) : null,
            'model_id' => $model?->id,
            'action' => $action,
            'description' => $description,
        ]);
    }
}