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
        Schema::table('customers', function (Blueprint $table) {
            $table->string('pan_card_no', 10)->nullable();
            $table->string('aadhar_no', 12)->nullable();
            $table->string('mother_name')->nullable();
            $table->string('grand_father_name')->nullable();
            $table->string('grand_mother_name')->nullable(); // Fixed: was duplicate grand_father_name
            $table->string('father_photo_path')->nullable();
            $table->string('mother_photo_path')->nullable();
            $table->string('website')->nullable();
            $table->boolean('is_trust_working_board')->default(false); // Fixed: changed from string to boolean
            $table->json('payment_details')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn([
                'pan_card_no',
                'aadhar_no',          // Fixed: matched up() definition
                'mother_name',
                'grand_father_name',  // Fixed: matched up() definition
                'grand_mother_name',  // Fixed: matched up() definition
                'father_photo_path',
                'mother_photo_path',
                'website',
                'is_trust_working_board',
                'payment_details',
            ]);
        });
    }
};