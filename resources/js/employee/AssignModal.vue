<template>
  <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
      <h2 class="text-lg text-gray-800 mb-4">
        Assign Project to <span class="font-semibold">{{ employee.name }}</span>
      </h2>
      <form @submit.prevent="assignProject">
        <input type="hidden" :value="employee.id" />
        <label for="project" class="block text-gray-600 font-medium mb-2">Select Project:</label>
        <select class="block w-full border border-gray-300 rounded-lg p-2 mb-4 focus:ring-blue-500 focus:border-blue-500"
          v-model="selectedProject" required>
          <option disabled value="">Choose a project</option>
          <option v-for="project in projects" :key="project.id" :value="project.id">
            {{ project.title }}
          </option>
        </select>

        <label for="role" class="block text-gray-600 font-medium mb-2">Role:</label>
        <input class="block w-full border border-gray-300 rounded-lg p-2 mb-4 focus:ring-blue-500 focus:border-blue-500" type="text" 
          v-model="role" required>
        <div class="flex justify-end space-x-2 mt-4">
          <button class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition" type="submit">
            Assign Project </button>
          <button class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-lg transition" type="button"
            @click="$emit('close')"> Cancel </button>
        </div>
      </form>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    employee: {
      type: Object,
      required: true
    },
    projects: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
      selectedProject: "",
      role: ""
    };
  },
  methods: {
    assignProject() {
      this.$emit('assignProject', { employeeId: this.employee.id, projectId: this.selectedProject, role: this.role });
    }
  }
};
</script>