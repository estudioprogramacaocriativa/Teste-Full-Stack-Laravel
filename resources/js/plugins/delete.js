import api from './../services/axios'
import helper from './helper'

const trash = () => {
    let formData = new FormData()
    let item_id
    let item_controller
    let method
    let item_route
    let reload_data = document.querySelector('.reload-data')
    let el = document.querySelectorAll('.j-trash')
    let el_selector = Array.from(el)
    let loading_target = document.querySelector('.loading')
    let container_hide_target = document.querySelector('.hide-when-loading')

    if(el_selector) {
        el_selector.forEach((item) => {
            item.addEventListener('click', (event) => {
                event.preventDefault()

                if (window.confirm('Deseja realmente remover o registro?')) {
                    if (!item.classList.contains('active')) {
                        loading_target.style.display = 'block'
                        container_hide_target.style.display = 'none'
                        item_id = item.dataset.id
                        item_controller = item.dataset.controller
                        method = item.dataset.method
                        item_route = item.dataset.route

                        formData.append('item_id', item_id)
                        formData.append('item_controller', item_controller)
                        formData.append('item_route', item_route)
                        formData.append('method', method)

                        api.post(item_route, formData)
                            .then((resp) => {
                                reload_data.innerHTML = resp.data.data
                                helper.handleWithSuccess(resp.data)
                                trash()
                            })
                            .then(() => {
                                loading_target.style.display = 'none'
                                container_hide_target.style.display = 'block'
                            })
                            .catch(() => {
                            })
                    }
                }
            })
        })
    }
}

export default trash
