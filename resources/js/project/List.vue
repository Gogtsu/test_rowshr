<template>
    <div class="p-4">
        <h1 class="text-2xl font-semibold mb-4 text-gray-800">Projects List</h1>
        <div v-if="message" class="mb-4 p-2 text-center text-green-600">{{ message }}</div>
        <div v-if="errorMessage" class="mb-4 p-2 text-center text-red-600">{{ errorMessage }}</div>
        <div class="my-4">
            <input class="border border-blue-300 p-2 rounded w-full" type="text" placeholder="Filter by role (e.g., Manager)" 
                v-model="searchRole" 
                @input="filterProjects" />
        </div>
        <ul class="bg-white shadow rounded-lg divide-y divide-gray-200">
            <li class="cursor-pointer p-4 hover:bg-blue-100 text-gray-700"
                v-for="project in projects"
                :key="project.id"
                @click="openProjectModal(project)">
                    <h3>{{ project.title }}</h3>
            </li>
        </ul>

        <ProjectModal
            v-if="selectedProject"
            :project="selectedProject"
            @close="selectedProject = null"
            @removeEmployee="removeEmployeeFromProject"
        />
    </div>
</template>
<script>
import axios from 'axios';
import ProjectModal from './ProjectModal.vue';
export default {
    components: {
        ProjectModal
    },
    data() {
        return {
            projects: [],
            message: null,
            errorMessage: null,
            selectedProject: null,
            searchRole: '',
        }
    },
    created() {
        this.fetchProjects("");
    },
    methods: {
        async fetchProjects(role = "") {
            const response = role 
                    ? await axios.get(`/api/projects/filter/${role}`)
                    : await axios.get('/api/projects');
            this.projects = response.data;
        },
        filterProjects() {
            this.fetchProjects(this.searchRole.trim());
        },
        openProjectModal(project, countRoles) {
            this.selectedProject = project;
        },
        async removeEmployeeFromProject({projectId, employeeId}) {
            try {
                await axios.delete(`/api/projects/${projectId}/employees/${employeeId}`);
                this.message = 'Employee removed from the project successfully!';
                this.fetchProjects();
                this.errorMessage = ""
            } catch (error) {
                this.message = ""
                this.errorMessage = 'Failed to remove employee from project.';
            }
            this.selectedProject = null;
        }
    }
    
}
</script>