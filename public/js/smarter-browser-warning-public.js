(function ($) {
  'use strict';

  var smarterBrowserWarning = {
    init: function () {
      if (this.showModal() && this.outdated()) {
        this.getModal();
      }
    },
    outdated: function () {

      var outdated = false;

      var ie = this.detectIE();

      if (false !== ie && ie < sbw_globals.ie_support) {
        outdated = true;
      }

      return outdated;
    },
    showModal: function () {
      return (!$.cookie('sbw_browser_support_warning'));
    },
    getModal: function () {

      $.ajax({
        type: "POST",
        url: sbw_globals.ajaxurl,
        data: {
          action: "sbw_get_browser_support_modal",
          nonce: sbw_globals.nonce
        },
        success: function (response) {
          $('html').addClass('sbw-overflow-hidden');

          $('body').append(response);

          $(".sbw-remind-later").on("click", function (e) {
            e.preventDefault();

            $.cookie('sbw_browser_support_warning', 'later', {expires: 1});

            $(".sbw-browser-support-modal").remove();
            $('html').removeClass('sbw-overflow-hidden');
          });

          $(".sbw-no-reminder").on("click", function (e) {
            e.preventDefault();

            $.cookie('sbw_browser_support_warning', 'permanent');

            $(".sbw-browser-support-modal").remove();
            $('html').removeClass('sbw-overflow-hidden');
          });
        }
      });
    },
    // http://stackoverflow.com/a/21712356/2043492
    detectIE: function () {

      var ua = window.navigator.userAgent;

      // IE 10 or older => return version number
      var msie = ua.indexOf('MSIE ');
      if (msie > 0) {
        return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
      }

      // IE 11 => return version number
      var trident = ua.indexOf('Trident/');
      if (trident > 0) {
        var rv = ua.indexOf('rv:');
        return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
      }

      // Edge (IE 12+) => return version number
      var edge = ua.indexOf('Edge/');
      if (edge > 0) {
        return parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
      }

      // If not IE
      return false;
    }
  };

  $(function () {
    smarterBrowserWarning.init();
  });

})(jQuery);
