<script setup>
import { ref } from 'vue';

</script>

<template>
    <div class=" bg-black w-full h-screen flex flex-col">
        <nav class=" w-full flex justify-between items-center bg-gray-700 p-6 flex-0.5">
            <h1 class=" text-white text-2xl font-bold">Welcome to MA Application Index Page</h1>
            <div>
                <a href="/welcome" class=" text-white mr-4">Home</a>
                <a href="/request" class=" text-white mr-4">Request</a>
                <a href="/logout" class=" text-white">Logout</a>
            </div>
        </nav>
        <div class="w-full flex flex-32 justify-center items-center">
            <div class=" w-1/2 h-auto bg-white rounded-2xl flex flex-col items-center">
                <h2 class=" text-black text-3xl font-bold mt-10">MA Application Index Page</h2>
                <p class=" text-black mt-6 mb-12">This is the index page of the MA Application.</p>
                <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg mb-12" href="/request">
                    Request Application
                </a>
                <div class="w-full p-4 bg-green-100 border border-green-400 rounded flex flex-col gap-2" v-for="$Request in $request">
                    <div class="border border-gray-400 rounded-lg p-4 mb-4 w-4/5">
                        <h3 class="text-xl font-bold mb-2">{{ $Request.type_request }}</h3>
                        <p class="text-gray-700 mb-2">Requester: {{ $Request.requester }}</p>
                        <p class="text-gray-700 mb-2">Date: {{ $Request.date_request }}</p>
                        <p class="text-gray-700">Description: {{ $Request.description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>