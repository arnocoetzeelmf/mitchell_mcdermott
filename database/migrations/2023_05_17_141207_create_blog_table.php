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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('blog_title', 200)->nullable(false);
            $table->text('blog_text')->nullable(false);
            $table->string('external_source', 400)->nullable(true);
            $table->unsignedBigInteger('external_id')->nullable(true);
            $table->datetime('publication_datetime')->nullable(false)->useCurrent();
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')->onDelete('restrict');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
