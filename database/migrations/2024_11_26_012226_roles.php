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
        Schema::create('tbl_roles', function (Blueprint $table) {
            $table->string('rl_id',32)->primary();
            $table->string('rl_detail', 64)->unique();
            $table->unsignedInteger('rl_level')->nullable();
            $table->unsignedTinyInteger('rl_active')->default(1);
            $table->unsignedTinyInteger('rl_deleted')->default(0);
            $table->timestamp('rl_created_at')->useCurrent();
            $table->timestamp('rl_updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_roles');
    }
};
