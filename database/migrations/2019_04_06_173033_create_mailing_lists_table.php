<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailingListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugins_mailing_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('website_id');
            $table->unsignedBigInteger('creator_id');
            $table->string('name');
            $table->text('subscribed_success_template')->nullable();
            $table->text('already_subscribed_template')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('website_id')
                ->references('id')
                ->on('websites')
                ->onDelete('cascade');

            $table->foreign('creator_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plugins_mailing_lists');
    }
}
