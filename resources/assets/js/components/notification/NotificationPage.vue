<template>
    <div class="columns" v-cloak>
        <left-panel style="order: 0;"></left-panel>
        <transition name="slide-fade">
        <div class="column is-6" style="order: 1;">
            <div class="panel has-text-centered">
                <div class="panel-heading">
                    Notifications
                </div>
                <div class="panel-block" v-if="notifications.length > 0">
                    <div class="control">
                        <div class="notification" v-for="notification in notifications" :key="notification.id" style="background-color: white;">
                            <strong v-html="notification.data.message"></strong>
                            <br>
                            <small v-text="notification.created_at"></small>
                        </div>
                    </div>
                </div>
                <div class="panel-block" v-else>
                    <div class="control">
                        <div class="notification has-text-centered" style="background-color: white;">
                             No notifications
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </transition>
        
        
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
                notifications: [],
                showMessage: false,
            }
        },

        methods: {
            listen() {
                this.$root.$on('added-notification', this.pushNotification)
            },

            getNotifications() {
                axios.get('/get-notifications').then((response) => {
                    this.notifications = response.data
                    if (response.data.length === 0) {
                        this.showMessage = true
                    }
                 })
                
            },

            pushNotification(notification) {
                this.notifications.unshift({ data: notification})
            }
        }
    }
</script>

<style scoped>
    .slide-fade-enter-active {
      transition: all .3s ease;
    }
    .slide-fade-leave-active {
      transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
    }
    .slide-fade-enter, .slide-fade-leave-to
    /* .slide-fade-leave-active for <2.1.8 */ {
      transform: translateX(10px);
      opacity: 0;
    }
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
