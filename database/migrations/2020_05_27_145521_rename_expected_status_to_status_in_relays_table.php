<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameExpectedStatusToStatusInRelaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('relays', static function (Blueprint $table) {
            $table->renameColumn('expected_status', 'status');
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
            $table->renameColumn('status', 'expected_status');
        });
    }
}
