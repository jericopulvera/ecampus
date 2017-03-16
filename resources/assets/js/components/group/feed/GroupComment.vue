<template>
    <article class="media">
        <figure class="media-left">
            <p class="image is-48x48">
                <img :src="comment.user.image">
            </p>
        </figure>
        <div class="media-content">
            <div class="content">
                <p>
                    <a :href="'/'+comment.user.usn" target="_blank"><strong>{{comment.user.name}}</strong>  <small> @{{comment.user.username}}</small></a>
                    <br>
                    {{comment.body}}
                    <br>
                    <small>
                    <a :class="{'is-disabled': disable}" @click="like">{{likeText}}</a> ·
                    <abbr :title="comment.readableDate"> <a>{{comment.readableDate}}</a> </abbr>
                    <br>
                    <a> {{comment.likesCount}}
                        {{ pluralize('like', comment.likesCount) }} 
                    </a>
                    </small>
                </p>
            </div>
        </div>
        <div class="media-right" v-if="$root.user.id == groupStore.admin.id || $root.user.id == comment.user.id">
            <a class="delete" @click="removeComment(comment.id)"></a>
        </div>
    </article>
</template>

<script>

    import {mapState} from 'vuex'
    import pluralize from 'pluralize'
    import eventHub from '../../../event'

    export default {
        props: ['comment'],

        data () {
            return {
                disable: false,
            }
        },

        computed: {
            ...mapState({
                groupStore: state => state.groupStore
            }),

            likeText: function () {
                if (this.comment.likedByCurrentUser) {
                    return 'Unlike'
                }
                return 'Like';
            }
        },

        methods: {
            pluralize,

            removeComment(id) {
                var confirm = window.confirm('Are you sure you want to delete this post?')

                if (confirm) {
                    eventHub.$emit('remove-post-comment', id)
                    axios.delete('/webapi/group/comment/'+id+'/'+group.slug)
                        .then(response => {
                        })
                        .catch(error => {
                            alert('something went wrong please reload the page.')
                        })
                }

                this.disable = false
            },

            like() {
                this.disable = true

                if (this.comment.likedByCurrentUser) { this.comment.likesCount-- }
                else { this.comment.likesCount++ }

                this.comment.likedByCurrentUser = !this.comment.likedByCurrentUser;

                axios.post('/webapi/group/like-post-comment/'+this.comment.id)
                    .then(response => {
                        setTimeout(() => {
                            this.disable = false
                        }, 500)
                    })
                    .catch (error => {
                        alert('something went wrong please reload the page.')
                    })
                
            }
        }
    }
</script>
