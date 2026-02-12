<script setup>
import { Head, useForm, usePage } from '@inertiajs/vue3';
const form = useForm({
    name_th: null,
    name_en: null,
    status: 1,
    application_admin: null,
   // status_select: 1,

    // application_id: '',
    // application_name_th: '',
});
const props = defineProps({
    applications: Array,
});
const page = usePage();
const user = page.props.auth.user;
const addApplication = () => {
    form.post(route('application.store'), {
        onSuccess: () => {
            form.reset();
            alert('บันทึกข้อมูลเรียบร้อย!');
        },
        onError: () => {
            console.log('พบข้อผิดพลาด');
        }
    });
};
</script>
<template>

<!--    {{ props.applications }}-->
    <div class="bg-amber-900 text-white">สวัสดี : {{ user.name }}</div>
    <div class="m-6 space-y-2 bg-amber-50 p-6">
        <div class="flex w-full justify-center text-2xl">เพิ่มข้อมูลระบบ</div>
        <div class="">
<!--            <div>-->
<!--                <label-->
<!--                    for="country"-->
<!--                    class="block text-sm/6 font-medium font-semibold text-gray-900"-->
<!--                    >ชื่อระบบ</label-->
<!--                >-->
<!--                <div class="mt-2 grid grid-cols-1">-->
<!--                    <select-->
<!--                        v-model="form.application_id"-->
<!--                        autocomplete="country-name"-->
<!--                        class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"-->
<!--                    >-->
<!--                        <option value="1">&#45;&#45;กรุณาเลือก&#45;&#45;</option>-->
<!--                        <option-->
<!--                            v-for="application in props.applications"-->
<!--                            :key="application.id"-->
<!--                            :value="application.id"-->
<!--                        >-->
<!--                            {{ application.name_th }}-->
<!--                        </option>-->
<!--                    </select>-->
<!--                    <svg-->
<!--                        viewBox="0 0 16 16"-->
<!--                        fill="currentColor"-->
<!--                        data-slot="icon"-->
<!--                        aria-hidden="true"-->
<!--                        class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"-->
<!--                    >-->
<!--                        <path-->
<!--                            d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"-->
<!--                            clip-rule="evenodd"-->
<!--                            fill-rule="evenodd"-->
<!--                        />-->
<!--                    </svg>-->
<!--                </div>-->
<!--                {{form.application_id}}-->
<!--            </div>-->
            <label
                for="username"
                class="mt-2 block text-sm/6 font-bold text-gray-900"
            >
                ชื่อระบบ(ภาษาไทย)</label
            >
            <div class="mt-2">
                <div
                    class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600"
                >
                    <input
                        v-model="form.name_th"
                        type="text"
                        name="name_th"
                        placeholder="ชื่อระบบ"
                        class="block min-w-0 grow bg-white py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6"
                    />
                </div>
            </div>
            <label for="">{{ form.name_th }}</label>
        </div>
        <div class="">
            <label
                for="username"
                class="block text-sm/6 font-bold text-gray-900"
            >
                ชื่อระบบ(ภาษาอังกฤษ)</label
            >
            <div class="mt-2">
                <div
                    class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600"
                >
                    <input
                        v-model="form.name_en"
                        type="text"
                        name="name_en"
                        placeholder="application name"
                        class="block min-w-0 grow bg-white py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6"
                    />
                </div>
            </div>
        </div>
        <div class="mt-4">
            <fieldset>
                <legend class="text-sm/6 font-semibold text-gray-900">
                    สถานะการใช้งาน Sample1
                </legend>
                <div class="mt-2 space-y-2">
                    <div class="flex items-center gap-x-3">
                        <input
                            v-model="form.status"
                            type="radio"
                            value="1"
                            class="relative size-4 appearance-none rounded-full border border-gray-300 bg-white before:absolute before:inset-1 before:rounded-full before:bg-white not-checked:before:hidden checked:border-indigo-600 checked:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:before:bg-gray-400 forced-colors:appearance-auto forced-colors:before:hidden"
                        />
                        <label
                            for="push-everything"
                            class="block text-sm/6 font-medium text-gray-900"
                        >
                            เปิดใช้งาน
                        </label>
                    </div>
                    <div class="flex items-center gap-x-3">
                        <input
                            v-model="form.status"
                            type="radio"
                            value="2"
                            class="relative size-4 appearance-none rounded-full border border-gray-300 bg-white before:absolute before:inset-1 before:rounded-full before:bg-white not-checked:before:hidden checked:border-indigo-600 checked:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:before:bg-gray-400 forced-colors:appearance-auto forced-colors:before:hidden"
                        />
                        <label
                            for="push-email"
                            class="block text-sm/6 font-medium text-gray-900"
                        >
                            ปิดใช้งาน
                        </label>
                    </div>
                    <p
                        class="mt-4 text-sm"
                        :class="
                            form.status == 1 ? 'text-green-600' : 'text-red-600'
                        "
                    >
                        คุณกำลังเลือก:
                        {{ form.status == 1 ? 'เปิดระบบ' : 'ปิดระบบ' }}
                    </p>
                </div>
            </fieldset>
        </div>



        <div class="">
            <label
                for="username"
                class="block text-sm/6 font-bold text-gray-900"
            >
                ผู้ดูแลระบบ</label
            >
            <div class="mt-2">
                <div
                    class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600"
                >
                    <input
                        type="text"
                        name="application_admin"
                        placeholder="คุณทดสอบ,คุณระบบ....."
                        class="block min-w-0 grow bg-white py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6"
                    />
                </div>
            </div>
        </div>
        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="button" class="text-sm/6 font-semibold text-gray-900">
                Cancel
            </button>
            <button
                type="button"
                @click="addApplication"
                class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
            >
                Save
            </button>
        </div>
    </div>
</template>
