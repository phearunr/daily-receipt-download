<template>
  <AppLayout title="Users">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Users</h2>
    </template>
    <div>
      <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <section
          class="flex flex-col p-4 mb-4 space-y-4 bg-white shadow sm:rounded lg:flex-row lg:items-center lg:justify-between lg:space-y-0 lg:p-2"
        >
          <div class="flex flex-col space-y-4 sm:flex-row sm:space-y-0 sm:space-x-2">
            <select
              v-model="query.month"
              aria-label="Media date"
              id="date"
              class="pr-10 pl-3 w-full h-11 rounded border-gray-300 shadow-sm lg:h-9 lg:text-sm sm:w-44 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            >
              <option v-for="month in allMonths" :value="month.value">
                {{ month.label }}
              </option>
            </select>

            <button
              @click="filter()"
              type="button"
              class="inline-flex items-center px-4 h-11 font-medium text-gray-700 bg-white rounded border border-gray-300 shadow-sm lg:h-9 lg:text-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
              Filter
            </button>
          </div>

          <div class="flex flex-col">
            <label for="search" class="text-sm font-medium text-gray-700 sr-only"
              >Search</label
            >
            <input
              v-model="query.term"
              @keydown.enter="filter()"
              type="search"
              id="search"
              class="w-full h-11 rounded border-gray-300 shadow-sm lg:h-9 lg:text-sm lg:w-64 focus:ring-blue-500 focus:border-blue-500"
              placeholder="Search for..."
              autocomplete="off"
            />
          </div>
        </section>

        <section
          class="flex flex-col items-center space-y-4 mb-4 md:space-y-0 md:flex-row md:justify-between"
        >
          <div class="flex flex-row space-x-2">
            <select-action

              :actions="actions"
              @execute="executeAction"
            >
            </select-action>
            <a
              :href="route('system.users.create')"

              class="inline-flex items-center px-4 h-11 font-medium text-gray-700 bg-white rounded border border-gray-300 shadow-sm lg:h-9 lg:text-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="w-4 h-4"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"
                />
              </svg>
            </a>
          </div>
          <pagination :pagination="entries.meta"></pagination>
        </section>

        <section class="mb-4">
          <table class="min-w-full bg-white shadow table-fixed sm:rounded">
            <thead>
              <tr class="border-b border-gray-200">
                <th class="px-2 w-10 text-center">
                  <input
                    type="checkbox"
                    @change="toggleSelectAll"
                    class="w-6 h-6 text-blue-600 rounded border-gray-300 lg:w-4 lg:h-4 focus:ring-blue-500"
                  />
                </th>
                <th class="text-left">
                  <span
                    class="flex relative z-10 items-center p-2 space-x-2 font-normal text-blue-600 group lg:text-sm focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-blue-500"
                  >
                    Name
                  </span>
                </th>
                <th class="hidden text-left lg:table-cell">
                  <span class="inline-block p-2 font-normal text-blue-600 lg:text-sm">
                    Roles
                  </span>
                </th>

                <th class="hidden w-28 text-left lg:table-cell">
                  <span
                    class="flex relative z-10 items-center p-2 space-x-2 font-normal text-blue-600 group lg:text-sm focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-blue-500"
                  >
                    Status
                  </span>
                </th>
                <th class="hidden w-32 text-left lg:table-cell">
                  <span class="p-2 font-normal text-blue-600 lg:text-sm">
                    Last login at
                  </span>
                </th>
                <th class="hidden w-32 text-left lg:table-cell">
                  <span
                    class="flex relative z-10 items-center p-2 space-x-2 font-normal text-blue-600 group lg:text-sm focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-blue-500"
                  >
                    Date
                  </span>
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
              <tr
                class="align-top group"
                v-for="(entry, index) in entries.data"
                :key="entry.id"
              >
                <td class="p-2 w-10 text-center">
                  <input
                    type="checkbox"
                    v-model="entry.selected"
                    class="w-6 h-6 text-blue-600 rounded border-gray-300 lg:w-4 lg:h-4 focus:ring-blue-500"
                  />
                </td>
                <td class="p-2 text-left">
                  <div class="flex space-x-4">
                    <div
                      class="overflow-hidden flex-shrink-0 w-12 h-12 bg-gray-100 rounded lg:w-16 lg:h-16"
                    >
                      <img :src="entry.profile_photo_url" class="object-cover" />
                    </div>
                    <div>
                      <span
                        class="text-sm font-semibold text-blue-600 break-all rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                      >
                        {{ entry.name }}
                      </span>
                      <p class="text-xs text-gray-500 break-all">
                        {{ entry.email }}
                      </p>
                      <p class="text-xs text-blue-400 break-all">
                        Verified_at: {{ entry.email_verified_at }}
                      </p>

                      <div
                        class="flex items-center mt-2 space-x-2 md:invisible group-hover:visible"
                      >
                        <Link
                          :href="route('system.users.edit', entry.id)"
                          class="text-xs text-blue-600 rounded hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                          Edit
                        </Link>
                        <span class="text-xs text-gray-300">|</span>
                        <button
                          @click="deleteEnty(entry.id)"
                          class="text-xs text-red-600 rounded hover:text-red-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                          Delete
                        </button>
                      </div>
                    </div>
                  </div>
                </td>
                <td class="hidden p-2 text-left lg:table-cell">
                  <a
                    href="#"
                    class="text-blue-600 rounded lg:text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                  >
                    {{ entry.role ?? null }}
                  </a>
                </td>
                <td class="hidden p-2 text-left lg:table-cell">
                  <a
                    href="#"
                    class="text-blue-600 rounded lg:text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                  >
                    {{ entry.status }}
                  </a>
                </td>
                <td class="hidden p-2 text-left lg:table-cell">
                  <span class="text-gray-600 lg:text-sm">
                    {{ entry.last_activity_at ?? null }}
                  </span>
                </td>
                <td class="hidden p-2 text-left lg:table-cell">
                  <span class="text-gray-600 lg:text-sm">
                    {{ entry.created_at }}
                  </span>
                </td>
              </tr>

              <tr class="align-top" v-if="!entries.data.length">
                <td colspan="4" class="p-2 text-sm text-gray-700">
                  No items found.
                </td>
              </tr>
            </tbody>
          </table>
        </section>

        <section
          class="flex flex-col items-center space-y-4 mb-4 md:space-y-0 md:flex-row md:justify-between"
        >
          <select-action :actions="actions" @execute="executeAction"></select-action>
          <pagination :pagination="entries.meta"></pagination>
        </section>
      </div>
    </div>
  </AppLayout>
