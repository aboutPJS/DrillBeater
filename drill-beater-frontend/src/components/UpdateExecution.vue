<template>
  <div>
    <div class="flex flex-col items-center justify-center p-3 min-h-full">
      <button
          @click="onToggle"
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
      >
        Start Execution
      </button>
    </div>
    <transition name="fade">
      <div v-if="isOpen">
        <div
            @click="onToggle"
            class="absolute bg-black opacity-70 inset-0 z-0"
        ></div>
        <div
            class="w-full max-w-lg p-3 relative mx-auto my-auto rounded-xl shadow-lg bg-white"
        >
          <div>
            <div class="text-center p-3 flex-auto justify-center leading-6">
              <h2 class="text-2xl font-bold py-4">Fill in Details for {{ exerciseName }}</h2>
              <div class="container mx-auto p-4">
                <form @submit.prevent="onSave" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                  <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="reps">
                      Reps
                    </label>
                    <input v-model="formData.reps"
                           class="shadow appearance-none border rounded w-1/2 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-2"
                           id="reps" type="number" placeholder="8">

                  </div>
                  <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="sets">
                      Sets
                    </label>
                    <input v-model="formData.sets"
                           class="shadow appearance-none border rounded w-1/2 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-2"
                           id="sets" type="number" placeholder="3">

                  </div>
                  <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="weight">
                      Weight
                    </label>
                    <input v-model="formData.weight"
                           class="shadow appearance-none border rounded w-1/2 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-2"
                           id="weight" type="number" placeholder="30">

                  </div>
                  <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="notes">
                      Notes
                    </label>
                    <textarea v-model="formData.notes"
                              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                              id="notes" placeholder="Execution was immaculate"></textarea>
                  </div>
                </form>
              </div>
            </div>
            <div class="p-3 mt-2 text-center space-x-4 md:block">
              <button
                  @click="onSave"
                  class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
              >
                Save
              </button>
              <button
                  @click="onToggle"
                  class="mb-2 md:mb-0 bg-white px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-gray-600 rounded-md hover:shadow-lg hover:bg-gray-100"
              >
                Cancel
              </button>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>


</template>

<script setup>
import {reactive, ref} from "vue"
import {useMutation, useQueryClient} from "@tanstack/vue-query";
import {createExercise, updateExecution} from "@/helpers/ApiCalls.ts";

const props = defineProps({
  trainingId: Number,
  executionId: Number,
  exerciseName: String,
})

const formData = reactive(
    {
      name: "",
      notes: "",
      reps: null,
      sets: null,
      weight: null,
    }
)

const isOpen = ref(false)
const queryClient = useQueryClient()


const onToggle = () => {
  isOpen.value = !isOpen.value;
}

const {mutate} = useMutation({
  mutationFn: (data) => updateExecution(data),
  onSuccess: (execution) => {
    queryClient.setQueryData(['training', String(props.trainingId)], (old) => {
      return {...old, executions: old.executions.map(it => it.id === execution.id ? execution : it)}
    });
    onToggle()
  },
})
const onSave = () => {
  mutate({
    trainingId: props.trainingId,
    executionId: props.executionId,
    executionData: {
      reps: formData.reps,
      sets: formData.sets,
      notes: formData.notes,
      weight: formData.weight,
      is_completed: true
    }
  })
}
</script>

