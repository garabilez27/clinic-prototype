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
        Schema::create('tbl_sub_menus', function (Blueprint $table) {
            $table->string('sbmn_id', 32)->primary();
            $table->string('sbmn_detail');
            $table->string('sbmn_reference', 191)->unique();
            $table->string('sbmn_icon')->default('fa-circle')->nullable();
            $table->string('sbmn_class')->nullable();
            $table->unsignedInteger('sbmn_sequence')->nullable();
            $table->unsignedTinyInteger('sbmn_active')->default(1);
            $table->unsignedTinyInteger('sbmn_deleted')->default(0);
            $table->timestamp('sbmn_created_at')->useCurrent();
            $table->timestamp('sbmn_updated_at')->useCurrent()->useCurrentOnUpdate();

            // Foreign Key
            $table->string('mn_id', 32);
            $table->foreign('mn_id')->references('mn_id')->on('tbl_menus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_sub_menus');
    }
};
