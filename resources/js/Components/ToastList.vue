<script setup>
import ToastListItem from "@/Components/ToastListItem.vue";
import { onUnmounted, ref,computed } from "vue";

import { usePage, router } from '@inertiajs/vue3';
import toast from "@/Stores/toast";

const remove = (index) => {
  toast.remove(index);
}


const page = computed(() => usePage());

let removeFinshEventListener = router.on("finish", () => {
  if (page.value.props.toast) {
    toast.add({
      message: page.value.props.toast,
    });
  }
});

onUnmounted(() => removeFinshEventListener());

</script>
<template>
  <TransitionGroup
    tag="div"
    enter-from-class="translate-x-full opacity-0"
    enter-active-class="duration-500"
    leave-active-class="duration-500"
    leave-to-class="translate-x-full opacity-0"
    class="fixed top-4 right-4 z-50 w-full max-w-xs space-y-4"
  >
    <ToastListItem
      v-for="(item, index) in toast.items"
      :key="item.key"
      :message="item.message"
      :duration="1000"
      @remove="remove(index)"
    />
  </TransitionGroup>
</template>
