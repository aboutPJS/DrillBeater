<script setup>
import {RouterView} from 'vue-router'
import { VueQueryDevtools } from '@tanstack/vue-query-devtools'

</script>

<template>
  <div class="min-h-screen bg-grey-100 text-center antialiased">
    <RouterView/>
  </div>
  <VueQueryDevtools />

</template>
