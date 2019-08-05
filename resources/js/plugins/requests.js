import api from '../services/axios'
import functions from '../services/methods'
import callbacks from '../services/callbacks'
import cart from '../cart/cart'
import modalMaster from '../modal/modal'
import handleDelete from '../delete/delete'

const formSubmit = () => {
    let route
    let form
    let data
    let drop_zone_target
    let drop_zone_files
    let listenerSubmit = Array.from(document.querySelectorAll('.j-submit'))

    listenerSubmit.forEach((el) => {
        el.addEventListener('submit', (event) => {
            event.preventDefault()

            form =(event.target) ? event.target : null
            route = form.getAttribute('action')
            data = new FormData(form)
            drop_zone_target = document.querySelector('.dropzone-area');

            functions.handlerHighlightClass(form)
            // functions.handlerFormButton(form)

            if(drop_zone_target != null) {
                drop_zone_files = drop_zone_target.dropzone ? drop_zone_target.dropzone.getAcceptedFiles() : null;

                if (drop_zone_files != null) {
                    drop_zone_files.forEach((i) => {
                        data.append('images[]', i);
                    });
                }
            }

            if(form.getAttribute('id') == 'form-moip-credit-card') {
                cart.checkCardNumber()
                cart.checkCvc()
                cart.checkExpireDate()

                let input_maturity = document.getElementById("holder_maturity")
                let maturity = input_maturity.value.split('/')

                let cc_hash = new Moip.CreditCard({
                    number: document.getElementById('card_number').value,
                    cvc: document.getElementById('card_cvc').value,
                    expMonth: maturity[0],
                    expYear: maturity[1],
                    pubKey: document.getElementById('card-key').value
                })

                if(cc_hash.isValid()) {
                    data.append('card_hash', cc_hash.hash());
                } else {
                    document.getElementById('card-hash').value = '';
                }
            }

            api.post(route, data)
                .then( (res) => {
                    callbacks.handleWithSuccess(res.data, form)
                    modalMaster()
                    handleDelete()
                    cart.addrSelect()
                })
                .catch((error) => {
                    let errorObject = JSON.parse(JSON.stringify(error))

                    if(errorObject.response != null && errorObject.response !== undefined) {
                        errorObject = errorObject.response.data
                        let keys = Object.keys(errorObject)

                        keys.forEach(key => {
                            callbacks.handlerWithErrors(errorObject, key, form)
                        })
                    } else {
                        console.log(error)
                    }
                })
                .then(() => {
                    functions.handlerFormButton(form, false)
                })
        })
    })
}


export default formSubmit