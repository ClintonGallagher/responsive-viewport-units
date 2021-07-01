<?php

/**
 * * Responsive ViewPort Units generates and displays a browser's viewport unit values when a page is loaded and 
 * * regenerates the unit values each time the browser is resized horizontally or vertically.
 * * 
 * * The source code was developed as a WordPress plugin but can be reused in any HTML file by those with the 
 * * technical skills to do so using <script> blocks. 
 * *
 * *
 * * CREATED v1:    December 17, 2017
 * * UPDATED v2:    June 21, 2021 added support for css vw and vh units
 * * AUTHOR:        Clinton Gallagher https://clintongallagher.com
 * * DEPENDENCIES:  => All Browswers must enable JavaScript.
 * *                => The WordPress theme must use <?php wp_footer(); ?>.
 * *                => WordPress settings must require browsers enabled to use localStorage and cookies.
 * *                => A 3rd party color picker calls jQuery functions only available in WordPress configuration settings however 
 * *                  the source code has default settings that will enable the use of Viewport Units if jQuery has been disabled. 
 * *
 * * LICENSE:      GNU AGPLv3 https://www.gnu.org/licenses/agpl-3.0.en.html  
 * *                          https://choosealicense.com/licenses/agpl-3.0/
 * *
 * * COPYRIGHT:     COPYRIGHT 2017, 2021 CLINTON GALLAGHER. ALL RIGHTS RESERVED
 * *
 * * KNOWN ISSUES:  This code is error and bug free and runs flawlessly in any browser with JavaScript enabled however page builders 
 * * and hosting service provider caching may cause the script to freeze or not even display. Clearing all cache and refreshing has been the only 
 * * workaround that may or may not work for you when software such as page builders or hosting services interfere with loading and running JavaScript.
 * */


/**
 * Get the Viewport Units container properties written into a client-side cookie
 * within js/ovu-app.js so the data can be used by server-side PHP.
 */
if (isset($_COOKIE["ovuColorPickerCookie"]) and strlen($_COOKIE["ovuColorPickerCookie"]) > 1) {

    // Deserialize data serialized as JSON stored in the cookie which enables cookies
    // to contain multiple key=value pairs as needed to store all of the ViewPort Units.
    $ovuCookieArray = json_decode($_COOKIE["ovuColorPickerCookie"], true);

    // Globally scoped variables assigned values from each key in the cookie
    $backgroundColor   = $ovuCookieArray["backgroundColor"];
    $topBorderColor    = $ovuCookieArray["topBorderColor"];
    $textColor         = $ovuCookieArray["textColor"];
    $bottomBorderColor = $ovuCookieArray["bottomBorderColor"];
    if ($ovuCookieArray["bottomMargin"] === "0") {
        $bottomMargin  = $ovuCookieArray["bottomMargin"];
    } else {
        $bottomMargin  = $ovuCookieArray["bottomMargin"] . "px";
    }
}

/* VIEWPORT UNITS  License GNU AGPLv3 COPYRIGHT 2017, 2021 CLINTON GALLAGHER. ALL RIGHTS RESERVED.
* License Synopsis: https://choosealicense.com/licenses/agpl-3.0/
* License Home: https://www.gnu.org/licenses/agpl-3.0.en.html

* I developed ViewPort Units to enable me to know the size of a browser's viewport when laying out web pages.
* 
* This script was written as a plugin for WordPress. The WordPress Settings menu is where ViewPort Units can
* be configured by those who may need to modify the default settings. The source code can be copied as raw text
* when viewing source and pasted into any HTML file when not using WordPress; reconfiguring settings is not
* supported when copying the raw source code that can then be pasted into a <script> block used by any HTML page.
* The raw source code can also be copied from the viewport-units-script-block.php file.*
* 
* Generated viewport units are displayed adjacent to the bottom of the viewport in all browsers that
* support javascript.  
  */
