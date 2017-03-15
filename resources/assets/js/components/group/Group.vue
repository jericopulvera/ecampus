<template>
    <div class="columns">

        <div class="column is-9">
           <div class="card">
             <header class="card-header">
               <div class="tabs is-medium">
                 <ul style="margin-left: 21px;">
                   <li :class="[ groupStore.tab === 'feed' ? 'is-active' : '' ]"><a @click="selectTab('feed')">Feed</a></li>
                   <li v-if="$root.user.id === groupStore.admin.id" :class="[ groupStore.tab === 'grades' ? 'is-active' : '' ]"><a @click="selectTab('grades')">Grades</a></li>
                   <li :class="[ groupStore.tab === 'members' ? 'is-active' : '' ]"><a @click="selectTab('members')">Members</a></li>
                   <li :class="[ groupStore.tab === 'settings' ? 'is-active' : '' ]"><a @click="selectTab('settings')">Settings</a></li>
                 </ul>
               </div>
             </header>
             <div class="card-content">
               <group-feed v-show="groupStore.tab === 'feed'"></group-feed>
               <group-grade v-if="$root.user.id === groupStore.admin.id" v-show="groupStore.tab === 'grades'"></group-grade>
               <group-members v-show="groupStore.tab === 'members'"></group-members>
               <group-settings v-if="groupStore.tab === 'settings'"></group-settings>
               
             </div>
           </div>
        </div>
        <group-grade-modal v-if="groupStore.term !== null" :student="groupStore.modalStudent" :grades="groupStore.modalGrades"></group-grade-modal>
        <group-sidebar></group-sidebar>
             
    </div>
</template>

<script>
    import {mapState} from 'vuex';

    export default {

        created () {
          this.$store.dispatch('fetchMembers', group.slug);
          this.listen()
        },

        computed: {
            ...mapState({
                groupStore: state => state.groupStore
            })
        },

        methods: {
          listen() {
            Echo.private('group.'+group.slug+'.'+this.$root.user.id)
                .listen('GroupUserWasKicked', e => {
                    alert('You have been kicked out of the group.');
                    window.location.href = '/';
              })
          },
          selectTab(name) {
            this.$store.dispatch('selectTab', name);
          }
        }
    }

</script>

<style scoped>
  .button {
    border: 1px solid #CCC !important; 
    border-radius:0 !important;
    -webkit-border-radius:0 !important;
  }
  .textarea {
    border: 1px solid #CCC !important; 
    border-radius:0 !important;
    -webkit-border-radius:0 !important;
    border-bottom: 0;
  }
</style>
