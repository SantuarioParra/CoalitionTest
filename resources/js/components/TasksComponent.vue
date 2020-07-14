<template>
    <v-row>
        <v-col cols="12">
            <v-snackbar
                v-model="snackbar"
                multi-line
                timeout="6000"
                :color="snackColor"
                bottom
                right

            >
                {{ text }}

                <template v-slot:action="{ attrs }">
                    <v-btn
                        dark
                        text
                        v-bind="attrs"
                        @click="snackbar = false"
                    >
                        Close
                    </v-btn>
                </template>
            </v-snackbar>
            <v-card
                flat
            >
                <v-card-title>
                    Tasks manager
                </v-card-title>
                <v-card-text>
                    <v-row fluid>
                        <v-col cols="12">
                            <v-autocomplete
                                v-model="task.project_id"
                                :search-input.sync="project.name"
                                :items="projects"
                                :loading="loading"
                                label="Project"
                                item-text="name"
                                item-value="id"
                                auto-select-first
                                clearable
                                v-on:keyup.enter="addProject(project)"
                                v-on:change="filterTasks(task.project_id)"
                                :error-messages="project_name_Errors"
                                @input="$v.project.name.$touch()"
                                @blur="$v.project.name.$touch()"
                                hide-selected
                            >
                                <template v-slot:selection="data">
                                    <v-chip
                                        v-bind="data.attrs"
                                        :input-value="data.selected"
                                        color="light-blue"
                                        text-color="white"
                                        label
                                        close
                                        close-icon="mdi mdi-delete"
                                        @click:close="deleteProject(data.item)"
                                    >
                                        <v-icon small left>mdi mdi-label</v-icon>
                                        {{data.item.name}}
                                    </v-chip>
                                </template>
                            </v-autocomplete>
                        </v-col>
                        <v-col cols="12">
                            <v-text-field
                                v-model="task.name"
                                label="Type your task"
                                counter="150"
                                clearable
                                v-on:keypress.enter="createTask"
                                :error-messages="task_name_Errors"
                                @input="$v.task.name.$touch()"
                                @blur="$v.task.name.$touch()"
                            ></v-text-field>
                        </v-col>

                    </v-row>
                    <v-row fluid>
                        <draggable v-model="tasks" group="tasks" @start="drag=true" @end="onEnd">
                            <v-col cols="12"
                                   v-for="task in tasks"
                                   :key="task.id">
                                <v-card
                                    flat
                                >
                                    <v-row fluid>
                                        <v-col cols="12" md="10" sm="10">
                                            <v-card-text v-text="task.name"></v-card-text>
                                        </v-col>
                                        <v-col cols="12" md="2" sm="2">
                                            <v-card-actions>
                                                <v-spacer></v-spacer>
                                                <v-btn
                                                    small
                                                    icon
                                                    dark
                                                    color="blue"
                                                    v-on:click.prevent="openDialog(task)"
                                                >
                                                    <v-icon>mdi-pencil-outline</v-icon>
                                                </v-btn>
                                                <v-btn
                                                    small
                                                    icon
                                                    dark
                                                    color="error"
                                                    v-on:click.prevent="deleteTask(task)"
                                                >
                                                    <v-icon>mdi-delete-outline</v-icon>
                                                </v-btn>
                                            </v-card-actions>
                                        </v-col>
                                    </v-row>
                                </v-card>
                            </v-col>
                        </draggable>
                    </v-row>
                </v-card-text>
            </v-card>
            <v-dialog
                v-model="editDialog"
                max-width="500"
            >
                <v-card>
                    <v-card-title>Edit task</v-card-title>
                    <v-card-text class="pb-0">
                        <v-row fluid>
                            <v-col cols="12">
                                <v-autocomplete
                                    v-model="task.project_id"
                                    :search-input.sync="project.name"
                                    :items="projects"
                                    :loading="loading"
                                    label="Project"
                                    item-text="name"
                                    item-value="id"
                                    clearable
                                    v-on:keyup.enter="addProject(project)"
                                    hide-selected
                                    :error-messages="project_name_Errors"
                                    @input="$v.project.name.$touch()"
                                    @blur="$v.project.name.$touch()"
                                >
                                    <template v-slot:selection="data">
                                        <v-chip
                                            v-bind="data.attrs"
                                            :input-value="data.selected"
                                            color="light-blue"
                                            text-color="white"
                                            label
                                            close
                                            close-icon="mdi mdi-delete"
                                            @click:close="deleteProject(data.item)"
                                        >
                                            <v-icon small left>mdi mdi-label</v-icon>
                                            {{data.item.name}}
                                        </v-chip>
                                    </template>
                                </v-autocomplete>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    v-model="task.name"
                                    label="Type your task"
                                    clearable
                                    counter="150"
                                    :error-messages="task_name_Errors"
                                    @input="$v.task.name.$touch()"
                                    @blur="$v.task.name.$touch()"
                                >
                                </v-text-field>
                            </v-col>
                        </v-row>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            small
                            text
                            color="error"
                            v-on:click.prevent="closeDialog"
                        >
                            close
                        </v-btn>
                        <v-btn
                            small
                            text
                            color="blue"
                            v-on:click.prevent="updateTask"
                        >
                            Save
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-col>
    </v-row>
</template>

