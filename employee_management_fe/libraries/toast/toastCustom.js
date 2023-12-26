var successStyle = '#07bc0c';
var errorStyle = '#e74c3c';

function createToast(text, type) {
  var style = 'linear-gradient(to right, #00b09b, #96c93d)';
  if (type == 'success') style = successStyle;
  else if (type == 'error') style = errorStyle;
  Toastify({
    text: text,
    duration: 3000,
    close: true,
    gravity: 'top', // `top` or `bottom`
    position: 'right', // `left`, `center` or `right`
    stopOnFocus: true, // Prevents dismissing of toast on hover
    style: {
      background: style,
    },
    onClick: function () {}, // Callback after click
  }).showToast();
}
