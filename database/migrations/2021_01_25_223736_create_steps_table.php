<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('steps', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique()->default(DB::raw('uuid_generate_v4()'));
            $table->string('title')->nullable();
            $table->text('body')->nullable();
            $table->decimal('order')->unsigned()->index();
            $table->foreignUuid('snippet_id')->constrained()->onDelete('cascade');
            //            $table->uuid('snippet_id');
            //            $table->foreign('snippet_id')->references('id')->on('snippets')->onDelete('cascade');
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
        Schema::dropIfExists('steps');
    }
}
