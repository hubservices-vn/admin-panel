<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade'); // Link to the Project
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('metadata')->nullable();
            $table->text('header')->nullable();
            $table->text('footer')->nullable();
            $table->longText('html_content');
            $table->longText('css')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
}
