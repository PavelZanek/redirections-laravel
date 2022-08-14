<?php

namespace PavelZanek\RedirectionsLaravel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use PavelZanek\RedirectionsLaravel\Enums\StatusCode;
use PavelZanek\RedirectionsLaravel\Events\RedirectWasUsedEvent;

class Redirect extends Model
{
    use HasFactory;

    protected $fillable = [
        'source_url',
        'target_url',
        'status_code',
        'last_used',
    ];

    protected $casts = [
        'status_code' => StatusCode::class,
        'last_used' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

        static::created(function($redirect)
        {
            Cache::forget('redirects_cache');
        });

        static::updated(function($redirect)
        {
            if($redirect->isDirty('source_url')){
                Cache::forget('redirects_cache');
            }
            if($redirect->isDirty('last_used')){
                RedirectWasUsedEvent::dispatch($redirect);
            }
        });

        static::deleted(function($redirect)
        {
            Cache::forget('redirects_cache');
        });
    }

    public function redirectData()
    {
        return $this->hasMany(RedirectData::class);
    }
}
