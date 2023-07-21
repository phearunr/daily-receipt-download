<template>
  <div class="bg-white shadow rounded mb-2 py-2 px-3 my-2 mx-1">
    <div class="flex flex-row">
      <label class="text-xs">Order no: </label>
      <span class="ml-1 text-xs font-semibold"> {{ item.order_sn }}</span>
      <div
        @click="copyMe(item.order_sn)"
        class="ml-1 p-[1px] rounded border bg-gray-50 text-red-600 border-gray-300 active:bg-red-600 focus:outline-none focus:ring focus:ring-red-300"
      >
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
            d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5A3.375 3.375 0 006.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0015 2.25h-1.5a2.251 2.251 0 00-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5a9 9 0 00-9-9z"
          />
        </svg>
      </div>
    </div>
    <details class="group">
      <summary
        class="list-none flex flex-wrap items-center cursor-pointer focus-visible:outline-none focus-visible:ring focus-visible:ring-purple-500 rounded group-open: rounded-b-none group-open:z-[1] relative"
      >
        <ul class="flex flex-1">
          <li>
            <div>
              <div class="flex flex-row">
                <div>
                  <label class="text-xs">Order date: </label>
                  <span class="text-xs font-semibold"> {{ item.order_date }}, <span class=" text-purple-900">{{ item.order_state  }} </span> </span>
                </div>
              </div>
            </div>
          </li>
        </ul>

        <div class="flex items-center justify-center">
          <div
            class="border-8 border-transparent border-l-gray-600 ml-2 group-open:rotate-90 transition-transform origin-left"
          ></div>
        </div>
      </summary>

      <ul class="rounded-md bg-gray-50 p-2 mt-2 border border-gray-100">
        <li
          v-for="(product, index) in item.order_items"
          key="item.goods_id"
          class="flex space-x-4 mb-2"
        >
          <ProductBasket :currency="item.currency" :product="product" />
        </li>
      </ul>
    </details>
    <div class="border-b border-gray-100 h-2 mb-2"></div>
    <div>
      <ul class="text-xs">
        <li class="flex flex-row justify-between">
          <span class="text-gray-600">Total Items:</span>
          <span class="font-semibold"> {{ item.total_quantity ?? 0 }} </span>
        </li>
        <li class="flex flex-row justify-between">
          <span class="text-gray-600">Total Price:</span>
          <span class="font-semibold"
            >{{ item.total_price ?? 0 }} {{ item.currency ?? null }}</span
          >
        </li>
        <li class="flex flex-row justify-between">
          <span class="text-gray-600">Deliver fee:</span>
          <span class="font-semibold">{{ item.delivery_fee }} {{ item.currency }}</span>
        </li>
        <!-- <li class="flex flex-row justify-between">
            <span class="text-gray-600">Exchange Rate 1$:</span>
            <span class="font-semibold"
              >{{ item.riel_currency_rate ?? 0 }} {{ item.curruncy_riel  ?? null }}</span
            >
          </li> -->
      </ul>
    </div>
    <div class="border-b border-gray-100 h-2 mb-2"></div>
    <div>
      <ul class="text-xs">
        <li class="flex flex-row justify-between">
          <span class="text-[#635b90]">Grand Total:</span>
          <span class="font-semibold">
            {{ item.grand_total_price }} {{ item.currency ?? null }}</span
          >
        </li>
        <li class="flex flex-row justify-between">
            <!-- <span class="text-[#635b90]">Grand Total Riel:</span> -->
            <span></span>
            <span class="font-semibold text-gray-600 text-[9px]"
              >{{ item.grand_total_riel }} {{ item.curruncy_riel ?? null }}</span
            >
          </li>
      </ul>
    </div>
    <div class="border-b border-gray-100 h-2 mb-2"></div>
    <div class="flex justify-between">
      <div></div>
      <div class="flex-1"></div>
      <div>
        <div class="ml-3 relative">
            <Dropdown align="right" width="48">
                <template #trigger>
                    <span  class="inline-flex rounded-md">
                        <button type="button" class="inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none  transition ease-in-out duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="ml-2 -mr-0.5 h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                            </svg>
                        </button>
                    </span>
                </template>

                <template #content>
                    <!-- Account Management -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        Manage Recipe
                    </div>
                    <DropdownLink
                        :href="route('stores.orders.download',{
                            order_id:item.order_id,
                            rate: item.riel_currency_rate,
                            store_id: item.store_id
                        })"
                        as="a"
                    >
                        Download
                    </DropdownLink>
                    <div class="border-t border-gray-200" />
                    <DropdownLink @click="addToBasket(item.order_id)" as="button">
                            Add to Basket
                    </DropdownLink>

                </template>
            </Dropdown>
        </div>
    </div>

    </div>
  </div>
</template>

<script setup>
import { usePage, router } from '@inertiajs/vue3';
import { userPermission } from "@/Composables/Permissions";
import ProductBasket from "@/Pages/Baskets/Partials/ProductBasket.vue";
import toast from "@/Stores/toast";
//import { computed } from "vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
//let { hasBasketCount } = userPermission();
const page = usePage();

const props = defineProps({
  item: Object,
});

const copyMe = (textCopy) => {
  navigator.clipboard.writeText(textCopy);
  console.log(copyMe);
};

const addToBasket = (order_id) => {
  axios
    .post(route("baskets.users.store"), {
      order_id: order_id,
    })
    .then((response) => {
      if (response.data.errors) {
        addToast(response.data.errors.order_id[0]);
      } else {
        addToast(response.data.success);
       // page.props.value.auth.user.basketCount++;
       // console.log(page.props.value)
      }
    })
    .catch((error) => {
      console.log(error);
    });
};

const addToast = (textMessage) => {
  toast.add({
    message: textMessage ?? "msg",
  });
};
</script>
