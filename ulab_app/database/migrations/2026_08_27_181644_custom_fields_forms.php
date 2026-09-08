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
        Schema::create('custom_fields_forms', function (Blueprint $table) {
            $table->id();
            $table->integer('module_id');
            $table->integer('form_id');
            $table->string('type_field');
            $table->string('title_field');
            $table->string('name_field');
            $table->string('size_field');
            $table->string('precission_field');
            $table->boolean('is_required');
            $table->boolean('is_visible');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_fields_forms');
    }
};
