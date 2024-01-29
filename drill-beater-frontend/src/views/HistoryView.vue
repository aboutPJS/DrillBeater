<template>
  <div class="flex justify-between mb-4">
    <div class="flex justify-between m-4">
      <router-link
          :to="{ name: 'home' }"
          class="bg-white px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-gray-600 rounded-md hover:shadow-lg hover:bg-gray-100"
      >
        Go Back
      </router-link>
    </div>
  </div>
  <div>
    <div v-for="training in data" :key="training.id" class="my-4 p-4 border rounded-md">
      <p class="text-lg font-semibold">Training from {{ training.created_at }}</p>
      <p class="text-md mb-2">of workout {{ training.workout.name }}</p>
      <p class="font-semibold">With {{ training.executions.length }} Exercises</p>
    </div>
  </div>
</template>

<script setup>


import {useQuery} from "@tanstack/vue-query";
import {getTrainings} from "@/helpers/ApiCalls.ts";

const {
  isError,
  isLoading,
  isSuccess,
  data
} = useQuery({
  queryKey: ['trainings', 'history'],
  queryFn: getTrainings,
})

</script>