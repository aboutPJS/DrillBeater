<template>
  <div class="relative">
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

    <div class="max-w-screen-md mx-auto mt-16">
      <h1 class="text-3xl font-bold underline mb-6">
        Chose workout to start training
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
          <a @click="startWorkout(workout.id)" class="flex items-center">
            <div class="bg-blue-500 text-white p-4 rounded-full mr-4">
              💪
            </div>
            <div>
              <h3 class="text-xl font-bold">{{ workout.name }}</h3>
            </div>
          </a>
        </div>
      </div>

    </div>
  </div>
</template>

<script setup>
import {useMutation, useQuery, useQueryClient} from "@tanstack/vue-query";
import {createTraining, getWorkouts} from "@/helpers/ApiCalls.ts";
import {useRouter} from "vue-router";

const router = useRouter()
const queryClient = useQueryClient()

const {
  isError,
  isLoading,
  data
} = useQuery({
  queryKey: ['workouts'],
  queryFn: getWorkouts,
})

const {mutate} = useMutation({
  mutationFn: (workoutId) => createTraining(workoutId),
  onSuccess: (training) => {
    queryClient.setQueryData(['training', String(training.id)], training);
    router.push({
          name: 'trainingDetails', params: {id: training.id}
        }
    )
  },
})
const startWorkout = (id) => {
  mutate(id)
}
</script>