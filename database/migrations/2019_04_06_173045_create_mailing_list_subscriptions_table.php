<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailingListSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugins_mailing_list_subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('mailing_list_id');
            $table->string('email');
            $table->jsonb('attrs')->nullable();
            $table->timestamps();

            $table->foreign('mailing_list_id')
                ->references('id')
                ->on('plugins_mailing_lists')
                ->onDelete('cascade');

            $table->unique(['mailing_list_id', 'email']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plugins_mailing_list_subscriptions');
    }
}
