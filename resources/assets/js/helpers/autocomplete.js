import algolia from 'algoliasearch'
import autocomplete from 'autocomplete.js'

var index = algolia('ZTHT7T6SRW', 'e7a1d84577f0e1179eecc87224747da5')

export const userautocomplete = selector => {
    var users = index.initIndex('users')

    return autocomplete(selector, {
        hint: false,
        debug: true,
    }, {
        source: autocomplete.sources.hits(users, { hitsPerPage: 5 }),
        displayKey: 'name',
        templates: {
            suggestion (suggestion) {
                return '<span>' + suggestion.name + '</span>'
            },
            empty: '<div class="aa-empty">No people found.</div>'
        }
    })
}
