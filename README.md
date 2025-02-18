# Laravel Translatable

A Laravel package for managing translatable models using JSON fields.

## Installation

1. Install the package via Composer:

   ```bash
   composer require ilyasapunkov/laravel-translatable

2. Publish the migration:

   ```bash
   php artisan vendor:publish --tag=translatable-migrations
   
3. Run the migration:
   
    ```bash
    php artisan migrate

## Usage

1. Use the Translatable trait in your model:

    ```php
    namespace App\Models;
    
    use Illuminate\Database\Eloquent\Model;
    use IlyaSapunkov\Translatable\Traits\Translatable;
    
    class Post extends Model
    {
        use Translatable;
    
        protected $translatableFields = ['title', 'description'];
    }
    ```

2. Set translations:

    ```php
   $post = Post::create();
   
   $post->syncTranslation([
      'ru' => [
           'title' => 'Заголовок на русском',
           'description' => 'Описание на русском',
       ]
   ]);
    ```
   
3. Get translations:

    ```php
    echo $post->title; // Заголовок на русском (если текущая локаль 'ru')
    echo $post->description; // Описание на русском
    ```
   
4. Filter by translations:

    ```php
    $posts = Post::hasTranslation('title')->get();
    $posts = Post::hasTranslation('title', 'en')->get();
    ```
   