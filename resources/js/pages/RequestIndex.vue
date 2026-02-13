<script setup>
import { router, usePage } from '@inertiajs/vue3';

const page = usePage();
const requests = page.props.requests;

console.log('$requests:', requests);

const editRequest = (requests) => {
    console.log('Editing request:', requests);
    router.visit(route('request.edit', requests),{},{
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            console.log('Navigation to edit page successful');
        },
        onError: (errors) => {
            console.log('Error navigating to edit page:', errors);
        },
        onFinish: () => {
            console.log('Navigation to edit page finished');
        }
    });
}

</script>

<template>
    <div class=" bg-gray-700 w-full h-screen flex flex-col font-noto">
        <nav class=" w-full flex justify-between items-center bg-gray-700 p-6 h-24">
            <h1 class=" text-white text-2xl font-bold">Welcome to MA Application Index Page</h1>
            <div>
                <a href="/" class=" text-white mr-4">Home</a>
                <a href="/request/create" class=" text-white mr-4">Request</a>
                <a href="/logout" class=" text-white">Logout</a>
            </div>
        </nav>

        <div class=" w-full h-auto bg-white rounded-2xl flex flex-col items-center">
            <h2 class=" text-black text-3xl font-bold mt-10">MA Application Index Page</h2>
            <p class=" text-black mt-6 mb-12">This is the index page of the MA Application.</p>
            <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg mb-12"
                href="/request/create">
                Request Application
            </a>

            <div class="w-full flex flex-col">
                <div class="w-full flex pl-16 pr-4 gap-4 border-b-2 border-gray-300">
                    <h1 class="text-black text-xl font-bold  mb-4 flex-1">Id</h1>
                    <h1 class="text-black text-xl font-bold  mb-4 flex-1">User ID</h1>
                    <h1 class="text-black text-xl font-bold  mb-4 flex-2">User Name</h1>
                    <h1 class="text-black text-xl font-bold  mb-4 flex-2">Requester</h1>
                    <h1 class="text-black text-xl font-bold  mb-4 flex-2">Date Request</h1>
                    <h1 class="text-black text-xl font-bold  mb-4 flex-2">Type Request</h1>
                    <h1 class="text-black text-xl font-bold  mb-4 flex-2">Application</h1>
                    <h1 class="text-black text-xl font-bold  mb-4 flex-2">Admin</h1>
                    <h1 class="text-black text-xl font-bold  mb-4 flex-2">Description</h1>
                    <h1 class="text-black text-xl font-bold  mb-4 flex-2">Edit</h1>
                </div>
                <div class="w-full flex pt-4 mb-4 border-t border-gray-300 pl-16 pr-4 gap-4" v-for="request in requests"
                    :key="request.id" :values="request.id">
                    <p class="text-black text-lg font-medium  flex-1">{{ request.id }}</p>
                    <p class="text-black text-lg font-medium  flex-1">{{ request.actor }}</p>
                    <p class="text-black text-lg font-medium  flex-2">{{ request.user_name }}</p>
                    <p class="text-black text-lg font-medium  flex-2">{{ request.requester }}</p>
                    <p class="text-black text-lg font-medium  flex-2">{{ request.date_request }}</p>
                    <p class="text-black text-lg font-medium  flex-2">{{ request.type_request }}</p>
                    <p class="text-black text-lg font-medium  flex-2">{{ request.application_name_th }}</p>
                    <p class="text-black text-lg font-medium  flex-2">{{ request.application_admin }}</p>
                    <p class="text-black text-lg font-medium  flex-2">{{ request.description }}</p>
                    <div class="flex-2">
                        <button @click="editRequest(request)"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold rounded-lg w-20 h-10">
                        Edit
                    </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>