jQuery(function ($) {
    "use strict";

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

    function addControls($el, controls) {
        var $controlsOverlay = getControlsOverlay(controls);

        // Add events.
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

    elementor.on("preview:loaded", function () {
        setTimeout(function () {
            var iframe = $("#elementor-preview-iframe").first().contents();

            addControls($("#sidebar", iframe), [
                {
                    action: "edit",
                    title: "Edit Sidebar",
                    icon: "eicon-edit",
                    events: {
                        click: function () {
                            activateEditorPageSettingsSection("the7_document_sidebar");

                            return false;
                        }
                    }
                }
            ]);

            addControls($("#footer > .wf-wrap > .wf-container-footer > .wf-container", iframe), [
                {
                    action: "edit",
                    title: "Edit Footer",
                    icon: "eicon-edit",
                    events: {
                        click: function () {
                            activateEditorPageSettingsSection("the7_document_footer");

                            return false;
                        }
                    }
                }
            ]);

            addControls($(".masthead, .page-title", iframe), [
                {
                    action: "edit",
                    title: "Edit Title",
                    icon: "eicon-edit",
                    events: {
                        click: function () {
                            activateEditorPageSettingsSection("the7_document_title_section");

                            return false;
                        }
                    }
                }
            ]);

        }, 10);
    });

    elementor.settings.page.model.on("change", function (settings) {
        var the7Settings = arrayIntersect(Object.keys(settings.changed), the7Elementor.controlsIds);

        if (the7Settings.length > 0) {
            elementor.saver.saveAutoSave({
                onSuccess: function onSuccess() {
                    elementor.reloadPreview();
                    elementor.once("preview:loaded", function () {
                        if(settings.controls[the7Settings[0]]) {
                            activateEditorPageSettingsSection(settings.controls[the7Settings[0]].section);
                        }
                    });
                }
            });
        }
    });
});