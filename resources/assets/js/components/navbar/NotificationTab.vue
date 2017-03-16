<template>
	<a href="/notifications" class="nav-item is-tab">
		<i class="fa fa-bell-o"></i> &nbsp; Notifications 
		<span class="tag is-danger" v-if="unreadCount > 0">
		  	{{unreadCount}}
		</span>
	</a>
</template>

<script>
	export default {
		data () {
			return {
				unreadCount: 0
			}
		},

		mounted () {
			this.get_unread();
			this.listen()
		},

		methods: {
			listen() {
				Echo.private('App.User.'+this.$root.user.id)
				    .notification((notification) => {

                        this.$root.$emit('added-notification', notification)
                        
				    	noty({ 
                            text: notification.message,
                            type: notification.noty_type,
                            timeout: 4000,
                        });

                        if (this.$root.path != 'notifications'){
    				    	this.unreadCount++
                        }

                        document.getElementById("noty_audio").play()
				});

					    		
			},

			get_unread() {
				axios.get('/get-unread').then(response => {
					// COMMENTS NOTIFICATION
					let comments = _.filter(response.data, function(data){
					  return data.type === "App\\Notifications\\PostComment";
					}); 

					var combinedUniqueComments = _.uniqBy(comments, function(data){
					    return data.data.comment.post_id;
					});					

					this.unreadCount = this.unreadCount + combinedUniqueComments.length;
					//!!!COMMENTS NOTIFICATION


					// POST LIKES NOTIFICATION
					var postLikes = _.filter(response.data, function(data){
					  return data.type === "App\\Notifications\\PostLike";
					}); 

					var combinedUniquePostLikes = _.uniqBy(postLikes, function(data){
					    return data.data.post.id;
					});

					this.unreadCount = this.unreadCount + combinedUniquePostLikes.length;
					//!!! POST LIKES NOTIFICATION

					// COMMENT LIKES NOTIFICATION
					var commentLikes = _.filter(response.data, function(data){
					  return data.type === "App\\Notifications\\CommentLike";
					}); 

					var combinedUniqueCommentLikes = _.uniqBy(commentLikes, function(data){
					    return data.data.comment.id;
					});

					this.unreadCount = this.unreadCount + combinedUniqueCommentLikes.length;
					//!!! COMMENT LIKES NOTIFICATION
					
				});
			}
		}
	}
</script>
