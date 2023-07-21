<template>
  <DriverAppLayout title="History">
    <template #header>
      <div class="flex justify-between items-center px-4 py-3 border-b">
        <UserProfile title="History" />
      </div>
    </template>
    <div class="p-2 flex-1 text-center " v-if="items.data.length == 0">
        <span> No results...</span>
    </div>
    <InfiniteScroll
        v-else
        :items="items.data"
        @refetch="fetch"
        loadingText="loading..."
    >
      <template v-slot:item="{ item }">
        <Basket :item="item" />
      </template>
    </InfiniteScroll>

  </DriverAppLayout>
</template>

<script setup>
import DriverAppLayout from "@/Layouts/DriverAppLayout.vue";
import UserProfile from "@/Components/UserProfile.vue";
import InfiniteScroll from "@/Components/InfiniteScroll.vue";
import Basket from "@/Pages/Baskets/Partials/BasketDrop.vue";
import { ref, defineProps } from "vue";

const props = defineProps({
  items: Object,
});

const lastPage = ref(props.items.meta.last_page);

const fetch = async (page) => {
  if (page > lastPage.value) return;
  let response = await axios.get(
    route("drivers.history.index", {
      page: page,
    })
  );
  setTimeout(() => {
    props.items.data.push(...response.data.data);
  }, 100);
};
</script>
