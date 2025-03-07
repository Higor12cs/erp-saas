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
        Schema::create('groups', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->foreignUuid('tenant_id')->index()->nullable()->constrained();
            $table->foreignUuid('section_id')->constrained();
            $table->unsignedBigInteger('sequential_id')->index();
            $table->string('name');
            $table->foreignUuid('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
