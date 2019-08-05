const preview = () => {
    let el = '.preview-image'
    let el_selector = Array.from(document.querySelectorAll(el))
    let target
    let reader

    el_selector.forEach((item) => {
        item.addEventListener('change', function() {
            target = document.querySelector(`.${item.getAttribute('name')}`)
            let item_file = item.files

            if (item_file && this.matchEl(item_file[0].type, ["image/jpeg", "image/png", "image/gif"])) {
                reader = new FileReader()
                reader.onload = function (e) {
                    target.src = e.target.result
                }
                reader.readAsDataURL(item.files[0])
            } else {
                alert('Selecione uma imagem válida: jpeg, png ou gif')
            }
        })
    })
}

const matchEl = (el, match = []) => {
    match.forEach(item => {
        let m = el.match(item)

        console.log(m)
    })

    // return el.match(match)
}

export default                             {
    preview,
    matchEl
}
