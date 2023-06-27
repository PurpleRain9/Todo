<template>
    <nav class=" bg-[#dfe4ea] border-gray-200 dark:bg-gray-900">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href=" " class="flex items-center">
                <img src="../../../public/images/cooperate-svgrepo-com.svg" class="h-8 mr-3" alt="Flowbite Logo" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Todo App</span>
            </a>
            <button data-collapse-toggle="navbar-default" type="button"
                class="inline-flex items-center p-2 ml-3 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                aria-controls="navbar-default" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
            <div class="hidden w-full md:block md:w-auto" id="navbar-default">

            </div>


            <div class="relative ">
                <!-- Toggle Button -->
                <button @click="isOpen = !isOpen"
                    class="text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2"
                    v-if="getUser">
                    {{ getUser.name }}
                </button>

                <!-- Dropdown Menu -->
                <div v-if="isOpen"
                    class="absolute right-0 w-40 mt-2 origin-top-right bg-white border border-gray-200 divide-y divide-gray-100 rounded-md shadow-lg">
                    <!-- Dropdown Items -->
                    <a @click="logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</a>

                </div>
            </div>
        </div>
    </nav>

    <div class="mt-3">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-6 space-y-4 px-6" style="height: 500px;">
                <div v-for="(todo , index) in state.todos" :key="index" class="p-8 bg-white shadow-md rounded flex items-center justify-between" :class="{ 'bg-green-200' : todo.done}">
                    <div>
                        <div>{{ todo.title }}</div>
                        <div class="text-gray-500 text-sm mt-2">{{ todo.description }}</div>
                        <div class="text-gray-500 mt-3" style="font-size: 0.7rem;">{{ todo.created_at }}</div>

                    </div>
                    <div class="space-x-2">
                        <button class="px-2 text-red-600" @click="removeTodo(todo)" title="Remove todo">&times;</button>
                        <button v-if="!todo.done"  class="px-2 text-green-600" @click="markAsDone(todo)"
                            title="Mark as done">&check;</button>
                        <button  class="px-2 text-orange-600" @click="markAsUndone(todo)"
                            title="Mark as undone">&#8630;</button>
                        <!-- <button  class="px-2 text-yellow-600" @click="editTodo(todo)"
                        title="Mark as undone">&#232;</button> -->
                    </div>
                </div>
            </div>
            <div class="col-span-6" style="height: 500px;">
                    <div class="p-6 shadow-lg">
                        <form @submit.prevent="addTodo">
                            <div>
                                <input type="hidden" v-model="state.user_id">
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                                    Title</label>
                                <input type="text" id="title" aria-describedby="helper-text-explanation"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="your title.." v-model="state.title">
                            </div>
                            <div class="mt-6">
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                                    Description</label>
                                <textarea type="text" id="title" aria-describedby="helper-text-explanation"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 h-40"
                                    placeholder="your description.. " v-model="state.description"></textarea>
                            </div>
                            <div class="mt-6">
                                <button type="submit"
                                    class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Add
                                    Todo</button>
                            </div>
                        </form>
                    </div>
                </div>

        </div>
    </div>

</template>
<script>
import { useRouter } from 'vue-router';
import { onMounted, ref } from 'vue';
import { defineComponent, reactive } from "vue";
import axios from 'axios';

export default defineComponent({
    setup() {
        const user = localStorage.getItem('token');
        const router = useRouter();
        const isOpen = ref(false);
        const getUser = ref(null);



        function logout() {
            localStorage.removeItem('token');
            router.push({ name: 'Login' });
        }



        async function fetchUser() {
            const token = localStorage.getItem('token');
            if (token) {
                try {
                    const response = await axios.get('/api/user', {
                        headers: {
                            Authorization: `Bearer ${token}`
                        }
                    });
                    getUser.value = response.data;
                    state.user_id = getUser.value.id
                } catch (error) {
                    console.error('Error fetching user data:', error);
                }
            }
        }
        const state = reactive({
            todos: [],
            title: "",
            description: "",
            user_id : getUser.id,
        });

        const unstate = reactive({
            todos: [],
            title: "",
            description: "",
            user_id: getUser.id,
        })

        const addTodo = async() => {
            console.log('Hien');
            await axios.post('/api/store_todo', state).then((response) => {
                console.log(response);
                getTodo();
            }).catch((error) => {
                console.log(error);
            });
        }

        onMounted(fetchUser);

        // let id = state.user_id;
        const getTodo = async() => {
            await axios.get(`/api/show_todo`).then((response) => {
                console.log(response.data);
                // console.log(id);
                state.todos = response.data;
            }).catch((err) => {
                console.log(err);
            });
        }

        onMounted(getTodo);

        const markAsDone = async(todo) => {
            await axios.post('/api/mask_as_todo',{
                id:todo.id
            }).then(()=>getTodo());
        }

        const markAsUndone = async(todo) => {
            await axios.post('/api/mask_down_todo', {
                id:todo.id
            }).then(()=>getTodo());
        }

        const removeTodo = async(todo) => {
            if (!confirm("Are you sure?")) {
                return;
            }

            await axios.post('/api/delete_todo', {
                id: todo.id
            }).then(() => getTodo());
        }





        return {
            user,
            logout,
            isOpen,
            getUser,
            state,
            addTodo,
            removeTodo,
            markAsDone,
            markAsUndone,

        };
    },
});
</script>

