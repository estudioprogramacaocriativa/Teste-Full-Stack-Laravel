import filters from './plugins/filter'
import search from './plugins/search'

document.addEventListener('DOMContentLoaded', () => {
    filters.filters()
    search.search()
})
