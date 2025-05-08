<template>
  <div class="p-6 space-y-6">
    <!-- Top Bar -->
    <div class="flex justify-between items-center">
      <div class="text-lg font-semibold">
        Total Tasks: {{totalTask ?? 0}} | Completed: {{completedCount ?? 0}}
      </div>
      <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"  @click.prevent="openAddModal">
        + Add Task
      </button>
    </div>

    <!-- Task Grid -->
    <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 md:grid-cols-4">
      <div
        v-for="task in tasks"
        :key="task.id"
        class="bg-white rounded-lg shadow p-4 relative group space-y-2"
      >
        <div class="flex justify-between items-start">
          <div class="flex items-start space-x-3">
            <input type="checkbox" class="w-5 h-5 text-green-600 mt-1" :checked="task.is_completed == 1" @change="isCompleted(task)" />
            <div>
              <h2  
              class="text-gray-900 font-semibold"
              :class="{ 'line-through text-gray-500': task.is_completed == 1 }">
              {{ task.title }}
              </h2>
              <p class="text-gray-500 text-sm mt-1">{{ task.body }}</p>
            </div>
          </div>
          <div class="relative">
            <button class="text-gray-400 hover:text-gray-700 text-lg" @click="toggleMenu(task.id)">⋮</button>
            <div
              v-show="openMenu === task.id"
              class="absolute right-0 mt-2 w-32 bg-white border rounded shadow z-10"
            >
              <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100" @click.prevent="openEditModal(task.id)">Edit</a>
              <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100" @click="deleteTask(task.id)">Delete</a>
            </div>
          </div>
        </div>
        <div class="flex justify-between items-center pt-2 text-sm">
          <span class="text-gray-400">{{ task.created_at.split('T')[0] }}</span>
          <span
            class="px-2 py-0.5 rounded-full text-xs font-medium"
            :class="task.is_completed ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'"
          >
            {{ task.is_completed ? 'Completed' : 'Pending' }}
          </span>
        </div>
      </div>
    </div>

    <!-- Pagination Right -->
    <div v-if="tasks.length > 0" class="mt-6 flex justify-end items-center space-x-2">
      <button
        :disabled="!meta.prev_page_url"
        @click="getAllTask(currentPage - 1)"
        class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300"
      >
        ‹ Prev
      </button>
    
      <button
        v-for="n in meta.last_page"
        :key="n"
        @click="getAllTask(n)"
        :class="[
          'px-4 py-2 rounded',
          n === currentPage ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-gray-300',
        ]"
      >
        {{ n }}
      </button>
    
      <button
        :disabled="!meta.next_page_url"
        @click="getAllTask(currentPage + 1)"
        class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300"
      >
        Next ›
      </button>
    </div>
  </div>

  <!-- Modal -->
  <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-96 p-6 space-y-4 relative">
      <h2 class="text-lg font-bold">
        {{ isEditing ? 'Edit Task' : 'Add Task' }}
      </h2>

      <form @submit.prevent="submitTask">
        <div class="mb-4">
          <input
            v-model="taskForm.title"
            type="text"
            placeholder="Task Title"
            class="w-full border rounded px-3 py-2"
          />
          <p v-if="errors && errors.title && errors.title.length" class="text-red-500 text-sm mt-1">
            {{ errors.title[0] }}
          </p>
        </div>
      
        <div class="mb-4">
          <textarea
            v-model="taskForm.body"
            placeholder="Task Description"
            class="w-full border rounded px-3 py-2"
          ></textarea>
          <p v-if="errors && errors.body && errors.body.length" class="text-red-500 text-sm mt-1">
            {{ errors.body[0] }}
          </p>
        </div>
      
        <div class="flex justify-end space-x-2 mt-4">
          <button type="button" @click="closeModal" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
          <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            {{ isEditing ? 'Update' : 'Add' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import {mapState} from "vuex";
import {http} from "@/services/HttpService";

export default {
  name: "Task",

  data() {
    return {
      openMenu: null,
      showModal: false,
      isEditing: false,
      editingTaskId: null,
      tasks: [],
      meta: {},
      totalTask: 0,
      currentPage: 1,
      loading: true,
      taskForm: {
        title: '',
        body: '',
      },
    }
  },

  computed: {
    ...mapState({
      message: state => state.task.success_message,
      errors: state => state.task.errors,
      success_status: state => state.task.success_status,
      error_status: state => state.task.error_status
    }),

    completedCount() {
      return this.tasks.filter(t => t.is_completed === 1).length;
    }
  },

  mounted(){
    this.getAllTask();
  },

  methods: {
    toggleMenu(id) {
      this.openMenu = this.openMenu === id ? null : id
    },

    openAddModal() {
      this.isEditing = false;
      this.taskForm = { title: '', body: '' };
      this.showModal = true;
    },

    openEditModal(id) {
      const task = this.tasks.find(t => t.id === id);
      if (task) {
        this.isEditing = true;
        this.editingTaskId = id;
        this.taskForm = {
          title: task.title,
          body: task.body
        };
        this.showModal = true;
        this.openMenu = null; // close the menu
      }
    },

    closeModal() {
      this.showModal = false;
    },

    /*get all tasks with oagination*/
    getAllTask(page = 1){
      this.loading = true
      this.currentPage = page;

      http().get(`http://localhost:8000/api/v1/admin/task?page=${page}`).then((result) => {
        
        this.tasks = result.data.data.data;
        this.meta = result.data.data;
        this.totalTask = result.data.data.total;
        this.loading = false;
      }).catch((err) => {
        console.log(err);
      })
    },
    /*get all tasks with oagination*/

    /*store and update task*/
    submitTask: async function() {
      if (this.isEditing) {
        try {
          let formData = new FormData();
          formData.append('title', this.taskForm.title);
          formData.append('body', this.taskForm.body);

          await this.$store.dispatch('task/UpdateTask', {
            id: this.editingTaskId,
            data: formData
          }).then(() => {
            if (this.success_status === 200) {
              this.$swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: this.message,
                showConfirmButton: false,
                timer: 1500
              });

              this.getAllTask(this.currentPage);

              this.taskForm = {};

              this.closeModal();
            }
          });
        } catch (e) {
          this.$swal.fire({
            icon: 'error',
            title: 'Something went wrong!',
          });
        }
      } else {

        try {
          let formData = new FormData();

          formData.append('title', this.taskForm.title);
          formData.append('body', this.taskForm.body);

          await this.$store.dispatch('task/StoreTask', formData).then(() => {
            
            if (this.success_status === 201)
            {
              this.$swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: this.message,
                showConfirmButton: false,
                timer: 1500
              });

              
              this.getAllTask(this.currentPage);

              this.taskForm = {};

              this.closeModal();

            }
          })

        }catch (e) {
          if (this.error_status === 422)
          {
            console.log('error');
          }else {
            this.$swal.fire({
              icon: 'error',
              text: 'Oops',
              title: 'Something wen wrong!!!',
            });
          }
        }
      }
    },
    /*store and update task*/

    /*delete task*/
    deleteTask: async function(id) {
      try {
        await this.$store.dispatch("task/DeleteTask", id).then(() => {
          if (this.success_status === 200)
          {
            this.$swal.fire({
              toast: true,
              position: 'top-end',
              icon: 'success',
              title: this.message,
              showConfirmButton: false,
              timer: 1500
            });

            this.getAllTask();
          }
        })
      }catch (e) {
        if (this.error_status === 403)
        {
          this.$swal.fire({
            icon: 'error',
            text: 'Permission denied',
          });
        }else {
          this.$swal.fire({
            icon: 'error',
            text: 'Oops',
            title: 'Something wen wrong!!!',
          });
        }
      }
    },
    /*delete task*/

    /*change status task*/
    isCompleted(task) {
      let formData = new FormData();
      formData.append('is_completed', task.is_completed ? 0 : 1);

      this.$store.dispatch('task/IsCompletedTask', {id:task.id, data:formData})
        .then(() => {
          this.$swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Task updated',
            showConfirmButton: false,
            timer: 1200
          });

          this.getAllTask();
        })
        .catch(() => {
          this.$swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to update task status',
          });
        });
    }
    /*change status task*/
  },
};
</script>

<style scoped></style>