if (!function_exists('write_ovu_script_block_into_footer')) {

    function write_ovu_script_block_into_footer()
    {
?>
        <script>
            //*** Generated Pattern of Output: XXXpx[ XX.XXXrem | X.Xvw ]W  x  XXXpx[ XX.XXXrem | X.Xvw ]H
            onload = function() {

                // Assign $GLOBALS here for readability
                var backgroundColor = "<?php echo $GLOBALS['backgroundColor']; ?>";
                var topBorderColor = "<?php echo $GLOBALS['topBorderColor']; ?>";
                var textColor = "<?php echo $GLOBALS['textColor']; ?>";
                var bottomBorderColor = "<?php echo $GLOBALS['bottomBorderColor']; ?>";
                var bottomMargin = "<?php echo $GLOBALS['bottomMargin'] ?>";


                //*** HTML element that contains the generated pattern
                var unitsContainer = document.createElement("div");

                //*** Styled HTML element properties
                unitsContainer.style.backgroundColor = backgroundColor;
                unitsContainer.style.borderBottom = "2px solid";
                unitsContainer.style.borderBottomColor = bottomBorderColor;
                unitsContainer.style.borderTop = "2px solid";
                unitsContainer.style.borderTopColor = topBorderColor;
                unitsContainer.style.bottom = bottomMargin;
                unitsContainer.style.color = textColor;
                unitsContainer.style.fontFamily = "sans-serif";
                unitsContainer.style.fontSize = "16px";
                unitsContainer.style.left = "0";
                unitsContainer.style.height = "auto";
				unitsContainer.style.marginLeft = 0;
				unitsContainer.style.marginRight = 0;
                unitsContainer.style.padding = "2px 0 2px 0";
                unitsContainer.style.position = "fixed";
                unitsContainer.style.textAlign = "center";
                unitsContainer.style.verticalAlign = "middle";
                unitsContainer.style.width = "100%";
                unitsContainer.style.whiteSpace = "nowrap";

                //*** CSS vw and vh Unit

                //*** pxWidthSpan element
                var pxWidthSpan = document.createElement("span");
                pxWidthSpan.id = "pxWidth";
                // append pxWidthSpan to the unitsContainer
                unitsContainer.appendChild(pxWidthSpan);
                // px unit width of viewport is written into the pxWidthSpan
                pxWidthSpan.textContent = window.innerWidth;

                //*** px width span suffix text
                var pxWidthSpanSuffixText = document.createElement("span");
                pxWidthSpanSuffixText.id = "pxWidthSpanSuffixText";
                pxWidthSpanSuffixText.textContent = "px [ ";
                unitsContainer.appendChild(pxWidthSpanSuffixText);

                //*** remWidthSpan element
                var remWidthSpan = document.createElement("span");
                remWidthSpan.id = "remWidth";
                unitsContainer.appendChild(remWidthSpan);
                // rem unit width of viewport is written into the remWidthSpan
                remWidthSpan.textContent = round(window.innerWidth / 16, 2);

                //*** rem width span suffix text
                var remWidthSpanSuffixText = document.createElement("span");
                remWidthSpanSuffixText.id = "remWidthSpanSuffixText";

                //*** use an x to delineate the groups of unit values
                var unitsDelineator = document.createElement("span");
                unitsDelineator.textContent = "x";
                unitsDelineator.style.marginLeft = "12px";
                unitsDelineator.style.marginRight = "12px";

                //*****************************
                // end of rem width suffix text
                remWidthSpanSuffixText.textContent = "rem | ";

                // append the rem width span suffix text
                unitsContainer.appendChild(remWidthSpanSuffixText);

                //*** vwWidthSpan element
                var vwWidthSpan = document.createElement("span");
                vwWidthSpan.id = "vwWidth";
                // append vwWidth to the unitsContainer
                unitsContainer.appendChild(vwWidthSpan);
                // vw unit width of viewport		
                vwWidthSpan.textContent = round(window.innerWidth * .01, 2) + "vw ]W";

                // append the unitsDelineator
                vwWidthSpan.appendChild(unitsDelineator);

                //*** pxHeightSpan element
                var pxHeightSpan = document.createElement("span");
                pxHeightSpan.id = "pxHeight";
                // append pxHeightSpan to the unitsContainer
                unitsContainer.appendChild(pxHeightSpan);
                // px unit height of viewport is written into the pxHeightSpan
                pxHeightSpan.textContent = window.innerHeight;

                //*** px height span suffix text
                var pxHeightSpanSuffixText = document.createElement("span");
                pxHeightSpanSuffixText.id = "pxHeightSpanSuffixText";
                pxHeightSpanSuffixText.textContent = "px [ ";
                unitsContainer.appendChild(pxHeightSpanSuffixText);

                //*** remHeightSpan element
                var remHeightSpan = document.createElement("span");
                remHeightSpan.id = "remHeight";
                // append remHeight span to the unitsContainer
                unitsContainer.appendChild(remHeightSpan);
                // rem unit width of viewport is written into the remWidthSpan
                remHeightSpan.textContent = round(window.innerHeight / 16, 2);

                //*** rem height span suffix text
                var remHeightSpanSuffixText = document.createElement("span");
                remHeightSpanSuffixText.id = "remHeightSpanSuffixText";
                remHeightSpanSuffixText.textContent = "rem | ";
                unitsContainer.appendChild(remHeightSpanSuffixText);

                //*** vhHeight element
                var vhHeightSpan = document.createElement("span");
                vhHeightSpan.id = "vhHeight";
                // append vhHeight span to the unitsContainer
                unitsContainer.appendChild(vhHeightSpan);
                // vh unit width of viewport		
                vhHeightSpan.textContent = round(window.innerHeight * .01, 2) + "vh ]H";

                //***
                //*** finally append the unitsContainer to the DOM...
                //***
                document.body.appendChild(unitsContainer);

                //***
                //*** function dependencies...
                //***

                //*** generate viewport units when browser is resized
                function resize() {
                    // px size of viewport width
                    pxWidthSpan.textContent = window.innerWidth;
                    // rem size of viewport width				
                    remWidthSpan.textContent = round(window.innerWidth / 16, 2);
                    // vw size of viewport width			
                    vwWidthSpan.textContent = round(window.innerWidth * .01, 2) + "vw ]W";
                    vwWidthSpan.appendChild(unitsDelineator);

                    // px size of viewport height
                    pxHeightSpan.textContent = window.innerHeight;
                    // rem size of viewport height
                    remHeightSpan.textContent = round(window.innerHeight / 16, 2);
                    // vh size of viewport height
                    vhHeightSpan.textContent = round(window.innerHeight * .01, 2) + "vh ]H";
                }

                //*** regenerate the viewport units
                window.onresize = resize;

                //*** round floating point values; accepts decimals = 0
                function round(value, decimals) {
                    return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals);
                }

                //*** resize font-size readabilit6y when width of browser is smaller than typical generated output
                var x = window.matchMedia("(max-width: 500px)")
                x.addListener(changeBGColor) // Attach listener function on state changes
                changeBGColor(x) // Call listener function at run time

                //*** change background color and font size so viewport units remain readable on very small viewports 
                function changeBGColor(x) {
                    if (x.matches) { // If media query matches

                        unitsContainer.style.fontSize = "9px";

                        //alert("bgColor: " + backgroundColor);

                        switch (backgroundColor) {

                            case "#000000":
                                unitsContainer.style.color = "#FFFFFF";
                                unitsContainer.style.fontWeight = "bold";
                                break;
                            case "#FFFFFF":
                                unitsContainer.style.color = "#000000";
                                unitsContainer.style.fontWeight = "bold";
                                break;
                            case "#FD5308":
                                unitsContainer.style.color = "#000000";
                                unitsContainer.style.fontWeight = "bold";
                                break;
                            case "#FB9902":
                                unitsContainer.style.color = "#000000";
                                unitsContainer.style.fontWeight = "bold";
                                break;
                            case "#FABC02":
                                unitsContainer.style.color = "#000000";
                                unitsContainer.style.fontWeight = "bold";
                                break;
                            case "#FEFE33":
                                unitsContainer.style.color = "#000000";
                                unitsContainer.style.fontWeight = "bold";
                                break;
                            case "#D0EA2B":
                                unitsContainer.style.color = "#000000";
                                unitsContainer.style.fontWeight = "bold";
                                break;
                            case "#66B032":
                                unitsContainer.style.color = "#000000";
                                unitsContainer.style.fontWeight = "bold";
                                break;
                            case "#0591CE":
                                unitsContainer.style.color = "#FFFFFF";
                                unitsContainer.style.fontWeight = "bold";
                                break;
                            case "#0247FE":
                                unitsContainer.style.color = "#FFFFFF";
                                unitsContainer.style.fontWeight = "bold";
                                break;
                            case "#3D01A4":
                                unitsContainer.style.color = "#FFFFFF";
                                unitsContainer.style.fontWeight = "bold";
                                break;
                            case "#8601AF":
                                unitsContainer.style.color = "#FFFFFF";
                                unitsContainer.style.fontWeight = "bold";
                                break;
                            case "#A7194B":
                                unitsContainer.style.color = "#FFFFFF";
                                unitsContainer.style.fontWeight = "bold";
                                break;
                            case "#FE2712":
                                unitsContainer.style.color = "#FFFFFF";
                                unitsContainer.style.fontWeight = "bold";
                                break;
                        }
                    } else {
                        unitsContainer.style.fontSize = "16px";
                        unitsContainer.style.color = textColor;
                    }
                }
            };
        </script>
<?php
    }
} //if ( !function_exists

// Write the <script> block into the footer of the page
add_action('wp_footer', 'write_ovu_script_block_into_footer');
