<script setup >
import { Head, useForm, usePage } from '@inertiajs/vue3';

import AppLayout from '@/layouts/AppLayout.vue';


const form = useForm({
    name_th: null,
    name_en: null,
    status: '1',
    application_admin: null,

})
const addApplication = () => {
    console.log('add application')
    form.post(route('application.store'), {
            onSuccess: () => {
                alert('บันทึกสำเร็จ!');
                form.reset(); // ล้างข้อมูลในฟอร์ม
            },
        });

    // form.post('/application/store', {
    //     onSuccess: () => {
    //         alert('บันทึกสำเร็จ!');
    //         form.reset(); // ล้างข้อมูลในฟอร์ม
    //     },
    // });
}
</script>
<template>

<!--   {{usePage().props.flash}}-->
    <div class="m-6 p-6 bg-amber-50 space-y-2">
        <div class="w-full text-2xl flex justify-center">
            เพิ่มข้อมูลระบบ
        </div>
        <div class="">
            <label for="username" class="block text-sm/6 font-bold text-gray-900 ">
                ชื่อระบบ(ภาษาไทย)</label>
            <div class="mt-2">
                <div class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600">
                    <input v-model="form.name_th"
                        type="text" name="name_th" placeholder="ชื่อระบบ"
                           class="block min-w-0 grow bg-white py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6" />
                </div>
            </div>
            <label for="">{{form.name_th}}</label>
        </div>
        <div class="">
            <label for="username" class="block text-sm/6 font-bold text-gray-900">
                ชื่อระบบ(ภาษาอังกฤษ)</label>
            <div class="mt-2">
                <div class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600">
                    <input v-model="form.name_en"
                           type="text"
                           name="name_en"
                           placeholder="application name"
                           class="block min-w-0 grow bg-white py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6" />
                </div>
            </div>
        </div>
        <div class="mt-4">
            <fieldset>
                <legend class="text-sm/6 font-semibold text-gray-900">สถานะการใช้งาน</legend>
                <div class="mt-2 space-y-2">
                    <div class="flex items-center gap-x-3">
                        <input
                               type="radio"
                               value="1"
                               v-model="form.status"
                               class="relative size-4 appearance-none rounded-full border border-gray-300 bg-white before:absolute before:inset-1 before:rounded-full before:bg-white not-checked:before:hidden checked:border-indigo-600 checked:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:before:bg-gray-400 forced-colors:appearance-auto forced-colors:before:hidden" />
                        <label for="push-everything" class="block text-sm/6 font-medium text-gray-900">
                            เปิดใช้งาน
                        </label>
                    </div>
                    <div class="flex items-center gap-x-3">
                        <input
                               type="radio"
                               value="2"
                               v-model="form.status"
                               class="relative size-4 appearance-none rounded-full border border-gray-300 bg-white before:absolute before:inset-1 before:rounded-full before:bg-white not-checked:before:hidden checked:border-indigo-600 checked:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:before:bg-gray-400 forced-colors:appearance-auto forced-colors:before:hidden" />
                        <label for="push-email" class="block text-sm/6 font-medium text-gray-900">
                            ปิดใช้งาน
                        </label>
                    </div>
                    <p class="mt-4 text-sm" :class="form.status == 1 ? 'text-green-600' : 'text-red-600'">
                        คุณกำลังเลือก: {{ form.status == 1 ? 'เปิดระบบ' : 'ปิดระบบ' }}
                    </p>
                </div>
            </fieldset>
        </div>
        <div class="">
            <label for="username" class="block text-sm/6 font-bold text-gray-900">
                ผู้ดูแลระบบ</label>
            <div class="mt-2">
                <div class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600">
                    <input v-model="form.application_admin"
                           type="text"
                           name="application_admin"
                           placeholder="คุณทดสอบ,คุณระบบ....."
                           class="block min-w-0 grow bg-white py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6" />
                </div>
            </div>
        </div>
        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="button" class="text-sm/6 font-semibold text-gray-900">Cancel</button>
            <button type="button"
                    @click="addApplication"
                    class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Save
            </button>
        </div>

    </div>

</template>
