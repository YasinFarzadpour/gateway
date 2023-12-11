<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    function getTable()
    {
        return config('gateway.table-gateway-users', 'gateway_users');
    }
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->getTable(), function (Blueprint $table) {
            $table->engine = "innoDB";
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('gateway_id');
            $table->json('gateway_details');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->getTable());
    }
};
