<template>
  <main ref="scollComponent" class="flex-1 overflow-scroll">
    <div v-for="(item, index) in items" key="index">
      <slot name="item" v-bind:item="item" />
    </div>
    <div v-if="loading" class="fixed left-0 w-full bottom-10 z-50 p-4 text-center text-gray-600">{{ loadingText }}</div>
  </main>
</template>

<script>
import { ref, onMounted } from "vue";
export default {
  props: {
    items: {
      type: Array,
      required: true,
    },
    loadingText: {
      type: String,
      default: "Loading more...",
    },
  },
  setup(props, { emit }) {
    const page = ref(1);
    let scollComponent = ref();
    const loading = ref(false);

    onMounted(() => {
      scollComponent.value.addEventListener("scroll", handleScroll);
    });

    const handleScroll = (e) => {
      let element = scollComponent.value;

      if ((element.scrollTop + element.clientHeight) + 1 >= element.scrollHeight)
      {
        page.value++;
        loading.value = true;
        setTimeout(() => {
          loading.value = false;
          emit("refetch", page.value);
        }, 500);
      }
    };
    return {
      page,
      scollComponent,
      handleScroll,
      loading,
    };
  },
};
</script>
