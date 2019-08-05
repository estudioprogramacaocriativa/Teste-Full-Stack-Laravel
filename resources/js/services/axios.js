import api from 'axios'

let token = document.querySelector('meta[name="csrf-token"]')

api.create({
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': token.content
    }
})

export default api
