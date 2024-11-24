<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Service;
use App\Models\Spare;
use App\Models\SpareType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('spare_types', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("image")->default('no-image.jpg');
            $table->string('dealer');
            $table->string('type');
            $table->string('brand');
            $table->text('description');
            $table->decimal('buy_price',10,2);
            $table->decimal('sell_price',10,2);
        });

        Schema::create('spares', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("image")->default('no-image.jpg');
            $table->foreignIdFor(Service::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(SpareType::class)->constrained()->onDelete('cascade');
            $table->text('description');
            $table->timestamp('purchase_date')->nullable();
            $table->timestamp('reception_date')->nullable();
            $table->timestamp('return_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spares');
        Schema::dropIfExists('spare_types');
    }
};
