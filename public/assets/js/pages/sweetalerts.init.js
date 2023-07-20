/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!************************************************!*\
  !*** ./resources/js/pages/sweetalerts.init.js ***!
  \************************************************/
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _defineProperty(obj, key, value) { key = _toPropertyKey(key); if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }
/*
Template Name: Velzon - Admin & Dashboard Template
Author: Themesbrand
Website: https://Themesbrand.com/
Contact: Themesbrand@gmail.com
File: Sweatalerts init js
*/

//Basic
document.getElementById("sa-basic").addEventListener("click", function () {
  Swal.fire({
    title: 'Any fool can use a computer',
    confirmButtonClass: 'btn btn-primary w-xs mt-2',
    buttonsStyling: false,
    showCloseButton: true
  });
});

//A title with a text under
document.getElementById("sa-title").addEventListener("click", function () {
  Swal.fire({
    title: "The Internet?",
    text: 'That thing is still around?',
    icon: 'question',
    confirmButtonClass: 'btn btn-primary w-xs mt-2',
    buttonsStyling: false,
    showCloseButton: true
  });
});

//Success Message
document.getElementById("sa-success").addEventListener("click", function () {
  Swal.fire({
    title: 'Good job!',
    text: 'You clicked the button!',
    icon: 'success',
    showCancelButton: true,
    confirmButtonClass: 'btn btn-primary w-xs me-2 mt-2',
    cancelButtonClass: 'btn btn-danger w-xs mt-2',
    buttonsStyling: false,
    showCloseButton: true
  });
});

//error Message
document.getElementById("sa-error").addEventListener("click", function () {
  Swal.fire({
    title: 'Oops...',
    text: 'Something went wrong!',
    icon: 'error',
    confirmButtonClass: 'btn btn-primary w-xs mt-2',
    buttonsStyling: false,
    footer: '<a href="">Why do I have this issue?</a>',
    showCloseButton: true
  });
});

// long content

document.getElementById("sa-longcontent").addEventListener("click", function () {
  Swal.fire({
    imageUrl: 'https://placeholder.pics/svg/300x1500',
    imageHeight: 1500,
    imageAlt: 'A tall image',
    confirmButtonClass: 'btn btn-primary w-xs mt-2',
    buttonsStyling: false,
    showCloseButton: true
  });
});

//Warning Message
document.getElementById("sa-warning").addEventListener("click", function () {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonClass: 'btn btn-primary w-xs me-2 mt-2',
    cancelButtonClass: 'btn btn-danger w-xs mt-2',
    confirmButtonText: "Yes, delete it!",
    buttonsStyling: false,
    showCloseButton: true
  }).then(function (result) {
    if (result.value) {
      Swal.fire({
        title: 'Deleted!',
        text: 'Your file has been deleted.',
        icon: 'success',
        confirmButtonClass: 'btn btn-primary w-xs mt-2',
        buttonsStyling: false
      });
    }
  });
});

//Parameter
document.getElementById("sa-params").addEventListener("click", function () {
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, delete it!',
    cancelButtonText: 'No, cancel!',
    confirmButtonClass: 'btn btn-primary w-xs me-2 mt-2',
    cancelButtonClass: 'btn btn-danger w-xs mt-2',
    buttonsStyling: false,
    showCloseButton: true
  }).then(function (result) {
    if (result.value) {
      Swal.fire({
        title: 'Deleted!',
        text: 'Your file has been deleted.',
        icon: 'success',
        confirmButtonClass: 'btn btn-primary w-xs mt-2',
        buttonsStyling: false
      });
    } else if (
    // Read more about handling dismissals
    result.dismiss === Swal.DismissReason.cancel) {
      Swal.fire({
        title: 'Cancelled',
        text: 'Your imaginary file is safe :)',
        icon: 'error',
        confirmButtonClass: 'btn btn-primary mt-2',
        buttonsStyling: false
      });
    }
  });
});

//Custom Image
document.getElementById("sa-image").addEventListener("click", function () {
  Swal.fire({
    title: 'Sweet!',
    text: 'Modal with a custom image.',
    imageUrl: 'assets/images/logo-sm.png',
    imageHeight: 40,
    confirmButtonClass: 'btn btn-primary w-xs mt-2',
    buttonsStyling: false,
    animation: false,
    showCloseButton: true
  });
});

//Auto Close Timer
document.getElementById("sa-close").addEventListener("click", function () {
  var timerInterval;
  Swal.fire({
    title: 'Auto close alert!',
    html: 'I will close in <strong></strong> seconds.',
    timer: 2000,
    timerProgressBar: true,
    showCloseButton: true,
    didOpen: function didOpen() {
      Swal.showLoading();
      timerInterval = setInterval(function () {
        var content = Swal.getHtmlContainer();
        if (content) {
          var b = content.querySelector('b');
          if (b) {
            b.textContent = Swal.getTimerLeft();
          }
        }
      }, 100);
    },
    onClose: function onClose() {
      clearInterval(timerInterval);
    }
  }).then(function (result) {
    /* Read more about handling dismissals below */
    if (result.dismiss === Swal.DismissReason.timer) {
      console.log('I was closed by the timer');
    }
  });
});

