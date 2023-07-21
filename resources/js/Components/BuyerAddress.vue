<template>
    <div class="flex w-full">
        <img
        class="h-8 w-8 rounded-full object-cover"
        :src="preview_url"
        :alt="reciver_info.address"
      />
      <div>
      <p class="ml-6 text-xs">{{ reciver_info.address }}</p>

      <p class="ml-6 text-xs text-purple-600 flex">
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
              </svg>
            <span> {{reciver_info.mob_phone }}</span>
        </div>
        <div class="flex ml-1 items-center">
            <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="w-4 h-4"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"
            />
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"
            />
          </svg>
          <span>{{ pinpoint }}</span>
        </div>

    </p>

    </div>
    </div>
</template>

<script>
export default {
  props: {
    preview_url: String,
    reciver_info: Object,
    pinpoint: String
  },
};
</script>
