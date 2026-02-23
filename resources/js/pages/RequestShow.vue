<script setup>
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const request = page.props.request;
const request_timeline = page.props.request_timeline;

console.log('request in show page:', request, request_timeline);
// const type_request = page.props.type_request;
// const status_request = page.props.status_request;
// const props = defineProps({
//     applications: Array
// });


</script>
<template>
    <div class=" bg-gray-900 w-full min-h-screen h-full flex flex-col">
        <nav class=" w-full flex justify-between items-center bg-gray-700 p-6 h-24">
            <h1 class=" text-white text-2xl font-bold">Welcome to MA Application Edit Request Page</h1>
            <div>
                <a href="/" class=" text-white mr-4">Home</a>
                <a href="/request" class=" text-white mr-4">Index</a>
                <a href="/logout" class=" text-white">Logout</a>
            </div>
        </nav>
        <div class="w-full flex flex-col justify-center items-center p-12 font-noto gap-6">
            <div
                class=" w-3/4 h-auto bg-white rounded-2xl flex flex-col items-center opacity-100 transition-opacity duration-750 starting:opacity-0 2xl:w-1/2 pb-6">
                <h2 class=" text-black text-3xl font-bold mt-10 text-center">MA Application Detail Request</h2>
            </div>
            <div
                class=" w-3/4 h-auto bg-white rounded-2xl flex flex-col items-center opacity-100 transition-opacity duration-750 starting:opacity-0 2xl:w-1/2 pb-6">
                <div class=" grid-cols-2 grid gap-14 mt-6 w-3/4 mb-6">
                    <div class=" flex flex-col w-full gap-2 border-b border-gray-300 font-extrabold">
                        <label for="requester" class=" text-black mt-6">Requester: {{ request.requester }}</label>
                    </div>
                    <div class=" flex flex-col w-full gap-2 border-b border-gray-300 font-extrabold">
                        <label for="date_request" class=" text-black mt-6">Date: {{ request.date_request }}</label>
                    </div>
                    <div class=" flex flex-col w-full gap-2 border-b border-gray-300 font-extrabold">
                        <label for="type_request" class=" text-black mt-6">Application: {{ request.application_name_en
                        }}</label>
                    </div>
                    <div class=" flex flex-col w-full gap-2 border-b border-gray-300 font-extrabold">
                        <label for="type_request" class=" text-black mt-6">Type Request: {{ request.type_request.type
                        }}</label>
                    </div>
                    <div class=" flex flex-col w-full gap-2 border-b border-gray-300 font-extrabold">
                        <label for="description" class=" text-black mt-6">Description: {{ request.description }}</label>
                    </div>
                    <div class=" flex flex-col w-full gap-2 border-b border-gray-300 font-extrabold">
                        <label for="type_request" class=" text-black mt-6">Create date: {{ request.created_at }}</label>
                    </div>
                </div>
            </div>

            <div v-for="list in request_timeline" :key="list.id"
                class=" w-3/4 h-auto bg-white rounded-2xl flex flex-col items-center opacity-100 transition-opacity duration-750 starting:opacity-0 2xl:w-1/2 pb-6 font-bold">
                <label for="type_request" class=" text-black mt-2 ml-4 self-start">Created at : {{ list.created_at
                    }}</label>
                <div class="w-full flex  justify-center items-center gap-8">
                    <div class="flex justify-center items-center gap-2">
                        <span class="text-black font-bold"> Actor : </span>
                        <label for="" class="text-black border border-green-600 bg-green-200 mt-2 mb-4 p-2 rounded-lg">
                            {{ list.name }}
                        </label>
                    </div>
                    <div class="flex justify-center items-center gap-2">
                        <span class="text-black font-bold"> Status : </span>
                        <label for="" class="text-black border border-blue-600 bg-blue-200 mt-2 mb-4 p-2 rounded-lg">
                            {{ list.status_request.status }}
                        </label>
                    </div>
                </div>

            </div>

        </div>
    </div>


</template>