<template>  
    <Head title="Users"/>
    <div class="flex justify-between  mb-6">
        <div class="flex items-center">
            <h1 class="text-3xl" >Users</h1>                
            <Link v-if="can.createUser" href="/users/create" class="text-blue-500 text-sm ml-3">New User</Link>
        </div>        
        <input v-model="search" type="text" placeholder="Search..." class ="border px-2 rounded-lg"/>
    </div>

    <ul role="list" class="divide-y divide-gray-100">
    <li class="flex justify-between gap-x-6 py-5" v-for="user in users.data" :key="user.id">
        <div class="flex min-w-0 gap-x-4">
        <img class="h-12 w-12 flex-none rounded-full bg-gray-50" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
        <div class="min-w-0 flex-auto">
            <p class="text-sm font-semibold leading-6 text-gray-900">{{ user.name  }}</p>
            <!--<p class="mt-1 truncate text-xs leading-5 text-gray-500">leslie.alexander@example.com</p>-->
        </div>
        </div>
        <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
        <Link :href="'/users/'+ user.id+'/edit'" class="text-sm leading-6 text-gray-900">Edit</Link>
        <!--<p class="mt-1 text-xs leading-5 text-gray-500">Last seen <time datetime="2023-01-23T13:23Z">3h ago</time></p>-->
        </div>
    </li>
    
</ul>

<Pagination :links="users.links" class="mt-6"/>

</template>


<script setup>
import Pagination from "../../Shared/Pagination.vue";
import {ref, watch} from 'vue';
import {router} from "@inertiajs/vue3";
import debounce from "lodash/debounce";

let props=defineProps({ 
    users: Object,
    filters: Object,
    can : Object
});

let search = ref(props.filters.search);

watch( search,debounce(function (value){
    router.get('/users', {search: value},{
        preserveState: true,
        replace: true
    });
},500));

</script>
