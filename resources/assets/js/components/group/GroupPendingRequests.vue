<template>
  <div class="box" v-show="requests.length > 0">
      <p><span class="title is-5">Pending {{ pluralize('Request', requests.length) }}</span> </p>
      
      <div class="card"  v-for="user in requests" style="margin: 10px 0;">
        <header class="card-header">
          <p class="card-header-title">
            <a :href="'/'+user.usn" target="_blank"> {{user.name}} - {{user.usn}} </a>
          </p>
        </header>        
        <footer class="card-footer">
          <a class="card-footer-item" @click="accept(user.usn)">Accept</a>
          <a class="card-footer-item" @click="decline(user.usn)">Decline</a>
        </footer>
      </div>
  </div>
</template>

<script>
    import pluralize from 'pluralize'

    export default {
        data () {
            return {
                disable: false,
                requests: [] 
            }
        },

        mounted () {
          this.load();
            Echo.private('join-requests.'+group.slug).listen('JoinGroupRequested', (event) => {
                this.load();
                noty({ text: event.user.name + ' requested to join this class.' , type: 'sucess', timeout: 5000});
            })
        },

        methods: {
            pluralize,
            
            load () {
                axios.get('/webapi/group/pending/' + group.slug).then((response) => {
                    this.requests = response.data;
                 })
            },
            accept (userUsn) {
                axios.post('/webapi/group/accept/' + group.slug + '/' + userUsn).then((response) => {
                     this.$store.dispatch('fetchMembers')
                     this.load()
                })
            },
            decline (userUsn) {
                axios.post('/webapi/group/decline/' + group.slug + '/' + userUsn).then((response) => {
                     this.load()
                })
            }
        }

    }
</script>
