<template>
  <div>
    <div class="flex flex-col items-center justify-center p-3 min-h-full">
      <button
          @click="onToggle"
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
      >
        Create Exercise
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
              <h2 class="text-2xl font-bold py-4">Create New Exercise</h2>
              <div class="container mx-auto p-4">
                <form @submit.prevent="submitForm" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                  <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                      Exercise Name
                    </label>
                    <input v-model="formData.name"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                           id="name" type="text" placeholder="Bench Press">
                  </div>
                  <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                      Description
                    </label>
                    <textarea v-model="formData.description"
                              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                              id="description" placeholder="Laying on bench, pressing weight up"></textarea>
                  </div>
                  <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="reps_min">
                      Reps (Min-Max)
                    </label>
                    <div class="flex">
                      <input v-model="formData.reps_min"
                             class="shadow appearance-none border rounded w-1/2 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-2"
                             id="reps_min" type="number" placeholder="Min">
                      <input v-model="formData.reps_max"
                             class="shadow appearance-none border rounded w-1/2 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                             id="reps_max" type="number" placeholder="Max">
                    </div>
                  </div>
                  <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="sets_min">
                      Sets (Min-Max)
                    </label>
                    <div class="flex">
                      <input v-model="formData.sets_min"
                             class="shadow appearance-none border rounded w-1/2 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-2"
                             id="sets_min" type="number" placeholder="Min">
                      <input v-model="formData.sets_max"
                             class="shadow appearance-none border rounded w-1/2 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                             id="sets_max" type="number" placeholder="Max">
                    </div>
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
import {createExercise} from "@/helpers/ApiCalls.ts";

const formData = reactive(
    {
      notes: "",
      sets: "",
      reps: null,
      is_complete: null,
    }
)

const isOpen = ref(false)
const queryClient = useQueryClient()

const onToggle = () => {
  isOpen.value = !isOpen.value;
}

const {mutate} = useMutation({
  mutationFn: (data) => createExercise(data),
  onSuccess: (exercise) => {
    queryClient.setQueryData(['exercises'], (old) => {
      return [...old, exercise]
    });
    onToggle()
  },
})
const onSave = () => {
  mutate(formData)
}
</script>

