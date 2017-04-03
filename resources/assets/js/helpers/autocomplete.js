import algolia from 'algoliasearch'
import autocomplete from 'autocomplete.js'

var index = algolia('RQTMQTYD3B', '03db5fb58fe8a6e53811dd4f86c4c788')

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
