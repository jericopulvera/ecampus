<template>
	<div class="nav-item is-flex-desktop is-hidden-mobile">
		<svg xmlns="https://www.w3.org/2000/svg" style="display:none">
			<symbol xmlns="https://www.w3.org/2000/svg" id="sbx-icon-search-8" viewBox="0 0 40 40">
			<path d="M16 32c8.835 0 16-7.165 16-16 0-8.837-7.165-16-16-16C7.162 0 0 7.163 0 16c0 8.835 7.163 16 16 16zm0-5.76c5.654 0 10.24-4.586 10.24-10.24 0-5.656-4.586-10.24-10.24-10.24-5.656 0-10.24 4.584-10.24 10.24 0 5.654 4.584 10.24 10.24 10.24zM28.156 32.8c-1.282-1.282-1.278-3.363.002-4.643 1.282-1.284 3.365-1.28 4.642-.003l6.238 6.238c1.282 1.282 1.278 3.363-.002 4.643-1.283 1.283-3.366 1.28-4.643.002l-6.238-6.238z"
				fill-rule="evenodd" />
			</symbol>
				<symbol xmlns="https://www.w3.org/2000/svg" id="sbx-icon-clear-3" viewBox="0 0 20 20">
				<path d="M8.114 10L.944 2.83 0 1.885 1.886 0l.943.943L10 8.113l7.17-7.17.944-.943L20 1.886l-.943.943-7.17 7.17 7.17 7.17.943.944L18.114 20l-.943-.943-7.17-7.17-7.17 7.17-.944.943L0 18.114l.943-.943L8.113 10z" fill-rule="evenodd" />
				</symbol>
			</svg>
			<form novalidate="novalidate" onsubmit="return false;" class="searchbox sbx-twitter">
				<div role="search" class="sbx-twitter__wrapper">
					<input type="search" name="search" @keydown="closeToggle" placeholder="Search user" required="required" class="sbx-twitter__input" style="height: 32px;">
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
	import eventHub from '../../event';
	var algoliasearch = require('algoliasearch');

	var client = algoliasearch('ZTHT7T6SRW', 'e7a1d84577f0e1179eecc87224747da5');

	var index = client.initIndex('users'); 

	export default {
		mounted () {
			this.autoComplete();
		},

		methods: {
			autoComplete() {
				autocomplete('.sbx-twitter__input', {
            hint: false,
            debug: true,
        }, [{
				      source: autocomplete.sources.hits(index, { hitsPerPage: 5 }),
				      displayKey: 'name',
				      templates: {
                footer: "<div class='frame is-marginless is-paddingless'><small>Powered by </small><span class='helper'><img id='drop-image' class='is-marginless is-paddingless' src='/dist/img/Algolia_logo_bg-white.svg' style=''/></span> </div>",
                empty: '<div class="has-text-centered">No result</div>',
				        suggestion: function(suggestion) {
							var sugTemplate = "<a href=/"+suggestion.usn+"><img id='drop-image' src='"+ suggestion.avatar +"'/><strong>@"+ suggestion._highlightResult.username.value +"</strong><strong style='color: #8899a6'> "+suggestion._highlightResult.usn.value +"</strong></a>"
				        	return sugTemplate;
				         }
				      },

				    }
				]);
			},

			closeToggle() {
				eventHub.$emit('close-dropdown');
			}
		}
	}
</script>

