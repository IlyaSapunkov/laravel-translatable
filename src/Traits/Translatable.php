<?php

declare(strict_types=1);

namespace IlyaSapunkov\Translatable\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Arr;
use IlyaSapunkov\Translatable\Models\Locale;
use IlyaSapunkov\Translatable\Models\Translation;

trait Translatable
{
    /**
     * Магический метод для получения атрибутов.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        if (in_array($key, $this->getTranslatableFields())) {
            return $this->getTranslation($key);
        }

        return parent::__get($key);
    }

    /**
     * Магический метод для установки атрибутов.
     *
     * @param string $key
     * @param mixed $value
     */
    public function __set($key, $value): void
    {
        if (in_array($key, $this->getTranslatableFields())) {
            $this->setTranslation($key, $value);

            return;
        }

        parent::__set($key, $value);
    }

    /**
     * Устанавливает переводимые поля.
     *
     * @param array $fields
     */
    public function setTranslatableFields(array $fields): void
    {
        $this->translatableFields = $fields;
    }

    /**
     * Получает перевод для указанного поля в текущей локали.
     *
     * @param string $field
     *
     * @return mixed
     */
    public function getTranslation(string $field): mixed
    {
        /** @var Translation $translation */
        $translation = $this->translation()->firstOrCreate(['locale' => app()->getLocale()]);

        return Arr::get($translation->translations ?? [], $field);
    }

    /**
     * Устанавливает перевод для указанного поля в текущей локали.
     *
     * @param string $field
     * @param mixed $value
     */
    public function setTranslation(string $field, mixed $value): void
    {
        /** @var Translation $translation */
        $translation = $this->translation()->firstOrCreate(['locale' => app()->getLocale()]);

        $translations = $translation->translations ?? [];
        $translations = Arr::set($translations, $field, $value);
        $translation->translations = $translations;
        $translation->save();
    }

    /**
     * Scope для выборки записей с переводом для указанного поля и локали.
     *
     * @param Builder $query
     * @param string $field
     * @param string|null $locale
     *
     * @return Builder
     */
    public function scopeHasTranslation(Builder $query, string $field, string $locale = null): Builder
    {
        $locale = $locale ?? app()->getLocale();

        return $query->whereHas('translation', function ($q) use ($field, $locale): void {
            $q->where('locale', $locale)
                ->where("translations->$field", '<>', '')
                ->whereNotNull("translations->$field");
        });
    }

    /**
     * Связь с таблицей `translations`.
     *
     * @return MorphMany
     */
    public function translation(): MorphMany
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    /**
     * Синхронизирует переводы.
     *
     * @param array $translations
     */
    public function syncTranslation(array $translations): void
    {
        foreach (Locale::all() as $locale) {
            $translation = $this->translation()->firstOrNew(['locale' => $locale->iso]);
            $translation->fill($translations[$locale->iso])->save();
        }
    }

    /**
     * Возвращает переводимые поля.
     *
     * @return array
     */
    protected function getTranslatableFields(): array
    {
        return $this->translatableFields;
    }
}
