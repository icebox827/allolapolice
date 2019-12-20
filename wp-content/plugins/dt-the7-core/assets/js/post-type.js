

jQuery(document).ready(function($){
     
    $.fn.exists = function() {
        if ($(this).length > 0) {
            return true;
        } else {
            return false;
        }
    }

    /* !- Check if element is loaded */
    $.fn.loaded = function(callback, jointCallback, ensureCallback){
        var len = this.length;
        if (len > 0) {
            return this.each(function() {
                var el      = this,
                    $el     = $(el),
                    blank   = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";

                $el.on("load.dt", function(event) {
                    $(this).off("load.dt");
                    if (typeof callback == "function") {
                        callback.call(this);
                    }
                    if (--len <= 0 && (typeof jointCallback == "function")){
                        jointCallback.call(this);
                    }
                });

                if (!el.complete || el.complete === undefined) {
                    el.src = el.src;
                } else {
                    $el.trigger("load.dt")
                }
            });
        } else if (ensureCallback) {
            if (typeof jointCallback == "function") {
                jointCallback.call(this);
            }
            return this;
        }
    };
    
    var $body = $("body"),
        $window = $(window),
        $mainSlider = $('#main-slideshow'),
        adminH = $('#wpadminbar').height(),
        header = $('.masthead:not(.side-header):not(.side-header-v-stroke)').height(),
        bodyTransparent = $body.hasClass("transparent"),
        headerBelowSliderExists = $(".floating-navigation-below-slider").exists(),
        $mastheadHeader = $(".masthead");
        
    if($body.hasClass("transparent")){
        var headerH = 0;
    }else if($body.hasClass("overlap")){
        var headerH = ($('.masthead:not(.side-header):not(.side-header-v-stroke)').height() + (parseInt($mainSlider.css("marginTop")) + parseInt($mainSlider.css("marginBottom")) ));
    }else{
        var headerH = $('.masthead:not(.side-header):not(.side-header-v-stroke)').height();
    }
    


/**
 * jquery.hoverdir.js v1.1.0
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2012, Codrops
 * http://www.codrops.com
 */

    
    'use strict';

    $.HoverDir = function( options, element ) {
        
        this.$el = $( element );
        this._init( options );

    };

    // the options
    $.HoverDir.defaults = {
        speed : 300,
        easing : 'ease',
        hoverDelay : 0,
        inverse : false
    };

    $.HoverDir.prototype = {

        _init : function( options ) {
            
            // options
            this.options = $.extend( true, {}, $.HoverDir.defaults, options );
            // transition properties
            this.transitionProp = 'all ' + this.options.speed + 'ms ' + this.options.easing;
            // support for CSS transitions
            this.support = Modernizr.csstransitions;
            // load the events
            this._loadEvents();

        },
        
        _loadEvents : function() {

            var self = this;
            
            this.$el.on( 'mouseenter.hoverdir, mouseleave.hoverdir', function( event ) {
                
                var $el = $( this ),
                    $hoverElem = $el.find( '.rollover-content, .post-entry-content, .gallery-rollover' ),
                    direction = self._getDir( $el, { x : event.pageX, y : event.pageY } ),
                    styleCSS = self._getStyle( direction );
                
                if( event.type === 'mouseenter' ) {
                    
                    $hoverElem.hide().css( styleCSS.from );
                    clearTimeout( self.tmhover );

                    self.tmhover = setTimeout( function() {
                        
                        $hoverElem.show( 0, function() {
                            
                            var $el = $( this );
                            if( self.support ) {
                                $el.css( 'transition', self.transitionProp );
                            }
                            self._applyAnimation( $el, styleCSS.to, self.options.speed );

                        } );
                        
                    
                    }, self.options.hoverDelay );
                    
                }
                else {
                
                    if( self.support ) {
                        $hoverElem.css( 'transition', self.transitionProp );
                    }
                    clearTimeout( self.tmhover );
                    self._applyAnimation( $hoverElem, styleCSS.from, self.options.speed );
                    
                }
                    
            } );

        },
        // credits : http://stackoverflow.com/a/3647634
        _getDir : function( $el, coordinates ) {
            
            // the width and height of the current div
            var w = $el.width(),
                h = $el.height(),

                // calculate the x and y to get an angle to the center of the div from that x and y.
                // gets the x value relative to the center of the DIV and "normalize" it
                x = ( coordinates.x - $el.offset().left - ( w/2 )) * ( w > h ? ( h/w ) : 1 ),
                y = ( coordinates.y - $el.offset().top  - ( h/2 )) * ( h > w ? ( w/h ) : 1 ),
            
                // the angle and the direction from where the mouse came in/went out clockwise (TRBL=0123);
                // first calculate the angle of the point,
                // add 180 deg to get rid of the negative values
                // divide by 90 to get the quadrant
                // add 3 and do a modulo by 4  to shift the quadrants to a proper clockwise TRBL (top/right/bottom/left) **/
                direction = Math.round( ( ( ( Math.atan2(y, x) * (180 / Math.PI) ) + 180 ) / 90 ) + 3 ) % 4;
            
            return direction;
            
        },
        _getStyle : function( direction ) {
            
            var fromStyle, toStyle,
                slideFromTop = { left : '0px', top : '-100%' },
                slideFromBottom = { left : '0px', top : '100%' },
                slideFromLeft = { left : '-100%', top : '0px' },
                slideFromRight = { left : '100%', top : '0px' },
                slideTop = { top : '0px' },
                slideLeft = { left : '0px' };
            
            switch( direction ) {
                case 0:
                    // from top
                    fromStyle = !this.options.inverse ? slideFromTop : slideFromBottom;
                    toStyle = slideTop;
                    break;
                case 1:
                    // from right
                    fromStyle = !this.options.inverse ? slideFromRight : slideFromLeft;
                    toStyle = slideLeft;
                    break;
                case 2:
                    // from bottom
                    fromStyle = !this.options.inverse ? slideFromBottom : slideFromTop;
                    toStyle = slideTop;
                    break;
                case 3:
                    // from left
                    fromStyle = !this.options.inverse ? slideFromLeft : slideFromRight;
                    toStyle = slideLeft;
                    break;
            };
            
            return { from : fromStyle, to : toStyle };
                    
        },
        // apply a transition or fallback to jquery animate based on Modernizr.csstransitions support
        _applyAnimation : function( el, styleCSS, speed ) {

            $.fn.applyStyle = this.support ? $.fn.css : $.fn.animate;
            el.stop().applyStyle( styleCSS, $.extend( true, [], { duration : speed + 'ms' } ) );

        },

    };
    
    var logError = function( message ) {

        if ( window.console ) {

            window.console.error( message );
        
        }

    };
    
    $.fn.hoverdir = function( options ) {

        var instance = $.data( this, 'hoverdir' );
        
        if ( typeof options === 'string' ) {
            
            var args = Array.prototype.slice.call( arguments, 1 );
            
            this.each(function() {
            
                if ( !instance ) {

                    logError( "cannot call methods on hoverdir prior to initialization; " +
                    "attempted to call method '" + options + "'" );
                    return;
                
                }
                
                if ( !$.isFunction( instance[options] ) || options.charAt(0) === "_" ) {

                    logError( "no such method '" + options + "' for hoverdir instance" );
                    return;
                
                }
                
                instance[ options ].apply( instance, args );
            
            });
        
        } 
        else {
        
            this.each(function() {
                
                if ( instance ) {

                    instance._init();
                
                }
                else {

                    instance = $.data( this, 'hoverdir', new $.HoverDir( options, this ) );
                
                }

            });
        
        }
        
        return instance;
        
    };
    

    /*!-Hover Direction aware init*/
    $('.mobile-false .hover-grid .rollover-project, .mobile-false .hover-grid.portfolio-shortcode .post, .mobile-false .hover-grid.album-gallery-shortcode .post, .mobile-false .hover-grid.albums-shortcode .post').each( function() { $(this).hoverdir(); } );
    $('.mobile-false .hover-grid-reverse .rollover-project, .mobile-false .hover-grid-reverse.portfolio-shortcode .post, .mobile-false .hover-grid-reverse.album-gallery-shortcode .post, .mobile-false .hover-grid-reverse.albums-shortcode .post ').each( function() { $(this).hoverdir({
        inverse : true
    }); } );

    $.fn.addIconToLinks = function() {
       return this.each(function() {
            var $icon = $(this);
            if ($icon.hasClass("icon-ready")) {
                return;
            }
            $("<span class='icon-portfolio'></span>").appendTo($(this));

            $icon.addClass("icon-ready");
        });
    };
    $(".links-container a").addIconToLinks();
    
    /*!Trigger click (direct to post) */
    $.fn.forwardToPost = function() {
        return this.each(function() {
            var $this = $(this);
            if ($this.hasClass("this-ready")) {
                return;
            };
            $this.on("click", function(){
                var $this = $(this);
                var $anchor = $this.find("a").first();
                var href = $anchor.attr("href");

                if ($this.parents(".ts-wrap").hasClass("ts-interceptClicks")) return;
                if ( $anchor.attr("target") === "_blank" ) {
                    window.open(href, "_blank");
                    return false;
                }
                window.location.href = href;
                return false;
            });
            $this.addClass("this-ready");
        });
    };
    $(".mobile-false .forward-post").forwardToPost();

    $.fn.touchforwardToPost = function() {
        return this.each(function() {
            var $this = $(this);
            if ($this.hasClass("touch-hover-ready")) {
                return;
            }

            $body.on("touchend", function(e) {
                $(".mobile-true .rollover-content").removeClass("is-clicked");
                $(".mobile-true .rollover-project").removeClass("is-clicked");
            });
            var $this = $(this).find(".rollover-content");
            $this.on("touchstart", function(e) { 
                origY = e.originalEvent.touches[0].pageY;
                origX = e.originalEvent.touches[0].pageX;
            });
            $this.on("touchend", function(e) {
                var touchEX = e.originalEvent.changedTouches[0].pageX,
                    touchEY = e.originalEvent.changedTouches[0].pageY;
                if( origY == touchEY || origX == touchEX ){
                    if ($this.hasClass("is-clicked")) {
                            window.location.href = $this.prev("a").first().attr("href");
                    } else {
                        e.preventDefault();
                        $(".mobile-ture .rollover-content").removeClass("is-clicked");
                        $(".mobile-true .rollover-project").removeClass("is-clicked");
                        $this.addClass("is-clicked");
                        $this.parent(".rollover-project").addClass("is-clicked");
                        return false;
                    };
                };
            });

            $this.addClass("touch-hover-ready");
        });
    };
    $(".mobile-true .forward-post").touchforwardToPost();

    /*!Trigger click on portfolio hover buttons */
    $.fn.followCurentLink = function() {
        return this.each(function() {
            if($(this).parents('.content-rollover-layout-list').length > 0 || $(this).parents('.gradient-overlay-layout-list').length > 0){
                var $this = $(this).parent('article');
            }else{
                var $this = $(this);
            }
            if ($this.hasClass("this-ready")) {
                return;
            }

            var $thisSingleLink = $this.parent().find(".links-container > a, .project-links-container > a"),
                $thisCategory = $this.find(".portfolio-categories a"),
                 $thisReadMore = $this.find(".post-details");
             var alreadyTriggered = false; 
            $this.on("click", function(){
                if ($this.parents(".ts-wrap").hasClass("ts-interceptClicks")) return;

                $thisSingleLink.each(function(){
                    $thisTarget = $(this).attr("target") ? $(this).attr("target") : "_self";
                });

                if($thisSingleLink.hasClass("project-details") || $thisSingleLink.hasClass("link") || $thisSingleLink.hasClass("project-link")){
                    window.open($thisSingleLink.attr("href"), $thisTarget);
                    return false;

                }else{
                    if ( !alreadyTriggered ) {
                        alreadyTriggered = true;
                        $thisSingleLink.trigger("click");
                        
                        alreadyTriggered = false;
                    }
                    //$thisSingleLink.trigger("click");
                    return false;
                }
            });

            $this.find($thisCategory).click(function(e) {
                 e.stopPropagation();
                window.location.href = $thisCategory.attr('href');
            });
            var $thisTarget = (typeof $thisReadMore.attr("target") != 'undefined' && $thisReadMore.attr("target").length > 0) ? $thisReadMore.attr("target") : "_self";

             $this.find($thisReadMore).click(function(e) {
                e.stopPropagation();
                e.preventDefault();
                window.open($thisReadMore.attr('href'), $thisTarget);
            });
            $this.addClass("this-ready");
        });
    };
    $(".mobile-false .rollover-project.rollover-active, .mobile-false .rollover-active,  .mobile-false .buttons-on-img.rollover-active").followCurentLink();

    $.fn.touchFollowCurentLink = function() {
        return this.each(function() {
            if($(this).parents('.content-rollover-layout-list').length > 0 || $(this).parents('.gradient-overlay-layout-list').length > 0){
                var $this = $(this).parent('article');
            }else{
                var $this = $(this);
            }
            if ($this.hasClass("this-ready")) {
                return;
            }

            var $thisSingleLink = $this.parent().find(".links-container > a, .project-links-container > a"),
                $thisCategory = $this.find(".portfolio-categories a");
            var alreadyTriggered = false; 

            $body.on("touchend", function(e) {
                $(".mobile-true .rollover-content").removeClass("is-clicked");
                $(".mobile-true .rollover-active").removeClass("is-clicked");
                $(".mobile-true .rollover-active").parent("article").removeClass("is-clicked");
            });

           
            $this.on("touchstart", function(e) { 
                origY = e.originalEvent.touches[0].pageY;
                origX = e.originalEvent.touches[0].pageX;
            });
            $this.on("touchend", function(e) {
                var touchEX = e.originalEvent.changedTouches[0].pageX,
                    touchEY = e.originalEvent.changedTouches[0].pageY;
                if( origY == touchEY || origX == touchEX ){
                    if ($this.hasClass("is-clicked")) {
                        if ($this.parents(".ts-wrap").hasClass("ts-interceptClicks")) return;

                        $thisSingleLink.each(function(){
                            $thisTarget = $(this).attr("target") ? $(this).attr("target") : "_self";
                        });

                        if($thisSingleLink.hasClass("project-details") || $thisSingleLink.hasClass("link") || $thisSingleLink.hasClass("project-link")){
                            window.open($thisSingleLink.attr("href"), $thisTarget);
                            return false;

                        }else{
                            if ( !alreadyTriggered ) {
                                alreadyTriggered = true;
                                $thisSingleLink.trigger("click");
                                
                                alreadyTriggered = false;
                            }
                            return false;
                        }
                    } else {
                        e.preventDefault();
                         $this.addClass("is-clicked");
                          return false;
                        
                    }
                }
            });

            $this.find($thisCategory).click(function(e) {
                 e.stopPropagation();
                window.location.href = $thisCategory.attr('href');
            });
            $this.addClass("this-ready");
        });
    };
    $(".mobile-true .rollover-project.rollover-active, .mobile-true .rollover-active,  .mobile-true .buttons-on-img.rollover-active").touchFollowCurentLink();

    $.fn.touchRolloverPostClick = function() {
        return this.each(function() {
            var $this = $(this);
            // if ($this.hasClass("touch-post-rollover-ready")) {
            //     return;
            // }
            var $thisSingleLink = $this.find(".post-thumbnail-rollover").first(),
                $thisCategory = $this.find(".entry-meta a, .fancy-date a, .fancy-categories a"),
                $thisOfTop = $this.find(".entry-excerpt").height() + $this.find(".post-details").height();

            $body.on("touchend", function(e) {
                $(".mobile-true .post").removeClass("is-clicked");
            });
          
            $this.on("touchstart", function(e) { 
                origY = e.originalEvent.touches[0].pageY;
                origX = e.originalEvent.touches[0].pageX;
            });
            $this.on("touchend", function(e) {
                var touchEX = e.originalEvent.changedTouches[0].pageX,
                    touchEY = e.originalEvent.changedTouches[0].pageY;
                if( origY == touchEY || origX == touchEX ){
                    //else {
                         if ($this.hasClass("is-clicked")) {
                             //   window.location.href = $thisSingleLink.attr('href');
                             if($this.parents().hasClass("disable-layout-hover")){
                                if(e.target.tagName.toLowerCase() === 'a'){
                                    $(e.target).trigger("click");
                                }else{
                                   // window.location.href = $thisSingleLink.attr('href');
                                }
                            }
                        } else {
                            e.preventDefault();
                            if(e.target.tagName.toLowerCase() === 'a'){
                               // $(e.target).trigger("click");
                            }
                            $(".mobile-ture .post").removeClass("is-clicked");
                            $this.addClass("is-clicked");
                            $this.parent().siblings().find(".post").removeClass("is-clicked");
                            return false;
                        };
                   // };
                };
            });

           // $this.addClass("touch-post-rollover-ready");
        });
    };
    $(".mobile-true .content-rollover-layout-list.portfolio-shortcode .post, .mobile-true .gradient-overlay-layout-list.portfolio-shortcode .post").touchRolloverPostClick();

    $.fn.touchHoverImage = function() {
        return this.each(function() {
            var $img = $(this);
            if ($img.hasClass("hover-ready")) {
                return;
            }

            $body.on("touchend", function(e) {
                $(".mobile-true .rollover-content").removeClass("is-clicked");
            });
            var $this = $(this).find(".rollover-content"),
                thisPar = $this.parents(".wf-cell");
            $this.on("touchstart", function(e) { 
                origY = e.originalEvent.touches[0].pageY;
                origX = e.originalEvent.touches[0].pageX;
            });
            $this.on("touchend", function(e) {
                var touchEX = e.originalEvent.changedTouches[0].pageX,
                    touchEY = e.originalEvent.changedTouches[0].pageY;
                if( origY == touchEY || origX == touchEX ){
                    if ($this.hasClass("is-clicked")) {
                    } else {

                        $('.links-container > a', $this).on('touchend', function(e) {
                            e.stopPropagation();
                            $this.addClass("is-clicked");
                        });
                        e.preventDefault();
                        $(".mobile-true .buttons-on-img .rollover-content").removeClass("is-clicked");
                        $this.addClass("is-clicked");
                        return false;
                    };
                };
            });

            $img.addClass("hover-ready");
        });
    };
    $(".mobile-true .buttons-on-img").touchHoverImage();
   
    $.fn.touchScrollerImage = function() {
        return this.each(function() {
            var $img = $(this);
            if ($img.hasClass("hover-ready")) {
                return;
            }

            $body.on("touchend", function(e) {
                $(".mobile-true .project-list-media").removeClass("is-clicked");
            });
            var $this = $(this),
                $thisSingleLink = $this.find("a.rollover-click-target").first(),
                $thisButtonLink = $this.find(".links-container");
            $this.on("touchstart", function(e) { 
                origY = e.originalEvent.touches[0].pageY;
                origX = e.originalEvent.touches[0].pageX;
            });
            $this.on("touchend", function(e) {
                var touchEX = e.originalEvent.changedTouches[0].pageX,
                    touchEY = e.originalEvent.changedTouches[0].pageY;
                if ($this.parents(".ts-wrap").hasClass("ts-interceptClicks")) return;
                if( origY == touchEY || origX == touchEX ){
                    if ($this.hasClass("is-clicked")) {
                            
                    } else {
                        if($thisSingleLink.length > 0){
                            $thisSingleLink.on("click", function(event) {
                                event.stopPropagation();

                                if ( $(this).hasClass('go-to') ) {
                                    window.location.href = $(this).attr('href');
                                }
                            });
                            $thisSingleLink.trigger("click");
                        };
                        if($thisButtonLink.length > 0){
                            $thisButtonLink.find(" > a ").each(function(){
                                $(this).on("touchend", function(event) {
                                    event.stopPropagation();
                                    $(this).trigger("click");
                                });
                            });
                        }
                        e.preventDefault();
                        $(".mobile-true .dt-owl-item").removeClass("is-clicked");
                        $this.addClass("is-clicked");
                        return false;
                    };
                };
            });

            $img.addClass("hover-ready");
        });
    };
    $(".mobile-true .project-list-media").touchScrollerImage();

    $.fn.touchHoverLinks = function() {
        return this.each(function() {
            var $img = $(this);
            if ($img.hasClass("hover-ready")) {
                return;
            }

            var $this = $(this);
            $this.on("touchend", function(e) {
                if ($this.parents(".ts-wrap").hasClass("ts-interceptClicks")) return;
                if ($this.hasClass("is-clicked")) {
                    return;
                } else {

                    if( $this.hasClass("project-zoom") ) {
                        $this.trigger("click");
                    }else {
                        window.location.href = $this.attr("href");
                        return false;
                    };

                    $(".mobile-true .links-container > a").removeClass("is-clicked");
                    $this.addClass("is-clicked");
                    return false;
                };
            });

            $img.addClass("hover-ready");
        });
    };
    $(".mobile-true .dt-owl-item .links-container > a").touchHoverLinks();

    /*!Trigger albums click */
    $.fn.triggerAlbumsClick = function() {
        return this.each(function() {
            var $this = $(this);
            if ($this.hasClass("this-ready")) {
                return;
            }

            var $thisSingleLink = $this.find("a.rollover-click-target, a.dt-pswp-item").first(),
                $thisCategory = $this.find(".portfolio-categories a");


            if( $thisSingleLink.length > 0 ){
                $thisSingleLink.on("click", function(event) {
                    event.preventDefault();
                   // event.stopPropagation();
                     if ($thisSingleLink.parents(".ts-wrap").hasClass("ts-interceptClicks")) return;

                    if ( $(this).hasClass('go-to') ) {
                        window.location.href = $(this).attr('href');
                    }
                });

                var alreadyTriggered = false;

                $this.on("click", function(){
                    if ($this.parents(".ts-wrap").hasClass("ts-interceptClicks")) return;

                    if ( !alreadyTriggered ) {
                        alreadyTriggered = true;
                        $thisSingleLink.trigger("click");
                        
                        alreadyTriggered = false;
                    }
                    return false;
                })
                $this.find($thisCategory).click(function(e) {

                     e.stopPropagation()
                    window.location.href = $thisCategory.attr('href');
                });
            }
            $this.addClass("this-ready");
        });
    };
    $(".mobile-false .dt-albums-template .rollover-project, .mobile-false .dt-albums-shortcode .rollover-project, .mobile-false .dt-albums-template .buttons-on-img, .mobile-false .dt-albums-shortcode .buttons-on-img, .mobile-false .archive .type-dt_gallery .buttons-on-img, .mobile-false .albums-shortcode:not(.content-rollover-layout-list):not(.gradient-overlay-layout-list) .post-thumbnail").triggerAlbumsClick();
    $.fn.triggerOverlayAlbumsClick = function() {
        return this.each(function() {
            var $this = $(this);
            if ($this.hasClass("this-overlay-ready")) {
                return;
            }
            var $thisSingleLink = $this.parents('.post').first().find("a.rollover-click-target, a.dt-pswp-item").first(),
                $thisCategory = $this.find(".portfolio-categories a, .entry-excerpt a");


             if( $thisSingleLink.length > 0 ){
                $thisSingleLink.on("click", function(event) {
                    event.preventDefault();
                   // event.stopPropagation();
                     if ($thisSingleLink.parents(".ts-wrap").hasClass("ts-interceptClicks")) return;

                    if ( $(this).hasClass('go-to') ) {
                        window.location.href = $(this).attr('href');
                    }
                });

                var alreadyTriggered = false;

                $this.on("click", function(){

                    if ($this.parents(".ts-wrap").hasClass("ts-interceptClicks")) return;

                    if ( !alreadyTriggered ) {
                        alreadyTriggered = true;
                        $thisSingleLink.trigger("click");

                        
                        alreadyTriggered = false;
                    }
                    return false;
                })
                $this.find($thisCategory).click(function(e) {

                     e.stopPropagation()
                    window.location.href = $thisCategory.attr('href');
                });
            }
            $this.addClass("this-overlay-ready");
        });
    };
    $(" .mobile-false .albums-shortcode.content-rollover-layout-list .post-entry-content, .mobile-false .albums-shortcode.gradient-overlay-layout-list .post-entry-content").triggerOverlayAlbumsClick();

     $.fn.triggerOverlayAlbumsTouch = function() {
        return this.each(function() {
            var $this = $(this);
            var $thisSingleLink = $this.find("a.rollover-click-target, a.dt-pswp-item").first(),
                $thisCategory = $this.find(".portfolio-categories a");

            $body.on("touchend", function(e) {
                $(".mobile-true .post").removeClass("is-clicked");
            });

            $this.on("touchstart", function(e) { 
                origY = e.originalEvent.touches[0].pageY;
                origX = e.originalEvent.touches[0].pageX;
                      
            });
            $this.on("touchend", function(e) {
                var touchEX = e.originalEvent.changedTouches[0].pageX,
                    touchEY = e.originalEvent.changedTouches[0].pageY;
                if( origY <= (touchEY+5) && origY >= (touchEY-5) || origX <= touchEX + 5 && origX == touchEX - 5 ){
                     

                     if ($this.hasClass("is-clicked")) {
                         //   window.location.href = $thisSingleLink.attr('href');
                       //  if($this.parents().hasClass("disable-layout-hover")){
                            if ($thisSingleLink.hasClass('go-to') ) {
                                window.location.href = $thisSingleLink.attr('href');
                            }
                            
                            // if(e.target.tagName.toLowerCase() === 'a'){
                            //     $(e.target).trigger("click");
                            // }else{
                               $thisSingleLink.trigger("click");
                           // }
                            $this.find($thisCategory).click(function(e) {

                                e.stopPropagation()
                                window.location.href = $thisCategory.attr('href');
                            });


                       // }
                    } else {
                        e.preventDefault();
                        $(".mobile-ture .post").removeClass("is-clicked");
                        $this.parent().siblings().find(".post").removeClass("is-clicked");
                        $this.addClass("is-clicked");
                        return false;
                    };
                }
            })
                
        });
    };
    $(" .mobile-true .albums-shortcode.content-rollover-layout-list .post, .mobile-true .albums-shortcode.gradient-overlay-layout-list .post").triggerOverlayAlbumsTouch();
    

    /*!Trigger albums click */
    $.fn.triggerAlbumsTouch = function() {
        return this.each(function() {
            var $this = $(this);
            if ($this.hasClass("this-touch-ready")) {
                return;
            }

            var $thisSingleLink = $this.find("a.rollover-click-target, a.dt-pswp-item").first(),
                $thisCategory = $this.find(".portfolio-categories a");

                $body.on("touchend", function(e) {
                $(".mobile-true .rollover-content").removeClass("is-clicked");
            });
           

            if( $thisSingleLink.length > 0 ){
                $thisSingleLink.on("click", function(event) {
                    event.preventDefault();
                    //event.stopPropagation();
                     if ($thisSingleLink.parents(".ts-wrap").hasClass("ts-interceptClicks")) return;

                    if ( $(this).hasClass('go-to') ) {
                        window.location.href = $(this).attr('href');
                    }
                });

                var alreadyTriggered = false;


               // $this.on("click", function(){

                $this.on("touchstart", function(e) { 
                    origY = e.originalEvent.touches[0].pageY;
                    origX = e.originalEvent.touches[0].pageX;
                });
                $this.on("touchend", function(e) {
                    var touchEX = e.originalEvent.changedTouches[0].pageX,
                        touchEY = e.originalEvent.changedTouches[0].pageY;
                    if( origY <= (touchEY+5) && origY >= (touchEY-5) || origX <= touchEX + 5 && origX == touchEX - 5 ){

                        if ($this.parents(".ts-wrap").hasClass("ts-interceptClicks")) return;

                        if ( !alreadyTriggered ) {
                            alreadyTriggered = true;
                            $thisSingleLink.trigger("click");
                            
                            alreadyTriggered = false;
                        }
                        return false;
                    }
                })
                $this.find($thisCategory).click(function(e) {

                     e.stopPropagation();
                    window.location.href = $thisCategory.attr('href');
                });
            }
            $this.addClass("this-touch-ready");
        });
    };
    $(".mobile-true .dt-albums-template .rollover-project, .mobile-true .dt-albums-shortcode .rollover-project, .mobile-true .dt-albums-template .buttons-on-img, .mobile-true .dt-albums-shortcode .buttons-on-img, .mobile-true .archive .type-dt_gallery .buttons-on-img, .mobile-true .albums-shortcode:not(.content-rollover-layout-list):not(.gradient-overlay-layout-list) .post-thumbnail").triggerAlbumsTouch();

        /*!Trigger rollover click*/
    
    $.fn.triggerHoverClick = function() {
        return this.each(function() {
            var $this = $(this);
            if ($this.hasClass("click-ready")) {
                return;
            }

            var $thisSingleLink = $this.prev("a:not(.dt-single-pswp):not(.dt-pswp-item)").first(),
                $thisCategory = $this.find(".portfolio-categories a"),
                $thisLink = $this.find(".project-link"),
                $thisTarget = $thisLink.attr("target") ? $thisLink.attr("target") : "_self",
                $targetClick;
                

            if( $thisSingleLink.length > 0 ){
            

                var alreadyTriggered = false;

                $this.on("click", function(e){

                    if ($this.parents(".ts-wrap").hasClass("ts-interceptClicks") || $this.parents('.owl-carousel').hasClass("ts-interceptClicks")) return;


                  
                    $targetClick = $(e.target);
                   
                    if($targetClick.hasClass("project-zoom") || $targetClick.parent('a').hasClass("project-zoom")){ 
                        console.log($targetClick)
                    }else{
                        if ( !alreadyTriggered ) {
                            alreadyTriggered = true;
                            $thisSingleLink.trigger("click");
                            window.location.href = $thisSingleLink.attr('href');
                            
                            alreadyTriggered = false;
                        }
                    }
                    return false;
                })
                $this.find($thisLink).click(function(e) {
                     e.stopPropagation();
                     e.preventDefault();
                    window.open($thisLink.attr("href"), $thisTarget);
                });

                $this.find($thisCategory).click(function(e) {
                     e.stopPropagation();
                    window.location.href = $thisCategory.attr('href');
                });
            }
            $this.addClass("click-ready");
        });
    };
    $(".mobile-false .rollover-project:not(.rollover-active) .rollover-content, .mobile-false .buttons-on-img:not(.rollover-active) .rollover-content").triggerHoverClick();
   



});
(function($) {

    

/*!
 *
 * jQuery collagePlus Plugin v0.3.2
 * https://github.com/ed-lea/jquery-collagePlus
 *
 * Copyright 2012, Ed Lea twitter.com/ed_lea
 *
 * built for http://qiip.me
 *
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.opensource.org/licenses/GPL-2.0
 *
 *
 * Heavily modified by Dream-Theme.com
 */





    $.fn.collagePlus = function( options ) {

        var defaults = {
            // the ideal height you want your images to be
            'targetHeight'          : 400,
            // width of the area the collage will be in
            'albumWidth'            : this.width(),
            // padding between the images
            'padding'               : parseFloat( this.css('padding-left') ),
            // object that contains the images to collage
            'images'                : this.children(),
            // how quickly you want images to fade in once ready can be in ms, "slow" or "fast"
            'fadeSpeed'             : "fast",
            // how the resized block should be displayed. inline-block by default so that it doesn't break the row
            'display'               : "inline-block",
            // which effect you want to use for revealing the images (note CSS3 browsers only),
            'effect'                : 'default',
            // effect delays can either be applied per row to give the impression of descending appearance
            // or horizontally, so more like a flock of birds changing direction
            'direction'             : 'vertical',
            // Sometimes there is just one image on the last row and it gets blown up to a huge size to fit the
            // parent div width. To stop this behaviour, set this to true
            'allowPartialLastRow'   : false
        };

        var settings = $.extend({}, defaults, options);

        return this.each(function() {

            /*
             *
             * set up vars
             *
             */

                // track row width by adding images, padding and css borders etc
            var row         = 0,
                // collect elements to be re-sized in current row
                elements    = [],
                // track the number of rows generated
                rownum = 1;


            settings.images.each(
                function(index){
                    /*
                     *
                     * Cache selector
                     * Even if first child is not an image the whole sizing is based on images
                     * so where we take measurements, we take them on the images
                     *
                     */
                    var $this = $(this),
                        $img  = ($this.is("img")) ? $this : $(this).find("img").first();

                    /*
                     *
                     * get the current image size. Get image size in this order
                     *
                     * 1. from <img> tag
                     * 2. from data set from initial calculation
                     * 3. after loading the image and checking it's actual size
                     *
                     */
                    if ($img.attr("width") != 'undefined' && $img.attr("height") != 'undefined') {
                        var w = (typeof $img.data("width") != 'undefined') ? $img.data("width") : $img.attr("width"),
                            h = (typeof $img.data("height") != 'undefined') ? $img.data("height") : $img.attr("height");
                        
                    }
                    else {
                        var w = (typeof $img.data("width") != 'undefined') ? $img.data("width") : $img.width(),
                            h = (typeof $img.data("height") != 'undefined') ? $img.data("height") : $img.height();
                    }



                    /*
                     *
                     * Get any current additional properties that may affect the width or height
                     * like css borders for example
                     *
                     */
                    var imgParams = getImgProperty($img);


                    /*
                     *
                     * store the original size for resize events
                     *
                     */
                    $img.data("width", w);
                    $img.data("height", h);



                    /*
                     *
                     * calculate the w/h based on target height
                     * this is our ideal size, but later we'll resize to make it fit
                     *
                     */
                    var nw = Math.ceil(w/h*settings.targetHeight),
                        nh = Math.ceil(settings.targetHeight);

                    /*
                     *
                     * Keep track of which images are in our row so far
                     *
                     */
                    elements.push([this, nw, nh, imgParams['w'], imgParams['h']]);

                    /*
                     *
                     * calculate the width of the element including extra properties
                     * like css borders
                     *
                     */
                    row += nw + imgParams['w'] + settings.padding;

                    /*
                     *
                     * if the current row width is wider than the parent container
                     * it's time to make a row out of our images
                     *
                     */
                    if( row > settings.albumWidth && elements.length != 0 ){

                        // call the method that calculates the final image sizes
                        // remove one set of padding as it's not needed for the last image in the row
                        resizeRow(elements, row, settings, rownum);

                        // reset our row
                        delete row;
                        delete elements;
                        row         = 0;
                        elements    = [];
                        rownum      += 1;
                    }


                    /*
                     *
                     * if the images left are not enough to make a row
                     * then we'll force them to make one anyway
                     *
                     */
                    if ( settings.images.length-1 == index && elements.length != 0){
                        resizeRow(elements, row, settings, rownum);

                        // reset our row
                        delete row;
                        delete elements;
                        row         = 0;
                        elements    = [];
                        rownum      += 1;
                    }
                }
            );

            // trigger "jgDone" event when all is ready
            $(this).trigger("jgDone");
        });

        function resizeRow(obj, row, settings, rownum) {
            /*
             *
             * How much bigger is this row than the available space?
             * At this point we have adjusted the images height to fit our target height
             * so the image size will already be different from the original.
             * The resizing we're doing here is to adjust it to the album width.
             *
             * We also need to change the album width (basically available space) by
             * the amount of padding and css borders for the images otherwise
             * this will skew the result.
             *
             * This is because padding and borders remain at a fixed size and we only
             * need to scale the images.
             *
             */
            var imageExtras         = (settings.padding * obj.length) + (obj.length * obj[0][3]),
                albumWidthAdjusted  = settings.albumWidth - imageExtras,
                overPercent         = albumWidthAdjusted / (row - imageExtras),
                // start tracking our width with know values that will make up the total width
                // like borders and padding
                trackWidth          = imageExtras,
                // guess whether this is the last row in a set by checking if the width is less
                // than the parent width.
                lastRow             = (row < settings.albumWidth  ? true : false);



            /*
             * Resize the images by the above % so that they'll fit in the album space
             */
            for (var i = 0; i < obj.length; i++) {



                var $obj        = $(obj[i][0]),
                    fw          = Math.floor(obj[i][1] * overPercent),
                    fh          = Math.floor(obj[i][2] * overPercent),
                // if the element is the last in the row,
                // don't apply right hand padding (this is our flag for later)
                    isNotLast   = !!(( i < obj.length - 1 ));

                /*
                 * Checking if the user wants to not stretch the images of the last row to fit the
                 * parent element size
                 */
                if(settings.allowPartialLastRow === true && lastRow === true){
                     fw = obj[i][1];
                     fh = obj[i][2];
                }


                /*
                 *
                 * Because we use % to calculate the widths, it's possible that they are
                 * a few pixels out in which case we need to track this and adjust the
                 * last image accordingly
                 *
                 */
                trackWidth += fw;


                /*
                 *
                 * here we check if the combined images are exactly the width
                 * of the parent. If not then we add a few pixels on to make
                 * up the difference.
                 *
                 * This will alter the aspect ratio of the image slightly, but
                 * by a noticable amount.
                 *
                 * If the user doesn't want full width last row, we check for that here
                 *
                 */


    /*
     *
     * We'll be doing a few things to the image so here we cache the image selector
     *
     *
     */
    var $img = ( $obj.is("img") ) ? $obj : $obj.find("img").first();

    /*
     *
     * Set the width of the image and parent element
     * if the resized element is not an image, we apply it to the child image also
     *
     * We need to check if it's an image as the css borders are only measured on
     * images. If the parent is a div, we need make the contained image smaller
     * to accommodate the css image borders.
     *
     */
    $img.width(fw);
    if( !$obj.is("img") ){
        $obj.width(fw + obj[i][3]);
    }


    /*
     *
     * Set the height of the image
     * if the resized element is not an image, we apply it to the child image also
     *
     */
    $img.height(fh);
    if( !$obj.is("img") ){
        $obj.height(fh + obj[i][4]);
    }


    /*
     *
     * Apply the css extras like padding
     *
     */
    if (settings.allowPartialLastRow === false &&  lastRow === true) {
        applyModifications($obj, isNotLast, "none");
    }
    else {
        applyModifications($obj, isNotLast, settings.display);
    };


    /*
     *
     * Assign the effect to show the image
     * Default effect is using jquery and not CSS3 to support more browsers
     * Wait until the image is loaded to do this
     *
     */
    

            }
        }

        /*
         *
         * This private function applies the required css to space the image gallery
         * It applies it to the parent element so if an image is wrapped in a <div> then
         * the css is applied to the <div>
         *
         */
        function applyModifications($obj, isNotLast, settingsDisplay) {
            var css = {
    /*
                    // Applying padding to element for the grid gap effect
                    'margin-bottom'     : settings.padding + "px",
                    'margin-right'      : (isNotLast) ? settings.padding + "px" : "0px",
    */
                    // Set it to an inline-block by default so that it doesn't break the row
                    'display'           : settingsDisplay,
                    // Set vertical alignment otherwise you get 4px extra padding
                    'vertical-align'    : "bottom",
                    // Hide the overflow to hide the caption
                    'overflow'          : "hidden"
                };

            return $obj.css(css);
        }


        /*
         *
         * This private function calculates any extras like padding, border associated
         * with the image that will impact on the width calculations
         *
         */
        function getImgProperty(img) {
            $img = $(img);
            var params =  new Array();
            params["w"] = (parseFloat($img.css("border-left-width")) + parseFloat($img.css("border-right-width")));
            params["h"] = (parseFloat($img.css("border-top-width")) + parseFloat($img.css("border-bottom-width")));
            return params;
        }

    };
    /* !- Justified Gallery Initialisation */


    var jgCounter = 0;
    $(".jg-container").each(function() {
        jgCounter++;
        var $jgContainer = $(this),
            $jgItemsPadding = $jgContainer.attr("data-padding"),
            $jgItems = $jgContainer.find(".wf-cell");
        // .iso-item elements are hidden by default, so we show them.

        $jgContainer.attr("id", "jg-container-" + jgCounter + "");

        $("<style type='text/css'>" + ' .content #jg-container-' + jgCounter + ' .wf-cell'  + '{padding:'  + $jgItemsPadding + ';}' + ' .content #jg-container-' + jgCounter + '.wf-container'  + '{'+ 'margin:'  + '-'+ $jgItemsPadding + ';}' + ' .content .full-width-wrap #jg-container-' + jgCounter + '.wf-container'  + '{'+ 'margin-left:'  + $jgItemsPadding + '; '+ 'margin-right:'  + $jgItemsPadding + '; '+ 'margin-top:' + '-' + $jgItemsPadding + '; '+ 'margin-bottom:' + '-' + $jgItemsPadding + ';}' +"</style>").insertAfter($jgContainer);
        var layzrJGridTimer;
        $jgContainer.on("jgDone", function() {
            var layzrJGrid = new Layzr({
                selector: '.jgrid-lazy-load',
                attr: 'data-src',
                attrSrcSet: 'data-srcset',
                retinaAttr: 'data-src-retina',
                threshold: 0,
                before: function() {

                    // For fixed-size images with srcset; or have to be updated on window resize.
                    this.setAttribute("sizes", this.width+"px");
                    this.style.willChange = 'opacity';
                },
                callback: function() {

                    this.classList.add("jgrid-layzr-loaded");
                    var $this =  $(this);
                    $this.one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(e) {
                        clearTimeout( layzrJGridTimer );
                        layzrJGridTimer = setTimeout(function(){
                            $this.parent().removeClass("layzr-bg");
                            $this.css("will-change",'auto');
                        }, 200)
                    });
                }
            });
        });
    });

    $.fn.collage = function(args) {
        return this.each(function() {
            var $this = $(this);
            var $jgContainer = $(this),
                $jgItemsPadding = $jgContainer.attr("data-padding"),
                $jgItems = $jgContainer.find(".wf-cell");
            var jgPadding = parseFloat($jgItems.first().css('padding-left')) + parseFloat($jgItems.first().css('padding-right')),
                jgTargetHeight = parseInt($jgContainer.attr("data-target-height")),
                jdPartRow = true;

            if ($jgContainer.attr("data-part-row") == "false") {
                jdPartRow = false;
            };


            if($jgContainer.parent(".full-width-wrap").length){
                var jgAlbumWidth = $jgContainer.parents(".full-width-wrap").width() - parseInt($jgItemsPadding)*2;
            }else{
                var jgAlbumWidth = $jgContainer.parent().width() + parseInt($jgItemsPadding)*2;
            }
            
            var $jgCont = {
                'albumWidth'            : jgAlbumWidth,
                'targetHeight'          : jgTargetHeight,
                'padding'               : jgPadding,
                'allowPartialLastRow'   : jdPartRow,
                'fadeSpeed'             : 2000,
                'effect'                : 'effect-1',
                'direction'             : 'vertical'
            };
            $.extend($jgCont, args);

            dtGlobals.jGrid = $jgCont;
            $jgContainer.collagePlus($jgCont);
            $jgContainer.css({
                'width': jgAlbumWidth
            });
        });
    };
    $(window).on("debouncedresize", function() {
        $(".jg-container").not('.jgrid-shortcode').collage();
        $(".jgrid-shortcode").each(function() {
            var $this = $(this);
            var $visibleItems = $this.data('visibleItems');
            if ( $visibleItems ) {
                $this.collage({ 'images': $visibleItems });
            } else {
                $this.collage();
            }
        });
    }).trigger( "debouncedresize" );

    

})(jQuery);