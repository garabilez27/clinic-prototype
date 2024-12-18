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
        Schema::create('tbl_patients', function (Blueprint $table) {
            $table->string('ptt_id',32)->primary();
            $table->string('ptt_fname');
            $table->string('ptt_lname');
            $table->string('ptt_phone')->nullable();
            $table->string('ptt_email', length: 191)->unique();
            $table->string('ptt_password');
            $table->string('ptt_image')->nullable();
            $table->unsignedTinyInteger('ptt_active')->default(1);
            $table->unsignedTinyInteger('ptt_deleted')->default(0);
            $table->timestamp('ptt_created_at')->useCurrent();
            $table->timestamp('ptt_updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_patients');
    }
};
