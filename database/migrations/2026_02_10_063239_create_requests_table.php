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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('date_request');
            $table->integer('application_id');
            $table->enum('type_request', ['bug', 'new_feature', 'improvement']);
            $table->string('requester');
            $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};


/*

**request**
request_id          INT             PRIMARY KEY NOT NULL
user_id             INT             FOREIGN KEY NOT NULL user.user_id
date_request        TIMESTAMP       NOT NULL
type_request        ENUM('bug', 'new feature', 'improvement')
// status_request      ENUM('pending', 'rejected', 'in progress', 'testing', 'completed', 'approved')
// date_completed      TIMESTAMP
// date_updated        TIMESTAMP 
// date_spent_time     INT 
created_at         TIMESTAMP       NOT NULL
updated_at         TIMESTAMP       NOT NULL


**request timeline**
request_timeline_id INT             PRIMARY KEY NOT NULL
request_id          INT             FOREIGN KEY NOT NULL request.request_id
status_request      ENUM('pending', 'rejected', 'in progress', 'testing', 'completed', 'approved')
created_at          TIMESTAMP       NOT NULL
updated_at          TIMESTAMP       NOT NULL
*/