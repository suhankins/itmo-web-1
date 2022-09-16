const validY = {
    lower: -3,
    upper: 5
}

function validate() {
    var textbox = document.getElementById("Y")
    var number = Number(textbox.value.replace(",", "."))
    var valid = (number >= validY.lower) && (number <= validY.upper)
    var result = {correct: true}
    if (!valid) {
        result.correct = false
        result.error = "Y is incorrect."
    }
    return result
}

const selectElement = document.getElementById("Y");

selectElement.addEventListener('change', (event) => {
    var errorWindow = document.getElementById("error")
    errorWindow.style.display = "none"
    var textBox = document.getElementById("errorText")
    textBox.innerHTML = ""
});


var form = document.getElementById("form")
var submit = document.getElementById("submit")
function handleForm(event) {
    var textbox = document.getElementById("Y").value.replace(",", ".")
    var result = validate()
    if (!result.correct) {
        event.preventDefault()
        submit.style.animation = "100ms forwards ease-in shake"
        addEventListener('animationend', (event) => {
            submit.style.animation = undefined
        });

        var errorWindow = document.getElementById("error")
        errorWindow.style.display = "block"
        var textBox = document.getElementById("errorText")
        textBox.innerHTML = result.error
    }
} 
form.addEventListener('submit', handleForm)