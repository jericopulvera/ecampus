<template>
    <div class="column is-3">
        <div class="box trending has-text-centered" v-if="$root.user.userGroups.length > 1">
            <p class="trend-title"><span class="title is-5">My Classes</span>
            </p>

            <p class="trend-hashtag" v-for="group in $root.user.userGroups">
                <a :href="'/groups/'+group.slug">{{group.slug}}</a>
            </p>
        </div>

        <div class="box" v-if="suggestions.length > 0">
            <p><span class="title is-5">Follow Suggestions</span> </p>
            <hr>

            <div class="columns" v-for="suggestUser in suggestions" :key="suggestUser.id">
                <div class="column is-3 is-marginless">
                    <div class="image">
                        <img :src="suggestUser.image">
                    </div>
                </div>
                <div class="column is-9">
                    <p>
                        <a :href="'/'+suggestUser.usn" target="_blank" >
                            <strong id="name">{{suggestUser.name}}</strong> &commat;{{suggestUser.username}}
                        </a>
                        <a @click="removeSuggested(suggestUser.id)">
                            <i class="fa fa-times"></i>
                        </a>
                    </p>
                    <a class="button is-info is-small" @click="follow(suggestUser.usn)">
                        <span>
                                Follow
                        </span>
                    </a>
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
