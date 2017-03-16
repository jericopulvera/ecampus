<template>
    <form action="#" @submit.prevent="reply">
       
        <div class="field">
          <label class="label">Message</label>
          <p class="control">
            <textarea class="textarea" cols="30" rows="4" placeholder="Write a message..." id="message" v-model="body"></textarea>
          </p>
        </div>
        <div class="field">
          <p class="control">
            <button class="button is-info">Send Message</button>
          </p>
        </div>
    </form>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex'

    export default {
        data () {
            return {
                body: null,
            }
        },
        computed: mapGetters({
            conversation: 'currentConversation'
        }),
        methods: {
            ...mapActions([
                'createConversationReply'
            ]),
            reply () {
                this.createConversationReply({
                    id: this.conversation.id,
                    body: this.body
                }).then(() => {
                    this.body = null
                })
            }
        }
    }
</script>
