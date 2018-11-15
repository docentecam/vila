/*!
 * jQuery hashchange event - v1.3 - 7/21/2010
 * http://benalman.com/projects/jquery-hashchange-plugin/
 * 
 * Copyright (c) 2010 "Cowboy" Ben Alman
 * Dual licensed under the MIT and GPL licenses.
 * http://benalman.com/about/license/
 */

// Script: jQuery hashchange event
//
// *Version: 1.3, Last updated: 7/21/2010*
// 
// Project Home - http://benalman.com/projects/jquery-hashchange-plugin/
// GitHub       - http://github.com/cowboy/jquery-hashchange/
// Source       - http://github.com/cowboy/jquery-hashchange/raw/master/jquery.ba-hashchange.js
// (Minified)   - http://github.com/cowboy/jquery-hashchange/raw/master/jquery.ba-hashchange.min.js (0.8kb gzipped)
// 
// About: License
// 
// Copyright (c) 2010 "Cowboy" Ben Alman,
// Dual licensed under the MIT and GPL licenses.
// http://benalman.com/about/license/
// 
// About: Examples
// 
// These working examples, complete with fully commented code, illustrate a few
// ways in which this plugin can be used.
// 
// hashchange event - http://benalman.com/code/projects/jquery-hashchange/examples/hashchange/
// document.domain - http://benalman.com/code/projects/jquery-hashchange/examples/document_domain/
// 
// About: Support and Testing
// 
// Information about what version or versions of jQuery this plugin has been
// tested with, what browsers it has been tested in, and where the unit tests
// reside (so you can test it yourself).
// 
// jQuery Versions - 1.2.6, 1.3.2, 1.4.1, 1.4.2
// Browsers Tested - Internet Explorer 6-8, Firefox 2-4, Chrome 5-6, Safari 3.2-5,
//                   Opera 9.6-10.60, iPhone 3.1, Android 1.6-2.2, BlackBerry 4.6-5.
// Unit Tests      - http://benalman.com/code/projects/jquery-hashchange/unit/
// 
// About: Known issues
// 
// While this jQuery hashchange event implementation is quite stable and
// robust, there are a few unfortunate browser bugs surrounding expected
// hashchange event-based behaviors, independent of any JavaScript
// window.onhashchange abstraction. See the following examples for more
// information:
// 
// Chrome: Back Button - http://benalman.com/code/projects/jquery-hashchange/examples/bug-chrome-back-button/
// Firefox: Remote XMLHttpRequest - http://benalman.com/code/projects/jquery-hashchange/examples/bug-firefox-remote-xhr/
// WebKit: Back Button in an Iframe - http://benalman.com/code/projects/jquery-hashchange/examples/bug-webkit-hash-iframe/
// Safari: Back Button from a different domain - http://benalman.com/code/projects/jquery-hashchange/examples/bug-safari-back-from-diff-domain/
// 
// Also note that should a browser natively support the window.onhashchange 
// event, but not report that it does, the fallback polling loop will be used.
// 
// About: Release History
// 
// 1.3   - (7/21/2010) Reorganized IE6/7 Iframe code to make it more
//         "removable" for mobile-only development. Added IE6/7 document.title
//         support. Attempted to make Iframe as hidden as possible by using
//         techniques from http://www.paciellogroup.com/blog/?p=604. Added 
//         support for the "shortcut" format $(window).hashchange( fn ) and
//         $(window).hashchange() like jQuery provides for built-in events.
//         Renamed jQuery.hashchangeDelay to <jQuery.fn.hashchange.delay> and
//         lowered its default value to 50. Added <jQuery.fn.hashchange.domain>
//         and <jQuery.fn.hashchange.src> properties plus document-domain.html
//         file to address access denied issues when setting document.domain in
//         IE6/7.
// 1.2   - (2/11/2010) Fixed a bug where coming back to a page using this plugin
//         from a page on another domain would cause an error in Safari 4. Also,
//         IE6/7 Iframe is now inserted after the body (this actually works),
//         which prevents the page from scrolling when the event is first bound.
//         Event can also now be bound before DOM ready, but it won't be usable
//         before then in IE6/7.
// 1.1   - (1/21/2010) Incorporated document.documentMode test to fix IE8 bug
//         where browser version is incorrectly reported as 8.0, despite
//         inclusion of the X-UA-Compatible IE=EmulateIE7 meta tag.
// 1.0   - (1/9/2010) Initial Release. Broke out the jQuery BBQ event.special
//         window.onhashchange functionality into a separate plugin for users
//         who want just the basic event & back button support, without all the
//         extra awesomeness that BBQ provides. This plugin will be included as
//         part of jQuery BBQ, but also be available separately.

