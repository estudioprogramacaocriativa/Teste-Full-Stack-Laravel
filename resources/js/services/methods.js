import responses from "./callbacks";
import $ from 'jquery'
import modal from "../modal/modal";

let bs = require('bootstrap.native')

let fields = ['_address', '_neighborhood', '_city', '_state', '_complement', '_number'];

/**
 * Clean up field for zipcode autocomplete.
 *
 * @param {string} parent
 */
const clean_fields_cep = (parent = null) => {
    setTimeout(function(){
        $.each(fields,  function(i,v){
            parent.find('.' + v).val('').removeAttr('disabled');
        });
    }, 1000);
}

/**
 * Pre-autocomplete fields before update
 * it with zipcode data result!
 *
 * @param {string} parent
 */
const preload_fields = (parent = null) => {
    $.each(fields, function(i,v){
        if(v === "_number"){
            parent.find('.' + v).attr('disabled', true);
        }else{
            parent.find('.' + v).val('Buscando...').addClass('has-value').attr('disabled', true);
        }
    });
}

/**
 * Populate fields with zipcode data result
 *
 * @param {array} data
 * @argument {string} parent
 */
const populate_fields = (data, parent = null) => {

    var response_values = {0: 'logradouro', 1: 'bairro', 2: 'localidade', 3: 'uf', 4: 'complemento'};

    setTimeout(function(){
        $.each(fields, function(i,v){
            if(v === "_number"){
                parent.find('.' + v).removeAttr('disabled').focus();
            }else{
                parent.find('.' + v).val(data[response_values[i]]).removeAttr('disabled').css({"border-color": "#ccc"});
            }
        });
    }, 1000);
}

/**
 * Redirect for specif location
 *
 * @param path
 */
const redirectTo = (path) => {
    window.location.href = path
}

/**
 * Clean form > * values
 *
 * @param form
 * @param exceptClass
 */
const cleanForm = (form, exceptClass = 'noclear') => {
    let formElements, formElementItem, formElementClass

    formElements = form.elements
    formElementClass = exceptClass

    for(let i=0; i<=formElements.length; i++) {
        if(typeof formElements[i] != 'undefined') {
            formElementItem = document.getElementById(formElements[i].id)

            if(formElementItem != null) {
                if(!formElementItem.classList.contains(formElementClass)) {
                    formElementItem.value = ''
                }

                /*if(formElementItem.classList.contains('editor')) {
                    formElementItem.summernote('code', '<p><br></p>');
                }*/
            }
        }
    }
}

/**
 * Reset image preview
 *
 * @param target
 * @param item
 */
const resetImg = (target, item) => {
    document.querySelector( '.' + target ).querySelector( 'img' ).src = item;
}

/**
 * Show a custom message
 *
 * @param message
 */
const talk = (message) => {
    const data = {
        title: message,
        icon: 'fas fa-check-circle',
        color: 'green',
        timer: 4500
    };

    triggerNotify(data)
}

/**
 * Handle errors
 *
 * @param arg
 * @param form
 */
const onError = (arg, form) => {
    let keys = Object.keys(arg)
    keys.forEach(key => {
        responses.handlerWithErrors(arg, key, form)
    })
}

/**
 * Hide the empty results container
 *
 * @param targetContainer
 */
const hideEmptyContentMessage = (targetContainer) => {
    let target = document.querySelector(targetContainer);
        target.style.display = 'none';
}

/**
 * Show the empty results container
 *
 * @param targetContainer
 */
const showEmptyContentMessage = (targetContainer) => {
    let target = document.querySelector(targetContainer);
        target.style.display = 'block';
}

/**
 * Handler success
 *
 * @param arg
 * @param form
 */
const onSuccess = (arg, form) => {
    responses.handleWithSuccess(arg, form)
}

/**
 * Hide the load more button
 */
const hideLoadMore = (status) => {
    let element = document.querySelector('.load-more')

    if(element !== undefined && element !== null)
        document.querySelector('.load-more').style.display = !status ? 'block' : 'none'
}

/**
 * Replace target container
 *
 * @param data
 * @param targetContainer
 */
const replaceContent = (data, targetContainer = 'replace-search-content') => {
    if(Array.isArray(data.targets)) {
        let targets = data.targets
            targets.forEach(function (i, v) {
                document.querySelector(i.div).innerHTML = i.content
            })
    } else {
        let container = document.querySelector('.' + targetContainer)
            container.innerHTML = data
    }
}

/**
 *
 * @param {type} message
 * @param {type} classe
 * @returns {undefined}
 */
const showNotification = (message, classe) => {
    $('body').append(`<div class="callback"><div class="content"></div></div>`).addClass(classe).html(message).animate({top: 0}, 335);

    setTimeout(function(){closeNotification();}, 5000);
}

/**
 *
 * @returns {undefined}
 */
const removeNotification = () => {
    $(document).find('.callback').animate({top: '-250px'}, 335);
}

/**
 *
 * @returns {undefined}
 */
const closeNotification = () => {
    $(document).on('click', '.callback', function(){
        $(this).animate({top: '-250px'}, 335);
    });
}