//custom html alert
document.getElementById("custom-html-alert").addEventListener("click", function () {
  Swal.fire(_defineProperty({
    title: '<i>HTML</i> <u>example</u>',
    icon: 'info',
    html: 'You can use <b>bold text</b>, ' + '<a href="//Themesbrand.in/">links</a> ' + 'and other HTML tags',
    showCloseButton: true,
    showCancelButton: true,
    confirmButtonClass: 'btn btn-success me-2',
    cancelButtonClass: 'btn btn-danger',
    buttonsStyling: false,
    confirmButtonText: '<i class="ri-thumb-up-fill align-bottom me-1"></i> Great!',
    cancelButtonText: '<i class="ri-thumb-down-fill align-bottom"></i>'
  }, "showCloseButton", true));
});

//dialog three buttons
document.getElementById("sa-dialog-three-btn").addEventListener("click", function () {
  Swal.fire({
    title: 'Do you want to save the changes?',
    showDenyButton: true,
    showCancelButton: true,
    confirmButtonText: 'Save',
    confirmButtonClass: 'btn btn-success w-xs me-2',
    cancelButtonClass: 'btn btn-danger w-xs',
    denyButtonClass: 'btn btn-info w-xs me-2',
    buttonsStyling: false,
    denyButtonText: 'Don\'t save',
    showCloseButton: true
  }).then(function (result) {
    /* Read more about isConfirmed, isDenied below */
    if (result.isConfirmed) {
      Swal.fire({
        title: 'Saved!',
        icon: 'success',
        confirmButtonClass: 'btn btn-primary w-xs',
        buttonsStyling: false
      });
    } else if (result.isDenied) {
      Swal.fire({
        title: 'Changes are not saved',
        icon: 'info',
        confirmButtonClass: 'btn btn-primary w-xs',
        buttonsStyling: false
      });
    }
  });
});

//position
document.getElementById("sa-position").addEventListener("click", function () {
  Swal.fire({
    position: 'top-end',
    icon: 'success',
    title: 'Your work has been saved',
    showConfirmButton: false,
    timer: 1500,
    showCloseButton: true
  });
});

//Custom width padding
document.getElementById("custom-padding-width-alert").addEventListener("click", function () {
  Swal.fire({
    title: 'Custom width, padding, background.',
    width: 600,
    padding: 100,
    confirmButtonClass: 'btn btn-primary w-xs',
    buttonsStyling: false,
    background: '#fff url(assets/images/chat-bg-pattern.png)'
  });
});

//Ajax
document.getElementById("ajax-alert").addEventListener("click", function () {
  Swal.fire({
    title: 'Submit email to run ajax request',
    input: 'email',
    showCancelButton: true,
    confirmButtonText: 'Submit',
    showLoaderOnConfirm: true,
    confirmButtonClass: 'btn btn-primary w-xs me-2',
    cancelButtonClass: 'btn btn-danger w-xs',
    buttonsStyling: false,
    showCloseButton: true,
    preConfirm: function preConfirm(email) {
      return new Promise(function (resolve, reject) {
        setTimeout(function () {
          if (email === 'taken@example.com') {
            reject('This email is already taken.');
          } else {
            resolve();
          }
        }, 2000);
      });
    },
    allowOutsideClick: false
  }).then(function (email) {
    Swal.fire({
      icon: 'success',
      title: 'Ajax request finished!',
      confirmButtonClass: 'btn btn-primary w-xs',
      buttonsStyling: false,
      html: 'Submitted email: ' + email
    });
  });
});

// Custom  Sweatalert

//Custom success Message
document.getElementById("custom-sa-success").addEventListener("click", function () {
  Swal.fire({
    html: '<div class="mt-3">' + '<lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#0ab39c,secondary:#405189" style="width:120px;height:120px"></lord-icon>' + '<div class="mt-4 pt-2 fs-15">' + '<h4>Well done !</h4>' + '<p class="text-muted mx-4 mb-0">Aww yeah, you successfully read this important message.</p>' + '</div>' + '</div>',
    showCancelButton: true,
    showConfirmButton: false,
    cancelButtonClass: 'btn btn-primary w-xs mb-1',
    cancelButtonText: 'Back',
    buttonsStyling: false,
    showCloseButton: true
  });
});

