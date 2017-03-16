<template>
<div class="container profile" v-cloak>
    <div class="section profile-heading">
        <div class="columns">
            <div class="column is-2">
                <div class="image is-128x128 avatar">
                    <img :src="user.image">
                </div>
            </div>
            <div class="column is-4 name">
                <p>
                    <span class="title is-bold" :title="user.usn">{{ user.name }}</span> <small :title="user.usn">@{{ user.username }}</small>
                </p>
                <p>
                <br>
                <div class="block is-pulled-left">
                    <a :href="'/schedule/'+user.usn" class="button is-info" style="margin-left: 5px;">View Schedule</a> &nbsp;
                    <a class="button is-info follow" :class="{'is-loading': loading }" @click="followUser(user.usn)">{{isFollowing ? 'Unfollow' : 'Follow'}}</a>
                </div>
            </div>
            <div class="column is-2 followers has-text-centered">
                <p class="stat-val">{{user.followerCount}}</p>
                <p class="stat-key">followers</p>
            </div>
            <div class="column is-2 following has-text-centered">
                <p class="stat-val">{{user.followCount}}</p>
                <p class="stat-key">following</p>
            </div>
            <div class="column is-2 likes has-text-centered">
                <p class="stat-val">{{user.postCount}}</p>
                <p class="stat-key">posts</p>
            </div>
        </div>
    </div>
    <div class="profile-options">
        <div class="tabs is-fullwidth">
            <ul>
                <li class="link" :class="[tab === 2 ? 'is-active' : '']" @click="tab = 2"><a><span class="icon"><i class="fa fa-th"></i></span> <span>Posts</span></a></li>
            </ul>
        </div>
    </div>
    <div class="spacer"></div>
        <search-user-feed :user="user"></search-user-feed>

</div>
</template>

<script>
	export default {
		mounted () {
			this.user = user;
			this.isFollowing = user.isFollowing;
		},

		data () {
			return {
				user: {},
				isFollowing: null,
				loading: false,
				tab: 2,
			}
		},

		methods: {
			followUser(usn) {
				this.loading = true;

				if (this.isFollowing) {
					noty({ text: 'You successfully unfollowed ' + this.user.name , type: 'success', timeout: 2000});
					this.isFollowing = false
				} else {
					noty({ text: 'You are now following ' + this.user.name , type: 'success', timeout: 2000});
					this.isFollowing = true
				}

				axios.post('/follow/'+usn)
					.then(response => {
						setTimeout(() => {
							this.loading = false
						}, 1000)
					})
					.catch(error => {
						alert('something went wrong. please reload the page.')
					})

			}
		}
	}
</script>
