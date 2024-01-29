import {createRouter, createWebHistory} from 'vue-router'
import HomeView from '../views/HomeView.vue'
import WorkoutView from "@/views/WorkoutView.vue";
import LoginView from "@/views/LoginView.vue";
import http from "@/helpers/http.js";
import WorkoutDetailsView from "@/views/WorkoutDetailsView.vue";
import ExerciseListView from "@/views/ExerciseListView.vue";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/login',
            name: 'login',
            component: LoginView
        },
        {
            path: '/',
            name: 'home',
            component: HomeView
        },
        {
            path: '/workout',
            name: 'workout',
            component: WorkoutView
        },
        {
            path: '/workout/:id',
            name: 'workoutDetails',
            component: WorkoutDetailsView,
        },
        {
            path: '/workout/:id/exercises',
            name: 'exercises',
            component: ExerciseListView,
        },
    ]
})

router.beforeEach((to, from) => {

    if (to.name === 'login') {
        return true
    }

    if (!localStorage.getItem('token')) {
        return {
            name: 'login'
        }
    }

    checkTokenAuthenticity()
})

const checkTokenAuthenticity = () => {
    http().get('/api/user')
        .catch((error) => {
            localStorage.removeItem('token')
            router.push({
                name: 'login'
            })
        })
}

export default router
