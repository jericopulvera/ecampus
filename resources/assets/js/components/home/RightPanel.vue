<template>
    <div class="column is-3 is-hidden-touch">
        <div class="panel has-text-centered">
            <div class="panel-heading">
                <p class="trend-title"><span class="title is-5">My Classes</span>
                </p>    
            </div>
            <div class="panel-block">
                <div class="control"  v-if="$root.user.userGroups.length > 1">
                    <p class="trend-hashtag has-text-centered" v-for="group in $root.user.userGroups">
                        <a :href="'/groups/'+group.slug">{{group.subject}} - {{group.section}}</a>
                    </p>
                </div>
            </div>
        </div>
      
    </div>
</template>

<script>
    import eventHub from '../../event'

    export default {

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

                            noty({ 
                                text: 'You are now following ' + name, 
                                type: 'success',
                                timeout: 2000,
                            });
                            
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

<style scoped>
    #name:hover {
        color: #ABB8C2;
    }
</style>
