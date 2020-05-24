<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveCreatorAndEditorIdFromCommunicationsToActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('communications', static function (Blueprint $table) {
            $table->dropColumn('creator_id');
            $table->dropColumn('editor_id');
        });
        Schema::table('actions', static function (Blueprint $table) {
            $table->foreignId('creator_id');
            $table->foreignId('editor_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('communications', static function (Blueprint $table) {
            $table->foreignId('creator_id');
            $table->foreignId('editor_id')->nullable();
        });
        Schema::table('actions', static function (Blueprint $table) {
            $table->dropColumn('creator_id');
            $table->dropColumn('editor_id');
        });
    }
}