(function($,window,undefined){
  '$:nomunge'; // Used by YUI compressor.
  
  // Reused string.
  var str_hashchange = 'hashchange',
    
    // Method / object references.
    doc = document,
    fake_onhashchange,
    special = $.event.special,
    
    // Does the browser support window.onhashchange? Note that IE8 running in
    // IE7 compatibility mode reports true for 'onhashchange' in window, even
    // though the event isn't supported, so also test document.documentMode.
    doc_mode = doc.documentMode,
    supports_onhashchange = 'on' + str_hashchange in window && ( doc_mode === undefined || doc_mode > 7 );
  
  // Get location.hash (or what you'd expect location.hash to be) sans any
  // leading #. Thanks for making this necessary, Firefox!
  function get_fragment( url ) {
    url = url || location.href;
    return '#' + url.replace( /^[^#]*#?(.*)$/, '$1' );
  };
  
  // Method: jQuery.fn.hashchange
  // 
  // Bind a handler to the window.onhashchange event or trigger all bound
  // window.onhashchange event handlers. This behavior is consistent with
  // jQuery's built-in event handlers.
  // 
  // Usage:
  // 
  // > jQuery(window).hashchange( [ handler ] );
  // 
  // Arguments:
  // 
  //  handler - (Function) Optional handler to be bound to the hashchange
  //    event. This is a "shortcut" for the more verbose form:
  //    jQuery(window).bind( 'hashchange', handler ). If handler is omitted,
  //    all bound window.onhashchange event handlers will be triggered. This
  //    is a shortcut for the more verbose
  //    jQuery(window).trigger( 'hashchange' ). These forms are described in
  //    the <hashchange event> section.
  // 
  // Returns:
  // 
  //  (jQuery) The initial jQuery collection of elements.
  
  // Allow the "shortcut" format $(elem).hashchange( fn ) for binding and
  // $(elem).hashchange() for triggering, like jQuery does for built-in events.
  $.fn[ str_hashchange ] = function( fn ) {
    return fn ? this.bind( str_hashchange, fn ) : this.trigger( str_hashchange );
  };
  
  // Property: jQuery.fn.hashchange.delay
  // 
  // The numeric interval (in milliseconds) at which the <hashchange event>
  // polling loop executes. Defaults to 50.
  
  // Property: jQuery.fn.hashchange.domain
  // 
  // If you're setting document.domain in your JavaScript, and you want hash
  // history to work in IE6/7, not only must this property be set, but you must
  // also set document.domain BEFORE jQuery is loaded into the page. This
  // property is only applicable if you are supporting IE6/7 (or IE8 operating
  // in "IE7 compatibility" mode).
  // 
  // In addition, the <jQuery.fn.hashchange.src> property must be set to the
  // path of the included "document-domain.html" file, which can be renamed or
  // modified if necessary (note that the document.domain specified must be the
  // same in both your main JavaScript as well as in this file).
  // 
  // Usage:
  // 
  // jQuery.fn.hashchange.domain = document.domain;
  
  // Property: jQuery.fn.hashchange.src
  // 
  // If, for some reason, you need to specify an Iframe src file (for example,
  // when setting document.domain as in <jQuery.fn.hashchange.domain>), you can
  // do so using this property. Note that when using this property, history
  // won't be recorded in IE6/7 until the Iframe src file loads. This property
  // is only applicable if you are supporting IE6/7 (or IE8 operating in "IE7
  // compatibility" mode).
  // 
  // Usage:
  // 
  // jQuery.fn.hashchange.src = 'path/to/file.html';
  
  $.fn[ str_hashchange ].delay = 50;
  /*
  $.fn[ str_hashchange ].domain = null;
  $.fn[ str_hashchange ].src = null;
  */
  
  // Event: hashchange event
  // 
  // Fired when location.hash changes. In browsers that support it, the native
  // HTML5 window.onhashchange event is used, otherwise a polling loop is
  // initialized, running every <jQuery.fn.hashchange.delay> milliseconds to
  // see if the hash has changed. In IE6/7 (and IE8 operating in "IE7
  // compatibility" mode), a hidden Iframe is created to allow the back button
  // and hash-based history to work.
  // 
  // Usage as described in <jQuery.fn.hashchange>:
  // 
  // > // Bind an event handler.
  // > jQuery(window).hashchange( function(e) {
  // >   var hash = location.hash;
  // >   ...
  // > });
  // > 
  // > // Manually trigger the event handler.
  // > jQuery(window).hashchange();
  // 
  // A more verbose usage that allows for event namespacing:
  // 
  // > // Bind an event handler.
  // > jQuery(window).bind( 'hashchange', function(e) {
  // >   var hash = location.hash;
  // >   ...
  // > });
  // > 
  // > // Manually trigger the event handler.
  // > jQuery(window).trigger( 'hashchange' );
  // 
  // Additional Notes:
  // 
  // * The polling loop and Iframe are not created until at least one handler
  //   is actually bound to the 'hashchange' event.
  // * If you need the bound handler(s) to execute immediately, in cases where
  //   a location.hash exists on page load, via bookmark or page refresh for
  //   example, use jQuery(window).hashchange() or the more verbose 
  //   jQuery(window).trigger( 'hashchange' ).
  // * The event can be bound before DOM ready, but since it won't be usable
  //   before then in IE6/7 (due to the necessary Iframe), recommended usage is
  //   to bind it inside a DOM ready handler.
  
  // Override existing $.event.special.hashchange methods (allowing this plugin
  // to be defined after jQuery BBQ in BBQ's source code).
  special[ str_hashchange ] = $.extend( special[ str_hashchange ], {
    
    // Called only when the first 'hashchange' event is bound to window.
    setup: function() {
      // If window.onhashchange is supported natively, there's nothing to do..
      if ( supports_onhashchange ) { return false; }
      
      // Otherwise, we need to create our own. And we don't want to call this
      // until the user binds to the event, just in case they never do, since it
      // will create a polling loop and possibly even a hidden Iframe.
      $( fake_onhashchange.start );
    },
    
    // Called only when the last 'hashchange' event is unbound from window.
    teardown: function() {
      // If window.onhashchange is supported natively, there's nothing to do..
      if ( supports_onhashchange ) { return false; }
      
      // Otherwise, we need to stop ours (if possible).
      $( fake_onhashchange.stop );
    }
    
  });
  
  // fake_onhashchange does all the work of triggering the window.onhashchange
  // event for browsers that don't natively support it, including creating a
  // polling loop to watch for hash changes and in IE 6/7 creating a hidden
  // Iframe to enable back and forward.
  fake_onhashchange = (function(){
    var self = {},
      timeout_id,
      
      // Remember the initial hash so it doesn't get triggered immediately.
      last_hash = get_fragment(),
      
      fn_retval = function(val){ return val; },
      history_set = fn_retval,
      history_get = fn_retval;
    
    // Start the polling loop.
    self.start = function() {
      timeout_id || poll();
    };
    
    // Stop the polling loop.
    self.stop = function() {
      timeout_id && clearTimeout( timeout_id );
      timeout_id = undefined;
    };
    
    // This polling loop checks every $.fn.hashchange.delay milliseconds to see
    // if location.hash has changed, and triggers the 'hashchange' event on
    // window when necessary.
    function poll() {
      var hash = get_fragment(),
        history_hash = history_get( last_hash );
      
      if ( hash !== last_hash ) {
        history_set( last_hash = hash, history_hash );
        
        $(window).trigger( str_hashchange );
        
      } else if ( history_hash !== last_hash ) {
        location.href = location.href.replace( /#.*/, '' ) + history_hash;
      }
      
      timeout_id = setTimeout( poll, $.fn[ str_hashchange ].delay );
    };
    
    // vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv
    // vvvvvvvvvvvvvvvvvvv REMOVE IF NOT SUPPORTING IE6/7/8 vvvvvvvvvvvvvvvvvvv
    // vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv
    (window.navigator.userAgent.indexOf("MSIE ") > -1 || !!window.navigator.userAgent.match(/Trident.*rv\:11\./)) && !supports_onhashchange && (function(){
      // Not only do IE6/7 need the "magical" Iframe treatment, but so does IE8
      // when running in "IE7 compatibility" mode.
      
      var iframe,
        iframe_src;
      
      // When the event is bound and polling starts in IE 6/7, create a hidden
      // Iframe for history handling.
      self.start = function(){
        if ( !iframe ) {
          iframe_src = $.fn[ str_hashchange ].src;
          iframe_src = iframe_src && iframe_src + get_fragment();
          
          // Create hidden Iframe. Attempt to make Iframe as hidden as possible
          // by using techniques from http://www.paciellogroup.com/blog/?p=604.
          iframe = $('<iframe tabindex="-1" title="empty"/>').hide()
            
            // When Iframe has completely loaded, initialize the history and
            // start polling.
            .one( 'load', function(){
              iframe_src || history_set( get_fragment() );
              poll();
            })
            
            // Load Iframe src if specified, otherwise nothing.
            .attr( 'src', iframe_src || 'javascript:0' )
            
            // Append Iframe after the end of the body to prevent unnecessary
            // initial page scrolling (yes, this works).
            .insertAfter( 'body' )[0].contentWindow;
          
          // Whenever `document.title` changes, update the Iframe's title to
          // prettify the back/next history menu entries. Since IE sometimes
          // errors with "Unspecified error" the very first time this is set
          // (yes, very useful) wrap this with a try/catch block.
          doc.onpropertychange = function(){
            try {
              if ( event.propertyName === 'title' ) {
                iframe.document.title = doc.title;
              }
            } catch(e) {}
          };
          
        }
      };
      
      // Override the "stop" method since an IE6/7 Iframe was created. Even
      // if there are no longer any bound event handlers, the polling loop
      // is still necessary for back/next to work at all!
      self.stop = fn_retval;
      
      // Get history by looking at the hidden Iframe's location.hash.
      history_get = function() {
        return get_fragment( iframe.location.href );
      };
      
      // Set a new history item by opening and then closing the Iframe
      // document, *then* setting its location.hash. If document.domain has
      // been set, update that as well.
      history_set = function( hash, history_hash ) {
        var iframe_doc = iframe.document,
          domain = $.fn[ str_hashchange ].domain;
        
        if ( hash !== history_hash ) {
          // Update Iframe with any initial `document.title` that might be set.
          iframe_doc.title = doc.title;
          
          // Opening the Iframe's document after it has been closed is what
          // actually adds a history entry.
          iframe_doc.open();
          
          // Set document.domain for the Iframe document as well, if necessary.
          domain && iframe_doc.write( '<script>document.domain="' + domain + '"</script>' );
          
          iframe_doc.close();
          
          // Update the Iframe's hash, for great justice.
          iframe.location.hash = hash;
        }
      };
      
    })();
    // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    // ^^^^^^^^^^^^^^^^^^^ REMOVE IF NOT SUPPORTING IE6/7/8 ^^^^^^^^^^^^^^^^^^^
    // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    
    return self;
  })();
  
})(jQuery,this);
;

/**
 * Debounce and throttle function's decorator plugin 1.0.5
 *
 * Copyright (c) 2009 Filatov Dmitry (alpha@zforms.ru)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 */

(function($) {

$.extend({

	debounce : function(fn, timeout, invokeAsap, ctx) {

		if(arguments.length == 3 && typeof invokeAsap != 'boolean') {
			ctx = invokeAsap;
			invokeAsap = false;
		}

		var timer;

		return function() {

			var args = arguments;
            ctx = ctx || this;

			invokeAsap && !timer && fn.apply(ctx, args);

			clearTimeout(timer);

			timer = setTimeout(function() {
				!invokeAsap && fn.apply(ctx, args);
				timer = null;
			}, timeout);

		};

	},

	throttle : function(fn, timeout, ctx) {

		var timer, args, needInvoke;

		return function() {

			args = arguments;
			needInvoke = true;
			ctx = ctx || this;

			if(!timer) {
				(function() {
					if(needInvoke) {
						fn.apply(ctx, args);
						needInvoke = false;
						timer = setTimeout(arguments.callee, timeout);
					}
					else {
						timer = null;
					}
				})();
			}

		};

	}

});

})(jQuery);;

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Handles the resizing of a menu according to the available screen width
 *
 * Uses themes/original/css/resizable-menu.css.php
 *
 * To initialise:
 * $('#myMenu').menuResizer(function () {
 *     // This function will be called to find out how much
 *     // available horizontal space there is for the menu
 *     return $('body').width() - 5; // Some extra margin for good measure
 * });
 *
 * To trigger a resize operation:
 * $('#myMenu').menuResizer('resize'); // Bind this to $(window).resize()
 *
 * To restore the menu to a state like before it was initialized:
 * $('#myMenu').menuResizer('destroy');
 *
 * @package PhpMyAdmin
 */
(function ($) {
    function MenuResizer($container, widthCalculator) {
        var self = this;
        self.$container = $container;
        self.widthCalculator = widthCalculator;
        // create submenu container
        var link = $('<a />', {href: '#', 'class': 'tab nowrap'})
            .text(PMA_messages.strMore)
            .bind('click', false); // same as event.preventDefault()
        var img = $container.find('li img');
        if (img.length) {
            $(PMA_getImage('b_more.png').toString()).prependTo(link);
        }
        var $submenu = $('<li />', {'class': 'submenu'})
            .append(link)
            .append($('<ul />'))
            .mouseenter(function() {
                if ($(this).find('ul .tabactive').length === 0) {
                    $(this)
                    .addClass('submenuhover')
                    .find('> a')
                    .addClass('tabactive');
                }
            })
            .mouseleave(function() {
                if ($(this).find('ul .tabactive').length === 0) {
                    $(this)
                    .removeClass('submenuhover')
                    .find('> a')
                    .removeClass('tabactive');
                }
            });
        $container.children('.clearfloat').remove();
        $container.append($submenu).append("<div class='clearfloat'></div>");
        setTimeout(function () {
            self.resize();
        }, 4);
    }
    MenuResizer.prototype.resize = function () {
        var wmax = this.widthCalculator.call(this.$container);
        var $submenu = this.$container.find('.submenu:last');
        var submenu_w = $submenu.outerWidth(true);
        var $submenu_ul = $submenu.find('ul');
        var $li = this.$container.find('> li');
        var $li2 = $submenu_ul.find('li');
        var more_shown = $li2.length > 0;
        // Calculate the total width used by all the shown tabs
        var total_len = more_shown ? submenu_w : 0;
        var l = $li.length - 1;
        var i;
        for (i = 0; i < l; i++) {
            total_len += $($li[i]).outerWidth(true);
        }
        // Now hide menu elements that don't fit into the menubar
        var hidden = false; // Whether we have hidden any tabs
        while (total_len >= wmax && --l >= 0) { // Process the tabs backwards
            hidden = true;
            var el = $($li[l]);
            var el_width = el.outerWidth(true);
            el.data('width', el_width);
            if (! more_shown) {
                total_len -= el_width;
                el.prependTo($submenu_ul);
                total_len += submenu_w;
                more_shown = true;
            } else {
                total_len -= el_width;
                el.prependTo($submenu_ul);
            }
        }
        // If we didn't hide any tabs, then there might be some space to show some
        if (! hidden) {
            // Show menu elements that do fit into the menubar
            for (i = 0, l = $li2.length; i < l; i++) {
                total_len += $($li2[i]).data('width');
                // item fits or (it is the last item
                // and it would fit if More got removed)
                if (total_len < wmax ||
                    (i == $li2.length - 1 && total_len - submenu_w < wmax)
                ) {
                    $($li2[i]).insertBefore($submenu);
                } else {
                    break;
                }
            }
        }
        // Show/hide the "More" tab as needed
        if ($submenu_ul.find('li').length > 0) {
            $submenu.addClass('shown');
        } else {
            $submenu.removeClass('shown');
        }
        if (this.$container.find('> li').length == 1) {
            // If there is only the "More" tab left, then we need
            // to align the submenu to the left edge of the tab
            $submenu_ul.removeClass().addClass('only');
        } else {
            // Otherwise we align the submenu to the right edge of the tab
            $submenu_ul.removeClass().addClass('notonly');
        }
        if ($submenu.find('.tabactive').length) {
            $submenu
            .addClass('active')
            .find('> a')
            .removeClass('tab')
            .addClass('tabactive');
        } else {
            $submenu
            .removeClass('active')
            .find('> a')
            .addClass('tab')
            .removeClass('tabactive');
        }
    };
    MenuResizer.prototype.destroy = function () {
        var $submenu = this.$container.find('li.submenu').removeData();
        $submenu.find('li').appendTo(this.$container);
        $submenu.remove();
    };

    /** Public API */
    var methods = {
        init: function(widthCalculator) {
            return this.each(function () {
                var $this = $(this);
                if (! $this.data('menuResizer')) {
                    $this.data(
                        'menuResizer',
                        new MenuResizer($this, widthCalculator)
                    );
                }
            });
        },
        resize: function () {
            return this.each(function () {
                var self = $(this).data('menuResizer');
                if (self) {
                    self.resize();
                }
            });
        },
        destroy: function () {
            return this.each(function () {
                var self = $(this).data('menuResizer');
                if (self) {
                    self.destroy();
                }
            });
        }
    };

    /** Extend jQuery */
    $.fn.menuResizer = function(method) {
        if (methods[method]) {
            return methods[method].call(this);
        } else if (typeof method === 'function') {
            return methods.init.apply(this, [method]);
        } else {
            $.error('Method ' +  method + ' does not exist on jQuery.menuResizer');
        }
    };
})(jQuery);
;

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Conditionally included if framing is not allowed
 */
if (self == top) {
    var style_element = document.getElementById("cfs-style");
    // check if style_element has already been removed
    // to avoid frequently reported js error
    if (typeof(style_element) != 'undefined' && style_element != null) {
        style_element.parentNode.removeChild(style_element);
    }
} else {
    top.location = self.location;
}
;

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * JavaScript functionality for Routines, Triggers and Events.
 *
 * @package PhpMyadmin
 */
/**
 * @var RTE Contains all the JavaScript functionality
 *          for Routines, Triggers and Events
 */
var RTE = {
    /**
     * Construct for the object that provides the
     * functionality for Routines, Triggers and Events
     */
    object: function (type) {
        $.extend(this, RTE.COMMON);
        this.editorType = type;

        switch (type) {
        case 'routine':
            $.extend(this, RTE.ROUTINE);
            break;
        case 'trigger':
            // nothing extra yet for triggers
            break;
        case 'event':
            $.extend(this, RTE.EVENT);
            break;
        default:
            break;
        }
    },
    /**
     * @var string param_template Template for a row in the routine editor
     */
    param_template: ''
};

/**
 * @var RTE.COMMON a JavaScript namespace containing the functionality
 *                 for Routines, Triggers and Events
 *
 *                 This namespace is extended by the functionality required
 *                 to handle a specific item (a routine, trigger or event)
 *                 in the relevant javascript files in this folder
 */
RTE.COMMON = {
    /**
     * @var $ajaxDialog Query object containing the reference to the
     *                  dialog that contains the editor
     */
    $ajaxDialog: null,
    /**
     * @var syntaxHiglighter Reference to the codemirror editor
     */
    syntaxHiglighter: null,
    /**
     * @var buttonOptions Object containing options for
     *                    the jQueryUI dialog buttons
     */
    buttonOptions: {},
    /**
     * @var editorType Type of the editor
     */
    editorType: null,
    /**
     * Validate editor form fields.
     */
    validate: function () {
        /**
         * @var $elm a jQuery object containing the reference
         *           to an element that is being validated
         */
        var $elm = null;
        // Common validation. At the very least the name
        // and the definition must be provided for an item
        $elm = $('table.rte_table').last().find('input[name=item_name]');
        if ($elm.val() === '') {
            $elm.focus();
            alert(PMA_messages.strFormEmpty);
            return false;
        }
        $elm = $('table.rte_table').find('textarea[name=item_definition]');
        if ($elm.val() === '') {
            if (this.syntaxHiglighter !== null) {
                this.syntaxHiglighter.focus();
            }
            else {
                $('textarea[name=item_definition]').last().focus();
            }
            alert(PMA_messages.strFormEmpty);
            return false;
        }
        // The validation has so far passed, so now
        // we can validate item-specific fields.
        return this.validateCustom();
    }, // end validate()
    /**
     * Validate custom editor form fields.
     * This function can be overridden by
     * other files in this folder
     */
    validateCustom: function () {
        return true;
    }, // end validateCustom()
    /**
     * Execute some code after the ajax
     * dialog for the editor is shown.
     * This function can be overridden by
     * other files in this folder
     */
    postDialogShow: function () {
        // Nothing by default
    }, // end postDialogShow()

    exportDialog: function ($this) {
        var $msg = PMA_ajaxShowMessage();
        if ($this.hasClass('mult_submit')) {
            var combined = {
                success: true,
                title: PMA_messages.strExport,
                message: '',
                error: ''
            };
            // export anchors of all selected rows
            var export_anchors = $('input.checkall:checked').parents('tr').find('.export_anchor');
            var count = export_anchors.length;
            var returnCount = 0;

            // No routine is exportable (due to privilege issues)
            if (count === 0) {
                PMA_ajaxShowMessage(PMA_messages.NoExportable);
            }

            export_anchors.each(function () {
                $.get($(this).attr('href'), {'ajax_request': true}, function (data) {
                    returnCount++;
                    if (data.success === true) {
                        combined.message += "\n" + data.message + "\n";
                        if (returnCount == count) {
                            showExport(combined);
                        }
                    } else {
                        // complain even if one export is failing
                        combined.success = false;
                        combined.error += "\n" + data.error + "\n";
                        if (returnCount == count) {
                            showExport(combined);
                        }
                    }
                });
            });
        } else {
            $.get($this.attr('href'), {'ajax_request': true}, showExport);
        }
        PMA_ajaxRemoveMessage($msg);

        function showExport(data) {
            if (data.success === true) {
                PMA_ajaxRemoveMessage($msg);
                /**
                 * @var button_options Object containing options
                 *                     for jQueryUI dialog buttons
                 */
                var button_options = {};
                button_options[PMA_messages.strClose] = function () {
                    $(this).dialog("close").remove();
                };
                /**
                 * Display the dialog to the user
                 */
                data.message = '<textarea cols="40" rows="15" style="width: 100%;">' + data.message + '</textarea>';
                var $ajaxDialog = $('<div>' + data.message + '</div>').dialog({
                    width: 500,
                    buttons: button_options,
                    title: data.title
                });
                // Attach syntax highlighted editor to export dialog
                /**
                 * @var $elm jQuery object containing the reference
                 *           to the Export textarea.
                 */
                var $elm = $ajaxDialog.find('textarea');
                PMA_getSQLEditor($elm);
            } else {
                PMA_ajaxShowMessage(data.error, false);
            }
        } // end showExport()
    },  // end exportDialog()
    editorDialog: function (is_new, $this) {
        var that = this;
        /**
         * @var $edit_row jQuery object containing the reference to
         *                the row of the the item being edited
         *                from the list of items
         */
        var $edit_row = null;
        if ($this.hasClass('edit_anchor')) {
            // Remeber the row of the item being edited for later,
            // so that if the edit is successful, we can replace the
            // row with info about the modified item.
            $edit_row = $this.parents('tr');
        }
        /**
         * @var $msg jQuery object containing the reference to
         *           the AJAX message shown to the user
         */
        var $msg = PMA_ajaxShowMessage();
        $.get($this.attr('href'), {'ajax_request': true}, function (data) {
            if (data.success === true) {
                // We have successfully fetched the editor form
                PMA_ajaxRemoveMessage($msg);
                // Now define the function that is called when
                // the user presses the "Go" button
                that.buttonOptions[PMA_messages.strGo] = function () {
                    // Move the data from the codemirror editor back to the
                    // textarea, where it can be used in the form submission.
                    if (typeof CodeMirror != 'undefined') {
                        that.syntaxHiglighter.save();
                    }
                    // Validate editor and submit request, if passed.
                    if (that.validate()) {
                        /**
                         * @var data Form data to be sent in the AJAX request
                         */
                        var data = $('form.rte_form').last().serialize();
                        $msg = PMA_ajaxShowMessage(
                            PMA_messages.strProcessingRequest
                        );
                        var url = $('form.rte_form').last().attr('action');
                        $.post(url, data, function (data) {
                            if (data.success === true) {
                                // Item created successfully
                                PMA_ajaxRemoveMessage($msg);
                                PMA_slidingMessage(data.message);
                                that.$ajaxDialog.dialog('close');
                                // If we are in 'edit' mode, we must
                                // remove the reference to the old row.
                                if (mode === 'edit' && $edit_row !== null ) {
                                    $edit_row.remove();
                                }
                                // Sometimes, like when moving a trigger from
                                // a table to another one, the new row should
                                // not be inserted into the list. In this case
                                // "data.insert" will be set to false.
                                if (data.insert) {
                                    // Insert the new row at the correct
                                    // location in the list of items
                                    /**
                                     * @var text Contains the name of an item from
                                     *           the list that is used in comparisons
                                     *           to find the correct location where
                                     *           to insert a new row.
                                     */
                                    var text = '';
                                    /**
                                     * @var inserted Whether a new item has been
                                     *               inserted in the list or not
                                     */
                                    var inserted = false;
                                    $('table.data').find('tr').each(function () {
                                        text = $(this)
                                                .children('td')
                                                .eq(0)
                                                .find('strong')
                                                .text()
                                                .toUpperCase();
                                        text = $.trim(text);
                                        if (text !== '' && text > data.name) {
                                            $(this).before(data.new_row);
                                            inserted = true;
                                            return false;
                                        }
                                    });
                                    if (! inserted) {
                                        // If we didn't manage to insert the row yet,
                                        // it must belong at the end of the list,
                                        // so we insert it there.
                                        $('table.data').append(data.new_row);
                                    }
                                    // Fade-in the new row
                                    $('tr.ajaxInsert')
                                        .show('slow')
                                        .removeClass('ajaxInsert');
                                } else if ($('table.data').find('tr').has('td').length === 0) {
                                    // If we are not supposed to insert the new row,
                                    // we will now check if the table is empty and
                                    // needs to be hidden. This will be the case if
                                    // we were editing the only item in the list,
                                    // which we removed and will not be inserting
                                    // something else in its place.
                                    $('table.data').hide("slow", function () {
                                        $('#nothing2display').show("slow");
                                    });
                                }
                                // Now we have inserted the row at the correct
                                // position, but surely at least some row classes
                                // are wrong now. So we will itirate throught
                                // all rows and assign correct classes to them
                                /**
                                 * @var ct Count of processed rows
                                 */
                                var ct = 0;
                                /**
                                 * @var rowclass Class to be attached to the row
                                 *               that is being processed
                                 */
                                var rowclass = '';
                                $('table.data').find('tr').has('td').each(function () {
                                    rowclass = (ct % 2 === 0) ? 'odd' : 'even';
                                    $(this).removeClass().addClass(rowclass);
                                    ct++;
                                });
                                // If this is the first item being added, remove
                                // the "No items" message and show the list.
                                if ($('table.data').find('tr').has('td').length > 0 &&
                                    $('#nothing2display').is(':visible')
                                    ) {
                                    $('#nothing2display').hide("slow", function () {
                                        $('table.data').show("slow");
                                    });
                                }
                                PMA_reloadNavigation();
                            } else {
                                PMA_ajaxShowMessage(data.error, false);
                            }
                        }); // end $.post()
                    } // end "if (that.validate())"
                }; // end of function that handles the submission of the Editor
                that.buttonOptions[PMA_messages.strClose] = function () {
                    $(this).dialog("close");
                };
                /**
                 * Display the dialog to the user
                 */
                that.$ajaxDialog = $('<div id="rteDialog">' + data.message + '</div>').dialog({
                    width: 700,
                    minWidth: 500,
                    maxHeight: $(window).height(),
                    buttons: that.buttonOptions,
                    title: data.title,
                    modal: true,
                    open: function () {
                        if ($('#rteDialog').parents('.ui-dialog').height() > $(window).height()) {
                            $('#rteDialog').dialog("option", "height", $(window).height());
                        }
                        $(this).find('input[name=item_name]').focus();
                        $(this).find('input.datefield').each(function () {
                            PMA_addDatepicker($(this).css('width', '95%'), 'date');
                        });
                        $(this).find('input.datetimefield').each(function () {
                            PMA_addDatepicker($(this).css('width', '95%'), 'datetime');
                        });
                        $.datepicker.initialized = false;
                    },
                    close: function () {
                        $(this).remove();
                    }
                });
                /**
                 * @var mode Used to remeber whether the editor is in
                 *           "Edit" or "Add" mode
                 */
                var mode = 'add';
                if ($('input[name=editor_process_edit]').length > 0) {
                    mode = 'edit';
                }
                // Attach syntax highlighted editor to the definition
                /**
                 * @var elm jQuery object containing the reference to
                 *                 the Definition textarea.
                 */
                var $elm = $('textarea[name=item_definition]').last();
                var linterOptions = {};
                linterOptions[that.editorType + '_editor'] = true;
                that.syntaxHiglighter = PMA_getSQLEditor($elm, {}, null, linterOptions);

                // Execute item-specific code
                that.postDialogShow(data);
            } else {
                PMA_ajaxShowMessage(data.error, false);
            }
        }); // end $.get()
    },

    dropDialog: function ($this) {
        /**
         * @var $curr_row Object containing reference to the current row
         */
        var $curr_row = $this.parents('tr');
        /**
         * @var question String containing the question to be asked for confirmation
         */
        var question = $('<div/>').text(
            $curr_row.children('td').children('.drop_sql').html()
        );
        // We ask for confirmation first here, before submitting the ajax request
        $this.PMA_confirm(question, $this.attr('href'), function (url) {
            /**
             * @var msg jQuery object containing the reference to
             *          the AJAX message shown to the user
             */
            var $msg = PMA_ajaxShowMessage(PMA_messages.strProcessingRequest);
            var params = {
                'is_js_confirmed': 1,
                'ajax_request': true,
                'token': PMA_commonParams.get('token')
            };
            $.post(url, params, function (data) {
                if (data.success === true) {
                    /**
                     * @var $table Object containing reference
                     *             to the main list of elements
                     */
                    var $table = $curr_row.parent();
                    // Check how many rows will be left after we remove
                    // the one that the user has requested us to remove
                    if ($table.find('tr').length === 3) {
                        // If there are two rows left, it means that they are
                        // the header of the table and the rows that we are
                        // about to remove, so after the removal there will be
                        // nothing to show in the table, so we hide it.
                        $table.hide("slow", function () {
                            $(this).find('tr.even, tr.odd').remove();
                            $('.withSelected').remove();
                            $('#nothing2display').show("slow");
                        });
                    } else {
                        $curr_row.hide("slow", function () {
                            $(this).remove();
                            // Now we have removed the row from the list, but maybe
                            // some row classes are wrong now. So we will itirate
                            // throught all rows and assign correct classes to them.
                            /**
                             * @var ct Count of processed rows
                             */
                            var ct = 0;
                            /**
                             * @var rowclass Class to be attached to the row
                             *               that is being processed
                             */
                            var rowclass = '';
                            $table.find('tr').has('td').each(function () {
                                rowclass = (ct % 2 === 1) ? 'odd' : 'even';
                                $(this).removeClass().addClass(rowclass);
                                ct++;
                            });
                        });
                    }
                    // Get rid of the "Loading" message
                    PMA_ajaxRemoveMessage($msg);
                    // Show the query that we just executed
                    PMA_slidingMessage(data.sql_query);
                    PMA_reloadNavigation();
                } else {
                    PMA_ajaxShowMessage(data.error, false);
                }
            }); // end $.post()
        }); // end $.PMA_confirm()
    },

    dropMultipleDialog: function ($this) {
        // We ask for confirmation here
        $this.PMA_confirm(PMA_messages.strDropRTEitems, '', function (url) {
            /**
             * @var msg jQuery object containing the reference to
             *          the AJAX message shown to the user
             */
            var $msg = PMA_ajaxShowMessage(PMA_messages.strProcessingRequest);

            // drop anchors of all selected rows
            var drop_anchors = $('input.checkall:checked').parents('tr').find('.drop_anchor');
            var success = true;
            var count = drop_anchors.length;
            var returnCount = 0;

            drop_anchors.each(function () {
                var $anchor = $(this);
                /**
                 * @var $curr_row Object containing reference to the current row
                 */
                var $curr_row = $anchor.parents('tr');
                var params = {
                    'is_js_confirmed': 1,
                    'ajax_request': true,
                    'token': PMA_commonParams.get('token')
                };
                $.post($anchor.attr('href'), params, function (data) {
                    returnCount++;
                    if (data.success === true) {
                        /**
                         * @var $table Object containing reference
                         *             to the main list of elements
                         */
                        var $table = $curr_row.parent();
                        // Check how many rows will be left after we remove
                        // the one that the user has requested us to remove
                        if ($table.find('tr').length === 3) {
                            // If there are two rows left, it means that they are
                            // the header of the table and the rows that we are
                            // about to remove, so after the removal there will be
                            // nothing to show in the table, so we hide it.
                            $table.hide("slow", function () {
                                $(this).find('tr.even, tr.odd').remove();
                                $('.withSelected').remove();
                                $('#nothing2display').show("slow");
                            });
                        } else {
                            $curr_row.hide("fast", function () {
                                $(this).remove();
                                // Now we have removed the row from the list, but maybe
                                // some row classes are wrong now. So we will itirate
                                // throught all rows and assign correct classes to them.
                                /**
                                 * @var ct Count of processed rows
                                 */
                                var ct = 0;
                                /**
                                 * @var rowclass Class to be attached to the row
                                 *               that is being processed
                                 */
                                var rowclass = '';
                                $table.find('tr').has('td').each(function () {
                                    rowclass = (ct % 2 === 1) ? 'odd' : 'even';
                                    $(this).removeClass().addClass(rowclass);
                                    ct++;
                                });
                            });
                        }
                        if (returnCount == count) {
                            if (success) {
                                // Get rid of the "Loading" message
                                PMA_ajaxRemoveMessage($msg);
                                $('#rteListForm_checkall').prop({checked: false, indeterminate: false});
                            }
                            PMA_reloadNavigation();
                        }
                    } else {
                        PMA_ajaxShowMessage(data.error, false);
                        success = false;
                        if (returnCount == count) {
                            PMA_reloadNavigation();
                        }
                    }
                }); // end $.post()
            }); // end drop_anchors.each()
        }); // end $.PMA_confirm()
    }
}; // end RTE namespace

/**
 * @var RTE.EVENT JavaScript functionality for events
 */
RTE.EVENT = {
    validateCustom: function () {
        /**
         * @var elm a jQuery object containing the reference
         *          to an element that is being validated
         */
        var $elm = null;
        if (this.$ajaxDialog.find('select[name=item_type]').find(':selected').val() === 'RECURRING') {
            // The interval field must not be empty for recurring events
            $elm = this.$ajaxDialog.find('input[name=item_interval_value]');
            if ($elm.val() === '') {
                $elm.focus();
                alert(PMA_messages.strFormEmpty);
                return false;
            }
        } else {
            // The execute_at field must not be empty for "once off" events
            $elm = this.$ajaxDialog.find('input[name=item_execute_at]');
            if ($elm.val() === '') {
                $elm.focus();
                alert(PMA_messages.strFormEmpty);
                return false;
            }
        }
        return true;
    }
};

/**
 * @var RTE.ROUTINE JavaScript functionality for routines
 */
RTE.ROUTINE = {
    /**
     * Overriding the postDialogShow() function defined in common.js
     *
     * @param data JSON-encoded data from the ajax request
     */
    postDialogShow: function (data) {
        // Cache the template for a parameter table row
        RTE.param_template = data.param_template;
        var that = this;
        // Make adjustments in the dialog to make it AJAX compatible
        $('td.routine_param_remove').show();
        $('input[name=routine_removeparameter]').remove();
        $('input[name=routine_addparameter]').css('width', '100%');
        // Enable/disable the 'options' dropdowns for parameters as necessary
        $('table.routine_params_table').last().find('th[colspan=2]').attr('colspan', '1');
        $('table.routine_params_table').last().find('tr').has('td').each(function () {
            that.setOptionsForParameter(
                $(this).find('select[name^=item_param_type]'),
                $(this).find('input[name^=item_param_length]'),
                $(this).find('select[name^=item_param_opts_text]'),
                $(this).find('select[name^=item_param_opts_num]')
            );
        });
        // Enable/disable the 'options' dropdowns for
        // function return value as necessary
        this.setOptionsForParameter(
            $('table.rte_table').last().find('select[name=item_returntype]'),
            $('table.rte_table').last().find('input[name=item_returnlength]'),
            $('table.rte_table').last().find('select[name=item_returnopts_text]'),
            $('table.rte_table').last().find('select[name=item_returnopts_num]')
        );
        // Allow changing parameter order
        $('.routine_params_table tbody').sortable({
            containment: '.routine_params_table tbody',
            handle: '.dragHandle',
            stop: function(event, ui) {
                that.reindexParameters();
            },
        });
    },
    /**
     * Reindexes the parameters after dropping a parameter or reordering parameters
     */
    reindexParameters: function () {
        /**
         * @var index Counter used for reindexing the input
         *            fields in the routine parameters table
         */
        var index = 0;
        $('table.routine_params_table tbody').find('tr').each(function () {
            $(this).find(':input').each(function () {
                /**
                 * @var inputname The value of the name attribute of
                 *                the input field being reindexed
                 */
                var inputname = $(this).attr('name');
                if (inputname.substr(0, 14) === 'item_param_dir') {
                    $(this).attr('name', inputname.substr(0, 14) + '[' + index + ']');
                } else if (inputname.substr(0, 15) === 'item_param_name') {
                    $(this).attr('name', inputname.substr(0, 15) + '[' + index + ']');
                } else if (inputname.substr(0, 15) === 'item_param_type') {
                    $(this).attr('name', inputname.substr(0, 15) + '[' + index + ']');
                } else if (inputname.substr(0, 17) === 'item_param_length') {
                    $(this).attr('name', inputname.substr(0, 17) + '[' + index + ']');
                    $(this).attr('id', 'item_param_length_' + index);
                } else if (inputname.substr(0, 20) === 'item_param_opts_text') {
                    $(this).attr('name', inputname.substr(0, 20) + '[' + index + ']');
                } else if (inputname.substr(0, 19) === 'item_param_opts_num') {
                    $(this).attr('name', inputname.substr(0, 19) + '[' + index + ']');
                }
            });
            index++;
        });
    },
    /**
     * Overriding the validateCustom() function defined in common.js
     */
    validateCustom: function () {
        /**
         * @var isSuccess Stores the outcome of the validation
         */
        var isSuccess = true;
        /**
         * @var inputname The value of the "name" attribute for
         *                the field that is being processed
         */
        var inputname = '';
        this.$ajaxDialog.find('table.routine_params_table').last().find('tr').each(function () {
            // Every parameter of a routine must have
            // a non-empty direction, name and type
            if (isSuccess) {
                $(this).find(':input').each(function () {
                    inputname = $(this).attr('name');
                    if (inputname.substr(0, 14) === 'item_param_dir' ||
                        inputname.substr(0, 15) === 'item_param_name' ||
                        inputname.substr(0, 15) === 'item_param_type') {
                        if ($(this).val() === '') {
                            $(this).focus();
                            isSuccess = false;
                            return false;
                        }
                    }
                });
            } else {
                return false;
            }
        });
        if (! isSuccess) {
            alert(PMA_messages.strFormEmpty);
            return false;
        }
        this.$ajaxDialog.find('table.routine_params_table').last().find('tr').each(function () {
            // SET, ENUM, VARCHAR and VARBINARY fields must have length/values
            var $inputtyp = $(this).find('select[name^=item_param_type]');
            var $inputlen = $(this).find('input[name^=item_param_length]');
            if ($inputtyp.length && $inputlen.length) {
                if (($inputtyp.val() === 'ENUM' || $inputtyp.val() === 'SET' || $inputtyp.val().substr(0, 3) === 'VAR') &&
                    $inputlen.val() === ''
                   ) {
                    $inputlen.focus();
                    isSuccess = false;
                    return false;
                }
            }
        });
        if (! isSuccess) {
            alert(PMA_messages.strFormEmpty);
            return false;
        }
        if (this.$ajaxDialog.find('select[name=item_type]').find(':selected').val() === 'FUNCTION') {
            // The length/values of return variable for functions must
            // be set, if the type is SET, ENUM, VARCHAR or VARBINARY.
            var $returntyp = this.$ajaxDialog.find('select[name=item_returntype]');
            var $returnlen = this.$ajaxDialog.find('input[name=item_returnlength]');
            if (($returntyp.val() === 'ENUM' || $returntyp.val() === 'SET' || $returntyp.val().substr(0, 3) === 'VAR') &&
                $returnlen.val() === ''
                ) {
                $returnlen.focus();
                alert(PMA_messages.strFormEmpty);
                return false;
            }
        }
        if ($('select[name=item_type]').find(':selected').val() === 'FUNCTION') {
            // A function must contain a RETURN statement in its definition
            if (this.$ajaxDialog.find('table.rte_table').find('textarea[name=item_definition]').val().toUpperCase().indexOf('RETURN') < 0) {
                this.syntaxHiglighter.focus();
                alert(PMA_messages.MissingReturn);
                return false;
            }
        }
        return true;
    },
    /**
     * Enable/disable the "options" dropdown and "length" input for
     * parameters and the return variable in the routine editor
     * as necessary.
     *
     * @param type a jQuery object containing the reference
     *             to the "Type" dropdown box
     * @param len  a jQuery object containing the reference
     *             to the "Length" input box
     * @param text a jQuery object containing the reference
     *             to the dropdown box with options for
     *             parameters of text type
     * @param num  a jQuery object containing the reference
     *             to the dropdown box with options for
     *             parameters of numeric type
     */
    setOptionsForParameter: function ($type, $len, $text, $num) {
        /**
         * @var no_opts a jQuery object containing the reference
         *              to an element to be displayed when no
         *              options are available
         */
        var $no_opts = $text.parent().parent().find('.no_opts');
        /**
         * @var no_len a jQuery object containing the reference
         *             to an element to be displayed when no
         *             "length/values" field is available
         */
        var $no_len  = $len.parent().parent().find('.no_len');

        // Process for parameter options
        switch ($type.val()) {
        case 'TINYINT':
        case 'SMALLINT':
        case 'MEDIUMINT':
        case 'INT':
        case 'BIGINT':
        case 'DECIMAL':
        case 'FLOAT':
        case 'DOUBLE':
        case 'REAL':
            $text.parent().hide();
            $num.parent().show();
            $no_opts.hide();
            break;
        case 'TINYTEXT':
        case 'TEXT':
        case 'MEDIUMTEXT':
        case 'LONGTEXT':
        case 'CHAR':
        case 'VARCHAR':
        case 'SET':
        case 'ENUM':
            $text.parent().show();
            $num.parent().hide();
            $no_opts.hide();
            break;
        default:
            $text.parent().hide();
            $num.parent().hide();
            $no_opts.show();
            break;
        }
        // Process for parameter length
        switch ($type.val()) {
        case 'DATE':
        case 'TINYBLOB':
        case 'TINYTEXT':
        case 'BLOB':
        case 'TEXT':
        case 'MEDIUMBLOB':
        case 'MEDIUMTEXT':
        case 'LONGBLOB':
        case 'LONGTEXT':
            $text.closest('tr').find('a:first').hide();
            $len.parent().hide();
            $no_len.show();
            break;
        default:
            if ($type.val() == 'ENUM' || $type.val() == 'SET') {
                $text.closest('tr').find('a:first').show();
            } else {
                $text.closest('tr').find('a:first').hide();
            }
            $len.parent().show();
            $no_len.hide();
            break;
        }
    },
    executeDialog: function ($this) {
        var that = this;
        /**
         * @var msg jQuery object containing the reference to
         *          the AJAX message shown to the user
         */
        var $msg = PMA_ajaxShowMessage();
        var params = {
            'ajax_request': true,
            'token': PMA_commonParams.get('token')
        };
        $.post($this.attr('href'), params, function (data) {
            if (data.success === true) {
                PMA_ajaxRemoveMessage($msg);
                // If 'data.dialog' is true we show a dialog with a form
                // to get the input parameters for routine, otherwise
                // we just show the results of the query
                if (data.dialog) {
                    // Define the function that is called when
                    // the user presses the "Go" button
                    that.buttonOptions[PMA_messages.strGo] = function () {
                        /**
                         * @var data Form data to be sent in the AJAX request
                         */
                        var data = $('form.rte_form').last().serialize();
                        $msg = PMA_ajaxShowMessage(
                            PMA_messages.strProcessingRequest
                        );
                        $.post('db_routines.php', data, function (data) {
                            if (data.success === true) {
                                // Routine executed successfully
                                PMA_ajaxRemoveMessage($msg);
                                PMA_slidingMessage(data.message);
                                $ajaxDialog.dialog('close');
                            } else {
                                PMA_ajaxShowMessage(data.error, false);
                            }
                        });
                    };
                    that.buttonOptions[PMA_messages.strClose] = function () {
                        $(this).dialog("close");
                    };
                    /**
                     * Display the dialog to the user
                     */
                    var $ajaxDialog = $('<div>' + data.message + '</div>').dialog({
                        width: 650,
                        buttons: that.buttonOptions,
                        title: data.title,
                        modal: true,
                        close: function () {
                            $(this).remove();
                        }
                    });
                    $ajaxDialog.find('input[name^=params]').first().focus();
                    /**
                     * Attach the datepickers to the relevant form fields
                     */
                    $ajaxDialog.find('input.datefield, input.datetimefield').each(function () {
                        PMA_addDatepicker($(this).css('width', '95%'));
                    });
                    /*
                    * Define the function if the user presses enter
                    */
                    $('form.rte_form').on('keyup', function (event) {
                        event.preventDefault();
                        if (event.keyCode === 13) {
                            /**
                            * @var data Form data to be sent in the AJAX request
                            */
                            var data = $(this).serialize();
                            $msg = PMA_ajaxShowMessage(
                                PMA_messages.strProcessingRequest
                            );
                            var url = $(this).attr('action');
                            $.post(url, data, function (data) {
                                if (data.success === true) {
                                    // Routine executed successfully
                                    PMA_ajaxRemoveMessage($msg);
                                    PMA_slidingMessage(data.message);
                                    $('form.rte_form').off('keyup');
                                    $ajaxDialog.remove();
                                } else {
                                    PMA_ajaxShowMessage(data.error, false);
                                }
                            });
                        }
                    });
                } else {
                    // Routine executed successfully
                    PMA_slidingMessage(data.message);
                }
            } else {
                PMA_ajaxShowMessage(data.error, false);
            }
        }); // end $.post()
    }
};

/**
 * Attach Ajax event handlers for the Routines, Triggers and Events editor
 */
$(function () {
    /**
     * Attach Ajax event handlers for the Add/Edit functionality.
     */
    $(document).on('click', 'a.ajax.add_anchor, a.ajax.edit_anchor', function (event) {
        event.preventDefault();
        var type = $(this).attr('href').substr(0, $(this).attr('href').indexOf('?'));
        if (type.indexOf('routine') != -1) {
            type = 'routine';
        } else if (type.indexOf('trigger') != -1) {
            type = 'trigger';
        } else if (type.indexOf('event') != -1) {
            type = 'event';
        } else {
            type = '';
        }
        var dialog = new RTE.object(type);
        dialog.editorDialog($(this).hasClass('add_anchor'), $(this));
    }); // end $(document).on()

    /**
     * Attach Ajax event handlers for the Execute routine functionality
     */
    $(document).on('click', 'a.ajax.exec_anchor', function (event) {
        event.preventDefault();
        var dialog = new RTE.object('routine');
        dialog.executeDialog($(this));
    }); // end $(document).on()

    /**
     * Attach Ajax event handlers for Export of Routines, Triggers and Events
     */
    $(document).on('click', 'a.ajax.export_anchor', function (event) {
        event.preventDefault();
        var dialog = new RTE.object();
        dialog.exportDialog($(this));
    }); // end $(document).on()

    $(document).on('click', '#rteListForm.ajax .mult_submit[value="export"]', function (event) {
        event.preventDefault();
        var dialog = new RTE.object();
        dialog.exportDialog($(this));
    }); // end $(document).on()

    /**
     * Attach Ajax event handlers for Drop functionality
     * of Routines, Triggers and Events.
     */
    $(document).on('click', 'a.ajax.drop_anchor', function (event) {
        event.preventDefault();
        var dialog = new RTE.object();
        dialog.dropDialog($(this));
    }); // end $(document).on()

    $(document).on('click', '#rteListForm.ajax .mult_submit[value="drop"]', function (event) {
        event.preventDefault();
        var dialog = new RTE.object();
        dialog.dropMultipleDialog($(this));
    }); // end $(document).on()

    /**
     * Attach Ajax event handlers for the "Change event/routine type"
     * functionality in the events editor, so that the correct
     * rows are shown in the editor when changing the event type
     */
    $(document).on('change', 'select[name=item_type]', function () {
        $(this)
        .closest('table')
        .find('tr.recurring_event_row, tr.onetime_event_row, tr.routine_return_row, .routine_direction_cell')
        .toggle();
    }); // end $(document).on()

    /**
     * Attach Ajax event handlers for the "Change parameter type"
     * functionality in the routines editor, so that the correct
     * option/length fields, if any, are shown when changing
     * a parameter type
     */
    $(document).on('change', 'select[name^=item_param_type]', function () {
        /**
         * @var row jQuery object containing the reference to
         *          a row in the routine parameters table
         */
        var $row = $(this).parents('tr').first();
        var rte = new RTE.object('routine');
        rte.setOptionsForParameter(
            $row.find('select[name^=item_param_type]'),
            $row.find('input[name^=item_param_length]'),
            $row.find('select[name^=item_param_opts_text]'),
            $row.find('select[name^=item_param_opts_num]')
        );
    }); // end $(document).on()

    /**
     * Attach Ajax event handlers for the "Change the type of return
     * variable of function" functionality, so that the correct fields,
     * if any, are shown when changing the function return type type
     */
    $(document).on('change', 'select[name=item_returntype]', function () {
        var rte = new RTE.object('routine');
        var $table = $(this).closest('table.rte_table');
        rte.setOptionsForParameter(
            $table.find('select[name=item_returntype]'),
            $table.find('input[name=item_returnlength]'),
            $table.find('select[name=item_returnopts_text]'),
            $table.find('select[name=item_returnopts_num]')
        );
    }); // end $(document).on()

    /**
     * Attach Ajax event handlers for the "Add parameter to routine" functionality
     */
    $(document).on('click', 'input[name=routine_addparameter]', function (event) {
        event.preventDefault();
        /**
         * @var routine_params_table jQuery object containing the reference
         *                           to the routine parameters table
         */
        var $routine_params_table = $(this).closest('div.ui-dialog').find('.routine_params_table');
        /**
         * @var new_param_row A string containing the HTML code for the
         *                    new row for the routine parameters table
         */
        var new_param_row = RTE.param_template.replace(/%s/g, $routine_params_table.find('tr').length - 1);
        // Append the new row to the parameters table
        $routine_params_table.append(new_param_row);
        // Make sure that the row is correctly shown according to the type of routine
        if ($(this).closest('div.ui-dialog').find('table.rte_table select[name=item_type]').val() === 'FUNCTION') {
            $('tr.routine_return_row').show();
            $('td.routine_direction_cell').hide();
        }
        /**
         * @var newrow jQuery object containing the reference to the newly
         *             inserted row in the routine parameters table
         */
        var $newrow = $(this).closest('div.ui-dialog').find('table.routine_params_table').find('tr').has('td').last();
        // Enable/disable the 'options' dropdowns for parameters as necessary
        var rte = new RTE.object('routine');
        rte.setOptionsForParameter(
            $newrow.find('select[name^=item_param_type]'),
            $newrow.find('input[name^=item_param_length]'),
            $newrow.find('select[name^=item_param_opts_text]'),
            $newrow.find('select[name^=item_param_opts_num]')
        );
    }); // end $(document).on()

    /**
     * Attach Ajax event handlers for the
     * "Remove parameter from routine" functionality
     */
    $(document).on('click', 'a.routine_param_remove_anchor', function (event) {
        event.preventDefault();
        $(this).parent().parent().remove();
        // After removing a parameter, the indices of the name attributes in
        // the input fields lose the correct order and need to be reordered.
        RTE.ROUTINE.reindexParameters();
    }); // end $(document).on()
}); // end of $()
;

/**
 * https://github.com/csnover/TraceKit
 * @license MIT
 * @namespace TraceKit
 */
(function(window, undefined) {
if (!window) {
    return;
}

var TraceKit = {};
var _oldTraceKit = window.TraceKit;

// global reference to slice
var _slice = [].slice;
var UNKNOWN_FUNCTION = '?';

/**
 * A better form of hasOwnProperty<br/>
 * Example: `_has(MainHostObject, property) === true/false`
 *
 * @param {Object} object to check property
 * @param {string} key to check
 * @return {Boolean} true if the object has the key and it is not inherited
 */
function _has(object, key) {
    return Object.prototype.hasOwnProperty.call(object, key);
}

/**
 * Returns true if the parameter is undefined<br/>
 * Example: `_isUndefined(val) === true/false`
 *
 * @param {*} what Value to check
 * @return {Boolean} true if undefined and false otherwise
 */
function _isUndefined(what) {
    return typeof what === 'undefined';
}

/**
 * Export TraceKit out to another variable<br/>
 * Example: `var TK = TraceKit.noConflict()`
 * @return {Object} The TraceKit object
 * @memberof TraceKit
 */
TraceKit.noConflict = function noConflict() {
    window.TraceKit = _oldTraceKit;
    return TraceKit;
};

/**
 * Wrap any function in a TraceKit reporter<br/>
 * Example: `func = TraceKit.wrap(func);`
 *
 * @param {Function} func Function to be wrapped
 * @return {Function} The wrapped func
 * @memberof TraceKit
 */
TraceKit.wrap = function traceKitWrapper(func) {
    function wrapped() {
        try {
            return func.apply(this, arguments);
        } catch (e) {
            TraceKit.report(e);
            throw e;
        }
    }
    return wrapped;
};

/**
 * Cross-browser processing of unhandled exceptions
 *
 * Syntax:
 * ```js
 *   TraceKit.report.subscribe(function(stackInfo) { ... })
 *   TraceKit.report.unsubscribe(function(stackInfo) { ... })
 *   TraceKit.report(exception)
 *   try { ...code... } catch(ex) { TraceKit.report(ex); }
 * ```
 *
 * Supports:
 *   - Firefox: full stack trace with line numbers, plus column number
 *     on top frame; column number is not guaranteed
 *   - Opera: full stack trace with line and column numbers
 *   - Chrome: full stack trace with line and column numbers
 *   - Safari: line and column number for the top frame only; some frames
 *     may be missing, and column number is not guaranteed
 *   - IE: line and column number for the top frame only; some frames
 *     may be missing, and column number is not guaranteed
 *
 * In theory, TraceKit should work on all of the following versions:
 *   - IE5.5+ (only 8.0 tested)
 *   - Firefox 0.9+ (only 3.5+ tested)
 *   - Opera 7+ (only 10.50 tested; versions 9 and earlier may require
 *     Exceptions Have Stacktrace to be enabled in opera:config)
 *   - Safari 3+ (only 4+ tested)
 *   - Chrome 1+ (only 5+ tested)
 *   - Konqueror 3.5+ (untested)
 *
 * Requires TraceKit.computeStackTrace.
 *
 * Tries to catch all unhandled exceptions and report them to the
 * subscribed handlers. Please note that TraceKit.report will rethrow the
 * exception. This is REQUIRED in order to get a useful stack trace in IE.
 * If the exception does not reach the top of the browser, you will only
 * get a stack trace from the point where TraceKit.report was called.
 *
 * Handlers receive a TraceKit.StackTrace object as described in the
 * TraceKit.computeStackTrace docs.
 *
 * @memberof TraceKit
 * @namespace
 */
TraceKit.report = (function reportModuleWrapper() {
    var handlers = [],
        lastArgs = null,
        lastException = null,
        lastExceptionStack = null;

    /**
     * Add a crash handler.
     * @param {Function} handler
     * @memberof TraceKit.report
     */
    function subscribe(handler) {
        installGlobalHandler();
        handlers.push(handler);
    }

    /**
     * Remove a crash handler.
     * @param {Function} handler
     * @memberof TraceKit.report
     */
    function unsubscribe(handler) {
        for (var i = handlers.length - 1; i >= 0; --i) {
            if (handlers[i] === handler) {
                handlers.splice(i, 1);
            }
        }
    }

    /**
     * Dispatch stack information to all handlers.
     * @param {TraceKit.StackTrace} stack
     * @param {boolean} isWindowError Is this a top-level window error?
     * @memberof TraceKit.report
     * @throws An exception if an error occurs while calling an handler.
     */
    function notifyHandlers(stack, isWindowError) {
        var exception = null;
        if (isWindowError && !TraceKit.collectWindowErrors) {
          return;
        }
        for (var i in handlers) {
            if (_has(handlers, i)) {
                try {
                    handlers[i].apply(null, [stack].concat(_slice.call(arguments, 2)));
                } catch (inner) {
                    exception = inner;
                }
            }
        }

        if (exception) {
            throw exception;
        }
    }

    var _oldOnerrorHandler, _onErrorHandlerInstalled;

    /**
     * Ensures all global unhandled exceptions are recorded.
     * Supported by Gecko and IE.
     * @param {string} message Error message.
     * @param {string} url URL of script that generated the exception.
     * @param {(number|string)} lineNo The line number at which the error occurred.
     * @param {(number|string)=} columnNo The column number at which the error occurred.
     * @param {Error=} errorObj The actual Error object.
     * @memberof TraceKit.report
     */
    function traceKitWindowOnError(message, url, lineNo, columnNo, errorObj) {
        var stack = null;

        if (lastExceptionStack) {
            TraceKit.computeStackTrace.augmentStackTraceWithInitialElement(lastExceptionStack, url, lineNo, message);
    	    processLastException();
	    } else if (errorObj) {
            stack = TraceKit.computeStackTrace(errorObj);
            notifyHandlers(stack, true);
        } else {
            var location = {
              'url': url,
              'line': lineNo,
              'column': columnNo
            };
            location.func = TraceKit.computeStackTrace.guessFunctionName(location.url, location.line);
            location.context = TraceKit.computeStackTrace.gatherContext(location.url, location.line);
            stack = {
              'mode': 'onerror',
              'message': message,
              'stack': [location]
            };

            notifyHandlers(stack, true);
        }

        if (_oldOnerrorHandler) {
            return _oldOnerrorHandler.apply(this, arguments);
        }

        return false;
    }

    /**
     * Install a global onerror handler
     * @memberof TraceKit.report
     */
    function installGlobalHandler () {
        if (_onErrorHandlerInstalled === true) {
            return;
        }
        _oldOnerrorHandler = window.onerror;
        window.onerror = traceKitWindowOnError;
        _onErrorHandlerInstalled = true;
    }

    /**
     * Process the most recent exception
     * @memberof TraceKit.report
     */
    function processLastException() {
        var _lastExceptionStack = lastExceptionStack,
            _lastArgs = lastArgs;
        lastArgs = null;
        lastExceptionStack = null;
        lastException = null;
        notifyHandlers.apply(null, [_lastExceptionStack, false].concat(_lastArgs));
    }

    /**
     * Reports an unhandled Error to TraceKit.
     * @param {Error} ex
     * @memberof TraceKit.report
     * @throws An exception if an incomplete stack trace is detected (old IE browsers).
     */
    function report(ex) {
        if (lastExceptionStack) {
            if (lastException === ex) {
                return; // already caught by an inner catch block, ignore
            } else {
              processLastException();
            }
        }

        var stack = TraceKit.computeStackTrace(ex);
        lastExceptionStack = stack;
        lastException = ex;
        lastArgs = _slice.call(arguments, 1);

        // If the stack trace is incomplete, wait for 2 seconds for
        // slow slow IE to see if onerror occurs or not before reporting
        // this exception; otherwise, we will end up with an incomplete
        // stack trace
        window.setTimeout(function () {
            if (lastException === ex) {
                processLastException();
            }
        }, (stack.incomplete ? 2000 : 0));

        throw ex; // re-throw to propagate to the top level (and cause window.onerror)
    }

    report.subscribe = subscribe;
    report.unsubscribe = unsubscribe;
    return report;
}());

/**
 * An object representing a single stack frame.
 * @typedef {Object} StackFrame
 * @property {string} url The JavaScript or HTML file URL.
 * @property {string} func The function name, or empty for anonymous functions (if guessing did not work).
 * @property {string[]?} args The arguments passed to the function, if known.
 * @property {number=} line The line number, if known.
 * @property {number=} column The column number, if known.
 * @property {string[]} context An array of source code lines; the middle element corresponds to the correct line#.
 * @memberof TraceKit
 */

/**
 * An object representing a JavaScript stack trace.
 * @typedef {Object} StackTrace
 * @property {string} name The name of the thrown exception.
 * @property {string} message The exception error message.
 * @property {TraceKit.StackFrame[]} stack An array of stack frames.
 * @property {string} mode 'stack', 'stacktrace', 'multiline', 'callers', 'onerror', or 'failed' -- method used to collect the stack trace.
 * @memberof TraceKit
 */

/**
 * TraceKit.computeStackTrace: cross-browser stack traces in JavaScript
 *
 * Syntax:
 *   ```js
 *   s = TraceKit.computeStackTrace.ofCaller([depth])
 *   s = TraceKit.computeStackTrace(exception) // consider using TraceKit.report instead (see below)
 *   ```
 *
 * Supports:
 *   - Firefox:  full stack trace with line numbers and unreliable column
 *               number on top frame
 *   - Opera 10: full stack trace with line and column numbers
 *   - Opera 9-: full stack trace with line numbers
 *   - Chrome:   full stack trace with line and column numbers
 *   - Safari:   line and column number for the topmost stacktrace element
 *               only
 *   - IE:       no line numbers whatsoever
 *
 * Tries to guess names of anonymous functions by looking for assignments
 * in the source code. In IE and Safari, we have to guess source file names
 * by searching for function bodies inside all page scripts. This will not
 * work for scripts that are loaded cross-domain.
 * Here be dragons: some function names may be guessed incorrectly, and
 * duplicate functions may be mismatched.
 *
 * TraceKit.computeStackTrace should only be used for tracing purposes.
 * Logging of unhandled exceptions should be done with TraceKit.report,
 * which builds on top of TraceKit.computeStackTrace and provides better
 * IE support by utilizing the window.onerror event to retrieve information
 * about the top of the stack.
 *
 * Note: In IE and Safari, no stack trace is recorded on the Error object,
 * so computeStackTrace instead walks its *own* chain of callers.
 * This means that:
 *  * in Safari, some methods may be missing from the stack trace;
 *  * in IE, the topmost function in the stack trace will always be the
 *    caller of computeStackTrace.
 *
 * This is okay for tracing (because you are likely to be calling
 * computeStackTrace from the function you want to be the topmost element
 * of the stack trace anyway), but not okay for logging unhandled
 * exceptions (because your catch block will likely be far away from the
 * inner function that actually caused the exception).
 *
 * Tracing example:
 *  ```js
 *     function trace(message) {
 *         var stackInfo = TraceKit.computeStackTrace.ofCaller();
 *         var data = message + "\n";
 *         for(var i in stackInfo.stack) {
 *             var item = stackInfo.stack[i];
 *             data += (item.func || '[anonymous]') + "() in " + item.url + ":" + (item.line || '0') + "\n";
 *         }
 *         if (window.console)
 *             console.info(data);
 *         else
 *             alert(data);
 *     }
 * ```
 * @memberof TraceKit
 * @namespace
 */
TraceKit.computeStackTrace = (function computeStackTraceWrapper() {
    var debug = false,
        sourceCache = {};

    /**
     * Attempts to retrieve source code via XMLHttpRequest, which is used
     * to look up anonymous function names.
     * @param {string} url URL of source code.
     * @return {string} Source contents.
     * @memberof TraceKit.computeStackTrace
     */
    function loadSource(url) {
        if (!TraceKit.remoteFetching) { //Only attempt request if remoteFetching is on.
            return '';
        }
        try {
            var getXHR = function() {
                try {
                    return new window.XMLHttpRequest();
                } catch (e) {
                    // explicitly bubble up the exception if not found
                    return new window.ActiveXObject('Microsoft.XMLHTTP');
                }
            };

            var request = getXHR();
            request.open('GET', url, false);
            request.send('');
            return request.responseText;
        } catch (e) {
            return '';
        }
    }

    /**
     * Retrieves source code from the source code cache.
     * @param {string} url URL of source code.
     * @return {Array.<string>} Source contents.
     * @memberof TraceKit.computeStackTrace
     */
    function getSource(url) {
        if (typeof url !== 'string') {
            return [];
        }

        if (!_has(sourceCache, url)) {
            // URL needs to be able to fetched within the acceptable domain.  Otherwise,
            // cross-domain errors will be triggered.
            /*
                Regex matches:
                0 - Full Url
                1 - Protocol
                2 - Domain
                3 - Port (Useful for internal applications)
                4 - Path
            */
            var source = '';
            var domain = '';
            try { domain = window.document.domain; } catch (e) { }
            var match = /(.*)\:\/\/([^:\/]+)([:\d]*)\/{0,1}([\s\S]*)/.exec(url);
            if (match && match[2] === domain) {
                source = loadSource(url);
            }
            sourceCache[url] = source ? source.split('\n') : [];
        }

        return sourceCache[url];
    }

    /**
     * Tries to use an externally loaded copy of source code to determine
     * the name of a function by looking at the name of the variable it was
     * assigned to, if any.
     * @param {string} url URL of source code.
     * @param {(string|number)} lineNo Line number in source code.
     * @return {string} The function name, if discoverable.
     * @memberof TraceKit.computeStackTrace
     */
    function guessFunctionName(url, lineNo) {
        var reFunctionArgNames = /function ([^(]*)\(([^)]*)\)/,
            reGuessFunction = /['"]?([0-9A-Za-z$_]+)['"]?\s*[:=]\s*(function|eval|new Function)/,
            line = '',
            maxLines = 10,
            source = getSource(url),
            m;

        if (!source.length) {
            return UNKNOWN_FUNCTION;
        }

        // Walk backwards from the first line in the function until we find the line which
        // matches the pattern above, which is the function definition
        for (var i = 0; i < maxLines; ++i) {
            line = source[lineNo - i] + line;

            if (!_isUndefined(line)) {
                if ((m = reGuessFunction.exec(line))) {
                    return m[1];
                } else if ((m = reFunctionArgNames.exec(line))) {
                    return m[1];
                }
            }
        }

        return UNKNOWN_FUNCTION;
    }

    /**
     * Retrieves the surrounding lines from where an exception occurred.
     * @param {string} url URL of source code.
     * @param {(string|number)} line Line number in source code to centre
     * around for context.
     * @return {?Array.<string>} Lines of source code.
     * @memberof TraceKit.computeStackTrace
     */
    function gatherContext(url, line) {
        var source = getSource(url);

        if (!source.length) {
            return null;
        }

        var context = [],
            // linesBefore & linesAfter are inclusive with the offending line.
            // if linesOfContext is even, there will be one extra line
            //   *before* the offending line.
            linesBefore = Math.floor(TraceKit.linesOfContext / 2),
            // Add one extra line if linesOfContext is odd
            linesAfter = linesBefore + (TraceKit.linesOfContext % 2),
            start = Math.max(0, line - linesBefore - 1),
            end = Math.min(source.length, line + linesAfter - 1);

        line -= 1; // convert to 0-based index

        for (var i = start; i < end; ++i) {
            if (!_isUndefined(source[i])) {
                context.push(source[i]);
            }
        }

        return context.length > 0 ? context : null;
    }

    /**
     * Escapes special characters, except for whitespace, in a string to be
     * used inside a regular expression as a string literal.
     * @param {string} text The string.
     * @return {string} The escaped string literal.
     * @memberof TraceKit.computeStackTrace
     */
    function escapeRegExp(text) {
        return text.replace(/[\-\[\]{}()*+?.,\\\^$|#]/g, '\\$&');
    }

    /**
     * Escapes special characters in a string to be used inside a regular
     * expression as a string literal. Also ensures that HTML entities will
     * be matched the same as their literal friends.
     * @param {string} body The string.
     * @return {string} The escaped string.
     * @memberof TraceKit.computeStackTrace
     */
    function escapeCodeAsRegExpForMatchingInsideHTML(body) {
        return escapeRegExp(body).replace('<', '(?:<|&lt;)').replace('>', '(?:>|&gt;)').replace('&', '(?:&|&amp;)').replace('"', '(?:"|&quot;)').replace(/\s+/g, '\\s+');
    }

    /**
     * Determines where a code fragment occurs in the source code.
     * @param {RegExp} re The function definition.
     * @param {Array.<string>} urls A list of URLs to search.
     * @return {?Object.<string, (string|number)>} An object containing
     * the url, line, and column number of the defined function.
     * @memberof TraceKit.computeStackTrace
     */
    function findSourceInUrls(re, urls) {
        var source, m;
        for (var i = 0, j = urls.length; i < j; ++i) {
            // console.log('searching', urls[i]);
            if ((source = getSource(urls[i])).length) {
                source = source.join('\n');
                if ((m = re.exec(source))) {
                    // console.log('Found function in ' + urls[i]);

                    return {
                        'url': urls[i],
                        'line': source.substring(0, m.index).split('\n').length,
                        'column': m.index - source.lastIndexOf('\n', m.index) - 1
                    };
                }
            }
        }

        // console.log('no match');

        return null;
    }

    /**
     * Determines at which column a code fragment occurs on a line of the
     * source code.
     * @param {string} fragment The code fragment.
     * @param {string} url The URL to search.
     * @param {(string|number)} line The line number to examine.
     * @return {?number} The column number.
     * @memberof TraceKit.computeStackTrace
     */
    function findSourceInLine(fragment, url, line) {
        var source = getSource(url),
            re = new RegExp('\\b' + escapeRegExp(fragment) + '\\b'),
            m;

        line -= 1;

        if (source && source.length > line && (m = re.exec(source[line]))) {
            return m.index;
        }

        return null;
    }

    /**
     * Determines where a function was defined within the source code.
     * @param {(Function|string)} func A function reference or serialized
     * function definition.
     * @return {?Object.<string, (string|number)>} An object containing
     * the url, line, and column number of the defined function.
     * @memberof TraceKit.computeStackTrace
     */
    function findSourceByFunctionBody(func) {
        if (_isUndefined(window && window.document)) {
            return;
        }

        var urls = [window.location.href],
            scripts = window.document.getElementsByTagName('script'),
            body,
            code = '' + func,
            codeRE = /^function(?:\s+([\w$]+))?\s*\(([\w\s,]*)\)\s*\{\s*(\S[\s\S]*\S)\s*\}\s*$/,
            eventRE = /^function on([\w$]+)\s*\(event\)\s*\{\s*(\S[\s\S]*\S)\s*\}\s*$/,
            re,
            parts,
            result;

        for (var i = 0; i < scripts.length; ++i) {
            var script = scripts[i];
            if (script.src) {
                urls.push(script.src);
            }
        }

        if (!(parts = codeRE.exec(code))) {
            re = new RegExp(escapeRegExp(code).replace(/\s+/g, '\\s+'));
        }

        // not sure if this is really necessary, but I don’t have a test
        // corpus large enough to confirm that and it was in the original.
        else {
            var name = parts[1] ? '\\s+' + parts[1] : '',
                args = parts[2].split(',').join('\\s*,\\s*');

            body = escapeRegExp(parts[3]).replace(/;$/, ';?'); // semicolon is inserted if the function ends with a comment.replace(/\s+/g, '\\s+');
            re = new RegExp('function' + name + '\\s*\\(\\s*' + args + '\\s*\\)\\s*{\\s*' + body + '\\s*}');
        }

        // look for a normal function definition
        if ((result = findSourceInUrls(re, urls))) {
            return result;
        }

        // look for an old-school event handler function
        if ((parts = eventRE.exec(code))) {
            var event = parts[1];
            body = escapeCodeAsRegExpForMatchingInsideHTML(parts[2]);

            // look for a function defined in HTML as an onXXX handler
            re = new RegExp('on' + event + '=[\\\'"]\\s*' + body + '\\s*[\\\'"]', 'i');

            if ((result = findSourceInUrls(re, urls[0]))) {
                return result;
            }

            // look for ???
            re = new RegExp(body);

            if ((result = findSourceInUrls(re, urls))) {
                return result;
            }
        }

        return null;
    }

    // Contents of Exception in various browsers.
    //
    // SAFARI:
    // ex.message = Can't find variable: qq
    // ex.line = 59
    // ex.sourceId = 580238192
    // ex.sourceURL = http://...
    // ex.expressionBeginOffset = 96
    // ex.expressionCaretOffset = 98
    // ex.expressionEndOffset = 98
    // ex.name = ReferenceError
    //
    // FIREFOX:
    // ex.message = qq is not defined
    // ex.fileName = http://...
    // ex.lineNumber = 59
    // ex.columnNumber = 69
    // ex.stack = ...stack trace... (see the example below)
    // ex.name = ReferenceError
    //
    // CHROME:
    // ex.message = qq is not defined
    // ex.name = ReferenceError
    // ex.type = not_defined
    // ex.arguments = ['aa']
    // ex.stack = ...stack trace...
    //
    // INTERNET EXPLORER:
    // ex.message = ...
    // ex.name = ReferenceError
    //
    // OPERA:
    // ex.message = ...message... (see the example below)
    // ex.name = ReferenceError
    // ex.opera#sourceloc = 11  (pretty much useless, duplicates the info in ex.message)
    // ex.stacktrace = n/a; see 'opera:config#UserPrefs|Exceptions Have Stacktrace'

    /**
     * Computes stack trace information from the stack property.
     * Chrome and Gecko use this property.
     * @param {Error} ex
     * @return {?TraceKit.StackTrace} Stack trace information.
     * @memberof TraceKit.computeStackTrace
     */
    function computeStackTraceFromStackProp(ex) {
        if (!ex.stack) {
            return null;
        }

        var chrome = /^\s*at (.*?) ?\(((?:file|https?|blob|chrome-extension|native|webpack|eval).*?)(?::(\d+))?(?::(\d+))?\)?\s*$/i,
            gecko = /^\s*(.*?)(?:\((.*?)\))?(?:^|@)((?:file|https?|blob|chrome|webpack|\[native).*?)(?::(\d+))?(?::(\d+))?\s*$/i,
            winjs = /^\s*at (?:((?:\[object object\])?.+) )?\(?((?:ms-appx|https?|webpack|blob):.*?):(\d+)(?::(\d+))?\)?\s*$/i,
            lines = ex.stack.split('\n'),
            stack = [],
            parts,
            element,
            reference = /^(.*) is undefined$/.exec(ex.message);

        for (var i = 0, j = lines.length; i < j; ++i) {
            if ((parts = chrome.exec(lines[i]))) {
                var isNative = parts[2] && parts[2].indexOf('native') !== -1;
                element = {
                    'url': !isNative ? parts[2] : null,
                    'func': parts[1] || UNKNOWN_FUNCTION,
                    'args': isNative ? [parts[2]] : [],
                    'line': parts[3] ? +parts[3] : null,
                    'column': parts[4] ? +parts[4] : null
                };
            } else if ( parts = winjs.exec(lines[i]) ) {
                element = {
                    'url': parts[2],
                    'func': parts[1] || UNKNOWN_FUNCTION,
                    'args': [],
                    'line': +parts[3],
                    'column': parts[4] ? +parts[4] : null
                };
            } else if ((parts = gecko.exec(lines[i]))) {
                element = {
                    'url': parts[3],
                    'func': parts[1] || UNKNOWN_FUNCTION,
                    'args': parts[2] ? parts[2].split(',') : [],
                    'line': parts[4] ? +parts[4] : null,
                    'column': parts[5] ? +parts[5] : null
                };
            } else {
                continue;
            }

            if (!element.func && element.line) {
                element.func = guessFunctionName(element.url, element.line);
            }

            if (element.line) {
                element.context = gatherContext(element.url, element.line);
            }

            stack.push(element);
        }

        if (!stack.length) {
            return null;
        }

        if (stack[0] && stack[0].line && !stack[0].column && reference) {
            stack[0].column = findSourceInLine(reference[1], stack[0].url, stack[0].line);
        } else if (!stack[0].column && !_isUndefined(ex.columnNumber)) {
            // FireFox uses this awesome columnNumber property for its top frame
            // Also note, Firefox's column number is 0-based and everything else expects 1-based,
            // so adding 1
            stack[0].column = ex.columnNumber + 1;
        }

        return {
            'mode': 'stack',
            'name': ex.name,
            'message': ex.message,
            'stack': stack
        };
    }

    /**
     * Computes stack trace information from the stacktrace property.
     * Opera 10+ uses this property.
     * @param {Error} ex
     * @return {?TraceKit.StackTrace} Stack trace information.
     * @memberof TraceKit.computeStackTrace
     */
    function computeStackTraceFromStacktraceProp(ex) {
        // Access and store the stacktrace property before doing ANYTHING
        // else to it because Opera is not very good at providing it
        // reliably in other circumstances.
        var stacktrace = ex.stacktrace;
        if (!stacktrace) {
            return;
        }

        var opera10Regex = / line (\d+).*script (?:in )?(\S+)(?:: in function (\S+))?$/i,
            opera11Regex = / line (\d+), column (\d+)\s*(?:in (?:<anonymous function: ([^>]+)>|([^\)]+))\((.*)\))? in (.*):\s*$/i,
            lines = stacktrace.split('\n'),
            stack = [],
            parts;

        for (var line = 0; line < lines.length; line += 2) {
            var element = null;
            if ((parts = opera10Regex.exec(lines[line]))) {
                element = {
                    'url': parts[2],
                    'line': +parts[1],
                    'column': null,
                    'func': parts[3],
                    'args':[]
                };
            } else if ((parts = opera11Regex.exec(lines[line]))) {
                element = {
                    'url': parts[6],
                    'line': +parts[1],
                    'column': +parts[2],
                    'func': parts[3] || parts[4],
                    'args': parts[5] ? parts[5].split(',') : []
                };
            }

            if (element) {
                if (!element.func && element.line) {
                    element.func = guessFunctionName(element.url, element.line);
                }
                if (element.line) {
                    try {
                        element.context = gatherContext(element.url, element.line);
                    } catch (exc) {}
                }

                if (!element.context) {
                    element.context = [lines[line + 1]];
                }

                stack.push(element);
            }
        }

        if (!stack.length) {
            return null;
        }

        return {
            'mode': 'stacktrace',
            'name': ex.name,
            'message': ex.message,
            'stack': stack
        };
    }

    /**
     * NOT TESTED.
     * Computes stack trace information from an error message that includes
     * the stack trace.
     * Opera 9 and earlier use this method if the option to show stack
     * traces is turned on in opera:config.
     * @param {Error} ex
     * @return {?TraceKit.StackTrace} Stack information.
     * @memberof TraceKit.computeStackTrace
     */
    function computeStackTraceFromOperaMultiLineMessage(ex) {
        // TODO: Clean this function up
        // Opera includes a stack trace into the exception message. An example is:
        //
        // Statement on line 3: Undefined variable: undefinedFunc
        // Backtrace:
        //   Line 3 of linked script file://localhost/Users/andreyvit/Projects/TraceKit/javascript-client/sample.js: In function zzz
        //         undefinedFunc(a);
        //   Line 7 of inline#1 script in file://localhost/Users/andreyvit/Projects/TraceKit/javascript-client/sample.html: In function yyy
        //           zzz(x, y, z);
        //   Line 3 of inline#1 script in file://localhost/Users/andreyvit/Projects/TraceKit/javascript-client/sample.html: In function xxx
        //           yyy(a, a, a);
        //   Line 1 of function script
        //     try { xxx('hi'); return false; } catch(ex) { TraceKit.report(ex); }
        //   ...

        var lines = ex.message.split('\n');
        if (lines.length < 4) {
            return null;
        }

        var lineRE1 = /^\s*Line (\d+) of linked script ((?:file|https?|blob)\S+)(?:: in function (\S+))?\s*$/i,
            lineRE2 = /^\s*Line (\d+) of inline#(\d+) script in ((?:file|https?|blob)\S+)(?:: in function (\S+))?\s*$/i,
            lineRE3 = /^\s*Line (\d+) of function script\s*$/i,
            stack = [],
            scripts = (window && window.document && window.document.getElementsByTagName('script')),
            inlineScriptBlocks = [],
            parts;

        for (var s in scripts) {
            if (_has(scripts, s) && !scripts[s].src) {
                inlineScriptBlocks.push(scripts[s]);
            }
        }

        for (var line = 2; line < lines.length; line += 2) {
            var item = null;
            if ((parts = lineRE1.exec(lines[line]))) {
                item = {
                    'url': parts[2],
                    'func': parts[3],
                    'args': [],
                    'line': +parts[1],
                    'column': null
                };
            } else if ((parts = lineRE2.exec(lines[line]))) {
                item = {
                    'url': parts[3],
                    'func': parts[4],
                    'args': [],
                    'line': +parts[1],
                    'column': null // TODO: Check to see if inline#1 (+parts[2]) points to the script number or column number.
                };
                var relativeLine = (+parts[1]); // relative to the start of the <SCRIPT> block
                var script = inlineScriptBlocks[parts[2] - 1];
                if (script) {
                    var source = getSource(item.url);
                    if (source) {
                        source = source.join('\n');
                        var pos = source.indexOf(script.innerText);
                        if (pos >= 0) {
                            item.line = relativeLine + source.substring(0, pos).split('\n').length;
                        }
                    }
                }
            } else if ((parts = lineRE3.exec(lines[line]))) {
                var url = window.location.href.replace(/#.*$/, '');
                var re = new RegExp(escapeCodeAsRegExpForMatchingInsideHTML(lines[line + 1]));
                var src = findSourceInUrls(re, [url]);
                item = {
                    'url': url,
                    'func': '',
                    'args': [],
                    'line': src ? src.line : parts[1],
                    'column': null
                };
            }

            if (item) {
                if (!item.func) {
                    item.func = guessFunctionName(item.url, item.line);
                }
                var context = gatherContext(item.url, item.line);
                var midline = (context ? context[Math.floor(context.length / 2)] : null);
                if (context && midline.replace(/^\s*/, '') === lines[line + 1].replace(/^\s*/, '')) {
                    item.context = context;
                } else {
                    // if (context) alert("Context mismatch. Correct midline:\n" + lines[i+1] + "\n\nMidline:\n" + midline + "\n\nContext:\n" + context.join("\n") + "\n\nURL:\n" + item.url);
                    item.context = [lines[line + 1]];
                }
                stack.push(item);
            }
        }
        if (!stack.length) {
            return null; // could not parse multiline exception message as Opera stack trace
        }

        return {
            'mode': 'multiline',
            'name': ex.name,
            'message': lines[0],
            'stack': stack
        };
    }

    /**
     * Adds information about the first frame to incomplete stack traces.
     * Safari and IE require this to get complete data on the first frame.
     * @param {TraceKit.StackTrace} stackInfo Stack trace information from
     * one of the compute* methods.
     * @param {string} url The URL of the script that caused an error.
     * @param {(number|string)} lineNo The line number of the script that
     * caused an error.
     * @param {string=} message The error generated by the browser, which
     * hopefully contains the name of the object that caused the error.
     * @return {boolean} Whether or not the stack information was
     * augmented.
     * @memberof TraceKit.computeStackTrace
     */
    function augmentStackTraceWithInitialElement(stackInfo, url, lineNo, message) {
        var initial = {
            'url': url,
            'line': lineNo
        };

        if (initial.url && initial.line) {
            stackInfo.incomplete = false;

            if (!initial.func) {
                initial.func = guessFunctionName(initial.url, initial.line);
            }

            if (!initial.context) {
                initial.context = gatherContext(initial.url, initial.line);
            }

            var reference = / '([^']+)' /.exec(message);
            if (reference) {
                initial.column = findSourceInLine(reference[1], initial.url, initial.line);
            }

            if (stackInfo.stack.length > 0) {
                if (stackInfo.stack[0].url === initial.url) {
                    if (stackInfo.stack[0].line === initial.line) {
                        return false; // already in stack trace
                    } else if (!stackInfo.stack[0].line && stackInfo.stack[0].func === initial.func) {
                        stackInfo.stack[0].line = initial.line;
                        stackInfo.stack[0].context = initial.context;
                        return false;
                    }
                }
            }

            stackInfo.stack.unshift(initial);
            stackInfo.partial = true;
            return true;
        } else {
            stackInfo.incomplete = true;
        }

        return false;
    }

    /**
     * Computes stack trace information by walking the arguments.caller
     * chain at the time the exception occurred. This will cause earlier
     * frames to be missed but is the only way to get any stack trace in
     * Safari and IE. The top frame is restored by
     * {@link augmentStackTraceWithInitialElement}.
     * @param {Error} ex
     * @return {TraceKit.StackTrace=} Stack trace information.
     * @memberof TraceKit.computeStackTrace
     */
    function computeStackTraceByWalkingCallerChain(ex, depth) {
        var functionName = /function\s+([_$a-zA-Z\xA0-\uFFFF][_$a-zA-Z0-9\xA0-\uFFFF]*)?\s*\(/i,
            stack = [],
            funcs = {},
            recursion = false,
            parts,
            item,
            source;

        for (var curr = computeStackTraceByWalkingCallerChain.caller; curr && !recursion; curr = curr.caller) {
            if (curr === computeStackTrace || curr === TraceKit.report) {
                // console.log('skipping internal function');
                continue;
            }

            item = {
                'url': null,
                'func': UNKNOWN_FUNCTION,
                'args': [],
                'line': null,
                'column': null
            };

            if (curr.name) {
                item.func = curr.name;
            } else if ((parts = functionName.exec(curr.toString()))) {
                item.func = parts[1];
            }

            if (typeof item.func === 'undefined') {
              try {
                item.func = parts.input.substring(0, parts.input.indexOf('{'));
              } catch (e) { }
            }

            if ((source = findSourceByFunctionBody(curr))) {
                item.url = source.url;
                item.line = source.line;

                if (item.func === UNKNOWN_FUNCTION) {
                    item.func = guessFunctionName(item.url, item.line);
                }

                var reference = / '([^']+)' /.exec(ex.message || ex.description);
                if (reference) {
                    item.column = findSourceInLine(reference[1], source.url, source.line);
                }
            }

            if (funcs['' + curr]) {
                recursion = true;
            }else{
                funcs['' + curr] = true;
            }

            stack.push(item);
        }

        if (depth) {
            // console.log('depth is ' + depth);
            // console.log('stack is ' + stack.length);
            stack.splice(0, depth);
        }

        var result = {
            'mode': 'callers',
            'name': ex.name,
            'message': ex.message,
            'stack': stack
        };
        augmentStackTraceWithInitialElement(result, ex.sourceURL || ex.fileName, ex.line || ex.lineNumber, ex.message || ex.description);
        return result;
    }

    /**
     * Computes a stack trace for an exception.
     * @param {Error} ex
     * @param {(string|number)=} depth
     * @memberof TraceKit.computeStackTrace
     */
    function computeStackTrace(ex, depth) {
        var stack = null;
        depth = (depth == null ? 0 : +depth);

        try {
            // This must be tried first because Opera 10 *destroys*
            // its stacktrace property if you try to access the stack
            // property first!!
            stack = computeStackTraceFromStacktraceProp(ex);
            if (stack) {
                return stack;
            }
        } catch (e) {
            if (debug) {
                throw e;
            }
        }

        try {
            stack = computeStackTraceFromStackProp(ex);
            if (stack) {
                return stack;
            }
        } catch (e) {
            if (debug) {
                throw e;
            }
        }

        try {
            stack = computeStackTraceFromOperaMultiLineMessage(ex);
            if (stack) {
                return stack;
            }
        } catch (e) {
            if (debug) {
                throw e;
            }
        }

        try {
            stack = computeStackTraceByWalkingCallerChain(ex, depth + 1);
            if (stack) {
                return stack;
            }
        } catch (e) {
            if (debug) {
                throw e;
            }
        }

        return {
            'mode': 'failed'
        };
    }

    /**
     * Logs a stacktrace starting from the previous call and working down.
     * @param {(number|string)=} depth How many frames deep to trace.
     * @return {TraceKit.StackTrace} Stack trace information.
     * @memberof TraceKit.computeStackTrace
     */
    function computeStackTraceOfCaller(depth) {
        depth = (depth == null ? 0 : +depth) + 1; // "+ 1" because "ofCaller" should drop one frame
        try {
            throw new Error();
        } catch (ex) {
            return computeStackTrace(ex, depth + 1);
        }
    }

    computeStackTrace.augmentStackTraceWithInitialElement = augmentStackTraceWithInitialElement;
    computeStackTrace.guessFunctionName = guessFunctionName;
    computeStackTrace.gatherContext = gatherContext;
    computeStackTrace.ofCaller = computeStackTraceOfCaller;
    computeStackTrace.getSource = getSource;

    return computeStackTrace;
}());

/**
 * Extends support for global error handling for asynchronous browser
 * functions. Adopted from Closure Library's errorhandler.js
 * @memberof TraceKit
 */
TraceKit.extendToAsynchronousCallbacks = function () {
    var _helper = function _helper(fnName) {
        var originalFn = window[fnName];
        window[fnName] = function traceKitAsyncExtension() {
            // Make a copy of the arguments
            var args = _slice.call(arguments);
            var originalCallback = args[0];
            if (typeof (originalCallback) === 'function') {
                args[0] = TraceKit.wrap(originalCallback);
            }
            // IE < 9 doesn't support .call/.apply on setInterval/setTimeout, but it
            // also only supports 2 argument and doesn't care what "this" is, so we
            // can just call the original function directly.
            if (originalFn.apply) {
                return originalFn.apply(this, args);
            } else {
                return originalFn(args[0], args[1]);
            }
        };
    };

    _helper('setTimeout');
    _helper('setInterval');
};

//Default options:
if (!TraceKit.remoteFetching) {
    TraceKit.remoteFetching = true;
}
if (!TraceKit.collectWindowErrors) {
    TraceKit.collectWindowErrors = true;
}
if (!TraceKit.linesOfContext || TraceKit.linesOfContext < 1) {
    // 5 lines before, the offending line, 5 lines after
    TraceKit.linesOfContext = 11;
}

// UMD export
if (typeof module !== 'undefined' && module.exports && window.module !== module) {
    module.exports = TraceKit;
} else if (typeof define === 'function' && define.amd) {
    define('TraceKit', [], TraceKit);
} else {
    window.TraceKit = TraceKit;
}

}(typeof window !== 'undefined' ? window : global));
;

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * general function, usually for data manipulation pages
 *
 */

var ErrorReport = {
    /**
     * @var object stores the last exception info
     */
    _last_exception: null,
    /**
     * handles thrown error exceptions based on user preferences
     *
     * @return void
     */
    error_handler: function (exception) {
        if (exception.name === null || typeof(exception.name) == "undefined") {
            exception.name = ErrorReport._extractExceptionName(exception);
        }
        ErrorReport._last_exception = exception;
        $.get("error_report.php", {
            ajax_request: true,
            server: PMA_commonParams.get('server'),
            token: PMA_commonParams.get('token'),
            get_settings: true,
            exception_type: 'js'
        }, function (data) {
            if (data.success !== true) {
                PMA_ajaxShowMessage(data.error, false);
                return;
            }
            if (data.report_setting == "ask") {
                ErrorReport._showErrorNotification();
            } else if (data.report_setting == "always") {
                report_data = ErrorReport._get_report_data(exception);
                post_data = $.extend(report_data, {
                    send_error_report: true,
                    automatic: true
                });
                $.post("error_report.php", post_data, function (data) {
                    if (data.success === false) {
                        //in the case of an error, show the error message returned.
                        PMA_ajaxShowMessage(data.error, false);
                    } else {
                        PMA_ajaxShowMessage(data.message, false);
                    }
                });
            }
        });
    },
    /**
     * Shows the modal dialog previewing the report
     *
     * @param exception object error report info
     *
     * @return void
     */
    _showReportDialog: function (exception) {
        var report_data = ErrorReport._get_report_data(exception);

        /*Remove the hidden dialogs if there are*/
        if ($('#error_report_dialog').length !== 0) {
            $('#error_report_dialog').remove();
        }
        var $div = $('<div id="error_report_dialog"></div>');
        $div.css('z-index', '1000');

        var button_options = {};

        button_options[PMA_messages.strSendErrorReport] = function () {
            var $dialog = $(this);
            var post_data = $.extend(report_data, {
                send_error_report: true,
                description: $("#report_description").val(),
                always_send: $("#always_send_checkbox")[0].checked
            });
            $.post("error_report.php", post_data, function (data) {
                $dialog.dialog('close');
                if (data.success === false) {
                    //in the case of an error, show the error message returned.
                    PMA_ajaxShowMessage(data.error, false);
                } else {
                    PMA_ajaxShowMessage(data.message, 3000);
                }
            });
        };

        button_options[PMA_messages.strCancel] = function () {
            $(this).dialog('close');
        };

        $.post("error_report.php", report_data, function (data) {
            if (data.success === false) {
                //in the case of an error, show the error message returned.
                PMA_ajaxShowMessage(data.error, false);
            } else {
                // Show dialog if the request was successful
                $div
                .append(data.message)
                .dialog({
                    title: PMA_messages.strSubmitErrorReport,
                    width: 650,
                    modal: true,
                    buttons: button_options,
                    close: function () {
                        $(this).remove();
                    }
                });
            }
        }); // end $.get()
    },
    /**
     * Shows the small notification that asks for user permission
     *
     * @return void
     */
    _showErrorNotification: function () {
        ErrorReport._removeErrorNotification();

        var $div = $(
            '<div style="position:fixed;bottom:0;left:0;right:0;margin:0;' +
            'z-index:1000" class="error" id="error_notification"></div>'
        ).append(
            PMA_getImage("s_error.png") + PMA_messages.strErrorOccurred
        );

        var $buttons = $('<div class="floatright"></div>');

        var button_html  = '<button id="show_error_report">';
        button_html += PMA_messages.strShowReportDetails;
        button_html += '</button>';

        button_html += '<a id="change_error_settings">';
        button_html += PMA_getImage('s_cog.png', PMA_messages.strChangeReportSettings);
        button_html += '</a>';

        button_html += '<a href="#" id="ignore_error">';
        button_html += PMA_getImage('b_close.png', PMA_messages.strIgnore);
        button_html += '</a>';

        $buttons.html(button_html);

        $div.append($buttons);
        $div.appendTo(document.body);
        $("#change_error_settings").on("click", ErrorReport._redirect_to_settings);
        $("#show_error_report").on("click", ErrorReport._createReportDialog);
        $("#ignore_error").on("click", ErrorReport._removeErrorNotification);
    },
    /**
     * Removes the notification if it was displayed before
     *
     * @return void
     */
    _removeErrorNotification: function (e) {
        if (e) {
            // don't remove the hash fragment by navigating to #
            e.preventDefault();
        }
        $("#error_notification").fadeOut(function () {
            $(this).remove();
        });
    },
    /**
     * Extracts Exception name from message if it exists
     *
     * @return String
     */
    _extractExceptionName: function (exception) {
        if (exception.message === null || typeof(exception.message) == "undefined") {
            return "";
        }

        var reg = /([a-zA-Z]+):/;
        var regex_result = reg.exec(exception.message);
        if (regex_result && regex_result.length == 2) {
            return regex_result[1];
        }

        return "";
    },
    /**
     * Shows the modal dialog previewing the report
     *
     * @return void
     */
    _createReportDialog: function () {
        ErrorReport._removeErrorNotification();
        ErrorReport._showReportDialog(ErrorReport._last_exception);
    },
    /**
     * Redirects to the settings page containing error report
     * preferences
     *
     * @return void
     */
    _redirect_to_settings: function () {
        window.location.href = "prefs_forms.php?token=" + PMA_commonParams.get('token');
    },
    /**
     * Returns the report data to send to the server
     *
     * @param exception object exception info
     *
     * @return object
     */
    _get_report_data: function (exception) {
        var report_data = {
            "ajax_request": true,
            "token": PMA_commonParams.get('token'),
            "exception": exception,
            "current_url": window.location.href,
            "exception_type": 'js'
        };
        if (AJAX.scriptHandler._scripts.length > 0) {
            report_data.scripts = AJAX.scriptHandler._scripts.map(
                function (script) {
                    return script.name;
                }
            );
        }
        return report_data;
    },
    /**
     * Wraps all global functions that start with PMA_
     *
     * @return void
     */
    wrap_global_functions: function () {
        for (var key in window) {
            if (key.indexOf("PMA_") === 0) {
                var global = window[key];
                if (typeof(global) === "function") {
                    window[key] = ErrorReport.wrap_function(global);
                }
            }
        }
    },
    /**
     * Wraps given function in error reporting code and returns wrapped function
     *
     * @param func function to be wrapped
     *
     * @return function
     */
    wrap_function: function (func) {
        if (!func.wrapped) {
            var new_func = function () {
                try {
                    return func.apply(this, arguments);
                } catch (x) {
                    TraceKit.report(x);
                }
            };
            new_func.wrapped = true;
            //Set guid of wrapped function same as original function, so it can be removed
            //See bug#4146 (problem with jquery draggable and sortable)
            new_func.guid = func.guid = func.guid || new_func.guid || jQuery.guid++;
            return new_func;
        } else {
            return func;
        }
    },
    /**
     * Automatically wraps the callback in AJAX.registerOnload
     *
     * @return void
     */
    _wrap_ajax_onload_callback: function () {
        var oldOnload = AJAX.registerOnload;
        AJAX.registerOnload = function (file, func) {
            func = ErrorReport.wrap_function(func);
            oldOnload.call(this, file, func);
        };
    },
    /**
     * Automatically wraps the callback in $.fn.on
     *
     * @return void
     */
    _wrap_$_on_callback: function () {
        var oldOn = $.fn.on;
        $.fn.on = function () {
            for (var i = 1; i <= 3; i++) {
                if (typeof(arguments[i]) === "function") {
                    arguments[i] = ErrorReport.wrap_function(arguments[i]);
                    break;
                }
            }
            return oldOn.apply(this, arguments);
        };
    },
    /**
     * Wraps all global functions that start with PMA_
     * also automatically wraps the callback in AJAX.registerOnload
     *
     * @return void
     */
    set_up_error_reporting: function () {
        ErrorReport.wrap_global_functions();
        ErrorReport._wrap_ajax_onload_callback();
        ErrorReport._wrap_$_on_callback();
    }

};

AJAX.registerOnload('error_report.js', function(){
    TraceKit.report.subscribe(ErrorReport.error_handler);
    ErrorReport.set_up_error_reporting();
    ErrorReport.wrap_global_functions();
});
;

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Functions used in configuration forms and on user preferences pages
 */

/**
 * checks whether browser supports web storage
 *
 * @param type the type of storage i.e. localStorage or sessionStorage
 *
 * @returns bool
 */
function isStorageSupported(type, warn)
{
    try {
        window[type].setItem('PMATest', 'test');
        // Check whether key-value pair was set successfully
        if (window[type].getItem('PMATest') === 'test') {
            // Supported, remove test variable from storage
            window[type].removeItem('PMATest');
            return true;
        }
    } catch(error) {
        // Not supported
        if (warn) {
            PMA_ajaxShowMessage(PMA_messages.strNoLocalStorage, false);
        }
    }
    return false;
}

/**
 * Unbind all event handlers before tearing down a page
 */
AJAX.registerTeardown('config.js', function () {
    $('.optbox input[id], .optbox select[id], .optbox textarea[id]').unbind('change').unbind('keyup');
    $('.optbox input[type=button][name=submit_reset]').unbind('click');
    $('div.tabs_contents').undelegate();
    $('#import_local_storage, #export_local_storage').unbind('click');
    $('form.prefs-form').unbind('change').unbind('submit');
    $(document).off('click', 'div.click-hide-message');
    $('#prefs_autoload').find('a').unbind('click');
});

AJAX.registerOnload('config.js', function () {
    var $topmenu_upt = $('#topmenu2.user_prefs_tabs');
    $topmenu_upt.find('li.active a').attr('rel', 'samepage');
    $topmenu_upt.find('li:not(.active) a').attr('rel', 'newpage');
});

// default values for fields
var defaultValues = {};

/**
 * Returns field type
 *
 * @param {Element} field
 */
function getFieldType(field)
{
    var $field = $(field);
    var tagName = $field.prop('tagName');
    if (tagName == 'INPUT') {
        return $field.attr('type');
    } else if (tagName == 'SELECT') {
        return 'select';
    } else if (tagName == 'TEXTAREA') {
        return 'text';
    }
    return '';
}

/**
 * Enables or disables the "restore default value" button
 *
 * @param {Element} field
 * @param {boolean} display
 */
function setRestoreDefaultBtn(field, display)
{
    var $el = $(field).closest('td').find('.restore-default img');
    $el[display ? 'show' : 'hide']();
}

/**
 * Marks field depending on its value (system default or custom)
 *
 * @param {Element} field
 */
function markField(field)
{
    var $field = $(field);
    var type = getFieldType($field);
    var isDefault = checkFieldDefault($field, type);

    // checkboxes uses parent <span> for marking
    var $fieldMarker = (type == 'checkbox') ? $field.parent() : $field;
    setRestoreDefaultBtn($field, !isDefault);
    $fieldMarker[isDefault ? 'removeClass' : 'addClass']('custom');
}

/**
 * Sets field value
 *
 * value must be of type:
 * o undefined (omitted) - restore default value (form default, not PMA default)
 * o String - if field_type is 'text'
 * o boolean - if field_type is 'checkbox'
 * o Array of values - if field_type is 'select'
 *
 * @param {Element} field
 * @param {String}  field_type  see {@link #getFieldType}
 * @param {String|Boolean}  [value]
 */
function setFieldValue(field, field_type, value)
{
    var $field = $(field);
    switch (field_type) {
    case 'text':
    case 'number':
        $field.val(value !== undefined ? value : $field.attr('defaultValue'));
        break;
    case 'checkbox':
        $field.prop('checked', (value !== undefined ? value : $field.attr('defaultChecked')));
        break;
    case 'select':
        var options = $field.prop('options');
        var i, imax = options.length;
        if (value === undefined) {
            for (i = 0; i < imax; i++) {
                options[i].selected = options[i].defaultSelected;
            }
        } else {
            for (i = 0; i < imax; i++) {
                options[i].selected = (value.indexOf(options[i].value) != -1);
            }
        }
        break;
    }
    markField($field);
}

/**
 * Gets field value
 *
 * Will return one of:
 * o String - if type is 'text'
 * o boolean - if type is 'checkbox'
 * o Array of values - if type is 'select'
 *
 * @param {Element} field
 * @param {String}  field_type returned by {@link #getFieldType}
 * @type Boolean|String|String[]
 */
function getFieldValue(field, field_type)
{
    var $field = $(field);
    switch (field_type) {
    case 'text':
    case 'number':
        return $field.prop('value');
    case 'checkbox':
        return $field.prop('checked');
    case 'select':
        var options = $field.prop('options');
        var i, imax = options.length, items = [];
        for (i = 0; i < imax; i++) {
            if (options[i].selected) {
                items.push(options[i].value);
            }
        }
        return items;
    }
    return null;
}

/**
 * Returns values for all fields in fieldsets
 */
function getAllValues()
{
    var $elements = $('fieldset input, fieldset select, fieldset textarea');
    var values = {};
    var type, value;
    for (var i = 0; i < $elements.length; i++) {
        type = getFieldType($elements[i]);
        value = getFieldValue($elements[i], type);
        if (typeof value != 'undefined') {
            // we only have single selects, fatten array
            if (type == 'select') {
                value = value[0];
            }
            values[$elements[i].name] = value;
        }
    }
    return values;
}

/**
 * Checks whether field has its default value
 *
 * @param {Element} field
 * @param {String}  type
 * @return boolean
 */
function checkFieldDefault(field, type)
{
    var $field = $(field);
    var field_id = $field.attr('id');
    if (typeof defaultValues[field_id] == 'undefined') {
        return true;
    }
    var isDefault = true;
    var currentValue = getFieldValue($field, type);
    if (type != 'select') {
        isDefault = currentValue == defaultValues[field_id];
    } else {
        // compare arrays, will work for our representation of select values
        if (currentValue.length != defaultValues[field_id].length) {
            isDefault = false;
        }
        else {
            for (var i = 0; i < currentValue.length; i++) {
                if (currentValue[i] != defaultValues[field_id][i]) {
                    isDefault = false;
                    break;
                }
            }
        }
    }
    return isDefault;
}

/**
 * Returns element's id prefix
 * @param {Element} element
 */
function getIdPrefix(element)
{
    return $(element).attr('id').replace(/[^-]+$/, '');
}

// ------------------------------------------------------------------
// Form validation and field operations
//

// form validator assignments
var validate = {};

// form validator list
var validators = {
    // regexp: numeric value
    _regexp_numeric: /^[0-9]+$/,
    // regexp: extract parts from PCRE expression
    _regexp_pcre_extract: /(.)(.*)\1(.*)?/,
    /**
     * Validates positive number
     *
     * @param {boolean} isKeyUp
     */
    PMA_validatePositiveNumber: function (isKeyUp) {
        if (isKeyUp && this.value === '') {
            return true;
        }
        var result = this.value != '0' && validators._regexp_numeric.test(this.value);
        return result ? true : PMA_messages.error_nan_p;
    },
    /**
     * Validates non-negative number
     *
     * @param {boolean} isKeyUp
     */
    PMA_validateNonNegativeNumber: function (isKeyUp) {
        if (isKeyUp && this.value === '') {
            return true;
        }
        var result = validators._regexp_numeric.test(this.value);
        return result ? true : PMA_messages.error_nan_nneg;
    },
    /**
     * Validates port number
     *
     * @param {boolean} isKeyUp
     */
    PMA_validatePortNumber: function (isKeyUp) {
        if (this.value === '') {
            return true;
        }
        var result = validators._regexp_numeric.test(this.value) && this.value != '0';
        return result && this.value <= 65535 ? true : PMA_messages.error_incorrect_port;
    },
    /**
     * Validates value according to given regular expression
     *
     * @param {boolean} isKeyUp
     * @param {string}  regexp
     */
    PMA_validateByRegex: function (isKeyUp, regexp) {
        if (isKeyUp && this.value === '') {
            return true;
        }
        // convert PCRE regexp
        var parts = regexp.match(validators._regexp_pcre_extract);
        var valid = this.value.match(new RegExp(parts[2], parts[3])) !== null;
        return valid ? true : PMA_messages.error_invalid_value;
    },
    /**
     * Validates upper bound for numeric inputs
     *
     * @param {boolean} isKeyUp
     * @param {int} max_value
     */
    PMA_validateUpperBound: function (isKeyUp, max_value) {
        var val = parseInt(this.value, 10);
        if (isNaN(val)) {
            return true;
        }
        return val <= max_value ? true : PMA_sprintf(PMA_messages.error_value_lte, max_value);
    },
    // field validators
    _field: {
    },
    // fieldset validators
    _fieldset: {
    }
};

/**
 * Registers validator for given field
 *
 * @param {String}  id       field id
 * @param {String}  type     validator (key in validators object)
 * @param {boolean} onKeyUp  whether fire on key up
 * @param {Array}   params   validation function parameters
 */
function validateField(id, type, onKeyUp, params)
{
    if (typeof validators[type] == 'undefined') {
        return;
    }
    if (typeof validate[id] == 'undefined') {
        validate[id] = [];
    }
    validate[id].push([type, params, onKeyUp]);
}

/**
 * Returns validation functions associated with form field
 *
 * @param {String}  field_id     form field id
 * @param {boolean} onKeyUpOnly  see validateField
 * @type Array
 * @return array of [function, parameters to be passed to function]
 */
function getFieldValidators(field_id, onKeyUpOnly)
{
    // look for field bound validator
    var name = field_id && field_id.match(/[^-]+$/)[0];
    if (typeof validators._field[name] != 'undefined') {
        return [[validators._field[name], null]];
    }

    // look for registered validators
    var functions = [];
    if (typeof validate[field_id] != 'undefined') {
        // validate[field_id]: array of [type, params, onKeyUp]
        for (var i = 0, imax = validate[field_id].length; i < imax; i++) {
            if (onKeyUpOnly && !validate[field_id][i][2]) {
                continue;
            }
            functions.push([validators[validate[field_id][i][0]], validate[field_id][i][1]]);
        }
    }

    return functions;
}

/**
 * Displays errors for given form fields
 *
 * WARNING: created DOM elements must be identical with the ones made by
 * display_input() in FormDisplay.tpl.php!
 *
 * @param {Object} error_list list of errors in the form {field id: error array}
 */
function displayErrors(error_list)
{
    var tempIsEmpty = function (item) {
        return item !== '';
    };

    for (var field_id in error_list) {
        var errors = error_list[field_id];
        var $field = $('#' + field_id);
        var isFieldset = $field.attr('tagName') == 'FIELDSET';
        var $errorCnt;
        if (isFieldset) {
            $errorCnt = $field.find('dl.errors');
        } else {
            $errorCnt = $field.siblings('.inline_errors');
        }

        // remove empty errors (used to clear error list)
        errors = $.grep(errors, tempIsEmpty);

        // CSS error class
        if (!isFieldset) {
            // checkboxes uses parent <span> for marking
            var $fieldMarker = ($field.attr('type') == 'checkbox') ? $field.parent() : $field;
            $fieldMarker[errors.length ? 'addClass' : 'removeClass']('field-error');
        }

        if (errors.length) {
            // if error container doesn't exist, create it
            if ($errorCnt.length === 0) {
                if (isFieldset) {
                    $errorCnt = $('<dl class="errors" />');
                    $field.find('table').before($errorCnt);
                } else {
                    $errorCnt = $('<dl class="inline_errors" />');
                    $field.closest('td').append($errorCnt);
                }
            }

            var html = '';
            for (var i = 0, imax = errors.length; i < imax; i++) {
                html += '<dd>' + errors[i] + '</dd>';
            }
            $errorCnt.html(html);
        } else if ($errorCnt !== null) {
            // remove useless error container
            $errorCnt.remove();
        }
    }
}

/**
 * Validates fieldset and puts errors in 'errors' object
 *
 * @param {Element} fieldset
 * @param {boolean} isKeyUp
 * @param {Object}  errors
 */
function validate_fieldset(fieldset, isKeyUp, errors)
{
    var $fieldset = $(fieldset);
    if ($fieldset.length && typeof validators._fieldset[$fieldset.attr('id')] != 'undefined') {
        var fieldset_errors = validators._fieldset[$fieldset.attr('id')].apply($fieldset[0], [isKeyUp]);
        for (var field_id in fieldset_errors) {
            if (typeof errors[field_id] == 'undefined') {
                errors[field_id] = [];
            }
            if (typeof fieldset_errors[field_id] == 'string') {
                fieldset_errors[field_id] = [fieldset_errors[field_id]];
            }
            $.merge(errors[field_id], fieldset_errors[field_id]);
        }
    }
}

/**
 * Validates form field and puts errors in 'errors' object
 *
 * @param {Element} field
 * @param {boolean} isKeyUp
 * @param {Object}  errors
 */
function validate_field(field, isKeyUp, errors)
{
    var args, result;
    var $field = $(field);
    var field_id = $field.attr('id');
    errors[field_id] = [];
    var functions = getFieldValidators(field_id, isKeyUp);
    for (var i = 0; i < functions.length; i++) {
        if (typeof functions[i][1] !== 'undefined' && functions[i][1] !== null) {
            args = functions[i][1].slice(0);
        } else {
            args = [];
        }
        args.unshift(isKeyUp);
        result = functions[i][0].apply($field[0], args);
        if (result !== true) {
            if (typeof result == 'string') {
                result = [result];
            }
            $.merge(errors[field_id], result);
        }
    }
}

/**
 * Validates form field and parent fieldset
 *
 * @param {Element} field
 * @param {boolean} isKeyUp
 */
function validate_field_and_fieldset(field, isKeyUp)
{
    var $field = $(field);
    var errors = {};
    validate_field($field, isKeyUp, errors);
    validate_fieldset($field.closest('fieldset.optbox'), isKeyUp, errors);
    displayErrors(errors);
}

function loadInlineConfig() {
    if (!Array.isArray(configInlineParams)) {
        return;
    }
    for (var i = 0; i < configInlineParams.length; ++i) {
        if (typeof configInlineParams[i] === 'function') {
            configInlineParams[i]();
        }
    }
}

function setupValidation() {
    validate = {};
    configScriptLoaded = true;
    if (configScriptLoaded && typeof configInlineParams !== "undefined") {
        loadInlineConfig();
    }
    // register validators and mark custom values
    var $elements = $('.optbox input[id], .optbox select[id], .optbox textarea[id]');
    $elements.each(function () {
        markField(this);
        var $el = $(this);
        $el.bind('change', function () {
            validate_field_and_fieldset(this, false);
            markField(this);
        });
        var tagName = $el.attr('tagName');
        // text fields can be validated after each change
        if (tagName == 'INPUT' && $el.attr('type') == 'text') {
            $el.keyup(function () {
                validate_field_and_fieldset($el, true);
                markField($el);
            });
        }
        // disable textarea spellcheck
        if (tagName == 'TEXTAREA') {
            $el.attr('spellcheck', false);
        }
    });

    // check whether we've refreshed a page and browser remembered modified
    // form values
    var $check_page_refresh = $('#check_page_refresh');
    if ($check_page_refresh.length === 0 || $check_page_refresh.val() == '1') {
        // run all field validators
        var errors = {};
        for (var i = 0; i < $elements.length; i++) {
            validate_field($elements[i], false, errors);
        }
        // run all fieldset validators
        $('fieldset.optbox').each(function () {
            validate_fieldset(this, false, errors);
        });

        displayErrors(errors);
    } else if ($check_page_refresh) {
        $check_page_refresh.val('1');
    }
}

AJAX.registerOnload('config.js', function () {
    setupValidation();
});

//
// END: Form validation and field operations
// ------------------------------------------------------------------

// ------------------------------------------------------------------
// Tabbed forms
//

/**
 * Sets active tab
 *
 * @param {String} tab_id
 */
function setTab(tab_id)
{
    $('ul.tabs').each(function() {
        var $this = $(this);
        if (!$this.find('li a[href="#' + tab_id + '"]').length) {
            return;
        }
        $this.find('li').removeClass('active').find('a[href="#' + tab_id + '"]').parent().addClass('active');
        $this.parent().find('div.tabs_contents fieldset').hide().filter('#' + tab_id).show();
        var hashValue = 'tab_' + tab_id;
        location.hash = hashValue;
        $this.parent().find('input[name=tab_hash]').val(hashValue);
    });
}

function setupConfigTabs() {
    var forms = $('form.config-form');
    forms.each(function() {
        var $this = $(this);
        var $tabs = $this.find('ul.tabs');
        if (!$tabs.length) {
            return;
        }
        // add tabs events and activate one tab (the first one or indicated by location hash)
        $tabs.find('li').removeClass('active');
        $tabs.find('a')
            .click(function (e) {
                e.preventDefault();
                setTab($(this).attr('href').substr(1));
            })
            .filter(':first')
            .parent()
            .addClass('active');
        $this.find('div.tabs_contents fieldset').hide().filter(':first').show();
    });
}

AJAX.registerOnload('config.js', function () {
    setupConfigTabs();

    // tab links handling, check each 200ms
    // (works with history in FF, further browser support here would be an overkill)
    var prev_hash;
    var tab_check_fnc = function () {
        if (location.hash != prev_hash) {
            prev_hash = location.hash;
            if (prev_hash.match(/^#tab_[a-zA-Z0-9_]+$/)) {
                // session ID is sometimes appended here
                var hash = prev_hash.substr(5).split('&')[0];
                if ($('#' + hash).length) {
                    setTab(hash);
                }
            }
        }
    };
    tab_check_fnc();
    setInterval(tab_check_fnc, 200);
});

//
// END: Tabbed forms
// ------------------------------------------------------------------

// ------------------------------------------------------------------
// Form reset buttons
//

AJAX.registerOnload('config.js', function () {
    $('.optbox input[type=button][name=submit_reset]').click(function () {
        var fields = $(this).closest('fieldset').find('input, select, textarea');
        for (var i = 0, imax = fields.length; i < imax; i++) {
            setFieldValue(fields[i], getFieldType(fields[i]));
        }
    });
});

//
// END: Form reset buttons
// ------------------------------------------------------------------

// ------------------------------------------------------------------
// "Restore default" and "set value" buttons
//

/**
 * Restores field's default value
 *
 * @param {String} field_id
 */
function restoreField(field_id)
{
    var $field = $('#' + field_id);
    if ($field.length === 0 || defaultValues[field_id] === undefined) {
        return;
    }
    setFieldValue($field, getFieldType($field), defaultValues[field_id]);
}

function setupRestoreField() {
    $('div.tabs_contents')
        .delegate('.restore-default, .set-value', 'mouseenter', function () {
            $(this).css('opacity', 1);
        })
        .delegate('.restore-default, .set-value', 'mouseleave', function () {
            $(this).css('opacity', 0.25);
        })
        .delegate('.restore-default, .set-value', 'click', function (e) {
            e.preventDefault();
            var href = $(this).attr('href');
            var field_sel;
            if ($(this).hasClass('restore-default')) {
                field_sel = href;
                restoreField(field_sel.substr(1));
            } else {
                field_sel = href.match(/^[^=]+/)[0];
                var value = href.match(/\=(.+)$/)[1];
                setFieldValue($(field_sel), 'text', value);
            }
            $(field_sel).trigger('change');
        })
        .find('.restore-default, .set-value')
        // inline-block for IE so opacity inheritance works
        .css({display: 'inline-block', opacity: 0.25});
}

AJAX.registerOnload('config.js', function () {
    setupRestoreField();
});

//
// END: "Restore default" and "set value" buttons
// ------------------------------------------------------------------

// ------------------------------------------------------------------
// User preferences import/export
//

AJAX.registerOnload('config.js', function () {
    offerPrefsAutoimport();
    var $radios = $('#import_local_storage, #export_local_storage');
    if (!$radios.length) {
        return;
    }

    // enable JavaScript dependent fields
    $radios
        .prop('disabled', false)
        .add('#export_text_file, #import_text_file')
        .click(function () {
            var enable_id = $(this).attr('id');
            var disable_id;
            if (enable_id.match(/local_storage$/)) {
                disable_id = enable_id.replace(/local_storage$/, 'text_file');
            } else {
                disable_id = enable_id.replace(/text_file$/, 'local_storage');
            }
            $('#opts_' + disable_id).addClass('disabled').find('input').prop('disabled', true);
            $('#opts_' + enable_id).removeClass('disabled').find('input').prop('disabled', false);
        });

    // detect localStorage state
    var ls_supported = isStorageSupported('localStorage', true);
    var ls_exists = ls_supported ? (window.localStorage.config || false) : false;
    $('div.localStorage-' + (ls_supported ? 'un' : '') + 'supported').hide();
    $('div.localStorage-' + (ls_exists ? 'empty' : 'exists')).hide();
    if (ls_exists) {
        updatePrefsDate();
    }
    $('form.prefs-form').change(function () {
        var $form = $(this);
        var disabled = false;
        if (!ls_supported) {
            disabled = $form.find('input[type=radio][value$=local_storage]').prop('checked');
        } else if (!ls_exists && $form.attr('name') == 'prefs_import' &&
            $('#import_local_storage')[0].checked
            ) {
            disabled = true;
        }
        $form.find('input[type=submit]').prop('disabled', disabled);
    }).submit(function (e) {
        var $form = $(this);
        if ($form.attr('name') == 'prefs_export' && $('#export_local_storage')[0].checked) {
            e.preventDefault();
            // use AJAX to read JSON settings and save them
            savePrefsToLocalStorage($form);
        } else if ($form.attr('name') == 'prefs_import' && $('#import_local_storage')[0].checked) {
            // set 'json' input and submit form
            $form.find('input[name=json]').val(window.localStorage.config);
        }
    });

    $(document).on('click', 'div.click-hide-message', function () {
        $(this)
        .hide()
        .parent('.group')
        .css('height', '')
        .next('form')
        .show();
    });
});

/**
 * Saves user preferences to localStorage
 *
 * @param {Element} form
 */
function savePrefsToLocalStorage(form)
{
    $form = $(form);
    var submit = $form.find('input[type=submit]');
    submit.prop('disabled', true);
    $.ajax({
        url: 'prefs_manage.php',
        cache: false,
        type: 'POST',
        data: {
            ajax_request: true,
            server: PMA_commonParams.get('server'),
            token: PMA_commonParams.get('token'),
            submit_get_json: true
        },
        success: function (data) {
            if (typeof data !== 'undefined' && data.success === true) {
                window.localStorage.config = data.prefs;
                window.localStorage.config_mtime = data.mtime;
                window.localStorage.config_mtime_local = (new Date()).toUTCString();
                updatePrefsDate();
                $('div.localStorage-empty').hide();
                $('div.localStorage-exists').show();
                var group = $form.parent('.group');
                group.css('height', group.height() + 'px');
                $form.hide('fast');
                $form.prev('.click-hide-message').show('fast');
            } else {
                PMA_ajaxShowMessage(data.error);
            }
        },
        complete: function () {
            submit.prop('disabled', false);
        }
    });
}

/**
 * Updates preferences timestamp in Import form
 */
function updatePrefsDate()
{
    var d = new Date(window.localStorage.config_mtime_local);
    var msg = PMA_messages.strSavedOn.replace(
        '@DATE@',
        PMA_formatDateTime(d)
    );
    $('#opts_import_local_storage').find('div.localStorage-exists').html(msg);
}

/**
 * Prepares message which informs that localStorage preferences are available and can be imported or deleted
 */
function offerPrefsAutoimport()
{
    var has_config = (isStorageSupported('localStorage')) && (window.localStorage.config || false);
    var $cnt = $('#prefs_autoload');
    if (!$cnt.length || !has_config) {
        return;
    }
    $cnt.find('a').click(function (e) {
        e.preventDefault();
        var $a = $(this);
        if ($a.attr('href') == '#no') {
            $cnt.remove();
            $.post('index.php', {
                token: PMA_commonParams.get('token'),
                server: PMA_commonParams.get('server'),
                prefs_autoload: 'hide'
            }, null, 'html');
            return;
        } else if ($a.attr('href') == '#delete') {
            $cnt.remove();
            localStorage.clear();
            $.post('index.php', {
                token: PMA_commonParams.get('token'),
                server: PMA_commonParams.get('server'),
                prefs_autoload: 'hide'
            }, null, 'html');
            return;
        }
        $cnt.find('input[name=json]').val(window.localStorage.config);
        $cnt.find('form').submit();
    });
    $cnt.show();
}

//
// END: User preferences import/export
// ------------------------------------------------------------------
;

/**
 * Definition of links to MySQL documentation.
 */

var mysql_doc_keyword = {
    /* Multi word */
    'CHARACTER SET': Array('charset'),
    'SHOW AUTHORS': Array('show-authors'),
    'SHOW BINARY LOGS': Array('show-binary-logs'),
    'SHOW BINLOG EVENTS': Array('show-binlog-events'),
    'SHOW CHARACTER SET': Array('show-character-set'),
    'SHOW COLLATION': Array('show-collation'),
    'SHOW COLUMNS': Array('show-columns'),
    'SHOW CONTRIBUTORS': Array('show-contributors'),
    'SHOW CREATE DATABASE': Array('show-create-database'),
    'SHOW CREATE EVENT': Array('show-create-event'),
    'SHOW CREATE FUNCTION': Array('show-create-function'),
    'SHOW CREATE PROCEDURE': Array('show-create-procedure'),
    'SHOW CREATE TABLE': Array('show-create-table'),
    'SHOW CREATE TRIGGER': Array('show-create-trigger'),
    'SHOW CREATE VIEW': Array('show-create-view'),
    'SHOW DATABASES': Array('show-databases'),
    'SHOW ENGINE': Array('show-engine'),
    'SHOW ENGINES': Array('show-engines'),
    'SHOW ERRORS': Array('show-errors'),
    'SHOW EVENTS': Array('show-events'),
    'SHOW FUNCTION CODE': Array('show-function-code'),
    'SHOW FUNCTION STATUS': Array('show-function-status'),
    'SHOW GRANTS': Array('show-grants'),
    'SHOW INDEX': Array('show-index'),
    'SHOW MASTER STATUS': Array('show-master-status'),
    'SHOW OPEN TABLES': Array('show-open-tables'),
    'SHOW PLUGINS': Array('show-plugins'),
    'SHOW PRIVILEGES': Array('show-privileges'),
    'SHOW PROCEDURE CODE': Array('show-procedure-code'),
    'SHOW PROCEDURE STATUS': Array('show-procedure-status'),
    'SHOW PROCESSLIST': Array('show-processlist'),
    'SHOW PROFILE': Array('show-profile'),
    'SHOW PROFILES': Array('show-profiles'),
    'SHOW RELAYLOG EVENTS': Array('show-relaylog-events'),
    'SHOW SLAVE HOSTS': Array('show-slave-hosts'),
    'SHOW SLAVE STATUS': Array('show-slave-status'),
    'SHOW STATUS': Array('show-status'),
    'SHOW TABLE STATUS': Array('show-table-status'),
    'SHOW TABLES': Array('show-tables'),
    'SHOW TRIGGERS': Array('show-triggers'),
    'SHOW VARIABLES': Array('show-variables'),
    'SHOW WARNINGS': Array('show-warnings'),
    'LOAD DATA INFILE': Array('load-data'),
    'LOAD XML': Array('load-xml'),
    'LOCK TABLES': Array('lock-tables'),
    'UNLOCK TABLES': Array('lock-tables'),
    'ALTER DATABASE': Array('alter-database'),
    'ALTER EVENT': Array('alter-event'),
    'ALTER LOGFILE GROUP': Array('alter-logfile-group'),
    'ALTER FUNCTION': Array('alter-function'),
    'ALTER PROCEDURE': Array('alter-procedure'),
    'ALTER SERVER': Array('alter-server'),
    'ALTER TABLE': Array('alter-table'),
    'ALTER TABLESPACE': Array('alter-tablespace'),
    'ALTER VIEW': Array('alter-view'),
    'CREATE DATABASE': Array('create-database'),
    'CREATE EVENT': Array('create-event'),
    'CREATE FUNCTION': Array('create-function'),
    'CREATE INDEX': Array('create-index'),
    'CREATE LOGFILE GROUP': Array('create-logfile-group'),
    'CREATE PROCEDURE': Array('create-procedure'),
    'CREATE SERVER': Array('create-server'),
    'CREATE TABLE': Array('create-table'),
    'CREATE TABLESPACE': Array('create-tablespace'),
    'CREATE TRIGGER': Array('create-trigger'),
    'CREATE VIEW': Array('create-view'),
    'DROP DATABASE': Array('drop-database'),
    'DROP EVENT': Array('drop-event'),
    'DROP FUNCTION': Array('drop-function'),
    'DROP INDEX': Array('drop-index'),
    'DROP LOGFILE GROUP': Array('drop-logfile-group'),
    'DROP PROCEDURE': Array('drop-procedure'),
    'DROP SERVER': Array('drop-server'),
    'DROP TABLE': Array('drop-table'),
    'DROP TABLESPACE': Array('drop-tablespace'),
    'DROP TRIGGER': Array('drop-trigger'),
    'DROP VIEW': Array('drop-view'),
    'RENAME TABLE': Array('rename-table'),
    'TRUNCATE TABLE': Array('truncate-table'),

    /* Statements */
    'SELECT': Array('select'),
    'SET': Array('set'),
    'EXPLAIN': Array('explain'),
    'DESCRIBE': Array('describe'),
    'DELETE': Array('delete'),
    'SHOW': Array('show'),
    'UPDATE': Array('update'),
    'INSERT': Array('insert'),
    'REPLACE': Array('replace'),
    'CALL': Array('call'),
    'DO': Array('do'),
    'HANDLER': Array('handler'),
    'COLLATE': Array('charset-collations'),

    /* Functions */
    'ABS': Array('mathematical-functions', 'function_abs'),
    'ACOS': Array('mathematical-functions', 'function_acos'),
    'ADDDATE': Array('date-and-time-functions', 'function_adddate'),
    'ADDTIME': Array('date-and-time-functions', 'function_addtime'),
    'AES_DECRYPT': Array('encryption-functions', 'function_aes_decrypt'),
    'AES_ENCRYPT': Array('encryption-functions', 'function_aes_encrypt'),
    'AND': Array('logical-operators', 'operator_and'),
    'ASCII': Array('string-functions', 'function_ascii'),
    'ASIN': Array('mathematical-functions', 'function_asin'),
    'ATAN2': Array('mathematical-functions', 'function_atan2'),
    'ATAN': Array('mathematical-functions', 'function_atan'),
    'AVG': Array('group-by-functions', 'function_avg'),
    'BENCHMARK': Array('information-functions', 'function_benchmark'),
    'BIN': Array('string-functions', 'function_bin'),
    'BINARY': Array('cast-functions', 'operator_binary'),
    'BIT_AND': Array('group-by-functions', 'function_bit_and'),
    'BIT_COUNT': Array('bit-functions', 'function_bit_count'),
    'BIT_LENGTH': Array('string-functions', 'function_bit_length'),
    'BIT_OR': Array('group-by-functions', 'function_bit_or'),
    'BIT_XOR': Array('group-by-functions', 'function_bit_xor'),
    'CASE': Array('control-flow-functions', 'operator_case'),
    'CAST': Array('cast-functions', 'function_cast'),
    'CEIL': Array('mathematical-functions', 'function_ceil'),
    'CEILING': Array('mathematical-functions', 'function_ceiling'),
    'CHAR_LENGTH': Array('string-functions', 'function_char_length'),
    'CHAR': Array('string-functions', 'function_char'),
    'CHARACTER_LENGTH': Array('string-functions', 'function_character_length'),
    'CHARSET': Array('information-functions', 'function_charset'),
    'COALESCE': Array('comparison-operators', 'function_coalesce'),
    'COERCIBILITY': Array('information-functions', 'function_coercibility'),
    'COLLATION': Array('information-functions', 'function_collation'),
    'COMPRESS': Array('encryption-functions', 'function_compress'),
    'CONCAT_WS': Array('string-functions', 'function_concat_ws'),
    'CONCAT': Array('string-functions', 'function_concat'),
    'CONNECTION_ID': Array('information-functions', 'function_connection_id'),
    'CONV': Array('mathematical-functions', 'function_conv'),
    'CONVERT_TZ': Array('date-and-time-functions', 'function_convert_tz'),
    'Convert': Array('cast-functions', 'function_convert'),
    'COS': Array('mathematical-functions', 'function_cos'),
    'COT': Array('mathematical-functions', 'function_cot'),
    'COUNT': Array('group-by-functions', 'function_count'),
    'CRC32': Array('mathematical-functions', 'function_crc32'),
    'CURDATE': Array('date-and-time-functions', 'function_curdate'),
    'CURRENT_DATE': Array('date-and-time-functions', 'function_current_date'),
    'CURRENT_TIME': Array('date-and-time-functions', 'function_current_time'),
    'CURRENT_TIMESTAMP': Array('date-and-time-functions', 'function_current_timestamp'),
    'CURRENT_USER': Array('information-functions', 'function_current_user'),
    'CURTIME': Array('date-and-time-functions', 'function_curtime'),
    'DATABASE': Array('information-functions', 'function_database'),
    'DATE_ADD': Array('date-and-time-functions', 'function_date_add'),
    'DATE_FORMAT': Array('date-and-time-functions', 'function_date_format'),
    'DATE_SUB': Array('date-and-time-functions', 'function_date_sub'),
    'DATE': Array('date-and-time-functions', 'function_date'),
    'DATEDIFF': Array('date-and-time-functions', 'function_datediff'),
    'DAY': Array('date-and-time-functions', 'function_day'),
    'DAYNAME': Array('date-and-time-functions', 'function_dayname'),
    'DAYOFMONTH': Array('date-and-time-functions', 'function_dayofmonth'),
    'DAYOFWEEK': Array('date-and-time-functions', 'function_dayofweek'),
    'DAYOFYEAR': Array('date-and-time-functions', 'function_dayofyear'),
    'DECLARE': Array('declare', 'declare'),
    'DECODE': Array('encryption-functions', 'function_decode'),
    'DEFAULT': Array('miscellaneous-functions', 'function_default'),
    'DEGREES': Array('mathematical-functions', 'function_degrees'),
    'DES_DECRYPT': Array('encryption-functions', 'function_des_decrypt'),
    'DES_ENCRYPT': Array('encryption-functions', 'function_des_encrypt'),
    'DIV': Array('arithmetic-functions', 'operator_div'),
    'ELT': Array('string-functions', 'function_elt'),
    'ENCODE': Array('encryption-functions', 'function_encode'),
    'ENCRYPT': Array('encryption-functions', 'function_encrypt'),
    'EXP': Array('mathematical-functions', 'function_exp'),
    'EXPORT_SET': Array('string-functions', 'function_export_set'),
    'EXTRACT': Array('date-and-time-functions', 'function_extract'),
    'ExtractValue': Array('xml-functions', 'function_extractvalue'),
    'FIELD': Array('string-functions', 'function_field'),
    'FIND_IN_SET': Array('string-functions', 'function_find_in_set'),
    'FLOOR': Array('mathematical-functions', 'function_floor'),
    'FORMAT': Array('string-functions', 'function_format'),
    'FOUND_ROWS': Array('information-functions', 'function_found_rows'),
    'FROM_DAYS': Array('date-and-time-functions', 'function_from_days'),
    'FROM_UNIXTIME': Array('date-and-time-functions', 'function_from_unixtime'),
    'GET_FORMAT': Array('date-and-time-functions', 'function_get_format'),
    'GET_LOCK': Array('miscellaneous-functions', 'function_get_lock'),
    'GREATEST': Array('comparison-operators', 'function_greatest'),
    'GROUP_CONCAT': Array('group-by-functions', 'function_group_concat'),
    'HEX': Array('string-functions', 'function_hex'),
    'HOUR': Array('date-and-time-functions', 'function_hour'),
    'IF': Array('control-flow-functions', 'function_if'),
    'IFNULL': Array('control-flow-functions', 'function_ifnull'),
    'IN': Array('comparison-operators', 'function_in'),
    'INET_ATON': Array('miscellaneous-functions', 'function_inet_aton'),
    'INET_NTOA': Array('miscellaneous-functions', 'function_inet_ntoa'),
    'INSTR': Array('string-functions', 'function_instr'),
    'INTERVAL': Array('comparison-operators', 'function_interval'),
    'IS_FREE_LOCK': Array('miscellaneous-functions', 'function_is_free_lock'),
    'IS_USED_LOCK': Array('miscellaneous-functions', 'function_is_used_lock'),
    'IS': Array('comparison-operators', 'operator_is'),
    'ISNULL': Array('comparison-operators', 'function_isnull'),
    'LAST_DAY': Array('date-and-time-functions', 'function_last_day'),
    'LAST_INSERT_ID': Array('information-functions', 'function_last_insert_id'),
    'LCASE': Array('string-functions', 'function_lcase'),
    'LEAST': Array('comparison-operators', 'function_least'),
    'LEFT': Array('string-functions', 'function_left'),
    'LENGTH': Array('string-functions', 'function_length'),
    'LIKE': Array('string-comparison-functions', 'operator_like'),
    'LN': Array('mathematical-functions', 'function_ln'),
    'LOAD_FILE': Array('string-functions', 'function_load_file'),
    'LOCALTIME': Array('date-and-time-functions', 'function_localtime'),
    'LOCALTIMESTAMP': Array('date-and-time-functions', 'function_localtimestamp'),
    'LOCATE': Array('string-functions', 'function_locate'),
    'LOG10': Array('mathematical-functions', 'function_log10'),
    'LOG2': Array('mathematical-functions', 'function_log2'),
    'LOG': Array('mathematical-functions', 'function_log'),
    'LOWER': Array('string-functions', 'function_lower'),
    'LPAD': Array('string-functions', 'function_lpad'),
    'LTRIM': Array('string-functions', 'function_ltrim'),
    'MAKE_SET': Array('string-functions', 'function_make_set'),
    'MAKEDATE': Array('date-and-time-functions', 'function_makedate'),
    'MAKETIME': Array('date-and-time-functions', 'function_maketime'),
    'MASTER_POS_WAIT': Array('miscellaneous-functions', 'function_master_pos_wait'),
    'MATCH': Array('fulltext-search', 'function_match'),
    'MAX': Array('group-by-functions', 'function_max'),
    'MD5': Array('encryption-functions', 'function_md5'),
    'MICROSECOND': Array('date-and-time-functions', 'function_microsecond'),
    'MID': Array('string-functions', 'function_mid'),
    'MIN': Array('group-by-functions', 'function_min'),
    'MINUTE': Array('date-and-time-functions', 'function_minute'),
    'MOD': Array('mathematical-functions', 'function_mod'),
    'MONTH': Array('date-and-time-functions', 'function_month'),
    'MONTHNAME': Array('date-and-time-functions', 'function_monthname'),
    'NAME_CONST': Array('miscellaneous-functions', 'function_name_const'),
    'NOT': Array('logical-operators', 'operator_not'),
    'NOW': Array('date-and-time-functions', 'function_now'),
    'NULLIF': Array('control-flow-functions', 'function_nullif'),
    'OCT': Array('mathematical-functions', 'function_oct'),
    'OCTET_LENGTH': Array('string-functions', 'function_octet_length'),
    'OLD_PASSWORD': Array('encryption-functions', 'function_old_password'),
    'OR': Array('logical-operators', 'operator_or'),
    'ORD': Array('string-functions', 'function_ord'),
    'PASSWORD': Array('encryption-functions', 'function_password'),
    'PERIOD_ADD': Array('date-and-time-functions', 'function_period_add'),
    'PERIOD_DIFF': Array('date-and-time-functions', 'function_period_diff'),
    'PI': Array('mathematical-functions', 'function_pi'),
    'POSITION': Array('string-functions', 'function_position'),
    'POW': Array('mathematical-functions', 'function_pow'),
    'POWER': Array('mathematical-functions', 'function_power'),
    'QUARTER': Array('date-and-time-functions', 'function_quarter'),
    'QUOTE': Array('string-functions', 'function_quote'),
    'RADIANS': Array('mathematical-functions', 'function_radians'),
    'RAND': Array('mathematical-functions', 'function_rand'),
    'REGEXP': Array('regexp', 'operator_regexp'),
    'RELEASE_LOCK': Array('miscellaneous-functions', 'function_release_lock'),
    'REPEAT': Array('string-functions', 'function_repeat'),
    'REVERSE': Array('string-functions', 'function_reverse'),
    'RIGHT': Array('string-functions', 'function_right'),
    'RLIKE': Array('regexp', 'operator_rlike'),
    'ROUND': Array('mathematical-functions', 'function_round'),
    'ROW_COUNT': Array('information-functions', 'function_row_count'),
    'RPAD': Array('string-functions', 'function_rpad'),
    'RTRIM': Array('string-functions', 'function_rtrim'),
    'SCHEMA': Array('information-functions', 'function_schema'),
    'SEC_TO_TIME': Array('date-and-time-functions', 'function_sec_to_time'),
    'SECOND': Array('date-and-time-functions', 'function_second'),
    'SESSION_USER': Array('information-functions', 'function_session_user'),
    'SHA': Array('encryption-functions', 'function_sha1'),
    'SHA1': Array('encryption-functions', 'function_sha1'),
    'SIGN': Array('mathematical-functions', 'function_sign'),
    'SIN': Array('mathematical-functions', 'function_sin'),
    'SLEEP': Array('miscellaneous-functions', 'function_sleep'),
    'SOUNDEX': Array('string-functions', 'function_soundex'),
    'SPACE': Array('string-functions', 'function_space'),
    'SQRT': Array('mathematical-functions', 'function_sqrt'),
    'STD': Array('group-by-functions', 'function_std'),
    'STDDEV_POP': Array('group-by-functions', 'function_stddev_pop'),
    'STDDEV_SAMP': Array('group-by-functions', 'function_stddev_samp'),
    'STDDEV': Array('group-by-functions', 'function_stddev'),
    'STR_TO_DATE': Array('date-and-time-functions', 'function_str_to_date'),
    'STRCMP': Array('string-comparison-functions', 'function_strcmp'),
    'SUBDATE': Array('date-and-time-functions', 'function_subdate'),
    'SUBSTR': Array('string-functions', 'function_substr'),
    'SUBSTRING_INDEX': Array('string-functions', 'function_substring_index'),
    'SUBSTRING': Array('string-functions', 'function_substring'),
    'SUBTIME': Array('date-and-time-functions', 'function_subtime'),
    'SUM': Array('group-by-functions', 'function_sum'),
    'SYSDATE': Array('date-and-time-functions', 'function_sysdate'),
    'SYSTEM_USER': Array('information-functions', 'function_system_user'),
    'TAN': Array('mathematical-functions', 'function_tan'),
    'TIME_FORMAT': Array('date-and-time-functions', 'function_time_format'),
    'TIME_TO_SEC': Array('date-and-time-functions', 'function_time_to_sec'),
    'TIME': Array('date-and-time-functions', 'function_time'),
    'TIMEDIFF': Array('date-and-time-functions', 'function_timediff'),
    'TIMESTAMP': Array('date-and-time-functions', 'function_timestamp'),
    'TIMESTAMPADD': Array('date-and-time-functions', 'function_timestampadd'),
    'TIMESTAMPDIFF': Array('date-and-time-functions', 'function_timestampdiff'),
    'TO_DAYS': Array('date-and-time-functions', 'function_to_days'),
    'TRIM': Array('string-functions', 'function_trim'),
    'TRUNCATE': Array('mathematical-functions', 'function_truncate'),
    'UCASE': Array('string-functions', 'function_ucase'),
    'UNCOMPRESS': Array('encryption-functions', 'function_uncompress'),
    'UNCOMPRESSED_LENGTH': Array('encryption-functions', 'function_uncompressed_length'),
    'UNHEX': Array('string-functions', 'function_unhex'),
    'UNIX_TIMESTAMP': Array('date-and-time-functions', 'function_unix_timestamp'),
    'UpdateXML': Array('xml-functions', 'function_updatexml'),
    'UPPER': Array('string-functions', 'function_upper'),
    'USER': Array('information-functions', 'function_user'),
    'UTC_DATE': Array('date-and-time-functions', 'function_utc_date'),
    'UTC_TIME': Array('date-and-time-functions', 'function_utc_time'),
    'UTC_TIMESTAMP': Array('date-and-time-functions', 'function_utc_timestamp'),
    'UUID_SHORT': Array('miscellaneous-functions', 'function_uuid_short'),
    'UUID': Array('miscellaneous-functions', 'function_uuid'),
    'VALUES': Array('miscellaneous-functions', 'function_values'),
    'VAR_POP': Array('group-by-functions', 'function_var_pop'),
    'VAR_SAMP': Array('group-by-functions', 'function_var_samp'),
    'VARIANCE': Array('group-by-functions', 'function_variance'),
    'VERSION': Array('information-functions', 'function_version'),
    'WEEK': Array('date-and-time-functions', 'function_week'),
    'WEEKDAY': Array('date-and-time-functions', 'function_weekday'),
    'WEEKOFYEAR': Array('date-and-time-functions', 'function_weekofyear'),
    'XOR': Array('logical-operators', 'operator_xor'),
    'YEAR': Array('date-and-time-functions', 'function_year'),
    'YEARWEEK': Array('date-and-time-functions', 'function_yearweek'),
    'SOUNDS_LIKE': Array('string-functions', 'operator_sounds-like'),
    'IS_NOT_NULL': Array('comparison-operators', 'operator_is-not-null'),
    'IS_NOT': Array('comparison-operators', 'operator_is-not'),
    'IS_NULL': Array('comparison-operators', 'operator_is-null'),
    'NOT_LIKE': Array('string-comparison-functions', 'operator_not-like'),
    'NOT_REGEXP': Array('regexp', 'operator_not-regexp'),
    'COUNT_DISTINCT': Array('group-by-functions', 'function_count-distinct'),
    'NOT_IN': Array('comparison-operators', 'function_not-in')
};

var mysql_doc_builtin = {
    'TINYINT': Array('numeric-types'),
    'SMALLINT': Array('numeric-types'),
    'MEDIUMINT': Array('numeric-types'),
    'INT': Array('numeric-types'),
    'BIGINT': Array('numeric-types'),
    'DECIMAL': Array('numeric-types'),
    'FLOAT': Array('numeric-types'),
    'DOUBLE': Array('numeric-types'),
    'REAL': Array('numeric-types'),
    'BIT': Array('numeric-types'),
    'BOOLEAN': Array('numeric-types'),
    'SERIAL': Array('numeric-types'),
    'DATE': Array('date-and-time-types'),
    'DATETIME': Array('date-and-time-types'),
    'TIMESTAMP': Array('date-and-time-types'),
    'TIME': Array('date-and-time-types'),
    'YEAR': Array('date-and-time-types'),
    'CHAR': Array('string-types'),
    'VARCHAR': Array('string-types'),
    'TINYTEXT': Array('string-types'),
    'TEXT': Array('string-types'),
    'MEDIUMTEXT': Array('string-types'),
    'LONGTEXT': Array('string-types'),
    'BINARY': Array('string-types'),
    'VARBINARY': Array('string-types'),
    'TINYBLOB': Array('string-types'),
    'MEDIUMBLOB': Array('string-types'),
    'BLOB': Array('string-types'),
    'LONGBLOB': Array('string-types'),
    'ENUM': Array('string-types'),
    'SET': Array('string-types')
};
;

/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * general function, usually for data manipulation pages
 *
 */

/**
 * @var sql_box_locked lock for the sqlbox textarea in the querybox
 */
var sql_box_locked = false;

/**
 * @var array holds elements which content should only selected once
 */
var only_once_elements = [];

/**
 * @var   int   ajax_message_count   Number of AJAX messages shown since page load
 */
var ajax_message_count = 0;

/**
 * @var codemirror_editor object containing CodeMirror editor of the query editor in SQL tab
 */
var codemirror_editor = false;

/**
 * @var codemirror_editor object containing CodeMirror editor of the inline query editor
 */
var codemirror_inline_editor = false;

/**
 * @var sql_autocomplete_in_progress bool shows if Table/Column name autocomplete AJAX is in progress
 */
var sql_autocomplete_in_progress = false;

/**
 * @var sql_autocomplete object containing list of columns in each table
 */
var sql_autocomplete = false;

/**
 * @var sql_autocomplete_default_table string containing default table to autocomplete columns
 */
var sql_autocomplete_default_table = '';

/**
 * @var central_column_list array to hold the columns in central list per db.
 */
var central_column_list = [];

/**
 * @var primary_indexes array to hold 'Primary' index columns.
 */
var primary_indexes = [];

/**
 * @var unique_indexes array to hold 'Unique' index columns.
 */
var unique_indexes = [];

/**
 * @var indexes array to hold 'Index' columns.
 */
var indexes = [];

/**
 * @var fulltext_indexes array to hold 'Fulltext' columns.
 */
var fulltext_indexes = [];

/**
 * @var spatial_indexes array to hold 'Spatial' columns.
 */
var spatial_indexes = [];

/**
 * Make sure that ajax requests will not be cached
 * by appending a random variable to their parameters
 */
$.ajaxPrefilter(function (options, originalOptions, jqXHR) {
    var nocache = new Date().getTime() + "" + Math.floor(Math.random() * 1000000);
    if (typeof options.data == "string") {
        options.data += "&_nocache=" + nocache;
    } else if (typeof options.data == "object") {
        options.data = $.extend(originalOptions.data, {'_nocache' : nocache});
    }
});

/*
 * Adds a date/time picker to an element
 *
 * @param object  $this_element   a jQuery object pointing to the element
 */
function PMA_addDatepicker($this_element, type, options)
{
    var showTimepicker = true;
    if (type=="date") {
        showTimepicker = false;
    }

    var defaultOptions = {
        showOn: 'button',
        buttonImage: themeCalendarImage, // defined in js/messages.php
        buttonImageOnly: true,
        stepMinutes: 1,
        stepHours: 1,
        showSecond: true,
        showMillisec: true,
        showMicrosec: true,
        showTimepicker: showTimepicker,
        showButtonPanel: false,
        dateFormat: 'yy-mm-dd', // yy means year with four digits
        timeFormat: 'HH:mm:ss.lc',
        constrainInput: false,
        altFieldTimeOnly: false,
        showAnim: '',
        beforeShow: function (input, inst) {
            // Remember that we came from the datepicker; this is used
            // in tbl_change.js by verificationsAfterFieldChange()
            $this_element.data('comes_from', 'datepicker');
            if ($(input).closest('.cEdit').length > 0) {
                setTimeout(function () {
                    inst.dpDiv.css({
                        top: 0,
                        left: 0,
                        position: 'relative'
                    });
                }, 0);
            }
            // Fix wrong timepicker z-index, doesn't work without timeout
            setTimeout(function () {
                $('#ui-timepicker-div').css('z-index', $('#ui-datepicker-div').css('z-index'));
            }, 0);
        },
        onSelect: function() {
            $this_element.data('datepicker').inline = true;
        },
        onClose: function (dateText, dp_inst) {
            // The value is no more from the date picker
            $this_element.data('comes_from', '');
            if (typeof $this_element.data('datepicker') !== 'undefined') {
                $this_element.data('datepicker').inline = false;
            }
        }
    };
    if (type == "datetime" || type == "timestamp") {
        $this_element.datetimepicker($.extend(defaultOptions, options));
    }
    else if (type == "date") {
        $this_element.datetimepicker($.extend(defaultOptions, options));
    }
    else if (type == "time") {
        $this_element.timepicker($.extend(defaultOptions, options));
        // Add a tip regarding entering MySQL allowed-values for TIME data-type
        PMA_tooltip($this_element, 'input', PMA_messages.strMysqlAllowedValuesTip);
    }
}

/**
 * Add a date/time picker to each element that needs it
 * (only when jquery-ui-timepicker-addon.js is loaded)
 */
function addDateTimePicker() {
    if ($.timepicker !== undefined) {
        $('input.timefield, input.datefield, input.datetimefield').each(function () {

            var decimals = $(this).parent().attr('data-decimals');
            var type = $(this).parent().attr('data-type');

            var showMillisec = false;
            var showMicrosec = false;
            var timeFormat = 'HH:mm:ss';
            // check for decimal places of seconds
            if (decimals > 0 && type.indexOf('time') != -1){
                if (decimals > 3) {
                    showMillisec = true;
                    showMicrosec = true;
                    timeFormat = 'HH:mm:ss.lc';
                } else {
                    showMillisec = true;
                    timeFormat = 'HH:mm:ss.l';
                }
            }
            PMA_addDatepicker($(this), type, {
                showMillisec: showMillisec,
                showMicrosec: showMicrosec,
                timeFormat: timeFormat
            });

            // Add a tip regarding entering MySQL allowed-values
            // for TIME and DATE data-type
            if ($(this).hasClass('timefield')) {
                PMA_tooltip($(this), 'input', PMA_messages.strMysqlAllowedValuesTipTime);
            } else if ($(this).hasClass('datefield')) {
                PMA_tooltip($(this), 'input', PMA_messages.strMysqlAllowedValuesTipDate);
            }
        });
    }
}

/**
 * Handle redirect and reload flags sent as part of AJAX requests
 *
 * @param data ajax response data
 */
function PMA_handleRedirectAndReload(data) {
    if (parseInt(data.redirect_flag) == 1) {
        // add one more GET param to display session expiry msg
        if (window.location.href.indexOf('?') === -1) {
            window.location.href += '?session_expired=1';
        } else {
            window.location.href += '&session_expired=1';
        }
        window.location.reload();
    } else if (parseInt(data.reload_flag) == 1) {
        // remove the token param and reload
        window.location.href = window.location.href.replace(/&?token=[^&#]*/g, "");
        window.location.reload();
    }
}

/**
 * Creates an SQL editor which supports auto completing etc.
 *
 * @param $textarea   jQuery object wrapping the textarea to be made the editor
 * @param options     optional options for CodeMirror
 * @param resize      optional resizing ('vertical', 'horizontal', 'both')
 * @param lintOptions additional options for lint
 */
function PMA_getSQLEditor($textarea, options, resize, lintOptions) {
    if ($textarea.length > 0 && typeof CodeMirror !== 'undefined') {

        // merge options for CodeMirror
        var defaults = {
            lineNumbers: true,
            matchBrackets: true,
            extraKeys: {"Ctrl-Space": "autocomplete"},
            hintOptions: {"completeSingle": false, "completeOnSingleClick": true},
            indentUnit: 4,
            mode: "text/x-mysql",
            lineWrapping: true
        };

        if (CodeMirror.sqlLint) {
            $.extend(defaults, {
                gutters: ["CodeMirror-lint-markers"],
                lint: {
                    "getAnnotations": CodeMirror.sqlLint,
                    "async": true,
                    "lintOptions": lintOptions
                }
            });
        }

        $.extend(true, defaults, options);

        // create CodeMirror editor
        var codemirrorEditor = CodeMirror.fromTextArea($textarea[0], defaults);
        // allow resizing
        if (! resize) {
            resize = 'vertical';
        }
        var handles = '';
        if (resize == 'vertical') {
            handles = 's';
        }
        if (resize == 'both') {
            handles = 'all';
        }
        if (resize == 'horizontal') {
            handles = 'e, w';
        }
        $(codemirrorEditor.getWrapperElement())
            .css('resize', resize)
            .resizable({
                handles: handles,
                resize: function() {
                    codemirrorEditor.setSize($(this).width(), $(this).height());
                }
            });
        // enable autocomplete
        codemirrorEditor.on("inputRead", codemirrorAutocompleteOnInputRead);

        return codemirrorEditor;
    }
    return null;
}

/**
 * Clear text selection
 */
function PMA_clearSelection() {
    if (document.selection && document.selection.empty) {
        document.selection.empty();
    } else if (window.getSelection) {
        var sel = window.getSelection();
        if (sel.empty) {
            sel.empty();
        }
        if (sel.removeAllRanges) {
            sel.removeAllRanges();
        }
    }
}

/**
 * Create a jQuery UI tooltip
 *
 * @param $elements     jQuery object representing the elements
 * @param item          the item
 *                      (see https://api.jqueryui.com/tooltip/#option-items)
 * @param myContent     content of the tooltip
 * @param additionalOptions to override the default options
 *
 */
function PMA_tooltip($elements, item, myContent, additionalOptions)
{
    if ($('#no_hint').length > 0) {
        return;
    }

    var defaultOptions = {
        content: myContent,
        items:  item,
        tooltipClass: "tooltip",
        track: true,
        show: false,
        hide: false
    };

    $elements.tooltip($.extend(true, defaultOptions, additionalOptions));
}

/**
 * HTML escaping
 */

function escapeHtml(unsafe) {
    if (typeof(unsafe) != 'undefined') {
        return unsafe
            .toString()
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    } else {
        return false;
    }
}

function escapeJsString(unsafe) {
    if (typeof(unsafe) != 'undefined') {
        return unsafe
            .toString()
            .replace("\000", '')
            .replace('\\', '\\\\')
            .replace('\'', '\\\'')
            .replace("&#039;", "\\\&#039;")
            .replace('"', '\"')
            .replace("&quot;", "\&quot;")
            .replace("\n", '\n')
            .replace("\r", '\r')
            .replace(/<\/script/gi, '</\' + \'script')
    } else {
        return false;
    }
}

function PMA_sprintf() {
    return sprintf.apply(this, arguments);
}

/**
 * Hides/shows the default value input field, depending on the default type
 * Ticks the NULL checkbox if NULL is chosen as default value.
 */
function PMA_hideShowDefaultValue($default_type)
{
    if ($default_type.val() == 'USER_DEFINED') {
        $default_type.siblings('.default_value').show().focus();
    } else {
        $default_type.siblings('.default_value').hide();
        if ($default_type.val() == 'NULL') {
            var $null_checkbox = $default_type.closest('tr').find('.allow_null');
            $null_checkbox.prop('checked', true);
        }
    }
}

/**
 * Hides/shows the input field for column expression based on whether
 * VIRTUAL/PERSISTENT is selected
 *
 * @param $virtuality virtuality dropdown
 */
function PMA_hideShowExpression($virtuality)
{
    if ($virtuality.val() === '') {
        $virtuality.siblings('.expression').hide();
    } else {
        $virtuality.siblings('.expression').show();
    }
}

/**
 * Show notices for ENUM columns; add/hide the default value
 *
 */
function PMA_verifyColumnsProperties()
{
    $("select.column_type").each(function () {
        PMA_showNoticeForEnum($(this));
    });
    $("select.default_type").each(function () {
        PMA_hideShowDefaultValue($(this));
    });
    $('select.virtuality').each(function () {
        PMA_hideShowExpression($(this));
    });
}

/**
 * Add a hidden field to the form to indicate that this will be an
 * Ajax request (only if this hidden field does not exist)
 *
 * @param $form object   the form
 */
function PMA_prepareForAjaxRequest($form)
{
    if (! $form.find('input:hidden').is('#ajax_request_hidden')) {
        $form.append('<input type="hidden" id="ajax_request_hidden" name="ajax_request" value="true" />');
    }
}

/**
 * Generate a new password and copy it to the password input areas
 *
 * @param passwd_form object   the form that holds the password fields
 *
 * @return boolean  always true
 */
function suggestPassword(passwd_form)
{
    // restrict the password to just letters and numbers to avoid problems:
    // "editors and viewers regard the password as multiple words and
    // things like double click no longer work"
    var pwchars = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWYXZ";
    var passwordlength = 16;    // do we want that to be dynamic?  no, keep it simple :)
    var passwd = passwd_form.generated_pw;
    var randomWords = new Int32Array(passwordlength);

    passwd.value = '';

    // First we're going to try to use a built-in CSPRNG
    if (window.crypto && window.crypto.getRandomValues) {
        window.crypto.getRandomValues(randomWords);
    }
    // Because of course IE calls it msCrypto instead of being standard
    else if (window.msCrypto && window.msCrypto.getRandomValues) {
        window.msCrypto.getRandomValues(randomWords);
    } else {
        // Fallback to Math.random
        for (var i = 0; i < passwordlength; i++) {
            randomWords[i] = Math.floor(Math.random() * pwchars.length);
        }
    }

    for (var i = 0; i < passwordlength; i++) {
        passwd.value += pwchars.charAt(Math.abs(randomWords[i]) % pwchars.length);
    }

    $jquery_passwd_form = $(passwd_form);

    passwd_form.elements['pma_pw'].value = passwd.value;
    passwd_form.elements['pma_pw2'].value = passwd.value;
    meter_obj = $jquery_passwd_form.find('meter[name="pw_meter"]').first();
    meter_obj_label = $jquery_passwd_form.find('span[name="pw_strength"]').first();
    checkPasswordStrength(passwd.value, meter_obj, meter_obj_label);
    return true;
}

/**
 * Version string to integer conversion.
 */
function parseVersionString(str)
{
    if (typeof(str) != 'string') { return false; }
    var add = 0;
    // Parse possible alpha/beta/rc/
    var state = str.split('-');
    if (state.length >= 2) {
        if (state[1].substr(0, 2) == 'rc') {
            add = - 20 - parseInt(state[1].substr(2), 10);
        } else if (state[1].substr(0, 4) == 'beta') {
            add =  - 40 - parseInt(state[1].substr(4), 10);
        } else if (state[1].substr(0, 5) == 'alpha') {
            add =  - 60 - parseInt(state[1].substr(5), 10);
        } else if (state[1].substr(0, 3) == 'dev') {
            /* We don't handle dev, it's git snapshot */
            add = 0;
        }
    }
    // Parse version
    var x = str.split('.');
    // Use 0 for non existing parts
    var maj = parseInt(x[0], 10) || 0;
    var min = parseInt(x[1], 10) || 0;
    var pat = parseInt(x[2], 10) || 0;
    var hotfix = parseInt(x[3], 10) || 0;
    return  maj * 100000000 + min * 1000000 + pat * 10000 + hotfix * 100 + add;
}

/**
 * Indicates current available version on main page.
 */
function PMA_current_version(data)
{
    if (data && data.version && data.date) {
        var current = parseVersionString($('span.version').text());
        var latest = parseVersionString(data.version);
        var url = 'https://web.phpmyadmin.net/files/' + escapeHtml(encodeURIComponent(data.version)) + '/';
        var version_information_message = document.createElement('span');
        version_information_message.className = 'latest';
        var version_information_message_link = document.createElement('a');
        version_information_message_link.href = url;
        version_information_message_link.className = 'disableAjax';
        version_information_message_link_text = document.createTextNode(data.version);
        version_information_message_link.appendChild(version_information_message_link_text);
        var prefix_message = document.createTextNode(PMA_messages.strLatestAvailable + ' ');
        version_information_message.appendChild(prefix_message);
        version_information_message.appendChild(version_information_message_link);
        if (latest > current) {
            var message = PMA_sprintf(
                PMA_messages.strNewerVersion,
                escapeHtml(data.version),
                escapeHtml(data.date)
            );
            var htmlClass = 'notice';
            if (Math.floor(latest / 10000) === Math.floor(current / 10000)) {
                /* Security update */
                htmlClass = 'error';
            }
            $('#newer_version_notice').remove();
            var maincontainer_div = document.createElement('div');
            maincontainer_div.id = 'newer_version_notice';
            maincontainer_div.className = htmlClass;
            var maincontainer_div_link = document.createElement('a');
            maincontainer_div_link.href = url;
            maincontainer_div_link.className = 'disableAjax';
            maincontainer_div_link_text = document.createTextNode(message);
            maincontainer_div_link.appendChild(maincontainer_div_link_text);
            maincontainer_div.appendChild(maincontainer_div_link);
            $('#maincontainer').append($(maincontainer_div));
        }
        if (latest === current) {
            version_information_message = document.createTextNode(' (' + PMA_messages.strUpToDate + ')');
        }
        /* Remove extra whitespace */
        var version_info = $('#li_pma_version').contents().get(2);
        version_info.textContent = $.trim(version_info.textContent);
        var $liPmaVersion = $('#li_pma_version');
        $liPmaVersion.find('span.latest').remove();
        $liPmaVersion.append($(version_information_message));
    }
}

/**
 * Loads Git revision data from ajax for index.php
 */
function PMA_display_git_revision()
{
    $('#is_git_revision').remove();
    $('#li_pma_version_git').remove();
    $.get(
        "index.php",
        {
            "server": PMA_commonParams.get('server'),
            "token": PMA_commonParams.get('token'),
            "git_revision": true,
            "ajax_request": true,
            "no_debug": true
        },
        function (data) {
            if (typeof data !== 'undefined' && data.success === true) {
                $(data.message).insertAfter('#li_pma_version');
            }
        }
    );
}

/**
 * for libraries/display_change_password.lib.php
 *     libraries/user_password.php
 *
 */

function displayPasswordGenerateButton()
{
    $('#tr_element_before_generate_password').parent().append('<tr class="vmiddle"><td>' + PMA_messages.strGeneratePassword + '</td><td><input type="button" class="button" id="button_generate_password" value="' + PMA_messages.strGenerate + '" onclick="suggestPassword(this.form)" /><input type="text" name="generated_pw" id="generated_pw" /></td></tr>');
    $('#div_element_before_generate_password').parent().append('<div class="item"><label for="button_generate_password">' + PMA_messages.strGeneratePassword + ':</label><span class="options"><input type="button" class="button" id="button_generate_password" value="' + PMA_messages.strGenerate + '" onclick="suggestPassword(this.form)" /></span><input type="text" name="generated_pw" id="generated_pw" /></div>');
}

/**
 * selects the content of a given object, f.e. a textarea
 *
 * @param element     object  element of which the content will be selected
 * @param lock        var     variable which holds the lock for this element
 *                              or true, if no lock exists
 * @param only_once   boolean if true this is only done once
 *                              f.e. only on first focus
 */
function selectContent(element, lock, only_once)
{
    if (only_once && only_once_elements[element.name]) {
        return;
    }

    only_once_elements[element.name] = true;

    if (lock) {
        return;
    }

    element.select();
}

/**
 * Displays a confirmation box before submitting a "DROP/DELETE/ALTER" query.
 * This function is called while clicking links
 *
 * @param theLink     object the link
 * @param theSqlQuery object the sql query to submit
 *
 * @return boolean  whether to run the query or not
 */
function confirmLink(theLink, theSqlQuery)
{
    // Confirmation is not required in the configuration file
    // or browser is Opera (crappy js implementation)
    if (PMA_messages.strDoYouReally === '' || typeof(window.opera) != 'undefined') {
        return true;
    }

    var is_confirmed = confirm(PMA_sprintf(PMA_messages.strDoYouReally, theSqlQuery));
    if (is_confirmed) {
        if ($(theLink).hasClass('formLinkSubmit')) {
            var name = 'is_js_confirmed';

            if ($(theLink).attr('href').indexOf('usesubform') != -1) {
                var matches = $(theLink).attr('href').substr('#').match(/usesubform\[(\d+)\]/i);
                if (matches != null) {
                    name = 'subform[' + matches[1] + '][is_js_confirmed]';
                }
            }

            $(theLink).parents('form').append('<input type="hidden" name="' + name + '" value="1" />');
        } else if (typeof(theLink.href) != 'undefined') {
            theLink.href += '&is_js_confirmed=1';
        } else if (typeof(theLink.form) != 'undefined') {
            theLink.form.action += '?is_js_confirmed=1';
        }
    }

    return is_confirmed;
} // end of the 'confirmLink()' function

/**
 * Confirms a "DROP/DELETE/ALTER" query before
 * submitting it if required.
 * This function is called by the 'checkSqlQuery()' js function.
 *
 * @param theForm1 object   the form
 * @param sqlQuery1 string  the sql query string
 *
 * @return boolean  whether to run the query or not
 *
 * @see     checkSqlQuery()
 */
function confirmQuery(theForm1, sqlQuery1)
{
    // Confirmation is not required in the configuration file
    if (PMA_messages.strDoYouReally === '') {
        return true;
    }

    // Confirms a "DROP/DELETE/ALTER/TRUNCATE" statement
    //
    // TODO: find a way (if possible) to use the parser-analyser
    // for this kind of verification
    // For now, I just added a ^ to check for the statement at
    // beginning of expression

    var do_confirm_re_0 = new RegExp('^\\s*DROP\\s+(IF EXISTS\\s+)?(TABLE|PROCEDURE)\\s', 'i');
    var do_confirm_re_1 = new RegExp('^\\s*ALTER\\s+TABLE\\s+((`[^`]+`)|([A-Za-z0-9_$]+))\\s+DROP\\s', 'i');
    var do_confirm_re_2 = new RegExp('^\\s*DELETE\\s+FROM\\s', 'i');
    var do_confirm_re_3 = new RegExp('^\\s*TRUNCATE\\s', 'i');

    if (do_confirm_re_0.test(sqlQuery1) ||
        do_confirm_re_1.test(sqlQuery1) ||
        do_confirm_re_2.test(sqlQuery1) ||
        do_confirm_re_3.test(sqlQuery1)) {
        var message;
        if (sqlQuery1.length > 100) {
            message = sqlQuery1.substr(0, 100) + '\n    ...';
        } else {
            message = sqlQuery1;
        }
        var is_confirmed = confirm(PMA_sprintf(PMA_messages.strDoYouReally, message));
        // statement is confirmed -> update the
        // "is_js_confirmed" form field so the confirm test won't be
        // run on the server side and allows to submit the form
        if (is_confirmed) {
            theForm1.elements.is_js_confirmed.value = 1;
            return true;
        }
        // statement is rejected -> do not submit the form
        else {
            window.focus();
            return false;
        } // end if (handle confirm box result)
    } // end if (display confirm box)

    return true;
} // end of the 'confirmQuery()' function

/**
 * Displays an error message if the user submitted the sql query form with no
 * sql query, else checks for "DROP/DELETE/ALTER" statements
 *
 * @param theForm object the form
 *
 * @return boolean  always false
 *
 * @see     confirmQuery()
 */
function checkSqlQuery(theForm)
{
    // get the textarea element containing the query
    var sqlQuery;
    if (codemirror_editor) {
        codemirror_editor.save();
        sqlQuery = codemirror_editor.getValue();
    } else {
        sqlQuery = theForm.elements.sql_query.value;
    }
    var space_re = new RegExp('\\s+');
    if (typeof(theForm.elements.sql_file) != 'undefined' &&
            theForm.elements.sql_file.value.replace(space_re, '') !== '') {
        return true;
    }
    if (typeof(theForm.elements.id_bookmark) != 'undefined' &&
            (theForm.elements.id_bookmark.value !== null || theForm.elements.id_bookmark.value !== '') &&
            theForm.elements.id_bookmark.selectedIndex !== 0) {
        return true;
    }
    var result = false;
    // Checks for "DROP/DELETE/ALTER" statements
    if (sqlQuery.replace(space_re, '') !== '') {
        result = confirmQuery(theForm, sqlQuery);
    } else {
        alert(PMA_messages.strFormEmpty);
    }

    if (codemirror_editor) {
        codemirror_editor.focus();
    } else if (codemirror_inline_editor) {
        codemirror_inline_editor.focus();
    }
    return result;
} // end of the 'checkSqlQuery()' function

/**
 * Check if a form's element is empty.
 * An element containing only spaces is also considered empty
 *
 * @param object   the form
 * @param string   the name of the form field to put the focus on
 *
 * @return boolean  whether the form field is empty or not
 */
function emptyCheckTheField(theForm, theFieldName)
{
    var theField = theForm.elements[theFieldName];
    var space_re = new RegExp('\\s+');
    return theField.value.replace(space_re, '') === '';
} // end of the 'emptyCheckTheField()' function

/**
 * Ensures a value submitted in a form is numeric and is in a range
 *
 * @param object   the form
 * @param string   the name of the form field to check
 * @param integer  the minimum authorized value
 * @param integer  the maximum authorized value
 *
 * @return boolean  whether a valid number has been submitted or not
 */
function checkFormElementInRange(theForm, theFieldName, message, min, max)
{
    var theField         = theForm.elements[theFieldName];
    var val              = parseInt(theField.value, 10);

    if (typeof(min) == 'undefined') {
        min = 0;
    }
    if (typeof(max) == 'undefined') {
        max = Number.MAX_VALUE;
    }

    // It's not a number
    if (isNaN(val)) {
        theField.select();
        alert(PMA_messages.strEnterValidNumber);
        theField.focus();
        return false;
    }
    // It's a number but it is not between min and max
    else if (val < min || val > max) {
        theField.select();
        alert(PMA_sprintf(message, val));
        theField.focus();
        return false;
    }
    // It's a valid number
    else {
        theField.value = val;
    }
    return true;

} // end of the 'checkFormElementInRange()' function


function checkTableEditForm(theForm, fieldsCnt)
{
    // TODO: avoid sending a message if user just wants to add a line
    // on the form but has not completed at least one field name

    var atLeastOneField = 0;
    var i, elm, elm2, elm3, val, id;

    for (i = 0; i < fieldsCnt; i++) {
        id = "#field_" + i + "_2";
        elm = $(id);
        val = elm.val();
        if (val == 'VARCHAR' || val == 'CHAR' || val == 'BIT' || val == 'VARBINARY' || val == 'BINARY') {
            elm2 = $("#field_" + i + "_3");
            val = parseInt(elm2.val(), 10);
            elm3 = $("#field_" + i + "_1");
            if (isNaN(val) && elm3.val() !== "") {
                elm2.select();
                alert(PMA_messages.strEnterValidLength);
                elm2.focus();
                return false;
            }
        }

        if (atLeastOneField === 0) {
            id = "field_" + i + "_1";
            if (!emptyCheckTheField(theForm, id)) {
                atLeastOneField = 1;
            }
        }
    }
    if (atLeastOneField === 0) {
        var theField = theForm.elements.field_0_1;
        alert(PMA_messages.strFormEmpty);
        theField.focus();
        return false;
    }

    // at least this section is under jQuery
    var $input = $("input.textfield[name='table']");
    if ($input.val() === "") {
        alert(PMA_messages.strFormEmpty);
        $input.focus();
        return false;
    }

    return true;
} // enf of the 'checkTableEditForm()' function

/**
 * True if last click is to check a row.
 */
var last_click_checked = false;

/**
 * Zero-based index of last clicked row.
 * Used to handle the shift + click event in the code above.
 */
var last_clicked_row = -1;

/**
 * Zero-based index of last shift clicked row.
 */
var last_shift_clicked_row = -1;

var _idleSecondsCounter = 0;
var IncInterval;
var updateTimeout;
AJAX.registerTeardown('functions.js', function () {
    clearTimeout(updateTimeout);
    clearInterval(IncInterval);
    $(document).off('mousemove');
});

AJAX.registerOnload('functions.js', function () {
    document.onclick = function() {
        _idleSecondsCounter = 0;
    };
    $(document).on('mousemove',function() {
        _idleSecondsCounter = 0;
    });
    document.onkeypress = function() {
        _idleSecondsCounter = 0;
    };
    function guid() {
        function s4() {
            return Math.floor((1 + Math.random()) * 0x10000)
                .toString(16)
            .substring(1);
        }
        return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
            s4() + '-' + s4() + s4() + s4();
    }

    function SetIdleTime() {
        _idleSecondsCounter++;
    }
    function UpdateIdleTime() {
        var href = 'index.php';
        var guid = 'default';
        if (isStorageSupported('sessionStorage')) {
            guid = window.sessionStorage.guid;
        }
        var params = {
                'ajax_request' : true,
                'token' : PMA_commonParams.get('token'),
                'server' : PMA_commonParams.get('server'),
                'db' : PMA_commonParams.get('db'),
                'guid': guid,
                'access_time':_idleSecondsCounter
            };
        $.ajax({
                type: 'POST',
                url: href,
                data: params,
                success: function (data) {
                    if (data.success) {
                        if (PMA_commonParams.get('LoginCookieValidity') - _idleSecondsCounter < 0) {
                            /* There is other active window, let's reset counter */
                            _idleSecondsCounter = 0;
                        }
                        var remaining = Math.min(
                            /* Remaining login validity */
                            PMA_commonParams.get('LoginCookieValidity') - _idleSecondsCounter,
                            /* Remaining time till session GC */
                            PMA_commonParams.get('session_gc_maxlifetime')
                        );
                        var interval = 1000;
                        if (remaining > 5) {
                            // max value for setInterval() function
                            interval = Math.min((remaining - 1) * 1000, Math.pow(2, 31) - 1);
                        }
                        updateTimeout = window.setTimeout(UpdateIdleTime, interval);
                    } else { //timeout occurred
                        clearInterval(IncInterval);
                        if (isStorageSupported('sessionStorage')){
                            window.sessionStorage.clear();
                        }
                        window.location.reload(true);
                    }
                }
            });
    }
    if (PMA_commonParams.get('logged_in')) {
        IncInterval = window.setInterval(SetIdleTime, 1000);
        var session_timeout = Math.min(
            PMA_commonParams.get('LoginCookieValidity'),
            PMA_commonParams.get('session_gc_maxlifetime')
        );
        if (isStorageSupported('sessionStorage')) {
            window.sessionStorage.setItem('guid', guid());
        }
        var interval = (session_timeout - 5) * 1000;
        if (interval > Math.pow(2, 31) - 1) { // max value for setInterval() function
            interval = Math.pow(2, 31) - 1;
        }
        updateTimeout = window.setTimeout(UpdateIdleTime, interval);
    }
});
/**
 * Unbind all event handlers before tearing down a page
 */
AJAX.registerTeardown('functions.js', function () {
    $(document).off('click', 'input:checkbox.checkall');
});
AJAX.registerOnload('functions.js', function () {
    /**
     * Row marking in horizontal mode (use "on" so that it works also for
     * next pages reached via AJAX); a tr may have the class noclick to remove
     * this behavior.
     */

    $(document).on('click', 'input:checkbox.checkall', function (e) {
        $this = $(this);
        var $tr = $this.closest('tr');
        var $table = $this.closest('table');

        if (!e.shiftKey || last_clicked_row == -1) {
            // usual click

            var $checkbox = $tr.find(':checkbox.checkall');
            var checked = $this.prop('checked');
            $checkbox.prop('checked', checked).trigger('change');
            if (checked) {
                $tr.addClass('marked');
            } else {
                $tr.removeClass('marked');
            }
            last_click_checked = checked;

            // remember the last clicked row
            last_clicked_row = last_click_checked ? $table.find('tr:not(.noclick)').index($tr) : -1;
            last_shift_clicked_row = -1;
        } else {
            // handle the shift click
            PMA_clearSelection();
            var start, end;

            // clear last shift click result
            if (last_shift_clicked_row >= 0) {
                if (last_shift_clicked_row >= last_clicked_row) {
                    start = last_clicked_row;
                    end = last_shift_clicked_row;
                } else {
                    start = last_shift_clicked_row;
                    end = last_clicked_row;
                }
                $tr.parent().find('tr:not(.noclick)')
                    .slice(start, end + 1)
                    .removeClass('marked')
                    .find(':checkbox')
                    .prop('checked', false)
                    .trigger('change');
            }

            // handle new shift click
            var curr_row = $table.find('tr:not(.noclick)').index($tr);
            if (curr_row >= last_clicked_row) {
                start = last_clicked_row;
                end = curr_row;
            } else {
                start = curr_row;
                end = last_clicked_row;
            }
            $tr.parent().find('tr:not(.noclick)')
                .slice(start, end + 1)
                .addClass('marked')
                .find(':checkbox')
                .prop('checked', true)
                .trigger('change');

            // remember the last shift clicked row
            last_shift_clicked_row = curr_row;
        }
    });

    addDateTimePicker();

    /**
     * Add attribute to text boxes for iOS devices (based on bugID: 3508912)
     */
    if (navigator.userAgent.match(/(iphone|ipod|ipad)/i)) {
        $('input[type=text]').attr('autocapitalize', 'off').attr('autocorrect', 'off');
    }
});

/**
 * Row highlighting in horizontal mode (use "on"
 * so that it works also for pages reached via AJAX)
 */
/*AJAX.registerOnload('functions.js', function () {
    $(document).on('hover', 'tr',function (event) {
        var $tr = $(this);
        $tr.toggleClass('hover',event.type=='mouseover');
        $tr.children().toggleClass('hover',event.type=='mouseover');
    });
})*/

/**
 * marks all rows and selects its first checkbox inside the given element
 * the given element is usually a table or a div containing the table or tables
 *
 * @param container    DOM element
 */
function markAllRows(container_id)
{

    $("#" + container_id).find("input:checkbox:enabled").prop('checked', true)
    .trigger("change")
    .parents("tr").addClass("marked");
    return true;
}

/**
 * marks all rows and selects its first checkbox inside the given element
 * the given element is usually a table or a div containing the table or tables
 *
 * @param container    DOM element
 */
function unMarkAllRows(container_id)
{

    $("#" + container_id).find("input:checkbox:enabled").prop('checked', false)
    .trigger("change")
    .parents("tr").removeClass("marked");
    return true;
}

/**
  * Checks/unchecks all options of a <select> element
  *
  * @param string   the form name
  * @param string   the element name
  * @param boolean  whether to check or to uncheck options
  *
  * @return boolean  always true
  */
function setSelectOptions(the_form, the_select, do_check)
{
    $("form[name='" + the_form + "'] select[name='" + the_select + "']").find("option").prop('selected', do_check);
    return true;
} // end of the 'setSelectOptions()' function

/**
 * Sets current value for query box.
 */
function setQuery(query)
{
    if (codemirror_editor) {
        codemirror_editor.setValue(query);
        codemirror_editor.focus();
    } else {
        document.sqlform.sql_query.value = query;
        document.sqlform.sql_query.focus();
    }
}

/**
 * Handles 'Simulate query' button on SQL query box.
 *
 * @return void
 */
function PMA_handleSimulateQueryButton()
{
    var update_re = new RegExp('^\\s*UPDATE\\s+((`[^`]+`)|([A-Za-z0-9_$]+))\\s+SET\\s', 'i');
    var delete_re = new RegExp('^\\s*DELETE\\s+FROM\\s', 'i');
    var query = '';

    if (codemirror_editor) {
        query = codemirror_editor.getValue();
    } else {
        query = $('#sqlquery').val();
    }

    var $simulateDml = $('#simulate_dml');
    if (update_re.test(query) || delete_re.test(query)) {
        if (! $simulateDml.length) {
            $('#button_submit_query')
            .before('<input type="button" id="simulate_dml"' +
                'tabindex="199" value="' +
                PMA_messages.strSimulateDML +
                '" />');
        }
    } else {
        if ($simulateDml.length) {
            $simulateDml.remove();
        }
    }
}

/**
  * Create quick sql statements.
  *
  */
function insertQuery(queryType)
{
    if (queryType == "clear") {
        setQuery('');
        return;
    } else if (queryType == "format") {
        if (codemirror_editor) {
            $('#querymessage').html(PMA_messages.strFormatting +
                '&nbsp;<img class="ajaxIcon" src="' +
                pmaThemeImage + 'ajax_clock_small.gif" alt="">');
            var href = 'db_sql_format.php';
            var params = {
                'ajax_request': true,
                'token': PMA_commonParams.get('token'),
                'sql': codemirror_editor.getValue()
            };
            $.ajax({
                type: 'POST',
                url: href,
                data: params,
                success: function (data) {
                    if (data.success) {
                        codemirror_editor.setValue(data.sql);
                    }
                    $('#querymessage').html('');
                }
            });
        }
        return;
    } else if (queryType == "saved") {
        if (isStorageSupported('localStorage') && typeof window.localStorage.auto_saved_sql != 'undefined') {
            setQuery(window.localStorage.auto_saved_sql);
        } else if ($.cookie('auto_saved_sql')) {
            setQuery($.cookie('auto_saved_sql'));
        } else {
            PMA_ajaxShowMessage(PMA_messages.strNoAutoSavedQuery);
        }
        return;
    }

    var query = "";
    var myListBox = document.sqlform.dummy;
    var table = document.sqlform.table.value;

    if (myListBox.options.length > 0) {
        sql_box_locked = true;
        var columnsList = "";
        var valDis = "";
        var editDis = "";
        var NbSelect = 0;
        for (var i = 0; i < myListBox.options.length; i++) {
            NbSelect++;
            if (NbSelect > 1) {
                columnsList += ", ";
                valDis += ",";
                editDis += ",";
            }
            columnsList += myListBox.options[i].value;
            valDis += "[value-" + NbSelect + "]";
            editDis += myListBox.options[i].value + "=[value-" + NbSelect + "]";
        }
        if (queryType == "selectall") {
            query = "SELECT * FROM `" + table + "` WHERE 1";
        } else if (queryType == "select") {
            query = "SELECT " + columnsList + " FROM `" + table + "` WHERE 1";
        } else if (queryType == "insert") {
            query = "INSERT INTO `" + table + "`(" + columnsList + ") VALUES (" + valDis + ")";
        } else if (queryType == "update") {
            query = "UPDATE `" + table + "` SET " + editDis + " WHERE 1";
        } else if (queryType == "delete") {
            query = "DELETE FROM `" + table + "` WHERE 0";
        }
        setQuery(query);
        sql_box_locked = false;
    }
}


/**
  * Inserts multiple fields.
  *
  */
function insertValueQuery()
{
    var myQuery = document.sqlform.sql_query;
    var myListBox = document.sqlform.dummy;

    if (myListBox.options.length > 0) {
        sql_box_locked = true;
        var columnsList = "";
        var NbSelect = 0;
        for (var i = 0; i < myListBox.options.length; i++) {
            if (myListBox.options[i].selected) {
                NbSelect++;
                if (NbSelect > 1) {
                    columnsList += ", ";
                }
                columnsList += myListBox.options[i].value;
            }
        }

        /* CodeMirror support */
        if (codemirror_editor) {
            codemirror_editor.replaceSelection(columnsList);
        //IE support
        } else if (document.selection) {
            myQuery.focus();
            var sel = document.selection.createRange();
            sel.text = columnsList;
            document.sqlform.insert.focus();
        }
        //MOZILLA/NETSCAPE support
        else if (document.sqlform.sql_query.selectionStart || document.sqlform.sql_query.selectionStart == "0") {
            var startPos = document.sqlform.sql_query.selectionStart;
            var endPos = document.sqlform.sql_query.selectionEnd;
            var SqlString = document.sqlform.sql_query.value;

            myQuery.value = SqlString.substring(0, startPos) + columnsList + SqlString.substring(endPos, SqlString.length);
        } else {
            myQuery.value += columnsList;
        }
        sql_box_locked = false;
    }
}

/**
 * Updates the input fields for the parameters based on the query
 */
function updateQueryParameters() {

    if ($('#parameterized').is(':checked')) {
        var query = codemirror_editor ? codemirror_editor.getValue() : $('#sqlquery').val();

        var allParameters = query.match(/:[a-zA-Z0-9_]+/g);
        var parameters = [];
        // get unique parameters
        if (allParameters) {
            $.each(allParameters, function(i, parameter){
                if ($.inArray(parameter, parameters) === -1) {
                    parameters.push(parameter);
                }
            });
        } else {
            $('#parametersDiv').text(PMA_messages.strNoParam);
            return;
        }

        var $temp = $('<div />');
        $temp.append($('#parametersDiv').children());
        $('#parametersDiv').empty();

        $.each(parameters, function (i, parameter) {
            var paramName = parameter.substring(1);
            var $param = $temp.find('#paramSpan_' + paramName );
            if (! $param.length) {
                $param = $('<span class="parameter" id="paramSpan_' + paramName + '" />');
                $('<label for="param_' + paramName + '" />').text(parameter).appendTo($param);
                $('<input type="text" name="parameters[' + parameter + ']" id="param_' + paramName + '" />').appendTo($param);
            }
            $('#parametersDiv').append($param);
        });
    } else {
        $('#parametersDiv').empty();
    }
}

/**
  * Refresh/resize the WYSIWYG scratchboard
  */
function refreshLayout()
{
    var $elm = $('#pdflayout');
    var orientation = $('#orientation_opt').val();
    var paper = 'A4';
    var $paperOpt = $('#paper_opt');
    if ($paperOpt.length == 1) {
        paper = $paperOpt.val();
    }
    var posa = 'y';
    var posb = 'x';
    if (orientation == 'P') {
        posa = 'x';
        posb = 'y';
    }
    $elm.css('width', pdfPaperSize(paper, posa) + 'px');
    $elm.css('height', pdfPaperSize(paper, posb) + 'px');
}

/**
 * Initializes positions of elements.
 */
function TableDragInit() {
    $('.pdflayout_table').each(function () {
        var $this = $(this);
        var number = $this.data('number');
        var x = $('#c_table_' + number + '_x').val();
        var y = $('#c_table_' + number + '_y').val();
        $this.css('left', x + 'px');
        $this.css('top', y + 'px');
        /* Make elements draggable */
        $this.draggable({
            containment: "parent",
            drag: function (evt, ui) {
                var number = $this.data('number');
                $('#c_table_' + number + '_x').val(parseInt(ui.position.left, 10));
                $('#c_table_' + number + '_y').val(parseInt(ui.position.top, 10));
            }
        });
    });
}

/**
 * Resets drag and drop positions.
 */
function resetDrag() {
    $('.pdflayout_table').each(function () {
        var $this = $(this);
        var x = $this.data('x');
        var y = $this.data('y');
        $this.css('left', x + 'px');
        $this.css('top', y + 'px');
    });
}

/**
 * User schema handlers.
 */
$(function () {
    /* Move in scratchboard on manual change */
    $(document).on('change', '.position-change', function () {
        var $this = $(this);
        var $elm = $('#table_' + $this.data('number'));
        $elm.css($this.data('axis'), $this.val() + 'px');
    });
    /* Refresh on paper size/orientation change */
    $(document).on('change', '.paper-change', function () {
        var $elm = $('#pdflayout');
        if ($elm.css('visibility') == 'visible') {
            refreshLayout();
            TableDragInit();
        }
    });
    /* Show/hide the WYSIWYG scratchboard */
    $(document).on('click', '#toggle-dragdrop', function () {
        var $elm = $('#pdflayout');
        if ($elm.css('visibility') == 'hidden') {
            refreshLayout();
            TableDragInit();
            $elm.css('visibility', 'visible');
            $elm.css('display', 'block');
            $('#showwysiwyg').val('1');
        } else {
            $elm.css('visibility', 'hidden');
            $elm.css('display', 'none');
            $('#showwysiwyg').val('0');
        }
    });
    /* Reset scratchboard */
    $(document).on('click', '#reset-dragdrop', function () {
        resetDrag();
    });
});

/**
 * Returns paper sizes for a given format
 */
function pdfPaperSize(format, axis)
{
    switch (format.toUpperCase()) {
    case '4A0':
        if (axis == 'x') {
            return 4767.87;
        } else {
            return 6740.79;
        }
        break;
    case '2A0':
        if (axis == 'x') {
            return 3370.39;
        } else {
            return 4767.87;
        }
        break;
    case 'A0':
        if (axis == 'x') {
            return 2383.94;
        } else {
            return 3370.39;
        }
        break;
    case 'A1':
        if (axis == 'x') {
            return 1683.78;
        } else {
            return 2383.94;
        }
        break;
    case 'A2':
        if (axis == 'x') {
            return 1190.55;
        } else {
            return 1683.78;
        }
        break;
    case 'A3':
        if (axis == 'x') {
            return 841.89;
        } else {
            return 1190.55;
        }
        break;
    case 'A4':
        if (axis == 'x') {
            return 595.28;
        } else {
            return 841.89;
        }
        break;
    case 'A5':
        if (axis == 'x') {
            return 419.53;
        } else {
            return 595.28;
        }
        break;
    case 'A6':
        if (axis == 'x') {
            return 297.64;
        } else {
            return 419.53;
        }
        break;
    case 'A7':
        if (axis == 'x') {
            return 209.76;
        } else {
            return 297.64;
        }
        break;
    case 'A8':
        if (axis == 'x') {
            return 147.40;
        } else {
            return 209.76;
        }
        break;
    case 'A9':
        if (axis == 'x') {
            return 104.88;
        } else {
            return 147.40;
        }
        break;
    case 'A10':
        if (axis == 'x') {
            return 73.70;
        } else {
            return 104.88;
        }
        break;
    case 'B0':
        if (axis == 'x') {
            return 2834.65;
        } else {
            return 4008.19;
        }
        break;
    case 'B1':
        if (axis == 'x') {
            return 2004.09;
        } else {
            return 2834.65;
        }
        break;
    case 'B2':
        if (axis == 'x') {
            return 1417.32;
        } else {
            return 2004.09;
        }
        break;
    case 'B3':
        if (axis == 'x') {
            return 1000.63;
        } else {
            return 1417.32;
        }
        break;
    case 'B4':
        if (axis == 'x') {
            return 708.66;
        } else {
            return 1000.63;
        }
        break;
    case 'B5':
        if (axis == 'x') {
            return 498.90;
        } else {
            return 708.66;
        }
        break;
    case 'B6':
        if (axis == 'x') {
            return 354.33;
        } else {
            return 498.90;
        }
        break;
    case 'B7':
        if (axis == 'x') {
            return 249.45;
        } else {
            return 354.33;
        }
        break;
    case 'B8':
        if (axis == 'x') {
            return 175.75;
        } else {
            return 249.45;
        }
        break;
    case 'B9':
        if (axis == 'x') {
            return 124.72;
        } else {
            return 175.75;
        }
        break;
    case 'B10':
        if (axis == 'x') {
            return 87.87;
        } else {
            return 124.72;
        }
        break;
    case 'C0':
        if (axis == 'x') {
            return 2599.37;
        } else {
            return 3676.54;
        }
        break;
    case 'C1':
        if (axis == 'x') {
            return 1836.85;
        } else {
            return 2599.37;
        }
        break;
    case 'C2':
        if (axis == 'x') {
            return 1298.27;
        } else {
            return 1836.85;
        }
        break;
    case 'C3':
        if (axis == 'x') {
            return 918.43;
        } else {
            return 1298.27;
        }
        break;
    case 'C4':
        if (axis == 'x') {
            return 649.13;
        } else {
            return 918.43;
        }
        break;
    case 'C5':
        if (axis == 'x') {
            return 459.21;
        } else {
            return 649.13;
        }
        break;
    case 'C6':
        if (axis == 'x') {
            return 323.15;
        } else {
            return 459.21;
        }
        break;
    case 'C7':
        if (axis == 'x') {
            return 229.61;
        } else {
            return 323.15;
        }
        break;
    case 'C8':
        if (axis == 'x') {
            return 161.57;
        } else {
            return 229.61;
        }
        break;
    case 'C9':
        if (axis == 'x') {
            return 113.39;
        } else {
            return 161.57;
        }
        break;
    case 'C10':
        if (axis == 'x') {
            return 79.37;
        } else {
            return 113.39;
        }
        break;
    case 'RA0':
        if (axis == 'x') {
            return 2437.80;
        } else {
            return 3458.27;
        }
        break;
    case 'RA1':
        if (axis == 'x') {
            return 1729.13;
        } else {
            return 2437.80;
        }
        break;
    case 'RA2':
        if (axis == 'x') {
            return 1218.90;
        } else {
            return 1729.13;
        }
        break;
    case 'RA3':
        if (axis == 'x') {
            return 864.57;
        } else {
            return 1218.90;
        }
        break;
    case 'RA4':
        if (axis == 'x') {
            return 609.45;
        } else {
            return 864.57;
        }
        break;
    case 'SRA0':
        if (axis == 'x') {
            return 2551.18;
        } else {
            return 3628.35;
        }
        break;
    case 'SRA1':
        if (axis == 'x') {
            return 1814.17;
        } else {
            return 2551.18;
        }
        break;
    case 'SRA2':
        if (axis == 'x') {
            return 1275.59;
        } else {
            return 1814.17;
        }
        break;
    case 'SRA3':
        if (axis == 'x') {
            return 907.09;
        } else {
            return 1275.59;
        }
        break;
    case 'SRA4':
        if (axis == 'x') {
            return 637.80;
        } else {
            return 907.09;
        }
        break;
    case 'LETTER':
        if (axis == 'x') {
            return 612.00;
        } else {
            return 792.00;
        }
        break;
    case 'LEGAL':
        if (axis == 'x') {
            return 612.00;
        } else {
            return 1008.00;
        }
        break;
    case 'EXECUTIVE':
        if (axis == 'x') {
            return 521.86;
        } else {
            return 756.00;
        }
        break;
    case 'FOLIO':
        if (axis == 'x') {
            return 612.00;
        } else {
            return 936.00;
        }
        break;
    } // end switch

    return 0;
}

/**
 * Get checkbox for foreign key checks
 *
 * @return string
 */
function getForeignKeyCheckboxLoader() {
    var html = '';
    html    += '<div>';
    html    += '<div class="load-default-fk-check-value">';
    html    += PMA_getImage('ajax_clock_small.gif');
    html    += '</div>';
    html    += '</div>';
    return html;
}

function loadForeignKeyCheckbox() {
    // Load default foreign key check value
    var params = {
        'ajax_request': true,
        'token': PMA_commonParams.get('token'),
        'server': PMA_commonParams.get('server'),
        'get_default_fk_check_value': true
    };
    $.get('sql.php', params, function (data) {
        var html = '<input type="hidden" name="fk_checks" value="0" />' +
            '<input type="checkbox" name="fk_checks" id="fk_checks"' +
            (data.default_fk_check_value ? ' checked="checked"' : '') + ' />' +
            '<label for="fk_checks">' + PMA_messages.strForeignKeyCheck + '</label>';
        $('.load-default-fk-check-value').replaceWith(html);
    });
}

function getJSConfirmCommonParam(elem) {
    return {
        'is_js_confirmed' : 1,
        'ajax_request' : true,
        'fk_checks': $(elem).find('#fk_checks').is(':checked') ? 1 : 0
    };
}

/**
 * Unbind all event handlers before tearing down a page
 */
AJAX.registerTeardown('functions.js', function () {
    $(document).off('click', "a.inline_edit_sql");
    $(document).off('click', "input#sql_query_edit_save");
    $(document).off('click', "input#sql_query_edit_discard");
    $('input.sqlbutton').unbind('click');
    if (codemirror_editor) {
        codemirror_editor.off('blur');
    } else {
        $(document).off('blur', '#sqlquery');
    }
    $(document).off('change', '#parameterized');
    $('#sqlquery').unbind('keydown');
    $('#sql_query_edit').unbind('keydown');

    if (codemirror_inline_editor) {
        // Copy the sql query to the text area to preserve it.
        $('#sql_query_edit').text(codemirror_inline_editor.getValue());
        $(codemirror_inline_editor.getWrapperElement()).unbind('keydown');
        codemirror_inline_editor.toTextArea();
        codemirror_inline_editor = false;
    }
    if (codemirror_editor) {
        $(codemirror_editor.getWrapperElement()).unbind('keydown');
    }
});

/**
 * Jquery Coding for inline editing SQL_QUERY
 */
AJAX.registerOnload('functions.js', function () {
    // If we are coming back to the page by clicking forward button
    // of the browser, bind the code mirror to inline query editor.
    bindCodeMirrorToInlineEditor();
    $(document).on('click', "a.inline_edit_sql", function () {
        if ($('#sql_query_edit').length) {
            // An inline query editor is already open,
            // we don't want another copy of it
            return false;
        }

        var $form = $(this).prev('form');
        var sql_query  = $form.find("input[name='sql_query']").val().trim();
        var $inner_sql = $(this).parent().prev().find('code.sql');
        var old_text   = $inner_sql.html();

        var new_content = "<textarea name=\"sql_query_edit\" id=\"sql_query_edit\">" + escapeHtml(sql_query) + "</textarea>\n";
        new_content    += getForeignKeyCheckboxLoader();
        new_content    += "<input type=\"submit\" id=\"sql_query_edit_save\" class=\"button btnSave\" value=\"" + PMA_messages.strGo + "\"/>\n";
        new_content    += "<input type=\"button\" id=\"sql_query_edit_discard\" class=\"button btnDiscard\" value=\"" + PMA_messages.strCancel + "\"/>\n";
        var $editor_area = $('div#inline_editor');
        if ($editor_area.length === 0) {
            $editor_area = $('<div id="inline_editor_outer"></div>');
            $editor_area.insertBefore($inner_sql);
        }
        $editor_area.html(new_content);
        loadForeignKeyCheckbox();
        $inner_sql.hide();

        bindCodeMirrorToInlineEditor();
        return false;
    });

    $(document).on('click', "input#sql_query_edit_save", function () {
        //hide already existing success message
        var sql_query;
        if (codemirror_inline_editor) {
            codemirror_inline_editor.save();
            sql_query = codemirror_inline_editor.getValue();
        } else {
            sql_query = $(this).parent().find('#sql_query_edit').val();
        }
        var fk_check = $(this).parent().find('#fk_checks').is(':checked');

        var $form = $("a.inline_edit_sql").prev('form');
        var $fake_form = $('<form>', {action: 'import.php', method: 'post'})
                .append($form.find("input[name=server], input[name=db], input[name=table], input[name=token]").clone())
                .append($('<input/>', {type: 'hidden', name: 'show_query', value: 1}))
                .append($('<input/>', {type: 'hidden', name: 'is_js_confirmed', value: 0}))
                .append($('<input/>', {type: 'hidden', name: 'sql_query', value: sql_query}))
                .append($('<input/>', {type: 'hidden', name: 'fk_checks', value: fk_check ? 1 : 0}));
        if (! checkSqlQuery($fake_form[0])) {
            return false;
        }
        $(".success").hide();
        $fake_form.appendTo($('body')).submit();
    });

    $(document).on('click', "input#sql_query_edit_discard", function () {
        var $divEditor = $('div#inline_editor_outer');
        $divEditor.siblings('code.sql').show();
        $divEditor.remove();
    });

    $('input.sqlbutton').click(function (evt) {
        insertQuery(evt.target.id);
        PMA_handleSimulateQueryButton();
        return false;
    });

    $(document).on('change', '#parameterized', updateQueryParameters);

    var $inputUsername = $('#input_username');
    if ($inputUsername) {
        if ($inputUsername.val() === '') {
            $inputUsername.focus();
        } else {
            $('#input_password').focus();
        }
    }
});

/**
 * "inputRead" event handler for CodeMirror SQL query editors for autocompletion
 */
function codemirrorAutocompleteOnInputRead(instance) {
    if (!sql_autocomplete_in_progress
        && (!instance.options.hintOptions.tables || !sql_autocomplete)) {

        if (!sql_autocomplete) {
            // Reset after teardown
            instance.options.hintOptions.tables = false;
            instance.options.hintOptions.defaultTable = '';

            sql_autocomplete_in_progress = true;

            var href = 'db_sql_autocomplete.php';
            var params = {
                'ajax_request': true,
                'token': PMA_commonParams.get('token'),
                'server': PMA_commonParams.get('server'),
                'db': PMA_commonParams.get('db'),
                'no_debug': true
            };

            var columnHintRender = function(elem, self, data) {
                $('<div class="autocomplete-column-name">')
                    .text(data.columnName)
                    .appendTo(elem);
                $('<div class="autocomplete-column-hint">')
                    .text(data.columnHint)
                    .appendTo(elem);
            };

            $.ajax({
                type: 'POST',
                url: href,
                data: params,
                success: function (data) {
                    if (data.success) {
                        var tables = JSON.parse(data.tables);
                        sql_autocomplete_default_table = PMA_commonParams.get('table');
                        sql_autocomplete = [];
                        for (var table in tables) {
                            if (tables.hasOwnProperty(table)) {
                                var columns = tables[table];
                                table = {
                                    text: table,
                                    columns: []
                                };
                                for (var column in columns) {
                                    if (columns.hasOwnProperty(column)) {
                                        var displayText = columns[column].Type;
                                        if (columns[column].Key == 'PRI') {
                                            displayText += ' | Primary';
                                        } else if (columns[column].Key == 'UNI') {
                                            displayText += ' | Unique';
                                        }
                                        table.columns.push({
                                            text: column,
                                            displayText: column + " | " +  displayText,
                                            columnName: column,
                                            columnHint: displayText,
                                            render: columnHintRender
                                        });
                                    }
                                }
                            }
                            sql_autocomplete.push(table);
                        }
                        instance.options.hintOptions.tables = sql_autocomplete;
                        instance.options.hintOptions.defaultTable = sql_autocomplete_default_table;
                    }
                },
                complete: function () {
                    sql_autocomplete_in_progress = false;
                }
            });
        }
        else {
            instance.options.hintOptions.tables = sql_autocomplete;
            instance.options.hintOptions.defaultTable = sql_autocomplete_default_table;
        }
    }
    if (instance.state.completionActive) {
        return;
    }
    var cur = instance.getCursor();
    var token = instance.getTokenAt(cur);
    var string = '';
    if (token.string.match(/^[.`\w@]\w*$/)) {
        string = token.string;
    }
    if (string.length > 0) {
        CodeMirror.commands.autocomplete(instance);
    }
}

/**
 * Remove autocomplete information before tearing down a page
 */
AJAX.registerTeardown('functions.js', function () {
    sql_autocomplete = false;
    sql_autocomplete_default_table = '';
});

/**
 * Binds the CodeMirror to the text area used to inline edit a query.
 */
function bindCodeMirrorToInlineEditor() {
    var $inline_editor = $('#sql_query_edit');
    if ($inline_editor.length > 0) {
        if (typeof CodeMirror !== 'undefined') {
            var height = $inline_editor.css('height');
            codemirror_inline_editor = PMA_getSQLEditor($inline_editor);
            codemirror_inline_editor.getWrapperElement().style.height = height;
            codemirror_inline_editor.refresh();
            codemirror_inline_editor.focus();
            $(codemirror_inline_editor.getWrapperElement())
                .bind('keydown', catchKeypressesFromSqlInlineEdit);
        } else {
            $inline_editor
                .focus()
                .bind('keydown', catchKeypressesFromSqlInlineEdit);
        }
    }
}

function catchKeypressesFromSqlInlineEdit(event) {
    // ctrl-enter is 10 in chrome and ie, but 13 in ff
    if ((event.ctrlKey || event.metaKey) && (event.keyCode == 13 || event.keyCode == 10)) {
        $("#sql_query_edit_save").trigger('click');
    }
}

/**
 * Adds doc link to single highlighted SQL element
 */
function PMA_doc_add($elm, params)
{
    if (typeof mysql_doc_template == 'undefined') {
        return;
    }

    var url = PMA_sprintf(
        decodeURIComponent(mysql_doc_template),
        params[0]
    );
    if (params.length > 1) {
        url += '#' + params[1];
    }
    var content = $elm.text();
    $elm.text('');
    $elm.append('<a target="mysql_doc" class="cm-sql-doc" href="' + url + '">' + content + '</a>');
}

/**
 * Generates doc links for keywords inside highlighted SQL
 */
function PMA_doc_keyword(idx, elm)
{
    var $elm = $(elm);
    /* Skip already processed ones */
    if ($elm.find('a').length > 0) {
        return;
    }
    var keyword = $elm.text().toUpperCase();
    var $next = $elm.next('.cm-keyword');
    if ($next) {
        var next_keyword = $next.text().toUpperCase();
        var full = keyword + ' ' + next_keyword;

        var $next2 = $next.next('.cm-keyword');
        if ($next2) {
            var next2_keyword = $next2.text().toUpperCase();
            var full2 = full + ' ' + next2_keyword;
            if (full2 in mysql_doc_keyword) {
                PMA_doc_add($elm, mysql_doc_keyword[full2]);
                PMA_doc_add($next, mysql_doc_keyword[full2]);
                PMA_doc_add($next2, mysql_doc_keyword[full2]);
                return;
            }
        }
        if (full in mysql_doc_keyword) {
            PMA_doc_add($elm, mysql_doc_keyword[full]);
            PMA_doc_add($next, mysql_doc_keyword[full]);
            return;
        }
    }
    if (keyword in mysql_doc_keyword) {
        PMA_doc_add($elm, mysql_doc_keyword[keyword]);
    }
}

/**
 * Generates doc links for builtins inside highlighted SQL
 */
function PMA_doc_builtin(idx, elm)
{
    var $elm = $(elm);
    var builtin = $elm.text().toUpperCase();
    if (builtin in mysql_doc_builtin) {
        PMA_doc_add($elm, mysql_doc_builtin[builtin]);
    }
}

/**
 * Higlights SQL using CodeMirror.
 */
function PMA_highlightSQL($base)
{
    var $elm = $base.find('code.sql');
    $elm.each(function () {
        var $sql = $(this);
        var $pre = $sql.find('pre');
        /* We only care about visible elements to avoid double processing */
        if ($pre.is(":visible")) {
            var $highlight = $('<div class="sql-highlight cm-s-default"></div>');
            $sql.append($highlight);
            if (typeof CodeMirror != 'undefined') {
                CodeMirror.runMode($sql.text(), 'text/x-mysql', $highlight[0]);
                $pre.hide();
                $highlight.find('.cm-keyword').each(PMA_doc_keyword);
                $highlight.find('.cm-builtin').each(PMA_doc_builtin);
            }
        }
    });
}

/**
 * Updates an element containing code.
 *
 * @param jQuery Object $base base element which contains the raw and the
 *                            highlighted code.
 *
 * @param string htmlValue    code in HTML format, displayed if code cannot be
 *                            highlighted
 *
 * @param string rawValue     raw code, used as a parameter for highlighter
 *
 * @return bool               whether content was updated or not
 */
function PMA_updateCode($base, htmlValue, rawValue)
{
    var $code = $base.find('code');
    if ($code.length === 0) {
        return false;
    }

    // Determines the type of the content and appropriate CodeMirror mode.
    var type = '', mode = '';
    if  ($code.hasClass('json')) {
        type = 'json';
        mode = 'application/json';
    } else if ($code.hasClass('sql')) {
        type = 'sql';
        mode = 'text/x-mysql';
    } else if ($code.hasClass('xml')) {
        type = 'xml';
        mode = 'application/xml';
    } else {
        return false;
    }

    // Element used to display unhighlighted code.
    var $notHighlighted = $('<pre>' + htmlValue + '</pre>');

    // Tries to highlight code using CodeMirror.
    if (typeof CodeMirror != 'undefined') {
        var $highlighted = $('<div class="' + type + '-highlight cm-s-default"></div>');
        CodeMirror.runMode(rawValue, mode, $highlighted[0]);
        $notHighlighted.hide();
        $code.html('').append($notHighlighted, $highlighted[0]);
    } else {
        $code.html('').append($notHighlighted);
    }

    return true;
}

/**
 * Show a message on the top of the page for an Ajax request
 *
 * Sample usage:
 *
 * 1) var $msg = PMA_ajaxShowMessage();
 * This will show a message that reads "Loading...". Such a message will not
 * disappear automatically and cannot be dismissed by the user. To remove this
 * message either the PMA_ajaxRemoveMessage($msg) function must be called or
 * another message must be show with PMA_ajaxShowMessage() function.
 *
 * 2) var $msg = PMA_ajaxShowMessage(PMA_messages.strProcessingRequest);
 * This is a special case. The behaviour is same as above,
 * just with a different message
 *
 * 3) var $msg = PMA_ajaxShowMessage('The operation was successful');
 * This will show a message that will disappear automatically and it can also
 * be dismissed by the user.
 *
 * 4) var $msg = PMA_ajaxShowMessage('Some error', false);
 * This will show a message that will not disappear automatically, but it
 * can be dismissed by the user after he has finished reading it.
 *
 * @param string  message     string containing the message to be shown.
 *                              optional, defaults to 'Loading...'
 * @param mixed   timeout     number of milliseconds for the message to be visible
 *                              optional, defaults to 5000. If set to 'false', the
 *                              notification will never disappear
 * @param string  type        string to dictate the type of message shown.
 *                              optional, defaults to normal notification.
 *                              If set to 'error', the notification will show message
 *                              with red background.
 *                              If set to 'success', the notification will show with
 *                              a green background.
 * @return jQuery object       jQuery Element that holds the message div
 *                              this object can be passed to PMA_ajaxRemoveMessage()
 *                              to remove the notification
 */
function PMA_ajaxShowMessage(message, timeout, type)
{
    /**
     * @var self_closing Whether the notification will automatically disappear
     */
    var self_closing = true;
    /**
     * @var dismissable Whether the user will be able to remove
     *                  the notification by clicking on it
     */
    var dismissable = true;
    // Handle the case when a empty data.message is passed.
    // We don't want the empty message
    if (message === '') {
        return true;
    } else if (! message) {
        // If the message is undefined, show the default
        message = PMA_messages.strLoading;
        dismissable = false;
        self_closing = false;
    } else if (message == PMA_messages.strProcessingRequest) {
        // This is another case where the message should not disappear
        dismissable = false;
        self_closing = false;
    }
    // Figure out whether (or after how long) to remove the notification
    if (timeout === undefined) {
        timeout = 5000;
    } else if (timeout === false) {
        self_closing = false;
    }
    // Determine type of message, add styling as required
    if (type === "error") {
      message = "<div class=\"error\">" + message + "</div>";
    } else if (type === "success") {
      message = "<div class=\"success\">" + message + "</div>";
    }
    // Create a parent element for the AJAX messages, if necessary
    if ($('#loading_parent').length === 0) {
        $('<div id="loading_parent"></div>')
        .prependTo("#page_content");
    }
    // Update message count to create distinct message elements every time
    ajax_message_count++;
    // Remove all old messages, if any
    $("span.ajax_notification[id^=ajax_message_num]").remove();
    /**
     * @var    $retval    a jQuery object containing the reference
     *                    to the created AJAX message
     */
    var $retval = $(
            '<span class="ajax_notification" id="ajax_message_num_' +
            ajax_message_count +
            '"></span>'
    )
    .hide()
    .appendTo("#loading_parent")
    .html(message)
    .show();
    // If the notification is self-closing we should create a callback to remove it
    if (self_closing) {
        $retval
        .delay(timeout)
        .fadeOut('medium', function () {
            if ($(this).is(':data(tooltip)')) {
                $(this).tooltip('destroy');
            }
            // Remove the notification
            $(this).remove();
        });
    }
    // If the notification is dismissable we need to add the relevant class to it
    // and add a tooltip so that the users know that it can be removed
    if (dismissable) {
        $retval.addClass('dismissable').css('cursor', 'pointer');
        /**
         * Add a tooltip to the notification to let the user know that (s)he
         * can dismiss the ajax notification by clicking on it.
         */
        PMA_tooltip(
            $retval,
            'span',
            PMA_messages.strDismiss
        );
    }
    PMA_highlightSQL($retval);

    return $retval;
}

/**
 * Removes the message shown for an Ajax operation when it's completed
 *
 * @param jQuery object   jQuery Element that holds the notification
 *
 * @return nothing
 */
function PMA_ajaxRemoveMessage($this_msgbox)
{
    if ($this_msgbox !== undefined && $this_msgbox instanceof jQuery) {
        $this_msgbox
        .stop(true, true)
        .fadeOut('medium');
        if ($this_msgbox.is(':data(tooltip)')) {
            $this_msgbox.tooltip('destroy');
        } else {
            $this_msgbox.remove();
        }
    }
}

/**
 * Requests SQL for previewing before executing.
 *
 * @param jQuery Object $form Form containing query data
 *
 * @return void
 */
function PMA_previewSQL($form)
{
    var form_url = $form.attr('action');
    var form_data = $form.serialize() +
        '&do_save_data=1' +
        '&preview_sql=1' +
        '&ajax_request=1';
    var $msgbox = PMA_ajaxShowMessage();
    $.ajax({
        type: 'POST',
        url: form_url,
        data: form_data,
        success: function (response) {
            PMA_ajaxRemoveMessage($msgbox);
            if (response.success) {
                var $dialog_content = $('<div/>')
                    .append(response.sql_data);
                var button_options = {};
                button_options[PMA_messages.strClose] = function () {
                    $(this).dialog('close');
                };
                var $response_dialog = $dialog_content.dialog({
                    minWidth: 550,
                    maxHeight: 400,
                    modal: true,
                    buttons: button_options,
                    title: PMA_messages.strPreviewSQL,
                    close: function () {
                        $(this).remove();
                    },
                    open: function () {
                        // Pretty SQL printing.
                        PMA_highlightSQL($(this));
                    }
                });
            } else {
                PMA_ajaxShowMessage(response.message);
            }
        },
        error: function () {
            PMA_ajaxShowMessage(PMA_messages.strErrorProcessingRequest);
        }
    });
}

/**
 * check for reserved keyword column name
 *
 * @param jQuery Object $form Form
 *
 * @returns true|false
 */

function PMA_checkReservedWordColumns($form) {
    var is_confirmed = true;
    $.ajax({
        type: 'POST',
        url: "tbl_structure.php",
        data: $form.serialize() + '&reserved_word_check=1',
        success: function (data) {
            if (typeof data.success != 'undefined' && data.success === true) {
                is_confirmed = confirm(data.message);
            }
        },
        async:false
    });
    return is_confirmed;
}

// This event only need to be fired once after the initial page load
$(function () {
    /**
     * Allows the user to dismiss a notification
     * created with PMA_ajaxShowMessage()
     */
    $(document).on('click', 'span.ajax_notification.dismissable', function () {
        PMA_ajaxRemoveMessage($(this));
    });
    /**
     * The below two functions hide the "Dismiss notification" tooltip when a user
     * is hovering a link or button that is inside an ajax message
     */
    $(document).on('mouseover', 'span.ajax_notification a, span.ajax_notification button, span.ajax_notification input', function () {
        if ($(this).parents('span.ajax_notification').is(':data(tooltip)')) {
            $(this).parents('span.ajax_notification').tooltip('disable');
        }
    });
    $(document).on('mouseout', 'span.ajax_notification a, span.ajax_notification button, span.ajax_notification input', function () {
        if ($(this).parents('span.ajax_notification').is(':data(tooltip)')) {
            $(this).parents('span.ajax_notification').tooltip('enable');
        }
    });
});

/**
 * Hides/shows the "Open in ENUM/SET editor" message, depending on the data type of the column currently selected
 */
function PMA_showNoticeForEnum(selectElement)
{
    var enum_notice_id = selectElement.attr("id").split("_")[1];
    enum_notice_id += "_" + (parseInt(selectElement.attr("id").split("_")[2], 10) + 1);
    var selectedType = selectElement.val();
    if (selectedType == "ENUM" || selectedType == "SET") {
        $("p#enum_notice_" + enum_notice_id).show();
    } else {
        $("p#enum_notice_" + enum_notice_id).hide();
    }
}

/**
 * Creates a Profiling Chart. Used in sql.js
 * and in server_status_monitor.js
 */
function PMA_createProfilingChart(target, data)
{
    // create the chart
    var factory = new JQPlotChartFactory();
    var chart = factory.createChart(ChartType.PIE, target);

    // create the data table and add columns
    var dataTable = new DataTable();
    dataTable.addColumn(ColumnType.STRING, '');
    dataTable.addColumn(ColumnType.NUMBER, '');
    dataTable.setData(data);

    // draw the chart and return the chart object
    chart.draw(dataTable, {
        seriesDefaults: {
            rendererOptions: {
                showDataLabels:  true
            }
        },
        highlighter: {
            tooltipLocation: 'se',
            sizeAdjust: 0,
            tooltipAxes: 'pieref',
            formatString: '%s, %.9Ps'
        },
        legend: {
            show: true,
            location: 'e',
            rendererOptions: {
                numberColumns: 2
            }
        },
        // from http://tango.freedesktop.org/Tango_Icon_Theme_Guidelines#Color_Palette
        seriesColors: [
            '#fce94f',
            '#fcaf3e',
            '#e9b96e',
            '#8ae234',
            '#729fcf',
            '#ad7fa8',
            '#ef2929',
            '#eeeeec',
            '#888a85',
            '#c4a000',
            '#ce5c00',
            '#8f5902',
            '#4e9a06',
            '#204a87',
            '#5c3566',
            '#a40000',
            '#babdb6',
            '#2e3436'
        ]
    });
    return chart;
}

/**
 * Formats a profiling duration nicely (in us and ms time).
 * Used in server_status_monitor.js
 *
 * @param  integer    Number to be formatted, should be in the range of microsecond to second
 * @param  integer    Accuracy, how many numbers right to the comma should be
 * @return string     The formatted number
 */
function PMA_prettyProfilingNum(num, acc)
{
    if (!acc) {
        acc = 2;
    }
    acc = Math.pow(10, acc);
    if (num * 1000 < 0.1) {
        num = Math.round(acc * (num * 1000 * 1000)) / acc + 'µ';
    } else if (num < 0.1) {
        num = Math.round(acc * (num * 1000)) / acc + 'm';
    } else {
        num = Math.round(acc * num) / acc;
    }

    return num + 's';
}


/**
 * Formats a SQL Query nicely with newlines and indentation. Depends on Codemirror and MySQL Mode!
 *
 * @param string      Query to be formatted
 * @return string      The formatted query
 */
function PMA_SQLPrettyPrint(string)
{
    if (typeof CodeMirror == 'undefined') {
        return string;
    }

    var mode = CodeMirror.getMode({}, "text/x-mysql");
    var stream = new CodeMirror.StringStream(string);
    var state = mode.startState();
    var token, tokens = [];
    var output = '';
    var tabs = function (cnt) {
        var ret = '';
        for (var i = 0; i < 4 * cnt; i++) {
            ret += " ";
        }
        return ret;
    };

    // "root-level" statements
    var statements = {
        'select': ['select', 'from', 'on', 'where', 'having', 'limit', 'order by', 'group by'],
        'update': ['update', 'set', 'where'],
        'insert into': ['insert into', 'values']
    };
    // don't put spaces before these tokens
    var spaceExceptionsBefore = {';': true, ',': true, '.': true, '(': true};
    // don't put spaces after these tokens
    var spaceExceptionsAfter = {'.': true};

    // Populate tokens array
    var str = '';
    while (! stream.eol()) {
        stream.start = stream.pos;
        token = mode.token(stream, state);
        if (token !== null) {
            tokens.push([token, stream.current().toLowerCase()]);
        }
    }

    var currentStatement = tokens[0][1];

    if (! statements[currentStatement]) {
        return string;
    }
    // Holds all currently opened code blocks (statement, function or generic)
    var blockStack = [];
    // Holds the type of block from last iteration (the current is in blockStack[0])
    var previousBlock;
    // If a new code block is found, newBlock contains its type for one iteration and vice versa for endBlock
    var newBlock, endBlock;
    // How much to indent in the current line
    var indentLevel = 0;
    // Holds the "root-level" statements
    var statementPart, lastStatementPart = statements[currentStatement][0];

    blockStack.unshift('statement');

    // Iterate through every token and format accordingly
    for (var i = 0; i < tokens.length; i++) {
        previousBlock = blockStack[0];

        // New block => push to stack
        if (tokens[i][1] == '(') {
            if (i < tokens.length - 1 && tokens[i + 1][0] == 'statement-verb') {
                blockStack.unshift(newBlock = 'statement');
            } else if (i > 0 && tokens[i - 1][0] == 'builtin') {
                blockStack.unshift(newBlock = 'function');
            } else {
                blockStack.unshift(newBlock = 'generic');
            }
        } else {
            newBlock = null;
        }

        // Block end => pop from stack
        if (tokens[i][1] == ')') {
            endBlock = blockStack[0];
            blockStack.shift();
        } else {
            endBlock = null;
        }

        // A subquery is starting
        if (i > 0 && newBlock == 'statement') {
            indentLevel++;
            output += "\n" + tabs(indentLevel) + tokens[i][1] + ' ' + tokens[i + 1][1].toUpperCase() + "\n" + tabs(indentLevel + 1);
            currentStatement = tokens[i + 1][1];
            i++;
            continue;
        }

        // A subquery is ending
        if (endBlock == 'statement' && indentLevel > 0) {
            output += "\n" + tabs(indentLevel);
            indentLevel--;
        }

        // One less indentation for statement parts (from, where, order by, etc.) and a newline
        statementPart = statements[currentStatement].indexOf(tokens[i][1]);
        if (statementPart != -1) {
            if (i > 0) {
                output += "\n";
            }
            output += tabs(indentLevel) + tokens[i][1].toUpperCase();
            output += "\n" + tabs(indentLevel + 1);
            lastStatementPart = tokens[i][1];
        }
        // Normal indentation and spaces for everything else
        else {
            if (! spaceExceptionsBefore[tokens[i][1]] &&
               ! (i > 0 && spaceExceptionsAfter[tokens[i - 1][1]]) &&
               output.charAt(output.length - 1) != ' ') {
                output += " ";
            }
            if (tokens[i][0] == 'keyword') {
                output += tokens[i][1].toUpperCase();
            } else {
                output += tokens[i][1];
            }
        }

        // split columns in select and 'update set' clauses, but only inside statements blocks
        if ((lastStatementPart == 'select' || lastStatementPart == 'where'  || lastStatementPart == 'set') &&
            tokens[i][1] == ',' && blockStack[0] == 'statement') {

            output += "\n" + tabs(indentLevel + 1);
        }

        // split conditions in where clauses, but only inside statements blocks
        if (lastStatementPart == 'where' &&
            (tokens[i][1] == 'and' || tokens[i][1] == 'or' || tokens[i][1] == 'xor')) {

            if (blockStack[0] == 'statement') {
                output += "\n" + tabs(indentLevel + 1);
            }
            // Todo: Also split and or blocks in newlines & indentation++
            //if (blockStack[0] == 'generic')
             //   output += ...
        }
    }
    return output;
}

/**
 * jQuery function that uses jQueryUI's dialogs to confirm with user. Does not
 *  return a jQuery object yet and hence cannot be chained
 *
 * @param string      question
 * @param string      url           URL to be passed to the callbackFn to make
 *                                  an Ajax call to
 * @param function    callbackFn    callback to execute after user clicks on OK
 * @param function    openCallback  optional callback to run when dialog is shown
 */

jQuery.fn.PMA_confirm = function (question, url, callbackFn, openCallback) {
    var confirmState = PMA_commonParams.get('confirm');
    if (! confirmState) {
        // user does not want to confirm
        if ($.isFunction(callbackFn)) {
            callbackFn.call(this, url);
            return true;
        }
    }
    if (PMA_messages.strDoYouReally === '') {
        return true;
    }

    /**
     * @var    button_options  Object that stores the options passed to jQueryUI
     *                          dialog
     */
    var button_options = [
        {
            text: PMA_messages.strOK,
            'class': 'submitOK',
            click: function () {
                $(this).dialog("close");
                if ($.isFunction(callbackFn)) {
                    callbackFn.call(this, url);
                }
            }
        },
        {
            text: PMA_messages.strCancel,
            'class': 'submitCancel',
            click: function () {
                $(this).dialog("close");
            }
        }
    ];

    $('<div/>', {'id': 'confirm_dialog', 'title': PMA_messages.strConfirm})
    .prepend(question)
    .dialog({
        buttons: button_options,
        close: function () {
            $(this).remove();
        },
        open: openCallback,
        modal: true
    });
};

/**
 * jQuery function to sort a table's body after a new row has been appended to it.
 *
 * @param string      text_selector   string to select the sortKey's text
 *
 * @return jQuery Object for chaining purposes
 */
jQuery.fn.PMA_sort_table = function (text_selector) {
    return this.each(function () {

        /**
         * @var table_body  Object referring to the table's <tbody> element
         */
        var table_body = $(this);
        /**
         * @var rows    Object referring to the collection of rows in {@link table_body}
         */
        var rows = $(this).find('tr').get();

        //get the text of the field that we will sort by
        $.each(rows, function (index, row) {
            row.sortKey = $.trim($(row).find(text_selector).text().toLowerCase());
        });

        //get the sorted order
        rows.sort(function (a, b) {
            if (a.sortKey < b.sortKey) {
                return -1;
            }
            if (a.sortKey > b.sortKey) {
                return 1;
            }
            return 0;
        });

        //pull out each row from the table and then append it according to it's order
        $.each(rows, function (index, row) {
            $(table_body).append(row);
            row.sortKey = null;
        });
    });
};

/**
 * Unbind all event handlers before tearing down a page
 */
AJAX.registerTeardown('functions.js', function () {
    $(document).off('submit', "#create_table_form_minimal.ajax");
    $(document).off('submit', "form.create_table_form.ajax");
    $(document).off('click', "form.create_table_form.ajax input[name=submit_num_fields]");
    $(document).off('keyup', "form.create_table_form.ajax input");
    $(document).off('change', "input[name=partition_count],input[name=subpartition_count],select[name=partition_by]");
});

/**
 * jQuery coding for 'Create Table'.  Used on db_operations.php,
 * db_structure.php and db_tracking.php (i.e., wherever
 * libraries/display_create_table.lib.php is used)
 *
 * Attach Ajax Event handlers for Create Table
 */
AJAX.registerOnload('functions.js', function () {
    /**
     * Attach event handler for submission of create table form (save)
     */
    $(document).on('submit', "form.create_table_form.ajax", function (event) {
        event.preventDefault();

        /**
         * @var    the_form    object referring to the create table form
         */
        var $form = $(this);

        /*
         * First validate the form; if there is a problem, avoid submitting it
         *
         * checkTableEditForm() needs a pure element and not a jQuery object,
         * this is why we pass $form[0] as a parameter (the jQuery object
         * is actually an array of DOM elements)
         */

        if (checkTableEditForm($form[0], $form.find('input[name=orig_num_fields]').val())) {
            PMA_prepareForAjaxRequest($form);
            if (PMA_checkReservedWordColumns($form)) {
                PMA_ajaxShowMessage(PMA_messages.strProcessingRequest);
                //User wants to submit the form
                $.post($form.attr('action'), $form.serialize() + "&do_save_data=1", function (data) {
                    if (typeof data !== 'undefined' && data.success === true) {
                        $('#properties_message')
                         .removeClass('error')
                         .html('');
                        PMA_ajaxShowMessage(data.message);
                        // Only if the create table dialog (distinct panel) exists
                        var $createTableDialog = $("#create_table_dialog");
                        if ($createTableDialog.length > 0) {
                            $createTableDialog.dialog("close").remove();
                        }
                        $('#tableslistcontainer').before(data.formatted_sql);

                        /**
                         * @var tables_table    Object referring to the <tbody> element that holds the list of tables
                         */
                        var tables_table = $("#tablesForm").find("tbody").not("#tbl_summary_row");
                        // this is the first table created in this db
                        if (tables_table.length === 0) {
                            PMA_commonActions.refreshMain(
                                PMA_commonParams.get('opendb_url')
                            );
                        } else {
                            /**
                             * @var curr_last_row   Object referring to the last <tr> element in {@link tables_table}
                             */
                            var curr_last_row = $(tables_table).find('tr:last');
                            /**
                             * @var curr_last_row_index_string   String containing the index of {@link curr_last_row}
                             */
                            var curr_last_row_index_string = $(curr_last_row).find('input:checkbox').attr('id').match(/\d+/)[0];
                            /**
                             * @var curr_last_row_index Index of {@link curr_last_row}
                             */
                            var curr_last_row_index = parseFloat(curr_last_row_index_string);
                            /**
                             * @var new_last_row_index   Index of the new row to be appended to {@link tables_table}
                             */
                            var new_last_row_index = curr_last_row_index + 1;
                            /**
                             * @var new_last_row_id String containing the id of the row to be appended to {@link tables_table}
                             */
                            var new_last_row_id = 'checkbox_tbl_' + new_last_row_index;

                            data.new_table_string = data.new_table_string.replace(/checkbox_tbl_/, new_last_row_id);
                            //append to table
                            $(data.new_table_string)
                             .appendTo(tables_table);

                            //Sort the table
                            $(tables_table).PMA_sort_table('th');

                            // Adjust summary row
                            PMA_adjustTotals();
                        }

                        //Refresh navigation as a new table has been added
                        PMA_reloadNavigation();
                        // Redirect to table structure page on creation of new table
                        var params_12 = 'ajax_request=true&ajax_page_request=true';
                        if (! (history && history.pushState)) {
                            params_12 += PMA_MicroHistory.menus.getRequestParam();
                        }
                        tblStruct_url = 'tbl_structure.php?server=' + data._params.server +
                            '&db='+ data._params.db + '&token=' + data._params.token +
                            '&goto=db_structure.php&table=' + data._params.table + '';
                        $.get(tblStruct_url, params_12, AJAX.responseHandler);
                    } else {
                        PMA_ajaxShowMessage(
                            '<div class="error">' + data.error + '</div>',
                            false
                        );
                    }
                }); // end $.post()
            }
        } // end if (checkTableEditForm() )
    }); // end create table form (save)

    /**
     * Submits the intermediate changes in the table creation form
     * to refresh the UI accordingly
     */
    function submitChangesInCreateTableForm (actionParam) {

        /**
         * @var    the_form    object referring to the create table form
         */
        var $form = $('form.create_table_form.ajax');

        var $msgbox = PMA_ajaxShowMessage(PMA_messages.strProcessingRequest);
        PMA_prepareForAjaxRequest($form);

        //User wants to add more fields to the table
        $.post($form.attr('action'), $form.serialize() + "&" + actionParam, function (data) {
            if (typeof data !== 'undefined' && data.success) {
                var $pageContent = $("#page_content");
                $pageContent.html(data.message);
                PMA_highlightSQL($pageContent);
                PMA_verifyColumnsProperties();
                PMA_hideShowConnection($('.create_table_form select[name=tbl_storage_engine]'));
                PMA_ajaxRemoveMessage($msgbox);
            } else {
                PMA_ajaxShowMessage(data.error);
            }
        }); //end $.post()
    }

    /**
     * Attach event handler for create table form (add fields)
     */
    $(document).on('click', "form.create_table_form.ajax input[name=submit_num_fields]", function (event) {
        event.preventDefault();

        if (!checkFormElementInRange(this.form, 'added_fields', PMA_messages.strLeastColumnError, 1)) {
            return;
        }

        submitChangesInCreateTableForm('submit_num_fields=1');
    }); // end create table form (add fields)

    $(document).on('keydown', "form.create_table_form.ajax input[name=added_fields]", function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            event.stopImmediatePropagation();
            $(this)
                .closest('form')
                .find('input[name=submit_num_fields]')
                .click();
        }
    });

    /**
     * Attach event handler to manage changes in number of partitions and subpartitions
     */
    $(document).on('change', "input[name=partition_count],input[name=subpartition_count],select[name=partition_by]", function (event) {
        $this = $(this);
        $form = $this.parents('form');
        if ($form.is(".create_table_form.ajax")) {
            submitChangesInCreateTableForm('submit_partition_change=1');
        } else {
            $form.submit();
        }
    });

    $(document).on('change', "input[value=AUTO_INCREMENT]", function() {
        if (this.checked) {
            var col = /\d/.exec($(this).attr('name'));
            col = col[0];
            var $selectFieldKey = $('select[name="field_key[' + col + ']"]');
            if ($selectFieldKey.val() === 'none_'+col) {
                $selectFieldKey.val('primary_'+col).change();
            }
        }
    });
    $('body')
    .off('click', 'input.preview_sql')
    .on('click', 'input.preview_sql', function () {
        var $form = $(this).closest('form');
        PMA_previewSQL($form);
    });
});


/**
 * Validates the password field in a form
 *
 * @see    PMA_messages.strPasswordEmpty
 * @see    PMA_messages.strPasswordNotSame
 * @param  object $the_form The form to be validated
 * @return bool
 */
function PMA_checkPassword($the_form)
{
    // Did the user select 'no password'?
    if ($the_form.find('#nopass_1').is(':checked')) {
        return true;
    } else {
        var $pred = $the_form.find('#select_pred_password');
        if ($pred.length && ($pred.val() == 'none' || $pred.val() == 'keep')) {
            return true;
        }
    }

    var $password = $the_form.find('input[name=pma_pw]');
    var $password_repeat = $the_form.find('input[name=pma_pw2]');
    var alert_msg = false;

    if ($password.val() === '') {
        alert_msg = PMA_messages.strPasswordEmpty;
    } else if ($password.val() != $password_repeat.val()) {
        alert_msg = PMA_messages.strPasswordNotSame;
    }

    if (alert_msg) {
        alert(alert_msg);
        $password.val('');
        $password_repeat.val('');
        $password.focus();
        return false;
    }
    return true;
}

/**
 * Unbind all event handlers before tearing down a page
 */
AJAX.registerTeardown('functions.js', function () {
    $(document).off('click', '#change_password_anchor.ajax');
});
/**
 * Attach Ajax event handlers for 'Change Password' on index.php
 */
AJAX.registerOnload('functions.js', function () {

    /* Handler for hostname type */
    $(document).on('change', '#select_pred_hostname', function () {
        var hostname = $('#pma_hostname');
        if (this.value == 'any') {
            hostname.val('%');
        } else if (this.value == 'localhost') {
            hostname.val('localhost');
        } else if (this.value == 'thishost' && $(this).data('thishost')) {
            hostname.val($(this).data('thishost'));
        } else if (this.value == 'hosttable') {
            hostname.val('').prop('required', false);
        } else if (this.value == 'userdefined') {
            hostname.focus().select().prop('required', true);
        }
    });

    /* Handler for editing hostname */
    $(document).on('change', '#pma_hostname', function () {
        $('#select_pred_hostname').val('userdefined');
        $('#pma_hostname').prop('required', true);
    });

    /* Handler for username type */
    $(document).on('change', '#select_pred_username', function () {
        if (this.value == 'any') {
            $('#pma_username').val('').prop('required', false);
            $('#user_exists_warning').css('display', 'none');
        } else if (this.value == 'userdefined') {
            $('#pma_username').focus().select().prop('required', true);
        }
    });

    /* Handler for editing username */
    $(document).on('change', '#pma_username', function () {
        $('#select_pred_username').val('userdefined');
        $('#pma_username').prop('required', true);
    });

    /* Handler for password type */
    $(document).on('change', '#select_pred_password', function () {
        if (this.value == 'none') {
            $('#text_pma_pw2').prop('required', false).val('');
            $('#text_pma_pw').prop('required', false).val('');
        } else if (this.value == 'userdefined') {
            $('#text_pma_pw2').prop('required', true);
            $('#text_pma_pw').prop('required', true).focus().select();
        } else {
            $('#text_pma_pw2').prop('required', false);
            $('#text_pma_pw').prop('required', false);
        }
    });

    /* Handler for editing password */
    $(document).on('change', '#text_pma_pw,#text_pma_pw2', function () {
        $('#select_pred_password').val('userdefined');
        $('#text_pma_pw2').prop('required', true);
        $('#text_pma_pw').prop('required', true);
    });

    /**
     * Attach Ajax event handler on the change password anchor
     */
    $(document).on('click', '#change_password_anchor.ajax', function (event) {
        event.preventDefault();

        var $msgbox = PMA_ajaxShowMessage();

        /**
         * @var button_options  Object containing options to be passed to jQueryUI's dialog
         */
        var button_options = {};
        button_options[PMA_messages.strGo] = function () {

            event.preventDefault();

            /**
             * @var $the_form    Object referring to the change password form
             */
            var $the_form = $("#change_password_form");

            if (! PMA_checkPassword($the_form)) {
                return false;
            }

            /**
             * @var this_value  String containing the value of the submit button.
             * Need to append this for the change password form on Server Privileges
             * page to work
             */
            var this_value = $(this).val();

            var $msgbox = PMA_ajaxShowMessage(PMA_messages.strProcessingRequest);
            $the_form.append('<input type="hidden" name="ajax_request" value="true" />');

            $.post($the_form.attr('action'), $the_form.serialize() + '&change_pw=' + this_value, function (data) {
                if (typeof data === 'undefined' || data.success !== true) {
                    PMA_ajaxShowMessage(data.error, false);
                    return;
                }

                var $pageContent = $("#page_content");
                $pageContent.prepend(data.message);
                PMA_highlightSQL($pageContent);
                $("#change_password_dialog").hide().remove();
                $("#edit_user_dialog").dialog("close").remove();
                PMA_ajaxRemoveMessage($msgbox);
            }); // end $.post()
        };

        button_options[PMA_messages.strCancel] = function () {
            $(this).dialog('close');
        };
        $.get($(this).attr('href'), {'ajax_request': true}, function (data) {
            if (typeof data === 'undefined' || !data.success) {
                PMA_ajaxShowMessage(data.error, false);
                return;
            }

            if (data._scripts) {
                AJAX.scriptHandler.load(data._scripts);
            }

            $('<div id="change_password_dialog"></div>')
                .dialog({
                    title: PMA_messages.strChangePassword,
                    width: 600,
                    close: function (ev, ui) {
                        $(this).remove();
                    },
                    buttons: button_options,
                    modal: true
                })
                .append(data.message);
            // for this dialog, we remove the fieldset wrapping due to double headings
            $("fieldset#fieldset_change_password")
                .find("legend").remove().end()
                .find("table.noclick").unwrap().addClass("some-margin")
                .find("input#text_pma_pw").focus();
            $('#fieldset_change_password_footer').hide();
            PMA_ajaxRemoveMessage($msgbox);
            $('#change_password_form').bind('submit', function (e) {
                e.preventDefault();
                $(this)
                    .closest('.ui-dialog')
                    .find('.ui-dialog-buttonpane .ui-button')
                    .first()
                    .click();
            });
        }); // end $.get()
    }); // end handler for change password anchor
}); // end $() for Change Password

/**
 * Unbind all event handlers before tearing down a page
 */
AJAX.registerTeardown('functions.js', function () {
    $(document).off('change', "select.column_type");
    $(document).off('change', "select.default_type");
    $(document).off('change', "select.virtuality");
    $(document).off('change', 'input.allow_null');
    $(document).off('change', '.create_table_form select[name=tbl_storage_engine]');
});
/**
 * Toggle the hiding/showing of the "Open in ENUM/SET editor" message when
 * the page loads and when the selected data type changes
 */
AJAX.registerOnload('functions.js', function () {
    // is called here for normal page loads and also when opening
    // the Create table dialog
    PMA_verifyColumnsProperties();
    //
    // needs on() to work also in the Create Table dialog
    $(document).on('change', "select.column_type", function () {
        PMA_showNoticeForEnum($(this));
    });
    $(document).on('change', "select.default_type", function () {
        PMA_hideShowDefaultValue($(this));
    });
    $(document).on('change', "select.virtuality", function () {
        PMA_hideShowExpression($(this));
    });
    $(document).on('change', 'input.allow_null', function () {
        PMA_validateDefaultValue($(this));
    });
    $(document).on('change', '.create_table_form select[name=tbl_storage_engine]', function () {
        PMA_hideShowConnection($(this));
    });
});

/**
 * If the chosen storage engine is FEDERATED show connection field. Hide otherwise
 *
 * @param $engine_selector storage engine selector
 */
function PMA_hideShowConnection($engine_selector)
{
    var $connection = $('.create_table_form input[name=connection]');
    var index = $connection.parent('td').index() + 1;
    var $labelTh = $connection.parents('tr').prev('tr').children('th:nth-child(' + index + ')');
    if ($engine_selector.val() != 'FEDERATED') {
        $connection
            .prop('disabled', true)
            .parent('td').hide();
        $labelTh.hide();
    } else {
        $connection
            .prop('disabled', false)
            .parent('td').show();
        $labelTh.show();
    }
}

/**
 * If the column does not allow NULL values, makes sure that default is not NULL
 */
function PMA_validateDefaultValue($null_checkbox)
{
    if (! $null_checkbox.prop('checked')) {
        var $default = $null_checkbox.closest('tr').find('.default_type');
        if ($default.val() == 'NULL') {
            $default.val('NONE');
        }
    }
}

/**
 * function to populate the input fields on picking a column from central list
 *
 * @param string  input_id input id of the name field for the column to be populated
 * @param integer offset of the selected column in central list of columns
 */
function autoPopulate(input_id, offset)
{
    var db = PMA_commonParams.get('db');
    var table = PMA_commonParams.get('table');
    input_id = input_id.substring(0, input_id.length - 1);
    $('#' + input_id + '1').val(central_column_list[db + '_' + table][offset].col_name);
    var col_type = central_column_list[db + '_' + table][offset].col_type.toUpperCase();
    $('#' + input_id + '2').val(col_type);
    var $input3 = $('#' + input_id + '3');
    $input3.val(central_column_list[db + '_' + table][offset].col_length);
    if(col_type === 'ENUM' || col_type === 'SET') {
        $input3.next().show();
    } else {
        $input3.next().hide();
    }
    var col_default = central_column_list[db + '_' + table][offset].col_default.toUpperCase();
    var $input4 = $('#' + input_id + '4');
    if (col_default !== '' && col_default !== 'NULL' && col_default !== 'CURRENT_TIMESTAMP') {
        $input4.val("USER_DEFINED");
        $input4.next().next().show();
        $input4.next().next().val(central_column_list[db + '_' + table][offset].col_default);
    } else {
        $input4.val(central_column_list[db + '_' + table][offset].col_default);
        $input4.next().next().hide();
    }
    $('#' + input_id + '5').val(central_column_list[db + '_' + table][offset].col_collation);
    var $input6 = $('#' + input_id + '6');
    $input6.val(central_column_list[db + '_' + table][offset].col_attribute);
    if(central_column_list[db + '_' + table][offset].col_extra === 'on update CURRENT_TIMESTAMP') {
        $input6.val(central_column_list[db + '_' + table][offset].col_extra);
    }
    if(central_column_list[db + '_' + table][offset].col_extra.toUpperCase() === 'AUTO_INCREMENT') {
        $('#' + input_id + '9').prop("checked",true).change();
    } else {
        $('#' + input_id + '9').prop("checked",false);
    }
    if(central_column_list[db + '_' + table][offset].col_isNull !== '0') {
        $('#' + input_id + '7').prop("checked",true);
    } else {
        $('#' + input_id + '7').prop("checked",false);
    }
}

/**
 * Unbind all event handlers before tearing down a page
 */
AJAX.registerTeardown('functions.js', function () {
    $(document).off('click', "a.open_enum_editor");
    $(document).off('click', "input.add_value");
    $(document).off('click', "#enum_editor td.drop");
    $(document).off('click', 'a.central_columns_dialog');
});
/**
 * @var $enum_editor_dialog An object that points to the jQuery
 *                          dialog of the ENUM/SET editor
 */
var $enum_editor_dialog = null;
/**
 * Opens the ENUM/SET editor and controls its functions
 */
AJAX.registerOnload('functions.js', function () {
    $(document).on('click', "a.open_enum_editor", function () {
        // Get the name of the column that is being edited
        var colname = $(this).closest('tr').find('input:first').val();
        var title;
        var i;
        // And use it to make up a title for the page
        if (colname.length < 1) {
            title = PMA_messages.enum_newColumnVals;
        } else {
            title = PMA_messages.enum_columnVals.replace(
                /%s/,
                '"' + escapeHtml(decodeURIComponent(colname)) + '"'
            );
        }
        // Get the values as a string
        var inputstring = $(this)
            .closest('td')
            .find("input")
            .val();
        // Escape html entities
        inputstring = $('<div/>')
            .text(inputstring)
            .html();
        // Parse the values, escaping quotes and
        // slashes on the fly, into an array
        var values = [];
        var in_string = false;
        var curr, next, buffer = '';
        for (i = 0; i < inputstring.length; i++) {
            curr = inputstring.charAt(i);
            next = i == inputstring.length ? '' : inputstring.charAt(i + 1);
            if (! in_string && curr == "'") {
                in_string = true;
            } else if (in_string && curr == "\\" && next == "\\") {
                buffer += "&#92;";
                i++;
            } else if (in_string && next == "'" && (curr == "'" || curr == "\\")) {
                buffer += "&#39;";
                i++;
            } else if (in_string && curr == "'") {
                in_string = false;
                values.push(buffer);
                buffer = '';
            } else if (in_string) {
                buffer += curr;
            }
        }
        if (buffer.length > 0) {
            // The leftovers in the buffer are the last value (if any)
            values.push(buffer);
        }
        var fields = '';
        // If there are no values, maybe the user is about to make a
        // new list so we add a few for him/her to get started with.
        if (values.length === 0) {
            values.push('', '', '', '');
        }
        // Add the parsed values to the editor
        var drop_icon = PMA_getImage('b_drop.png');
        for (i = 0; i < values.length; i++) {
            fields += "<tr><td>" +
                   "<input type='text' value='" + values[i] + "'/>" +
                   "</td><td class='drop'>" +
                   drop_icon +
                   "</td></tr>";
        }
        /**
         * @var dialog HTML code for the ENUM/SET dialog
         */
        var dialog = "<div id='enum_editor'>" +
                   "<fieldset>" +
                    "<legend>" + title + "</legend>" +
                    "<p>" + PMA_getImage('s_notice.png') +
                    PMA_messages.enum_hint + "</p>" +
                    "<table class='values'>" + fields + "</table>" +
                    "</fieldset><fieldset class='tblFooters'>" +
                    "<table class='add'><tr><td>" +
                    "<div class='slider'></div>" +
                    "</td><td>" +
                    "<form><div><input type='submit' class='add_value' value='" +
                    PMA_sprintf(PMA_messages.enum_addValue, 1) +
                    "'/></div></form>" +
                    "</td></tr></table>" +
                    "<input type='hidden' value='" + // So we know which column's data is being edited
                    $(this).closest('td').find("input").attr("id") +
                    "' />" +
                    "</fieldset>" +
                    "</div>";
        /**
         * @var  Defines functions to be called when the buttons in
         * the buttonOptions jQuery dialog bar are pressed
         */
        var buttonOptions = {};
        buttonOptions[PMA_messages.strGo] = function () {
            // When the submit button is clicked,
            // put the data back into the original form
            var value_array = [];
            $(this).find(".values input").each(function (index, elm) {
                var val = elm.value.replace(/\\/g, '\\\\').replace(/'/g, "''");
                value_array.push("'" + val + "'");
            });
            // get the Length/Values text field where this value belongs
            var values_id = $(this).find("input[type='hidden']").val();
            $("input#" + values_id).val(value_array.join(","));
            $(this).dialog("close");
        };
        buttonOptions[PMA_messages.strClose] = function () {
            $(this).dialog("close");
        };
        // Show the dialog
        var width = parseInt(
            (parseInt($('html').css('font-size'), 10) / 13) * 340,
            10
        );
        if (! width) {
            width = 340;
        }
        $enum_editor_dialog = $(dialog).dialog({
            minWidth: width,
            maxHeight: 450,
            modal: true,
            title: PMA_messages.enum_editor,
            buttons: buttonOptions,
            open: function () {
                // Focus the "Go" button after opening the dialog
                $(this).closest('.ui-dialog').find('.ui-dialog-buttonpane button:first').focus();
            },
            close: function () {
                $(this).remove();
            }
        });
        // slider for choosing how many fields to add
        $enum_editor_dialog.find(".slider").slider({
            animate: true,
            range: "min",
            value: 1,
            min: 1,
            max: 9,
            slide: function (event, ui) {
                $(this).closest('table').find('input[type=submit]').val(
                    PMA_sprintf(PMA_messages.enum_addValue, ui.value)
                );
            }
        });
        // Focus the slider, otherwise it looks nearly transparent
        $('a.ui-slider-handle').addClass('ui-state-focus');
        return false;
    });

    $(document).on('click', 'a.central_columns_dialog', function (e) {
        var href = "db_central_columns.php";
        var db = PMA_commonParams.get('db');
        var table = PMA_commonParams.get('table');
        var maxRows = $(this).data('maxrows');
        var pick = $(this).data('pick');
        if (pick !== false) {
            pick = true;
        }
        var params = {
            'ajax_request' : true,
            'token' : PMA_commonParams.get('token'),
            'server' : PMA_commonParams.get('server'),
            'db' : PMA_commonParams.get('db'),
            'cur_table' : PMA_commonParams.get('table'),
            'getColumnList':true
        };
        var colid = $(this).closest('td').find("input").attr("id");
        var fields = '';
        if (! (db + '_' + table in central_column_list)) {
            central_column_list.push(db + '_' + table);
            $.ajax({
                type: 'POST',
                url: href,
                data: params,
                success: function (data) {
                    central_column_list[db + '_' + table] = JSON.parse(data.message);
                },
                async:false
            });
        }
        var i = 0;
        var list_size = central_column_list[db + '_' + table].length;
        var min = (list_size <= maxRows) ? list_size : maxRows;
        for (i = 0; i < min; i++) {

            fields += '<tr><td><div><span style="font-weight:bold">' +
                escapeHtml(central_column_list[db + '_' + table][i].col_name) +
                '</span><br><span style="color:gray">' + central_column_list[db + '_' + table][i].col_type;

            if (central_column_list[db + '_' + table][i].col_attribute !== '') {
                fields += '(' + escapeHtml(central_column_list[db + '_' + table][i].col_attribute) + ') ';
            }
            if (central_column_list[db + '_' + table][i].col_length !== '') {
                fields += '(' + escapeHtml(central_column_list[db + '_' + table][i].col_length) +') ';
            }
            fields += escapeHtml(central_column_list[db + '_' + table][i].col_extra) + '</span>' +
                '</div></td>';
            if (pick) {
                fields += '<td><input class="pick" style="width:100%" type="submit" value="' +
                    PMA_messages.pickColumn + '" onclick="autoPopulate(\'' + colid + '\',' + i + ')"/></td>';
            }
            fields += '</tr>';
        }
        var result_pointer = i;
        var search_in = '<input type="text" class="filter_rows" placeholder="' + PMA_messages.searchList + '">';
        if (fields === '') {
            fields = PMA_sprintf(PMA_messages.strEmptyCentralList, "'" + escapeHtml(db) + "'");
            search_in = '';
        }
        var seeMore = '';
        if (list_size > maxRows) {
            seeMore = "<fieldset class='tblFooters' style='text-align:center;font-weight:bold'>" +
                "<a href='#' id='seeMore'>" + PMA_messages.seeMore + "</a></fieldset>";
        }
        var central_columns_dialog = "<div style='max-height:400px'>" +
            "<fieldset>" +
            search_in +
            "<table id='col_list' style='width:100%' class='values'>" + fields + "</table>" +
            "</fieldset>" +
            seeMore +
            "</div>";

        var width = parseInt(
            (parseInt($('html').css('font-size'), 10) / 13) * 500,
            10
        );
        if (! width) {
            width = 500;
        }
        var buttonOptions = {};
        var $central_columns_dialog = $(central_columns_dialog).dialog({
            minWidth: width,
            maxHeight: 450,
            modal: true,
            title: PMA_messages.pickColumnTitle,
            buttons: buttonOptions,
            open: function () {
                $('#col_list').on("click", ".pick", function (){
                    $central_columns_dialog.remove();
                });
                $(".filter_rows").on("keyup", function () {
                    $.uiTableFilter($("#col_list"), $(this).val());
                });
                $("#seeMore").click(function() {
                    fields = '';
                    min = (list_size <= maxRows + result_pointer) ? list_size : maxRows + result_pointer;
                    for (i = result_pointer; i < min; i++) {

                        fields += '<tr><td><div><span style="font-weight:bold">' +
                            central_column_list[db + '_' + table][i].col_name +
                            '</span><br><span style="color:gray">' +
                            central_column_list[db + '_' + table][i].col_type;

                        if (central_column_list[db + '_' + table][i].col_attribute !== '') {
                            fields += '(' + central_column_list[db + '_' + table][i].col_attribute + ') ';
                        }
                        if (central_column_list[db + '_' + table][i].col_length !== '') {
                            fields += '(' + central_column_list[db + '_' + table][i].col_length + ') ';
                        }
                        fields += central_column_list[db + '_' + table][i].col_extra + '</span>' +
                            '</div></td>';
                        if (pick) {
                            fields += '<td><input class="pick" style="width:100%" type="submit" value="' +
                                PMA_messages.pickColumn + '" onclick="autoPopulate(\'' + colid + '\',' + i + ')"/></td>';
                        }
                        fields += '</tr>';
                    }
                    $("#col_list").append(fields);
                    result_pointer = i;
                    if (result_pointer === list_size) {
                        $('.tblFooters').hide();
                    }
                    return false;
                });
                $(this).closest('.ui-dialog').find('.ui-dialog-buttonpane button:first').focus();
            },
            close: function () {
                $('#col_list').off("click", ".pick");
                $(".filter_rows").off("keyup");
                $(this).remove();
            }
        });
        return false;
    });

   // $(document).on('click', 'a.show_central_list',function(e) {

   // });
    // When "add a new value" is clicked, append an empty text field
    $(document).on('click', "input.add_value", function (e) {
        e.preventDefault();
        var num_new_rows = $enum_editor_dialog.find("div.slider").slider('value');
        while (num_new_rows--) {
            $enum_editor_dialog.find('.values')
                .append(
                    "<tr style='display: none;'><td>" +
                    "<input type='text' />" +
                    "</td><td class='drop'>" +
                    PMA_getImage('b_drop.png') +
                    "</td></tr>"
                )
                .find('tr:last')
                .show('fast');
        }
    });

    // Removes the specified row from the enum editor
    $(document).on('click', "#enum_editor td.drop", function () {
        $(this).closest('tr').hide('fast', function () {
            $(this).remove();
        });
    });
});

/**
 * Ensures indexes names are valid according to their type and, for a primary
 * key, lock index name to 'PRIMARY'
 * @param string   form_id  Variable which parses the form name as
 *                            the input
 * @return boolean  false    if there is no index form, true else
 */
function checkIndexName(form_id)
{
    if ($("#" + form_id).length === 0) {
        return false;
    }

    // Gets the elements pointers
    var $the_idx_name = $("#input_index_name");
    var $the_idx_choice = $("#select_index_choice");

    // Index is a primary key
    if ($the_idx_choice.find("option:selected").val() == 'PRIMARY') {
        $the_idx_name.val('PRIMARY');
        $the_idx_name.prop("disabled", true);
    }

    // Other cases
    else {
        if ($the_idx_name.val() == 'PRIMARY') {
            $the_idx_name.val("");
        }
        $the_idx_name.prop("disabled", false);
    }

    return true;
} // end of the 'checkIndexName()' function

AJAX.registerTeardown('functions.js', function () {
    $(document).off('click', '#index_frm input[type=submit]');
});
AJAX.registerOnload('functions.js', function () {
    /**
     * Handler for adding more columns to an index in the editor
     */
    $(document).on('click', '#index_frm input[type=submit]', function (event) {
        event.preventDefault();
        var rows_to_add = $(this)
            .closest('fieldset')
            .find('.slider')
            .slider('value');

        var tempEmptyVal = function () {
            $(this).val('');
        };

        var tempSetFocus = function () {
            if ($(this).find("option:selected").val() === '') {
                return true;
            }
            $(this).closest("tr").find("input").focus();
        };

        while (rows_to_add--) {
            var $indexColumns = $('#index_columns');
            var $newrow = $indexColumns
                .find('tbody > tr:first')
                .clone()
                .appendTo(
                    $indexColumns.find('tbody')
                );
            $newrow.find(':input').each(tempEmptyVal);
            // focus index size input on column picked
            $newrow.find('select').change(tempSetFocus);
        }
    });
});

function indexEditorDialog(url, title, callback_success, callback_failure)
{
    /*Remove the hidden dialogs if there are*/
    var $editIndexDialog = $('#edit_index_dialog');
    if ($editIndexDialog.length !== 0) {
        $editIndexDialog.remove();
    }
    var $div = $('<div id="edit_index_dialog"></div>');

    /**
     * @var button_options Object that stores the options
     *                     passed to jQueryUI dialog
     */
    var button_options = {};
    button_options[PMA_messages.strGo] = function () {
        /**
         * @var    the_form    object referring to the export form
         */
        var $form = $("#index_frm");
        var $msgbox = PMA_ajaxShowMessage(PMA_messages.strProcessingRequest);
        PMA_prepareForAjaxRequest($form);
        //User wants to submit the form
        $.post($form.attr('action'), $form.serialize() + "&do_save_data=1", function (data) {
            var $sqlqueryresults = $(".sqlqueryresults");
            if ($sqlqueryresults.length !== 0) {
                $sqlqueryresults.remove();
            }
            if (typeof data !== 'undefined' && data.success === true) {
                PMA_ajaxShowMessage(data.message);
                var $resultQuery = $('.result_query');
                if ($resultQuery.length) {
                    $resultQuery.remove();
                }
                if (data.sql_query) {
                    $('<div class="result_query"></div>')
                        .html(data.sql_query)
                        .prependTo('#page_content');
                    PMA_highlightSQL($('#page_content'));
                }
                $(".result_query .notice").remove();
                $resultQuery.prepend(data.message);
                /*Reload the field form*/
                $("#table_index").remove();
                $("<div id='temp_div'><div>")
                    .append(data.index_table)
                    .find("#table_index")
                    .insertAfter("#index_header");
                var $editIndexDialog = $("#edit_index_dialog");
                if ($editIndexDialog.length > 0) {
                    $editIndexDialog.dialog("close");
                }
                $('div.no_indexes_defined').hide();
                if (callback_success) {
                    callback_success();
                }
                PMA_reloadNavigation();
            } else {
                var $temp_div = $("<div id='temp_div'><div>").append(data.error);
                var $error;
                if ($temp_div.find(".error code").length !== 0) {
                    $error = $temp_div.find(".error code").addClass("error");
                } else {
                    $error = $temp_div;
                }
                if (callback_failure) {
                    callback_failure();
                }
                PMA_ajaxShowMessage($error, false);
            }
        }); // end $.post()
    };
    button_options[PMA_messages.strPreviewSQL] = function () {
        // Function for Previewing SQL
        var $form = $('#index_frm');
        PMA_previewSQL($form);
    };
    button_options[PMA_messages.strCancel] = function () {
        $(this).dialog('close');
    };
    var $msgbox = PMA_ajaxShowMessage();
    $.get("tbl_indexes.php", url, function (data) {
        if (typeof data !== 'undefined' && data.success === false) {
            //in the case of an error, show the error message returned.
            PMA_ajaxShowMessage(data.error, false);
        } else {
            PMA_ajaxRemoveMessage($msgbox);
            // Show dialog if the request was successful
            $div
            .append(data.message)
            .dialog({
                title: title,
                width: 450,
                height: 350,
                open: PMA_verifyColumnsProperties,
                modal: true,
                buttons: button_options,
                close: function () {
                    $(this).remove();
                }
            });
            $div.find('.tblFooters').remove();
            showIndexEditDialog($div);
        }
    }); // end $.get()
}

function showIndexEditDialog($outer)
{
    checkIndexType();
    checkIndexName("index_frm");
    var $indexColumns = $('#index_columns');
    $indexColumns.find('td').each(function () {
        $(this).css("width", $(this).width() + 'px');
    });
    $indexColumns.find('tbody').sortable({
        axis: 'y',
        containment: $indexColumns.find("tbody"),
        tolerance: 'pointer'
    });
    PMA_showHints($outer);
    PMA_init_slider();
    // Add a slider for selecting how many columns to add to the index
    $outer.find('.slider').slider({
        animate: true,
        value: 1,
        min: 1,
        max: 16,
        slide: function (event, ui) {
            $(this).closest('fieldset').find('input[type=submit]').val(
                PMA_sprintf(PMA_messages.strAddToIndex, ui.value)
            );
        }
    });
    $('div.add_fields').removeClass('hide');
    // focus index size input on column picked
    $outer.find('table#index_columns select').change(function () {
        if ($(this).find("option:selected").val() === '') {
            return true;
        }
        $(this).closest("tr").find("input").focus();
    });
    // Focus the slider, otherwise it looks nearly transparent
    $('a.ui-slider-handle').addClass('ui-state-focus');
    // set focus on index name input, if empty
    var input = $outer.find('input#input_index_name');
    if (! input.val()) {
        input.focus();
    }
}

/**
 * Function to display tooltips that were
 * generated on the PHP side by PMA\libraries\Util::showHint()
 *
 * @param object $div a div jquery object which specifies the
 *                    domain for searching for tooltips. If we
 *                    omit this parameter the function searches
 *                    in the whole body
 **/
function PMA_showHints($div)
{
    if ($div === undefined || ! $div instanceof jQuery || $div.length === 0) {
        $div = $("body");
    }
    $div.find('.pma_hint').each(function () {
        PMA_tooltip(
            $(this).children('img'),
            'img',
            $(this).children('span').html()
        );
    });
}

AJAX.registerOnload('functions.js', function () {
    PMA_showHints();
});

function PMA_mainMenuResizerCallback() {
    // 5 px margin for jumping menu in Chrome
    return $(document.body).width() - 5;
}
// This must be fired only once after the initial page load
$(function () {
    // Initialise the menu resize plugin
    $('#topmenu').menuResizer(PMA_mainMenuResizerCallback);
    // register resize event
    $(window).resize(function () {
        $('#topmenu').menuResizer('resize');
    });
});

/**
 * Get the row number from the classlist (for example, row_1)
 */
function PMA_getRowNumber(classlist)
{
    return parseInt(classlist.split(/\s+row_/)[1], 10);
}

/**
 * Changes status of slider
 */
function PMA_set_status_label($element)
{
    var text;
    if ($element.css('display') == 'none') {
        text = '+ ';
    } else {
        text = '- ';
    }
    $element.closest('.slide-wrapper').prev().find('span').text(text);
}

/**
 * var  toggleButton  This is a function that creates a toggle
 *                    sliding button given a jQuery reference
 *                    to the correct DOM element
 */
var toggleButton = function ($obj) {
    // In rtl mode the toggle switch is flipped horizontally
    // so we need to take that into account
    var right;
    if ($('span.text_direction', $obj).text() == 'ltr') {
        right = 'right';
    } else {
        right = 'left';
    }
    /**
     *  var  h  Height of the button, used to scale the
     *          background image and position the layers
     */
    var h = $obj.height();
    $('img', $obj).height(h);
    $('table', $obj).css('bottom', h - 1);
    /**
     *  var  on   Width of the "ON" part of the toggle switch
     *  var  off  Width of the "OFF" part of the toggle switch
     */
    var on  = $('td.toggleOn', $obj).width();
    var off = $('td.toggleOff', $obj).width();
    // Make the "ON" and "OFF" parts of the switch the same size
    // + 2 pixels to avoid overflowed
    $('td.toggleOn > div', $obj).width(Math.max(on, off) + 2);
    $('td.toggleOff > div', $obj).width(Math.max(on, off) + 2);
    /**
     *  var  w  Width of the central part of the switch
     */
    var w = parseInt(($('img', $obj).height() / 16) * 22, 10);
    // Resize the central part of the switch on the top
    // layer to match the background
    $('table td:nth-child(2) > div', $obj).width(w);
    /**
     *  var  imgw    Width of the background image
     *  var  tblw    Width of the foreground layer
     *  var  offset  By how many pixels to move the background
     *               image, so that it matches the top layer
     */
    var imgw = $('img', $obj).width();
    var tblw = $('table', $obj).width();
    var offset = parseInt(((imgw - tblw) / 2), 10);
    // Move the background to match the layout of the top layer
    $obj.find('img').css(right, offset);
    /**
     *  var  offw    Outer width of the "ON" part of the toggle switch
     *  var  btnw    Outer width of the central part of the switch
     */
    var offw = $('td.toggleOff', $obj).outerWidth();
    var btnw = $('table td:nth-child(2)', $obj).outerWidth();
    // Resize the main div so that exactly one side of
    // the switch plus the central part fit into it.
    $obj.width(offw + btnw + 2);
    /**
     *  var  move  How many pixels to move the
     *             switch by when toggling
     */
    var move = $('td.toggleOff', $obj).outerWidth();
    // If the switch is initialized to the
    // OFF state we need to move it now.
    if ($('div.container', $obj).hasClass('off')) {
        if (right == 'right') {
            $('div.container', $obj).animate({'left': '-=' + move + 'px'}, 0);
        } else {
            $('div.container', $obj).animate({'left': '+=' + move + 'px'}, 0);
        }
    }
    // Attach an 'onclick' event to the switch
    $('div.container', $obj).click(function () {
        if ($(this).hasClass('isActive')) {
            return false;
        } else {
            $(this).addClass('isActive');
        }
        var $msg = PMA_ajaxShowMessage();
        var $container = $(this);
        var callback = $('span.callback', this).text();
        var operator, url, removeClass, addClass;
        // Perform the actual toggle
        if ($(this).hasClass('on')) {
            if (right == 'right') {
                operator = '-=';
            } else {
                operator = '+=';
            }
            url = $(this).find('td.toggleOff > span').text();
            removeClass = 'on';
            addClass = 'off';
        } else {
            if (right == 'right') {
                operator = '+=';
            } else {
                operator = '-=';
            }
            url = $(this).find('td.toggleOn > span').text();
            removeClass = 'off';
            addClass = 'on';
        }

        var params = {'ajax_request': true, 'token': PMA_commonParams.get('token')};
        $.post(url, params, function (data) {
            if (typeof data !== 'undefined' && data.success === true) {
                PMA_ajaxRemoveMessage($msg);
                $container
                .removeClass(removeClass)
                .addClass(addClass)
                .animate({'left': operator + move + 'px'}, function () {
                    $container.removeClass('isActive');
                });
                eval(callback);
            } else {
                PMA_ajaxShowMessage(data.error, false);
                $container.removeClass('isActive');
            }
        });
    });
};

/**
 * Unbind all event handlers before tearing down a page
 */
AJAX.registerTeardown('functions.js', function () {
    $('div.container').unbind('click');
});
/**
 * Initialise all toggle buttons
 */
AJAX.registerOnload('functions.js', function () {
    $('div.toggleAjax').each(function () {
        var $button = $(this).show();
        $button.find('img').each(function () {
            if (this.complete) {
                toggleButton($button);
            } else {
                $(this).load(function () {
                    toggleButton($button);
                });
            }
        });
    });
});

/**
 * Unbind all event handlers before tearing down a page
 */
AJAX.registerTeardown('functions.js', function () {
    $(document).off('change', 'select.pageselector');
    $(document).off('click', 'a.formLinkSubmit');
    $('#update_recent_tables').unbind('ready');
    $('#sync_favorite_tables').unbind('ready');
});

AJAX.registerOnload('functions.js', function () {

    /**
     * Autosubmit page selector
     */
    $(document).on('change', 'select.pageselector', function (event) {
        event.stopPropagation();
        // Check where to load the new content
        if ($(this).closest("#pma_navigation").length === 0) {
            // For the main page we don't need to do anything,
            $(this).closest("form").submit();
        } else {
            // but for the navigation we need to manually replace the content
            PMA_navigationTreePagination($(this));
        }
    });

    /**
     * Load version information asynchronously.
     */
    if ($('li.jsversioncheck').length > 0) {
        $.ajax({
            dataType: "json",
            url: 'version_check.php',
            method: "POST",
            data: {
                "server": PMA_commonParams.get('server'),
                "token": PMA_commonParams.get('token'),
            },
            success: PMA_current_version
        });
    }

    if ($('#is_git_revision').length > 0) {
        setTimeout(PMA_display_git_revision, 10);
    }

    /**
     * Slider effect.
     */
    PMA_init_slider();

    /**
     * Enables the text generated by PMA\libraries\Util::linkOrButton() to be clickable
     */
    $(document).on('click', 'a.formLinkSubmit', function (e) {
        if (! $(this).hasClass('requireConfirm')) {
            submitFormLink($(this));
            return false;
        }
    });

    var $updateRecentTables = $('#update_recent_tables');
    if ($updateRecentTables.length) {
        $.get(
            $updateRecentTables.attr('href'),
            {no_debug: true},
            function (data) {
                if (typeof data !== 'undefined' && data.success === true) {
                    $('#pma_recent_list').html(data.list);
                }
            }
        );
    }

    // Sync favorite tables from localStorage to pmadb.
    if ($('#sync_favorite_tables').length) {
        $.ajax({
            url: $('#sync_favorite_tables').attr("href"),
            cache: false,
            type: 'POST',
            data: {
                favorite_tables: (isStorageSupported('localStorage') && typeof window.localStorage.favorite_tables !== 'undefined')
                    ? window.localStorage.favorite_tables
                    : '',
                token: PMA_commonParams.get('token'),
                server: PMA_commonParams.get('server'),
                no_debug: true
            },
            success: function (data) {
                // Update localStorage.
                if (isStorageSupported('localStorage')) {
                    window.localStorage.favorite_tables = data.favorite_tables;
                }
                $('#pma_favorite_list').html(data.list);
            }
        });
    }
}); // end of $()

/**
 * Submits the form placed in place of a link due to the excessive url length
 *
 * @param $link anchor
 * @returns {Boolean}
 */
function submitFormLink($link)
{
    if ($link.attr('href').indexOf('=') != -1) {
        var data = $link.attr('href').substr($link.attr('href').indexOf('#') + 1).split('=', 2);
        $link.parents('form').append('<input type="hidden" name="' + data[0] + '" value="' + data[1] + '"/>');
    }
    $link.parents('form').submit();
}

/**
 * Initializes slider effect.
 */
function PMA_init_slider()
{
    $('div.pma_auto_slider').each(function () {
        var $this = $(this);
        if ($this.data('slider_init_done')) {
            return;
        }
        var $wrapper = $('<div>', {'class': 'slide-wrapper'});
        $wrapper.toggle($this.is(':visible'));
        $('<a>', {href: '#' + this.id, "class": 'ajax'})
            .text($this.attr('title'))
            .prepend($('<span>'))
            .insertBefore($this)
            .click(function () {
                var $wrapper = $this.closest('.slide-wrapper');
                var visible = $this.is(':visible');
                if (!visible) {
                    $wrapper.show();
                }
                $this[visible ? 'hide' : 'show']('blind', function () {
                    $wrapper.toggle(!visible);
                    $wrapper.parent().toggleClass("print_ignore", visible);
                    PMA_set_status_label($this);
                });
                return false;
            });
        $this.wrap($wrapper);
        $this.removeAttr('title');
        PMA_set_status_label($this);
        $this.data('slider_init_done', 1);
    });
}

/**
 * Initializes slider effect.
 */
AJAX.registerOnload('functions.js', function () {
    PMA_init_slider();
});

/**
 * Restores sliders to the state they were in before initialisation.
 */
AJAX.registerTeardown('functions.js', function () {
    $('div.pma_auto_slider').each(function () {
        var $this = $(this);
        $this.removeData();
        $this.parent().replaceWith($this);
        $this.parent().children('a').remove();
    });
});

/**
 * Creates a message inside an object with a sliding effect
 *
 * @param msg    A string containing the text to display
 * @param $obj   a jQuery object containing the reference
 *                 to the element where to put the message
 *                 This is optional, if no element is
 *                 provided, one will be created below the
 *                 navigation links at the top of the page
 *
 * @return bool   True on success, false on failure
 */
function PMA_slidingMessage(msg, $obj)
{
    if (msg === undefined || msg.length === 0) {
        // Don't show an empty message
        return false;
    }
    if ($obj === undefined || ! $obj instanceof jQuery || $obj.length === 0) {
        // If the second argument was not supplied,
        // we might have to create a new DOM node.
        if ($('#PMA_slidingMessage').length === 0) {
            $('#page_content').prepend(
                '<span id="PMA_slidingMessage" ' +
                'style="display: inline-block;"></span>'
            );
        }
        $obj = $('#PMA_slidingMessage');
    }
    if ($obj.has('div').length > 0) {
        // If there already is a message inside the
        // target object, we must get rid of it
        $obj
        .find('div')
        .first()
        .fadeOut(function () {
            $obj
            .children()
            .remove();
            $obj
            .append('<div>' + msg + '</div>');
            // highlight any sql before taking height;
            PMA_highlightSQL($obj);
            $obj.find('div')
                .first()
                .hide();
            $obj
            .animate({
                height: $obj.find('div').first().height()
            })
            .find('div')
            .first()
            .fadeIn();
        });
    } else {
        // Object does not already have a message
        // inside it, so we simply slide it down
        $obj.width('100%')
            .html('<div>' + msg + '</div>');
        // highlight any sql before taking height;
        PMA_highlightSQL($obj);
        var h = $obj
            .find('div')
            .first()
            .hide()
            .height();
        $obj
        .find('div')
        .first()
        .css('height', 0)
        .show()
        .animate({
                height: h
            }, function () {
            // Set the height of the parent
            // to the height of the child
                $obj
                .height(
                    $obj
                    .find('div')
                    .first()
                    .height()
                );
            });
    }
    return true;
} // end PMA_slidingMessage()

/**
 * Attach CodeMirror2 editor to SQL edit area.
 */
AJAX.registerOnload('functions.js', function () {
    var $elm = $('#sqlquery');
    if ($elm.length > 0) {
        if (typeof CodeMirror != 'undefined') {
            codemirror_editor = PMA_getSQLEditor($elm);
            codemirror_editor.focus();
            codemirror_editor.on("blur", updateQueryParameters);
        } else {
            // without codemirror
            $elm.focus()
                .bind('blur', updateQueryParameters);
        }
    }
    PMA_highlightSQL($('body'));
});
AJAX.registerTeardown('functions.js', function () {
    if (codemirror_editor) {
        $('#sqlquery').text(codemirror_editor.getValue());
        codemirror_editor.toTextArea();
        codemirror_editor = false;
    }
});
AJAX.registerOnload('functions.js', function () {
    // initializes all lock-page elements lock-id and
    // val-hash data property
    $('#page_content form.lock-page textarea, ' +
            '#page_content form.lock-page input[type="text"], '+
            '#page_content form.lock-page input[type="number"], '+
            '#page_content form.lock-page select').each(function (i) {
        $(this).data('lock-id', i);
        // val-hash is the hash of default value of the field
        // so that it can be compared with new value hash
        // to check whether field was modified or not.
        $(this).data('val-hash', AJAX.hash($(this).val()));
    });

    // initializes lock-page elements (input types checkbox and radio buttons)
    // lock-id and val-hash data property
    $('#page_content form.lock-page input[type="checkbox"], ' +
            '#page_content form.lock-page input[type="radio"]').each(function (i) {
        $(this).data('lock-id', i);
        $(this).data('val-hash', AJAX.hash($(this).is(":checked")));
    });
});

/**
 * jQuery plugin to correctly filter input fields by value, needed
 * because some nasty values may break selector syntax
 */
(function ($) {
    $.fn.filterByValue = function (value) {
        return this.filter(function () {
            return $(this).val() === value;
        });
    };
})(jQuery);

/**
 * Return value of a cell in a table.
 */
function PMA_getCellValue(td) {
    var $td = $(td);
    if ($td.is('.null')) {
        return '';
    } else if ((! $td.is('.to_be_saved')
        || $td.is('.set'))
        && $td.data('original_data')
    ) {
        return $td.data('original_data');
    } else {
        return $td.text();
    }
}

$(window).on('popstate', function (event, data) {
    $('#printcss').attr('media','print');
    return true;
});

/**
 * Unbind all event handlers before tearing down a page
 */
AJAX.registerTeardown('functions.js', function () {
    $(document).off('click', 'a.themeselect');
    $(document).off('change', '.autosubmit');
    $('a.take_theme').unbind('click');
});

AJAX.registerOnload('functions.js', function () {
    /**
     * Theme selector.
     */
    $(document).on('click', 'a.themeselect', function (e) {
        window.open(
            e.target,
            'themes',
            'left=10,top=20,width=510,height=350,scrollbars=yes,status=yes,resizable=yes'
            );
        return false;
    });

    /**
     * Automatic form submission on change.
     */
    $(document).on('change', '.autosubmit', function (e) {
        $(this).closest('form').submit();
    });

    /**
     * Theme changer.
     */
    $('a.take_theme').click(function (e) {
        var what = this.name;
        if (window.opener && window.opener.document.forms.setTheme.elements.set_theme) {
            window.opener.document.forms.setTheme.elements.set_theme.value = what;
            window.opener.document.forms.setTheme.submit();
            window.close();
            return false;
        }
        return true;
    });
});

/**
 * Produce print preview
 */
function printPreview()
{
    $('#printcss').attr('media','all');
    createPrintAndBackButtons();
}

/**
 * Create print and back buttons in preview page
 */
function createPrintAndBackButtons() {

    var back_button = $("<input/>",{
        type: 'button',
        value: PMA_messages.back,
        id: 'back_button_print_view'
    });
    back_button.click(removePrintAndBackButton);
    back_button.appendTo('#page_content');
    var print_button = $("<input/>",{
        type: 'button',
        value: PMA_messages.print,
        id: 'print_button_print_view'
    });
    print_button.click(printPage);
    print_button.appendTo('#page_content');
}

/**
 * Remove print and back buttons and revert to normal view
 */
function removePrintAndBackButton(){
    $('#printcss').attr('media','print');
    $('#back_button_print_view').remove();
    $('#print_button_print_view').remove();
}

/**
 * Print page
 */
function printPage(){
    if (typeof(window.print) != 'undefined') {
        window.print();
    }
}

/**
 * Print button
 */
function copyToClipboard()
{
    var textArea = document.createElement("textarea");

    //
    // *** This styling is an extra step which is likely not required. ***
    //
    // Why is it here? To ensure:
    // 1. the element is able to have focus and selection.
    // 2. if element was to flash render it has minimal visual impact.
    // 3. less flakyness with selection and copying which **might** occur if
    //    the textarea element is not visible.
    //
    // The likelihood is the element won't even render, not even a flash,
    // so some of these are just precautions. However in IE the element
    // is visible whilst the popup box asking the user for permission for
    // the web page to copy to the clipboard.
    //

    // Place in top-left corner of screen regardless of scroll position.
    textArea.style.position = 'fixed';
    textArea.style.top = 0;
    textArea.style.left = 0;

    // Ensure it has a small width and height. Setting to 1px / 1em
    // doesn't work as this gives a negative w/h on some browsers.
    textArea.style.width = '2em';
    textArea.style.height = '2em';

    // We don't need padding, reducing the size if it does flash render.
    textArea.style.padding = 0;

    // Clean up any borders.
    textArea.style.border = 'none';
    textArea.style.outline = 'none';
    textArea.style.boxShadow = 'none';

    // Avoid flash of white box if rendered for any reason.
    textArea.style.background = 'transparent';

    textArea.value = '';

    var elementList = $('#serverinfo a');

    elementList.each(function(){
        textArea.value += $(this).text().split(':')[1].trim() + '/';
    });
    textArea.value += '\t\t' + window.location.href;
    textArea.value += '\n';

    elementList = $('.notice,.success');

    elementList.each(function(){
        textArea.value += $(this).clone().children().remove().end().text() + '\n\n';
    });

    elementList = $('.sql pre');

    elementList.each(function() {
        textArea.value += $(this).text() + '\n\n';
    });

    elementList = $('.table_results .column_heading a');

    elementList.each(function() {
        textArea.value += $(this).clone().children().remove().end().text() + '\t';
    });

    textArea.value += '\n';
    elementList = $('tbody tr');
    elementList.each(function() {
        var childElementList = $(this).find('.data span');
        childElementList.each(function(){
            textArea.value += $(this).clone().children().remove().end().text() + '\t';
        });
        textArea.value += '\n';
    });

    document.body.appendChild(textArea);

    textArea.select();

    try {
        document.execCommand('copy');
    } catch (err) {
        alert('Sorry! Unable to copy');
    }

    document.body.removeChild(textArea);
}

/**
 * Unbind all event handlers before tearing down a page
 */
AJAX.registerTeardown('functions.js', function () {
    $('input#print').unbind('click');
    $(document).off('click', 'a.create_view.ajax');
    $(document).off('keydown', '#createViewDialog input, #createViewDialog select');
    $(document).off('change', '#fkc_checkbox');
});

AJAX.registerOnload('functions.js', function () {
    $('input#print').click(printPage);
    $('.logout').click(function() {
        var form = $(
            '<form method="POST" action="' + $(this).attr('href') + '" class="disableAjax">' +
            '<input type="hidden" name="token" value="' + PMA_commonParams.get('token') + '"/>' +
            '</form>'
        );
        $('body').append(form);
        form.submit();
        return false;
    });
    /**
     * Ajaxification for the "Create View" action
     */
    $(document).on('click', 'a.create_view.ajax', function (e) {
        e.preventDefault();
        PMA_createViewDialog($(this));
    });
    /**
     * Attach Ajax event handlers for input fields in the editor
     * and used to submit the Ajax request when the ENTER key is pressed.
     */
    if ($('#createViewDialog').length !== 0) {
        $(document).on('keydown', '#createViewDialog input, #createViewDialog select', function (e) {
            if (e.which === 13) { // 13 is the ENTER key
                e.preventDefault();

                // with preventing default, selection by <select> tag
                // was also prevented in IE
                $(this).blur();

                $(this).closest('.ui-dialog').find('.ui-button:first').click();
            }
        }); // end $(document).on()
    }

    syntaxHighlighter = PMA_getSQLEditor($('textarea[name="view[as]"]'));

});

function PMA_createViewDialog($this)
{
    var $msg = PMA_ajaxShowMessage();
    var syntaxHighlighter = null;
    $.get($this.attr('href') + '&ajax_request=1&ajax_dialog=1', function (data) {
        if (typeof data !== 'undefined' && data.success === true) {
            PMA_ajaxRemoveMessage($msg);
            var buttonOptions = {};
            buttonOptions[PMA_messages.strGo] = function () {
                if (typeof CodeMirror !== 'undefined') {
                    syntaxHighlighter.save();
                }
                $msg = PMA_ajaxShowMessage();
                $.post('view_create.php', $('#createViewDialog').find('form').serialize(), function (data) {
                    PMA_ajaxRemoveMessage($msg);
                    if (typeof data !== 'undefined' && data.success === true) {
                        $('#createViewDialog').dialog("close");
                        $('.result_query').html(data.message);
                        PMA_reloadNavigation();
                    } else {
                        PMA_ajaxShowMessage(data.error, false);
                    }
                });
            };
            buttonOptions[PMA_messages.strClose] = function () {
                $(this).dialog("close");
            };
            var $dialog = $('<div/>').attr('id', 'createViewDialog').append(data.message).dialog({
                width: 600,
                minWidth: 400,
                modal: true,
                buttons: buttonOptions,
                title: PMA_messages.strCreateView,
                close: function () {
                    $(this).remove();
                }
            });
            // Attach syntax highlighted editor
            syntaxHighlighter = PMA_getSQLEditor($dialog.find('textarea'));
            $('input:visible[type=text]', $dialog).first().focus();
        } else {
            PMA_ajaxShowMessage(data.error);
        }
    });
}

/**
 * Makes the breadcrumbs and the menu bar float at the top of the viewport
 */
$(function () {
    if ($("#floating_menubar").length && $('#PMA_disable_floating_menubar').length === 0) {
        var left = $('html').attr('dir') == 'ltr' ? 'left' : 'right';
        $("#floating_menubar")
            .css('margin-' + left, $('#pma_navigation').width() + $('#pma_navigation_resizer').width())
            .css(left, 0)
            .css({
                'position': 'fixed',
                'top': 0,
                'width': '100%',
                'z-index': 99
            })
            .append($('#serverinfo'))
            .append($('#topmenucontainer'));
        // Allow the DOM to render, then adjust the padding on the body
        setTimeout(function () {
            $('body').css(
                'padding-top',
                $('#floating_menubar').outerHeight(true)
            );
            $('#topmenu').menuResizer('resize');
        }, 4);
    }
});

/**
 * Scrolls the page to the top if clicking the serverinfo bar
 */
$(function () {
    $(document).delegate("#serverinfo, #goto_pagetop", "click", function (event) {
        event.preventDefault();
        $('html, body').animate({scrollTop: 0}, 'fast');
    });
});

var checkboxes_sel = "input.checkall:checkbox:enabled";
/**
 * Watches checkboxes in a form to set the checkall box accordingly
 */
var checkboxes_changed = function () {
    var $form = $(this.form);
    // total number of checkboxes in current form
    var total_boxes = $form.find(checkboxes_sel).length;
    // number of checkboxes checked in current form
    var checked_boxes = $form.find(checkboxes_sel + ":checked").length;
    var $checkall = $form.find("input.checkall_box");
    if (total_boxes == checked_boxes) {
        $checkall.prop({checked: true, indeterminate: false});
    }
    else if (checked_boxes > 0) {
        $checkall.prop({checked: true, indeterminate: true});
    }
    else {
        $checkall.prop({checked: false, indeterminate: false});
    }
};
$(document).on("change", checkboxes_sel, checkboxes_changed);

$(document).on("change", "input.checkall_box", function () {
    var is_checked = $(this).is(":checked");
    $(this.form).find(checkboxes_sel).prop("checked", is_checked)
    .parents("tr").toggleClass("marked", is_checked);
});

/**
 * Watches checkboxes in a sub form to set the sub checkall box accordingly
 */
var sub_checkboxes_changed = function () {
    var $form = $(this).parent().parent();
    // total number of checkboxes in current sub form
    var total_boxes = $form.find(checkboxes_sel).length;
    // number of checkboxes checked in current sub form
    var checked_boxes = $form.find(checkboxes_sel + ":checked").length;
    var $checkall = $form.find("input.sub_checkall_box");
    if (total_boxes == checked_boxes) {
        $checkall.prop({checked: true, indeterminate: false});
    }
    else if (checked_boxes > 0) {
        $checkall.prop({checked: true, indeterminate: true});
    }
    else {
        $checkall.prop({checked: false, indeterminate: false});
    }
};
$(document).on("change", checkboxes_sel + ", input.checkall_box:checkbox:enabled", sub_checkboxes_changed);

$(document).on("change", "input.sub_checkall_box", function () {
    var is_checked = $(this).is(":checked");
    var $form = $(this).parent().parent();
    $form.find(checkboxes_sel).prop("checked", is_checked)
    .parents("tr").toggleClass("marked", is_checked);
});

/**
 * Formats a byte number to human-readable form
 *
 * @param bytes the bytes to format
 * @param optional subdecimals the number of digits after the point
 * @param optional pointchar the char to use as decimal point
 */
function formatBytes(bytes, subdecimals, pointchar) {
    if (!subdecimals) {
        subdecimals = 0;
    }
    if (!pointchar) {
        pointchar = '.';
    }
    var units = ['B', 'KiB', 'MiB', 'GiB'];
    for (var i = 0; bytes > 1024 && i < units.length; i++) {
        bytes /= 1024;
    }
    var factor = Math.pow(10, subdecimals);
    bytes = Math.round(bytes * factor) / factor;
    bytes = bytes.toString().split('.').join(pointchar);
    return bytes + ' ' + units[i];
}

AJAX.registerOnload('functions.js', function () {
    /**
     * Reveal the login form to users with JS enabled
     * and focus the appropriate input field
     */
    var $loginform = $('#loginform');
    if ($loginform.length) {
        $loginform.find('.js-show').show();
        if ($('#input_username').val()) {
            $('#input_password').focus();
        } else {
            $('#input_username').focus();
        }
    }
});

/**
 * Dynamically adjust the width of the boxes
 * on the table and db operations pages
 */
(function () {
    function DynamicBoxes() {
        var $boxContainer = $('#boxContainer');
        if ($boxContainer.length) {
            var minWidth = $boxContainer.data('box-width');
            var viewport = $(window).width() - $('#pma_navigation').width();
            var slots = Math.floor(viewport / minWidth);
            $boxContainer.children()
            .each(function () {
                if (viewport < minWidth) {
                    $(this).width(minWidth);
                } else {
                    $(this).css('width', ((1 /  slots) * 100) + "%");
                }
            })
            .removeClass('clearfloat')
            .filter(':nth-child(' + slots + 'n+1)')
            .addClass('clearfloat');
        }
    }
    AJAX.registerOnload('functions.js', function () {
        DynamicBoxes();
    });
    $(function () {
        $(window).resize(DynamicBoxes);
    });
})();

/**
 * Formats timestamp for display
 */
function PMA_formatDateTime(date, seconds) {
    var result = $.datepicker.formatDate('yy-mm-dd', date);
    var timefmt = 'HH:mm';
    if (seconds) {
        timefmt = 'HH:mm:ss';
    }
    return result + ' ' + $.datepicker.formatTime(
        timefmt, {
            hour: date.getHours(),
            minute: date.getMinutes(),
            second: date.getSeconds()
        }
    );
}

/**
 * Check than forms have less fields than max allowed by PHP.
 */
function checkNumberOfFields() {
    if (typeof maxInputVars === 'undefined') {
        return false;
    }
    if (false === maxInputVars) {
        return false;
    }
    $('form').each(function() {
        var nbInputs = $(this).find(':input').length;
        if (nbInputs > maxInputVars) {
            var warning = PMA_sprintf(PMA_messages.strTooManyInputs, maxInputVars);
            PMA_ajaxShowMessage(warning);
            return false;
        }
        return true;
    });

    return true;
}

/**
 * Ignore the displayed php errors.
 * Simply removes the displayed errors.
 *
 * @param  clearPrevErrors whether to clear errors stored
 *             in $_SESSION['prev_errors'] at server
 *
 */
function PMA_ignorePhpErrors(clearPrevErrors){
    if (typeof(clearPrevErrors) === "undefined" ||
        clearPrevErrors === null
    ) {
        str = false;
    }
    // send AJAX request to error_report.php with send_error_report=0, exception_type=php & token.
    // It clears the prev_errors stored in session.
    if(clearPrevErrors){
        var $pmaReportErrorsForm = $('#pma_report_errors_form');
        $pmaReportErrorsForm.find('input[name="send_error_report"]').val(0); // change send_error_report to '0'
        $pmaReportErrorsForm.submit();
    }

    // remove displayed errors
    var $pmaErrors = $('#pma_errors');
    $pmaErrors.fadeOut( "slow");
    $pmaErrors.remove();
}

/**
 * Toggle the Datetimepicker UI if the date value entered
 * by the user in the 'text box' is not going to be accepted
 * by the Datetimepicker plugin (but is accepted by MySQL)
 */
function toggleDatepickerIfInvalid($td, $input_field) {
    // Regex allowed by the Datetimepicker UI
    var dtexpDate = new RegExp(['^([0-9]{4})',
        '-(((01|03|05|07|08|10|12)-((0[1-9])|([1-2][0-9])|(3[0-1])))|((02|04|06|09|11)',
        '-((0[1-9])|([1-2][0-9])|30)))$'].join(''));
    var dtexpTime = new RegExp(['^(([0-1][0-9])|(2[0-3]))',
        ':((0[0-9])|([1-5][0-9]))',
        ':((0[0-9])|([1-5][0-9]))(\.[0-9]{1,6}){0,1}$'].join(''));

    // If key-ed in Time or Date values are unsupported by the UI, close it
    if ($td.attr('data-type') === 'date' && ! dtexpDate.test($input_field.val())) {
        $input_field.datepicker('hide');
    } else if ($td.attr('data-type') === 'time' && ! dtexpTime.test($input_field.val())) {
        $input_field.datepicker('hide');
    } else {
        $input_field.datepicker('show');
    }
}

/**
 * Unbind all event handlers before tearing down a page
 */
AJAX.registerTeardown('functions.js', function(){
    $(document).off('keydown', 'form input, form textarea, form select');
});

AJAX.registerOnload('functions.js', function () {
    /**
     * Handle 'Ctrl/Alt + Enter' form submits
     */
    $('form input, form textarea, form select').on('keydown', function(e){
        if((e.ctrlKey && e.which == 13) || (e.altKey && e.which == 13)) {
            $form = $(this).closest('form');
            if (! $form.find('input[type="submit"]') ||
                ! $form.find('input[type="submit"]').click()
            ) {
                $form.submit();
            }
        }
    });
});

/**
 * Unbind all event handlers before tearing down a page
 */
AJAX.registerTeardown('functions.js', function(){
    $(document).off('change', 'input[type=radio][name="pw_hash"]');
});

AJAX.registerOnload('functions.js', function(){
    /*
     * Display warning regarding SSL when sha256_password
     * method is selected
     * Used in user_password.php (Change Password link on index.php)
     */
    $(document).on("change", 'select#select_authentication_plugin_cp', function() {
        if (this.value === 'sha256_password') {
            $('#ssl_reqd_warning_cp').show();
        } else {
            $('#ssl_reqd_warning_cp').hide();
        }
    });
});
;

