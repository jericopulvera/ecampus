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
                    </p>
                        <small class="is-full-width">

                        <a :class="{'is-disabled': disable}" @click.prevent="like">{{likeText}}</a> ·
                        <a @click.prevent="reply()">Reply</a> ·
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
                
                <article class="media" v-if="post.comments.length > 0" v-for="comment in comments" :key="comment.id">
                    <figure class="media-left">
                        <p class="image is-48x48">
                            <img :src="comment.user.image">
                        </p>
                    </figure>
                    <div class="media-content">
                        <div class="content">
                            <p>
                                <a href="#">
                                    <strong>{{comment.user.name}}</strong> &commat;{{comment.user.username}}
                                </a>
                                <br>
                                {{comment.body}}
                                <br>
                                <small>
                                <a v-if="comment.likedByCurrentUser" @click="likeComment(comment.id)">Unlike</a>
                                <a v-else @click="likeComment(comment.id)">Like</a> ·
                                <a @click="reply(comment.user.username)">Reply</a> ·
                                {{comment.readableDate}} · {{comment.likesCount}} {{ pluralize('like', comment.likeCount) }}
                                </small>
                            </p>
                        </div>
                    </div>
                    <div class="media-right">
                          <a @click="openEditCommentOption(comment)" 
                                v-if="$root.user.id == comment.user.id"><i class="fa fa-minus-circle"></i>
                          </a>
                          <a  
                            v-if="$root.user.id != comment.user.id 
                                && $root.user.privilege == 'Dean' 
                                && $root.user.id != post.user.id" 
                                @click="deleteComment(comment.id)">
                                <i class="fa fa-times-circle"></i>
                          </a>
                          <a  
                            v-if="$root.user.id != comment.user.id
                                 && $root.user.privilege != 'Dean' 
                                 && $root.user.id == post.user.id" 
                                @click="deleteComment(comment.id)">
                                <i class="fa fa-times-circle"></i>
                          </a>
                          <a  
                            v-if="$root.user.id != comment.user.id
                                 && $root.user.privilege == 'Dean' 
                                 && $root.user.id == post.user.id" 
                                @click="deleteComment(comment.id)">
                                <i class="fa fa-times-circle"></i>
                          </a>
                    </div>
                </article>

                <!-- REPLY FORM -->
                <article class="media" v-show="check">
                    <figure class="media-left">
                        <p class="image is-48x48">
                            <img :src="$root.user.image">
                        </p>
                    </figure>
                    <div class="media-content">
                        <p class="control">
                            <textarea v-html class="textarea" placeholder="Write a comment..." ref="reply"
                            v-model="commentBody" maxlength="500"></textarea>
                        </p>
                        <p class="control">
                            <button class="button" @click.prevent="submitComment">Post comment</button>
                        </p>
                    </div>
                </article>
                <!-- REPLY -->
            </div>

            <div class="media-right" v-if="$root.user.privilege == 'Dean' || $root.user.id == this.post.user.id">
                <a @click="postOptions = true" v-if="$root.user.id == this.post.user.id"><i class="fa fa-minus-circle"></i></a>
                <a class="delete" v-else @click="deletePost(this.post.id)"></a>
            </div>

        </article>

        <div class="modal is-active" v-if="postOptions">
            <div class="modal-background"></div>
            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title">Edit Post</p>
                </header>
                <section class="modal-card-body">
                    <div class="media-content">
                        <p class="control">
                            <textarea class="textarea" maxlength="2200" placeholder="Write something..." v-model="body"></textarea>
                        </p>
                    </div>
                </section>
                <footer class="modal-card-foot">
                    <a class="button is-primary" @click="editPost()">Save changes</a>
                    <a class="button is-danger" @click="deletePost()">Delete post</a>
                    <a class="button" @click="cancel()">Cancel</a>
                </footer>
            </div>
        </div>

        <div class="modal is-active" v-if="commentOptions">
            <div class="modal-background"></div>
            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title">Edit Comment</p>
                </header>
                <section class="modal-card-body">
                    <div class="media-content">
                        <p class="control">
                            <textarea class="textarea" maxlength="500" placeholder="Write something..." v-model="commentBody"></textarea>
                        </p>
                    </div>
                </section>
                <footer class="modal-card-foot">
                    <a class="button is-primary" @click="editComment(commentHolder.id)">Save changes</a>
                    <a class="button is-danger" @click="deleteComment(commentHolder.id)">Delete comment</a>
                    <a class="button" @click="cancelEditComment(commentHolder.id)">Cancel</a>
                </footer>
            </div>
        </div>
    </div>


