<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author')->nullable();
            $table->string('isbn')->nullable();
            $table->text('description')->nullable();
            $table->string('cover_url')->nullable();
            $table->string('publisher')->nullable();
            $table->date('published_date')->nullable();
            $table->integer('page_count')->nullable();
            $table->enum('status', ['TBR', 'Reading', 'Read', 'Abandoned', 'Rereading'])->default('TBR');
            $table->integer('progress_percentage')->default(0);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
