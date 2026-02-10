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
        Schema::create('request_timelines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')->constrained('requests')->onDelete('cascade');
            $table->enum('status_request', ['pending', 'rejected', 'in_progress', 'testing', 'completed', 'approved']);
            $table->string('name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_timelines');
    }
};
/*


**request timeline**
request_timeline_id INT             PRIMARY KEY NOT NULL
request_id          INT             FOREIGN KEY NOT NULL request.request_id
status_request      ENUM('pending', 'rejected', 'in progress', 'testing', 'completed', 'approved')
created_at          TIMESTAMP       NOT NULL
updated_at          TIMESTAMP       NOT NULL
*/