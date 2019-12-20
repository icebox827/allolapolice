
jQuery(document).ready(function($){
	var $body = $("body"),
        $window = $(window),
        $mainSlider = $('#main-slideshow'),
        adminH = $('#wpadminbar').height(),
        header = $('.masthead:not(.side-header):not(.side-header-v-stroke)').height(),
        bodyTransparent = $body.hasClass("transparent"),
		headerBelowSliderExists = $(".floating-navigation-below-slider").exists(),
		$mastheadHeader = $(".masthead");
/* #Photo slider core
================================================== */
	$.fn.exists = function() {
		if ($(this).length > 0) {
			return true;
		} else {
			return false;
		}
	}

	$.fn.loaded = function(callback, jointCallback, ensureCallback){
		var len = this.length;
		if (len > 0) {
			return this.each(function() {
				var el    = this,
					$el  = $(el),
					blank = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";

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

	$.rsCSS3Easing = {
		easeOutSine: 'cubic-bezier(0.390, 0.575, 0.565, 1.000)',
		easeInOutSine: 'cubic-bezier(0.445, 0.050, 0.550, 0.950)'
	};

	$.extend(jQuery.easing, {
		easeInOutSine: function (x, t, b, c, d) {
			return -c/2 * (Math.cos(Math.PI*t/d) - 1) + b;
		},
		easeOutSine: function (x, t, b, c, d) {
			return c * Math.sin(t/d * (Math.PI/2)) + b;
		},
		easeOutCubic: function (x, t, b, c, d) {
			return c*((t=t/d-1)*t*t + 1) + b;
		}
	});

	$.thePhotoSlider = function(element, settings) {
		var self = $(element).data("thePhotoSlider");

		if (!self) {
			this._init(element, settings);
		}
		else {
			self.update();
		};
	};

	$.thePhotoSlider.defaults = {
		mode: {
			type: "slider"
		},
		responsive: true,
		height: false,
		width: false,
		sidePaddings: 0,
		storeHTML: false,
		autoPlay: false,
		threshold: 20,
		resizeImg: false,
		imageScaleMode:"none",
		imageAlignCenter:false,
		collapsePoint: 700,
		transformEnable: true,
		calcAutoHeight :false,
		columBasedResize: false,
		resizeHeight: false
	};

	$.thePhotoSlider.prototype = {
		_init: function(element, settings) {
			var self = this;
			self.st = $.extend({}, $.thePhotoSlider.defaults, settings);
			self.ev = $(self);

			self.autoPlay = {
				enabled: false,
				delay: 2000,
				loop: true
			};

			self.currSlide = 0;
			self.noSlide = true;
			self.lockLeft = true;
			self.lockRight = true;

			self.sliderLock = false;
			self.lockTimeout = false;

			self.wrap = {};
			self.wrap.$el = $(element);
			self.wrap.width = 0;
			self.wrap.height = false;
			self.wrap.$el.data("thePhotoSlider", self);

			self.viewport = self.wrap.$el.find(".ts-viewport");

			self.cont = {};
			self.cont.$el = self.viewport.find(".ts-cont");
			self.cont.width = 0;
			self.cont.startX = 0;
			self.cont.instantX = 0;
	 
			self.slides = {};
			self.slides.$items = self.cont.$el.children();
			self.slides.number = self.slides.$items.length;
			self.slides.position = [];
			self.slides.width = [];
			self.slides.isLoaded = [];

			self.drag = {};
			self.drag.isMoving = false;
			self.drag.startX = 0;
			self.drag.startY = 0;
			self.drag.offsetX = 0;
			self.drag.offsetY = 0;
			self.drag.lockX = false;
			self.drag.lockY = false;

			self.features = {};
			self._featureDetection();

			if (self.st.storeHTML) self.origHTML = self.wrap.$el.html();
			self._buildHTML();

			self._calcSliderSize();
			self._resizeImage();
			if (!self.wrap.height) self.wrap.$el.addClass("ts-autoHeight");

			self._setSliderWidth();
			self._adjustSlides();
			self._setSliderHeight();

			/* if (self.st.mode.type === "centered") */ self.slideTo(0, true);

			if (!self.noSlide) self._bindEvents();

			setTimeout(function() {
				self.wrap.$el.addClass("ts-ready");
				self.ev.trigger("sliderReady");
			}, 20);

			if (self.st.responsive) {
				if (!("onorientationchange" in window)) {
					var dtResizeTimeout;

					$(window).on("resize", function(e) {
						clearTimeout(dtResizeTimeout);
						dtResizeTimeout = setTimeout(function() {
							self.update();
						}, 200);
					});
				}
				else {
					var scrOrientation = window.orientation;

					$(window).on("orientationchange", function(e) {
						var tempOrientation = window.orientation;

						if (tempOrientation !== scrOrientation) {
							scrOrientation = tempOrientation;
							self.update();
						};
					});
				};
			};

			if(self.st.autoPlay.enabled) {
				self.play();
			};
		},

		_featureDetection: function() {
			var self = this,
				tempStyle = document.createElement('div').style,
				vendors = ['webkit','Moz','ms','O'],
				tempV;
				self.features.vendor = '';


			for (i = 0; i < vendors.length; i++ ) {
				tempV = vendors[i];
				if (!self.features.vendor && (tempV + 'Transform') in tempStyle ) {
					self.features.vendor = "-"+tempV.toLowerCase()+"-";
				}
			}
			
			if (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1 && !('ontouchstart' in window)) {
				self.features.css3d = Modernizr.csstransforms3d;
				//self.features.css3d = false;
			}
			else if (typeof Modernizr != "undefined") {
				self.features.css3d = Modernizr.csstransforms3d;
				//self.features.css3d = false;
			}
		
		},

		_buildHTML: function() {
			var self = this;

			if (self.st.mode.type === "centered") {
				self.wrap.$el.addClass("ts-centered");
			};

			if (self.st.mode.type === "slider") {
				self.slides.$items.addClass("ts-slide");
			}
			else if (self.st.mode.type === "scroller" || self.st.mode.type === "centered" || self.st.mode.type === "carousel") {
				self.slides.$items.addClass("ts-cell");
			};
		},

		_calcSliderSize: function() {
			var self = this,
				typeofWidth = typeof self.st.width,
				typeofHeight = typeof self.st.height,
				tempWidth = false,
				tempHeight = false;

			self.wrap.width = self.wrap.$el.width();

			if (typeofWidth === "function") {
				tempWidth = self.st.width(this);
			}
			else if (typeofWidth === "number") {
				tempWidth = self.st.width;
			};

			if (typeofHeight === "function") {
				tempHeight = self.st.height(this);
			}
			else if (typeofHeight === "number") {
				tempHeight = self.st.height;
			};

			if (tempHeight && !tempWidth) { 
				// Calculate once or on resize (if typeofHeight === "function")
				self.wrap.height = tempHeight;
			}
			else if (tempHeight && tempWidth) {
				// Calculate on resize
				self.wrap.height = ( tempHeight * self.wrap.width ) / tempWidth;
			}
			else {
				// Calculate on every slide change and resize
				self.wrap.height = false;
			};
		},

		_resizeImage:function() {

			var self = this;
			var $slide = $(self.slides.$items[i]);

			if (self.st.resizeImg === true) {
				self.cont.width = 0;
				self.slides.$items.each(function(i) {
					var $slide = $(self.slides.$items[i]),
						tempCSS = {};
					var img = $slide.find("img");
					var classToFind = 'rsMainSlideImage';
					var isVideo;
					var imgAlignCenter = self.st.imageAlignCenter,
						imgScaleMode = self.st.imageScaleMode,
						tempEl;

					if(!img) {
						return;
					}

					var baseImageWidth = parseInt(img.attr("width")),
						baseImageHeight = parseInt(img.attr("height"));


					//slideObject.isRendered = true;
					if(imgScaleMode === 'none') {
						return;
					}
					var containerWidth = self.wrap.width,
						containerHeight = self.wrap.height,
						hRatio,
						vRatio,
						ratio,
						nWidth,
						nHeight,
						cssObj = {};

					if(imgScaleMode === 'fit-if-smaller') {
						if(baseImageWidth > containerWidth || baseImageHeight > containerHeight) {
							imgScaleMode = 'fit';
						}
					}
					if(imgScaleMode === 'fill' || imgScaleMode === 'fit') {   
						hRatio = containerWidth / baseImageWidth;
						vRatio = containerHeight / baseImageHeight;

						if (imgScaleMode  == "fill") {
							ratio = hRatio > vRatio ? hRatio : vRatio;                          
						} else if (imgScaleMode  == "fit") {
							ratio = hRatio < vRatio ? hRatio : vRatio;                    
						} else {
							ratio = 1;
						}

						nWidth = Math.ceil(baseImageWidth * ratio, 10);
						nHeight = Math.ceil(baseImageHeight * ratio, 10);
					} else {                
						nWidth = baseImageWidth;
						nHeight = baseImageHeight;    

					}
					if(imgScaleMode !== 'none') {
						cssObj.width = nWidth;
						cssObj.height = nHeight;

					}
					if (imgAlignCenter) { 
						cssObj.marginLeft = Math.floor((containerWidth - nWidth) / 2);
						cssObj.marginTop = Math.floor((containerHeight - nHeight) / 2);
					}
					img.css(cssObj);
				})
			}
		},

		_setSliderWidth: function() {
			var self = this;

			if (self.st.mode.type !== "centered") {
				self.viewport.css({
					width: self.wrap.width
				});
			}
			else if (self.wrap.width > self.st.collapsePoint) {
				self.wrap.$el.removeClass("ts-collapsed");
			}
			else {
				self.wrap.$el.addClass("ts-collapsed");
			};
		},

		_setSliderHeight: function() {
			var self = this;

			if (typeof self.wrap.height === "number") {
				// Fixed & proportional height
				self.viewport.css({
					height: self.wrap.height
				});
			}
			else if (self.st.mode.type === "scroller" || self.st.mode.type === "centered" || self.st.mode.type === "carousel") {
				// Auto height; scroller and centered only
				//Aply responsive height 
				if(self.st.resizeHeight){
					var articleHeights = $(self.viewport).find("article").map(function() {
					    return $(this).height();
					}).get();

					// Math.max takes a variable number of arguments
					// `apply` is equivalent to passing each height as an argument
					var maxHeight = Math.max.apply(null, articleHeights);
					self.viewport.css({
						height: maxHeight
					});
					$(self.slides.$items).css({
						height: maxHeight
					});
				}
				if (self.viewport.css("height") === "0px" || self.viewport.css("height") == 0 || !self.viewport.css("height")) {
					self.viewport.css({
						height: Math.max.apply(null, self.slides.height)
					});
				};
			}
			else if (self.slides.isLoaded[self.currSlide]) {
				// Auto height; current slide is loaded
				var jsHeight = $(self.slides.$items[self.currSlide]).height();

				if (jsHeight > 0) {
					self.viewport.css({
						height: jsHeight
					});
				}
				else {
					// !This will cause "collapsed" slider
					self.viewport.css({
						height: "auto"
					});
				};
			}
			else {
				// Auto height; current slide is NOT loaded
				var jsHeight = $(self.slides.$items[self.currSlide]).height();

				if (jsHeight > 0) {
					self.viewport.css({
						height: jsHeight
					});
				}
				else {
					// !This will cause "collapsed" slider
					self.viewport.css({
						height: auto
					});
				};
			};
		},

		_adjustSlides: function() {
			var self = this;

			if (self.st.mode.type === "slider") {
				self.cont.width = 0;

				self.slides.$items.each(function(i) {
					var $slide = $(self.slides.$items[i]),
						tempCSS = {};
					
					self.slides.position[i] = - self.cont.width - self.st.sidePaddings/2;
					self.cont.width = self.cont.width + self.wrap.width + self.st.sidePaddings;
					//if (self.wrap.height) tempCSS.height = self.wrap.height;
					tempCSS.left = -self.slides.position[i];

					if (!self.slides.isLoaded[i]) {
						$slide.find("img").loaded(false, function() {
							self.slides.isLoaded[i] = true;
							$slide.addClass("ts-loaded");
						}, true);
					} else {
					};

					$slide.css(tempCSS);
				});
			}
			else if (self.st.mode.type === "centered") {
					self.cont.width = 0;
					self.slides.contRatio = [];
					self.slides.ratio = [];

				if (self.st.mode.lsMinW || self.st.mode.lsMaxW) {
					var lsMinW = self.wrap.width/100 * self.st.mode.lsMinW,
						lsMaxW = self.wrap.width/100 * self.st.mode.lsMaxW;
				};

				if (self.st.mode.ptMinW || self.st.mode.ptMaxW) {
					var ptMinW = self.wrap.width/100 * self.st.mode.ptMinW,
						ptMaxW = self.wrap.width/100 * self.st.mode.ptMaxW;
				};

				self.slides.$items.each(function(i) {
					var $slide = $(self.slides.$items[i]),
						tempCSS = {};

					var dataWidth = $slide.attr("data-width") ? parseFloat($slide.attr("data-width")) : $slide.width(),
						dataHeight = $slide.attr("data-height") ? parseFloat($slide.attr("data-height")) : $slide.height();
					

					if (!self.slides.contRatio[i]) {
						self.slides.contRatio[i] =  dataWidth / dataHeight;

						if (self.slides.contRatio[i] > 1) {
							$slide.addClass("ts-ls");
						}
						else {
							$slide.addClass("ts-pt");
						};
					};

					if (self.wrap.width > self.st.collapsePoint) {
						dataHeight = self.wrap.height;
						dataWidth = self.wrap.height * self.slides.contRatio[i];
	
						if ((lsMinW || lsMaxW) && (dataWidth > dataHeight)) {
							if (lsMinW === lsMaxW || dataWidth > lsMaxW) {
								dataWidth = lsMaxW;
							}
							else if (dataWidth < lsMinW) {
								dataWidth = lsMinW;
							};
						}
						else if ((ptMinW || ptMaxW) && (dataWidth <= dataHeight)) {
							if (ptMinW === ptMaxW || dataWidth > ptMaxW) {
								dataWidth = ptMaxW;
							}
							else if (dataWidth < ptMinW) {
								dataWidth = ptMinW;
							};            
						};
	
						self.slides.ratio[i] = dataWidth / dataHeight;

						tempCSS.height = self.wrap.height;
						tempCSS.width = self.slides.width[i] = dataWidth;
	
						self.slides.position[i] = - self.cont.width;
						self.cont.width = self.cont.width + self.slides.width[i] + self.st.sidePaddings;
						tempCSS.left = -self.slides.position[i];
					}
					else {
						dataHeight = tempCSS.height = self.wrap.height;
						dataWidth = self.slides.width[i] = tempCSS.width = self.wrap.width;
						self.slides.ratio[i] = dataWidth / dataHeight;

						self.slides.position[i] = - self.cont.width;
						self.cont.width = self.cont.width + self.slides.width[i];

						tempCSS.left = -self.slides.position[i];
					};

					// Adjust position to slide center
					self.slides.position[i] = self.slides.position[i] - (self.slides.width[i]/2);


					if (self.slides.ratio[i] > self.slides.contRatio[i]) {
						$slide.removeClass("ts-narrow");
						$slide.addClass("ts-wide");
					}
					else {
						$slide.removeClass("ts-wide");
						$slide.addClass("ts-narrow");
					};

					if (!self.slides.isLoaded[i]) {
						$slide.find("img").loaded(false, function() {
							self.slides.isLoaded[i] = true;
							$slide.addClass("ts-loaded");
						}, true);
					} 
					else {
					};

					$slide.css(tempCSS);

				});
			}
			else if (self.st.mode.type === "scroller") {
				self.cont.width = 0;
				self.slides.ratio = [];
				if (!(typeof self.wrap.height === "number")) {
					self.slides.height = [];
				}
				//determine if max-width has %
				if(typeof self.slides.$items.parents(".slider-wrapper").attr("data-max-width") != "undefined"){
					var dataMaxWidth = (self.slides.$items.parents(".slider-wrapper").width() * parseFloat(self.slides.$items.parents(".slider-wrapper").attr("data-max-width")))/100;
					
				}

				self.slides.$items.each(function(i) {
					var $slide = $(self.slides.$items[i]),
						tempCSS = {};

					var dataWidth = $slide.attr("data-width") ? parseFloat($slide.attr("data-width")) : $slide.width(),
						dataHeight = $slide.attr("data-height") ? parseFloat($slide.attr("data-height")) : $slide.height();
					
					if(dataWidth > dataMaxWidth){
						var dataWidth = dataMaxWidth;
					}
	
					if (dataWidth > 0 && dataHeight > 0) {
						self.slides.ratio[i] =  dataWidth / dataHeight;
					}
					else {
						self.slides.ratio[i] = 1;
					};

	
					if (typeof self.wrap.height === "number") {
						// Fixed & proportional height
						self.slides.width[i] = self.wrap.height * self.slides.ratio[i];
	
						tempCSS.width = self.slides.width[i];
						tempCSS.height = self.slides.width[i] / self.slides.ratio[i]; 
					}
					else if (dataWidth > 0 && dataHeight > 0) {
						// Auto height;
						if (!self.slides.width[i]) tempCSS.width = self.slides.width[i] = dataWidth;
						if (!self.slides.height[i] && !self.st.resizeHeight) { 
							tempCSS.height = "100%";
						};
						self.slides.height[i] = dataHeight;
					}
					else {
						// Auto height;
						$slide.css("height", "auto");

						self.slides.width[i] = $slide.width();
						self.slides.height[i] = $slide.height();

						tempCSS.height = "100%";
					};
					if(self.st.columBasedResize) {
						self.slides.width[i] = $slide.width();
						
					}
					self.slides.position[i] = - self.cont.width;
					self.cont.width = self.cont.width + self.slides.width[i];
					if (i < self.slides.number - 1) self.cont.width += self.st.sidePaddings
					tempCSS.left = -self.slides.position[i] //+ self.st.sidePaddings/2;
					
	
					if (!self.slides.isLoaded[i]) {
						$slide.find("img").loaded(false, function() {
							self.slides.isLoaded[i] = true;
							$slide.addClass("ts-loaded");
						}, true);
					}
					else {
					};
	
					$slide.css(tempCSS);
				});
			}
			else if (self.st.mode.type === "carousel") {
				self.cont.width = 0;

				var perView =  self.st.mode.perView,
					minWidth = self.st.mode.minWidth,
					cellWidth = self.wrap.width/perView;
		
				while (cellWidth < minWidth && perView > 0.31) {
					perView--;
					if (perView < 1) perView = 1;
					cellWidth = self.wrap.width/perView;
				};

				self.perView = perView;
				//self.st.sidePaddings = 0;
		
				self.slides.$items.each(function(i) {
					var $slide = $(self.slides.$items[i]),
						tempCSS = {};

					self.slides.position[i] = - self.cont.width;
					self.cont.width = self.cont.width + cellWidth;
					tempCSS.width = cellWidth - self.st.sidePaddings;
					tempCSS.left = -self.slides.position[i] + self.st.sidePaddings/2;

					$slide.css(tempCSS);
				});
			};

			// Adjusting slides conteiner position and updating navigation
			if ( (self.st.mode.type !== "centered") && (self.cont.width <= self.wrap.width) ) {
				self.noSlide = true;
				self._transitionStart(0, 0, "easeInOutSine", true);
				self.cont.$el.css( "left", (self.wrap.width - self.cont.width) / 2 );

				self.lockLeft = true;
				self.lockRight = true;
				self.ev.trigger("updateNav");
			}
			else if ( (self.st.mode.type === "centered") && (self.slides.number < 2) /* && (self.cont.width <= self.wrap.width / 2) */ ) {
				self.noSlide = true;
				self._transitionStart(0, 0, "easeInOutSine", true);
				self.cont.$el.css( "left", -(self.cont.width) / 2 );

				self.lockLeft = true;
				self.lockRight = true;
				self.ev.trigger("updateNav");
			}
			else {
				self.noSlide = false;
				self.cont.$el.css( "left", "" );

				if (self.lockRight) {
					self.lockLeft = false;
					self.lockRight = true;
					self.ev.trigger("lockRight").trigger("updateNav");
				}
				else if ( self.currSlide <= 0 ) {
					self.lockLeft = true;
					self.lockRight = false;
					self.ev.trigger("lockLeft").trigger("updateNav");
				}
				else if ( self.currSlide > 0 ) {
					self.lockLeft = false;
					self.lockRight = false;
					self.ev.trigger("updateNav");
				};
			};
		},

		_unifiedEvent: function(event) {
			if (event.originalEvent.touches !== undefined && event.originalEvent.touches[0]) {
				event.pageX = event.originalEvent.touches[0].pageX;
				event.pageY = event.originalEvent.touches[0].pageY;
			}
			return event;
		},

		_unifiedX: function() {
			var self = this,
				coord = 0,
				css3dTransform = self.cont.$el.css("transform");

			if (css3dTransform) {
				var css3dArray = css3dTransform.split(", ");
			}

			if (self.features.css3d && css3dTransform !== "none" && css3dArray[0] === "matrix(1") {
				coord = parseFloat(css3dArray[4]);
			}
			else if (self.features.css3d && css3dTransform !== "none" && css3dArray[0] === "matrix3d(1") {
				coord = parseFloat(css3dArray[12]);
			}
			else {
				//coord = self.cont.$el.position().left;
				coord = parseFloat(self.cont.$el.css("left"));
			};

			return coord;
		},

		_bindEvents: function() {
			var self = this;
			if(self.st.transformEnable){
				self.wrap.$el.on("mousedown.theSlider touchstart.theSlider", function(event) {
					if (event.type != "touchstart") event.preventDefault();

					self._onStart( self._unifiedEvent(event) );

					$(document).on("mousemove.theSlider touchmove.theSlider", function(event) {
						self._onMove( self._unifiedEvent(event) );
					});
					$(document).on("mouseup.theSlider mouseleave.theSlider touchend.theSlider touchcancel.theSlider", function(event) {
						$(document).off("mousemove.theSlider mouseup.theSlider mouseleave.theSlider touchmove.theSlider touchend.theSlider touchcancel.theSlider");
						self._onStop( self._unifiedEvent(event) );
					});
				});
			}
		},

		_unbindEvents: function() {
			var self = this;

			self.wrap.$el.off("mousedown.theSlider touchstart.theSlider");
			$(document).off("mousemove.theSlider mouseup.theSlider mouseleave.theSlider touchmove.theSlider touchend.theSlider touchcancel.theSlider");
		},

		_onStart: function(event) {
			var self = this;

			if (!self.drag.isMoving && !self.sliderLock) {
				//self._transitionEnd();

				self.drag.isMoving = true;
				self.drag.startX = event.pageX;
				self.drag.startY = event.pageY;
				self.cont.startX = self._unifiedX();

				self.drag.offsetX = 0;
				self.drag.offsetY = 0;
				self.drag.lockX = false;
				self.drag.lockY = false;
			}
			else {
				//self._transitionCancel();
			};
		},

		_onMove: function(event) {
			var self = this,
				coord = 0;
				//self.pause();
			self.ev.trigger('psOnMove');
			if (self.drag.isMoving) {
				self.drag.offsetX = event.pageX - self.drag.startX;
				self.drag.offsetY = event.pageY - self.drag.startY;

				if ( (Math.abs(self.drag.offsetX) >= self.st.threshold-1) && (Math.abs(self.drag.offsetX) > Math.abs(self.drag.offsetY)) && !self.drag.lockX ) {
					self.drag.lockX = false;
					self.drag.lockY = true;
					if (event.type == "touchmove") self.drag.offsetY = 0;
				} 
				else if( (Math.abs(self.drag.offsetY) >= self.st.threshold-1) && (Math.abs(self.drag.offsetX) < Math.abs(self.drag.offsetY)) && !self.drag.lockY ) {
					self.drag.lockX = true;
					self.drag.lockY = false;
					if (event.type == "touchmove") self.drag.offsetX = 0;
				};

				if (self.drag.lockX && event.type == "touchmove") self.drag.offsetX = 0;
				else if (self.drag.lockY && event.type == "touchmove") self.drag.offsetY = 0;

				if (self.drag.lockY) event.preventDefault();

				self.cont.instantX = self.cont.startX + self.drag.offsetX;

				if ( self.cont.instantX < 0 && self.cont.instantX > -self.cont.width + self.viewport.width()) {
					coord = self.cont.instantX;
				}
				else if (self.cont.instantX >= 0) {
					coord = self.cont.instantX/4;
				}
				else {
					coord = (-self.cont.width + self.viewport.width()) + ((self.cont.width - self.viewport.width() + self.cont.instantX) / 4);
				};

				self._doDrag(coord);
			};


			if (self.st.autoPlay.enabled) {
				self.pause();
			};
		},

		_onStop: function(event) {
			var self = this;
			//self.pause()
			self.ev.trigger('psOnStop');

			if (self.drag.isMoving) {
				self.cont.instantX = self.cont.startX + self.drag.offsetX;

				if (Math.abs(self.drag.offsetX) > self.st.threshold) {
					self.wrap.$el.addClass("ts-interceptClicks");
					self.wrap.$el.one("click.preventClick", function(e) {
						e.preventDefault();
						e.stopImmediatePropagation();
						e.stopPropagation();
					}); 
					window.setTimeout(function() {
						self.wrap.$el.off('click.preventClick');
						self.wrap.$el.removeClass("ts-interceptClicks");
					}, 301);
				};

				self._autoAdjust();
				self._setSliderHeight();

				self.cont.startX = 0;
				self.cont.instantX = 0;
		
				self.drag.isMoving = false;
				self.drag.startX = 0;
				self.drag.startY = 0;
				self.drag.offsetX = 0;
				self.drag.offsetY = 0;
				self.drag.lockX = false;
				self.drag.lockY = false;
			};

			if(self.st.autoPlay.enabled) {
				self.play();
			}

			return false;
		},

		_doDrag: function(coord) {
			var self = this;
		//	self.pause();
			if(self.st.transformEnable){
				if (self.features.css3d) {
					var tempCSS = {};

					tempCSS[self.features.vendor+"transform"] = "translate3d("+coord+"px,0,0)";
					tempCSS["transform"] = "translate3d("+coord+"px,0,0)";
					tempCSS[self.vendor+"transition"] = "";
					tempCSS["transition"] = "";

					self.cont.$el.css(tempCSS);
				}
				else {
					self.cont.$el.css({
						"left": coord
					});
				};
			}
		},

		_calcCurrSlide: function(coord) {
			var self = this,
				tempCurrSlide = self.slides.number - 1;

			self.slides.$items.each(function(i) {
				if ( coord > self.slides.position[i] ) {
					tempCurrSlide = i-1;
					return false;
				};
			});
			if (tempCurrSlide < 0) tempCurrSlide = 0;

			return tempCurrSlide;
		},

		_isRightExceed: function(coord) {
			var self = this,
				edge = 0;

			if (self.st.mode.type === "centered") {
				edge = self.slides.position[self.slides.number - 1];
			}
			else {
				edge = -self.cont.width + self.viewport.width();
			};

			if (coord < edge) {
				return true;
			}
			else {
				return false;
			};
		},

		_autoAdjust: function() {
			var self = this,
				adjustTo = 0,
				duration = 0,
				tempCurrSlide = self.slides.number - 1;

			/*
			if (self.drag.offsetX == 0) {
				console.log("No movement. Canceling _autoAdjust.");
				return false;
			}
			*/

			if (self.cont.instantX >= 0) {
				// leftmost edge reached
				adjustTo = self.slides.position[0];
				self.currSlide = 0;

				self.lockLeft = true;
				self.lockRight = false;
				self.ev.trigger("lockLeft").trigger("updateNav");
			}
			else if ( self._isRightExceed(self.cont.instantX) ) {
				// rightmost edge reached
				if (self.st.mode.type === "centered") {
					adjustTo = self.slides.position[self.slides.number-1];
				}
				else {
					adjustTo = -self.cont.width + self.viewport.width();
				};

				self.currSlide = self._calcCurrSlide(adjustTo);

				self.lockLeft = false;
				self.lockRight = true;
				self.ev.trigger("lockRight").trigger("updateNav");
			}
			else {
				// autoadjust to closest slide
				if (self.drag.offsetX < -self.st.threshold) {
					// flick from right to left
					tempCurrSlide = self._calcCurrSlide(self.cont.instantX) + 1;

					if (self._isRightExceed(self.slides.position[tempCurrSlide])) {
						adjustTo = -self.cont.width + self.viewport.width();

						for ( i = tempCurrSlide; i >= 0; i-- ) {
							if (!self._isRightExceed(self.slides.position[i])) {
								tempCurrSlide = i;
								break;
							}
						}

						self.lockLeft = false;
						self.lockRight = true;
						self.ev.trigger("lockRight").trigger("updateNav");
					}
					else {
						adjustTo = self.slides.position[tempCurrSlide];

						if  ( tempCurrSlide < self.slides.number - 1 ) {
							self.lockLeft = false;
							self.lockRight = false;
							self.ev.trigger("updateNav");
						}
						else {
							self.lockLeft = false;
							self.lockRight = true;
							self.ev.trigger("lockRight").trigger("updateNav");
						};
					};

					self.currSlide = tempCurrSlide;
				}
				else if (self.drag.offsetX > self.st.threshold) {
					// flick from left to right
					self.currSlide = self._calcCurrSlide(self.cont.instantX);
					adjustTo = self.slides.position[self.currSlide];

					if ( self.currSlide > 0 ) {
						self.lockLeft = false;
						self.lockRight = false;
						self.ev.trigger("updateNav");
					}
					else {
						self.lockLeft = true;
						self.lockRight = false;
						self.ev.trigger("lockLeft").trigger("updateNav");
					};
				}
				else {
					// flick cenceled, since it's to short
					adjustTo = self.cont.startX;
				};

			};


			//duration = Math.sqrt(Math.abs(self.cont.instantX - adjustTo)) * 15 + 50;
			// duration = Math.abs(self.cont.instantX - adjustTo)/2 + 100;
			duration = Math.sqrt(Math.abs(self.cont.instantX - adjustTo)) * 10 + 100;
			self._transitionStart(adjustTo, duration, "easeOutSine");
		},

		_transitionStart: function(coord, duration, easing, justSet) {
			var self = this,
				tempCSS = {},
				cssEasing = $.rsCSS3Easing[easing];

			self._transitionEnd();
			self.ev.trigger("beforeTransition");

			if (justSet) {
				if(self.st.transformEnable){
					if (self.features.css3d) {
						tempCSS[self.features.vendor+"transform"] = "translate3d("+coord+"px,0,0)";
						tempCSS["transform"] = "translate3d("+coord+"px,0,0)";
					}
					else {
						//console.log("and, here's the issue");
						tempCSS.left = coord;
					};
				}

				self.cont.$el.css(tempCSS);
				return false;
			}

			self.ev.trigger("beforeTransition");

			self.sliderLock = true;
			clearTimeout(self.lockTimeout);
			self.lockTimeout = setTimeout(function() {
				self.sliderLock = false;
				self.ev.trigger("afterTransition");
			}, duration);
			if(self.st.transformEnable){
				if (self.features.css3d) {
					tempCSS[self.features.vendor+"transform"] = "translate3d("+coord+"px,0,0)";
					tempCSS["transform"] = "translate3d("+coord+"px,0,0)";
					tempCSS[self.features.vendor+"transition"] = "all "+duration+"ms "+cssEasing;
					tempCSS["transition"] = "all "+duration+"ms "+cssEasing;

					self.cont.$el.css(tempCSS);

					self.cont.$el.one("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend", function() {
					
					});
				}
				else {
					self.cont.$el.animate({
						"left": coord
					}, duration, easing);
				};
			}
		},

		_transitionEnd: function() {
			var self = this;
			self.ev.trigger('psTransitionEnd');
			if(self.st.transformEnable){
				if (self.features.css3d) {
					var tempCSS = {};
						tempCSS[self.vendor+"transition"] = "";
						tempCSS["transition"] = "";

					self.cont.$el.css(tempCSS);
				}
				else {
					self.cont.$el.stop();
				};
			}
		},

		_transitionCancel: function() {
			var self = this,
				coord = self.cont.$el.position().left,
				tempCSS = {};

			tempCSS[self.vendor+"transition"] = "";
			tempCSS["transition"] = "";

			self.cont.$el.off("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend");
			if(self.st.transformEnable){
				if (self.features.css3d) {
					var str = self.cont.$el.css("transform"),
						result = str.split(", ");

					coord = result[4];

					tempCSS[self.features.vendor+"transform"] = "translate3d("+coord+"px,0,0)";
					tempCSS["transform"] = "translate3d("+coord+"px,0,0)";

					self.cont.$el.css(tempCSS);
				}
				else {
					self.cont.$el.stop();
					self.cont.$el.animate({
						"left": coord
					}, duration, easing);
				};
			}
		},

		pause: function() {
			var self = this;
			self.ev.trigger('autoPlayPause');
			self._autoPlayRunning = false;
			if( self._autoPlayTimeout) {
				clearTimeout(self._autoPlayTimeout);
				self._autoPlayTimeout = null;
			}
			
		},

		slideTo: function(slideID, justSet) {
			var self = this,
				slideToX = self.slides.position[slideID],
				duration = 0,
				oldID = self.currSlide;
			 self.pause();
			self.ev.trigger('psBeforeAnimStart');

			if (self.noSlide) return false;

			self._transitionEnd();

			if (slideToX >= self.slides.position[0]) {
				// leftmost edge reached
				self.currSlide = 0;

				self.lockLeft = true;
				self.lockRight = false;
				self.ev.trigger("lockLeft").trigger("updateNav");
			}
			else if ( self._isRightExceed(slideToX) || slideID >= self.slides.number - 1 ) {
				// rightmost edge reached
				if (self.st.mode.type === "centered") {
					slideToX = self.slides.position[slideID];
					self.currSlide = slideID;
				}
				else {
					slideToX = -self.cont.width + self.viewport.width();
					self.currSlide = self._calcCurrSlide(slideToX);
				};

				self.lockLeft = false;
				self.lockRight = true;
				self.ev.trigger("lockRight").trigger("updateNav");
			}
			else {
				self.currSlide = slideID;

				self.lockLeft = false;
				self.lockRight = false;
				self.ev.trigger("updateNav");
			};

			//duration = Math.abs(self.slides.position[oldID] - slideToX)/2 + 100;
			duration = Math.sqrt(Math.abs(self.slides.position[oldID] - slideToX)) * 10 + 100;
			self._transitionStart(slideToX, duration, "easeInOutSine", justSet);

			if ( /*$(".auto-play-btn").hasClass('paused')*/self.st.autoPlay.enabled) {
				self.play();
			}
			if(self.st.calcAutoHeight){
				self._setSliderHeight();
			}
		},
		startPlay: function() {
			var self = this;
			self.ev.trigger('autoPlayPlay');
			if (self.currSlide + 1 <= self.slides.number - 1 && !self.lockRight) {
				self.slideTo(self.currSlide + 1);
			}
			else if (self.currSlide >= self.slides.number-1 && self.st.autoPlay.loop) {
				self.slideTo(0);
			}
			else if (self.lockRight && self.st.autoPlay.loop) {
				self.slideTo(0);
			}
		},

		play: function() {
			var self = this;
			self.ev.trigger('autoPlayPlay');
			self._autoPlayRunning = true;
			if(self._autoPlayTimeout) {
				clearTimeout(self._autoPlayTimeout);
			}
			self._autoPlayTimeout = setTimeout( function() {
				self.startPlay();
			}, self.st.autoPlay.delay );
		},

		slideNext: function() {
			var self = this;

			if (self.currSlide + 1 <= self.slides.number - 1) {
				self.slideTo(self.currSlide + 1);
			}
			else {
				return false;
			};
		},

		slidePrev: function() {
			var self = this;

			if (self.currSlide - 1 >= 0) {
				self.slideTo(self.currSlide - 1);
			}
			else if (self.currSlide == 0 && self.lockLeft == false) {
				self.slideTo(self.currSlide);
			}
			else {
				return false;
			};
		},

		update: function() {
			var self = this;

			self._calcSliderSize();
			self._resizeImage();
			self._setSliderWidth();
			self._adjustSlides();
			self._setSliderHeight();
			self._doDrag();

			if (self.noSlide) {
				self.slideTo(0, true);
				self._unbindEvents();
			}
			else {
				self.slideTo(self.currSlide, true);
				self._bindEvents();
			}
		}
	};

	$.fn.thePhotoSlider = function(settings) {
		return this.each(function() {
			new $.thePhotoSlider(this, settings);
		});
	};
/* #Photo slider initialisation
================================================== */
// jQuery(document).ready(function($) {
    var $photoScroller = $(".photo-scroller");
    if($photoScroller.length > 0){
        /* !Set slider */
        $.fn.photoSlider = function() {
            var $el = $(this),
                slides = {},
                thumbs = "";
                $elParent = $el.parents(".photo-scroller");

                slides.$items = $el.children("figure");
                slides.count = slides.$items.length;

            slides.$items.each(function(i) {
                var $this = $(this),
                    $slide = $this.children().first().remove(),
                    src = $slide.attr("href"),
                    $thumbImg = $slide.children("img"),
                    thumbSrc = $thumbImg.attr("src"),
                    thumbAlt = $thumbImg.attr("alt") || '',
                    thumbDataSrc = $thumbImg.attr("data-src"),
                    thumbDataSrcset = $thumbImg.attr("data-srcset"),
                    thumbClass = $thumbImg.attr("class");
                if($thumbImg.hasClass("lazy-load")){
                    var $layzrBg = "layzr-bg";
                }else{
                    var $layzrBg = "";
                }

                // !Captions copying
                $this.find("figcaption").addClass("caption-" + (i+1) + "");
                var $thisCaptionClone = $(this).find("figcaption").clone(true);
                $(".slide-caption").append($thisCaptionClone);
                if (parseInt($elParent.attr("data-thumb-width")) > 0) {
                    var thisWidth = parseInt($elParent.attr("data-thumb-width")),
                        thisHeight = parseInt($elParent.attr("data-thumb-height"));

                    $elParent.removeClass("proportional-thumbs");
                }
                else {
                    var thisWidth = parseInt($thumbImg.attr("width")),
                        thisHeight = parseInt($thumbImg.attr("height"));

                    $elParent.addClass("proportional-thumbs");
                };

                thumbs = thumbs + '<div class="ts-cell" data-width="'+(thisWidth+5)+'" data-height="'+(thisHeight+10)+'"><div class="ts-thumb-img ' + $layzrBg +'"><img class=" '+thumbClass+'" src="'+thumbSrc+'" data-src="'+thumbDataSrc+'" data-srcset="'+thumbDataSrc+'" width="'+thisWidth+'" height="'+thisHeight+'" alt="'+thumbAlt+'"></div></div>';

                $this.prepend('<div class="ts-slide-img"><img src="'+src+'" width="'+$this.attr("data-width")+'" height="'+$this.attr("data-height")+'"  alt="'+thumbAlt+'"></div>');

                
            });
            
            $elParent.append('<div class="scroller-arrow prev"><i></i><i></i></div><div class="scroller-arrow next"><i></i><i></i></div>')

            $el.addClass("ts-cont");
            $el.wrap('<div class="ts-wrap"><div class="ts-viewport"></div></div>');

            var $slider = $el.parents(".ts-wrap"),
                windowW = $window.width(),
                $sliderPar = $elParent,
                $sliderAutoslide = ($sliderPar.attr("data-autoslide") == "true") ? true : false,
                $sliderAutoslideDelay = ($sliderPar.attr("data-delay") && parseInt($sliderPar.attr("data-delay")) > 999) ? parseInt($sliderPar.attr("data-delay")) : 5000,
                $sliderLoop = ($sliderPar.attr("data-loop") === "true") ? true : false,
                $thumbHeight = $sliderPar.attr("data-thumb-height") ? parseInt($sliderPar.attr("data-thumb-height"))+10 : 80+10,
                $slideOpacity = $sliderPar.attr("data-transparency") ? $sliderPar.attr("data-transparency") : 0.5,
                $adminBarH = $("#wpadminbar").length > 0? $("#wpadminbar").height() : 0;

            // !New settings for cells;
            var dataLsMin = $sliderPar.attr("data-ls-min") ? parseInt($sliderPar.attr("data-ls-min")) : 0,
                dataLsMax = $sliderPar.attr("data-ls-max") ? parseInt($sliderPar.attr("data-ls-max")) : 100,
                dataLsFillDt = $sliderPar.attr("data-ls-fill-dt") ? $sliderPar.attr("data-ls-fill-dt") : "fill",
                dataLsFillMob = $sliderPar.attr("data-ls-fill-mob") ? $sliderPar.attr("data-ls-fill-mob") : "fit",
                dataPtMin = $sliderPar.attr("data-pt-min") ? parseInt($sliderPar.attr("data-pt-min")) : 0,
                dataPtMax = $sliderPar.attr("data-pt-max") ? parseInt($sliderPar.attr("data-pt-max")) : 100,
                dataPtFillDt = $sliderPar.attr("data-pt-fill-dt") ? $sliderPar.attr("data-pt-fill-dt") : "fill",
                dataPtFillMob = $sliderPar.attr("data-pt-fill-mob") ? $sliderPar.attr("data-pt-fill-mob") : "fit",
                dataSidePaddings  = $sliderPar.attr("data-padding-side") ? parseInt($sliderPar.attr("data-padding-side")) : 0;

            // !Normalize new settings for cells;
            if (dataLsMax <= 0) dataLsMax = 100;
            if (dataPtMax <= 0) dataPtMax = 100;
            if (dataLsMax < dataLsMax) dataLsMax = dataLsMax;
            if (dataPtMax < dataPtMax) dataPtMax = dataPtMax;

            $slider.addClass("ts-ls-"+dataLsFillDt).addClass("ts-ls-mob-"+dataLsFillMob);
            $slider.addClass("ts-pt-"+dataPtFillDt).addClass("ts-pt-mob-"+dataPtFillMob);

            $slider.find(".ts-slide-img").css({
                "opacity": $slideOpacity
            });
            $slider.find(".video-icon").css({
                "opacity": $slideOpacity
            });


            var $slideTopPadding = ($sliderPar.attr("data-padding-top") && windowW > 760) ? $sliderPar.attr("data-padding-top") : 0,
                $slideBottomPadding = ($sliderPar.attr("data-padding-bottom") && windowW > 760) ? $sliderPar.attr("data-padding-bottom") : 0;

            var $sliderVP = $slider.find(".ts-viewport");
            $sliderVP.css({
                "margin-top": $slideTopPadding+"px",
                "margin-bottom": $slideBottomPadding+"px"
            });
            
            $window.on("debouncedresize", function() {
                if ($sliderPar.attr("data-padding-top") && $window.width() > 760) {
                    $slideTopPadding = $sliderPar.attr("data-padding-top");
                }
                else {
                    $slideTopPadding = 0;
                };

                if ($sliderPar.attr("data-padding-bottom") && $window.width() > 760) {
                    $slideBottomPadding = $sliderPar.attr("data-padding-bottom");
                }
                else {
                    $slideBottomPadding = 0;
                };

                if ($window.width() > 760) {
                    $sliderVP.css({
                        "margin-top": $slideTopPadding+"px",
                        "margin-bottom": $slideBottomPadding+"px"
                    });
                }
                else {
                    $sliderVP.css({
                        "margin-top": 0+"px",
                        "margin-bottom": 0+"px"
                    });
                };
            });

            /* !Initializinig the main slider */
            var $sliderData = $slider.thePhotoSlider({
                mode: {
                    type: "centered",
                    lsMinW: dataLsMin,
                    lsMaxW: dataLsMax,
                    ptMinW: dataPtMin,
                    ptMaxW: dataPtMax,
                },
                height: function() {
                    // if ($(window).width() < 760) {
                    //  return (window.innerHeight);
                    // }else 

                    var $windowH = $window.height(),
                        $adminBarH = $("#wpadminbar").height();
                    if ($(".mixed-header").length > 0 && !$elParent.hasClass('full-screen')){
                        var $headerH = $(".mixed-header").height();
                    }else if(!$elParent.hasClass('full-screen')){                      
                        var $headerH = $(".masthead").height();
                    }else{
                    	 var $headerH = 0;
                    }
                    if($elParent.hasClass('full-screen')){
                    	var $adminBarH = 0;
                    }

                    if ($body.hasClass("transparent") || $slider.parents(".photo-scroller").hasClass("full-screen")) {

                        if(window.innerWidth < dtLocal.themeSettings.mobileHeader.secondSwitchPoint) {
                            return ($windowH - $slideTopPadding - $slideBottomPadding - $headerH - $adminBarH);
                        }else {
                            return ($windowH - $slideTopPadding - $slideBottomPadding - $adminBarH);                            
                        };

                    }else if ($(".mixed-header").length > 0 || $slider.parents(".photo-scroller").hasClass("full-screen")) {

                        if(window.innerWidth < dtLocal.themeSettings.mobileHeader.firstSwitchPoint && !$body.hasClass("responsive-off")) {
                            return ($windowH - $slideTopPadding - $slideBottomPadding - $headerH - $adminBarH);                 
                        }else {
                            if($(".side-header-h-stroke").length > 0){
                                return ($windowH - $slideTopPadding - $slideBottomPadding - $headerH - $adminBarH);
                            }else{
                                return ($windowH - $slideTopPadding - $slideBottomPadding - $adminBarH);
                            }
                        };

                    }else if ($(".side-header").length > 0 || $slider.parents(".photo-scroller").hasClass("full-screen")) {

                        if(window.innerWidth < dtLocal.themeSettings.mobileHeader.firstSwitchPoint && !$body.hasClass("responsive-off")) {
                            return ($windowH - $slideTopPadding - $slideBottomPadding - $headerH - $adminBarH);
                        }else {
                            return ($windowH - $slideTopPadding - $slideBottomPadding - $adminBarH);                            
                        };

                    }else {

                        if(window.innerWidth < dtLocal.themeSettings.mobileHeader.firstSwitchPoint && !$body.hasClass("responsive-off")) {
                            return ($windowH - $slideTopPadding - $slideBottomPadding - $headerH - $adminBarH);                     
                        }else {
                            return ($windowH - $slideTopPadding - $slideBottomPadding - $headerH - $adminBarH);
                        };

                    };
                },
                sidePaddings: dataSidePaddings,
                autoPlay: {
                    enabled: $sliderAutoslide,
                    delay: $sliderAutoslideDelay,
                    loop: $sliderLoop
                }
            }).data("thePhotoSlider");


            var $thumbsScroller = $('<div class="ts-wrap"><div class="ts-viewport"><div class="ts-cont ts-thumbs">'+thumbs+'</div></div></div>');
            $slider.after($thumbsScroller);

            /* !Initializinig the thumbnail stripe */
            var $thumbsScrollerData = $thumbsScroller.thePhotoSlider({
                mode: {
                    type: "scroller"
                },
                height: $thumbHeight
            }).data("thePhotoSlider");


            $(".prev", $this_par).click(function() {
                if (!$sliderData.noSlide) $sliderData.slidePrev();
            });
            $(".next", $this_par).click(function() {
                if (!$sliderData.noSlide) $sliderData.slideNext();
            });

            $sliderData.ev.on("updateNav sliderReady", function() {
                if ($sliderData.lockRight) {
                    $(".next", $elParent).addClass("disabled");
                } else {
                    $(".next", $elParent).removeClass("disabled");
                };

                if ($sliderData.lockLeft) {
                    $(".prev", $elParent).addClass("disabled");
                } else {
                    $(".prev", $elParent).removeClass("disabled");
                };
            });
            if(!!navigator.userAgent.match(/Trident.*rv\:11\./) && headerBelowSliderExists && bodyTransparent){
                var $mastheadHeaderStyle = $mastheadHeader.attr("style")
                $mastheadHeader.attr("style", $mastheadHeaderStyle + "; top:" + $sliderData.wrap.height + "px !important;");
            }

            if ( headerBelowSliderExists && !!!navigator.userAgent.match(/Trident.*rv\:11\./)) { 
                if ($.isFunction(dtGlobals.resetSizes)) {
                    dtGlobals.resetSizes($sliderData.wrap.height);
                }
                if ($.isFunction(dtGlobals.resetMobileSizes)) {
                    dtGlobals.resetMobileSizes($sliderData.wrap.height);
                }
            }

            /*keyboard navigation*/
            window.addEventListener("keydown", checkKeyPressed, false); 
            function checkKeyPressed(e) {
                if (e.keyCode == "37") {
                    if (!$sliderData.noSlide) $sliderData.slidePrev();
                } else if (e.keyCode == "39") { 
                    if (!$sliderData.noSlide) $sliderData.slideNext();
                } 
            }


            // !Active slide indication and thumbnail mechanics: begin */
            $sliderData.ev.on("sliderReady beforeTransition", function() {
                $sliderData.slides.$items.removeClass("act");
                $sliderData.slides.$items.eq($sliderData.currSlide).addClass("act");

                $thumbsScrollerData.slides.$items.removeClass("act");
                $thumbsScrollerData.slides.$items.eq($sliderData.currSlide).addClass("act");

                if($sliderData.slides.$items.eq($sliderData.currSlide).hasClass("ts-video")){
                    $sliderData.slides.$items.parents(".ts-wrap ").addClass("hide-slider-overlay");
                }else if($sliderData.slides.$items.eq($sliderData.currSlide).find(".ps-link").length > 0){
                    $sliderData.slides.$items.parents(".ts-wrap ").addClass("hide-slider-overlay");
                }else{
                    $sliderData.slides.$items.parents(".ts-wrap ").removeClass("hide-slider-overlay");
                };


                var actCaption = $sliderData.slides.$items.eq($sliderData.currSlide).find("figcaption").attr("class");

                $('.slide-caption > figcaption').removeClass("actCaption");
                $('.slide-caption > .'+actCaption).addClass("actCaption");
            });

            $sliderData.ev.on("afterTransition", function() {
                var viewportLeft    = -($thumbsScrollerData._unifiedX()),
                    viewportRight   = viewportLeft + $thumbsScrollerData.wrap.width,
                    targetLeft      = -$thumbsScrollerData.slides.position[$sliderData.currSlide],
                    targetRight     = targetLeft + $thumbsScrollerData.slides.width[$sliderData.currSlide];

                targetLeft = targetLeft - 50;
                targetRight = targetRight + 50;

                if (targetLeft < viewportLeft) {

                    for (i = $thumbsScrollerData.currSlide; i >= 0; i--) {
                        targetLeft = targetLeft + 50;
                        targetRight = targetRight - 50;

                        var tempViewportLeft    = -$thumbsScrollerData.slides.position[i],
                            tempViewportRight   = tempViewportLeft + $thumbsScrollerData.wrap.width;

                        if (targetRight > tempViewportRight) {
                            $thumbsScrollerData.slideTo(i+1);
                            break;
                        } 
                        else if (i === 0) {
                            $thumbsScrollerData.slideTo(0);
                        }
                    }
                }
                else if (targetRight > viewportRight) {
                    $thumbsScrollerData.slideTo($sliderData.currSlide);
                };
            });

            $thumbsScroller.addClass("scroller-thumbnails");
            $thumbsScrollerData.slides.$items.each(function(i) {
                $(this).on("click", function(event) {
                    var $this = $(this);

                    if ($this.parents(".ts-wrap").hasClass("ts-interceptClicks")) return;
                    $sliderData.slideTo(i);
                });
            });

            $(".scroller-thumbnails").layzrInitialisation();
            $sliderData.slides.$items.each(function(i) {
                $(this).on("click", function(event) {
                    var $this = $(this);

                    if ($this.parents(".ts-wrap").hasClass("ts-interceptClicks")) return;
                    $sliderData.slideTo(i);
                });
            });
            // !Active slide indication and thumbnail mechanics: end */

            var $this_par = $slider.parents(".photo-scroller");

            /* !- Autoplay */
            if( $sliderData.st.autoPlay.enabled ){
                $(".auto-play-btn", $this_par).addClass("paused");
            }
            
            $(".auto-play-btn", $this_par).on("click", function(e){
                e.preventDefault();
                var $this = $(this);
                if( $this.hasClass("paused")){
                    $this.removeClass("paused");
                    if (!$sliderData.noSlide) $sliderData.pause();
                    $sliderData.st.autoPlay.enabled = false;
                }else{
                    $this.addClass("paused");
                    if (!$sliderData.noSlide) $sliderData.play();
                    $sliderData.st.autoPlay.enabled = true;
                }
            });

        };

        /* !- Initialize slider */
        $(".photoSlider:not(.slider-simple)").photoSlider();

      
        
        /* !- Show slider*/

        $(".photoSlider").parents(".photo-scroller").css("visibility", "visible");


        
        function launchFullscreen(element) {
            if(element.requestFullscreen) {
                element.requestFullscreen();
            } else if(element.mozRequestFullScreen) {
                element.mozRequestFullScreen();
            } else if(element.webkitRequestFullscreen) {
                element.webkitRequestFullscreen();
            } else if(element.msRequestFullscreen) {
                element.msRequestFullscreen();
            }
        }
        function exitFullscreen() {
            if(document.exitFullscreen) {
                document.exitFullscreen();
            } else if(document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            } else if(document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            }
        };

        /* !- Fullscreen button */
        if(!dtGlobals.isWindowsPhone){
            $(".full-screen-btn").each(function(){
                var $this = $(this),
                    $thisParent = $this.parents(".photo-scroller"),
                    $frame = $thisParent.find(".ts-wrap");
                document.addEventListener("fullscreenchange", function () {
                    if(!document.fullscreen){
                        $this.removeClass("act");
                        $thisParent.removeClass("full-screen");
                        $("body, html").css("overflow", "");
                        var scroller = $frame.data("thePhotoSlider");
                        if(typeof scroller!= "undefined"){
                            scroller.update();
                        };
                    }
                }, false);
                document.addEventListener("mozfullscreenchange", function () {
                    if(!document.mozFullScreen){
                        $this.removeClass("act");
                        $thisParent.removeClass("full-screen");
                        $("body, html").css("overflow", "");
                    }
                }, false);
                document.addEventListener("webkitfullscreenchange", function () {
                    if(!document.webkitIsFullScreen){
                        $this.removeClass("act");
                        $thisParent.removeClass("full-screen");
                        $("body, html").css("overflow", "");
                        var scroller = $frame.data("thePhotoSlider");
                        if(typeof scroller!= "undefined"){
                            scroller.update();
                        };
                    }
                }, false);
                $window.on("debouncedresize", function() {
		        	var scroller = $frame.data("thePhotoSlider");
	                if(typeof scroller!= "undefined"){
	                    scroller.update();
	                };
		         })
            })
             this.fullScreenMode = document.fullScreen || document.mozFullScreen || document.webkitIsFullScreen;
   
            $(".full-screen-btn").on("click", function(e){
                e.preventDefault();
                	var $this = $(this),
                    $thisParent = $this.parents(".photo-scroller"),
                    $frame = $thisParent.find(".ts-wrap"),										
                    $thumbs = $thisParent.find(".scroller-thumbnails").data("thePhotoSlider"),
                    $scroller = $frame.data("thePhotoSlider");
                $this.parents(".photo-scroller").find("figure").animate({"opacity": 0},150);
                if( $this.hasClass("act")){
                
                    $this.removeClass("act");
                    exitFullscreen();
                    $thisParent.removeClass("full-screen");

                    setTimeout(function(){
                        $this.parents(".photo-scroller").find("figure").delay(600).animate({"opacity": 1},300)
                    }, 300);
                }else{
                     $this.addClass("act");
                    $thisParent.addClass("full-screen");
                    launchFullscreen(document.documentElement);
                    $("body, html").css("overflow", "hidden");
                    setTimeout(function(){
                        $this.parents(".photo-scroller").find("figure").delay(600).animate({"opacity": 1},300)
                    }, 300)
                }
                var scroller = $frame.data("thePhotoSlider");
                if(typeof scroller!= "undefined"){
                    scroller.update();
                };
            });
        }

        /* !- Show/hide thumbs */
        $photoScroller.each(function(){
            var $this = $(this);
            
            $(".btn-cntr, .slide-caption", $this).css({
                "bottom": parseInt($this.attr("data-thumb-height")) + 15
            });

            if( $this.hasClass("hide-thumbs")){
                $this.find(".hide-thumb-btn").addClass("act");
                $(".scroller-thumbnails", $this).css({
                    "bottom": -(parseInt($this.attr("data-thumb-height")) +20)
                });
                $(".btn-cntr, .slide-caption", $this).css({
                    "bottom": 5 + "px"
                });
            }
        });
        $(".hide-thumb-btn").on("click", function(e){
            e.preventDefault();
            var $this = $(this),
                $thisParent = $this.parents(".photo-scroller");
            if( $this.hasClass("act")){
                 $this.removeClass("act");
                $thisParent.removeClass("hide-thumbs");
                $(".scroller-thumbnails", $thisParent).css({
                    "bottom": 0
                });
                $(".btn-cntr, .slide-caption", $thisParent).css({
                    "bottom": parseInt($thisParent.attr("data-thumb-height")) + 15
                });

            }else{
                 $this.addClass("act");
                $thisParent.addClass("hide-thumbs");
                $(".scroller-thumbnails", $thisParent).css({
                    "bottom": -(parseInt($thisParent.attr("data-thumb-height")) +20)
                });
                $(".btn-cntr, .slide-caption", $thisParent).css({
                    "bottom": 5 + "px"
                });
            }
        });
    };
// })

    //porthole Slider
    var $portholeSliderClass = $(".rsHomePorthole");
    if ($portholeSliderClass.exists()) {
        var portholeSlider = {};
        portholeSlider.container = $("#main-slideshow");
        portholeSlider.hendheld = $window.width() < 740 && dtGlobals.isMobile ? true : false;
        
        $("#main-slideshow-content").appendTo(portholeSlider.container);

           //Scroller porthole slideshow

        $.fn.portholeScroller = function() {
            var $el = $(this),
                slides = {},
                thumbs = "";

                slides.$items = $el.children("li"),
                slides.count = slides.$items.length;

            slides.$items.each(function(i) {
                var $this = $(this),
                     $slide = $this,
                     $thumbImg = $slide.children("img"),
                     thumbSrc = $thumbImg.attr("data-rstmb"),
                     thumbAlt = $thumbImg.attr("alt") || '',
                     thumbDataSrc = $thumbImg.attr("data-src"),
                     thumbDataSrcset = $thumbImg.attr("data-srcset"),
                     thumbClass = $thumbImg.attr("class");
                 if($thumbImg.hasClass("lazy-load")){
                     var $layzrBg = "layzr-bg";
                 }else{
                     var $layzrBg = "";
                 }
                 thumbs = thumbs + '<div class="ps-thumb-img ' + $layzrBg +'"><img class=" '+thumbClass+'" src="'+thumbSrc+'"  width="150" height="150" alt="'+thumbAlt+'"></div>';
             });

            $el.addClass("ts-cont");
            $el.wrap('<div class="ts-wrap"><div class="ts-viewport portholeSlider-wrap"></div></div>');
          

            var $slider = $el.parents(".ts-wrap"),
                $this_par = $el.parents("#main-slideshow"),
                windowW = $window.width(),
                paddings = $this_par.attr("data-padding-side") ? parseInt($this_par.attr("data-padding-side")) : 0,
                $sliderAutoslideEnable = ( 'true' != $this_par.attr("data-paused") && typeof $this_par.attr("data-autoslide") != "undefined" && !($window.width() < 740 && dtGlobals.isMobile) ) ? true : false,
               // $sliderAutoslide = ( 'true' === $this_par.attr("data-paused") ) ? false : true,
                $sliderAutoslideDelay = $this_par.attr("data-autoslide") && parseInt($this_par.attr("data-autoslide")) > 999 ? parseInt($this_par.attr("data-autoslide")) : 5000,
                $sliderLoop = (  typeof $this_par.attr("data-autoslide") != "undefined" ) ? true : false,
                $sliderWidth = $this_par.attr("data-width") ? parseInt($this_par.attr("data-width")) : 800,
                $sliderHight = $this_par.attr("data-height") ? parseInt($this_par.attr("data-height")) : 400,
                imgMode = $this_par.attr("data-scale") ? $this_par.attr("data-scale") : "none";

            var $sliderData = $slider.thePhotoSlider({
                mode: {
                    type: "slider"
                },
                height: $sliderHight,
                width: $sliderWidth,
                //sidePaddings: paddings,
                resizeImg: true,
                imageScaleMode: imgMode,
                imageAlignCenter:true,
                autoPlay: {
                    enabled: $sliderAutoslideEnable,
                    delay: $sliderAutoslideDelay,
                    loop: $sliderLoop
                }
            }).data("thePhotoSlider");

            //Create thumbs
            var $thumbsScroller = $('<div class="psThumbs"><div class="psThumbsContainer">'+thumbs+'</div></div>');
            $slider.append($thumbsScroller);
            var $psThumb = $(".ps-thumb-img ");
            $psThumb.each(function(i) {
                $(this).on("click", function(event) {
                     var $this = $(this);

                     //if ($this.parents(".ts-wrap").hasClass("ts-interceptClicks")) return;
                     $sliderData.slideTo(i);
                });
             });

            //Tumbs progress
            $(".psThumbsContainer").after('<div class="progress-wrapper"><div class="progress-controls"></div></div>');
            $progressWrap = $(".psThumbsContainer").next();
            $progressHtml = '<div class="progress-mask"><div class="progress-spinner-left" style="animation-duration: '+$sliderAutoslideDelay+'ms;"></div></div><div class="progress-mask"><div class="progress-spinner-right" style="animation-duration: '+$sliderAutoslideDelay+'ms;"></div></div>';
            
            if ($sliderData.st.autoPlay.enabled) {
                if ($progressWrap.find(".progress-mask").length < 1) {
                    $progressWrap.prepend($progressHtml);
                }
            }
            $sliderData.ev.on("autoPlayPlay", function() {
                if ($progressWrap.find(".progress-mask").length < 1) {
                    $progressWrap.prepend($progressHtml);
                }
                $progressWrap.removeClass("paused");
            });

            $sliderData.ev.on("autoPlayPause", function() {
                $progressWrap.find(".progress-mask").remove();
                if (!$sliderAutoslideEnable) {
                    $progressWrap.addClass("paused");
                }
            });

            $sliderData.ev.on("sliderReady beforeTransition", function() {
                //Animate thums container
                var newPos = -$sliderData.currSlide * 40;
                if (newPos == 0) {
                    newPos = 20;
                }
                $psThumb.removeClass("psNavSelected psNavPrev psNavNext psNavVis");
                $psThumb.eq($sliderData.currSlide).addClass("psNavSelected");
                $psThumb.eq($sliderData.currSlide).prev().addClass("psNavPrev");
                $psThumb.eq($sliderData.currSlide).next().addClass("psNavNext");
                $psThumb.eq($sliderData.currSlide).prev().prev().addClass("psNavVis");
                $psThumb.eq($sliderData.currSlide).next().next().addClass("psNavVis");
                $(".psThumbsContainer").css({ transform:'translateY(' +  newPos  + 'px)' });
            })
            $sliderData.ev.on("sliderReady beforeTransition", function() {
                //hide thumb progress on slide change
                $progressWrap.addClass("blurred");
            });
            $sliderData.ev.on("sliderReady afterTransition", function() {
                $progressWrap.removeClass("blurred");
            });
            var dtResizeTimeout;
            $window.on("resize", function() {
                clearTimeout(dtResizeTimeout);
                dtResizeTimeout = setTimeout(function() {
                    $progressWrap.removeClass("blurred");
                }, 200);
            });
            if(!!navigator.userAgent.match(/Trident.*rv\:11\./) && headerBelowSliderExists && bodyTransparent){
                var $mastheadHeaderStyle = $mastheadHeader.attr("style")
                $mastheadHeader.attr("style", $mastheadHeaderStyle + "; top:" + $sliderData.wrap.height + "px !important;");
            }

            if ( headerBelowSliderExists && !!!navigator.userAgent.match(/Trident.*rv\:11\./)) { 
                if ($.isFunction(dtGlobals.resetSizes)) {
                    dtGlobals.resetSizes($sliderData.wrap.height);
                }
                if ($.isFunction(dtGlobals.resetMobileSizes)) {
                    dtGlobals.resetMobileSizes($sliderData.wrap.height);
                }
            }
            //Append slider navigation
            $('<div class="leftArrow"></div><div class="rightArrow"></div>').insertAfter($el);

            $(".leftArrow", $slider).click(function() {
                if (!$sliderData.noSlide) $sliderData.slidePrev();
            });
            $(".rightArrow", $slider).click(function() {
                if (!$sliderData.noSlide) $sliderData.slideNext();
            });

            $sliderData.ev.on("updateNav sliderReady", function() {
                if ($sliderData.lockRight) {
                    $(".rightArrow", $slider).addClass("disabled");
                } else {
                    $(".rightArrow", $slider).removeClass("disabled");
                };

                if ($sliderData.lockLeft) {
                    $(".leftArrow", $slider).addClass("disabled");
                } else {
                    $(".leftArrow", $slider).removeClass("disabled");
                };
                if ($sliderData.lockRight && $sliderData.lockLeft) {
                    $this_par.addClass("hide-arrows");
                };
            });

            //Slider auto play/pause
            if( 'true' === $this_par.attr("data-paused") ){
                $progressWrap.addClass("paused");
            };
            $progressWrap.on("click", function(e){
                e.preventDefault();
                var $this = $(this);
                if( $this.hasClass("paused")){
                    $this.removeClass("paused");
                    if ($progressWrap.find(".progress-mask").length < 1) {
                        $progressWrap.prepend($progressHtml);
                    }
                    if (!$sliderData.noSlide) $sliderData.play();
                    $sliderData.st.autoPlay.enabled = true;
                }else{
                    $this.addClass("paused");
                    if (!$sliderData.noSlide) $sliderData.pause();
                    $sliderData.st.autoPlay.enabled = false;
                    $progressWrap.find(".progress-mask").remove();
                  
                }
            });
        };
        $portholeSliderClass.portholeScroller();
        $portholeSliderClass.css('visibility', 'visible');
        $(".ts-wrap .dt-pswp-item").each(function(){
            var $this = $(this);
           
            $this.parents().removeClass("photoswipe-wrapper").parents('li').addClass("photoswipe-wrapper");
            
        })
        
        
    };
 })