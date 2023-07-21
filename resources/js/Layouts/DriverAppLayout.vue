<template>
  <Head :title="title" />
  <Banner />
  <ToastList />
  <div
    class="flex flex-col items-center justify-center w-screen h-screen mx-auto text-base text-gray-900 bg-cool-gray-200"
  >
    <div class="relative flex flex-col flex-1 w-full overflow-hidden bg-white shadow">
      <!-- Page Heading -->
      <header v-if="$slots.header">
        <slot name="header" />
      </header>

      <!-- Page Content -->
        <slot />

      <footer className="flex border-t border-gray-200">
        <NavLink
          :href="route('dashboard')"
          :active="route().current('dashboard')"
          class="flex items-center justify-center w-1/4 py-3"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="p-px text-gray-500 w-7 h-7"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"
            />
          </svg>
        </NavLink>
        <NavLink
          :href="route('stores.orders.index')"
          :active="route().current('stores.orders.index')"
          class="flex items-center justify-center w-1/4 py-3"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="p-px text-gray-500 w-7 h-7"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"
            />
          </svg>
        </NavLink>
        <NavLink
          :href="route('drivers.history.index')"
          :active="route().current('drivers.history.index')"
          class="flex items-center justify-center w-1/4 py-3"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="p-px text-gray-500 w-7 h-7"
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
        </NavLink>
        <NavLink
          :href="route('system.notifications.index')"
          :active="route().current('system.notifications.index')"
          class="flex items-center justify-center w-1/4 py-3"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="p-px text-gray-500 w-7 h-7"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0M3.124 7.5A8.969 8.969 0 015.292 3m13.416 0a8.969 8.969 0 012.168 4.5"
            />
          </svg>
        </NavLink>
      </footer>
    </div>
    <ButtonBasket />
  </div>
</template>

<script setup>
import { ref, defineProps, onMounted, computed } from "vue";
import { Head, usePage } from "@inertiajs/vue3";

import Banner from "@/Components/Banner.vue";
import NavLink from "@/Components/NavLink.vue";
import ToastList from "@/Components/ToastList.vue";
import ButtonBasket from "@/Pages/Baskets/Partials/BasketButton.vue";

const page = computed(() => usePage());

defineProps({
  title: String,
});

onMounted(() => {
   // console.log(page.value.props.auth.user.id)
  window.Echo.private(`App.Models.User.${page.value.props.auth.user.id}`).notification((notification) => {
    switch (notification.type) {
      case "App\\Notifications\\AddToBasketNotification":
        page.value.props.unReadNoticationxCount++;

        if (notification.method == "scanout a new order") {
          page.value.props.auth.user.basketCount++;
        } else {
          page.value.props.auth.user.basketCount = 0;
        }
        break;
    }
  });
});
</script>
