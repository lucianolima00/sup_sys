<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('supports', function (Blueprint $table) {
            // Change address from string (varchar 255) to text to accommodate JSON address override
            $table->text('address')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('supports', function (Blueprint $table) {
            $table->string('address')->nullable()->change();
        });
    }
};
