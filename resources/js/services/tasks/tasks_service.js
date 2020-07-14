import axiosRequest from '../axios_config';

export default {

    getTasks() {
        return axiosRequest().get(`/api/tasks`)
    },

    getTask(id) {
        return axiosRequest().get(`/api/tasks/${id}`)
    },

    saveTask(data) {
        return axiosRequest().post('/api/tasks', data)
    },

    updateTask(data, id) {
        return axiosRequest().put(`/api/tasks/${id}`, data)
    },

    updateTaskPriority(data) {
        return axiosRequest().post(`/api/tasks/priorities`, data)
    },
    deleteTask(id) {
        return axiosRequest().delete(`/api/tasks/${id}`)
    },

}
