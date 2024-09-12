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
        Schema::create("linuxes", function (Blueprint $table) {
            $table->id();

            // Custom fields
            $table->string('name');
            $table->integer('parent_id');
            

            // Default columns
            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();
            $table->json('extra')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('linuxes');
    }
};
