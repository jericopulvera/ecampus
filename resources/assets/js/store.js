import Vue from 'vue'
import Vuex from 'vuex'

import groupStore from './components/group/store/groupStore'
import conversations from './components/conversation/store/modules/conversations'

Vue.use(Vuex)

const debug = process.env.node_ENV !== 'production'

export default new Vuex.Store({
	modules: {
		 groupStore, conversations
	},
	strict: debug
})
