<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('company_name', 255)->nullable();
            $table->integer('cpf_cnpj')->nullable();
            $table->string('email', 255)->nullable();
            $table->integer('phone')->nullable();
            $table->string('address_public_place')->nullable();
            $table->string('address_number')->nullable();
            $table->string('address_complement')->nullable();
            $table->integer('address_zip_code')->nullable();
            $table->string('address_neighborhood')->nullable();
            $table->string('address_city')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
