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
        Schema::create('lxc_requests', function (Blueprint $table) {
            $table->id();
            $table->enum('machine_power', ['bronze', 'silver', 'gold']);
            $table->text('details')->nullable();
            $table->integer('user_id')->constrained('users');
            $table->enum('status', ['pending', 'approved', 'denied', 'created'])->default('pending');
            $table->text('denial_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lxc_requests');
    }
};
