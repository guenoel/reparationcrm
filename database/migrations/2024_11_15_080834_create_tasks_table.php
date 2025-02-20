<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Service;
use App\Models\Spare;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('image')->default('no-image.jpg');
            $table->foreignIdFor(Service::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(User::class)->nullable()->constrained()->onDelete('set null');
            $table->timestamp('start')->nullable()->default(null);
            $table->timestamp('end')->nullable()->default(null);
            $table->text("description");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
