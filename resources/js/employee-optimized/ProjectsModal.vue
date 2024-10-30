<template>
  <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full mx-12">
      <h2 class="text-lg text-gray-800 mb-4">
        <span class="font-semibold">{{ employee.name }}</span>&quot; projects
      </h2>
      <div class="bg-white shadow divide-y divide-gray-200"
        v-for="project in employee.projects" :key="project.id" :value="project.id">
        <div class="flex items-center justify-between divide-x divide-black space-y-1">
          <span class="px-4">
            {{ project.title }}
          </span>
          <form @submit.prevent="changeRole(project.id)" class="flex items-center justify-between space-x-4 px-4 py-2">
            <label class="block text-gray-600 font-medium mb-1">Role:</label>
            <input class="block w-full border border-gray-300 rounded-lg p-2 text-gray-800 mb-2 focus:ring-blue-500 focus:border-blue-500"
              type="text" v-model="project.pivot.role"/>
            <button class="bg-blue-500 hover:bg-blue-600 text-white font-medium p-2 rounded-lg transition" type="submit">
              Update </button>
          </form>
        </div>  
      </div>
      <div class="flex justify-end mt-6">
        <button class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-lg transition" 
          type="button" @click="$emit('close')">Close</button>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    employee: {
      type: Object,
      required: true
    }
  },
  methods: {
    changeRole(projectId) {
      const project = this.employee.projects.find(p => p.id === projectId);
      this.$emit('changeRole', { employeeId: this.employee.id, projectId: projectId, role: project.pivot.role });
    }
  }
};
</script>