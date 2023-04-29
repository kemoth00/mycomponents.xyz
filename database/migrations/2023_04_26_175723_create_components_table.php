<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();

            $table->uuid('uuid')->unique();
            $table->string('name');
            $table->text('description');
            $table->string('front_end_type');
            $table->string('style_type');
            $table->string('image');
            $table->text('code');
            $table->bigInteger('upvotes');
            $table->bigInteger('downvotes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('components');
    }
};
