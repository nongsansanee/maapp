<script setup>
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const request = page.props.request;
// const type_request = page.props.type_request;
// const status_request = page.props.status_request;
// const props = defineProps({
//     applications: Array
// });


</script>
<template>
    <div class=" bg-gray-900 w-full h-screen flex flex-col">
        <nav class=" w-full flex justify-between items-center bg-gray-700 p-6 h-24">
            <h1 class=" text-white text-2xl font-bold">Welcome to MA Application Edit Request Page</h1>
            <div>
                <a href="/" class=" text-white mr-4">Home</a>
                <a href="/request" class=" text-white mr-4">Index</a>
                <a href="/logout" class=" text-white">Logout</a>
            </div>
        </nav>
        <div class="w-full flex justify-center items-center p-12 font-noto">
            <div class=" w-3/4 h-auto bg-white rounded-2xl flex flex-col items-center opacity-100 transition-opacity duration-750 starting:opacity-0 2xl:w-1/2 pb-6">
                <h2 class=" text-black text-3xl font-bold mt-10 text-center">MA Application Detail Request</h2>
                <!-- <p class=" text-black mt-6 w-3/4 text-center">If you want to edit an existing application request, please update the details in the input
                    field below.</p> -->
                <div class=" grid-cols-2 grid gap-4 mt-6 w-3/4">
                    <div class=" flex flex-col w-full gap-2">
                        <label for="actor" class=" text-black mt-6">Actor: {{ request.actor }}</label>
                    </div>
                    <div class=" flex flex-col w-full gap-2">
                        <label for="requester" class=" text-black mt-6">Requester: {{ request.requester }}</label>
                    </div>
                    <div class=" flex flex-col w-full gap-2">
                        <label for="date_request" class=" text-black mt-6">Date: {{ request.date_request }}</label>
                    </div>
                    <div class=" flex flex-col w-full gap-2">
                        <label for="type_request" class=" text-black mt-6">Application Type: {{ request.type_request.type }}</label>
                    </div>
                    <div class=" flex flex-col w-full gap-2">
                        <label for="description" class=" text-black mt-6">Description: {{ request.description }}</label>
                    </div>
                    <div class=" flex flex-col w-full gap-2">
                        <label for="status_request" class=" text-black mt-6">Status Type: {{ request.status_request.status }}</label>
                    </div>
                </div>
            </div>
            
        </div>
    </div>


</template>