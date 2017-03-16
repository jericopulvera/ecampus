<template>
    <div class="box">

        <article class="media">
            <figure class="media-left">
                <p class="image is-64x64">
                    <img :src="post.user.image">
                </p>
            </figure>
            <div class="media-content">
                <div class="content">
                    <p>
                        <a :href="'/'+post.user.usn" target="_blank"><strong>{{post.user.name}}</strong>  <small> @{{post.user.username}}</small></a>
                        <br>
                        {{post.body}}
                        <br>
                        <small>
                        <a :class="{'is-disabled': disable}" @click.prevent="like">{{likeText}}</a> ·
                        <a @click="reply">Reply</a> · 
                        <abbr :title="post.readableDate"> <a>{{post.readableDate}}</a> </abbr>
                        <br>
                        <a> {{post.likesCount}}
                            {{ pluralize('like', post.likesCount) }} ·
                            {{post.comments.length}}
                            {{ pluralize('comment', post.commentsCount) }}
                        </a>
                        </small>
                        <br>
                        <a @click="viewPreviousComments"
                            v-if="post.comments.length < post.commentsCount">
                            <small>View previous comments </small>
                        </a>
                        <a v-if="post.comments.length < post.commentsCount">
                            <small class="is-pulled-right">· {{post.comments.length}} of {{ post.commentsCount}}
                            </small>
                        </a>
                    </p>
                </div>
                
                <!-- COMMENT LIST -->
                <group-comment v-for="comment in comments" :comment="comment" :key="comment.id"></group-comment>

                <!-- REPLY FORM  -->
                <group-comment-form :id="post.id" :key="post.id"></group-comment-form>
            </div>

            <div class="media-right" v-if="$root.user.id == groupStore.admin.id || $root.user.id == this.post.user.id">
                <a class="delete" @click="removePost(post.id)"></a>
            </div>
        </article>
        
    </div>
</template>

<script>
    import {mapState} from 'vuex'
    import pluralize from 'pluralize'
    import eventHub from '../../../event'

    export default {
        props: ['post'],

        mounted () {
            this.comments = this.post.comments;
            eventHub.$on('remove-post-comment', this.removeComment);
            eventHub.$on('new-comment', this.pushComment)
        },

        data () {
            return {
                disable: false,
                comments: [],
            }
        },

        computed: {
            ...mapState({
                groupStore: state => state.groupStore
            }),

            likeText: function () {
                if (this.post.likedByCurrentUser) {
                    return 'Unlike'
                }
                return 'Like';
            }
        },

        methods: {
            pluralize,

            pushComment(comment) {
                this.comments.push(comment)
            },

            removeComment(id) {
                for (let i = 0; i < this.post.comments.length; i++) {
                    if (this.post.comments[i].id == id) {
                        this.post.comments.splice(i,1)
                        break;
                    }
                }
            },

            like() {
                this.disable = true

                if (this.post.likedByCurrentUser) { this.post.likesCount-- }
                else { this.post.likesCount++ }

                this.post.likedByCurrentUser = !this.post.likedByCurrentUser;

                axios.post('/webapi/group/like-post/'+this.post.id)
                    .then(response => {
                        setTimeout(() => {
                            this.disable = false
                        }, 500)
                    })
                    .catch (error => {
                        alert('something went wrong please reload the page.')
                    })

                
            },

            reply() {
                eventHub.$emit('reply-focus'+this.post.id)
            },

            removePost(id) {
                var confirm = window.confirm('Are you sure you want to delete this post?')

                if (confirm) {
                    eventHub.$emit('remove-post', id)
                    axios.delete('/webapi/group/post/'+id)
                        .then(response => {
                        })
                        .catch(error => {
                            alert('something went wrong please reload the page.')
                        })
                }
            }
        }

    }
</script>


