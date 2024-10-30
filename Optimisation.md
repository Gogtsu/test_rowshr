# Optimisation
## Indexing
 - I will update the pivot schema. First create the migration `php artisan make:migration update_employee_project_indexes`
 - In the migration add index to role, since the foreing keys are automatically indexed
 - I will paginate the list with ->paginate()
 - plus will use cacheing with predis, through docker. This process shows that I know some things about optimization. It is already taking too much time for a test.