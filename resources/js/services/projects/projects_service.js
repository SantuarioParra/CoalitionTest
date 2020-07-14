import axiosRequest from '../axios_config';

export default {

    getProjects() {
        return axiosRequest().get(`/api/projects`)
    },

    getProject(id) {
        return axiosRequest().get(`/api/projects/${id}`)
    },

    saveTProject(data) {
        return axiosRequest().post('/api/projects', data)
    },

    updateProject(data, id) {
        return axiosRequest().patch(`/api/projects/${id}`, data)
    },
    deleteProject(id) {
        return axiosRequest().delete(`/api/projects/${id}`)
    },

}
