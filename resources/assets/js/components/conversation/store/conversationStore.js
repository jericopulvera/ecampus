import Vue from 'vue'
import Vuex from 'vuex'

const state = {
  conversations: {},
  activeConversation: {},
  conversationModal: null,
  activeUsers: {
     0: {}
  },
  recipient: [],
}

const mutations = {
  // Frontend
  SHOW_CONVERSATION_LIST (state) {
    state.conversationModal = 'list';
  },

  CLOSE_MODAL (state) {
    state.conversationModal = null;
  },

  NEW_MESSAGE (state) {
    state.conversationModal = 'create';
  },

  ADD_RECIPIENT (state, recipient) {
    state.recipient.push(recipient);
  },

  REMOVE_RECIPIENT (state, usn) {
    for (let i = 0; i < state.recipient.length; i++) {
        if (state.recipient[i].usn === usn) {
            state.recipient.splice(i,1)
            break
        }
    }
  },

  //Backend
  SET_CONVERSATION_LIST (state, conversations) {
    state.conversations = conversations
  },

  CREATE_CONVERSATION (state, data) {
    state.recipient = [];

    // If Conversation already exists
    if (data.exists) {
      state.activeConversation = data.conversation;
    }
    else {
      // Push to conversations if does not exist
      state.conversations.push(data);
      state.activeConversation = data;
    }
   
    state.conversationModal = 'message';
  },

  SHOW_CONVERSATION (state, data) {
    state.conversationModal = 'message';
    state.activeConversation = data;
  },

  SEND_MESSAGE (state, data) {
    for (var i = 0; i < state.conversations.length; i++) {
        if (state.conversations[i].id === data.conversation_id) {
            state.activeConversation.latestMessages.push(data);
            break
        }
    }
  },

  // Presence Channel
  NEW_ACTIVE_USER (state, users) {
    if (state.conversations.length === 0) {
      state.activeUsers[0] = users;
    } else {
      let i = 0;
      while (i < state.conversations.length) {
        i++;
      }
      state.activeUsers[i-1] = users;
    }
  },

  ACTIVE_USERS (state, users) {
    for (let i = 0; i < state.conversations.length; i++) {
        state.activeUsers[i] = users;
    }
  },

  JOINING_USER (state, user) {
    for (let i = 0; i < state.conversations.length; i++) {
      if(state.activeUsers[i][0].conversation_id === user.conversation_id) {
        state.activeUsers[i].push(user);
        break;
      }
    }
  },

  LEAVING_USER (state, user) {
    for (let i = 0; i < state.conversations.length; i++) {
      if (state.activeUsers[i][0].conversation_id === user.conversation_id) {
        for (let c = 0; c < state.activeUsers[i].length; c++) {
        if (state.activeUsers[i][c].id === user.id) {
            state.activeUsers[i].splice(c,1)
            break
        }
      }
      }
    }
  }
}

const actions = {
  // Frontend
  showConversationList ({ commit }) {
    commit('SHOW_CONVERSATION_LIST')
  },

  closeModal ({ commit }) {
    commit('CLOSE_MODAL')
  },

  newMessage ({ commit }) {
    commit('NEW_MESSAGE')
  },

  addRecipient: ({commit}, recipient) => {
    commit('ADD_RECIPIENT', recipient)
  },

  removeRecipient: ({commit}, id) => {
    commit('REMOVE_RECIPIENT', id)
  },

  // Backend 
  setConversationList: ({commit}, conversations) => {
    return axios.get('/conversation')
      .then(response => {
        if (response.status === 200) {
          commit('SET_CONVERSATION_LIST', response.data)

          for(let i = 0; i < response.data.length; i++) {
            Echo.join('conversation.' + response.data[i].id)
              .here((users) => {
                 commit('ACTIVE_USERS', users)
              })
              .joining((user) => {
                  commit('JOINING_USER', user)
              })
              .leaving((user) => {
                  commit('LEAVING_USER', user)
              })
              .listen('MessageWasCreated', (data) => {
                  commit('SEND_MESSAGE', data.message)
              })
          }
        }
      })
  },

  createConversation: ({commit}, recipient) => {
    return axios.post('/create-conversation', recipient)
      .then(response => {
        if (response.status === 200) {

          Echo.join('conversation.' + response.data.id)
            .here((users) => {
               commit('NEW_ACTIVE_USER', users)
            })
            .joining((user) => {
                commit('JOINING_USER', user)
            })
            .leaving((user) => {
                commit('LEAVING_USER', user)
            })
            .listen('MessageWasCreated', (data) => {
                commit('SEND_MESSAGE', data.message)
            })

          setTimeout(() => { 
            commit('CREATE_CONVERSATION', response.data)
          }, 2000);
        }
      })
  },

  showConversation: ({commit}, id) => {
    return axios.get('/show-conversation/'+id)
      .then(response => {
        if (response.status === 200) {
          commit('SHOW_CONVERSATION', response.data)
        }
      })
  },

  sendMessage: ({commit}, message) => {
    return axios.post('/message', message)
      .then(response => {
        if (response.status === 200) {
          commit('SEND_MESSAGE', response.data)
        }
      })
  }
}

export default {
  state, mutations, actions
}