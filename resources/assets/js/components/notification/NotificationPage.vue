<template>
    <div class="columns">

        <div class="column is-6" style="order: 1;">
            <div class="panel container has-text-centered">
                <div class="panel-heading">
                    Notifications
                </div>
                <div class="panel-block">
                    <div class="control">
                        <div class="notification">
                            <button class="delete" onclick="((this).parentNode.remove())"></button>
                            <strong>Cron job successfully completed.</strong>
                            <br>
                            <small>2h ago | via: system</small>
                        </div>
                    </div>
                </div>
            </div>
           <!--  <article class="media box">
                <div class=" event-timeline">
                    <p>
                        <a>
                            All Notifications
                        </a>
                    </p>
                    <hr>
                    <p class="event-item" v-if="notifications.length === 0">
                        <span class="subtitle">You have no notifications</span>
                    </p>
                    <p class="event-item" v-for="noty in notifications" :key="noty.id">
                        <span class="icon-item-type"><i class="fa fa-star"></i></span>
                        <a href="#" v-if="noty.type != 'App\\Notifications\\AcceptedInGroup'">{{noty.data.user.name}}</a>
                        <a v-else>{{ noty.data.group.subject }}</a>
                        <span v-if="noty.type == 'App\\Notifications\\PostLike'">
                            liked your post <a href="#">{{noty.data.post.title}}</a> &nbsp;
                        </span>
                        <span v-if="noty.type == 'App\\Notifications\\PostComment'">
                            reacted on your post <a href="#">{{noty.data.post.title}}</a> &nbsp;
                        </span>
                        <span v-if="noty.type == 'App\\Notifications\\CommentLike'">
                            liked your comment <a href="#">{{noty.data.comment.body}}</a> &nbsp;
                        </span>
                        
                        <span v-if="noty.type == 'App\\Notifications\\AcceptedInGroup'">
                            <a :href="'/groups/' + noty.data.group.slug" target="_blank" >
                                {{noty.data.message}}
                            </a>
                        </span>
                        
                        <span v-if="noty.type == 'App\\Notifications\\FollowUser'">
                            <a :href="noty.data.user.usn" target="_blank">
                                {{noty.data.message}}
                            </a>
                        </span>
                        
                        <span v-if="noty.type != 'App\\Notifications\\FollowUser' && noty.type != 'App\\Notifications\\AcceptedInGroup'">
                            <a :href="'/post/'+noty.data.post.slug" target="_blank">
                                {{noty.data.message}}
                            </a>
                        </span>
                        
                        <small>{{noty.readableDate}}</small>
                    </p>
                    
                </div>
            </article> -->
        </div>
        
        <left-panel style="order: 0;"></left-panel>
        <right-panel style="order: 2;"></right-panel>
        
    </div>
</template>

<script>
    export default {
        mounted () {
            this.getNotifications()
            this.listen()
        },

        data () {
            return {
                notifications: []
            }
        },

        methods: {
            listen() {

            },

            getNotifications() {
                axios.get('/get-notifications').then((response) => {
                    this.notifications = response.data
             })
            }
        }
    }
</script>

<style scoped>
    .has-text-muted {
      color: #95A5A6;
    }
    .spacer {
      height:20px;
    }
    .nav-left .searchbox {
      margin-top: 10px;
    }
    .nav.is-default {
      background-color:#f5f5f5;
    }
    .icon-chevron {
      font-size: 12px;
    }
    .icon-item-type i {
      font-size:12px;
      padding:6px 15px 6px 6px;
      color:#bbbbbb;
    }
    .event-timeline hr {
      margin-top: 10px;
    }
    p.event-item {
      padding: 10px 10px 10px 0;
      border-bottom: 1px solid #f1f1f1;
    }
</style>
