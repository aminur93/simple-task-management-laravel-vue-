<script>
import {mapState} from "vuex";
import {http} from "@/services/HttpService";

export default {
  name: "Login",

  data() {
    return {
      login: "",
      password: "",
      loading: true,
      errors: {}
    };
  },

  computed: {
    ...mapState({
        message: state => state.success_message,
        success_status: state => state.success_status,
    })
  },

  mounted() {
    if(this.$store.state.token !== '')
    {
      return http().post('v1/auth/checkToken')
          .then(res => {
            if(res.data.success)
            {
              this.$router.push('/dashboard');
            }else{
              this.$store.commit('SET_TOKEN', res.data.data.access_token);
              this.$store.commit('SET_USER', res.data.data.user);
            }
          })
          .catch(err => {
            console.log(err);
          })
    }else {
      this.loading = false;
    }
  },

  methods: {
    handleLogin: function () {
    try {
      let formData = new FormData();
      
      formData.append('login', this.login);
      formData.append('password', this.password);

      return http().post('v1/auth/login', formData)
        .then(res => {
          if (res && res.data && res.data.data) {
            this.$store.commit('SET_TOKEN', res.data.data.access_token);
            this.$store.commit('SET_USER', res.data.data.user);
            this.$router.push('/dashboard');
          } else {
            this.$swal.fire({
              icon: 'error',
              title: 'Login Failed',
              text: 'Unexpected response format!',
            });
          }
        })
        .catch(err => {
          this.errors = err.response?.data?.errors || { general: ['Login failed'] };
        });
    } catch (e) {
      this.$swal.fire({
        icon: 'error',
        title: 'Something went wrong!',
        text: 'Please try again later.',
      });
    }
  }

  }

};
</script>

<template>
  <div
    class="min-h-screen flex items-center justify-center bg-gray-100 bg-cover bg-no-repeat"
    style="background-image: url('/your-background-image.jpg')"
  >
    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">
      <h2 class="text-2xl font-semibold text-center mb-2">Sign in</h2>
      <p class="text-center text-sm text-gray-600 mb-6">
        Need an account?
        <a href="#" class="text-blue-600 hover:underline">Sign up</a>
      </p>

      <div class="flex justify-between gap-2 mb-4">
        <button
          class="flex-1 flex items-center justify-center border rounded-md py-2 hover:bg-gray-100"
        >
          <img
            src="https://www.svgrepo.com/show/475656/google-color.svg"
            alt="Google"
            class="w-5 h-5 mr-2"
          />
          Use Google
        </button>
        <button
          class="flex-1 flex items-center justify-center border rounded-md py-2 hover:bg-gray-100"
        >
          <img
            src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_logo_black.svg"
            alt="Apple"
            class="w-5 h-5 mr-2"
          />
          Use Apple
        </button>
      </div>

      <div class="relative text-center mb-4">
        <span class="absolute inset-0 flex items-center">
          <span class="w-full border-t"></span>
        </span>
        <span class="relative bg-white px-2 text-sm text-gray-500">OR</span>
      </div>

      <form @submit.prevent="handleLogin">
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700">Email</label>
          <input
            v-model="login"
             type="text"
              placeholder="email@email.com or 01XXXXXXXXX"
            class="mt-1 block w-full border rounded-md px-3 py-2 focus:outline-none focus:ring focus:border-blue-300"
          />
        </div>

        <div class="mb-4">
          <div class="flex justify-between items-center">
            <label class="block text-sm font-medium text-gray-700"
              >Password</label
            >
            <a href="#" class="text-sm text-blue-600 hover:underline"
              >Forgot Password?</a
            >
          </div>
          <input
            v-model="password"
            type="password"
            placeholder="Enter Password"
            class="mt-1 block w-full border rounded-md px-3 py-2 focus:outline-none focus:ring focus:border-blue-300"
          />
        </div>

        <div class="flex items-center mb-6">
          <input
            id="remember"
            type="checkbox"
            class="h-4 w-4 text-blue-600 border-gray-300 rounded"
          />
          <label for="remember" class="ml-2 block text-sm text-gray-900"
            >Remember me</label
          >
        </div>

        <button
          type="submit"
          class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700"
        >
          Sign In
        </button>
      </form>
    </div>
  </div>
</template>

<style scoped></style>
