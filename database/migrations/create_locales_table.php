<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('locales', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 32);
            $table->string('name_short', 16);
            $table->string('iso', 8)->unique();
            $table->tinyInteger('active')->default(1)->index();
            $table->timestamps();
        });

        DB::table('locales')->insert([
            [
                'name' => 'Русский',
                'name_short' => 'Ru',
                'iso' => 'ru',
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'English',
                'name_short' => 'US',
                'iso' => 'en',
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locales');
    }
};
