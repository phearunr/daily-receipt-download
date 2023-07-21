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
    <p class="text-sm text-gray-500 break-all">
      Unit Price: <span class="text-gray-600 font-semibold">{{ product.product_price }}{{ currency }} x {{ product.order_quantity }}</span>
    </p>
    <p class="text-sm text-gray-500 break-all flex items-center">
        Drop Quantity: <span class="text-gray-600 font-semibold"> {{ product.drop_quantity }}</span>
        <button class="ml">
            <svg
              v-if="product.drop_status == 0"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor"
              class="w-5 h-5 text-red-600"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M6 18L18 6M6 6l12 12"
              />
            </svg>
            <svg
              v-else
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor"
              class="w-5 h-5 text-purple-600"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M4.5 12.75l6 6 9-13.5"
              />
            </svg>
          </button>
      </p>
  </div>
</template>

<script setup>
const props = defineProps({
  product: Object,
  currency: String,
});
</script>
