<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_offers', function (Blueprint $table) {
            $table->id();
            $table->string('name_institution');
            $table->string('cpf_client');
            $table->string('name_offer');
            $table->string('code_offer');
            $table->integer('qnt_parcels_min');
            $table->integer('qnt_parcels_max');
            $table->string('value_min');
            $table->string('value_max');
            $table->decimal('value_fees_month', 5, 4);
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
        Schema::dropIfExists('credit_offers');
    }
};
