<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Service;
use App\Models\Spare;
use App\Models\SpareType;
use App\Models\Task;

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
            $table->text('description')->nullable()->default(null);
            $table->decimal('buy_price',10,2)->nullable()->default(null);
            $table->decimal('sell_price',10,2)->nullable()->default(null);
        });

        Schema::create('spares', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("image")->default('no-image.jpg');
            $table->foreignIdFor(Service::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Task::class)->nullable()->constrained()->onDelete('set null');
            $table->foreignIdFor(SpareType::class)->nullable()->constrained()->onDelete('set null');
            $table->text('description')->nullable()->default(null);
            $table->timestamp('purchase_date')->nullable()->default(null);
            $table->timestamp('reception_date')->nullable()->default(null);
            $table->timestamp('return_date')->nullable()->default(null);
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
