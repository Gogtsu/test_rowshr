<template>
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full mx-12">
            <h2 class="text-lg text-gray-800 mb-4">
                Details for <span class="font-semibold">{{ project.title }}</span>
            </h2>
            <div class="my-4 text-lg p-4 border rounded-md">
                <h4>This project has:</h4>
                <ul class="grid grid-cols-5 items-center">
                    <li v-for="(count, role) in countRoles" :key="role" class="flex items-center space-x-4">
                        <span class="font-semibold text-gray-700">{{ role }}</span>
                        <span class="bg-gray-500 text-white rounded-full w-8 h-8 text-center">{{ count }}</span>
                    </li>
                </ul>
            </div>
            <div class="bg-white shadow divide-y divide-gray-200"
                v-for="employee in project.employees" :key="employee.id" :value="employee.id">
                <div class="grid grid-cols-5 items-center divide-x divide-black space-y-1">
                    <span class="px-4 col-span-4">
                        {{ employee.name }}
                    </span>
                    <div class="flex items-center justify-between space-x-4 px-4 py-2">
                        <p class="block text-gray-600 font-medium mb-1">{{employee.pivot.role}}</p>
                        <button class="bg-red-500 hover:bg-red-600 text-white font-medium p-2 rounded-lg transition" type="button"
                            @click="removeEmployee(employee.id)">
                            Remove </button>
                    </div>
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
        project: {
            type: Object,
            required: true
        },
    },
    data() {
        return {
            countRoles: []
        }
    },
    mounted() {
        this.fetchCountRoles()
    },
    methods: {
        async fetchCountRoles() {
            const response = await axios.get(`/api/projects/count-roles/${this.project.id}`);
            this.countRoles = response.data;
        },
        removeEmployee(employeeId) {
            const employee = this.project.employees.find(e => e.id === employeeId);
            this.$emit('removeEmployee', { projectId: this.project.id, employeeId: employee.id });
        }
    }
};
</script>