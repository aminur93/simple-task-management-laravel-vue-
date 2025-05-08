import Master from "@/views/admin/Master.vue";
import Dashboard from "@/views/admin/Dashboard.vue";

import TaskRouter from "@/router/admin/TaskRouter";

import store from "@/store";

export default [
  {
    path: "/dashboard",
    component: Master,
    children: [
      {
        path: "",
        name: "Dashboard",
        component: Dashboard,
      },

      ...TaskRouter
    ],
    beforeEnter(to, from, next){
        if (!store.getters['AuthToken'])
        {
            next({name: 'Login'});
        }else {
            next();
        }
    }
  },
];
