<?php
/**
 * Plugin Name: MN - Custom Phone Validation for WooCommerce
 * Plugin URI: https://github.com/mnestorov/wp-custom-phone-validation-for-woocommerce
 * Description: Adds custom phone number validation for Germany, Austria, and Luxembourg in WooCommerce checkout.
 * Version: 1.1
 * Author: Martin Nestorov
 * Author URI: https://github.com/mnestorov
 * WC requires at least: 3.0.0
 * WC tested up to: 5.1.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class MN_Custom_Phone_Validation {

    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts_styles'));
        add_action('woocommerce_after_checkout_form', array($this, 'initialize_phone_validation'));
    }

    public function enqueue_scripts_styles() {
        // Enqueue intl-tel-input library from CDN
        wp_enqueue_script('intl-tel-input', 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js', array('jquery'), '17.0.8', true);
        wp_enqueue_style('intl-tel-input-css', 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css', array(), '17.0.8');
        
        // Optionally, enqueue the utils script from the CDN for additional functionality
        wp_enqueue_script('intl-tel-input-utils', 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js', array('intl-tel-input'), '17.0.8', true);
    }

    public function initialize_phone_validation() {
        ?>
        <style>
            /* CSS for phone validation */
            .phone-error-message {
                color: red;
                margin-top: 5px;
            }
        </style>

        <script type="text/javascript">
            jQuery(document).ready(function($) {
                if ($('#billing_phone').length > 0) {
                    const input = document.querySelector("#billing_phone");

                    window.intlTelInput(input, {
                        initialCountry: "auto",
                        geoIpLookup: function(callback) {
                            fetch('https://ipapi.co/json')
                                .then(response => response.json())
                                .then(data => callback(data.country_code))
                                .catch(() => callback("us"));
                        },
                        onlyCountries: ['de', 'at', 'lu'], // Germany, Austria, Luxembourg
                        preferredCountries: ['de', 'at', 'lu'],
                        separateDialCode: true,
                        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js" // CDN path to intl-tel-input's utils script
                    });
                }

                // Function to check valid phone number
                function isValidPhoneNumber(phoneNumber, country) {
                    var regexMap = {
                        'de': /^(\+49)[1-9][0-9]{9,10}$/,   // German pattern
                        'at': /^(\+43)[1-9][0-9]{10,12}$/,  // Austrian pattern
                        'lu': /^(\+352)[1-9][0-9]{8}$/,     // Luxembourg pattern
                    };

                    return regexMap[country].test(phoneNumber);
                }

                // Function to display error message
                function displayErrorMessage(message) {
                    var errorMessage = $('<small class="phone-error-message" style="color: red;"></small>');
                    errorMessage.text(message);
                    phoneInput.closest('.form-row').find('.phone-error-message').remove();
                    phoneInput.after(errorMessage);
                }

                // Validate phone number on form submission
                $('form.checkout').on('checkout_place_order', function() {
                    var phoneNumber = iti.getNumber();
                    var countryData = iti.getSelectedCountryData();

                    if (!isValidPhoneNumber(phoneNumber, countryData.iso2)) {
                        displayErrorMessage("Please enter a valid phone number for your country.");
                        return false;
                    }

                    phoneInput.closest('.form-row').find('.phone-error-message').remove();
                    return true;
                });
            });
        </script>
        <?php
    }
}

new MN_Custom_Phone_Validation();