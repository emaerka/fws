<template>
  <!-- This example requires Tailwind CSS v2.0+ -->
  <div class="px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center">
      <div class="sm:flex-auto">
        <h1 class="text-xl font-semibold text-gray-900">Projects</h1>
        <p class="mt-2 text-sm text-gray-700">A list of all the projects.</p>
      </div>
      <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
        <Link
          :href="$route('projects.create')"
          class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto"
          >Add project</Link
        >
      </div>
    </div>
    <div class="mt-8">
      <div class="mt-1 sm:mt-0 sm:col-span-2">
        <form>
          <fieldset class="space-x-5 flex justify-end">
            <div class="relative flex items-start" v-for="s in status" :key="s.value">
              <div class="flex items-center h-5">
                <input
                  :id="'status_' + s.value"
                  name="status"
                  type="checkbox"
                  :value="s.value"
                  v-model="form.status"
                  class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"
                />
              </div>
              <div class="ml-3 text-sm">
                <label :for="'status_' + s.value" class="font-medium text-gray-700">{{
                  s.name
                }}</label>
              </div>
            </div>
          </fieldset>
        </form>
      </div>
    </div>
    <div class="mt-8 flex flex-col">
      <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
          <div
            class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg"
          >
            <table class="min-w-full divide-y divide-gray-300">
              <thead class="bg-gray-50">
                <tr>
                  <th
                    scope="col"
                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                  >
                    Name
                  </th>
                  <th
                    scope="col"
                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                  >
                    Status
                  </th>
                  <th
                    scope="col"
                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                  >
                    Contact People
                  </th>
                  <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                    <span class="sr-only">Edit</span>
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white">
                <tr
                  v-for="(project, projectId) in projects.data"
                  :key="project.id"
                  :class="projectId % 2 === 0 ? undefined : 'bg-gray-50'"
                >
                  <td
                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                  >
                    {{ project.name }}
                  </td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                    {{ project.status }}
                  </td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                    {{ project.contact_people_count }}
                  </td>
                  <td
                    class="relative whitespace-nowrap flex py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"
                  >
                    <a
                      :href="$route('projects.show', { project: project.id })"
                      class="text-indigo-600 hover:text-indigo-900"
                      >Edit</a
                    >
                    <button
                      class="text-indigo-600 hover:text-indigo-900 ml-2"
                      @click="deleteProject(project.id)"
                    >
                      Delete
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div
      class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6"
    >
      <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
        <div>
          <p class="text-sm text-gray-700">
            Showing
            {{ " " }}
            <span class="font-medium">{{ projects.meta.from }}</span>
            {{ " " }}
            to
            {{ " " }}
            <span class="font-medium">{{ projects.meta.to }}</span>
            {{ " " }}
            of
            {{ " " }}
            <span class="font-medium">{{ projects.meta.total }}</span>
            {{ " " }}
            results
          </p>
        </div>
        <div v-if="projects.meta.total > 10">
          <nav
            class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
            aria-label="Pagination"
          >
            <a
              v-for="(link, index) in projects.meta.links"
              :key="index"
              :href="link.url"
              aria-current="page"
              :class="{
                'z-10 bg-indigo-50 border-indigo-500 text-indigo-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium':
                  link.active,
                'relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50': !link.active,
              }"
            >
              <span v-html="link.label"></span>
            </a>
          </nav>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Inertia } from "@inertiajs/inertia";
import { watch } from "vue";
import throttle from "lodash/throttle";
import { useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
  projects: Array,
  status: Array,
  filter: Array,
});

let form = useForm({
  status: props.filter ?? [],
});

watch(
    form,
    throttle(function (value) {
        request();
    }, 300)
);

function request() {
  Inertia.get(
    route('projects.index'),
    { filter: form.status},
    { preserveState: true, replace: true, preserveScroll: true, }
  );
}

const deleteProject = (projectId) => {
  Inertia.delete(route("projects.delete", { project: projectId }), {});
};
</script>
