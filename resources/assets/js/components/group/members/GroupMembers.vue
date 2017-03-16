<template>
	<div class="content has-text-centered">
		<div class="subtitle">Admin</div>
		<div class="card" style="margin: 20px 0;">
			
			<div class="card-content">
				<div class="content">
					<div class="box-info has-text-centered">
						<!-- <img id="image" :src="groupStore.admin.image" alt="" /> -->
						{{groupStore.admin.name}} | {{groupStore.admin.usn}}
					</div>
				</div>
			</div>
			<footer class="card-footer">
				<a class="card-footer-item" target="_blank" :href="'/'+groupStore.admin.usn">View Profile</a>
			</footer>
		</div>

		<div class="subtitle" v-show="groupStore.professors.length > 0">Professors</div>
		<div class="card" v-for="professor in groupStore.professors" style="margin: 20px 0;">
			
			<div class="card-content">
				<div class="content">
					<div class="box-info has-text-centered">
						<!-- <img id="image" :src="professor.image" alt="" /> -->
						{{professor.name}} | {{professor.usn}}
					</div>
				</div>
			</div>
			<footer class="card-footer">
				<a class="card-footer-item" v-if="$root.user.id === groupStore.admin.id" @click.prevent="passSubject(professor.usn)">Pass Subject</a>
				<a class="card-footer-item" target="_blank" :href="'/'+professor.usn">View Profile</a>
				<a class="card-footer-item" @click="expelUser(professor.usn)" v-if="$root.user.id === groupStore.admin.id">Expel</a>
			</footer>
		</div>

		<div class="subtitle" v-show="groupStore.students.length > 0">Students</div>
		<div class="card" v-for="student in groupStore.students" style="margin: 20px 0;">
			
			<div class="card-content">
				<div class="content">
					<div class="box-info has-text-centered">
						<!-- <img id="image" :src="student.image" alt="" /> -->
						{{student.name}} | {{student.usn}} | {{student.course}}
					</div>
				</div>
			</div>
			<footer class="card-footer">
				<a class="card-footer-item" target="_blank" :href="'/'+student.usn">View Profile</a>
				<a class="card-footer-item" @click="expelUser(student.usn)" v-if="$root.user.id === groupStore.admin.id">Expel</a>
			</footer>
		</div>
		
	</div>
</template>

<script>
    import {mapState} from 'vuex';

	export default {

		computed: {
		    ...mapState({
		        groupStore: state => state.groupStore
		    })
		},

		methods: {
			expelUser(usn) {
				var confirm = window.confirm('Are you sure you want to expel this user?')

				if (confirm) {
					axios.post('/webapi/group/kick/'+group.slug+'/'+usn)		
					    .then(response => {
					         this.$store.dispatch('fetchMembers', group.slug);
					    })
					    .catch(error => {
					    	alert(error)
					    });

				    
				}
			},

            passSubject(usn) {
                axios.post('/webapi/group/pass-subject/'+ group.slug + '/' + usn)
                    .then(response => {
                        noty({ text: 'Successfully changed this subjects professor.', type: 'success'});
                        this.$store.dispatch('fetchMembers', group.slug);
                    })
            }
		  
		}
	}
</script>

<style scoped>
	#image {
		float: left;
		height: 32px;
		width: 32px;
		margin: 6px;
		vertical-align: middle;
	}
</style>

