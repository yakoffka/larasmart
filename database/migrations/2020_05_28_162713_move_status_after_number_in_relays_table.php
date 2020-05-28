<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MoveStatusAfterNumberInRelaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('relays', static function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('relays', static function (Blueprint $table) {
            $table->boolean('status')->after('number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('relays', static function (Blueprint $table) {
        });
    }
}
