<template>
	<div class="modal is-active" v-if="conversationStore.conversationModal === 'list'" style="white-space: normal; text-align: left;">
		<div class="modal-background"></div>
		<div class="modal-card">
			<header class="modal-card-head">
				<div class="modal-card-title">Direct Messages</div>
				<a @click="newMessage" class="button is-primary">New Message</a>
				<a @click="closeModal"><i class="fa fa-close"></i></a>
			</header>
			<section class="modal-card-body is-paddingless">

			<a @click="showConversation(conversation.id)" v-for="conversation in conversationStore.conversations" :key="conversation.id">
				<div class="box">
					<div class="box-info">
					    <img width="200" height="200" id="drop-image" :src="conversation.image" alt="" />
					   <span>{{conversation.conversationName}} &nbsp;</span>
					   <span class="tag is-danger">1</span>
					</div>
				</div>
			</a>

			</section>
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

    methods: {
    
    	closeModal() {
    		this.$store.dispatch('closeModal');
    	},

    	newMessage() {
    		this.$store.dispatch('newMessage');
    	},

    	showConversation(id) {
    		this.$store.dispatch('showConversation', id);
    	}
    }
}
</script>

<style lang="css" scoped>
	.box-info {
		display: flex;
		align-items: center;
		justify-content: center;	
	}
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
	
	.is-primary {
		margin-right: 10px;
	}
	.image {
		margin: 10px 0px 10px 10px;
	}
	.media {
		margin-bottom: 10px;
	}
</style>