</template>
<script>

import { pickBy } from 'lodash';
import AppLayout from "@/Layouts/AppLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import SelectAction from "@/Components/SelectAction.vue";
import {Link} from '@inertiajs/vue3'

export default {
  components: {
    AppLayout,
    Pagination,
    SelectAction,
    Link
  },
  props: {
    entries: Object,
    months: Array,
    queryParams: Object,
  },
  data() {
    return {
      actions: [
        { id: null, label: "Bulk actions" },
        { id: "delete", label: "Delete" },
       // { id: "export-to-xlsx", label: "Export .xlsx" },
      ],
      query: {
        status: this.queryParams.status,
        term: this.queryParams.term,
        role: this.queryParams.role,
        month: this.queryParams.month,
      },
    };
  },
  methods: {
    deleteEnty(entryId) {
      if (confirm(`Are you sure?`)) {
        this.$inertia.delete(route("system.users.destroy"), {
          preserveState: false,
          data: {
            entryIds: [entryId],
          },
        });
      }
    },
    toggleSelectAll(e) {
      this.entries.data.forEach((entry) => (entry.selected = e.target.checked));
    },
    executeAction(actionId) {
      const entryIds = this.entries.data
        .filter((entry) => entry.selected)
        .map((entry) => entry.id);
      if (!entryIds.length) return;

      switch (actionId) {
        case "delete":
          if (confirm(`Are you sure?`)) {
            this.$inertia.delete(route("system.users.destroy"), {
              preserveState: false,
              data: {
                entryIds: entryIds,
              },
            });
          }
          break;

        // case "export-to-xlsx":
        //   if (confirm(`Are you wish bulk items to .xlsx with selected?`)) {
        //     window.open(
        //       `/accounts/users/export/bulk-action?entryIds=${entryIds}`,
        //       "_blank"
        //     );
        //   }
        //   break;
      }
    },
    filter() {
      this.$inertia.get(route("system.users.index"), pickBy(this.query), {
        preserveState: true,
      });
    },
  },
  computed: {
    allMonths() {
      return [{ value: null, label: "Any date" }, ...this.months];
    },
  },
};
</script>
