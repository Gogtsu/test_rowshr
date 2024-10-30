<template>
    <div class="p-4">
        <h1 class="text-2xl font-semibold mb-4 text-gray-800">Employee List</h1>
        <div v-if="message" class="mb-4 p-2 text-center text-green-600">{{ message }}</div>
        <div v-if="errorMessage" class="mb-4 p-2 text-center text-red-600">{{ errorMessage }}</div>
        <ul class="bg-white shadow rounded-lg divide-y divide-gray-200">
            <li class="p-4 hover:bg-blue-100 text-gray-700"
                v-for="employee in employees"
                :key="employee.id">
                <div class="flex items-center justify-between space-x-2 divide-x divide-black">
                    <h3>
                        {{ employee.name }}
                    </h3>
                    <div class="flex items-center space-x-4 pl-4">
                        <button class="p-2 border rounded-md bg-indigo-300 hover:bg-indigo-500 hover:text-white" 
                            @click="openProjectsModal(employee)">View Projects</button>
                        <button class="p-2 border rounded-md bg-green-300 hover:bg-green-700 hover:text-white" 
                            @click="openAssignModal(employee)">Assign Project</button>
                    </div>
                </div>
            </li>
        </ul>
  
        <AssignModal
            v-if="selectedEmployee"
            :employee="selectedEmployee"
            :projects="projects"
            @close="selectedEmployee = null"
            @assignProject="assignProjectToEmployee"
        />

        <ProjectsModal
            v-if="selectedEmployeeList"
            :employee="selectedEmployeeList"
            @close="selectedEmployeeList = null"
            @changeRole="changeEmployeeRole"
        />
    </div>
</template>
  
<script>
    import axios from 'axios';
    import ProjectsModal from './ProjectsModal.vue';
    import AssignModal from './AssignModal.vue';
    
    export default {
        components: {
            ProjectsModal,
            AssignModal
        },
        data() {
            return {
                employees: [],
                projects: [],
                selectedEmployee: null,
                selectedEmployeeList: null,
                message: '',
                errorMessage: ''
            };
        },
        created() {
            this.fetchEmployees();
            this.fetchProjects();
        },
        methods: {
            async fetchEmployees() {
                const response = await axios.get('/api/employees');
                this.employees = response.data;
            },
            async fetchProjects() {
                const response = await axios.get('/api/projects');
                this.projects = response.data;
            },
            openAssignModal(employee) {
                this.selectedEmployee = employee;
            },
            openProjectsModal(employee) {
                this.selectedEmployeeList = employee;
            },
            async assignProjectToEmployee({ employeeId, projectId, role }) {
                try {
                    const response = await axios.post(`/api/employees/${employeeId}/assign-project/${projectId}`, { role });
                    this.message = response.data.message;
                    this.errorMessage = '';
                } catch(error) {
                    if (error.response && error.response.status === 409) {
                        this.errorMessage = error.response.data.message;
                    } else if (error.response && error.response.status === 422) {
                        if (error.response.data.errors.projectId) {
                            this.errorMessage = error.response.data.errors.projectId[0];
                        } else if (error.response.data.errors.role) {
                            this.errorMessage = error.response.data.errors.role[0];
                        } else {
                            this.errorMessage = 'An unexpected error occurred.';
                        }
                    } else {
                        this.errorMessage = 'An unexpected error occurred.';
                    }
                    this.message = '';
                }
                this.selectedEmployee = null;
                this.fetchEmployees();
            },
            async changeEmployeeRole({ employeeId, projectId, role}) {
                try {
                    const response = await axios.post(`/api/projects/${projectId}/change-role/${employeeId}`, { role });
                    this.message = response.data.message;
                    this.errorMessage = '';
                } catch (error) {
                    if (error.response && error.response.status === 404) {
                        this.errorMessage = error.response.data.message;
                    } else if (error.response && error.response.status === 422) {
                        if (error.response.data.errors.projectId) {
                            this.errorMessage = error.response.data.errors.projectId[0];
                        } else if (error.response.data.errors.role) {
                            this.errorMessage = error.response.data.errors.role[0];
                        } else {
                            this.errorMessage = 'An unexpected error occurred.';
                        }
                    } else {
                        this.errorMessage = 'An unexpected error occurred.';
                    }
                    this.message = '';
                }
                this.selectedEmployeeList = null;
                this.fetchEmployees();
            }
        }
    };
</script>