<template>
  <DriverAppLayout title="Orders">
    <template #header>
      <div class="flex justify-between items-center px-4 py-3 border-b">
        <UserProfile title="Orders" />
        <div class="flex">
          <OrderSearchModal />
        </div>
      </div>
    </template>
    <div class="flex flex-row justify-between p-2 items-center border-b">
      <div id="overflow-x-auto" class="flex gap-2 overflow-x-auto">
        <button
          v-for="(item, index) in order_status"
          key="index"
          class="py-1 px-3 text-sm outline-none focus:rounded-3xl"
          @click="activeItem(index, item.value)"
          :class="{
            'bg-purple-600 text-white font-semibold rounded-3xl': index == selectedItem,
          }"
        >
          <span>
            {{ item.label }}
          </span>
        </button>
      </div>
      <div class="pl-1 w-28 text-right">
        <div class="flex items-center">
          <select
            v-model="query.rate"
            @change="exchangeRate()"
            class="text-gray-500 text-center text-[10px] font-semibold focus:outline-none ring-0 h-6 p-0 w-full border-0 focus:ring-0 focus:border-none"
          >
            <option v-for="(option, index) in rates">{{ option.label }}</option>
          </select>
          <label class="text-[10px] text-right" for="khr"> khr </label>
        </div>
        <p class="text-purple-900 font-semibold text-xs">Total: {{ items.meta.total }}</p>
      </div>
    </div>

    <div class="p-2 flex-1 text-center" v-if="items.data.length == 0">
      <span> No results...</span>
    </div>
    <InfiniteScroll v-else :items="items.data" @refetch="fetch" loadingText="loading...">
      <template v-slot:item="{ item }">
        <Basket :item="item" />
      </template>
    </InfiniteScroll>
  </DriverAppLayout>
</template>

<script setup>
import axios from "axios";
import { pickBy } from "lodash";
import { ref, defineProps } from "vue";
import { router } from "@inertiajs/vue3";
import DriverAppLayout from "@/Layouts/DriverAppLayout.vue";
import InfiniteScroll from "@/Components/InfiniteScroll.vue";
import UserProfile from "@/Components/UserProfile.vue";
import OrderSearchModal from "@/Pages/Orders/Partials/OrderSearchModal.vue";
import Basket from "@/Pages/Baskets/Partials/Basket.vue";

const props = defineProps({
  items: Object,
  order_status: Object,
  rates: Object,
  queryParams: Object,
});

const rate = ref(4000);

const selectedItem = ref(0);
const item_order_stage = ref(0);
const target = ref("scroll");

const query = ref({
  status: props.queryParams.status,
  term: props.queryParams.term,
  store: props.queryParams.store,
  rate: props.queryParams.rate,
});

const exchangeRate = () => {
  filter();
};

const activeItem = (index, item_order_status) => {
  selectedItem.value = index;
  query.value.status = item_order_status;

  filter();
};

const lastPage = ref(props.items.meta.last_page);

const fetch = async (page) => {
  if (page > lastPage.value) return;
  let response = await axios.get(
    route("stores.orders.index", {
      page: page,
      status: query.value.status,
      rate: query.value.rate,
    })
  );
  setTimeout(() => {
    props.items.data.push(...response.data.data);
    props.items.meta.total = response.data.meta.total;
  }, 100);
};

const filter = () => {
  router.get(route("stores.orders.index"), pickBy(query.value), {
    preserveState: true,
  });
};
</script>
