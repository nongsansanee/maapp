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
        Schema::table('users', function (Blueprint $table) {
            $table->text('two_factor_secret')->after('password')->nullable();
            $table->text('two_factor_recovery_codes')->after('two_factor_secret')->nullable();
            $table->timestamp('two_factor_confirmed_at')->after('two_factor_recovery_codes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'two_factor_secret',
                'two_factor_recovery_codes',
                'two_factor_confirmed_at',
            ]);
        });
    }
    
};



/* 
ขอ วัน   
ใคร เมื่อไร
ประเภท  fix new
status current อนุมัติ รอ ไม่อนุุมัติ กำลังพัตนา ทดสอบ เสร็จ **มีวันที่เก็บ วันเสร็จ ใช้เวลากี่วัน ฯลฯ

(user , date)
(typr_request:bug , new feature , improvement)
(status: pending , rejected , in progress , testing , completed? , approved?)

**User**
user_id             INT             PRIMARY KEY NOT NULL
user_name           VARCHAR(255)    NOT NULL
user_email          VARCHAR(255)
user_phone          VARCHAR(20)

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

/*

**User**
user_id             INT             PRIMARY KEY NOT NULL
user_name           VARCHAR(255)    NOT NULL
user_email          VARCHAR(255)
user_phone          VARCHAR(20)

**request**
request_id          INT             PRIMARY KEY NOT NULL
user_id             INT             FOREIGN KEY NOT NULL user.user_id
// title_request       VARCHAR(255)    NOT NULL
// date_request        TIMESTAMP       NOT NULL
// period_request      INT             NOT NULL
// agency_request      VARCHAR(255)    NOT NULL
// num_user_request    INT             NOT NULL
// room_request        VARCHAR(100)    NOT NULL
// status_request      ENUM('draft', 'pending','withdrawn','approved','rejected','canceled', 'abandoned')
created_at          TIMESTAMP       NOT NULL
updated_at          TIMESTAMP       NOT NULL

**request detail**
request_detail_id   INT             PRIMARY KEY NOT NULL
request_id          INT             FOREIGN KEY NOT NULL request.request_id
title_request       VARCHAR(255)    NOT NULL
date_request        TIMESTAMP       NOT NULL
period_request      INT             NOT NULL
agency_request      VARCHAR(255)    NOT NULL
num_user_request    INT             NOT NULL
room_request        VARCHAR(100)    NOT NULL

**request timeline**
request_timeline_id INT             PRIMARY KEY NOT NULL
request_detail_id   INT             FOREIGN KEY NOT NULL request.request_detail_id
status_request      ENUM('pending', 'rejected', 'in progress', 'testing', 'completed', 'approved')
created_at          TIMESTAMP       NOT NULL
updated_at          TIMESTAMP       NOT NULL
*/