<script setup>
import { useForm , usePage } from '@inertiajs/vue3';

const form = useForm({
    actor: '',
    requester: '',
    date_request: '',
    type_request: '' ,
    description: '',
    status_type: '',
    applications: ''
})

const log = () => {
    console.log('form:',  form.type_request.type , form.status_type.status);
    console.log('form value:', form.type_request.value, form.status_type.value);
}

const page = usePage();
const user = page.props.auth.user;
console.log('user:', user);

const type_request = page.props.type_request;
console.log('type_request:', type_request);

const status_request = page.props.status_request;
console.log('status_request:', status_request);

const props = defineProps({
    applications: Array
});

</script>

<template>
    <div class=" bg-black w-full h-screen flex flex-col">
        <nav class=" w-full flex justify-between items-center bg-gray-700 p-6 flex-0.5">
            <h1 class=" text-white text-2xl font-bold">Welcome to MA Application Request Page</h1>
            <div>
                <a href="/welcome" class=" text-white mr-4">Home</a>
                <a href="/application/index" class=" text-white mr-4">Index</a>
                <a href="/logout" class=" text-white">Logout</a>
            </div>
        </nav>
        <div class="w-full flex flex-32 justify-center items-center">
            <div class=" w-1/2 h-auto bg-white rounded-2xl flex flex-col items-center opacity-100 transition-opacity duration-750 starting:opacity-0">
                <h2 class=" text-black text-3xl font-bold mt-10 text-center">MA Application Request Page</h2>
                <p class=" text-black mt-6 w-3/4 text-center">If you want to request about application, please enter detail in the input
                    field below.</p>
            
                <p class="text-black">{{ user.name }} </p>
                <!-- <p class="text-black">{{ form.applications }} </p> -->
                <!-- <p class="text-black">{{ props.applications.name_th }}</p> -->
                <div class=" w-4/5 h-1/2 flex flex-col items-center mt-2 gap-2 opacity-100 transition-all duration-750 starting:translate-y-6 starting:opacity-0">
                    <div class=" flex flex-col w-full gap-2">
                        <label for="actor" class=" text-black mt-6">Actor: {{ form.actor }}</label>
                        <input type="text" id="actor" v-model="form.actor" placeholder="Name"
                            class="h-10 border border-gray-400 rounded-lg p-2 text-black placeholder-gray-400" />
                    </div>
                    <div class="flex flex-col w-full gap-2">
                        <label for="requester" class=" text-black mt-6">Requester: {{ form.requester }}</label>
                        <input type="text" id="requester" v-model="form.requester" placeholder="Requester"
                            class="h-10 border border-gray-400 rounded-lg p-2 text-black placeholder-gray-400" />
                    </div>
                    <div class=" flex w-full gap-2 max-lg:flex-col">
                        <div class=" flex flex-col w-full gap-2">
                            <label for="date_request" class=" text-black mt-6">Date: {{ form.date_request }}</label>
                            <input type="date" id="date_request" v-model="form.date_request" placeholder="Date"
                                class="h-10 border border-gray-400 rounded-lg p-2 text-black placeholder-gray-400" />
                        </div>
                        <div class=" flex flex-col w-full gap-2">
                            <label for="type_request" class=" text-black mt-6">Application Type: {{ form.type_request.type }}</label>
                            <select id="type_request" v-model="form.type_request"
                                class="h-10 border border-gray-400 rounded-lg p-2 text-black placeholder-gray-400 w-full">
                                <option value="" disabled selected>Select Application Type</option>
                                <option v-for="type in type_request" :key="type" :value="{type:type.name, value:type.value}">{{ type.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class=" flex flex-col w-full gap-2">
                        <label for="description" class=" text-black mt-6">Description:{{ form.description }}</label>
                        <input type="text" id="description" v-model="form.description" placeholder="Description"
                            class="h-10 border border-gray-400 rounded-lg p-2 text-black placeholder-gray-400" />
                    </div>
                    <div class=" flex flex-col w-full gap-2">
                        <label for="status_type" class=" text-black mt-6">Status Type: {{ form.status_type.status }}</label>
                        <select id="status_type" v-model="form.status_type"
                            class="h-10 border border-gray-400 rounded-lg p-2 text-black placeholder-gray-400 w-full">
                            <option value="" disabled selected>Select Status Type</option>
                            <option v-for="status in status_request" :key="status" :value="{status:status.name, value:status.value}">{{ status.name }}</option>
                        </select>
                    </div>

                    <div class=" flex flex-col w-full gap-2">
                        <label for="applications" class=" text-black mt-6"> Applications: {{ form.applications }} </label>
                        <select id="applications" v-model="form.applications"
                            class="h-10 border border-gray-400 rounded-lg p-2 text-black placeholder-gray-400 w-full">
                            <option value="" disabled selected>Select Application</option>
                            <option v-for="application in props.applications" :key="application.id" :value="application.id">
                                {{ application.name_th }}
                            </option>
                        </select>
                    </div>


                    <button type="submit" @click="log(form)"
                        class=" mt-6 mb-12 bg-blue-500 text-white px-4 py-2 rounded-lg font-bold hover:bg-blue-600">Submit
                        Request</button>
                </div>
            </div>
        </div>
    </div>


</template>