<template>
    <div class="columns">

        <left-panel style="order: 0;"></left-panel>
        <right-panel style="order: 2;" :user="$root.user"></right-panel>
        
        <div class="column is-6" style="order: 1;">
           
            <posts v-for="post in posts" :post="post" :key="post.id"></posts>

                <infinite-loading :on-infinite="onInfinite" ref="infiniteLoading">
                    <span slot="no-more">
                        No more posts
                    </span>
                    <span slot="no-results">
                      <div class="notification is-info" v-show="show">
                        <p>Your feed is currently empty, </p> <p> Follow more users to see more posts in your newsfeed. </p>
                      </div>
                    </span>
                </infinite-loading>
              
        </div>

        
    </div>
</template>

<script>
    import eventHub from '../../event';
    import InfiniteLoading from 'vue-infinite-loading';

    export default {
        components: {
            InfiniteLoading
        },

        data () {
            return {
                posts: [],
                show: false,
                body: '',
                title: '',
                time: 30,
                page: 2,
                lastPage: null,
                loading: false,
            }
        },

        mounted () {
            this.fetchPosts();
            this.listen();
            eventHub.$on('add-post', this.addPost);
            eventHub.$on('delete-post', this.deletePost);
        },

        methods: {
            listen () {
                window.addEventListener('scroll', this.handleScroll);
            },

            addPost (post) {
                this.posts.unshift(post);
                this.show = false
            },

            deletePost (id) {
                for (var i = 0; i <= this.posts.length; i++) {
                    if (this.posts[i].id === id) {
                        this.posts.splice(i,1)
                        break
                    }
                }
            },

            fetchPosts () {
                axios.get('/posts').then((response) => {
                if(response.data.data.length == 0) {
                    this.posts = response.data.data
                    this.$refs.infiniteLoading.$emit('$InfiniteLoading:complete');
                } else {
                    this.$refs.infiniteLoading.$emit('$InfiniteLoading:loaded');
                    this.posts = response.data.data
                    this.lastPage = response.data.last_page
                  if (this.lastPage == 1) {
                      this.$refs.infiniteLoading.$emit('$InfiniteLoading:complete');
                  }
                }
             })
                if (this.posts.length === 0) {
                    this.show = true;
                }
            },

            onInfinite() {},

            handleScroll: _.debounce(
               function () {
                var self = this
                if(this.posts.length == 0) {
                   this.$refs.infiniteLoading.$emit('$InfiniteLoading:complete');
                 }
                 if(this.page <= this.lastPage) {
                     if (($(document).scrollTop() + $(window).outerHeight()) + 300 >= $(window).height()) {
                         this.loadMore()
                       }
                 }
               }, 400),

            loadMore () {
                 if(this.page <= this.lastPage) {
                 axios.get('/posts?page=' + this.page).then((response) => {
                     this.page++
                     for(var key = 0; key < response.data.data.length; key++){
                         this.posts.push(response.data.data[key])
                     }
                     if (this.page > this.lastPage) {
                         this.$refs.infiniteLoading.$emit('$InfiniteLoading:complete');
                     }
                  })
               }
            }
        }
    }
</script>