<style>
 .frame {
    white-space: nowrap;
    text-align: center; 
  }

  .helper {
      display: inline-block;
      vertical-align: middle;
  }


  .aa-dropdown-menu {
    background-color: #fff;
    cursor: pointer;
    position: relative;
    padding: 0;
    margin: 0;
    top: -10px;
    border-radius: 3px;
    text-align: left;
    height: auto;
    position: relative;
    border: none;
    width: 120%;
    left: 0 !important;
    box-shadow: 0 1px 0 0 rgba(0,0,0,0.2),0 2px 3px 0 rgba(0,0,0,0.1);
  }
  .aa-suggestion a {
    display: block;
    height: 112%;
    width: 102%;
  }

  .aa-dropdown-menu:before {
    position: absolute;
    content: '';
    width: 14px;
    height: 14px;
    background: #fff;
    z-index: 0;
    top: -7px;
    border-top: 1px solid #D9D9D9;
    border-right: 1px solid #D9D9D9;
    transform: rotate(-45deg);
    border-radius: 2px;
    z-index: 999;
    display: block;
    left: 24px;
  }

  .aa-dropdown-menu [class^="aa-dataset-"] {
    position: relative;
    border: solid 1px #D9D9D9;
    border-radius: 3px;
    overflow: auto;
    padding: 8px 8px 8px;
  }

  .aa-dropdown-menu * {
    box-sizing: border-box;
  }

  .aa-suggestion {
    font-size: 1.1em;
    padding-bottom: 4px;
    display: block;
    width: 100%;
    height: 38px;
    clear: both;
    span {
      white-space: nowrap!important;
      text-overflow: ellipsis;
      overflow: hidden;
      display: block;
      float: left;
      line-height: 2em;
      width: calc(100% - 30px);
    }
  }

  .aa-suggestion:hover {
    background-color: #abb8c2
  }

  #drop-image {
    float: left;
    height: 32px;
    width: 32px;
    margin: 6px;
    vertical-align: middle;
  }

  .sbx-twitter {
    display: inline-block;
    position: relative;
    width: 200px;
    height: 33px;
    white-space: nowrap;
    box-sizing: border-box;
    font-size: 12px;
  }

  .sbx-twitter__wrapper {
    width: 100%;
    height: 100%;
  }

  .sbx-twitter__input {
    display: inline-block;
    -webkit-transition: box-shadow .4s ease, background .4s ease;
    transition: box-shadow .4s ease, background .4s ease;
    border: 0;
    border-radius: 17px;
    box-shadow: inset 0 0 0 1px #E1E8ED;
    background: #F5F8FA;
    padding: 0;
    padding-right: 52px;
    padding-left: 16px;
    width: 100%;
    height: 100%;
    vertical-align: middle;
    white-space: normal;
    font-size: inherit;
    -webkit-appearance: none;
       -moz-appearance: none;
            appearance: none;
  }

  .sbx-twitter__input::-webkit-search-decoration, .sbx-twitter__input::-webkit-search-cancel-button, .sbx-twitter__input::-webkit-search-results-button, .sbx-twitter__input::-webkit-search-results-decoration {
    display: none;
  }

  .sbx-twitter__input:hover {
    box-shadow: inset 0 0 0 1px #c1d0da;
  }

  .sbx-twitter__input:focus, .sbx-twitter__input:active {
    outline: 0;
    box-shadow: inset 0 0 0 1px #D6DEE3;
    background: #FFFFFF;
  }

  .sbx-twitter__input::-webkit-input-placeholder {
    color: #9AAEB5;
  }

  .sbx-twitter__input::-moz-placeholder {
    color: #9AAEB5;
  }

  .sbx-twitter__input:-ms-input-placeholder {
    color: #9AAEB5;
  }

  .sbx-twitter__input::placeholder {
    color: #9AAEB5;
  }

  .sbx-twitter__submit {
    position: absolute;
    top: 0;
    right: 0;
    left: inherit;
    margin: 0;
    border: 0;
    border-radius: 0 16px 16px 0;
    background-color: rgba(62, 130, 247, 0);
    padding: 0;
    width: 33px;
    height: 100%;
    vertical-align: middle;
    text-align: center;
    font-size: inherit;
    -webkit-user-select: none;
       -moz-user-select: none;
        -ms-user-select: none;
            user-select: none;
  }

  .sbx-twitter__submit::before {
    display: inline-block;
    margin-right: -4px;
    height: 100%;
    vertical-align: middle;
    content: '';
  }

  .sbx-twitter__submit:hover, .sbx-twitter__submit:active {
    cursor: pointer;
  }

  .sbx-twitter__submit:focus {
    outline: 0;
  }

  .sbx-twitter__submit svg {
    width: 13px;
    height: 13px;
    vertical-align: middle;
    fill: #657580;
  }

  .sbx-twitter__reset {
    display: none;
    position: absolute;
    top: 7px;
    right: 33px;
    margin: 0;
    border: 0;
    background: none;
    cursor: pointer;
    padding: 0;
    font-size: inherit;
    -webkit-user-select: none;
       -moz-user-select: none;
        -ms-user-select: none;
            user-select: none;
    fill: rgba(0, 0, 0, 0.5);
  }

  .sbx-twitter__reset:focus {
    outline: 0;
  }

  .sbx-twitter__reset svg {
    display: block;
    margin: 4px;
    width: 11px;
    height: 11px;
  }

  .sbx-twitter__input:valid ~ .sbx-twitter__reset {
    display: block;
    -webkit-animation-name: sbx-reset-in;
            animation-name: sbx-reset-in;
    -webkit-animation-duration: .15s;
            animation-duration: .15s;
  }

  @-webkit-keyframes sbx-reset-in {
    0% {
      -webkit-transform: translate3d(-20%, 0, 0);
              transform: translate3d(-20%, 0, 0);
      opacity: 0;
    }
    100% {
      -webkit-transform: none;
              transform: none;
      opacity: 1;
    }
  }

  @keyframes sbx-reset-in {
    0% {
      -webkit-transform: translate3d(-20%, 0, 0);
              transform: translate3d(-20%, 0, 0);
      opacity: 0;
    }
    100% {
      -webkit-transform: none;
              transform: none;
      opacity: 1;
    }
  }
</style>
