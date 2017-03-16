<template>
    <div class="panel panel-default">
        <div class="panel-heading">
            New Conversation
        </div>
        <div class="panel-block">
            <div class="control">
                <form action="#" @submit.prevent="send">
                    <div class="field">
                      <p class="control">
                        <input class="input" id="users"  type="text" placeholder="Start Typing to find users">
                      </p>
                    </div>
                    
                    <ul v-if="recipients.length" class="list-inline">
                        <li><strong>To:</strong></li>
                        <li v-for="recipient in recipients">{{ recipient.name }} [<a href="#" @click.prevent="removeRecipient(recipient)">x</a>]</li>
                    </ul>
                    
                    <div class="field">
                      <label class="label">Conversation Name</label>
                      <p class="control">
                        <input class="input" id="message"  type="text" placeholder="Conversation name" v-model="body">
                      </p>
                    </div>
                    
                    <div class="field">
                      <p class="control">
                        <button class="button is-info">Create</button>
                      </p>
                    </div>
                </form>
            </div>
          
        </div>
    </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex'
    import { userautocomplete } from '../../../helpers/autocomplete'

    export default {
        data () {
            return {
                body: null,
                recipients: [],
            }
        },
        methods: {
            ...mapActions([
                'createConversation'
            ]),
            addRecipient (recipient) {
                var existing = this.recipients.find((r) => {
                    return r.id === recipient.id
                })

                if (typeof existing !== 'undefined') {
                    return
                }

                this.recipients.push(recipient)
            },
            removeRecipient (recipient) {
                this.recipients = this.recipients.filter((r) => {
                    return r.id !== recipient.id
                })
            },
            send () {
                this.createConversation({
                    recipientIds: this.recipients.map((r) => {
                        return r.id
                    }),
                    body: this.body
                }).then(() => {
                    this.recipients = []
                    this.body = null
                })
            }
        },
        mounted () {
            var users = userautocomplete('#users').on('autocomplete:selected', (e, selection) => {
                this.addRecipient(selection)
                users.autocomplete.setVal('')
            })
        }
    }
</script>
