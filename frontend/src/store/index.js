import { createStore } from "vuex";
import createPersistedState from "vuex-persistedstate";

//root vuex import start
import state from "./state";
import * as getters from "./getters";
import * as mutations from "./mutations";
import * as actions from "./actions";
//root vuex import end

/*module import start */
import task from "@/store/modules/task";
/*module import end */

const store = createStore({
    state,
    getters,
    mutations,
    actions,

    modules: {
        task
    },

    plugins: [
        createPersistedState({
            paths: ["token", "user"]
        })
    ]
});

export default store
