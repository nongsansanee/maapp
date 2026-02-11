<?php

namespace Database\Seeders;

use App\Models\Application;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $applications = array(
            ['name_th' => 'ระบบ InfoMED - ระบบบุคลากรเก่า', 'name_en' => 'InfoMED-HR', 'application_admin' => 'คุณศันสนีย์'],
            ['name_th' => 'ระบบ InfoMED - ระบบบุคลากรใหม่-งานบริหาร', 'name_en' => 'InfoMED-HR Management', 'application_admin' => 'คุณศันสนีย์'],
            ['name_th' => 'ระบบ InfoMED - ระบบสารบรรณ', 'name_en' => 'InfoMED-Document Management System', 'application_admin' => 'คุณศันสนีย์'],
            ['name_th' => 'ระบบ InfoMED - ระบบการลา', 'name_en' => 'InfoMED-Leave System', 'application_admin' => 'คุณสัมฤทธิ์'],
            ['name_th' => 'ระบบ InfoMED - ระบบภาระงาน', 'name_en' => 'InfoMED-Workload System', 'application_admin' => 'คุณศันสนีย์'],
            ['name_th' => 'ระบบ InfoMED - ระบบบัญชี', 'name_en' => 'InfoMED-Account System', 'application_admin' => 'คุณศันสนีย์'],
            ['name_th' => 'ระบบส่งใบปรึกษา', 'name_en' => 'Consult-MedSiCon', 'application_admin' => 'คุณศันสนีย์'],
            ['name_th' => 'ระบบส่งใบปรึกษา-ดูใบปรึกษาย้อนหลัง', 'name_en' => 'Consult-WorldSiCon', 'application_admin' => 'คุณศันสนีย์'],
            ['name_th' => 'ระบบดูวิดีโอวิชาการ', 'name_en' => 'MED-VDO', 'application_admin' => 'คุณศันสนีย์'],
            ['name_th' => 'ระบบ ESTER - ระบบส่งรายงานนักศึกษาแพทย์ชั้นปีที่ 4-6', 'name_en' => 'Student Medical Notes', 'application_admin' => 'คุณศันสนีย์,คุณทศพล'],
            ['name_th' => 'ระบบ ESTER - ระบบแลกตารางสอน OPD นักศึกษาแพทย์ ชั้นปีที่ 4-6', 'name_en' => 'OPD Timetables', 'application_admin' => 'คุณทศพล,คุณศันสนีย์'],
            ['name_th' => 'ระบบบันทึกข้อมูลการรักษา (On-Premise)', 'name_en' => 'Medical Notes (On-Premise)', 'application_admin' => 'บุคลากรภายนอกสำนักงานภาควิชาฯ'],
            ['name_th' => 'ระบบบันทึกข้อมูลการรักษา (On-Cloud)', 'name_en' => 'Medical Notes (On-Cloud)', 'application_admin' => 'บุคลากรภายนอกสำนักงานภาควิชาฯ'],
            ['name_th' => 'ระบบการรักษาผู้ป่วยโควิด-19', 'name_en' => 'YUZU', 'application_admin' => 'บุคลากรภายนอกสำนักงานภาควิชาฯ'],
            ['name_th' => 'ระบบเชื่อมโยงข้อมูลต่างๆ', 'name_en' => 'Portal', 'application_admin' => 'บุคลากรภายนอกสำนักงานภาควิชาฯ'],
            ['name_th' => 'ระบบการจัดการข้อมูลวัสดุทางการแพทย์', 'name_en' => 'MED-STOCK', 'application_admin' => 'คุณศันสนีย์'],
            ['name_th' => 'ระบบค้นหาเอกสารเก่า', 'name_en' => 'MED-ODOC', 'application_admin' => 'คุณศันสนีย์'],
            ['name_th' => 'ระบบจองห้องประชุม', 'name_en' => 'Meeting System', 'application_admin' => 'คุณศันสนีย์,คุณทศพล'],
            ['name_th' => 'Website ภาควิชาอายุรศาสตร์', 'name_en' => 'Website SiMedcine System', 'application_admin' => 'คุณทศพล'],
        );

        foreach ($applications as $application) {
            Application::query()->create([
                'name_th' => $application['name_th'],
                'name_en' => $application['name_en'],
                'status' => 1,
                'application_admin' => $application['application_admin']
            ]);
        }
    }
}
