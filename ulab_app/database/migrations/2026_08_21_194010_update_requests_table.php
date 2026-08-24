<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->dropColumn('request_name');

            $table->text('email')->nullable();
            $table->text('phone')->nullable();
            $table->text('contact_person')->nullable();
            $table->text('test_basis')->nullable();
            $table->text('batch_number')->nullable();
            $table->text('sample_quantity')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->string('request_name')->nullable();

            $table->dropColumn([
                'email',
                'phone',
                'contact_person',
                'test_basis',
                'batch_number',
                'sample_quantity',
            ]);
        });
    }
};
