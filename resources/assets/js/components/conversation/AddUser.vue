<template>
	<div class="is-fullwidth">
		<svg xmlns="https://www.w3.org/2000/svg" style="display:none">
			<symbol xmlns="https://www.w3.org/2000/svg" id="sbx-icon-search-8" viewBox="0 0 40 40">
			<path d="M16 32c8.835 0 16-7.165 16-16 0-8.837-7.165-16-16-16C7.162 0 0 7.163 0 16c0 8.835 7.163 16 16 16zm0-5.76c5.654 0 10.24-4.586 10.24-10.24 0-5.656-4.586-10.24-10.24-10.24-5.656 0-10.24 4.584-10.24 10.24 0 5.654 4.584 10.24 10.24 10.24zM28.156 32.8c-1.282-1.282-1.278-3.363.002-4.643 1.282-1.284 3.365-1.28 4.642-.003l6.238 6.238c1.282 1.282 1.278 3.363-.002 4.643-1.283 1.283-3.366 1.28-4.643.002l-6.238-6.238z"
				fill-rule="evenodd" />
				</symbol>
				<symbol xmlns="https://www.w3.org/2000/svg" id="sbx-icon-clear-3" viewBox="0 0 20 20">
				<path d="M8.114 10L.944 2.83 0 1.885 1.886 0l.943.943L10 8.113l7.17-7.17.944-.943L20 1.886l-.943.943-7.17 7.17 7.17 7.17.943.944L18.114 20l-.943-.943-7.17-7.17-7.17 7.17-.944.943L0 18.114l.943-.943L8.113 10z" fill-rule="evenodd" />
				</symbol>
			</svg>
			<form novalidate="novalidate" onsubmit="return false;" class="searchbox sbx-twitter" v-show="conversationStore.recipient.length < 5">
				<div role="search" class="sbx-twitter__wrapper">
					<input v-model="query" placeholder="Search user"  class="sbx-twitter__input" style="height: 32px;">
					<button type="submit" title="Submit your search query." class="sbx-twitter__submit">
					<svg role="img" aria-label="Search">
						<use xmlns:xlink="https://www.w3.org/1999/xlink" xlink:href="#sbx-icon-search-8"></use>
					</svg>
					</button>
					<button type="reset" title="Clear the search query." class="sbx-twitter__reset">
					<svg role="img" aria-label="Reset">
						<use xmlns:xlink="https://www.w3.org/1999/xlink" xlink:href="#sbx-icon-clear-3"></use>
					</svg>
					</button>
				</div>
			</form>
		</div>
</template>

<script>
	import {mapState} from 'vuex';

	var algoliasearch = require('algoliasearch');

	var client = algoliasearch('ZTHT7T6SRW', 'e7a1d84577f0e1179eecc87224747da5');

	var index = client.initIndex('users'); 

	export default {
		mounted () {
			this.autoComplete();
		},

	    data () {
	      return {
	        query: '',
	      };
	    },

	    computed: {
	      ...mapState({
	        conversationStore: state => state.conversationStore
	      })
	    },

		methods: {
			autoComplete() {
       			let self = this;
				autocomplete('.sbx-twitter__input', {
            hint: false,
            debug: true,
        }, [{
				      source: autocomplete.sources.hits(index, { hitsPerPage: 10 }),
				      displayKey: 'name',
				      templates: {
				      	footer: "<div class='frame is-marginless is-paddingless'><small>Powered by </small><span class='helper'><img class='is-marginless is-paddingless' src='/dist/img/Algolia_logo_bg-white.svg' style=''/></span> </div>",
                empty: '<div class="has-text-centered">No result</div>',
				        suggestion: function(suggestion) {
							var sugTemplate = "<a><img src='"+ suggestion.avatar +"'/><strong>"+ suggestion._highlightResult.name.value +"</strong><strong style='color: #8899a6'> @"+suggestion._highlightResult.username.value +"</strong></a>"
				        	return sugTemplate;
				         }
				      },

				    }
				]).on('autocomplete:selected', function(event, suggestion, dataset) {
            self.query = '';
            let user = suggestion;
            
            if (self.conversationStore.recipient.length === 0) {
            	self.$store.dispatch('addRecipient', user);
            }
            else {
            	var create = true;
            	for (let recipient of self.conversationStore.recipient) {
            	    if (recipient.usn === user.usn) {
            	    	var create = false;
            	    } 
            	}

            	if (create === true) {
            		self.$store.dispatch('addRecipient', user);
            	}
            }
            
        });
			}
		}
	}
</script>
