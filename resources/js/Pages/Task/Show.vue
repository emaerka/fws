<template>
  <form class="space-y-8 divide-y divide-gray-200" @submit.prevent="submitForm">
    <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">
      <div>
        <div>
          <h3 class="text-lg leading-6 font-medium text-gray-900">Project</h3>
          <p class="mt-1 max-w-2xl text-sm text-gray-500">
            Information about the project
          </p>
        </div>
        <div class="space-y-6 sm:space-y-5">
          <!-- NAME -->
          <div
            class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
          >
            <label
              for="name"
              class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"
            >
              Name *</label
            >
            <div class="mt-1 sm:mt-0 sm:col-span-2">
              <input
                v-model="form.name"
                required
                type="text"
                name="name"
                id="name"
                autocomplete="name"
                class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md"
              />
            </div>
          </div>
          <!-- DESCRIPTION -->
          <div
            class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
          >
            <label
              for="about"
              class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"
            >
              Description *
            </label>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
              <textarea
                v-model="form.description"
                id="about"
                name="about"
                rows="3"
                required
                class="max-w-lg shadow-sm block w-full focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border border-gray-300 rounded-md"
              />
              <p class="mt-2 text-sm text-gray-500">
                Long or short description of the project.
              </p>
            </div>
          </div>

          <!-- STATUS --->
          <div
            class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
          >
            <label
              for="about"
              class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"
            >
              Status *</label
            >
            <select
              v-model="form.status"
              required
              id="status"
              name="status"
              class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
            >
              <option v-for="s in status" :key="s.value" :value="s.value">
                {{ s.name }}
              </option>
            </select>
          </div>

          <!-- CONTACT PEOPLE -->
          <div
            class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
          >
            <label
              for="about"
              class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"
            >
              Contact People
            </label>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
              <fieldset class="space-y-5">
                <div
                  class="relative flex items-start"
                  v-for="(person, index) in contactPeople.data"
                  :key="person.id"
                >
                  <div class="flex items-center h-5">
                    <input
                      :id="'candidates_' + person.id"
                      aria-describedby="candidates-description"
                      name="candidates"
                      type="checkbox"
                      v-model="form.contact_people"
                      :value="person.id"
                      
                      class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"
                    />
                  </div>
                  <div class="ml-3 text-sm flex flex-col w-full text-left">
                    <input
                      :for="'candidates_' + person.id"
                      class="font-medium text-gray-700"
                      v-model="contactPeopleList.value[index].name"
                      />
                    <input id="candidates-description" class="text-gray-500" 
                    v-model="contactPeopleList.value[index].email"
>
                    <div class="flex">
                        <button
                        type="button"
                        class="text-indigo-600 hover:text-indigo-900 text-left w-max"
                        @click="deleteContactPerson(person.id)"
                        >
                        Delete
                        </button>

                        <button
                        type="button"
                        class="text-indigo-600 hover:text-indigo-900 text-left w-max ml-3"
                        @click="saveContactPerson(contactPeopleList.value[index])"
                        >
                        Save
                        </button>
                    </div>
                  </div>
                </div>
              </fieldset>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="pt-5">
      <div class="flex justify-end">
        <Link
          :href="$route('projects.index')"
          type="button"
          class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        >
          Cancel
        </Link>
        <button
          type="submit"
          class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        >
          Save
        </button>
      </div>
    </div>
  </form>
</template>

<script setup>
import { reactive, ref } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import { watch } from "vue";
import throttle from "lodash/throttle";

const props = defineProps({
    contactPeople: Array,
    status : Array,
    project: Object,
})

let contactPeopleList = reactive({value : props.contactPeople.data })

const saveContactPerson = (contactPerson) => {
    request(contactPerson)
}

function request(contactPerson) {
  Inertia.put(route('contact-person.update', {contactPerson: contactPerson.id}),
    contactPerson,
    { preserveState: true, replace: true,  preserveScroll: true }
  );
}

let form = useForm({
    name: props.project ? props.project.data.name : null,
    description: props.project ? props.project.data.description : null,
    status: props.project ? props.project.data.status : null,
    contact_people : props.project ? props.project.data.contact_people : [],
});

const submitForm = () => {
    /* UPDATE */
    if(props.project) {
        form.put(route('projects.update', {project: props.project.data.id}), {
            preserveScroll: true,
             onSuccess: () => { handleSuccess() },
            onError:(e) => { handleError(e)},
        })
    }
    /* CREATE */
    else {
        form.post(route('projects.store'), {
            preserveScroll: true,
            onSuccess: () => { handleSuccess() },
            onError:(e) => { handleError(e)},
        })
    }
}

const handleSuccess = (text) => {
    if(!props.project){
        form.reset()
    }
    alert(text ?? 'Success')
}

const handleError = (e, text) => {
    alert(text ?? 'Error', e)
}

const deleteContactPerson = (id) => {
    Inertia.delete(route('contact-person.delete', {contactPerson: id}),
    {   
        onBefore: () => confirm('Are you sure you want to delete this contact person?'),
        preserveState: false, 
        replace: true, 
        onSuccess: () => {  },
        onError:(e) => { handleError(e)}, 
    }
  );
}
</script>
