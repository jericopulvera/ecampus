<template>
	<a class="nav-item is-tab" @click="showConversationList"><i class="fa fa-envelope"></i> &nbsp; Messages</a>
</template>

<script>
	import {mapState} from 'vuex';
	import eventHub from '../../event';

	export default {
		computed: {
			...mapState({
				conversationStore: state => state.conversationStore
			})
		},

		mounted() {
			this.listen();
		},

		methods: {
			listen() {
				this.$store.dispatch('setConversationList');
				eventHub.$on('add-user', this.addUser);
				eventHub.$on('remove-user', this.removeUser);
			},

			addUser(user) {
				let users = this.users;
				let id = users.length + 1;
				    let found = users.some(function (el) {
				      return el.usn === user.usn;
				    });
				    if (!found) {
				        this.users.push(user);
				    }
			},

			removeUser(id) {
			  for (var i = 0; i <= this.users.length; i++) {
			      if (this.users[i].id === id) {
			          this.users.splice(i,1);
			          break
			      }
			  }
			},

			showConversationList() {
				this.$store.dispatch('showConversationList');
			},

			showConversation(id) {
				this.$store.dispatch('showConversation', id);
			}
		}
	}
</script>