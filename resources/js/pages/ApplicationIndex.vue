<script setup>


import { Link } from '@inertiajs/vue3';
import { router, useForm, usePage } from '@inertiajs/vue3';
import Paginate from "@/Components/Paginate.vue";
const props = defineProps({
    applications: {type: Object, },
})

const form = useForm({
    status: '',
    is_search: false,
});
const searchApplication = () => {
    form.transform((data) => ({
        ...data,
        is_search: true,
    }))
        .get(route('application.index'),{
            preserveState: true,
            preserveScroll: true,

        })
}
const editApplication = (hashed_key) =>{
  //  console.log(application)
    router.get(route('application.edit', hashed_key), {}, {
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

        <div class="w-full flex justify-center items-center">
            <label for="country" class="px-2 text-sm font-medium text-gray-900 whitespace-nowrap">
                สถานะการใช้งาน</label>
            <div class=" grid grid-cols-1">
                <select
                         v-model="form.status"
                         class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    <option value="">ระบุเพื่อค้นหา</option>
                    <option value="1">เปิด</option>
                    <option value="0">ปิด</option>
                </select>
                <svg viewBox="0 0 16 16" fill="currentColor" data-slot="icon" aria-hidden="true" class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4">
                    <path d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" fill-rule="evenodd" />
                </svg>
            </div>


                <button
                    :disabled="form.processing"
                    @click="searchApplication"
                    type="button"
                    class=" mx-2 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                >
                    <span>{{ form.processing ? 'กำลังค้นหา...' : 'ค้นหา' }}</span>
                </button>

        </div>
    <div class=" m-2 w-full flex justify-center text-red-600">

        <label v-if="usePage().props.errors"  >
            {{ usePage().props.errors.status }}
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

        <div v-if="props.applications.links.length > 3" class="mt-6 flex flex-wrap justify-center">
            <template v-for="(link, key) in props.applications.links" :key="key">

                <div v-if="link.url === null"
                     class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                     v-html="link.label" />

                <Link v-else
                      class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500 transition-colors"
                      :class="{ 'bg-blue-600 text-white font-bold': link.active, 'bg-white': !link.active }"
                      :href="link.url" v-html="link.label"
                />

            </template>
        </div>

        <Paginate
            class="relative w-full min-w-min justify-center bg-blue-700 p-2 rounded-sm mt-6"
            :pagination="props.applications"
        />
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
                v-for="app in applications.data" :key="app.id"
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
                        @click="editApplication(app.hashed_key)"
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
