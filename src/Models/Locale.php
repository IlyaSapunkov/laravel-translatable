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

    protected $table = 'locales';

    /**
     * Значения по умолчанию для атрибутов модели.
     *
     * @var array
     */
    protected $attributes = [
        'active' => 1,
    ];
}
