import api from './../services/axios'
import trash from './delete'

const search = () => {
    let reload_data = document.querySelector('.reload-data')
    let el_selector = document.querySelector('.form-search > input')
    let loading_target = document.querySelector('.loading')
    let container_hide_target = document.querySelector('.hide-when-loading')

    if(el_selector) {
        let timeout = null;

        el_selector.addEventListener('keyup', (el) => {
            let value = el_selector.value

            clearTimeout(timeout)

            timeout = setTimeout(function () {
                loading_target.style.display = 'block'
                container_hide_target.style.display = 'none'

                api.get(`posts/search/${value}`)
                    .then((resp) => {
                        reload_data.innerHTML = resp.data.data
                        trash()
                    })
                    .then(() => {
                        loading_target.style.display = 'none'
                        container_hide_target.style.display = 'block'
                    })
                    .catch(() => {})
            }, 500)
        })
    }
}

export default {
    search
}
