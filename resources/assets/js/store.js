import Vue from 'vue'
import Vuex from 'vuex'

import groupStore from './components/group/store/groupStore'
import conversationStore from './components/conversation/store/conversationStore'

Vue.use(Vuex)

const debug = process.env.node_ENV !== 'production'

export default new Vuex.Store({
	modules: {
		 groupStore, conversationStore
	},
	strict: debug
})
