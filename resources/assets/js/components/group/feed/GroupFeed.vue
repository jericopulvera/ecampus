<template>
	<div class="content">

	   <p class="control">
	     <textarea class="textarea is-focused" :class="{'is-disabled': loading}" placeholder="Write a something..." v-model="body"></textarea>
	     <a @click="createPost" class="button is-info is-fullwidth" :class="{'is-loading': loading}">Submit</a>
	   </p>

	   <group-post v-for="post in posts" :post="post" :key="post.id"></group-post>

	</div>
</template>

<script>
    import eventHub from '../../../event'

	export default {
		created () {
			this.fetchClassPosts()
			this.$on('load-post', this.fetchClassPosts);
			eventHub.$on('remove-post', this.removePost);
		},

		data () {
			return {
				posts: [],
				body: '',
				loading: false,
				lastPage: null,
			}
		},

		methods: {
			removePost (id) {
				for (let i = 0; i < this.posts.length; i++) {
					if (this.posts[i].id == id) {
						this.posts.splice(i,1);
						break;
					}
				}
			},

			fetchClassPosts () {
			    axios.get('/webapi/group/posts/'+group.slug).then((response) => {
			        this.posts = response.data.data
			        this.lastPage = response.data.last_page
				    eventHub.$emit('clear')
			     })

			},

			addPosts (post) {
				this.posts.unshift(post);
			},

			createPost() {
				if (this.body.trim() != '') {
					this.loading = true
					axios.post('/webapi/group/post/' + group.slug, { body: this.body })		
					    .then(response => {
					         setTimeout( () => {
						         this.loading = false
						         this.body = ''
						         this.posts.unshift(response.data)
					         }, 1000)
					    })
					    .catch(error => {
					    	alert(error)
					    });
				}
			}
		}
	}
</script>
