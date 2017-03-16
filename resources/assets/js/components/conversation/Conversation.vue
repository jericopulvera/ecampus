<template>
    <div>

    <div class="panel" v-if="conversation" v-cloak>
        <div class="panel-heading">
            In conversation
        </div>
        <div class="panel-block">
            <div class="control">
                <div v-if="loading">
                    <div class="loader"></div>
                </div>
                <div v-else-if="conversation">
                    <nav class="level-left">
                      <p class="level-item" v-for="user in conversation.users.data">
                        <a target="_blank" :href="'/'+user.usn" class="link is-info">{{ user.name }}</a>
                      </p>
                    </nav>

                    <conversation-add-user-form></conversation-add-user-form>

                    <hr>

                    <conversation-reply-form></conversation-reply-form>

                </div>
            </div>
        </div>
    </div>

    <div class="panel" v-else v-cloak>
        <div class="panel-heading">
            Select a conversation
        </div>
    </div>

    <div class="panel" v-if="conversation">
        <div class="panel-heading">
            Messages
        </div>
        <div class="panel-block">
            <div class="control">
                <div class="media" v-for="reply in conversation.replies.data">
                    <figure class="media-left">
                        <p class="image is-64x64">
                          <img v-bind:src="reply.user.data.avatar" v-bind:alt="reply.user.data.name + ' avatar'">
                        </p>
                      </figure>
                    <div class="media-content">
                        <div class="content">
                          <p>
                            <strong>{{ reply.user.data.name }}</strong> <small>{{ reply.created_at_human }}</small>
                            <br>
                            {{ reply.body }}
                          </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
   
</template>

<script>
    import { mapActions, mapGetters } from 'vuex'

    export default {
        props: [
            'id'
        ],
        computed: mapGetters({
            conversation: 'currentConversation',
            loading: 'loadingConversation'
        }),
        methods: {
            ...mapActions([
                'getConversation'
            ])
        },
        mounted () {
            if (this.id !== null) {
                this.getConversation(this.id)
            }
        }
    }
</script>

