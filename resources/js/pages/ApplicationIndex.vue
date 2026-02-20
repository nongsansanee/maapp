<script setup>


import { Link } from '@inertiajs/vue3';
import { router, useForm, usePage } from '@inertiajs/vue3';
import Paginate from "@/Components/Paginate.vue";
const props = defineProps({
    applications: {type: Object, },
})

const editApplication = (application) =>{
  //  console.log(application)
    router.get(route('application.edit', application), {}, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => { console.log('success')},
        onError: () => {},
        onFinish: () => { },
    })

}

const deleteApplication = (application) =>{
    console.log(application)

    router.delete(route('application.destroy', application), {}, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => { console.log('success')},
        onError: () => {},
        onFinish: () => { },
    })

}

</script>
<template>
    <div class="w-full flex justify-center text-4xl p-4" >
        <label> รายชื่อระบบสารสนเทศของภาควิชาอายุรศาสตร์ </label>
    </div>
    <div class="w-full flex justify-center bg-red-200 my-2">
        <label v-if="usePage().props.flash.msg" :intent="usePage().props.flash.intent" >
            {{ usePage().props.flash.msg }}
        </label>
    </div>
    <div class="mt-6 mx-4 flex items-center ">
        <Link :href="route('application.create')">
            <button
                type="button"
                class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
            >
            New
            </button>
        </Link>
    </div>

    <div class="relative overflow-x-auto sm:rounded-lg  mt-4 min-h-screen">



        <table class="w-full shadow-md text-sm text-left text-gray-500 whitespace-nowrap">
            <thead class="text-md text-gray-700 uppercase bg-gray-50">
            <tr class="bg-white">
                <th scope="col" class="px-3 py-2">
                    #
                </th>
                <th scope="col" class="px-3 py-2">
                        <span class="flex items-center cursor-pointer">
                            ชื่อระบบภาษาไทย
                        </span>
                </th>
                <th scope="col" class="px-3 py-2">
                        <span class="flex items-center cursor-pointer">
                             ชื่อระบบภาษาอังกฤษ
                        </span>
                </th>
                <th scope="col" class="px-3 py-2">
                    <div class="flex items-center">
                        สถานะการใช้งาน
                    </div>
                </th>
                <th scope="col" class="px-3 py-2">
                    <div class="flex items-center">
                        ผู้ดูแลระบบ
                    </div>
                </th>
                <th scope="col" class="px-3 py-2">
                    <div class="flex items-center">
                        ::
                    </div>
                </th>
            </tr>
            <tr
                v-for="app in applications" :key="app.id"
                class="bg-white border-b border-b-gray-200">
                <td  class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap">
                    {{ app.id }}
                </td>
                <td  class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap">
                    {{ app.name_th }}
                </td>
                <td  class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap">
                    {{ app.name_en }}
                </td>
                <td  class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap">

<!--                    <span :class="app.status == 1 ? 'text-green-600' : 'text-red-600'">-->
<!--                     {{ app.status == 1 ? 'เปิดใช้งาน' : 'ปิดใช้งาน' }}-->
<!--                    </span>-->
                    <button
                        v-if="app.status == 1"

                        type="button"
                        class=" bg-green-100 px-2 py-2 text-sm font-semibold text-blue-900 rounded-md  focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    >
                        เปิด
                    </button>
                    <button
                        v-else

                        type="button"

                        class="rounded-md bg-red-100 px-2 py-2 text-sm font-semibold text-blue-900  focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    >
                        ปิด
                    </button>
                </td>
                <td  class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap">
                    {{ app.application_admin }}
                </td>
                <td  class="px-3 py-2 font-medium  whitespace-nowrap">
                    <button
                        @click="editApplication(app)"
                        type="button"
                        class="rounded-md bg-yellow-100 px-3 py-2 text-sm font-semibold text-blue-900 shadow-xs hover:bg-yellow-300 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    >
                    edit
                    </button>
                    <button
                        @click="deleteApplication(app)"
                        type="button"
                        class=" mx-2 rounded-md bg-red-700 text-white px-3 py-2 text-sm font-semibold  shadow-xs hover:bg-red-200 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    >
                        delete
                    </button>
                </td>
            </tr>
            </thead>

        </table>

    </div>
</template>
