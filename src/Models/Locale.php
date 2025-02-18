<?php

declare(strict_types=1);

namespace IlyaSapunkov\Translatable\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $name_short
 * @property string $iso
 * @property bool $active
 */
class Locale extends Model
{
    /**
     * Значения по умолчанию для атрибутов модели.
     *
     * @var array
     */
    protected $attributes = [
        'active' => 1,
    ];

    /**
     * Атрибуты, для которых разрешено массовое присвоение значений.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'name_short',
        'iso',
        'active',
    ];
}