</template>

<script>
    import eventHub from '../../event'
    import pluralize from 'pluralize'

    export default {
        props: ['post'],

        mounted () {
            this.body = this.post.body;
            this.listen();
        },

        data () {
            return {
                check: false,
                disable: false,
                counter: 1,
                postOptions: false,
                body: '',
                commentOptions: false,
                commentHolder: {},
                commentBody: '',
                comments: [],
            }
        },

        computed: {
            likeText: function () {
                if (this.post.likedByCurrentUser) {
                    return 'Unlike'
                }
                return 'Like';
            }
        },

        methods: {
            pluralize,

            listen () {
                this.comments = this.post.comments;
                Echo.private('post.'+this.post.id).listen('PostLikeUpdated', (e) => {
                    if (e.like)
                        this.post.likesCount++;
                    else
                        this.post.likesCount--;
                })

                Echo.private('post.'+this.post.id).listen('CommentWasCreated', (e) => {
                    this.comments.push(e.comment);
                })

                Echo.private('post.'+this.post.id).listen('CommentLikeUpdated', (e) => {
                    this.commentLikeUpdated(e.comment, e.like)
                })
            },
            // COMMENT ACTIONS
            openEditCommentOption(comment) {
                this.commentHolder = comment;
                let body = comment.body;
                this.commentBody = body;
                this.commentOptions = true;
            },

            cancelEditComment(id) {
                for (var i = 0; i <= this.comments.length; i++) {
                    if (this.comments[i].id === id) {
                        if (this.comments[i].body != this.commentBody) {
                            
                            var confirm = window.confirm('Discard changes?')

                            if (confirm) {
                                this.commentHolder.body = this.comments[i].body;
                                this.commentOptions = false;
                            }
                        } else {
                            this.commentOptions = false;
                        }
                        break
                    }

                }
            },

            deleteComment(id) {
                var confirm = window.confirm("Are you sure you wan't to delete this comment?");
                if (confirm) {
                    axios.delete('comment/'+id).then(response => {
                        this.commentOptions = false;
                        for (var i = 0; i <= this.comments.length; i++) {
                            if (this.comments[i].id === id) {
                                this.comments.splice(i,1)
                                this.commentsCount--
                                break
                            }
                        }
                    }).catch(error => {
                        alert('this comment has already been deleted');
                        for (var i = 0; i <= this.comments.length; i++) {
                            if (this.comments[i].id === id) {
                                this.comments.splice(i,1)
                                this.commentsCount--
                                break
                            }
                        }
                        this.commentOptions = false;
                    })
                }
            },

            editComment(id) {
                if (this.commentHolder.body != this.commentBody) {
                    axios.patch('comment/'+id, {body: this.commentBody}).then(response => {
                        this.postOptions = false;
                        this.commentHolder.body = this.commentBody;
                    }).catch(error => {
                        alert('this comment has already been deleted');
                        for (var i = 0; i <= this.comments.length; i++) {
                            if (this.comments[i].id === id) {
                                this.comments.splice(i,1);
                                this.commentsCount--;
                                break
                            }
                        }
                        this.commentOptions = false;
                    })
                } else {
                    this.postOptions = false;
                }
            },

            commentLikeUpdated(comment, like) {
                for (var i = 0; i <= this.comments.length; i++) {
                    if (this.comments[i].id === comment.id) {
                        if (like)
                            this.comments[i].likesCount++;
                        else
                            this.comments[i].likesCount--;
                        break
                    }
                }
            },

            likeComment(id) {
                for (var i = 0; i <= this.comments.length; i++) {
                    if (this.comments[i].id === id) {
                        if (this.comments[i].likedByCurrentUser) 
                            axios.delete('/comment-like/'+id).then(response => {
                                 this.comments[i].likedByCurrentUser = false;
                                 this.comments[i].likesCount--; 
                            }).catch(error => {
                                alert('this comment has already been deleted');
                                for (var i = 0; i <= this.comments.length; i++) {
                                    if (this.comments[i].id === id) {
                                        this.comments.splice(i,1)
                                        this.commentsCount--
                                        break
                                    }
                                }
                            })
                        else 
                            axios.post('/comment-like/'+id+'/'+this.post.id).then(response => {
                                 this.comments[i].likedByCurrentUser = true;
                                 this.comments[i].likesCount++;
                            }).catch(error => {
                                alert('this comment has already been deleted');
                                for (var i = 0; i <= this.comments.length; i++) {
                                    if (this.comments[i].id === id) {
                                        this.comments.splice(i,1)
                                        this.commentsCount--
                                        break
                                    }
                                }
                            })
                        break
                    }
                }
            },
            // COMMENT ACTIONS END

            // POST ACTIONS
            cancel() {
                if (this.post.body != this.body ) {
                    var confirm = window.confirm('Discard changes?')

                    if (confirm) {
                        this.body = this.post.body;
                        this.postOptions = false;
                    }
                } else {
                    this.postOptions = false;
                }
                
            },

            deletePost() {
                var confirm = window.confirm("Are you sure you wan't to delete this post?");
                if (confirm) {
                    axios.delete('posts/'+this.post.id).then(response => {
                        this.postOptions = false;
                        eventHub.$emit('delete-post', this.post.id);
                    })
                }
            },

            editPost() {
                if (this.post.body != this.body) {
                    axios.patch('posts/'+this.post.id, {body: this.body}).then(response => {
                        this.postOptions = false;
                        this.post.body = this.body;
                    })
                } else {
                    this.postOptions = false;
                }
            },

            viewPreviousComments () {
                axios.get('/comment/'+ this.post.id +'/'+ this.counter).then(response => {
                    let comments = response.data;
                    for (let comment of comments) {
                        this.post.comments.unshift(comment);
                    }
                })
            },

            like () {
                this.disable = true;
                if (this.post.likedByCurrentUser) {
                    axios.delete('/like/'+ this.post.id).then(response => {
                         this.post.likedByCurrentUser = false;
                         this.post.likesCount--; 
                         Vue.nextTick(() =>{ this.disable = false; });
                    }).catch(error => {
                        alert('This post has already been deleted!');
                        eventHub.$emit('delete-post', this.post.id)
                    });
                }
                else {
                    axios.post('/like/'+ this.post.id).then(response => {
                         this.post.likedByCurrentUser = true;
                         this.post.likesCount++;
                         Vue.nextTick(() =>{ this.disable = false; });
                    }).catch(error => {
                        alert('This post has already been deleted!');
                        eventHub.$emit('delete-post', this.post.id)
                    });
                }

            },

            reply (name) {
                this.check = true;
                var self = this;

                if (name) {
                    self.commentBody = '@'+name+' '
                }

                Vue.nextTick(function () {
                    self.$refs.reply.focus();
                });
                
            },

            submitComment() {
                if (this.commentBody.trim() != '')
                axios.post('/comment/'+ this.post.id, {body: this.commentBody})
                    .then(response => {
                        this.reply();
                        this.comments.push(response.data);
                        this.commentBody = '';
                    }).catch(error => {
                        alert('This post has already been deleted!');
                        eventHub.$emit('delete-post', this.post.id)
                    });
            } // POST ACTIONS END


        }
    }
</script>

<style scoped>
    p {
        word-break: break-all;
    }
</style>
