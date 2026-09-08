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
        Schema::table('system_fields_forms', function (Blueprint $table) {
            $table->foreign('form_id')
                ->references('id')
                ->on('system_forms')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('system_fields_forms', function (Blueprint $table) {
            $table->dropForeign(['form_id']);
        });
    }
};
