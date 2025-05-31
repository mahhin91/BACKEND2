<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('post_reactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->enum('reaction_type', ['like', 'dislike']);
            $table->timestamps();
            
            // Đảm bảo mỗi user chỉ có thể like/dislike một bài viết một lần
            $table->unique(['user_id', 'post_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('post_reactions');
    }
}; 