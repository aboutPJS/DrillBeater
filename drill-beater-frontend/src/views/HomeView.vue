<script setup>
import {useRouter} from "vue-router";

const router = useRouter()


const handleStartTraining = () => {
  router.push({
    name: 'training'
  })
}

const handleWorkouts = () => {
  router.push({
    name: 'workout'
  })
}

const handleTrainingHistory = () => {
  router.push({
    name: 'history'
  })
}


</script>

<template>
  <h1 class="text-3xl font-bold underline">
    Hello world!
  </h1>

  <div class="flex flex-col items-center justify-center space-y-4">
    <button @click="handleStartTraining"
            class=" bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded">
      Start Training
    </button>
    <button @click="handleWorkouts"
            class=" bg-white border border-blue-500 hover:bg-gray-100 text-gray-800 font-bold py-3 px-4 rounded">
      Workouts
    </button>
    <button @click="handleTrainingHistory"
            class=" bg-white border border-blue-500 hover:bg-gray-100 text-gray-800 font-bold py-3 px-4 rounded">
      Training History
    </button>
  </div>
</template>
