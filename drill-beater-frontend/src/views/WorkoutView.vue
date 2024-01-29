<script setup lang="ts">
import {QueryClient, useQuery} from '@tanstack/vue-query'
import {getExercises, getWorkouts} from "@/helpers/ApiCalls.ts";
import {useRouter} from "vue-router";
import CreateWorkout from "@/components/CreateWorkout.vue";

const queryClient = new QueryClient()

const router = useRouter()


const {
  isError,
  isLoading,
  data
} = useQuery({
  queryKey: ['workouts'],
  queryFn: getWorkouts,
})

const navigate = (id: string) => {
  router.push({
        name: 'workoutDetails', params: {id: id}
      }
  )
}
const handleCreatWorkout = () => {
}

</script>

<template>
  <div class="relative">
    <!-- Create Workout button -->

    <div class="flex justify-between mb-4">

      <div class="flex justify-between m-4">
        <router-link
          :to="{ name: 'home' }"
          class="bg-white px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-gray-600 rounded-md hover:shadow-lg hover:bg-gray-100"
      >
        Go Back
      </router-link>
      </div>


      <CreateWorkout></CreateWorkout>
    </div>

    <div class="max-w-screen-md mx-auto mt-16"> <!-- Adjusted margin-top to provide space for the button -->
      <h1 class="text-3xl font-bold underline mb-6">
        Your Workouts
      </h1>

      <div v-if="isLoading" class="text-gray-700">
        Loading...
      </div>

      <div v-else-if="isError" class="text-red-500">
        Something went wrong, please try again
      </div>

      <div v-else>
        <div v-for="workout in data" :key="workout.id"
             class="mb-6 p-4 border rounded-md shadow-md hover:shadow-lg transition duration-300 ease-in-out">
          <a @click="navigate(workout.id)" class="flex items-center">
            <div class="bg-blue-500 text-white p-4 rounded-full mr-4">
              <!-- You can replace the icon with your workout icon -->
              💪
            </div>
            <div>
              <h3 class="text-xl font-bold">{{ workout.name }}</h3>
              <p class="text-gray-600">{{ workout.description }}</p>
            </div>
          </a>
        </div>
      </div>

    </div>
  </div>
</template>