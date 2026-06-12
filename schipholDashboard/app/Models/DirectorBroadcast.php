<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DirectorBroadcast extends Model
{
    protected $fillable = ['message', 'sent_by', 'is_active', 'expires_at'];
    
    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];
    
    public function sender()
    {
        return $this->belongsTo(Staff::class, 'sent_by');
    }
    
    public static function getActiveBroadcast()
    {
        return self::where('is_active', true)
            ->where(function($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>', now());
            })
            ->orderBy('created_at', 'desc')
            ->first();
    }
}