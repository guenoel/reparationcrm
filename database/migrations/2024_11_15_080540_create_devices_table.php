<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

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
            $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
            $table->string("image")->default('no-image.jpg');
            $table->string("brand");
            $table->string("model_name");
            $table->string("model_number")->nullable();
            $table->string("color")->nullable();
            $table->string("serial_number")->nullable();
            $table->string("imei")->nullable();
            $table->text("description")->nullable();
            $table->boolean("returned")->default(false);
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
