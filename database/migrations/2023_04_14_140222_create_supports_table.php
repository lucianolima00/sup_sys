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
        Schema::create('supports', function (Blueprint $table) {
            $table->id();
            $table->date('opening_date');
            $table->integer('status');
            $table->unsignedBigInteger('primary_collaborator_id')->nullable();
            $table->unsignedBigInteger('secondary_collaborator_id')->nullable();
            $table->datetime('start_datetime')->nullable();
            $table->unsignedBigInteger('client_id');
            $table->string('address')->nullable();
            $table->unsignedBigInteger('requester_id')->nullable();
            $table->text('description')->nullable();
            $table->text('solution')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supports');
    }
};
