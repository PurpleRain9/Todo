import { createWebHashHistory, createRouter } from "vue-router";
import Home from './Pages/Home.vue';
import Login from './Pages/Login.vue';
import Register from './Pages/Register.vue';


const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home,
        meta: {
            requiresAuth:true
        }
    },
    {
        path : '/login',
        name:'Login',
        component:Login,
        meta: {
            requiresAuth:false
        }
    },
    {
        path: '/register',
        name: 'Register',
        component: Register,
        meta: {
            requiresAuth:false
        }
    }
]



const router = createRouter({
    history: createWebHashHistory(),
    routes
});

router.beforeEach((to,from) => {
    if(to.meta.requiresAuth == true && !localStorage.getItem('token')){
        return {name : 'Login'}
    }
    if (to.meta.requiresAuth == false && localStorage.getItem('token')) {
        return {name: 'Home'}
    }
});

export default router
