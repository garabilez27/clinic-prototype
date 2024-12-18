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
        Schema::create('tbl_role_menus', function (Blueprint $table) {
            $table->id('rlmn_id');
            $table->unsignedTinyInteger('rlmn_active')->default(1);
            $table->unsignedTinyInteger('rlmn_create')->default(0);
            $table->unsignedTinyInteger('rlmn_update')->default(0);
            $table->unsignedTinyInteger('rlmn_destroy')->default(0);
            $table->unsignedTinyInteger('rlmn_view')->default(0);
            $table->timestamp('rlmn_created_at')->useCurrent();
            $table->timestamp('rlmn_updated_at')->useCurrent()->useCurrentOnUpdate();

            // Foreign Key
            $table->string('mn_id', 32);
            $table->foreign('mn_id')->references('mn_id')->on('tbl_menus')->onDelete('cascade');
            $table->string('rl_id', 32);
            $table->foreign('rl_id')->references('rl_id')->on('tbl_roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_role_menus');
    }
};
