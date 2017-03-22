<template>
    <div class="column is-3">
        <div class="row">
            <div class="card is-fullwidth" v-if="$root.route != 'user.profile'">
                <div class="card-image">
                    <figure class="image is-1half-by1">
                      <img src="/dist/img/cover.jpg" alt="Image">
                    </figure>
                  </div>
                <div class="card-content">
                    <a class="card-avatar">
                        <img class="image is-72x72" :src="$root.user.image">
                    </a>

                    <div class="card-user">
                        <div class="card-user-name">
                            <a :href="'/'+$root.user.usn" v-text="$root.user.name"></a>
                        </div>
                        <span>
                                <a :href="'/'+$root.user.usn">@<span>{{ $root.user.username }}</span></a>
                        </span>
                    </div>

                    <div class="card-stats">
                        <ul class="card-stats-list">
                            <li class="card-stats-item">
                                <a :title="$root.user.postCount + ' posts'">
                                    <span class="card-stats-key">Posts</span>
                                    <span class="card-stats-val">{{$root.user.postCount}}</span>
                                </a>
                            </li>
                            <li class="card-stats-item">
                                <a :title="'following '+following + ' users'">
                                    <span class="card-stats-key">Following</span>
                                    <span class="card-stats-val">{{following}}</span>
                                </a>
                            </li>
                            <li class="card-stats-item">
                                <a :title="$root.user.followerCount + ' followers'">
                                    <span class="card-stats-key">Followers</span>
                                    <span class="card-stats-val">{{$root.user.followerCount}}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <br v-if="$root.route !== 'user.profile'">
        <div class="panel">
            <div class="panel-heading has-text-centered">
                <p class="trend-title"><span class="title is-5">{{ events.length > 0 ? 'Upcoming events' : 'No Upcoming Events'}}</span>
                </p>
            </div>
            <div class="panel-block">
                <div class="control">
                    <div class="trend-hashtag has-text-centered"  v-for="event in events" v-if="events.length > 0">
                        <a :href="'/calendar/event/'+event.id">{{event.title}}</a>
                    </div>
                </div>
            </div>
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
