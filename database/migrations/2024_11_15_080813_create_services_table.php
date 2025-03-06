<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Device;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(Device::class)->constrained()->onDelete('cascade');
            $table->text('description');
            $table->boolean('accepted')->default(false);
            $table->decimal('deposit', 10, 2)->nullable()->default(null);
            $table->boolean('deposit_paid')->default(false);
            $table->decimal('price', 10, 2)->nullable()->default(null);
            $table->boolean('price_paid')->default(false);
            $table->boolean('done')->default(false);
            $table->boolean('returned')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
