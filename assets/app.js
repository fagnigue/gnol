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
import $, { post } from 'jquery';

console.log("Javascript pass !");

/* GET GEOLOCALISATION
$.getJSON('http://ipwhois.app/json/', function(data) {
    country_code = data['country_code'];
    console.log(country_code);
});*/

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




// ADD PRODUCT IN SHOPPING CART
$("#add").on('click', function() {
    var product_id = $("#product_id").val();

    console.log("add button clicked");

    $.ajax({
        method: "POST",
        url: "/addproducttocart",
        data: { 'product_id': product_id },
        success: function(data) {
            $('#badge_cart').html(data);
            var msg = "Produit ajouté au panier";
            //console.log(msg);
            $("#msg").html(msg).addClass('alert alert-success').fadeIn(600).delay(500).fadeOut(600);
            $("#add").prop('disabled', true);
        },
        error: function() {
            alert('error');
        }
    });
});

// CHECKED DELIVER MODE
$("#relaypoint").on('change', function() {
    var delivermode = $("#relaypoint").val();

    $.ajax({
        method: "GET",
        url: "/command/delivermode",
        data: { 'delivermode': delivermode },
        success: function(data) {
            console.log(data);
            var deliver_price = data['deliver_price'];
            var total_cart = data['total_cart'];

            $.getJSON('http://ipwhois.app/json/', function(data) {
                var country_code = data['country_code'];

                if (country_code == 'CI') {
                    deliver_price = parseFloat(deliver_price * 655.85).toFixed(2);
                    total_cart = parseFloat(total_cart * 655.85).toFixed(2);
                    $('#frais_livraison').html(deliver_price + ' CFA');
                    $('#total_command').html(total_cart + ' CFA');
                } else {
                    $('#frais_livraison').html(`&euro; ` + deliver_price);
                    $('#total_command').html(`&euro;` + total_cart);
                }
            });

            $("#pays").prop('disabled', false);

        },
        error: function() {
            alert('error');
        }
    });
});

$("#homepoint").on('change', function() {
    var delivermode = $("#homepoint").val();

    $.ajax({
        method: "GET",
        url: "/command/delivermode",
        data: { 'delivermode': delivermode },
        success: function(data) {
            console.log(data);
            var deliver_price = data['deliver_price'];
            var total_cart = data['total_cart'];

            $.getJSON('http://ipwhois.app/json/', function(data) {
                var country_code = data['country_code'];

                if (country_code == 'CI') {
                    deliver_price = parseFloat(deliver_price * 655.85).toFixed(2);
                    total_cart = parseFloat(total_cart * 655.85).toFixed(2);
                    $('#frais_livraison').html(deliver_price + ' CFA');
                    $('#total_command').html(total_cart + ' CFA');
                } else {
                    $('#frais_livraison').html(`&euro; ` + deliver_price);
                    $('#total_command').html(`&euro; ` + total_cart);
                }
            });

            $("#pays").prop('disabled', true);

        },
        error: function() {
            alert('error');
        }
    });
});