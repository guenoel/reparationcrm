<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            //$table->foreignIdFor(\App\Models\User::class);
            $table->string("user_id");
            $table->string("image");
            $table->string("brand");
            $table->string("model_name");
            $table->string("model_number");
            $table->string("serial_number");
            $table->string("imei");
            $table->text("description");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
