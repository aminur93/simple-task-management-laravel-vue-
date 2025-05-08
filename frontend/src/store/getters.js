export const authenticated = (state) => {
    return state.token && state.user
};

export const AuthToken = (state) => {
    return state.token;
};

export const userInfo = (state) => {
    return state.user;
};