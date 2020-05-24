<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveCreatorAndEditorIdFromCommutationsToActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('commutations', static function (Blueprint $table) {
            $table->dropForeign('commutations_creator_id_foreign');
            $table->dropForeign('commutations_editor_id_foreign');

            $table->dropColumn('creator_id');
            $table->dropColumn('editor_id');
        });
        Schema::table('actions', static function (Blueprint $table) {
            $table->foreignId('creator_id');
            $table->foreignId('editor_id')->nullable();

            $table->foreign('creator_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('editor_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('commutations', static function (Blueprint $table) {
            $table->foreignId('creator_id');
            $table->foreignId('editor_id')->nullable();

            $table->foreign('creator_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('editor_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');
        });
        Schema::table('actions', static function (Blueprint $table) {
            $table->dropForeign('actions_creator_id_foreign');
            $table->dropForeign('actions_editor_id_foreign');

            $table->dropColumn('creator_id');
            $table->dropColumn('editor_id');
        });
    }
}
