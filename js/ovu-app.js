/*
    INTENT:      OVU ADMIN PAGE SETTINGS SCRIPT
    CREATED:     December 17, 2017
    AUTHOR:      Clinton Gallagher @tapABILITIES; All Rights Reserved
    PARAMETERS:  none
    RETURNS:     nothing
    NOTE:        The ovu prefix is an acronym of onBrowser Resize Viewport Units
*/

/*
    This MDN script detects whether localStorage is both supported and available using known browser tests.
    https://developer.mozilla.org/en-US/docs/Web/API/Web_Storage_API/Using_the_Web_Storage_API
*/


function storageAvailable(type) {
'use strict';

    try {
        var storage = window[type],
            x = '__storage_test__';
        storage.setItem(x, x);
        storage.removeItem(x);
        return true;
    }
    catch(err) {
        return err instanceof DOMException && (
            // For everything except Firefox
            err.code === 22 ||
            // For Firefox
            err.code === 1014 ||
            // Test name field because code might not be present
            // For everything except Firefox
            err.name === 'QuotaExceededError' ||
            // For Firefox
            // If there's an attempt to store more than 5MB allowed by HTML5 localStorage
            // TODO: catching this error should also be written for use with other browsers
            err.name === 'NS_ERROR_DOM_QUOTA_REACHED') && storage.length !== 0;
    }
}

/*
    The first time the plugin is activated and loaded in the settings page
    HTML5 localStorage stores default values for the Viewport Unit's container settings.
*/
(function(){
'use strict';

    // Default Viewport Units container values
    var marginBottom = "0";
    var backgroundColor = "#000000";
    var textColor = "#FF8C00";
    var topBorderColor = "#FF8C00";
    var bottomBorderColor = "#FF8C00";

    try {

        // MDN storageAvailable() script determines if localStorage is supported
        if (storageAvailable('localStorage')) {
            // If this is the first time the plugin is loaded the keys should be empty
            if( !localStorage.getItem( 'ovu_marginBottomKey'      ) ||
                !localStorage.getItem( 'ovu_backgroundColorKey'   ) ||
                !localStorage.getItem( 'ovu_textColorKey'         ) ||
                !localStorage.getItem( 'ovu_topBorderColorKey'    ) ||
                !localStorage.getItem( 'ovu_bottomBorderColorKey' ) ) {

                // Since the localStorage keys were empty Write default values to localStorage
                localStorage.setItem( 'ovu_marginBottomKey', marginBottom );
                localStorage.setItem( 'ovu_backgroundColorKey', backgroundColor );
                localStorage.setItem( 'ovu_textColorKey', textColor );
                localStorage.setItem( 'ovu_topBorderColorKey', topBorderColor );
                localStorage.setItem( 'ovu_bottomBorderColorKey', bottomBorderColor );
            }
        }
        else {
            alert("The browser you are using is so old it does not support HTML5 localStorage.");
        }
    }
    catch(err)
    { alert("The first time localStorage was populated with data" + "\r\n"
          + "there was an unrecoverable error:"
          + err.message); }
})();

/*
    Get values from localStorage and update the input element and the color pickers in the settings page
    to maintain the state of any changes that may have been made to the properties of the Viewport Units container.
*/
(function(){
'use strict';

    try {

        if (storageAvailable('localStorage')) {

            // At least one element must be confirmed to not be null or catch(err)
            // will raise a document.getElementById(...) is null error when leaving the settings page.
            if( document.getElementById("ovu_inner_background_color") !== null ) {
                document.getElementById("colorPickerForm").elements["ovu_margin_bottom"].value = localStorage.getItem( 'ovu_marginBottomKey' );
                document.getElementById("ovu_inner_background_color").style.backgroundColor = localStorage.getItem( 'ovu_backgroundColorKey' );
                document.getElementById("ovu_inner_text_color").style.backgroundColor =  localStorage.getItem( 'ovu_textColorKey' );
                document.getElementById("ovu_inner_top_border_color").style.backgroundColor = localStorage.getItem( 'ovu_topBorderColorKey' );
                document.getElementById("ovu_inner_bottom_border_color").style.backgroundColor = localStorage.getItem( 'ovu_bottomBorderColorKey' );
            }

        }
        else {
            alert("The browser you are using is so old it does not support HTML5 localStorage.");
        }
    }
    catch(err)
    { alert("While changing colorPicker selections" + "\r\n"
            + "there was an unrecoverable error:"   + "\r\n"
            + err.message); }
})();

