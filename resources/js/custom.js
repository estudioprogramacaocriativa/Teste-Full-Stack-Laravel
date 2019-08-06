import filters from './plugins/filter'
import search from './plugins/search'
import formRequests from './plugins/requests'
import preview from './plugins/preview'
import trash from './plugins/delete'

document.addEventListener('DOMContentLoaded', () => {
    filters.filters()
    search.search()
    preview.preview()
    trash()
    formRequests()
})
