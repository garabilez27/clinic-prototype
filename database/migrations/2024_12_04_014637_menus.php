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
        Schema::create('tbl_menus', function (Blueprint $table) {
            $table->string('mn_id', 32)->primary();
            $table->string('mn_prefix', 10);
            $table->string('mn_detail');
            $table->string('mn_reference', 191)->unique();
            $table->string('mn_icon');
            $table->unsignedInteger('mn_sequence')->nullable();
            $table->unsignedTinyInteger('mn_branched')->default(0);
            $table->unsignedTinyInteger('mn_has_actions')->default(0);
            $table->unsignedTinyInteger('mn_active')->default(1);
            $table->unsignedTinyInteger('mn_deleted')->default(0);
            $table->timestamp('mn_created_at')->useCurrent();
            $table->timestamp('mn_updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_menus');
    }
};
