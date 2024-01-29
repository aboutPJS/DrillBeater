<template>
  <div class="flex justify-between mb-4">

    <div class="flex m-4 items-center">
      <router-link
          :to="{ name: 'training' }"
          class="bg-white px-4 py-2 text-sm shadow-sm font-medium tracking-wider border text-gray-600 rounded-md hover:shadow-lg hover:bg-gray-100"
      >
        Go Back
      </router-link>
    </div>
  </div>

  <div v-if="isLoading">Loading</div>

  <div v-if="isSuccess">
    <div class="max-w-2xl mx-auto bg-white rounded-md shadow-md p-6">

      <h1 class="text-2xl font-semibold mb-6">Exercise of {{ data.workoutName }}</h1>

      <div v-if="data.exercises.length !== 0">
        <div class="m-4" v-for="exercise in data.exercises" :key="exercise.id">
          <div class="flex items-center">
            <ExerciseItem :exercise="exercise"></ExerciseItem>

            <div v-if="exercise.execution.is_completed" class="bg-blue-100 p-4 rounded-md">
              <p class="text-blue-700 font-semibold">Done: {{ exercise.execution.updated_at }}</p>
              <p class="text-blue-700">Notes: {{ exercise.execution.notes }}</p>
              <p class="text-blue-700">Sets: {{ exercise.execution.sets }}</p>
              <p class="text-blue-700">Reps: {{ exercise.execution.reps }}</p>
              <p class="text-blue-700">Weight: {{ exercise.execution.weight }}</p>
            </div>

            <div v-else>
              <UpdateExecution
                  :executionId="exercise.execution.id"
                  :exerciseName="exercise.name"
                  :trainingId="exercise.execution.training_id"
              >
              </UpdateExecution>
            </div>
          </div>
        </div>
      </div>

      <div v-else>No exercise</div>

      <button @click="handleCompleteTraining"
              class=" bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded">
        Complete Training
      </button>
    </div>
  </div>
</template>

<script setup>
import {useMutation, useQuery, useQueryClient} from "@tanstack/vue-query";
import {completeTraining, getTraining} from "@/helpers/ApiCalls.ts";
import {useRoute, useRouter} from "vue-router";
import ExerciseItem from "@/components/ExerciseItem.vue";
import UpdateExecution from "@/components/UpdateExecution.vue";

const queryClient = useQueryClient()
const router = useRouter()

const route = useRoute()
const {
  isLoading,
  isSuccess,
  data
} = useQuery({
  queryKey: ['training', route.params.id],
  queryFn: () => getTraining(route.params.id),
  select: (data) => {
    return {
      workoutName: data.workout.name,
      exercises: data.workout.exercises.map((exercise) => {
        return {
          ...exercise,
          execution: data.executions.find((execution) => execution.exercise_id === exercise.id)
        }
      })
    }
  }
})

const {mutate} = useMutation({
  mutationFn: (trainingId) => completeTraining(trainingId),
  onSuccess: (training) => {
    queryClient.setQueryData(['training', String(training.id)], training);
    router.push({
          name: 'history'
        }
    )
  },
})

const handleCompleteTraining = () => {
  mutate(route.params.id)
}

</script>