<template>
	<div class="column is-3">
	    <div class="box" v-if="groupStore.students.length > 0">
	        <p><span class="title is-5">Student Leaderboard</span> </p>

		     <table class="table table-bordered table-responsive">
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
		     			<td><a :href="$root.baseUrl+'/'+student.usn" target="_blank">{{student.name}}</a></td>
		     			
		     			<td>
		     				{{student.totalGrade}} %
		     			</td>
		     		</tr>
		     	</tbody>
		     </table>
	    </div>

	    <group-pending-requests></group-pending-requests>
	</div>
</template>

<script>
	import {mapState} from 'vuex'
	export default {
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