const triggerNotify = (data) => {

    var triggerContent = "<div class='trigger_notify trigger_notify_" + data.color + "' style='left: 100%; opacity: 0;'>";
    triggerContent += "<p><i class='" + data.icon + "' style='margin-right: 8px;'></i>" + data.title + "</p>";
    triggerContent += "<span class='trigger_notify_timer'></span>";
    triggerContent += "</div>";

    if(!$('.trigger_notify_box').length){
        $('body').prepend("<div class='trigger_notify_box'></div>");
    }

    $('.trigger_notify_box').prepend(triggerContent);
    $('.trigger_notify').stop().animate({'left': '0', 'opacity': '1'}, 200, function(){
        $(this).find('.trigger_notify_timer').animate({'width': '100%'}, data.timer, 'linear', function(){
            $(this).parent('.trigger_notify').animate({'left': '100%', 'opacity': '0'}, function(){
                $(this).remove();
            });
        });
    });

    $('body').on('click', '.trigger_notify', function(){
        $(this).animate({'left': '100%', 'opacity': '0'}, function(){
            $(this).remove();
        });
    });

}

/**
 * Close the opening bootstrap modal
 *
 * @param modal
 */
const closeModal = (modal) => {
    let instanceModal = new bs.Modal(modal)
        instanceModal.hide()
}

/**
 * Update content for specified target
 *
 * @param target
 * @param newData
 */
const updateTargetContent = (target, newData) => {
    document.querySelector(target).innerHTML = newData
}

/**
 * Handler form elements highlight class
 *
 * @param form
 */
const handlerHighlightClass = (form) => {
    let formElementItem,
        borderOrientation = form.getAttribute('data-border-on-error') !== null ? form.getAttribute('data-border-on-error') : '',
        separator = borderOrientation != null  && borderOrientation != '' ? '-' : '',
        formElementClass = 'highlight' + separator + borderOrientation

    Array.from(form.elements).filter(el => el !== undefined && el.id).forEach(form => {
        formElementItem = document.getElementById(form.id)
        formElementItem.classList.remove(formElementClass)
    })
}

/**
 * Handler button state
 *
 * @param form
 * @param disabled
 */
const handlerFormButton = (form, disabled = true) => {
    let formBtn = form.querySelector('button[type="submit"]')
    formBtn.disabled = disabled
    formBtn.classList.add('button-loading')
}

const updateCart = (response) => {
    if(response.__rows) {
        document.querySelector('.header-cart .shop-count-furniture').innerHTML = response.__rows;
    }

    if(response.__line) {
        document.getElementById('item-' + response.__line).remove();
    }

    if(response.__item_single_update) {
        document
            .getElementById('item-' + response.__line_id)
            .querySelector('.__line_total')
            .innerHTML = response.__item_single_update;
    }

    if(response.__total) {
        document.querySelector('.__cart_total strong').innerHTML = response.__total;
    }

    if(response.__shipment) {
        document.querySelector('.__cart_shipment strong').innerHTML = response.__shipment;
    }

    if(response.__subtotal) {
        document.querySelector('.__cart_subtotal strong').innerHTML = response.__subtotal;
    }

    if(response.__discount) {
        document.querySelector('.__cart_discount strong').innerHTML = response.__discount;
    }

    if(parseInt(response.__rows) === 0) {
        document.querySelector('.empty-results.--cart').classList.add('--visible');
        document.querySelector('.cart-container').style.display = 'none';
    }
}

const updateSmallCart = (response) => {
    document.querySelector('.header-cart .shop-count-furniture').innerHTML = response.__items_total;
    document.querySelector(response.__target).innerHTML = response.__items;

    if(parseInt(response.__items_total) === 0) {
        document.querySelector('.header-cart .cart-dropdown .empty-results').classList.add('--visible');
    }
}

const updateShipmentOptions = (data) => {
    document.querySelector('.ship-options').style.display = 'block'

    if(document.querySelector('.ship-options article') != null) {
        document.querySelector('.ship-options article').style.display = 'block'
    }

    document.querySelector('.__shipment_options').innerHTML = data
}

const steps = (keys) => {
    let button = document.getElementById('prevBtn')
    let buttonNext = document.getElementById('nextBtn')

    if(keys.remove_finished) {
        let item = document.querySelector('.step-' + keys.step_prev)
        item.classList.remove('finished')
        item.classList.add('current');
    }

    if(keys.step_unlock) {
        document.querySelector('.step-' + keys.step_prev).classList.add('finished')
    }

    if(keys.show_btn_submit) {
        buttonNext.querySelector('span').innerHTML = 'Finalizar'
    } else {
        buttonNext.querySelector('span').innerHTML = 'Próximo'
    }

    if(keys.show_prev_btn) {
        button.style.display = 'block'
    }

    if(keys.hide_prev_btn) {
        if(keys.hide_prev_btn != false) {
            button.style.display = 'none'
        }
    }

    let step_containers = document.querySelectorAll('.step-item')
        Array.from(step_containers).forEach((e) => {
            e.style.display = 'none'
        })

    let step_tabs = document.querySelectorAll('.step')
        Array.from(step_tabs).forEach((e) => {
            e.classList.remove('current')
        })

    if(keys.step_prev == keys.step_unlock) {
        document.querySelector('.step-' + keys.step_prev).classList.remove('finished')
    }

    document.querySelector('.step-' + keys.step_unlock).classList.add('current')
    document.querySelector('.item-' + keys.step_unlock).style.display = 'block'
}

export default {
    redirectTo,
    cleanForm,
    talk,
    resetImg,
    onError,
    onSuccess,
    hideEmptyContentMessage,
    showEmptyContentMessage,
    hideLoadMore,
    replaceContent,
    showNotification,
    removeNotification,
    closeNotification,
    triggerNotify,
    handlerHighlightClass,
    handlerFormButton,
    clean_fields_cep,
    preload_fields,
    populate_fields,
    closeModal,
    updateTargetContent,
    updateCart,
    updateSmallCart,
    updateShipmentOptions,
    steps
}