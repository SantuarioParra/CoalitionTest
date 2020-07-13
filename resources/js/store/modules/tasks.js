const state={
    tasks:[]
};

const getters = {
    getAllTask(state) {
        return state.tasks
    }
};

const mutations = {
    updateTasks(state, tasks) {
        state.tasks = tasks
    }
};

const actions = {
    updateTasks(context, tasks) {
        context.commit('updateTasks', tasks)
    }
};


export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
