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
        Schema::create('tbl_role_sub_menus', function (Blueprint $table) {
            $table->id('rsm_id');
            $table->unsignedTinyInteger('rsm_active')->default(1);
            $table->unsignedTinyInteger('rsm_create')->default(0);
            $table->unsignedTinyInteger('rsm_update')->default(0);
            $table->unsignedTinyInteger('rsm_destroy')->default(0);
            $table->unsignedTinyInteger('rsm_view')->default(0);
            $table->timestamp('rsm_created_at')->useCurrent();
            $table->timestamp('rsm_updated_at')->useCurrent()->useCurrentOnUpdate();

            // Foreign Key
            $table->unsignedBigInteger('rlmn_id');
            $table->foreign('rlmn_id')->references('rlmn_id')->on('tbl_role_menus')->onDelete('cascade');
            $table->string('sbmn_id', 32);
            $table->foreign('sbmn_id')->references('sbmn_id')->on('tbl_sub_menus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_role_sub_menus');
    }
};
