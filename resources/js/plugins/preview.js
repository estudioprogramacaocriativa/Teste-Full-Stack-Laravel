import helper from './helper'

const preview = () => {
    let el = '.preview-image'
    let el_selector = Array.from(document.querySelectorAll(el))
    let target
    let reader
    let item_file
    let data = {
        icon: 'fas fa-exclamation-circle',
        color: 'red',
        timer: 7500
    }

    el_selector.forEach((item) => {
        item.addEventListener('change', function() {
            target = document.querySelector(`.${item.getAttribute('name')}`)
            item_file = item.files

            if (item_file && matchEl(item_file[0].type, ["image/jpeg", "image/png", "image/gif"])) {
                reader = new FileReader()
                reader.onload = function (e) {
                    target.src = e.target.result
                }
                reader.readAsDataURL(item.files[0])
            } else {
                target.src = '../images/no-image.jpg'
                data['title'] = 'Selecione uma imagem válida: jpeg, png ou gif'
                helper.triggerNotify(data)
            }
        })
    })
}

const matchEl = (el, match = []) => {
    if(match.indexOf(el) == -1) return false

    return true
}

export default {
    preview,
    matchEl
}
