export default {
    //Local development url start
    apiUrl: "http://localhost:8000/api/",
    serverPath: "http://localhost:8000",
    //Local development url end
    
    token: localStorage.getItem("token") || "",
    user: localStorage.getItem("user") || "",
    success_message: '',
    errors: {},
    error_message: '',
    error_status: '',
    success_status: ''
}