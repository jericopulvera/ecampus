<template>
	<div class="modal is-active" v-if="conversationStore.conversationModal === 'create'" style="white-space: normal; text-align: left;">
		<div class="modal-background"></div>
		<div class="modal-card">
			<header class="modal-card-head">
				<a @click="showConversationList"><i class="fa fa-chevron-left"></i></a>
				<div class="modal-card-title has-text-centered">New Message</div>
				<a @click="closeModal"><i class="fa fa-close"></i></a>
			</header>
			<section class="modal-card-body">
				<add-user></add-user>
				<!-- to -->
				<div class="tabs" style="margin-top: 10px;">
				  <ul style="border: none; display: block;">
				    <li v-for="user in conversationStore.recipient" :key="user.id">
				        <span class="tag is-primary is-medium">{{user.name}} | @{{user.username}} | {{user.usn}} &nbsp; <a @click="removeRecipient(user.usn)" class="is-paddingless"><i class="fa fa-close"></i> </a></span>
				    </li>
				  </ul>
				</div>

				<!-- conversation name if more than 2 user -->

				<p class="control" v-if="conversationStore.recipient.length > 1">
				  <label class="label">Conversation Name</label>
				  <input type="text" class="input" placeholder="Enter conversation name" v-model="name">
				</p>
				
				<p class="control">
				  <label class="label">Message</label>
				  <textarea class="textarea" placeholder="Write a message..." v-model="message"
				  :class="loading ? 'is-disabled' : ''"></textarea>
				</p>

			</section>
			<footer class="modal-card-foot">
			     <a v-if="conversationStore.recipient.length < 2" class="button is-info" :class="[
			       conversationStore.recipient.length == 0 ? 'is-disabled' : '', 
			       message.trim() == '' ? 'is-disabled' : '',
			       loading ? 'is-loading' : ''
			      ]" style="width: 100%;" @click="createConversation">Next</a>

			      <a v-if="conversationStore.recipient.length >= 2" class="button is-info" :class="[
			        name.trim() == '' ? 'is-disabled' : '',
			        message.trim() == '' ? 'is-disabled' : '',
			        loading ? 'is-loading' : ''
			       ]" style="width: 100%;" @click="createConversation">Next</a>
			 </footer>
		</div>
	</div>

</template>

<script>
import {mapState} from 'vuex';

export default {
	computed: {
		...mapState({
			conversationStore: state => state.conversationStore
		})
	},

	data () {
	  	return {
	     	loading: false,   
	     	message: '',
	     	name: ''
	  	}
	},

    methods: {
    	showConversationList() {
    		this.$store.dispatch('showConversationList');
    	},

    	closeModal() {
    		this.$store.dispatch('closeModal');
    	},

    	createConversation() {
    		this.loading = true;
    		this.$store.dispatch('createConversation', {
    			'recipient': this.conversationStore.recipient, 
    			'message': this.message,  
    			'name': this.name 
    		});
    		this.name = '';
    		this.message = '';
            setTimeout(() => { this.loading = false;}, 3500);

    	},

    	removeRecipient(id) {
    		this.$store.dispatch('removeRecipient', id)
    	}
    }
}
</script>

<style lang="css" scoped>
	.modal-card {
	 	height: 844px;
	}
	.media {
		border-bottom: 1px solid #e1e8ed;
	}
	.media:hover {
		background-color: #f5f8fa!important;
		text-decoration: none;
	}
</style>
