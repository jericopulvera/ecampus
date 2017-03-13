import Vue from 'vue'
import Vuex from 'vuex'

const state = {
  tab: 'feed',
  term: null,
  admin: [],
  professors: [],
  students: [],
  modalGrades: [],
  modalStudent: []
}

const mutations = {
  SELECT_TAB(state,name) {
    state.tab = name;
  },
  SELECT_TERM(state,term) {
    state.term = term;
  },
  SET_MEMBERS(state,members) {
    state.admin = members.admin;
    state.professors = members.professors;
    state.students = members.students;
  },
  EDIT_GRADE(state, info) {
    for (let i = 0; i < state.students.length; i++) {
      if (state.students[i].id == info.id) {
        if (info.term === 'prelim') { state.modalGrades = state.students[i].grades[0]; }
        if (info.term === 'midterm') { state.modalGrades = state.students[i].grades[1]; }
        if (info.term === 'finals') { state.modalGrades = state.students[i].grades[2]; }
        state.term = info.term;
        state.modalStudent = state.students[i];
        break;
      }
    }
  },
  CLOSE_MODAL(state) {
    state.term = null;
    state.modalGrades = [];
    state.modalStudent = [];
  }
}

const actions = {
  selectTab({commit}, name) {
    commit('SELECT_TAB', name);
  },
  editGrade({commit}, info) {
    commit('EDIT_GRADE', info);
  },
  fetchMembers({commit}, group_slug) {
  	return axios.get('/webapi/group/fetch-members/'+ group.slug).then((response) => {
  			     commit('SET_MEMBERS', response.data);
           })
  },
  closeModal({commit}) {
    commit('CLOSE_MODAL');
  }
}

export default {
	state, mutations, actions
}
