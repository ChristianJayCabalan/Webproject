<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Alisin ang lumang 'address' kung meron
            if (Schema::hasColumn('orders', 'address')) {
                $table->dropColumn('address');
            }

            // Structured fields
            $table->string('province')->default('Bohol')->after('status');
            $table->string('barangay')->after('province');
            $table->string('purok')->after('barangay');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Alisin muna structured fields kung meron
            if (Schema::hasColumn('orders', 'province')) {
                $table->dropColumn('province');
            }
            if (Schema::hasColumn('orders', 'barangay')) {
                $table->dropColumn('barangay');
            }
            if (Schema::hasColumn('orders', 'purok')) {
                $table->dropColumn('purok');
            }

            // Ibalik yung old 'address' column
            if (!Schema::hasColumn('orders', 'address')) {
                $table->text('address')->after('status');
            }
        });
    }
};
