<script setup>
import { router, usePage, useForm } from '@inertiajs/vue3';

import { ref } from 'vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import 'primeicons/primeicons.css'

import Paginate from '@/Components/Paginate.vue';

const opendialog = ref(false)

// const page = usePage();
const props = defineProps({
    requests: { type: Object },
    status_request: { type: Object }
});


console.log('$requests:', props.requests);

const form = useForm({
    id: '',
    actor: '',
    status_request: '',
})

const openDialog = (index) => {
    form.id = props.requests.data[index].id;
    form.actor = props.requests.data[index].actor;
    form.status_request = props.requests.data[index].status_request;
    console.log('Opening dialog for request:', props.requests.data[index].status_request);
    opendialog.value = true;
}

const editRequest = (requests) => {
    console.log('Editing request:', requests);
    router.visit(route('request.edit', requests), {}, {
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

const viewRequest = (requests) => {
    console.log('Viewing request:', requests);
    router.visit(route('request.show', requests), {}, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            console.log('Navigation to view page successful');
        },
        onError: (errors) => {
            console.log('Error navigating to view page:', errors);
        },
        onFinish: () => {
            console.log('Navigation to view page finished');
        }
    });
}

const deleteRequest = (request) => {
    if (confirm('Are you sure you want to delete this request?')) {
        router.delete(route('request.destroy', request), {
            onSuccess: () => {
                alert('Request deleted successfully');
            },
            onError: (errors) => {
                console.log('Error deleting request:', errors);
            },
        });
    }
}

const EditStatusRequest = () => {
    console.log('Changing status for request with actor:', form.actor, 'and new status:', form.status_request.values, form.id);
    form.status_request = form.status_request.values;
    form.put(route('request.update_status', form.id), {
        onSuccess: () => {
            alert('Request updated successfully');
            form.reset();
            opendialog.value = false;
        },
        onError: (errors) => {
            console.log('Error submitting request:', errors);
        },
    });
}

</script>

<template>
    <div class=" bg-gray-700 w-full min-h-screen h-full flex flex-col font-noto">
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
                    <h1 class="text-black text-xl font-bold  mb-4 flex-2">Actor</h1>
                    <h1 class="text-black text-xl font-bold  mb-4 flex-2">Requester</h1>
                    <h1 class="text-black text-xl font-bold  mb-4 flex-2">Date Request</h1>
                    <h1 class="text-black text-xl font-bold  mb-4 flex-2">Type Request</h1>
                    <h1 class="text-black text-xl font-bold  mb-4 flex-2">Application</h1>
                    <h1 class="text-black text-xl font-bold  mb-4 flex-2">Admin</h1>
                    <h1 class="text-black text-xl font-bold  mb-4 flex-2">Status</h1>
                    <h1 class="text-black text-xl font-bold  mb-4 flex-1">Edit</h1>
                </div>
                <div class="w-full flex pt-4 mb-4 border-t border-gray-300 pl-16 pr-4 gap-4 items-center"
                    v-for="(request, index) in props.requests.data" :key="request.id" :values="request.id">
                    <p class="text-black text-lg font-medium  flex-1">{{ request.id }}</p>
                    <p class="text-black text-lg font-medium  flex-2">{{ request.actor }}</p>
                    <p class="text-black text-lg font-medium  flex-2">{{ request.requester }}</p>
                    <p class="text-black text-lg font-medium  flex-2">{{ request.date_request }}</p>
                    <p class="text-black text-lg font-medium  flex-2">{{ request.type_request.type }}</p>
                    <p class="text-black text-lg font-medium  flex-2">{{ request.application_name_th }}</p>
                    <p class="text-black text-lg font-medium  flex-2">{{ request.application_admin }}</p>
                    <div class="flex flex-2">
                        <div class="flex gap-4 cursor-pointer" @click="openDialog(index)">
                            <p class="text-black text-lg font-medium">{{ request.status_request.status }}</p>
                            <i class="pi pi-chevron-down text-blue-500 cursor-pointer flex-1 mt-1"></i>
                        </div>
                    </div>
                    <div class="flex flex-1">
                        <i class="pi pi-pencil text-blue-500 cursor-pointer flex-1 mt-1"
                            @click="editRequest(request)"></i>
                        <i class="pi pi-folder text-blue-500 cursor-pointer flex-1 mt-1"
                            @click='viewRequest(request)'></i>
                        <i class="pi pi-trash text-red-500 cursor-pointer flex-1 mt-1"
                            @click="deleteRequest(request)"></i>
                    </div>
                    <!-- <div class="flex-1">
                        <button @click="editRequest(request)"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold rounded-lg w-20 h-10">
                            Edit
                        </button>
                    </div> -->
                </div>
            </div>
        </div>

        <Paginate class="relative w-full min-w-min flex justify-center items-center mt-3" :pagination="props.requests" />


        <TransitionRoot as="template" :show="opendialog">
            <Dialog class="relative z-10" @close="opendialog = false">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to=""
                    leave="ease-in duration-200" leave-from="" leave-to="opacity-0">
                    <div class="fixed inset-0 bg-gray-900/50 transition-opacity"></div>
                </TransitionChild>

                <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                        <TransitionChild as="template" enter="ease-out duration-300"
                            enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            enter-to=" translate-y-0 sm:scale-100" leave="ease-in duration-200"
                            leave-from=" translate-y-0 sm:scale-100"
                            leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                            <DialogPanel
                                class="relative transform overflow-hidden rounded-lg bg-gray-800 text-left shadow-xl outline -outline-offset-1 outline-black/10 transition-all sm:my-8 sm:w-full sm:max-w-lg ">
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 h-auto">
                                    <div class="sm:flex sm:items-start">
                                        <!-- <div
                                            class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-red-500/10 sm:mx-0 sm:size-10">
                                            <ExclamationTriangleIcon class="size-6 text-red-400" aria-hidden="true" />
                                        </div> -->
                                        <div class="flex flex-col gap-4 p-8 w-full">
                                            <DialogTitle as="h3"
                                                class="text-center font-semibold text-gray-900 text-2xl">
                                                Change Status Request</DialogTitle>
                                            <div class="mt-2 text-black text-lg font-medium flex flex-col gap-2">
                                                <p>Actor: {{ form.actor }}</p>
                                                <input type="text" v-model="form.actor" placeholder="Actor"
                                                    class="h-10 border border-gray-400 rounded-lg p-2 placeholder-gray-400 w-full" />
                                            </div>
                                            <div class="mt-2 text-black text-lg font-medium flex flex-col gap-2">
                                                <p>Status Request: {{ form.status_request.status }}</p>
                                                <select id="status_type" v-model="form.status_request"
                                                    class="h-10 border border-gray-400 rounded-lg p-2 placeholder-gray-400 w-full">
                                                    <option value="" disabled selected>Select Status Type</option>
                                                    <option v-for="status in props.status_request" :key="status"
                                                        :value="{ status: status.name, values: status.values }">{{
                                                            status.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-700/25 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                    <button type="button"
                                        class="inline-flex w-full justify-center rounded-md bg-blue-500  px-3 py-2 text-sm font-semibold text-white hover:bg-blue-600 sm:ml-3 sm:w-auto"
                                        @click="EditStatusRequest()">Change Status</button>
                                    <button type="button"
                                        class="mt-3 inline-flex w-full justify-center rounded-md bg-white/10 px-3 py-2 text-sm font-semibold text-white inset-ring inset-ring-white/5 hover:bg-white/20 sm:mt-0 sm:w-auto"
                                        @click="opendialog = false" ref="cancelButtonRef">Cancel</button>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </div>
</template>