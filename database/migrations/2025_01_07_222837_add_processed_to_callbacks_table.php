<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('callbacks', function (Blueprint $table) {
            $table->boolean('processed')->default(false); // Добавляем поле processed
        });
    }

    public function down()
    {
        Schema::table('callbacks', function (Blueprint $table) {
            $table->dropColumn('processed'); // Удаляем поле processed
        });
    }
};
