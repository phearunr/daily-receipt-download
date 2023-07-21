<template>
  <div class="overflow-hidden border border-gray-100 flex-shrink-0 w-16 h-16 bg-gray-100 rounded lg:w-16 lg:h-16">
    <img :src="product.product_image" class="object-cover" />
  </div>
  <div>
    <span class="text-sm font-semibold text-gray-600 break-all rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
      {{ product.product_name }}
    </span>
    <!-- <p class="text-xs text-gray-500 break-all">
      Barcode: <span class="text-gray-600  font-semibold">{{ product.parrent_product[0].bar_code  ?? null}}</span>
    </p> -->
    <p class="text-xs text-gray-500 break-all">
      Unit Price: <span class="text-gray-600 font-semibold">{{ product.product_price }}{{ currency }} x {{ product.order_quantity }}</span>
    </p>
  </div>
</template>

<script setup>
const props = defineProps({
  product: Object,
  currency: String,
});
</script>
