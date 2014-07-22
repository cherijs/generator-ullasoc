/* jshint undef: false, unused: false, -W020 */
/* global Gumby,jQuery */


//------------------------  SOC SHARE FUNCTIONS

function Dr(link) {
    'use strict';
    var titlePrefix = encodeURIComponent(SHARE_TXT);
    window.open('http://www.draugiem.lv/say/ext/add.php?title=' + encodeURIComponent(TITLE) + '&link=' + encodeURIComponent(link) + (titlePrefix ? '&titlePrefix=' + titlePrefix : ''), '', 'location=1,status=1,scrollbars=0,resizable=0,width=530,height=400');
    return false;
}

function Fb(link) {
    'use strict';
    var width = 575,
        height = 400,
        left = ($(window).width() - width) / 2,
        top = ($(window).height() - height) / 2,
        url = 'http://www.facebook.com/sharer.php?s=100&p[title]=' + encodeURIComponent(TITLE) + '&p[url]=' + link + '&p[images[]=' + SERVER_URL + 'images/facebook.png';
    var opts = 'status=1' + ',width=' + width + ',height=' + height + ',top=' + top + ',left=' + left;
    window.open(url, 'facebook', opts);
}

function Tw(link) {
    'use strict';
    var width = 575,
        height = 400,
        left = ($(window).width() - width) / 2,
        top = ($(window).height() - height) / 2,
        url = 'http://twitter.com/share?url=' + link + '&text=' + encodeURIComponent(SHARE_TXT);
    var opts = 'status=1' + ',width=' + width + ',height=' + height + ',top=' + top + ',left=' + left;
    window.open(url, 'twitter', opts);
}
//------------------------  SOC SHARE FUNCTIONS END
//---
//---
//---
//---
//---
//---
//---
//---
//---
//---





(function($, window, document, undefined) {
    'use strict';


    //------------------------  CONSOLE FIX
    // Avoid `console` errors in browsers that lack a console.
    if (!console) {
        console = {
            log: function() {

            }
        };
    }
    //------------------------  CONSOLE END

    $(function() {
        // JQUERY READY, MY FUNCTIONS HERE
        console.log('Ulla boilerplate ready!!!');

        if (!Modernizr.csstransitions || !Modernizr.cssanimations) {
            $('#warning').addClass('active');
        }


    });



})(jQuery, this, this.document);