<template>
  <DriverAppLayout title="Notifications">
    <template #header>
      <div class="flex justify-between items-center px-4 py-3 border-b">
        <UserProfile title="Notifications" />
      </div>
    </template>
    <div
        class="p-2 flex-1 text-center"
        v-if="items.data.length == 0">
        <span> No results...</span>
    </div>
    <InfiniteScroll
        v-else
        :items="items.data"
        @refetch="fetch"
        loadingText="loading..."
    >
      <template v-slot:item="{ item }">
        <div class="bg-white shadow rounded mb-2 py-2 px-3 my-2 mx-1">
          <div class="flex flex-row justify-between">
            <div class="flex-1 flex">
              <img
                :src="item.data.user.profile_photo_url"
                :alt="item.data.user.name"
                class="w-11 h-11"
              />
              <div class="ml-2">
                <p class="text-xs text-purple-600">
                  @{{ item.data.user.name }}
                  <span class="text-gray-600 font-semibold">
                    {{ item.data.method }}:
                  </span>
                </p>
                <p class="text-[10px] text-purple-900 font-medium">
                  {{ item.data.order_drop.order_sn }}
                </p>
                <p class="text-gray-600 text-[9px]">
                  {{ item.created_at }}
                </p>
              </div>
            </div>
            <div class="text-gray-400">
              <p class="flex items-center">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="1.5"
                  stroke="currentColor"
                  class="w-3 h-3"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M4.5 12.75l6 6 9-13.5"
                  />
                </svg>
                <span class="ml-1 text-[8px]">{{ item.read_at }}</span>
              </p>
            </div>
          </div>
        </div>
      </template>
    </InfiniteScroll>
  </DriverAppLayout>
</template>

<script setup>

import axios from "axios";
import { ref, defineProps } from "vue";
import DriverAppLayout from "@/Layouts/DriverAppLayout.vue";
import UserProfile from "@/Components/UserProfile.vue";
import InfiniteScroll from "@/Components/InfiniteScroll.vue";

const props = defineProps({
  items: Object,
});

const lastPage = ref(props.items.last_page);

const fetch = async (page) => {
  if (page > lastPage.value) return;
  let response = await axios.get(
    route("system.notifications.index", {
      page: page,
    })
  );
  setTimeout(() => {
    props.items.data.push(...response.data.data);
  }, 100);
};
</script>
