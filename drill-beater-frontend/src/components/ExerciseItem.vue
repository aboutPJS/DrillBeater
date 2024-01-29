<template>
  <div class="bg-white shadow-md rounded-md p-6 mx-4 my-8">
    <h2 class="text-xl font-semibold mb-4">{{ exercise.name }}</h2>
    <p class="text-gray-600 mb-4">{{ exercise.description || 'No description available' }}</p>
    <div class="flex justify-between text-sm text-gray-600">
      <div>
        <p><strong>Reps:</strong> {{ exercise.reps_min }} - {{ exercise.reps_max }}</p>
        <p><strong>Sets:</strong> {{ exercise.sets_min }} - {{ exercise.sets_max }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  exercise: {
    created_at: String,
    name: String,
    description: String | null,
    reps_min: Number,
    reps_max: Number,
    sets_min: Number,
    sets_max: Number,
  }
})

</script>