const validY = {
    lower: -3,
    upper: 5
}

function validate() {
    var textbox = document.getElementById("Y")
    var number = Number(textbox.value)
    var valid = (number >= validY.lower) && (number <= validY.upper)
    return valid
}

var form = document.getElementById("form")
var submit = document.getElementById("submit")
function handleForm(event) {
    if (!validate()) {
        event.preventDefault()
        submit.style.animation = "500ms forwards ease-in shake"
        addEventListener('animationend', (event) => {
            submit.style.animation = undefined
        });
    }
} 
form.addEventListener('submit', handleForm)