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
        Schema::create('purchase_request_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('purchase_request_id')
                  ->constrained()
                  ->cascadeOnDelete();
        
            $table->string('item_name');
        
            $table->text('description')->nullable();
        
            $table->integer('quantity');
        
            $table->string('unit');
        
            $table->decimal('unit_cost', 12, 2);
        
            $table->decimal('total_cost', 12, 2);
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_request_items');
    }
};
