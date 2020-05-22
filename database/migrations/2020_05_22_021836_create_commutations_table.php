<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommutationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('commutations', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('relay_id');
            $table->foreignId('action_id');
            $table->string('comment');
            $table->enum('type', ['manual', 'schedule']);
            $table->timestamp('start_at', 0);
            $table->foreignId('creator_id');
            $table->foreignId('editor_id')->nullable();
            $table->boolean('status');
            $table->timestamps();

            $table->foreign('relay_id')->references('id')->on('relays')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('action_id')->references('id')->on('actions')
                ->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('commutations');
    }
}
