<template>
    <div class="container mx-auto p-4">
      <nav class="mb-4">
        <router-link to="/" class="mr-4 text-blue-500">Employees</router-link>
        <router-link to="/projects" class="mr-8 text-blue-500">Projects</router-link>
        <router-link to="/projects-optimized" class="mr-4 text-blue-500">Projects Optimized</router-link>
      </nav>
      <router-view />
    </div>
</template>
  
<script>
  export default {
    name: 'App'
  };
</script>