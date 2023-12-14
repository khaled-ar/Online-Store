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
        Schema::table('stores', function (Blueprint $table) {
            $table->string('fr_name')->after('name');
            $table->string('fr_slug')->after('slug');
            $table->text('fr_description')->after('description');

            $table->string('ar_name')->after('fr_name');
            $table->string('ar_slug')->after('fr_slug');
            $table->text('ar_description')->after('fr_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn([
                'fr_name', 'fr_slug', 'fr_description',
                'ar_name', 'ar_slug', 'ar_description',
            ]);
        });
    }
};
