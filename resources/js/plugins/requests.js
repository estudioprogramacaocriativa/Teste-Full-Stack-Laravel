import api from '../services/axios'
import helper from './helper'

const handlerSubmit = () => {
    let route
    let form
    let data
    let el_selector = Array.from(document.querySelectorAll('.j-submit'))

    el_selector.forEach((el) => {
        el.addEventListener('submit', (item) => {
            item.preventDefault()

            form = item.target
            route = form.getAttribute('action')
            data = new FormData(form)

            helper.handlerHighlightClass(form)
            helper.handlerFormButton(form)

            api.post(route, data)
                .then( (resp) => helper.handleWithSuccess(resp.data, form))
                .catch((err) => helper.handlerWithErrors(err, form))
                .then(() => helper.handlerFormButton(form, false))
        })
    })
}


export default handlerSubmit
