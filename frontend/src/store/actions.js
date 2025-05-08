import {http} from "@/services/HttpService";

export const logout = ({commit}) => {

    return http().post('v1/auth/logout')
        .then(() => {
            commit('clearToken');
        });
};