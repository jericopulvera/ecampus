<template>
    <div class="column is-3" v-cloak>
        <div class="panel" >
            <div class="panel-heading">
                Student Leaderboard
            </div>
            <transition name="slide-fade">
            <div class="panel-block">
                <div class="control">
                    <div class="notification" v-if="groupStore.students.length === 0" v-cloak>
                        No Students...
                    </div>
                    <table class="table table-bordered table-responsive" v-else v-cloak>
                        <thead>
                            <tr>
                                <th>rank</th>
                                <th>name</th>
                                <th>grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(student, index) in ranking">
                                <td>{{index +1}}</td>
                                <td><a :href="'/'+student.usn" target="_blank">{{student.name}}</a></td>
                                
                                <td>
                                    {{student.totalGrade}} %
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    
                </div>
            </div>
            </transition>
            
        </div>
        <group-pending-requests></group-pending-requests>
    </div>
</template>

<script>
	import {mapState} from 'vuex'
	export default {

        data() {
            return {
                showMessage: false
            }
        },
		computed: {

			ranking () {
				return _.orderBy(this.groupStore.students, ['totalGrade'], ['desc']);
			},

			...mapState({
				groupStore: state => state.groupStore
			})
		}
	}
</script>

<style scoped>
/* Enter and leave animations can use different */
/* durations and timing functions.              */
.slide-fade-enter-active {
  transition: all .3s ease;
}
.slide-fade-leave-active {
  transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}
.slide-fade-enter, .slide-fade-leave-to
/* .slide-fade-leave-active for <2.1.8 */ {
  transform: translateX(10px);
  opacity: 0;
}
</style>
