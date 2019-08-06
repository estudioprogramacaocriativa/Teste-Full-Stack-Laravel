import api from './../services/axios'
import trash from './delete'

const filters = () => {
    let status
    let reload_data = document.querySelector('.reload-data')
    let el = document.querySelectorAll('.filters nav li')
    let el_selector = Array.from(el)
    let loading_target = document.querySelector('.loading')
    let container_hide_target = document.querySelector('.hide-when-loading')

    if(el_selector) {
        el_selector.forEach((item) => {
            item.addEventListener('click', () => {
                if (!item.classList.contains('active')){
                    el_selector.filter(el => toggleClass(el, 'remove', 'active'))
                    loading_target.style.display = 'block'
                    container_hide_target.style.display = 'none'
                    status = item.dataset.filter

                    toggleClass(item, 'add', 'active')

                    api.get(`posts/filter/${status}`)
                        .then((resp) => {
                            reload_data.innerHTML = resp.data.data
                            trash()
                        })
                        .then(() => {
                            loading_target.style.display = 'none'
                            container_hide_target.style.display = 'block'
                        })
                        .catch(() => {})
                }
            })
        })
    }
}

const toggleClass = (el, action, class_) => {
    if(el !== undefined) {
        el.classList[action](class_)
    }
}

export default {
    filters,
    toggleClass
}