<script>
    import draggable from 'vuedraggable';
    import taskService from '../services/tasks/tasks_service';
    import projectService from '../services/projects/projects_service';
    import {required, maxLength, minLength} from 'vuelidate/lib/validators'

    export default {
        data() {
            return {
                //dialog
                editDialog: false,
                //tasks
                tasks: [],
                task: {
                    'name': '',
                    'priority': undefined
                },
                defaultTask: {
                    'name': '',
                    'priority': undefined
                },
                //projects
                projects: [],
                project: {
                    'name': ''
                },
                loading: false,
                //snackbar
                snackbar: false,
                snackColor: '',
                text: ''

            }
        },
        components: {
            draggable
        },
        validations: {
            task: {
                'name': {required, maxLength: maxLength(150), minLength: minLength(1)}
            },
            project: {
                'name': {maxLength: maxLength(150), minLength: minLength(1)}
            }
        },
        computed: {
            task_name_Errors() {
                const errors = [];
                if (!this.$v.task.name.$dirty) return errors;
                !this.$v.task.name.required && errors.push('Task text is required.');
                !this.$v.task.name.maxLength && errors.push('Task text is too large, max 150 characters.');
                !this.$v.task.name.minLength && errors.push('Task text is too short, min 1 character.');
                return errors
            },
            project_name_Errors() {
                const errors = [];
                if (!this.$v.project.name.$dirty) return errors;
                !this.$v.project.name.maxLength && errors.push('Project name is too large, max 150 characters.');
                !this.$v.project.name.minLength && errors.push('Project name is too short, min 1 character.');
                return errors
            },
        },
        methods: {
            async indexData() {
                let tasksResponse = await taskService.getTasks();
                this.tasks = tasksResponse.data.tasks;
                let projectsResponse = await projectService.getProjects();
                this.projects = projectsResponse.data.projects;
            },
            onEnd(evt) {
                let priority = 1;
                let priorityList = {
                    taskPriorities: []
                };
                this.tasks.forEach(task => {
                    task.priority = priority;
                    priority++;
                    priorityList.taskPriorities.push({'id': task.id, 'priority': task.priority});
                });
                console.log(priorityList);
                taskService.updateTaskPriority(priorityList).then(response => {
                    console.log(response);
                }).catch(error => {
                    console.log(error.response);
                })
            },
            createTask() {
                this.$v.$touch();
                if (!this.$v.$invalid) {
                    if (this.task.project_id === undefined) {
                        delete this.task.project_id
                    }
                    this.task.priority = this.tasks.length + 1;
                    taskService.saveTask(this.task).then(response => {
                        this.snackColor = "success";
                        this.text = response.data.message;
                    }).catch(error => {
                        if (error.response.status >= 300 && error.response.status < 500) {
                            this.snackColor = "warning"
                        }
                        if (error.response.status >= 500) {
                            this.snackColor = "error"
                        }
                        this.text = error.response.data.message;
                    }).finally(() => {
                        this.indexData();
                        this.task = this.defaultTask;
                        this.snackbar = true;
                    })
                }
            },
            updateTask() {
                this.$v.$touch();
                if (!this.$v.$invalid) {
                    if (this.task.project_id === null && this.task.project_id === undefined) {
                        delete this.task.project_id;
                    }
                    taskService.updateTask(this.task, this.task.id).then(response => {
                        this.snackColor = "success";
                        this.text = response.data.message;
                    }).catch(error => {
                        if (error.response.status >= 300 && error.response.status < 500) {
                            this.snackColor = "warning"
                        }
                        if (error.response.status >= 500) {
                            this.snackColor = "error"
                        }
                        this.text = error.response.data.message;
                    }).finally(() => {
                        this.indexData();
                        this.task = this.defaultTask;
                        this.editDialog = false;
                        this.snackbar = true;
                    })
                }
            },
            deleteTask(task) {
                if (confirm("Are you sure about delete this task?")) {
                    taskService.deleteTask(task.id).then(response => {
                        this.snackColor = "success";
                        this.text = response.data.message;
                    }).catch(error => {
                        if (error.response.status >= 300 && error.response.status < 500) {
                            this.snackColor = "warning"
                        }
                        if (error.response.status >= 500) {
                            this.snackColor = "error"
                        }
                        this.text = error.response.data.message;
                    }).finally(() => {
                        this.indexData();
                        this.snackbar = true;
                    })
                }
            },
            openDialog(task) {
                this.editDialog = true;
                this.task = task;
            },
            closeDialog() {
                this.task = this.defaultTask;
                this.editDialog = false;
            },
            //Project
            addProject(project) {
                if (project.name !== '' && project.name !== undefined) {
                    this.loading = true;
                    projectService.saveTProject(project).then(response => {
                        this.snackColor = "success";
                        this.text = response.data.message;
                    }).catch(error => {
                        if (error.response.status >= 300 && error.response.status < 500) {
                            this.snackColor = "warning"
                        }
                        if (error.response.status >= 500) {
                            this.snackColor = "error"
                        }
                        this.text = error.response.data.message;
                    }).finally(() => {
                        this.indexData();
                        this.project.name = '';
                        this.loading = false;
                        this.snackbar = true;
                    })
                }
            },
            deleteProject(project) {
                this.loading = true;
                if (confirm('Are you sure about delete this project?')) {
                    projectService.deleteProject(project.id).then(response => {
                        this.snackColor = "success";
                        this.text = response.data.message;
                    }).catch(error => {
                        if (error.response.status >= 300 && error.response.status < 500) {
                            this.snackColor = "warning"
                        }
                        if (error.response.status >= 500) {
                            this.snackColor = "error"
                        }
                        this.text = error.response.data.message;
                    }).finally(() => {
                        this.indexData();
                        this.snackbar = true;
                    })
                }
                this.loading = false;
            },
            filterTasks(projectId) {
                if (projectId !== undefined) {
                    this.tasks = this.tasks.filter(function (task) {
                        return task.project_id === projectId;
                    })
                } else {
                    this.indexData();
                }
            }
        },
        mounted() {
            this.indexData();
        }
    }
</script>

<style scoped>

</style>
