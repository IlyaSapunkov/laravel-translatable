<?php

declare(strict_types=1);

namespace IlyaSapunkov\Translatable\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property array $translations
 */
class Translation extends Model
{
    protected $table = 'translations';

    protected $fillable = [
        'translatable_type',
        'translatable_id',
        'translations',
        'locale',
    ];

    protected $casts = [
        'translations' => 'json',
    ];
}
