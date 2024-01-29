<template>
  <div class="flex justify-between mb-4">

    <div class="flex m-4 items-center">
      <router-link
          :to="{ name: 'workoutDetails', params: { id: route.params.id } }"
          class="bg-white px-4 py-2 text-sm shadow-sm font-medium tracking-wider border text-gray-600 rounded-md hover:shadow-lg hover:bg-gray-100"
      >
        Go Back
      </router-link>
    </div>

    <CreateExercise></CreateExercise>
  </div>

  <div v-if="isLoading">Loading</div>

  <div v-if="isSuccess">
    <div class="max-w-2xl mx-auto bg-white rounded-md shadow-md p-6">

      <h1 class="text-2xl font-semibold mb-6">Add Exercise</h1>

      <div v-if="exercises.length !== 0">
        <div class="m-4" v-for="exercise in exercises" :key="exercise.id">
          <div class="flex items-center">
            <ExerciseItem :exercise="exercise"></ExerciseItem>

            <div v-if="workout?.exercises.every(it => it.id !== exercise.id)">
              <button @click="handleAddExercise(exercise.id)"
                      class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-3 rounded">
                Add
              </button>
            </div>
            <div v-else>
              <button @click="handleRemoveExercise(exercise.id)"
                      class="ml-4 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-3 rounded">
                Remove
              </button>
            </div>

          </div>
        </div>
      </div>
      <div v-else>No exercise</div>

    </div>
  </div>
</template>



<script setup>
import {useMutation, useQuery, useQueryClient} from "@tanstack/vue-query";
import {addExercise, getExercises, getWorkout, removeExercise} from "@/helpers/ApiCalls.ts";
import {useRoute} from "vue-router";
import ExerciseItem from "@/components/ExerciseItem.vue";
import {ref} from "vue";
import CreateExercise from "@/components/CreateExercise.vue";

const route = useRoute()
const queryClient = useQueryClient()

const {
  isLoading,
  isSuccess,
  data: exercises
} = useQuery({
  queryKey: ['exercises'],
  queryFn: getExercises,
})


const {
  data: workout
} = useQuery({
  queryKey: ['workout', route.params.id],
  queryFn: () => getWorkout(route.params.id),
})


const addExerciseToWorkout = useMutation({
  mutationFn: ({workoutId, exerciseId}) => addExercise({workoutId, exerciseId}),
  onSuccess: (workout) => {
    queryClient.setQueryData(['workout', String(workout.id)], workout);
  },
})

const removeExerciseFromWorkout = useMutation({
  mutationFn: ({workoutId, exerciseId}) => removeExercise({workoutId, exerciseId}),
  onSuccess: (workout) => {
    queryClient.setQueryData(['workout', String(workout.id)], workout);
  },
})
const handleAddExercise = (exerciseId) => {
  addExerciseToWorkout.mutate({workoutId: route.params.id, exerciseId: exerciseId})
}
const handleRemoveExercise = (exerciseId) => {
  removeExerciseFromWorkout.mutate({workoutId: route.params.id, exerciseId: exerciseId},)
}


</script>