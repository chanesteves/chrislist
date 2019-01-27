<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('modifiable_id');
            $table->string('modifiable_type');
            $table->enum('type', ['create', 'update', 'destroy', 'done', 'undone']);
            $table->integer('performer_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modifications');
    }
}
