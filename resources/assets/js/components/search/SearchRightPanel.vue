<template>
    <div class="column is-3">
        <div class="panel has-text-centered">
            <div class="panel-heading">
                <p class="trend-title"><span class="title is-5">{{ user.name }} Classes</span>
                </p>   
            </div>
            <div class="panel-block">
                <div class="control"  v-if="user.userGroups.length > 1">
                    <p class="trend-hashtag has-text-centered" v-for="group in user.userGroups">
                        <a :href="'/groups/'+group.slug">{{group.subject}}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import eventHub from '../../event'

    export default {

        props: ['user'],

        mounted () {
            this.getSuggestions()
        },

        data () {
            return {
                showFollowed: false,
                suggestions: []
            }
        },

        methods: {
            getSuggestions() {
                axios.get('follow-suggestions').then(response => {
                    this.suggestions = response.data;
                })
            },

            removeSuggested(id) {
                for (var i = 0; i <= this.suggestions.length; i++) {
                    if (this.suggestions[i].id === id) {
                        this.suggestions.splice(i,1);
                        break
                    }
                }
            },

            follow(usn) {
                axios.post('follow/'+usn).then(response => {
                    for (var i = 0; i <= this.suggestions.length; i++) {

                        if (this.suggestions[i].usn === usn) {

                            let name = this.suggestions[i].name;

                            noty({ text: 'You are now following ' + name , type: 'sucess'});
                            
                            this.suggestions.splice(i,1);
                            
                            eventHub.$emit('follow');
                
                            break
                        }
                    }
                })
            }
        }
    }
</script>
