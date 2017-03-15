<template>
	<div class="modal is-active">
	  <div class="modal-background"></div>
	  <div class="modal-content">
	    <div class="card">
	      <header class="card-header has-text-centered">
	        <p class="card-header-title">
	          <a :href="'/'+student.usn" target="_blank">{{groupStore.term.toUpperCase() }}: {{student.name.toUpperCase()}}</a>
	        </p>
	      </header>
	      <div class="card-content">
	        <div class="content">
	          <div class="control is-grouped">
	             <p class="control is-expanded">
	             	<label class="label">Class Standing</label>
	               <input class="input" type="number" v-model="grade.cs">
	             </p>
	             <p class="control is-expanded">
	             	<label class="label">Examination</label>
	               <input class="input" type="number" v-model="grade.exam">
	             </p>
	           </div>

	           <div class="control is-grouped">
	              <p class="control is-expanded">
	              	<label class="label">Quiz 1</label>
	                <input class="input" type="number" v-model="grade.quiz1">
	              </p>
	              <p class="control is-expanded">
	              	<label class="label">Quiz 2</label>
	                <input class="input" type="number" v-model="grade.quiz2">
	              </p>
	            </div>

	        </div>
	      </div>
	      <footer class="card-footer">
	        <a class="card-footer-item" @click="updateGrade">Save</a>
	      </footer>
	    </div>
	  </div>
	  <button class="modal-close" @click="closeModal"></button>
	</div>
</template>

<script>
	import {mapState} from 'vuex';

	export default {
		props: ['student', 'grades'],

		data () {
			return {
				grade: {
					cs: 0,
					exam: 0,
					quiz1: 0,
					quiz2: 0,
					week: null
				}
				
			}
		},

		mounted () {
			this.grade.cs = this.grades.class_standing;
			this.grade.exam = this.grades.exam;
			this.grade.quiz1 = this.grades.quiz_one;
			this.grade.quiz2 = this.grades.quiz_two;
			this.grade.week = this.grades.week;
		},

		computed: {
		    ...mapState({
		        groupStore: state => state.groupStore
		    })
		},

		methods: {
			closeModal () {
				this.$store.dispatch('closeModal');
			},

			updateGrade () {
				axios.post('/webapi/group/'+this.student.pivot.group_id+'/'+this.student.id+'/update-grade', this.grade).then((response) => {
				    if (response.status === 200) {
				    	this.$store.dispatch('fetchMembers', group.slug);
				    	this.$store.dispatch('closeModal');
				    }
				})
			}
		},

		watch: {
			    'grade.quiz1': function () {
			      if(this.grade.quiz1 > 100) {
			     	  this.grade.quiz1 = 100
			      }
				  if (this.grade.quiz1 < 0 || this.grade.quiz1 == '') {
			      	 this.grade.quiz1 = 0
			      }
			    },

			    'grade.quiz2': function () {
			      if(this.grade.quiz2 > 100) {
			     	  this.grade.quiz2 = 100
			      }
				  if (this.grade.quiz2 < 0 || this.grade.quiz2 == '') {
			      	 this.grade.quiz2 = 0
			      }
			    },

			    'grade.cs': function () {
			      if(this.grade.cs > 100) {
			     	  this.grade.cs = 100
			      }
				  if (this.grade.cs < 0 || this.grade.cs == '') {
			      	this.grade.cs = 0
			      }
			    },

			    'grade.exam': function () {
			      if(this.grade.exam > 100) {
			     	  this.grade.exam = 100
			      }
				  if (this.grade.exam < 0 || this.grade.exam == '') {
			      	this.grade.exam = 0
			      }

			    }
		}
	
	}
</script>
