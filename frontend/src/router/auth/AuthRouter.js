import Login from "@/views/auth/Login.vue";

export default [
  {
    path: "/",
    name: "Login",
    component: Login,
    meta: {
      title: "Login",
      requiresAuth: false,
    },
  },
];
