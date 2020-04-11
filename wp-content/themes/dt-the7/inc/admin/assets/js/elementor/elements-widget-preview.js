(function($) {

    /**
     * @param $scope The Widget wrapper element as a jQuery element
     * @param $ The jQuery alias
     */
    var the7ElementsWidgetHandler = function( $scope, $ ) {
        var precessEffects = function($atoms, instant) {
            var k = 1;

            var $itemsToAnimate = $atoms.filter(function() {
                var $this = $(this);

                return !$this.hasClass("shown") && !$this.hasClass("animation-triggered");
            }).each(function() {
                var $this = $(this);
                var timeout = 200;
                if(!instant && dtGlobals.isInViewport($this) && !$this.hasClass("hidden")) {
                    timeout = 100 * k++;
                }

                $this.addClass("animation-triggered");
                setTimeout(function () {
                    $this.removeClass("animation-triggered").addClass("shown");
                }, timeout);
           });
        }

        var calculateColumns = function($dataContainer, $isoContainer) {
            var contWidth = parseInt($dataContainer.attr("data-width"));
            var contNum = parseInt($dataContainer.attr("data-columns"));
            var desktopNum = parseInt($dataContainer.attr("data-desktop-columns-num"));
            var tabletHNum = parseInt($dataContainer.attr("data-h-tablet-columns-num"));
            var tabletVNum = parseInt($dataContainer.attr("data-v-tablet-columns-num"));
            var phoneNum = parseInt($dataContainer.attr("data-phone-columns-num"));
            var contPadding = parseInt($dataContainer.attr("data-padding"));

            $isoContainer.calculateColumns(contWidth, contNum, contPadding, desktopNum, tabletHNum, tabletVNum, phoneNum, "px");
        }

        var DTMasonryControls = (function () {
            function DTMasonryControls(config) {
                var defaults = {
                    paginatorContainer: null,
                    postLimit: 1,
                    curPage: 1,
                    items: [],
                    onPaginate: function () {
                    }
                };

                this.config = $.extend(defaults, config);
            }

            DTMasonryControls.prototype.setCurPage = function (curPage) {
                this.config.curPage = parseInt(curPage);
            };

            DTMasonryControls.prototype.getCurPage = function () {
                return this.config.curPage;
            };

            DTMasonryControls.prototype.reset = function (items) {
                this.config.items = items;
                this.setCurPage(1);
                this.appendControls();
                this._filterByCurPage();
            };

            DTMasonryControls.prototype.appendControls = function () {
            };

            DTMasonryControls.prototype._filterByCurPage = function () {
                this.showItem(this.config.items);
            };

            DTMasonryControls.prototype.hideItem = function (item) {
                item.removeClass('visible').addClass('hidden').hide();
            };

            DTMasonryControls.prototype.showItem = function (item) {
                item.addClass('visible').removeClass('hidden').show();
            };

            return DTMasonryControls;
        }());

        var DTMasonryPaginationControls = (function () {
            function DTMasonryPaginationControls(config) {
                DTMasonryControls.call(this, config);

                var defaults = {
                    previousButtonClass: '',
                    previousButtonLabel: '',
                    pagerClass: '',
                    nextButtonClass: '',
                    nextButtonLabel: '',
                    activeClass: 'act',
                    pagesToShow: 5
                };

                this.config = $.extend(defaults, this.config);

                this.appendControls();

                $('a.act', this.config.paginatorContainer).trigger('click.dtPostsPaginationFilter', {onSetup: true});
            }

            DTMasonryPaginationControls.prototype = new DTMasonryControls();

            DTMasonryPaginationControls.prototype.addEvents = function () {
                var self = this;
                $('a', this.config.paginatorContainer).not('.dots').on('click.dtPostsPaginationFilter', {self: this}, function (event, onSetup) {
                    self.config.onPaginate.call(this, event, onSetup);
                });
                $('a.dots', this.config.paginatorContainer).on('click.dtPostsPaginationDots', {self: this}, function (event) {
                    event.preventDefault();
                    event.data.self.config.paginatorContainer.find('div:hidden a').unwrap();
                    event.data.self.config.paginatorContainer.find('a.dots').remove();
                });
            };

            DTMasonryPaginationControls.prototype.appendControls = function () {
                var pageControls = this.config.paginatorContainer;
                var pageCount = Math.ceil(this.config.items.length / this.config.postLimit);
                var activePage = this.config.curPage;

                pageControls.empty();

                if (pageCount <= 1) {
                    return;
                }

                var i, _i;

                if (activePage !== 1) {
                    pageControls.prepend('<a href="#" class="' + this.config.previousButtonClass + '" data-page-num="' + (activePage - 1) + '">' + this.config.previousButtonLabel + '</a>');
                }

                var pagesToShow = this.config.pagesToShow | 5;
                var pagesToShowMinus1 = pagesToShow - 1;
                var pagesBefore = Math.floor(pagesToShowMinus1 / 2);
                var pagesAfter = Math.ceil(pagesToShowMinus1 / 2);
                var startPage = Math.max(activePage - pagesBefore, 1);
                var endPage = activePage + pagesAfter;

                if (startPage <= pagesBefore) {
                    endPage = startPage + pagesToShowMinus1;
                }

                if (endPage > pageCount) {
                    startPage = Math.max(pageCount - pagesToShowMinus1, 1);
                    endPage = pageCount;
                }

                var dots = '<a href="javascript:void(0);" class="dots">…</a>';
                var leftPagesPack = $('<div style="display: none;"></div>');
                var rightPagesPack = $('<div style="display: none;"></div>');

                for (i = _i = 1; 1 <= pageCount ? _i <= pageCount : _i >= pageCount; i = 1 <= pageCount ? ++_i : --_i) {
                    if (i < startPage && i != 1) {
                        leftPagesPack.append('<a href="#" class="' + this.config.pagerClass + '" data-page-num="' + +i + '">' + i + '</a>');
                        continue;
                    }

                    if (i == startPage && leftPagesPack.children().length) {
                        pageControls.append(leftPagesPack).append($(dots));
                    }

                    if (i > endPage && i != pageCount) {
                        rightPagesPack.append('<a href="#" class="' + this.config.pagerClass + '" data-page-num="' + +i + '">' + i + '</a>');
                        continue;
                    }

                    if (i == pageCount && rightPagesPack.children().length) {
                        pageControls.append(rightPagesPack).append($(dots));
                    }

                    pageControls.append('<a href="#" class="' + this.config.pagerClass + '" data-page-num="' + +i + '">' + i + '</a>');
                }

                if (activePage < pageCount) {
                    pageControls.append('<a href="#" class="' + this.config.nextButtonClass + '" data-page-num="' + (activePage + 1) + '">' + this.config.nextButtonLabel + '</a>');
                }
                pageControls.find('a[data-page-num="' + activePage + '"]').addClass(this.config.activeClass);

                this.addEvents();
            };

            DTMasonryPaginationControls.prototype._filterByCurPage = function () {
                var self = this;
                this.config.items.get().map(function (item, index) {
                    if (self._showOnCurPage(index + 1)) {
                        self.showItem($(item));
                    } else {
                        self.hideItem($(item));
                    }
                });
            };

            DTMasonryPaginationControls.prototype._showOnCurPage = function (index) {
                return this.config.postLimit <= 0 || (this.config.postLimit * (this.getCurPage() - 1) < index && index <= this.config.postLimit * this.getCurPage());
            };

            DTMasonryPaginationControls.prototype._setAsActive = function (item) {
                item.addClass('act').siblings().removeClass('act');
            };

            return DTMasonryPaginationControls;
        }());

        var DTMasonryLoadMoreControls = (function () {
            function DTMasonryLoadMoreControls(config) {
                DTMasonryControls.call(this, config);

                var defaults = {
                    loadMoreButtonClass: '',
                    loadMoreButtonLabel: 'Load more'
                };

                this.config = $.extend(defaults, config);

                this.appendControls();

                $('a.act', this.config.paginatorContainer).trigger('click.dtPostsPaginationFilter', {onSetup: true});
            }

            DTMasonryLoadMoreControls.prototype = new DTMasonryControls();

            DTMasonryLoadMoreControls.prototype.addEvents = function () {
                $('a', this.config.paginatorContainer).on('click.dtPostsPaginationFilter', {self: this}, this.config.onPaginate);
            };

            DTMasonryLoadMoreControls.prototype.appendControls = function () {
                var pageControls = this.config.paginatorContainer;
                var pageCount = Math.ceil(this.config.items.length / this.config.postLimit);
                var activePage = this.config.curPage;
                var self = this;

                pageControls.empty();

                if (pageCount <= 1) {
                    this.config.items.get().map(function (item, index) {
                        self.showItem($(item));
                    });

                    self.config.items.filter('.visible').IsoLayzrJqInitialisation();
                    return;
                }


                if (activePage < pageCount) {
                    pageControls.append('<a href="#" class="' + this.config.loadMoreButtonClass + '"><span class="stick"></span><span class="button-caption">' + this.config.loadMoreButtonLabel + '</span></a>').css("display", "flex");
                } else {
                    pageControls.css("display", "none");
                }

                this.addEvents();
            };

            DTMasonryLoadMoreControls.prototype._filterByCurPage = function () {
                var self = this;
                var postsToShow = self.getCurPage() * self.config.postLimit;

                this.config.items.get().map(function (item, index) {
                    if (index < postsToShow) {
                        self.showItem($(item));
                    } else {
                        self.hideItem($(item));
                    }
                });
            };

            return DTMasonryLoadMoreControls;
        }());

        var DTIsotopeFilter = (function () {
            function DTIsotopeFilter(config) {
                var defaults = {
                    onCategoryFilter: function () {
                    },
                    onOrderFilter: function () {
                    },
                    onOrderByFilter: function () {
                    },
                    categoryContainer: null,
                    orderContainer: null,
                    orderByContainer: null,
                    postsContainer: null,
                    order: 'desc',
                    orderBy: 'date',
                    curCategory: '*'
                };
                this.config = $.extend(defaults, config);

                this.addEvents();
            }

            DTIsotopeFilter.prototype.addEvents = function () {
                var self = this;
                $('a', this.config.categoryContainer).on('click.dtPostsCategoryFilter', {self: this}, function (event) {
                    self.config.onCategoryFilter.call(this, event);
                });
                $('a', this.config.orderContainer).on('click.dtPostsOrderFilter', {self: this}, function (event) {
                    self.config.onOrderFilter.call(this, event);
                });
                $('a', this.config.orderByContainer).on('click.dtPostsOrderByFilter', {self: this}, function (event) {
                    self.config.onOrderByFilter.call(this, event);
                });
            };

            DTIsotopeFilter.prototype.setOrder = function (order) {
                this.config.order = order;
            };

            DTIsotopeFilter.prototype.setOrderBy = function (orderBy) {
                this.config.orderBy = orderBy;
            };

            DTIsotopeFilter.prototype.setCurCategory = function (curCategory) {
                this.config.curCategory = curCategory;
            };

            DTIsotopeFilter.prototype.getFilteredItems = function () {
                return $(this.config.postsContainer.isotope('getFilteredItemElements'));
            };

            DTIsotopeFilter.prototype.getItems = function () {
                return $(this.config.postsContainer.isotope('getItemElements'));
            };

            DTIsotopeFilter.prototype.layout = function () {
                this.config.postsContainer.isotope('layout');
            };

            DTIsotopeFilter.prototype.scrollToTopOfContainer = function (onComplite, bindTo) {
                var scrollTo = this.config.postsContainer.parent();
                var phantomStickyExists = $(".phantom-sticky").exists(),
                    sideHeaderHStrokeExists = $(".sticky-top-line").exists();
                if (phantomStickyExists || sideHeaderHStrokeExists) {
                    var $phantom = $(".masthead");
                } else {
                    var $phantom = $("#phantom");
                }
                $("html, body").animate({
                    scrollTop: scrollTo.offset().top - $phantom.height() - 50
                }, 400, onComplite ? onComplite.bind(bindTo | this) : undefined);
            };

            DTIsotopeFilter.prototype._filterPosts = function () {
                this.config.postsContainer.isotope({
                    filter: this.config.curCategory,
                    sortAscending: 'asc' == this.config.order,
                    sortBy: this.config.orderBy
                });
            };

            DTIsotopeFilter.prototype._setAsActive = function (item) {
                item.addClass('act').siblings().removeClass('act');
            };

            return DTIsotopeFilter;
        }());

        var DTJGridFilter = (function () {
            function DTJGridFilter(config) {
                DTIsotopeFilter.call(this, config);

                var defaults = {
                    showOnCurPage: function () {
                    }
                };
                this.config = $.extend(defaults, this.config);
                this.items = this.config.postsContainer.find('.wf-cell');
                this.filteredItems = this.items;
            }

            DTJGridFilter.prototype = new DTIsotopeFilter();

            DTJGridFilter.prototype.getFilteredItems = function () {
                return this.filteredItems;
            };

            DTJGridFilter.prototype.getItems = function () {
                return this.items;
            };

            DTJGridFilter.prototype.layout = function () {
                var self = this;

                // category filter emulation
                self.items.css("display", "none");
                var itemsCount = 0;
                var visibleItems = [];
                self.filteredItems.each(function () {
                    if (self.config.showOnCurPage(++itemsCount)) {
                        $(this).css("display", "block");
                        visibleItems.push(this);
                    }
                });

                visibleItems = $(visibleItems);
                self.config.postsContainer.data('visibleItems', visibleItems);
                self.config.postsContainer.collage({images: visibleItems});
            };

            DTJGridFilter.prototype._filterPosts = function () {
                var self = this;
                self.filteredItems = self.items.filter(self.config.curCategory);
            };

            return DTJGridFilter;
        }());

        var DTJQueryFilter = (function () {
            function DTJQueryFilter(config) {
                DTIsotopeFilter.call(this, config);

                this.items = this.config.postsContainer.find('.wf-cell');
                this.filteredItems = this.items;
            }

            DTJQueryFilter.prototype = new DTIsotopeFilter();

            DTJQueryFilter.prototype.getFilteredItems = function () {
                return this.filteredItems;
            };

            DTJQueryFilter.prototype.getItems = function () {
                return this.items;
            };

            DTJQueryFilter.prototype.layout = function () {
            };

            DTJQueryFilter.prototype._filterPosts = function () {
                this.items.hide();
                this.filteredItems = this._sortItems(this.items.filter(this.config.curCategory));
                this.filteredItems.detach().prependTo(this.config.postsContainer);
                this.filteredItems.show();
            };

            DTJQueryFilter.prototype._sortItems = function (items) {
                var activeSort = this.config.orderBy;
                var activeOrder = this.config.order;
                var $nodes = $([]);
                $nodes.$nodesCache = $([]);

                items.each(function () {
                    var $this = $(this);
                    $nodes.push({
                        node: this,
                        $node: $this,
                        name: $this.attr("data-name"),
                        date: new Date($this.attr("data-date"))
                    });
                });

                if (activeSort === "date" && activeOrder === "desc") {
                    $nodes.sort(function (a, b) {
                        return b.date - a.date
                    });
                } else if (activeSort === "date" && activeOrder === "asc") {
                    $nodes.sort(function (a, b) {
                        return a.date - b.date
                    });
                } else if (activeSort === "name" && activeOrder === "desc") {
                    $nodes.sort(function (a, b) {
                        var x = a.name.toLowerCase();
                        var y = b.name.toLowerCase();
                        if (x > y) {
                            return -1;
                        }
                        if (x < y) {
                            return 1;
                        }
                        return 0;
                    });
                } else if (activeSort === "name" && activeOrder === "asc") {
                    $nodes.sort(function (a, b) {
                        var x = a.name.toLowerCase();
                        var y = b.name.toLowerCase();
                        if (x < y) {
                            return -1;
                        }
                        if (x > y) {
                            return 1;
                        }
                        return 0;
                    });
                }

                $nodes.each(function () {
                    $nodes.$nodesCache.push(this.node);
                });

                return $nodes.$nodesCache;
            };

            return DTJQueryFilter;
        }());

        var paginate = function(paginationMode, isoContainer, isIsotope, postLimit, showAll, paginatorContainer ) {
            if (paginationMode === "pages") {
                var paginator = new DTMasonryPaginationControls({
                    previousButtonClass: 'nav-prev',
                    previousButtonLabel: '<i class="dt-icon-the7-arrow-0-42" aria-hidden="true"></i>',
                    nextButtonClass: 'nav-next',
                    nextButtonLabel: '<i class="dt-icon-the7-arrow-0-41" aria-hidden="true"></i>',
                    postLimit: postLimit,
                    curPage: 1,
                    pagesToShow: (showAll ? 999 : 5),
                    items: isoContainer.find(".wf-cell"),
                    paginatorContainer: paginatorContainer,
                    onPaginate: function (event, onSetup) {
                        event.preventDefault();

                        var item = $(this);
                        var self = event.data.self;

                        self._setAsActive(item);
                        self.setCurPage(item.attr('data-page-num'));
                        self._filterByCurPage();

                        isIsotope && isoContainer.isotope("layout");

                        if (!onSetup) {
                            self.appendControls();
                        }
                    }
                });
            }

            if (paginationMode === "load-more") {
                var paginator = new DTMasonryLoadMoreControls({
                    loadMoreButtonClass: 'act button-load-more',
                    loadMoreButtonLabel: dtLocal.moreButtonText.loadMore,
                    postLimit: postLimit,
                    curPage: 0,
                    items: isoContainer.find(".wf-cell"),
                    paginatorContainer: paginatorContainer,
                    onPaginate: function (event, onSetup) {
                        event.preventDefault();

                        var self = event.data.self;

                        self.setCurPage(self.getCurPage() + 1);
                        self._filterByCurPage();

                        isIsotope && isoContainer.isotope("layout");

                        if (!onSetup) {
                            self.appendControls();
                        }
                    }
                });
            }
        }

        var $dataAttrContainer = $scope.find(".portfolio-shortcode");
        var paginationMode = $dataAttrContainer.attr("data-pagination-mode");
        var postsLimit = $dataAttrContainer.attr('data-post-limit');
        var showAll = $dataAttrContainer.hasClass('show-all-pages');
        var isIsotope = $dataAttrContainer.hasClass("mode-masonry");

        if (isIsotope) {
            //Masonry layout
            i = $scope.attr("data-id");
            var $isoContainer = $dataAttrContainer.find(".iso-container");

            $isoContainer.addClass("cont-id-" + i).attr("data-cont-id", i);
            jQuery(window).off("columnsReady");
            $isoContainer.off("columnsReady.The7Elements").one("columnsReady.The7Elements.IsoInit", function () {
                $isoContainer.IsoInitialisation('.iso-item', 'masonry', 400);
                paginate(paginationMode, $isoContainer, isIsotope, postsLimit, showAll, $dataAttrContainer.find('.paginator'));
            });

            $isoContainer.on("columnsReady.The7Elements.IsoLayout", function () {
                $(".preload-me", $isoContainer).heightHack();
                $isoContainer.isotope("layout");
            });

            $(window).off("debouncedresize.The7Elements").on("debouncedresize.The7Elements", function () {
                $(".elementor-widget-container .mode-masonry").each(function() {
                    var $dataAttrContainer = $(this);
                    calculateColumns($dataAttrContainer, $dataAttrContainer.find(".iso-container"));
                });
            });

            calculateColumns($dataAttrContainer, $isoContainer);
        } else {
            paginate(paginationMode, $dataAttrContainer.find(".dt-css-grid"), isIsotope, postsLimit, showAll, $dataAttrContainer.find('.paginator'));
        }

        if ($dataAttrContainer.is(".content-rollover-layout-list:not(.disable-layout-hover)")) {
            $dataAttrContainer.find(".post-entry-wrapper").clickOverlayGradient();
        }

        precessEffects($dataAttrContainer.find(".wf-cell"), $dataAttrContainer.hasClass("loading-effect-none"));

        // Stub anchors.
        $dataAttrContainer.find("a").on("click", function(e) {
            e.preventDefault();

            return false;
        });
    };

    // Make sure you run this code under Elementor.
    $( window ).on( 'elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/the7_elements.default', the7ElementsWidgetHandler );
    } );

})(jQuery);