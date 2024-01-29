<script setup>
import {useQuery} from "@tanstack/vue-query";
import {getUser, getWorkout, getWorkouts} from "@/helpers/ApiCalls.ts";
import {useRoute, useRouter} from "vue-router";
import ExerciseItem from "@/components/ExerciseItem.vue";
import http from "@/helpers/http.js";

const route = useRoute()
const router = useRouter()


const {
  isError,
  isLoading,
  isSuccess,
  data
} = useQuery({
  queryKey: ['workout', route.params.id],
  queryFn: () => getWorkout(route.params.id),
})


const handleShowAllExercises = () => {
  router.push({
    name: 'exercises'
  })
}


</script>

<template>
  <div class="flex justify-between mb-4">

    <div class="flex justify-between m-4">
      <router-link
          :to="{ name: 'workout' }"
          class="bg-white px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-gray-600 rounded-md hover:shadow-lg hover:bg-gray-100"
      >
        Go Back
      </router-link>
    </div>
  </div>

  <div v-if="isLoading">Loading</div>


  <div v-if="isSuccess">
    <div class="max-w-2xl mx-auto bg-white rounded-md shadow-md p-6">

      <h1 class="text-2xl font-semibold mb-6">Workout Information</h1>

      <div>
        <h2 class="text-xl font-semibold mb-4">Workout Details</h2>
        <p><strong>Name:</strong> {{ data.name }}</p>
        <p><strong>Created At:</strong> {{ data.created_at }}</p>
        <p><strong>Updated At:</strong> {{ data.updated_at }}</p>
      </div>

      <div v-if="data.exercises.length !== 0">
        <div class="m-4" v-for="exercise in data.exercises" :key="exercise.id">
          <ExerciseItem :exercise="exercise"></ExerciseItem>
        </div>
      </div>
      <div v-else>No exercise</div>

      <button @click="handleShowAllExercises"
              class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded">
        Add Exercise
      </button>

    </div>


  </div>


</template>
