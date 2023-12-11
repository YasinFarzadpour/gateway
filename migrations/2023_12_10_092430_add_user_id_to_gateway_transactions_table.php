<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    function getTable()
    {
        return config('gateway.table-transactions', 'gateway_transactions');
    }
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table($this->getTable(), function (Blueprint $table) {
            $table->foreignId('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table($this->getTable(), function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
};
