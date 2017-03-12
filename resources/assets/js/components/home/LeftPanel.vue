<template>
    <div class="column is-3">
        <div class="card is-fullwidth" v-if="true == false">
            <header class="card-header">
            </header>
            <div class="card-content">
                <a class="card-avatar">
                    <img class="image is-72x72" :src="$root.user.image">
                </a>

                <div class="card-user">
                    <div class="card-user-name">
                        <a href="#" v-text="$root.user.name"></a>
                    </div>
                    <span>
                            <a href="#">@<span>{{ $root.user.username }}</span></a>
                    </span>
                </div>

                <div class="card-stats">
                    <ul class="card-stats-list">
                        <li class="card-stats-item">
                            <a href="#" title="9.840 Tweet">
                                <span class="card-stats-key">Posts</span>
                                <span class="card-stats-val">{{$root.user.postCount}}</span>
                            </a>
                        </li>
                        <li class="card-stats-item">
                            <a href="#/following" title="885 Following">
                                <span class="card-stats-key">Following</span>
                                <span class="card-stats-val">{{following}}</span>
                            </a>
                        </li>
                        <li class="card-stats-item">
                            <a href="#">
                                <span class="card-stats-key">Followers</span>
                                <span class="card-stats-val">{{$root.user.followerCount}}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="box trending has-text-centered" v-if="events.length > 0">
            <p class="trend-title"><span class="title is-5">Upcoming events</span>
            </p>

            <p class="trend-hashtag" v-for="event in events">
                <a :href="'/calendar/event/'+event.id">{{event.title}}</a>
            </p>

        </div>
       
    </div>
</template>

<script>
    import eventHub from '../../event'

    export default {
        data () {
            return {
                following: 0,
                events: [],
            }
        },

        mounted () {
            this.getEvents();
            this.following = this.$root.user.followCount
            eventHub.$on('follow', this.update);
        },

        methods: {
            getEvents() {
                axios.get('/calendar/events').then(response => {
                    this.events = response.data;
                });
            },

            update() {
                this.following++
            }
        }
    }

</script>