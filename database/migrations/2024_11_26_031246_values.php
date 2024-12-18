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
        Schema::create('tbl_values', function (Blueprint $table) {
            $table->id('val_id');
            $table->string('val_prefix', 8)->unique();
            $table->integer('val_value')->default(0);
            $table->string('val_for');
            $table->timestamp('val_created_at')->useCurrent();
            $table->timestamp('val_updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_values');
    }
};
