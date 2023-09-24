<?php

use App\Models\Facility;
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
        Schema::create('occupancy_records', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Facility::class);
            $table->integer('spaces_public_vacant');
            $table->integer('spaces_public_occupied');
            $table->integer('spaces_subscribers_vacant');
            $table->integer('spaces_subscribers_occupied');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('occupancy_records');
    }
};
