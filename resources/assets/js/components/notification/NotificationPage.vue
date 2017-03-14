<template>
    <div class="columns">

        <div class="column is-6" style="order: 1;">
            <div class="panel container has-text-centered">
                <div class="panel-heading">
                    Notifications
                </div>
                <div class="panel-block">
                    <div class="control">
                        <div class="notification" v-for="notification in notifications" :key="notification.id">
                            <strong v-html="notification.data.message"></strong>
                            <br>
                            <small v-text="notification.created_at"></small>
                        </div>
                    </div>
                </div>
            </div>
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
                this.$root.$on('added-notification', this.pushNotification)
            },

            getNotifications() {
                axios.get('/get-notifications').then((response) => {
                    this.notifications = response.data
                 })
            },

            pushNotification(notification) {
                this.notifications.unshift({ data: notification})
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