//Custom error Message
document.getElementById("custom-sa-error").addEventListener("click", function () {
  Swal.fire({
    html: '<div class="mt-3">' + '<lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#f7b84b" style="width:120px;height:120px"></lord-icon>' + '<div class="mt-4 pt-2 fs-15">' + '<h4>Oops...! Something went Wrong !</h4>' + '<p class="text-muted mx-4 mb-0">Your email Address is invalid</p>' + '</div>' + '</div>',
    showCancelButton: true,
    showConfirmButton: false,
    cancelButtonClass: 'btn btn-primary w-xs mb-1',
    cancelButtonText: 'Dismiss',
    buttonsStyling: false,
    showCloseButton: true
  });
});

//Custom error Message
document.getElementById("custom-sa-warning").addEventListener("click", function () {
  Swal.fire({
    html: '<div class="mt-3">' + '<lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>' + '<div class="mt-4 pt-2 fs-15 mx-5">' + '<h4>Are you Sure ?</h4>' + '<p class="text-muted mx-4 mb-0">Are you Sure You want to Delete this Account ?</p>' + '</div>' + '</div>',
    showCancelButton: true,
    confirmButtonClass: 'btn btn-primary w-xs me-2 mb-1',
    confirmButtonText: 'Yes, Delete It!',
    cancelButtonClass: 'btn btn-danger w-xs mb-1',
    buttonsStyling: false,
    showCloseButton: true
  });
});

// custom Join Our Community
document.getElementById("custom-sa-community").addEventListener("click", function () {
  var _Swal$fire2;
  Swal.fire((_Swal$fire2 = {
    title: 'Join Our Community',
    html: 'You can use <b>bold text</b>, ' + '<a href="//Themesbrand.in/">links</a> ' + 'and other HTML tags'
  }, _defineProperty(_Swal$fire2, "html", '<div class="mt-3 text-start">' + '<label for="input-email" class="form-label fs-13">Email</label>' + '<input type="email" class="form-control" id="input-email" placeholder="Enter Email Address">' + '</div>'), _defineProperty(_Swal$fire2, "imageUrl", 'assets/images/logo-sm.png'), _defineProperty(_Swal$fire2, "footer", '<p class="fs-13 text-muted mb-0">Already have an account ? <a href="#" class="fw-semibold text-decoration-underline"> Signin </a> </p>'), _defineProperty(_Swal$fire2, "imageHeight", 40), _defineProperty(_Swal$fire2, "confirmButtonClass", 'btn btn-primary w-xs mb-2'), _defineProperty(_Swal$fire2, "confirmButtonText", 'Register <i class="ri-arrow-right-line ms-1 align-bottom"></i>'), _defineProperty(_Swal$fire2, "buttonsStyling", false), _defineProperty(_Swal$fire2, "showCloseButton", true), _Swal$fire2));
});

//Custom Email varification
document.getElementById("custom-sa-email-verify").addEventListener("click", function () {
  Swal.fire({
    html: '<div class="mt-3">' + '<div class="avatar-lg mx-auto">' + '<div class="avatar-title bg-light text-success display-5 rounded-circle">' + '<i class="ri-mail-send-fill"></i>' + '</div>' + '</div>' + '<div class="mt-4 pt-2 fs-15">' + '<h4 class="fs-20 fw-semibold">Verify Your Email</h4>' + '<p class="text-muted mb-0 mt-3 fs-13">We have sent you verification email <span class="fw-medium text-dark">example@abc.com</span>, <br/> Please check it.</p>' + '</div>' + '</div>',
    showCancelButton: false,
    confirmButtonClass: 'btn btn-primary mb-1',
    confirmButtonText: 'Verify Email',
    buttonsStyling: false,
    footer: '<p class="fs-14 text-muted mb-0">Didn\'t receive an email ? <a href="#" class="fw-semibold text-decoration-underline">Resend</a></p>',
    showCloseButton: true
  });
});

//Custom notification Message
document.getElementById("custom-sa-notification").addEventListener("click", function () {
  Swal.fire({
    html: '<div class="mt-3">' + '<div class="avatar-lg mx-auto">' + '<img src="assets/images/users/avatar-2.jpg" class="rounded-circle img-thumbnail" alt="thumbnail">' + '</div>' + '<div class="mt-4 pt-2 fs-15">' + '<h4 class="fs-18 fw-semibold">Welcome <span class="fw-semibold">Mike Mayer</span></h4>' + '<p class="text-muted mb-0 fs-13">You have <span class="fw-semibold text-success">2</span> Notifications</p>' + '</div>' + '</div>',
    showCancelButton: false,
    confirmButtonClass: 'btn btn-primary mb-1',
    confirmButtonText: 'Show Me <i class="ri-arrow-right-line ms-1 align-bottom"></i>',
    buttonsStyling: false,
    showCloseButton: true
  });
});
/******/ })()
;