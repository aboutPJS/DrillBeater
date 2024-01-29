<template>
  <div class="pt-16">
    <h1 class="text-3xl font-semibold mb-4">Enter your phone number here</h1>
    <form v-if="!waitingOnVerification" action="#" @submit.prevent="submitPhoneNumber">
      <div class="overflow-hidden shadow sm:rounded-md max-w-sm mx-auto text-left">
        <div class="bg-white px-4 py-5 sm:p-6">
          <div>
            <input type="text" v-maska data-maska="## ###########" v-model="phoneNumber" name="phone" id="phone"
                   placeholder="49 17642933100"
                   class="mt-1 block w-full px-3 py-2 rounded-md border border-grey-300 shadow-sm"
            >
          </div>
          <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
            <button
                type="submit"
                @submit.prevent="submitPhoneNumber"
                class="inline-flex justify-center rounded-md border border-transparent bg-black py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-gray-600">
              Continue

            </button>
          </div>
        </div>
      </div>
    </form>
    <form v-else action="#" @submit.prevent="submitLoginCode">
      <div class="overflow-hidden shadow sm:rounded-md max-w-sm mx-auto text-left">
        <div class="bg-white px-4 py-5 sm:p-6">
          <div>
            <input type="text" v-maska data-maska="######" v-model="loginCode" name="phone" id="phone"
                   placeholder="123456"
                   class="mt-1 block w-full px-3 py-2 rounded-md border border-grey-300 shadow-sm"
            >
          </div>
          <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
            <button
                type="submit"
                @submit.prevent="submitLoginCode"
                class="inline-flex justify-center rounded-md border border-transparent bg-black py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-gray-600">
              Continue

            </button>
          </div>
        </div>
      </div>
    </form>
  </div>

</template>


<script setup>
import {onMounted, ref} from "vue";
import {useRouter} from "vue-router";
import {vMaska} from 'maska'
import {useMutation} from '@tanstack/vue-query'
import http from "@/helpers/http.js";
import {errorHandling, loginCall, verifyCall} from "@/helpers/ApiCalls.ts";

const waitingOnVerification = ref(false)
const phoneNumber = ref(null)
const loginCode = ref(null)
const router = useRouter()

onMounted(() => {
  if (localStorage.getItem('token')) {
    reroute()
  }
})

const login = useMutation({
  mutationFn: loginCall,
  onError: errorHandling,
})

const verify = useMutation({
  mutationFn: verifyCall,
  onError: errorHandling
})


const submitPhoneNumber = () => {
  login.mutateAsync(removeSpaces(phoneNumber.value)).then(() => {
    waitingOnVerification.value = true;
  });
};

const submitLoginCode = () => {
  verify.mutateAsync({
    phoneNumber: removeSpaces(phoneNumber.value),
    loginCode: loginCode.value,
  }).then((data) => {
    localStorage.setItem('token', data)
    reroute()
  });
};

const reroute = () => router.push({
  name: 'home'
})

const removeSpaces = (input) => {
  return input.replace(' ', '');
};
</script>
