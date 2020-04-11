(function ($) {
    $(function () {
        if ( typeof window.the7ElementorSettingsCache === "undefined" ) {
            window.the7ElementorSettingsCache = {};
        }

        function getWidgetSettingsCache(widgetType, field) {
            if ( ! window.the7ElementorSettingsCache[widgetType] ) {
                window.the7ElementorSettingsCache[widgetType] = {}
            }

            if ( typeof field !== "undefined" ) {
                return window.the7ElementorSettingsCache[widgetType][field];
            }

            return window.the7ElementorSettingsCache[widgetType];
        }

        function setWidgetSettingsCache(widgetType, field, value) {
            if ( ! window.the7ElementorSettingsCache[widgetType] ) {
                window.the7ElementorSettingsCache[widgetType] = {}
            }

            window.the7ElementorSettingsCache[widgetType][field] = value;
        }

        /**
         * @param string postType
         * @param string currentValue
         * @param object $taxonomySelect
         */
        function getTermsOptions(widgetType, taxonomy) {
            var terms = getWidgetSettingsCache(widgetType, "terms");
            var options = [];
            if (terms[taxonomy]) {
                options = terms[taxonomy];
            }

            return options;
        }

        /**
         * @param string postType
         * @param string currentValue
         * @param object $taxonomySelect
         */
        function getTaxonomiesOptions(widgetType, post_type) {
            var taxonomies = getWidgetSettingsCache(widgetType, "taxonomies");
            var options = [];
            if (taxonomies[post_type]) {
                options = taxonomies[post_type];
            }

            return options;
        }

        function appendOptionsTo($selectEl, options, currentValue) {
            var currentArray = window.Array.isArray(currentValue) ? currentValue : [currentValue];

            $selectEl.prop("disabled", true);
            $selectEl.empty();
            $selectEl.append(options.reduce(function (prev, cur, index) {
                var selected = "";
                if (currentArray.indexOf(cur.value) !== -1) {
                    selected = "selected";
                }

                return prev + "<option value=\"" + cur.value + "\"" + selected + ">" + cur.label + "</option>";
            }, ""));

            $selectEl.prop("disabled", false);
        }

        function fillTermsTaxonomy(model, $termsSelect, $taxonomySelect) {
            var widgetType = model.attributes.widgetType;

            appendOptionsTo($termsSelect, getTermsOptions(widgetType, model.getSetting("taxonomy")), model.getSetting("terms"));
            appendOptionsTo($taxonomySelect, getTaxonomiesOptions(widgetType, model.getSetting("post_type")), model.getSetting("taxonomy"));
        }

        function onEditSettings(changedModel, widgetModel) {
            if (!changedModel.attributes.panel) {
                return;
            }

            if (changedModel.attributes.panel.activeSection !== "content_section") {
                return;
            }

            setTimeout(function(model, panel) {
                var $postTypeSelect = panel.$el.find("[data-setting='post_type']");
                var $taxonomySelect = panel.$el.find("[data-setting='taxonomy']");
                var $termsSelect = panel.$el.find("[data-setting='terms']");

                // On post type change.
                $postTypeSelect.on("change", function () {
                    var widgetType = model.attributes.widgetType;
                    var taxonomies = getTaxonomiesOptions(widgetType, $(this).val());

                    if (!taxonomies[0]) {
                        return;
                    }

                    appendOptionsTo($taxonomySelect, taxonomies, null);
                    model.setSetting(taxonomies[0].value);
                    $taxonomySelect.trigger("change");
                });

                // On taxonomy change.
                $taxonomySelect.on("change", function () {
                    var widgetType = model.attributes.widgetType;

                    $termsSelect[0].options.length = 0;
                    appendOptionsTo($termsSelect, getTermsOptions(widgetType, $(this).val()), null);
                    model.setSetting("terms", []);
                });

                fillTermsTaxonomy(model, $termsSelect, $taxonomySelect);
            }, 350, this.model, this.panel);
        }

        elementor.hooks.addAction("panel/open_editor/widget", function (panel, model, view) {
            var $postTypeSelect = panel.$el.find("[data-setting='post_type']");
            var $taxonomySelect = panel.$el.find("[data-setting='taxonomy']");
            var $termsSelect = panel.$el.find("[data-setting='terms']");
            var widgetType = model.attributes.widgetType;

            if (! getWidgetSettingsCache(widgetType, "taxonomies") || ! getWidgetSettingsCache(widgetType, "terms")) {
                var data = {
                    action: "the7_elements_get_widget_taxonomies",
                    _wpnonce: window.the7ElementsWidget._wpnonce
                };
                $.post(window.the7ElementsWidget.ajaxurl, data)
                    .done(function (response) {
                        if (!response) {
                            response = {};
                        }

                        setWidgetSettingsCache(widgetType, "taxonomies", response.taxonomies);
                        setWidgetSettingsCache(widgetType, "terms", response.terms);
                        fillTermsTaxonomy(model, $termsSelect, $taxonomySelect);
                    });
            } else {
                fillTermsTaxonomy(model, $termsSelect, $taxonomySelect);
            }

            // On post type change.
            $postTypeSelect.on("change", function () {
                var widgetType = model.attributes.widgetType;
                var taxonomies = getTaxonomiesOptions(widgetType, $(this).val());

                if (!taxonomies[0]) {
                    return;
                }

                appendOptionsTo($taxonomySelect, taxonomies, null);
                model.setSetting(taxonomies[0].value);
                $taxonomySelect.trigger("change");
            });

            // On taxonomy change.
            $taxonomySelect.on("change", function () {
                var widgetType = model.attributes.widgetType;

                $termsSelect[0].options.length = 0;
                appendOptionsTo($termsSelect, getTermsOptions(widgetType, $(this).val()), null);
                model.setSetting("terms", []);
            });

            elementor.channels.editor.off("change:editSettings", onEditSettings).on("change:editSettings", onEditSettings, {panel: panel, model: model});
        });
    });
})(jQuery);