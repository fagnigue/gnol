/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';


// start the Stimulus application
import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'feather-icons/dist/feather.js';
import $ from 'jquery';

console.log("Javascript pass !");

// preview file in profil page
var readURL = function(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('.profile-pic').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$(".file-upload").on('change', function() {
    readURL(this);
});

$(".upload-button").on('click', function() {
    $(".file-upload").click();
    //console.log("le bouton passe !");
});