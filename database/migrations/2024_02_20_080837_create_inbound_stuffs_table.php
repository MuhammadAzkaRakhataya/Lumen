<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    //ngubah skema database
    public function up(): void
    {
        Schema::create('inbound_stuffs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("stuff_id");  //bernilai besar
            $table->integer("total");
            $table->date("date");
            $table->string("proff_file"); 
            $table->timestamps(); //update create
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    //ngembaliin tindakan   
    public function down(): void
    {
        Schema::dropIfExists('inbound_stuffs');
    }
};


//buat ngehapus