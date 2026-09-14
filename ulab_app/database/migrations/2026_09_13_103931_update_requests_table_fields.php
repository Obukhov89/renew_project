<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->renameColumn('contact_person', 'customer');
            $table->renameColumn('test_basis', 'basis_contest');
            $table->renameColumn('sample_quantity', 'count_probes');

            $table->string('contact_person', 256)->nullable();
            $table->jsonb('custom_fields')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->dropColumn([
                'contact_person',
                'custom_fields',
            ]);

            $table->renameColumn('customer', 'contact_person');
            $table->renameColumn('basis_contest', 'test_basis');
            $table->renameColumn('count_probes', 'sample_quantity');
        });
    }
};
