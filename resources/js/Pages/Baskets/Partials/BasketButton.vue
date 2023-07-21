<template>
  <button
  v-if="$page.props.auth.user.basketCount"
    @click="setIsOpen(true)"
    class="fixed right-4 bottom-8 p-2 bg-purple-900 rounded-full hover:bg-purple-800"
  >
    <span

      class="inline-flex absolute top-0 left-0 justify-center items-center -m-1 w-4 h-4 text-xs font-bold leading-none text-white bg-red-600 rounded-full"
    >
     {{ $page.props.auth.user.basketCount }}
    </span>

    <svg
      xmlns="http://www.w3.org/2000/svg"
      class="w-6 h-6 text-white"
      fill="none"
      viewBox="0 0 24 24"
      stroke="currentColor"
    >
      <path
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="2"
        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
      />
    </svg>
  </button>

  <TransitionRoot appear as="template" :show="isOpen">
    <Dialog
      :initialFocus="checkoutButtonRef"
      class="overflow-hidden fixed inset-0 z-10"
      :open="isOpen"
      @close="setIsOpen"
    >
      <TransitionChild
        enter="transition-opacity ease-in-out duration-300"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="transition-opacity ease-in-out duration-300"
        leave-from="opacity-100"
        leave-to="opacity-0"
        as="template"
      >
        <DialogOverlay class="absolute inset-0 bg-purple-300 bg-opacity-40" />
      </TransitionChild>

      <TransitionChild
        enter="transform ease-in-out transition-transform duration-300"
        enter-from="translate-x-full"
        enter-to="translate-x-0"
        leave="transform ease-in-out transition-transform duration-300"
        leave-from="translate-x-0"
        leave-to="translate-x-full"
        as="template"
      >
        <div class="flex flex-col fixed inset-y-0 right-0 w-full max-w-sm bg-white">
          <div class="flex justify-between items-center p-4 shadow">
            <DialogTitle class="text-xl font-bold">Basket</DialogTitle>
            <BarcodeSearchVerifyModal
                @reloadBasket="refesh()"
            />
            <button
              @click="setIsOpen(false)"
              class="p-1 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-6 h-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
            </button>
          </div>

          <div class="flex-1 flex flex-col">
            <div class="flex-1 relative">
              <div class="absolute inset-0 overflow-y-scroll">
                <div class="flex flex-col divide-y divide-gray-100">
                  <div
                    v-for="(order, orderIndex) in results"
                    key="orderIndex"
                    >
                  <div
                    v-for="(item, itemIndex) in order.order_items"
                    :key="itemIndex"
                    class="flex p-4 space-x-4"
                  >
                    <div class="flex flex-col w-24">
                      <img
                        class="mb-0.5"
                        :src="item.goods_image"
                        :alt="item.product_name"
                      />
                    </div>
                    <div>
                      <div class="text-xs font-semibold leading-tight">
                        {{ item.product_name }}: {{ item.bar_code }}
                      </div>
                      <div class="mt-2 text-gray-800 leading-normal text-sm">
                        {{ item.order_quantity }} x {{ item.currency
                        }}{{ item.product_price }} = {{ item.currency
                        }}{{ item.total_price }}
                      </div>
                      <div
                        class="flex items-center mt-2 text-gray-800 leading-normal text-sm"
                      >
                        <input
                          @change="status_dropoff(orderIndex, itemIndex)"
                          v-model="item.drop_quantity"
                          type="number"
                          class="border border-gray-200 h-6 w-12 px-0 text-center"
                        />
                        <button>
                          <svg
                            v-if="item.drop_status == 0"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-6 h-6 text-red-600"
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
                            class="w-6 h-6 text-purple-600"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M4.5 12.75l6 6 9-13.5"
                            />
                          </svg>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                </div>
              </div>
            </div>

            <div class="py-6 px-4 bg-gray-50">
              <div class="flex justify-between">
                <div class="text-center font-semibold">Total Dropoffs</div>
                <div class="text-center font-semibold">
                  {{ total_dropoffs }}
                </div>
              </div>
              <div class="flex justify-between">
                <div class="text-center font-semibold text-gray-600">Total Orders</div>
                <div class="text-center font-semibold">{{ total_orders }}</div>
              </div>

              <div class="flex flex-col space-y-2 mt-4">
                <button
                  class="bg-purple-600 p-3 text-white rounded-full hover:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple"
                  ref="checkoutButtonRef"
                  @click="confirm()"
                >
                  Confirm
                </button>
                <button
                  class="p-3 bg-white text-gray-500 hover:text-black rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-300"
                  @click="setIsOpen(false)"
                >
                  Continue confirm
                </button>
              </div>
            </div>
          </div>
        </div>
      </TransitionChild>
    </Dialog>
  </TransitionRoot>
