<template>
    <div class="p-4">
        <h1 class="text-2xl font-semibold mb-4 text-gray-800">Projects List</h1>
        <div v-if="message" class="mb-4 p-2 text-center text-green-600">{{ message }}</div>
        <div v-if="errorMessage" class="mb-4 p-2 text-center text-red-600">{{ errorMessage }}</div>
        <div class="my-4 flex">
            <input 
                class="border border-blue-300 p-2 rounded w-full" 
                type="text" 
                placeholder="Filter by role (e.g., Manager)" 
                v-model="searchRole" 
            />
            <button 
                class="bg-blue-500 text-white px-4 py-2 rounded-lg ml-2" 
                @click="filterProjects">
                Search
            </button>
        </div>
        <ul class="bg-white shadow rounded-lg divide-y divide-gray-200">
            <li class="cursor-pointer p-4 hover:bg-blue-100 text-gray-700"
                v-for="project in projects.data" 
                :key="project.id"
                @click="openProjectModal(project)">
                <h3>{{ project.title }}</h3>
            </li>
        </ul>

        <!-- Pagination controls -->
        <div class="mt-4 flex justify-between">
            <button 
                :disabled="!projects.prev_page_url" 
                @click="fetchProjects(projects.current_page - 1)" 
                class="bg-blue-500 text-white px-4 py-2 rounded-lg" 
            >
                Previous
            </button>
            <span>Page {{ projects.current_page }} of {{ projects.last_page }}</span>
            <button 
                :disabled="!projects.next_page_url" 
                @click="fetchProjects(projects.current_page + 1)" 
                class="bg-blue-500 text-white px-4 py-2 rounded-lg" 
            >
                Next
            </button>
        </div>

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
            projects: { data: [], current_page: 1, last_page: 1, prev_page_url: null, next_page_url: null },
            message: null,
            errorMessage: null,
            selectedProject: null,
            searchRole: '',
        }
    },
    created() {
        this.fetchProjects();
    },
    methods: {
        async fetchProjects(page = 1) {
            try {
                const response = this.searchRole.trim() 
                    ? await axios.get(`/api/optimized/projects/filter/${this.searchRole.trim()}?page=${page}`)
                    : await axios.get(`/api/optimized/projects?page=${page}`);
                this.projects = response.data;
            } catch (error) {
                this.errorMessage = 'Failed to fetch projects.';
                console.error(error);
            }
        },
        filterProjects() {
            this.fetchProjects();
        },
        openProjectModal(project) {
            this.selectedProject = project;
        },
        async removeEmployeeFromProject({projectId, employeeId}) {
            try {
                await axios.delete(`/api/projects/${projectId}/employees/${employeeId}`);
                this.message = 'Employee removed from the project successfully!';
                this.fetchProjects(this.projects.current_page);
                this.errorMessage = "";
            } catch (error) {
                this.message = "";
                this.errorMessage = 'Failed to remove employee from project.';
            }
            this.selectedProject = null;
        }
    }
}
</script>
