<?php

namespace PavelZanek\RedirectionsLaravel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RedirectData extends Model
{
    use HasFactory;

    protected $table = 'redirects_data';

    public $timestamps = false;

    protected $fillable = [
        'redirect_id',
        'used_at',
    ];

    protected $casts = [
        'used_at' => 'datetime',
    ];

    public function redirect()
    {
        return $this->belongsTo(Redirect::class);
    }
}