</template>

<script>

import { nextTick, reactive, ref, computed, onUnmounted } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import axios from "axios";
import { debounce } from "lodash";
import toast from "@/Stores/toast";

import {
  Dialog,
  DialogDescription,
  DialogOverlay,
  DialogTitle,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";
import { userPermission } from "@/Composables/Permissions";
import BarcodeSearchVerifyModal from '@/Pages/Baskets/BarcodeSearchVerifyModal.vue';

export default {
  components: {
    Dialog,
    DialogOverlay,
    DialogTitle,
    DialogDescription,
    TransitionRoot,
    TransitionChild,
    BarcodeSearchVerifyModal
  },

  setup() {

    let isOpen = ref(false);
    let checkoutButtonRef = ref(null);
    let { hasBasketCount } = userPermission();

    const form = reactive({
      latitude: null,
      longitude: null,
      pinpoint: null,
      items: null,
    });

    const results = ref([]);
    const resultsRefs = ref([]);
    const selectedIndex = ref(0);

    const refesh = () =>  {
        search()

    }

    const search = debounce(async (term) => {

      let { data } = await axios.get(route("baskets.users.index"), {
        params: { term: term },
      });

      results.value = data;
      await nextTick();
      resultsRefs.value = [];

    }, 250);

    const status_dropoff = (orderIndex, itemIndex) => {
      let drop_quantity = results.value[orderIndex].order_items[itemIndex].drop_quantity;
      let order_quantity = results.value[orderIndex].order_items[itemIndex].order_quantity;
      return (results.value[orderIndex].order_items[itemIndex].drop_status = order_quantity == drop_quantity ? 1 : 0);
    };

    const total_dropoffs = computed(() => {
      let total = 0;
      results.value.map((order,orderIndex ) => {
        order.order_items.map((item, itemIndex) => {
            total += item.drop_quantity;
            status_dropoff(orderIndex, itemIndex)
        });

      });
      return total;
    });

    const total_orders = computed(() => {
      let total = 0;
      results.value.map((order) => {
        order.order_items.map((item) => {
            total += item.order_quantity;
        });
      });
      return total;
    });

    const locatorButtonPressed = () => {
      navigator.geolocation.getCurrentPosition(
        (position) => {
          form.latitude = position.coords.latitude;
          form.longitude = position.coords.longitude;
          form.pinpoint = [position.coords.latitude, position.coords.longitude];
          form.orders = results.value;
        },
        (error) => {
          return false;
          // console.log(error.message);
        }
      );
    };

    const confirm = async () => {

      locatorButtonPressed();

      axios
        .put(route("baskets.users.confirm", 1), {
          latitude: form.latitude,
          longitude: form.longitude,
          pinpoint: form.pinpoint,
          orders: form.orders,
        })
        .then((response) => {
          if (response.data.errors) {
            addToast(response.data.errors.pinpoint[0]);
          } else {
            addToast(response.data.success);
            search();
            form.reset("orders", "pinpoint", "latitude", "longitude");
            // console.log(response.data);
          }
        })
        .catch((error) => {
          // console.log(error);
        });
    };

    const addToast = (textMessage) => {
      toast.add({
        message: textMessage ?? "msg",
      });
    };

    return {
      locatorButtonPressed,
      checkoutButtonRef,
      isOpen,
      setIsOpen(value) {
        isOpen.value = value;
        search();
      },
      hasBasketCount,
      search,
      refesh,
      results,
      status_dropoff,
      total_orders,
      total_dropoffs,
      form,
      confirm,
      addToast,

    };
  },
};
</script>