/*
    After localStorage is populated with default values for the Viewport Units container
    this try block overwrites and updates localStorage when the user is in the settings page and
    the input element or the color pickers are used to change Viewport Unit container properties.

    Since this is where the most current Viewport Units container properties are created
    and stored a collection of the properties will also be stored in a cookie so the values
    can be read by server-side PHP code in the viewport_units-script-block.php file which is
    where the Viewport Units container is generated for display in all pages within the
    website as long as the plugin remains activated.
*/
try {

    jQuery(function ($) {

        $(document).ready(function () {
            // NOTE: The following tinycolorpicker() function assignments are required or
            // the color pickers will not display or function in the page.
            var $background_color = $('#ovu_settings_background_color').tinycolorpicker();
            var $text_color = $('#ovu_settings_text_color').tinycolorpicker();
            var $top_border_color = $('#ovu_settings_top_border_color').tinycolorpicker();
            var $bottom_border_color = $('#ovu_settings_bottom_border_color').tinycolorpicker();

            // Updates the value of ovu_marginBottomKey in localStorage when the user selects the
            // spinners on the input control in the settings page. Doing so changes the value of the
            // Viewport Units container Bottom Margin property used to move the entire ViewPort Units
            // container vertically up or down in he page as may be needed. No further validation needs
            // to be used other than that provided by these event listeners.
            $("#ovu_margin_bottom").on("change paste keyup", function() {
                localStorage.setItem( 'ovu_marginBottomKey', document.getElementById("colorPickerForm").elements["ovu_margin_bottom"].value );
                saveSetting(this);
            });

            // Update value of the backgroundColorKey in localStorage when the user
            // clicks on the color picker and changes a color picker value
            $background_color.bind("change", function () {
                localStorage.setItem( 'ovu_backgroundColorKey', $('#hidden-input-background-color').val() );
                saveSetting(this);
            });

            // Update value of the textColorKey in localStorage when the user
            // clicks on the color picker and changes a color picker value
            $text_color.bind("change", function () {
                localStorage.setItem( 'ovu_textColorKey', $('#hidden-input-text-color').val() );
                saveSetting(this);
            });

            // Update value of the topBorderColorKey in localStorage when the user
            // clicks on the color picker and changes a color picker value
            $top_border_color.bind("change", function () {
                localStorage.setItem( 'ovu_topBorderColorKey', $('#hidden-input-top-border-color').val() );
                saveSetting(this);
            });

            // Update value of the bottomBorderColorKey in localStorage when the user
            // clicks on the color picker and changes a color picker value
            $bottom_border_color.bind("change", function () {
                localStorage.setItem( 'ovu_bottomBorderColorKey', $('#hidden-input-bottom-border-color').val() );
                saveSetting(this);
            });

            // Store the Viewport Units container properties in a cookie
            setCookie();


            // Save all changed settings to the cookie as they occur
            function saveSetting(e) {

                switch (e.id) {
                    case 'ovu_margin_bottom':
                        setCookie();
                        break;
                    case 'ovu_settings_background_color' :
                        setCookie();
                        break;
                    case 'ovu_settings_text_color' :
                        setCookie();
                        break;
                    case 'ovu_settings_top_border_color' :
                        setCookie();
                        break;
                    case 'ovu_settings_bottom_border_color' :
                        setCookie();
                        break;
                    default: // no code block
                }

            }

        });//$(document).ready

    });//jQuery(function ($)
}
catch(err){
    alert("While updating localStorage" + "\r\n"
        + "there was an unrecoverable jQuery error:" + "\r\n"
        + err.message);
}

/**
 * Write the cookie
 */

try {
    // Write the ovuColorPickerCookie containing margin and color picker values
    function setCookie() {
    'use strict';

        // Cookies can only have one name=value pair so multiple name=value pairs are stored in the cookie as a JSON string
        // Initialize a custom object to store the multiple name=value pairs that will be stringified by JSON
        var customObject = {};
        customObject.cookieName = "ovuColorPickerCookie";
        customObject.bottomMargin = localStorage.getItem("ovu_marginBottomKey");
        customObject.backgroundColor = localStorage.getItem("ovu_backgroundColorKey");
        customObject.textColor = localStorage.getItem("ovu_textColorKey");
        customObject.topBorderColor = localStorage.getItem("ovu_topBorderColorKey");
        customObject.bottomBorderColor = localStorage.getItem("ovu_bottomBorderColorKey");

        // Assign the stringified multiple name=value pairs
        var jsonString = JSON.stringify(customObject);

        // Set the expiration using the cookieExpiresDate() function
        // coded to work around the Year 2038 cookie expiration date bug.
        var cookieExpires = "expires=" + cookieExpiresDate();

        // Write the cookie
        document.cookie = "ovuColorPickerCookie=" + jsonString +";"+ cookieExpires + ";path=/";
    }

    // The cookieExpiresDate() function generates an expiration date for a cookie that can work around
    // the Year 2038 bug. Any expiration date beyond 03:14:07 UTC on Tuesday, 19 January 2038 will
    // wrap around to a date and time in the year 1900 causing the cookie to expire and disappear.
    //
    // Typically, persistent cookies would and could live for a maximum of ten years. However, any
    // code intended to be published for public use that uses cookies to maintain state must now be
    // coded with cookie expiration values that will enable the code to remain stable for as long
    // as the code may be found on the WWW.
    //
    // This particular work-around resets the year of expiration one year into the future each time
    // a typical setCookie() function calls cookieExpiresDate() as the cookie is written or updated.
    function cookieExpiresDate() {
    'use strict';
        var d = new Date();
        var n = d.getFullYear() + 1;
        d.setFullYear(n);
        // Format: Thu Dec 21 2017 22:03:55 GMT-0600 (Central Standard Time)
        return d;
    }

}
catch(err){
    alert("When attempting to write setCookie()" + "\r\n"
        + "there was an unrecoverable Javascript error:"  + "\r\n"
        +  err.message);
}


