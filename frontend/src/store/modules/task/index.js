/* -------------------------------------------------------------------------- */
/*                                states Define                               */
/* -------------------------------------------------------------------------- */
import {http} from "@/services/HttpService";

const state = {
    tasks: [],
    task: {},
    success_message: "",
    errors: {},
    error_message: "",
    error_status: "",
    success_status: "",
}

/* -------------------------------------------------------------------------- */
/*                              Mutations Define                              */
/* -------------------------------------------------------------------------- */
const mutations = {
    GET_ALL_TASKS: (state, data) => {
        state.tasks = data;
    },

    STORE_TASK: (state, data) => {
        if (state.tasks.push(data.data))
        {
            state.success_message = data.data.message;
            state.success_status = data.status;
        }else {
            state.success_message = '';
        }
    },

    GET_SINGLE_TASK: (state, data) => {
        state.task = data;
    },

    UPDATE_TASK: (state, data) => {
        if (state.tasks.push(data.data))
        {
            state.success_message = data.data.message;
            state.success_status = data.status;
        }
    },

    DELETE_TASK: (state, {id, data}) => {
        if (id)
        {
            state.tasks = state.tasks.filter(item => {
                return item.id !== id;
            })

            state.success_message = data.data.message;
            state.success_status = data.status;
        }
    },

    IS_COMPLETED_TASK: (state, data) => {
        if (state.tasks.push(data.data))
        {
            state.success_message = data.data.message;
            state.success_status = data.status;
        }
    },

    SET_ERROR(state, { errors, errorStatus }) {
        state.errors = errors;
        state.error_status = errorStatus;
    },

    clearErrors(state) {
        state.error_message = '';
        state.error_status = '';
        state.errors = {};
    }
}

/* -------------------------------------------------------------------------- */
/*                               Actions Define                               */
/* -------------------------------------------------------------------------- */
const actions = {
    /*get all task start*/
    async GetAllTask({ commit }) {
        try {
            const result = await http().get("v1/admin/task", {
                params: {
                    pagination: false
                }
            });
            commit("GET_ALL_TASK", result.data.data);
        } catch (err) {
            const errors = err.response.data.errors;
            const errorStatus = err.response.status;
            commit("SET_ERROR", { errors, errorStatus });
            throw err; // Re-throw the error to propagate it to the caller
        }
    },
    /*get all task end*/

    /*store task start*/
    StoreTask: ({commit}, data) => {
        return http()
            .post("v1/admin/task", data)
            .then((result) => {
                commit("STORE_TASK", result);
                commit("SET_CLEAR_ERROR");
                
            })
            .catch((err) => {
                const errors = err.response.data.errors;
                const errorStatus = err.response.status;
                commit("SET_ERROR", { errors, errorStatus });
                throw err;
            })
    },
    /*store task end*/

    /*get single task start*/
    GetSingleTask: ({commit}, id) => {
        return http()
            .get(`v1/admin/task/${id}`)
            .then((result) => {
                commit("GET_SINGLE_TASK", result.data.data);
            })
            .catch((err) => {
                const errors = err.response.data.errors;
                const errorStatus = err.response.status;
                commit("SET_ERROR", { errors, errorStatus });
                throw err;
            })
    },
    /*get single task end*/

    /*update task start*/
    UpdateTask: ({commit}, {id, data}) => {
        return http()
            .put(`v1/admin/task/${id}`, data)
            .then((result) => {
                commit("UPDATE_TASK", result);
                commit("SET_CLEAR_ERROR");
            })
            .catch((err) => {
                const errors = err.response.data.errors;
                const errorStatus = err.response.status;
                commit("SET_ERROR", { errors, errorStatus });
                throw err;
            })
    },
    /*update task end*/

    /*destroy book start*/
    DeleteTask: ({commit}, id) => {
        return http()
            .delete(`v1/admin/task/${id}`)
            .then((result) => {
                commit("DELETE_TASK", {id:id, data:result});
            })
            .catch((err) => {
                const errors = err.response.data.errors;
                const errorStatus = err.response.status;
                commit("SET_ERROR", { errors, errorStatus });
                throw err;
            })
    },
    /*destroy book end*/

    /*is completed start*/
    IsCompletedTask: ({commit}, {id, data}) => {
        return http()
                .patch(`v1/admin/task/changeCompleteStatus/${id}`, data)
                .then((result) => {
                    commit('IS_COMPLETED_TASK', result)
                })
                .catch((err) => {
                    const errors = err.response.data.errors;
                    const errorStatus = err.response.status;
                    commit("SET_ERROR", { errors, errorStatus });
                    throw err;
                })
    }
    /*is completed start*/
}

/* -------------------------------------------------------------------------- */
/*                               Getters Define                               */
/* -------------------------------------------------------------------------- */
const getters = {}

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
}