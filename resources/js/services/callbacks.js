import functions from "./methods";
import siteBuild from '../../build/site'

/**
 * Handler with errors
 *
 * @param arg
 * @param key
 * @param form
 */
const handlerWithErrors = (arg, key, form) => {
    let separate
    let data = {
        icon: 'fas fa-exclamation-circle',
        color: 'red',
        timer: 7500
    }

    // When response stop here, that will be like this 'my callback error#show_error'
    // Whe just slice it in two parts for get the message at the index zero and the callback type in a index one
    if(typeof arg[key][0].split('#') != null) {
        separate = arg[key][0].split('#')
    }

    // If the key index is equal an error
    if(key == 'error') {
        data['title'] = arg[key]
        functions.triggerNotify(data)

        // If our slice in index one equal 'show_error'
    } else if(separate[1] == 'show_error') {
        data['title'] = separate[0]
        functions.triggerNotify(data)

        // Else, we just add class highlight for the element in form
    } else {
        let formErrorElement = form.querySelector(`#${key}`)
        let borderOrientation = form.getAttribute('data-border-on-error') !== null ? form.getAttribute('data-border-on-error') : ''
        let separator = borderOrientation != null  && borderOrientation != '' ? '-' : ''

        if(formErrorElement != null) {
            formErrorElement.className += ' highlight' + separator + borderOrientation;
        }
    }
}

/**
 * Handler with success
 *
 * @param arg
 * @param form
 */
const handleWithSuccess = (arg, form) => {
    if(arg.clean_form) {
        functions.cleanForm(form)
    }

    if(arg.redirect_to) {
        functions.redirectTo(arg.redirect_to)
    }

    if(arg.message) {
        functions.talk(arg.message)
    }

    if(arg.reset_img) {
        functions.resetImg(arg.reset_img.target, arg.reset_img.path)
    }

    if(arg.showEmptyContentMessage) {
        functions.showEmptyContentMessage(arg.showEmptyContentMessage.target)
    }

    if(arg.hideEmptyContentMessage) {
        functions.hideEmptyContentMessage(arg.hideEmptyContentMessage.target)
    }

    if(arg.replace_content) {
        functions.replaceContent(arg.replace_content)
    }

    if(!arg.hide_load_more) {
        functions.hideLoadMore(false)
    }

    if(arg.hide_load_more) {
        functions.hideLoadMore(true)
    }

    if(arg.clean_dropzone) {
        myDropzone.removeAllFiles()
    }

    if(arg.close_modal) {
        let modal = document.getElementById('ion-modal-master')
        functions.closeModal(modal)
    }

    if(arg.refreshContent) {
        functions.updateTargetContent(arg.refreshContent.target, arg.refreshContent.data)
    }

    if(arg.rebuildCarousel) {
        let carouselInstance = arg.rebuildCarousel.functionName
        siteBuild[carouselInstance]()
    }

    if(arg.__update_cart_values) {
        functions.updateCart(arg.__update_cart_values)
    }

    if(arg.__refresh_small_cart) {
        functions.updateSmallCart(arg.__refresh_small_cart)
    }

    if(arg.__shipment_options) {
        functions.updateShipmentOptions(arg.__shipment_options)
    }

    if(arg.steps) {
        functions.steps(arg.steps)
    }
}

export default {
    handlerWithErrors,
    handleWithSuccess
}