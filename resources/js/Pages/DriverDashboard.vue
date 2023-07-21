<template>
  <DriverAppLayout title="Dashboard">
    <main class="flex-1 overflow-scroll">
      <div class="flex w-full justify-between bg-purple-600 p-4">
        <Dropdown align="left" width="48">
          <template #trigger>
            <button
              v-if="$page.props.jetstream.managesProfilePhotos"
              class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-none transition"
            >
              <div class="flex">
                <img
                  class="h-10 w-10 rounded-full object-cover"
                  :src="$page.props.auth.user.profile_photo_url"
                  :alt="$page.props.auth.user.name"
                />
                <div class="text-left ml-1">
                  <p class="text-xs text-white">Hello,</p>
                  <div class="flex">
                    <span class="text-white font-semibold">
                      {{ $page.props.auth.user.name }}
                    </span>
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 24 24"
                      fill="currentColor"
                      class="w-3 h-3 text-white"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                        clip-rule="evenodd"
                      />
                    </svg>
                  </div>
                </div>
              </div>
            </button>
            <span v-else class="inline-flex rounded-md">
              <button
                type="button"
                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150"
              >
                {{ $page.props.auth.user.name }}
                <svg
                  class="ml-2 -mr-0.5 h-4 w-4"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="1.5"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M19.5 8.25l-7.5 7.5-7.5-7.5"
                  />
                </svg>
              </button>
            </span>
          </template>
          <template #content>
            <!-- Account Management -->
            <div class="block px-4 py-2 text-xs text-gray-400">Manage Account</div>
            <DropdownLink :href="route('profile.show')"> Profile </DropdownLink>
            <div class="border-t border-gray-200" />
            <!-- Authentication -->
            <form @submit.prevent="logout">
              <DropdownLink as="button"> Log Out </DropdownLink>
            </form>
          </template>
        </Dropdown>
        <div>
          <button class="relative p-1 rounded-full hover:text-purple-800 text-white">
            <span
              v-if="$page.props.unReadNoticationxCount"
              class="inline-flex absolute top-0 left-0 justify-center items-center -m-1 w-5 h-5 text-xs font-bold leading-none text-white bg-red-600 rounded-full"
            >
              {{ $page.props.unReadNoticationxCount }}
            </span>
            <a :href="route('system.notifications.index')">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="w-6 h-6"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"
                />
              </svg>
            </a>
          </button>
        </div>
      </div>

      <div class="relative h-36">
        <div
          class="bg-purple-600 h-20 absolute top-0 w-full border-b border-gray-300"
        ></div>
        <div
          class="mx-4 h-36 p-4 bg-white space-x-14 absolute top-0 inset-0 border-2 border-purple-600 rounded-lg"
        >
          <div class="flex">
            <div class="flex-1">
              <p class="text-sm text-gray-600 font-semibold">Success</p>
              <h3 class="text-2xl text-purple-600 font-semibold">
                {{ todaySuccess ?? 0 }} <span class="text-sm">Times</span>
              </h3>
              <p class="text-sm text-purple-600">On {{ date ?? null }}</p>
              <p class="text-sm text-gray-600">You 're my family to go!</p>
            </div>
            <div class="relative">
              <a
                :href="route('drivers.history.index')"
                class="absolute top-0 right-1"
                >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 24 24"
                  fill="currentColor"
                  class="w-5 h-5 text-gray-600"
                >
                  <path
                    fill-rule="evenodd"
                    d="M16.28 11.47a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 01-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 011.06-1.06l7.5 7.5z"
                    clip-rule="evenodd"
                  />
                </svg>
              </a>
              <div class="absolute top-4 right-0 w-24">
                <!-- <Pie :data="data" :options="options" /> -->
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="flex justify-between p-4">
        <button class="bg-purple-600 rounded text-sm text-white p-2 w-full mr-1">
          {{ historyUntilNow ?? 0 }} history until now
        </button>
        <button class="bg-purple-600 rounded text-sm text-white p-2 w-full">
          <span class="font-semibold">{{ orders.total }}</span>
          <span class="text-xs"> New orders</span>
        </button>
      </div>
      <div class="flex justify-between px-4">
        <div class="text-gray-600 font-semibold">Current orders</div>
        <a :href="route('stores.orders.index')" class="text-gray-400">Find a new order</a>
      </div>
      <div class="p-4">
        <div class="bg-white rounded">
          <div class="flex flex-col max-h-[410px] mb-4">
            <ul class="flex-1 overflow-scroll border-t border-gray-100">
              <li
                v-for="(item, index) in orders.data"
                key="item.order_id"
                class="flex justify-between border-b py-2 border-gray-100"
              >
                <div class="flex">
                  <img
                    :src="item.preview_url"
                    alt=""
                    class="w-10 h-10 border border-gray-100 rounded"
                  />
                  <div class="ml-2">
                    <h3 class="truncate text-xs">
                      {{ item.buyer_name }}
                      <span class="text-xs text-purple-600 font-semibold">
                        {{ item.order_sn }}
                      </span>
                    </h3>
                    <p class="text-xs text-gray-600">
                      {{ item.bayer.reciver_info.address }}
                    </p>
                  </div>
                </div>
                <div class="text-xs">
                  <div>
                    <span class="text-gray-600">Qty: </span>
                    <span class="text-gray-900 font-semibold">{{
                      item.products_sum_goods_num
                    }}</span>
                  </div>
                  <div>
                    <span class="text-gray-600">Date: </span>
                    <span class="text-gray-900 font-semibold">{{
                      item.order_date_human
                    }}</span>
                  </div>
                </div>
              </li>
              <div v-if="orders.data.length == 0">No results...</div>
            </ul>
          </div>
          <button
            class="w-full rounded p-2 border border-purple-600 hover:text-purple-600"
          >
            Confirm early
          </button>
          <button
            @click="orderMoreItem"
            class="w-full font-semibold p-2 hover:text-purple-600"
          >
            More
          </button>
        </div>
      </div>
    </main>
  </DriverAppLayout>
</template>

<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
import DriverAppLayout from "@/Layouts/DriverAppLayout.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from "chart.js";
import { Pie } from "vue-chartjs";
import * as chartConfig from "@/Stores/chartConfig.js";
ChartJS.register(ArcElement, Tooltip, Legend);
const { data } = chartConfig;

const props = defineProps({
  date: String,
  todaySuccess: String,
  historyUntilNow: String,
  orders: Object,
});

const page = ref(1);
const lastPage = ref(1);

const orderMoreItem = async () => {
  if (page.value > lastPage.value) return;
  let response = await axios.get(
    route("dashboard", {
      page: page.value++,
    })
  );
  setTimeout(() => {
    props.orders.data.push(...response.data.data);
    lastPage.value = response.data.last_page;
  }, 100);
};

const logout = () => {
  router.post(route("logout"));
};
</script>
