<script setup>
import { ref, computed, watch } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
//import { Store } from '@/State/StateStore.js'

const props = defineProps({
    pagination: { type: Object, required: true, default: {} },
})

console.log('pagination', props.pagination)

const emit = defineEmits(['start_loading', 'stop_loading'])

const cpage = ref(props.pagination.current_page)

const loadPage = (page) => {
    // router.get(usePage().url, {page: page}, {
    //     preserveState: true,
    //     preserveScroll: true
    // });
    console.log('load page', page)

    router.visit(usePage().url, {
        method: 'get',
        data: {page: page},
        replace: false,
        preserveState: true,
        preserveScroll: true,
     //   onStart: visit => { Store.isLoading = true },
        onProgress: progress => {},
        onSuccess: page => {},
        onError: errors => {},
      //  onFinish: visit => { Store.isLoading = false },
    })
}

const noPreviousPage = computed( () => {
    return props.pagination.current_page - 1 <= 0
})

const noNextPage = computed( () => {
    return props.pagination.current_page + 1 > props.pagination.last_page
})

watch(
    () => props.pagination.current_page,
    (newValue, oldValue) => {
        cpage.value = newValue
    }
)

</script>

<template>
    <div class="flex flex-col md:flex-row justify-center items-center">

        <div class="flex space-x-1 items-top" v-if="pagination.last_page > 1">
            <button
                :disabled="noPreviousPage"
                :class="{'opacity-50': noPreviousPage , 'cursor-not-allowed': noPreviousPage}"
                @click="loadPage(1)"
                class="inline-flex justify-center items-center w-11 h-11 text-gray-700 bg-white rounded-sm border border-gray-200 shadow-xs outline-hidden hover:bg-gray-50 lg:h-9 lg:w-9 lg:text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 lg:h-3 lg:w-3" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
                </svg>
            </button>
            <button
                :disabled="noPreviousPage"
                :class="{'opacity-50': noPreviousPage , 'cursor-not-allowed': noPreviousPage}"
                @click="loadPage(pagination.current_page - 1)"
                class="inline-flex justify-center items-center w-11 h-11 text-gray-700 bg-white rounded-sm border border-gray-200 shadow-xs outline-hidden hover:bg-gray-50 lg:h-9 lg:w-9 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 lg:h-3 lg:w-3" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>

            <div class="flex flex-col items-center space-y-2 md:flex-row md:space-y-0 md:items-center md:space-x-1">
                <div class="px-2 text-white lg:text-sm">หน้า </div>
                <input type="number"
                       @keydown.enter="loadPage(cpage)"
                       @change="loadPage(cpage)"
                       v-model="cpage"
                       min="1" :max="pagination.last_page"
                       class="px-2 w-16 h-11 text-center rounded-sm border border-gray-400 shadow-xs lg:h-9 lg:w-16 lg:text-sm focus:ring-blue-500 focus:border-blue-500"
                />
                <div class="px-2 text-white lg:text-sm">จาก {{ pagination.last_page }}</div>
            </div>

            <button
                :disabled="noNextPage"
                :class="{'opacity-50': noNextPage , 'cursor-not-allowed': noNextPage}"
                @click="loadPage(pagination.current_page + 1)"
                class="inline-flex justify-center items-center w-11 h-11 text-gray-700 bg-white rounded-sm border border-gray-300 shadow-xs outline-hidden hover:bg-gray-50 lg:h-9 lg:w-9 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 lg:h-3 lg:w-3" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>

            <button
                :disabled="noNextPage"
                :class="{'opacity-50': noNextPage , 'cursor-not-allowed': noNextPage}"
                @click="loadPage(pagination.last_page)"
                class="inline-flex justify-center items-center w-11 h-11 text-gray-700 bg-white rounded-sm border border-gray-300 shadow-xs outline-hidden hover:bg-gray-50 lg:h-9 lg:w-9 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 lg:h-3 lg:w-3" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
        <div class="ml-2 lg:text-sm text-white place-self-center ">รวมทั้งหมด {{ pagination.total }} รายการ</div>
    </div>
</template>
