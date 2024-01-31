<script setup>
import {RouterView} from 'vue-router'
import { VueQueryDevtools } from '@tanstack/vue-query-devtools'

</script>

<template>
  <div class="container-md">
    <RouterView/>
  </div>
  <VueQueryDevtools />
</template>
