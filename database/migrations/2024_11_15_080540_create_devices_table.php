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
            $table->string("model_number")->nullable()->default(null);
            $table->string("color")->nullable()->default(null);
            $table->string("serial_number")->nullable()->default(null);
            $table->string("imei")->nullable()->default(null);
            $table->text("description")->nullable()->default(null);
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
