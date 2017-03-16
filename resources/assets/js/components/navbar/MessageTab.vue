<template>
	<a class="nav-item is-tab" href="/conversations"><i class="fa fa-comments"></i> &nbsp; Conversations</a>
</template>

<script>
	import {mapState} from 'vuex';

	export default {

		mounted() {
			this.listen();
		},

		methods: {
			listen() {
				// nothing
			}
		}
	}
</script>
