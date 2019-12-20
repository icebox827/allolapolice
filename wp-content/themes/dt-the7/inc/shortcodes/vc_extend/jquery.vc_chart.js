/* =========================================================
 * jquery.vc_chart.js v1.0
 * =========================================================
 * Copyright 2013 Wpbakery
 *
 * Jquery chart plugin for the Visual Composer.
 * ========================================================= */
(function($){
    /**
     * Pie chart animated.
     * @param element - DOM element
     * @param options - settings object.
     * @constructor
     */
    var VcChart = function(element, options) {
        this.el = element;
        this.$el = $(this.el);
        this.options = $.extend({
            color: 'wpb_button',
            units: '',
            label_selector: '.vc_pie_chart_value',
            back_selector: '.vc_pie_chart_back',
            responsive: true
        }, options);
        this.init();
    };
    VcChart.prototype = {
        constructor: VcChart,
        _progress_v: 0,
        animated: false,
        colors: {
            'wpb_button': 'rgba(142, 147, 151, 1)',
            'btn-primary': 'rgba(42, 130, 236, 1)',
            'btn-info': 'rgba(24, 199, 225, 1)',
            'btn-success': 'rgba(106, 206, 25, 1)',
            'btn-warning': 'rgba(255, 109, 30, 1)',
            'btn-danger': 'rgba(238, 40, 63, 1)',
            'btn-inverse': 'rgba(50, 54, 58, 1)'
        },
        init: function() {
            this.setupColor();
            this.value = this.$el.data('pie-value')/100;
            this.label_value = this.$el.data('pie-label-value') || this.$el.data('pie-value');
            this.$wrapper = $('.vc_pie_wrapper', this.$el);
            this.$label = $(this.options.label_selector, this.$el);
            this.$back = $(this.options.back_selector, this.$el);
            this.$canvas = this.$el.find('canvas');

            if ( this.$el.hasClass('transparent-pie') ) {
                this.$label.css('color', this.color);
            }

            this.draw();
            this.setWayPoint();
            if(this.options.responsive === true) this.setResponsive();

        },
        setupColor: function() {
            if(typeof this.colors[this.options.color] !== 'undefined') {
                this.color = this.colors[this.options.color];
            } else if( typeof this.options.color === 'string' ) {
                this.color = this.options.color;

                /*changes 02.09.2014 by  Alla*/
                if( this.color === 'dt-title' ){
                    if($(this.el).parents(".stripe-style-1").length > 0){
                        this.color = dtLocal.themeSettings.stripes.stripe1.headerColor;
                    }else if($(this.el).parents(".stripe-style-2").length > 0){
                        this.color = dtLocal.themeSettings.stripes.stripe2.headerColor;
                    }else if($(this.el).parents(".stripe-style-3").length > 0){
                        this.color = dtLocal.themeSettings.stripes.stripe3.headerColor;
                    }else if($(this.el).parents(".stripe-style-4").length > 0){
                        this.color = "#ffffff";
                    }else if($(this.el).parents(".stripe-style-5").length > 0){
                        this.color = "#333333";
                    }else{
                        this.color = dtLocal.themeSettings.content.headerColor;
                    }
                }else if( this.color === 'dt-content' ){
                    if($(this.el).parents(".stripe-style-1").length > 0){
                        this.color = dtLocal.themeSettings.stripes.stripe1.textColor;
                    }else if($(this.el).parents(".stripe-style-2").length > 0){
                        this.color = dtLocal.themeSettings.stripes.stripe2.textColor;
                    }else if($(this.el).parents(".stripe-style-3").length > 0){
                        this.color = dtLocal.themeSettings.stripes.stripe3.textColor;
                    }else if($(this.el).parents(".stripe-style-4").length > 0){
                        this.color = "#ffffff";
                    }else if($(this.el).parents(".stripe-style-5").length > 0){
                        this.color = "#333333";
                    }else{
                        this.color = dtLocal.themeSettings.content.textColor;
                    }
                }else if( this.color === "dt-accent" ){
                    this.color = dtLocal.themeSettings.accentColor.color;
                }
            } else {
                this.color = 'rgba(247, 247, 247, 0.2)';
            }
        },
        setResponsive: function() {
            var that = this;
            $(window).resize(function(){
                if(that.animated === true) that.circle.stop();
                that.draw(true);
            });
        },
        draw: function(redraw) {
            var w = this.$el.addClass('vc_ready').width(),
                border_w = 5,
                radius;
            if(!w) w = this.$el.parents(':visible').first().width()-2;
            w = w/100*80;
                radius = w/2 - border_w - 1;
            this.$wrapper.css({"width" : w + "px"});
            this.$label.css({"width" : w, "height" : w, "line-height" : w+"px"});
            this.$back.css({"width" : w, "height" : w});
            this.$canvas.attr({"width" : w + "px", "height" : w + "px"});
            this.$el.addClass('vc_ready');
            this.circle = new ProgressCircle({
                canvas: this.$canvas.get(0),
                minRadius: radius,
                arcWidth: border_w
            });
            if(redraw === true && this.animated === true) {
                this._progress_v = this.value;
                this.circle.addEntry({
                    fillColor: this.color,
                    progressListener: $.proxy(this.setProgress, this)
                }).start();
            }
        },
        setProgress: function() {
            if (this._progress_v >= this.value) {
                this.circle.stop();
                this.$label.text(this.label_value + this.options.units);
                return this._progress_v;
            }
            this._progress_v += 0.005;
            var label_value = this._progress_v/this.value*this.label_value;
            var val = Math.round(label_value) + this.options.units;
            this.$label.text(val);
            return this._progress_v;
        },
        animate: function() {
            if(this.animated !== true) {
                this.animated = true;
                this.circle.addEntry({
                    fillColor: this.color,
                    progressListener: $.proxy(this.setProgress, this)
                }).start(5);
               /* var my_gradient=this.circle.canvas.getContext("2d").createLinearGradient(150, 0, 350,0);
                my_gradient.addColorStop(0,"black");
                 my_gradient.addColorStop(1,"white");
                 this.circle.canvas.fillStyle=my_gradient;*/
            }
        },
         setWayPoint: function() { 
                    void 0 !== $.fn.vcwaypoint ? this.$el.vcwaypoint($.proxy(this.animate, this), { 
                        offset: "85%" 
                    }) : this.animate() } , 
    };
    /**
     * jQuery plugin
     * @param option - object with settings
     * @return {*}
     */
    $.fn.vcChat = function(option, value) {
        return this.each(function () {
            var $this = $(this),
                data = $this.data('vc_chart'),
                options = typeof option === 'object' ? option : {
                    color: $this.data('pie-color'),
                    units: $this.data('pie-units')
                };
            if (typeof option == 'undefined') $this.data('vc_chart', (data = new VcChart(this, options)));
            if (typeof option == 'string') data[option](value);
        });
    };
    /**
     * Allows users to rewrite function inside theme.
     */
    if ( typeof window['vc_pieChart'] !== 'function' ) {
        window.vc_pieChart = function() {
            $('.vc_pie_chart:visible').vcChat();
        }
    }
    $(document).ready(function(){
        !window.vc_iframe && vc_pieChart();
    });

})(window.jQuery);