import $ from 'jquery'

const buttonState = (btn_id, state = false) => {
    if(btn_id !== '') {
        document.getElementById(btn_id).disabled = state
    }
}

const triggerNotify = (data) => {
    let triggerContent = `
        <div class='trigger_notify trigger_notify_${data.color}' style='left: 100%; opacity: 0;'>
        <p><i class='${data.icon}' style='margin-right: 8px;'></i>${data.title}</p>
        <span class='trigger_notify_timer'></span>
    </div>`

    if(!$('.trigger_notify_box').length) {
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
            }
        }
    }
}

const redirectTo = (path) => {
    window.location.href = path
}

const talk = (message) => {
    const data = {
        title: message,
        icon: 'fas fa-check-circle',
        color: 'green',
        timer: 4500
    };

    triggerNotify(data)
}

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

const handlerWithErrors = (arg, form) => {
    let errorObject = JSON.parse(JSON.stringify(arg))
    let separate
    let data = {
        icon: 'fas fa-exclamation-circle',
        color: 'red',
        timer: 7500
    }

    if(errorObject.response != null && errorObject.response !== undefined) {
        errorObject = errorObject.response.data
        let keys = Object.keys(errorObject)

        keys.forEach(key => {
            if(typeof errorObject[key][0].split('#') != null) {
                separate = errorObject[key][0].split('#')
            }

            if(key == 'error') {
                data['title'] = errorObject[key]
                triggerNotify(data)
            } else if(separate[1] == 'show_error') {
                data['title'] = separate[0]
                triggerNotify(data)
            } else {
                let formErrorElement = form.querySelector(`#${key}`)
                let borderOrientation = form.getAttribute('data-border-on-error') !== null ? form.getAttribute('data-border-on-error') : ''
                let separator = borderOrientation != null  && borderOrientation != '' ? '-' : ''

                if(formErrorElement != null) {
                    formErrorElement.className += ' highlight' + separator + borderOrientation;
                }
            }
        })

    } else {
        console.log(arg)
    }
}

const handlerFormButton = (form, disabled = true) => {
    let formBtn = form.querySelector('button[type="submit"]')
    formBtn.disabled = disabled
    formBtn.classList.add('button-loading')
}

const handleWithSuccess = (arg, form) => {
    if(arg.clean_form) {
        cleanForm(form)
    }

    if(arg.redirect_to) {
        redirectTo(arg.redirect_to)
    }

    if(arg.message) {
        talk(arg.message)
    }

    if(arg.reset_img) {
        resetImage(arg.reset_img.path, arg.reset_img.target)
    }
}

const resetImage = (path, target) => {
    document.getElementById(target).src = path
}

export default {
    talk,
    buttonState,
    handlerWithErrors,
    handleWithSuccess,
    triggerNotify,
    cleanForm,
    redirectTo,
    handlerHighlightClass,
    handlerFormButton,
    resetImage
}
