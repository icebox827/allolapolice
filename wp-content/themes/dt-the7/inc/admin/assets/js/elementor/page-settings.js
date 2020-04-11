jQuery(function ($) {
    "use strict";

    var autoSaveTimeout;

    function arrayIntersect(a, b) {
        var t;
        if (b.length > a.length) {
            t = b;
            b = a;
            a = t;
        }
        return a.filter(function (e) {
            return b.indexOf(e) > -1;
        });
    }

    function activateEditorPageSettingsSection(section) {
        window.$e.route("panel/page-settings/settings");
        window.elementor.getPanelView().currentPageView.activateSection(section)._renderChildren();
    }

    function getControlsOverlay(controls) {
        var controlsHTML = controls.reduce(function (s, e) {
            return s + "<li class=\"the7-elementor-element-setting the7-elementor-element-setting-" + e.action + "\" title=\"" + e.title + "\">" +
                "<i class=\"" + e.icon + "\" aria-hidden=\"true\"></i>" +
                "<span class=\"elementor-screen-only\">" + e.title + "</span>" +
                "</li>";
        }, "");
        controlsHTML = "<div class=\"the7-elementor-overlay\"><ul class=\"the7-elementor-element-settings\">" + controlsHTML + "</ul></div>";

        return $(controlsHTML);
    }

    function removeAllControls() {
        var iframe = $("#elementor-preview-iframe").first().contents();
        var $the7overlays = $(".the7-elementor-overlay-active", iframe);
        $the7overlays.find(".the7-elementor-overlay").remove();
        $the7overlays.removeClass("the7-elementor-overlay-active");
    }

    function addControls($el, controls) {
        var $controlsOverlay;

        controls = controls.filter(function(control) {
            return !control.section || elementor.settings.page.model.controls[control.section];
        });

        if (!controls) {
            return;
        }

        $controlsOverlay = getControlsOverlay(controls);

        controls.forEach(function (control) {
            if (control.events) {
                var events = control.events;
                var $control = $controlsOverlay.find(".the7-elementor-element-setting-" + control.action);
                for (var event in events) {
                    $control.on(event, events[event]);
                }
            }
        });

        $el.addClass("the7-elementor-overlay-active");
        $el.append($controlsOverlay);
    }

    elementor.on("document:loaded", function (document) {
        var iframe = $("#elementor-preview-iframe").first().contents();
        var $elementorEditor = $(".elementor-editor-active #content > .elementor", iframe);

        removeAllControls();

        $(".transparent .masthead", iframe).hover(
            function () {
                $(this).hasClass("sticky-off") && $elementorEditor.children(".elementor-document-handle").addClass("visible");

            },
            function () {
                $(this).hasClass("sticky-off") && $elementorEditor.children(".elementor-document-handle").removeClass("visible");
            }
        );

        if (($("body.elementor-editor-footer")[0] === undefined) && ($("body.elementor-editor-header")[0]  === undefined)){
            addControls($("#sidebar", iframe), [
                {
                    action: "edit",
                    title: "Edit Sidebar",
                    icon: "eicon-edit",
                    section: "the7_document_sidebar",
                    events: {
                        click: function () {
                            activateEditorPageSettingsSection("the7_document_sidebar");

                            return false;
                        }
                    }
                }
            ]);

            if ($("#footer.elementor-footer", iframe)[0] === undefined){
                addControls($("#footer > .wf-wrap > .wf-container-footer > .wf-container", iframe), [
                    {
                        action: "edit",
                        title: "Edit Footer",
                        icon: "eicon-edit",
                        section: "the7_document_footer",
                        events: {
                            click: function () {
                                activateEditorPageSettingsSection("the7_document_footer");

                                return false;
                            }
                        }
                    }
                ]);
            }

            addControls($(".masthead, .page-title", iframe), [
                {
                    action: "edit",
                    title: "Edit Title",
                    icon: "eicon-edit",
                    section: "the7_document_title_section",
                    events: {
                        click: function () {
                            activateEditorPageSettingsSection("the7_document_title_section");

                            return false;
                        }
                    }
                }
            ]);
        }
        elementor.settings.page.model.on("change", function (settings) {
            var iframe = $("#elementor-preview-iframe").first().contents();
            var the7Settings = arrayIntersect(Object.keys(settings.changed), the7Elementor.controlsIds);

            var tobBarColor = settings.changed.the7_document_disabled_header_top_bar_color || settings.changed.the7_document_fancy_header_top_bar_color;
            var headerBgColor = settings.changed.the7_document_disabled_header_backgraund_color || settings.changed.the7_document_fancy_header_backgraund_color;

            if (tobBarColor !== undefined) {
                $(".top-bar .top-bar-bg", iframe).css("background-color", tobBarColor);
            }

            if (headerBgColor !== undefined) {
                $(".masthead.inline-header, .masthead.classic-header, .masthead.split-header, .masthead.mixed-header", iframe).css("background-color", headerBgColor);
            }

            clearTimeout(autoSaveTimeout);
            if (the7Settings.length > 0) {
                autoSaveTimeout = setTimeout(function () {
                    elementor.saver.saveAutoSave({
                        onSuccess: function onSuccess() {
                            elementor.reloadPreview();
                            elementor.once("preview:loaded", function () {
                                if (!settings.controls[the7Settings[0]]) {
                                    return;
                                }
                                setTimeout(function () {
                                    activateEditorPageSettingsSection(settings.controls[the7Settings[0]].section);
                                });
                            });
                        }
                    });
                }, 300);
            }
        });
    });
});