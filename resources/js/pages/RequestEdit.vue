<script setup>
import { useForm , usePage } from '@inertiajs/vue3';

const page = usePage();
// console.log('request first:', request);
// const type_request = page.props.type_request;
// const status_request = page.props.status_request;
const props = defineProps({
    applications: Array,
    type_request: Array,
    status_request: Array,
    request: Object
});

// const request = page.props.request;
const form = useForm({
    user_id: props.request.user_id,
    actor: props.request.actor,
    requester: props.request.requester,
    date_request: props.request.date_request,
    type_request: props.request.type_request,
    description: props.request.description,
    status_request: props.request.status_request,
    application: props.request.application_id
})

const EditRequest = (Apprequest) => {
    form.type_request = form.type_request.value;
    form.status_request = form.status_request.value;
    console.log('request', Apprequest , 'form',form);
    form.patch(route('request.update', props.request), {
        onSuccess: () => {
            alert('Request updated successfully');
            form.reset();
        },
        onError: (errors) => {
            console.log('Error submitting request:', errors);
        },
    });
}

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
            <div class=" w-3/4 h-auto bg-white rounded-2xl flex flex-col items-center opacity-100 transition-opacity duration-750 starting:opacity-0 2xl:w-1/2">
                <h2 class=" text-black text-3xl font-bold mt-10 text-center">MA Application Edit Request Page</h2>
                <p class=" text-black mt-6 w-3/4 text-center">If you want to edit an existing application request, please update the details in the input
                    field below.</p>
                <div class=" w-4/5 h-1/2 flex flex-col items-center mt-2 gap-2 opacity-100 transition-all duration-750 starting:translate-y-6 starting:opacity-0">
                    <div class=" flex flex-col w-full gap-2">
                        <label for="actor" class=" text-black mt-6">Actor: {{ form.actor }}</label>
                        <input type="text" id="actor" v-model="form.actor" placeholder="Actor" :class="form.errors.actor && !form.actor ? 'border-red-500 placeholder-red-500:' : ''"
                            class="h-10 border border-gray-400 rounded-lg p-2 text-black placeholder-gray-400" />
                            <p v-if="form.errors.actor && !form.actor" class="text-red-500">{{ form.errors.actor }}</p>
                    </div>
                    <div class="flex flex-col w-full gap-2">
                        <label for="requester" class=" text-black mt-6">Requester: {{ form.requester }}</label>
                        <input type="text" id="requester" v-model="form.requester" placeholder="Requester" :class="form.errors.requester && !form.requester ? 'border-red-500 placeholder-red-500:' : ''"
                            class="h-10 border border-gray-400 rounded-lg p-2 text-black" />
                        <p v-if="form.errors.requester && !form.requester" class="text-red-500">{{ form.errors.requester }}</p>

                    </div>
                    <div class=" flex w-full gap-2 max-lg:flex-col">
                        <div class=" flex flex-col w-full gap-2">
                            <label for="date_request" class=" text-black mt-6">Date: {{ form.date_request }}</label>
                            <input type="date" id="date_request" v-model="form.date_request" placeholder="Date" :class="form.errors.date_request && !form.date_request ? 'border-red-500 placeholder-red-500:' : ''"
                                class="h-10 border border-gray-400 rounded-lg p-2 text-black placeholder-gray-400" />
                            <p v-if="form.errors.date_request && !form.date_request" class="text-red-500">{{ form.errors.date_request }}</p>
                        </div>
                        <div class=" flex flex-col w-full gap-2">
                            <label for="type_request" class=" text-black mt-6">Application Type: {{ form.type_request.type }}</label>
                            <select id="type_request" v-model="form.type_request" :class="form.errors.type_request && !form.type_request ? 'border-red-500 placeholder-red-500:' : ''"
                                class="h-10 border border-gray-400 rounded-lg p-2 text-black placeholder-gray-400 w-full">
                                <option value="" disabled selected style="color: gray;">Select Application Type</option>
                                <option v-for="type in type_request" :key="type" :value="{type:type.name, value:type.value}">{{ type.name }}</option>
                            </select>
                            <p v-if="form.errors.type_request && !form.type_request" class="text-red-500">{{ form.errors.type_request }}</p>
                        </div>
                    </div>
                    <div class=" flex flex-col w-full gap-2">
                        <label for="description" class=" text-black mt-6">Description:{{ form.description }}</label>
                        <input type="text" id="description" v-model="form.description" placeholder="Description" :class="form.errors.description && !form.description ? 'border-red-500 placeholder-red-500:' : ''"
                            class="h-10 border border-gray-400 rounded-lg p-2 text-black placeholder-gray-400" />
                            <p v-if="form.errors.description && !form.description" class="text-red-500">{{ form.errors.description }}</p>
                    </div>
                    <div class=" flex flex-col w-full gap-2">
                        <label for="status_type" class=" text-black mt-6">Status Type: {{ form.status_request.status }}</label>
                        <select id="status_type" v-model="form.status_request" :class="form.errors.status_request && !form.status_request ? 'border-red-500 placeholder-red-500:' : ''"
                            class="h-10 border border-gray-400 rounded-lg p-2 text-black placeholder-gray-400 w-full">
                            <option value="" disabled selected>Select Status Type</option>
                            <option v-for="status in status_request" :key="status" :value="{status:status.name, value:status.value}">{{ status.name }}</option>
                        </select>
                        <p v-if="form.errors.status_request && !form.status_request" class="text-red-500">{{ form.errors.status_request }}</p>
                    </div>

                    <div class=" flex flex-col w-full gap-2">
                        <label for="application" class=" text-black mt-6"> Applications: {{ form.application }} </label>
                        <select id="application" v-model="form.application" :class="form.errors.application && !form.application ? 'border-red-500 placeholder-red-500:' : ''"
                            class="h-10 border border-gray-400 rounded-lg p-2 text-black placeholder-gray-400 w-full">
                            <option value="" disabled selected>Select Application</option>
                            <option v-for="application in props.applications" :key="application.id" :value="application.id">
                                {{ application.name_th }}
                            </option>
                        </select>
                        <p v-if="form.errors.application && !form.application" class="text-red-500">{{ form.errors.application }}</p>
                    </div>


                    <button type="submit" @click="EditRequest(props.request)"
                        class=" mt-6 mb-12 bg-blue-500 text-white px-4 py-2 rounded-lg font-bold hover:bg-blue-600">Edit
                        Request</button>
                </div>
            </div>

        </div>
    </div>


</template>
