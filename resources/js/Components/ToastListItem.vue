<script setup>
import {onMounted} from "vue";

const props = defineProps({
  message: String,
  duration: {
    type: Number,
    default: 2000
  }
});

onMounted(() => {
  setTimeout(() => emit("remove"), props.duration);
});

const emit = defineEmits(["remove"]);
</script>
<template>
  <div
    class="flex items-center rounded-lg bg-white p-2 z-50 text-gray-500 shadow dark:bg-gray-800 dark:text-gray-400"
    role="alert"
  >
    <div
      class="inline-flex h-4 w-4 flex-shrink-0 items-center justify-center rounded-lg bg-blue-100 text-blue-500 dark:bg-blue-800 dark:text-blue-200"
    >
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
      </svg>
      <span class="sr-only">Fire icon</span>
    </div>
    <div class="ml-3 text-xs truncate font-normal">{{ props.message }}</div>
    <button
      @click="emit('remove')"
      type="button"
      class="-mx-1.5 -my-1.5 ml-auto inline-flex h-8 w-8 rounded-lg bg-white p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-900 focus:ring-2 focus:ring-gray-300 dark:bg-gray-800 dark:text-gray-500 dark:hover:bg-gray-700 dark:hover:text-white"
      data-dismiss-target="#toast-default"
      aria-label="Close"
    >
      <span class="sr-only">Close</span>
      <svg
        aria-hidden="true"
        class="h-5 w-5"
        fill="currentColor"
        viewBox="0 0 20 20"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          fill-rule="evenodd"
          d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
          clip-rule="evenodd"
        ></path>
      </svg>
    </button>
  </div>
</template>
