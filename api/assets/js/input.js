const inputs = document.querySelectorAll('input[type=file]');

document.addEventListener('DOMContentLoaded', function () {

    Array.prototype.forEach.call(inputs, function (input) {
        const label = input.nextElementSibling;
        const labelVal = label.innerHTML;

        const fileName = input.value.split('\\' ).pop();
        if (fileName) {
            label.innerHTML = fileName;
        } else {
            label.innerHTML = labelVal;
        }

        input.addEventListener('change', function (e) {
            const fileName = e.target.value.split('\\' ).pop();
            if (fileName) {
                label.innerHTML = fileName;
            } else {
                label.innerHTML = labelVal;
            }
        });
    });

});