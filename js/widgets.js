/**
 * Theme javascript helper.
 *
 * App developers use the following functions to create widgets in
 * there app.  This set of functions runs in parallel with the
 * widgets defined in core/widgets.php.
 *
 * @category  Theme
 * @package   ClearOS
 * @author    ClearFoundation <developer@clearfoundation.com>
 * @copyright 2014 ClearFoundation
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 * @link      http://www.clearfoundation.com/docs/developer/theming/
 */

/**
 * Anchor widget.
 *
 * See core/widgets.php
 *
 * @param string $url        URL
 * @param string $text       anchor text
 * @param array  $options    options
 */

function theme_anchor(url, text, options)
{
    id = 'anchor-' + Math.floor(Math.random() * 1000);
    button_class = 'btn btn-sm btn-primary';
    data_ref = '';
    data_type = '';
    button_group_start = '<div class="btn-group">';
    button_group_end = '</div>';
    target = '';

    // TODO - Rethink 'data-' passing
    if (typeof options != 'undefined') {
        if (options.id)
            id = options.id;

        if (options.external)
            text += '<i class="fa fa-external-link theme-text-icon-spacing"></i>';
        if (options.buttons == false) {
            button_class = '';
            button_group_start = '';
            button_group_end = '';
        } else if (options.buttons == 'extra-small') {
            button_class = 'btn btn-xs btn-primary';
        } else if (options.buttons) {
            button_class = 'btn btn-primary';
        }
        if (typeof options.classes != 'undefined')
            button_class += ' ' + options.classes;
        if (typeof options.data_ref != 'undefined')
            data_ref = ' data-ref="' + options.data_ref + '"';
        if (typeof options.data_type != 'undefined')
            data_type = ' data-type="' + options.data_type + '"';
        if (typeof options.target != 'undefined')
            target = ' target="' + options.target + '"';
    }

    return button_group_start + '<a href="' + url + '" id="' + id + '" class="' + button_class + '"' + data_ref + data_type + target + '>' +
            text + '</a>' + button_group_end;
}

/**
 * Anchors widget.
 *
 * @param object links   links
 * @param array  options options
 */

function theme_anchors(links, options)
{
    var html = '';
    button_group_start = '<div class="btn-group">';
    button_group_end = '</div>';
    $.each(links, function( index, value ) {
        id = 'anchor-' + Math.floor(Math.random() * 1000);
        button_class = 'btn btn-sm btn-primary';
        data_ref = '';
        data_type = '';
        target = '';
        text = links[index].text;
        if (typeof links[index].options != 'undefined') {
            if (links[index].options.id)
                id = links[index].options.id;

            if (links[index].options.external)
                text += '<i class="fa fa-external-link theme-text-icon-spacing"></i>';
            if (links[index].options.buttons == false) {
                button_class = '';
            } else if (links[index].options.buttons == 'extra-small') {
                button_class = 'btn btn-xs btn-primary';
            } else if (links[index].options.buttons == 'normal') {
                button_class = 'btn btn-primary';
            } else if (links[index].options.buttons == 'secondary') {
                button_class = 'btn btn-secondary';
            } else if (links[index].options.buttons) {
                button_class = 'btn btn-sm btn-primary';
            }
            if (typeof links[index].options.classes != 'undefined')
                button_class += ' ' + links[index].options.classes;
            if (typeof links[index].options.data_ref != 'undefined')
                data_ref = ' data-ref="' + links[index].options.data_ref + '"';
            if (typeof links[index].options.target != 'undefined')
                target = ' target="' + links[index].options.target + '"';
            if (typeof links[index].options.data_type != 'undefined')
                data_type = ' data-type="' + links[index].options.data_type + '"';
        }
        html += '<a href="' + links[index].url + '" id="' + id + '" class="' + button_class + '"' + data_ref + data_type + target + '>' + text + '</a>';
    });
    return button_group_start + html + button_group_end;
}

/**
 * Dialog box.
 */

function theme_dialog_box(id, title, message, options)
{
    var dialog_type = BootstrapDialog.TYPE_INFO;

    if (title == lang_warning)
        dialog_type = BootstrapDialog.TYPE_WARNING;

    if (typeof options != 'undefined') {
        if (options.type == 'success')
            dialog_type = BootstrapDialog.TYPE_SUCCESS;
        else if (options.type == 'info')
            dialog_type = BootstrapDialog.TYPE_INFO;
        else if (options.type == 'warning')
            dialog_type = BootstrapDialog.TYPE_WARNING;
        else if (options.type == 'danger')
            dialog_type = BootstrapDialog.TYPE_DANGER;
    }

    var modal_dialog = new BootstrapDialog({
        type: dialog_type,
        title: title,
        buttons: [{
            label: lang_close,
            action: function(my_dialog) {
                if (typeof options != 'undefined' && options.reload_on_close)
                    window.location.reload();
                else if (typeof options != 'undefined' && options.redirect_on_close)
                    window.location = options.redirect_on_close;
                else
                    my_dialog.close();
            }
        }],
        message: message
    });
    modal_dialog.open();
    return modal_dialog;
}

/**
 * Dialog box close.
 */

function theme_dialog_close(obj)
{
    obj.close();
}

/**
 * Add key/value pair to DOM.
 * 
 * @param string key     key
 * @param string value   value
 * @param object options options
 */

function theme_key_value_pair(key, value, options)
{
    var row_dom_id = 'row-' + Math.floor(Math.random() * 1000);
    var key_dom_id = 'key-' + Math.floor(Math.random() * 1000);
    var value_dom_id = 'value-' + Math.floor(Math.random() * 1000);
    var row_classes = '';
    var key_classes = '';
    var value_classes = '';
    var key_col = 6;
    var value_col = 6;

    if (typeof options != 'undefined') {
        if (typeof options.row != 'undefined') {
            if (options.row.id != 'undefined')
                row_dom_id = options.row.id;
            if (options.row.classes != 'undefined')
                row_classes = options.row.classes;
        }
        if (typeof options.key != 'undefined') {
            if (options.key.id != 'undefined')
                key_dom_id = options.key.id;
            if (options.key.width != 'undefined')
                key_col = options.key.width;
            if (options.key.classes != 'undefined')
                key_classes = options.key.classes;
        }
        if (typeof options.value != 'undefined') {
            if (options.value.id != 'undefined')
                value_dom_id = options.value.id;
            if (options.value.width != 'undefined')
                value_col = options.value.width;
            if (options.value.classes != 'undefined')
                value_classes = options.value.classes;
        }
    }
    return '<div class="row ' + row_classes + '" id="' + row_dom_id + '">' +
        '  <div class="col-lg-' + key_col + ' ' + key_classes + ' theme-field" id="' + key_dom_id + '">' + key + '</div>' +
        '  <div class="col-lg-' + value_col + ' ' + value_classes + '" id="' + value_dom_id + '">' + value + '</div>' +
        '</div>';
}

/**
 * Add key/value pair to sidebar widget.
 * 
 * @param string key     key
 * @param string value   value
 * @param object options options
 */

function theme_add_sidebar_pair(key, value, options)
{
    var row_dom_id = 'row-' + Math.floor(Math.random() * 1000);
    var key_dom_id = 'key-' + Math.floor(Math.random() * 1000);
    var value_dom_id = 'value-' + Math.floor(Math.random() * 1000);

    if (typeof options != 'undefined') {
        if (typeof options.row != 'undefined') {
            if (options.row.id != 'undefined')
                row_dom_id = options.row.id;
        }
        if (typeof options.key != 'undefined') {
            if (options.key.id != 'undefined')
                key_dom_id = options.key.id;
        }
        if (typeof options.value != 'undefined') {
            if (options.value.id != 'undefined')
                value_dom_id = options.value.id;
        }
    }
    $('#sidebar_additional_info_row').after(
        '<div class="row" id="' + row_dom_id + '">' +
        '  <div class="col-xs-6 theme-field" id="' + key_dom_id + '">' + key + '</div>' +
        '  <div class="col-xs-6" id="' + value_dom_id + '">' + value + '</div>' +
        '</div>'
    );
}

/**
 * Format a date.
 */

function theme_format_date(value, format)
{
    // Uses lightweight jquery plugin 
    // https://github.com/phstc/jquery-dateFormat
    $.format = DateFormat.format;
    return $.format.date(value, format);
}

/**
 * Enabled/Disabled display.
 */

function theme_enabled_disabled(state)
{
    if (state)
        return '<i class="fa fa-check-circle"></i>';
    else
        return '-';
}

/**
 * Infobox.
 */

function theme_infobox(type, title, message, options)
{
    if (type === 'critical') {
        box_class = 'alert-danger';
        icon_class = 'fa fa-times-circle';
    } else if (type === 'warning') {
        box_class = 'alert-warning';
        icon_class = 'fa fa-exclamation-triangle';
    } else if (type === 'info') {
        box_class = 'alert-info';
        icon_class = 'fa fa-info-circle';
    } else {
        box_class = 'alert-success';
        icon_class = 'fa fa-check-circle';
    }

    id = (options != undefined && options.id != undefined) ? ' id="' + options.id + '"' : '';

    return ' \
        <div class="theme-infobox alert ' + box_class + '"' + id + '> \
            <div class="theme-infobox-icon"><i class="' + icon_class + '"></i></div> \
            <div class="theme-infobox-title">' + title + '</div> \
            <div class="theme-infobox-content">' + message + '</div> \
        </div> \
    ';
}

/**
 * Modal infobox open.
 */

function theme_modal_infobox_open(id, options)
{
    $('#' + id).modal({show: true, backdrop: 'static'});
}

/**
 * Modal infobox close.
 */

function theme_modal_infobox_close(id, options)
{
    $('#' + id).modal('hide');
}

/**
 * Progress bar.
 */

function theme_progress_bar(value, options)
{

    var id = '';
    var classes = [];
    if (typeof options != undefined && options != null) {
        if (options.id != undefined)
            id = 'id="' + options.id + '"';
        if (options.no_animation != undefined)
            classes.push('theme-progress-bar-no-animation');
    }
    
    return ' \
        <div class="progress sm">\
            <div ' + id + ' class="progress-bar progress-bar-primary sm ' + classes.join(' ') + '" role="progressbar" valuenow="' + value + '" aria-valuemin="0" aria-valuemax="100" style="width:' + value + '%">\
                <span class="sr-only">' + value + '%</span>\
            </div>\
        </div>\
    ';
}

/**
 * Set progress bar.
 */

function theme_set_progress_bar(id, value, options)
{
    $('#' + id).css('width', value + '%').attr('aria-valuenow', value);
}

/**
 * Loading whirlygig.
 */

function theme_loading(options) {
    var id = null;
    var classes = '';
    var text = '';
    var center_begin = '';
    var center_end = '';
    var form_control = '';

    if (options != undefined) {
        if (options.id)
            id = options.id;
        if (options.classes)
            classes = options.classes;
        if (options.text)
            text = '<span style=\'margin-left: 5px;\'>' + options.text + '</span>';
        if (options.form_control)
            form_control = 'class=\'form-control\'';
        if (options.center) {
            center_begin = '<div ' + (id != null ? 'id="' + id + '"' : '') + ' style=\'width: 100%; text-align: center;\'>';
            center_end = '</div>';
        } else {
            center_begin = '<span ' + form_control + ' ' + ' ' + (id != null ? 'id="' + id + '"' : '') + '>';
            center_end = '</span>';
        }
    } else {
        center_begin = '<div' + (id != null ? ' id="' + id + '"' : '') + '>';
        center_end = '</div>';
    }

    return center_begin + '<i class=\'fa fa-spinner fa-spin ' + classes + '\'></i>' + text + center_end;
}

/**
 * Remove loading whirlygig.
 */

function theme_loaded(id) {
    // May be a box overlay
    if ($('#' + id + ' .clearos-loading-overlay').length != 0) {
        $('#' + id + ' .clearos-loading-overlay').hide();
        return;
    }
    // Or may be a loading widget
    $('#' + id).hide();
}

/**
 * Screenshots.
 */

function theme_screenshots(basename, screenshots) {
    var html = '';

    // Themers...do not change domID of img tag...used to fetch PNG from static.clearsdn.com.

    for (i = 0 ; i < screenshots.length; i++) {
        html += '\
            <a href="/cache/' + screenshots[i].filename + '" data-lightbox="ss-set" data-title="' + screenshots[i].caption + '">\
                <img id="ss-' + basename + '_' + screenshots[i].index + '" data-index="' + screenshots[i].index +'" src="/clearos/themes/ClearOS-Admin/img/placeholder.png" class="theme-screenshot-img">\
            </a>\
        ';
    }

    return html;
}

/**
 * Related app widget.
 */

function theme_related_app(type, list)
{
    html = '<div class="row">';
    for (index = 0 ; index < list.length; index++) {
        app = list[index];
        box_class = 'box-primary';

        if (type == 'complimentary')
            box_class = 'box-primary';
        else if (type == 'other_by_devel')
            box_class = 'box-warning';
        html += '\
            <div class="col-md-6 box ' + box_class + ' marketplace-related-app" id="box-' + app.basename + '">\
                <div class="box-header">\
                    <h3 class="box-title">' + app.name + '</h3>\
                </div>\
                <div class="box-body">\
                    <div class="marketplace-app-info">\
                        <div class="marketplace-app-lhs">\
                            <div class="marketplace-app-info-icon">\
                                <div class="theme-app-logo-container">\
                                    <figure id="app-logo-' + app.basename + '" data-basename="' + app.basename + '" class="theme-app-logo theme-placeholder">\
                                        ' + get_placeholder("svg") + '\
                                    </figure>\
                                </div>\
                            </div>\
                            <div class="marketplace-app-info-rating">' + theme_star_rating(app.rating) + '</div>\
                        </div>\
                        <div class="marketplace-app-rhs">\
                            <div class="marketplace-app-info-description">\
                                <p>' + app.description.replace(/(\r\n|\n|\r)/g, '</p><p>') + '</p>\
                            </div>\
                        </div>\
                        <div style="clear: both;"></div>\
                    </div>\
                </div>\
                <div class="box-footer">\
                    <div class="marketplace-app-info-more pull-right">\
                        <a href="/app/marketplace/view/' + app.basename + '">' + lang_marketplace_learn_more + '</a>\
                    </div>\
                </div>\
            </div>\
        ';
    }
    html += '</div>';
    $('#app_' + type).append(html);

    $('#app_' + type).append('\
        <script type="text/javascript">\
            $("#app_' + type + ' .marketplace-app-info-description").dotdotdot({\
                ellipsis: "..."\
            });\
        </script>\
    ');
}

/**
 * Summary table data.
 *
 * This is javascript helper for loading data summary tables (i.e. the
 * theme_summary_table() function in page/widgets.php).
 *
 * @param string $table_id   table ID
 * @param array  $data       data set
 * @param array  $data_type  data types for the data set
 * @param array  $urls       array of URLs associated with data set
 * @param string $highlight  todo
 * @param string $sort       todo
 * @param string $report_id  ID of report related to the table (if relevant)
 */

function theme_summary_table(table_id, data, data_type, urls, highlight, sort, report_id) {

    // Create reference to datatable
    var table = $('#' + table_id).dataTable();

    // Bail if datatable does not exist
    if ($('#' + table_id).val() == undefined)
        return;

    // Clear the table
    table.fnClearTable();

    // Add rows to the data table
    for (i = 0; i < data.length; i++) {
        var row = new Array();

        for (j = 0; j < data[i].length; j++) {
            // Converting to human readable (e.g. IP addresses) can mess up sorting.
            // Add hidden data that preserves the sort order.
            var hidden_item = '';

            if (data_type[j] == 'ip')
                hidden_item = '<span style="display: none">' + data[i][j] + '</span>';
            else
                hidden_item = '';

            // Change item in table to a URL if specified
            var item = _report_friendly_format(data[i][j], data_type[j]);

            if (urls[j])
                item = '<a href="' + urls[j] + item + '">' + item + '</a>';

            row.push(hidden_item + item);
        }

        table.fnAddData(row);
    }

    // Sort
    table.fnSort( [ [highlight, sort] ] );
    table.fnAdjustColumnSizing();

    // TODO: review
    // For data tables that are linked to charts, we provide a callback.
    // Whenever a datatable is sorted, the callback is triggered.
    if (report_id != null)
        table.bind('sort', function () { clearos_report_trigger( 'Sort', table, report_id ); })
}

function get_option_key(obj, keys) {
    if (typeof keys == 'string')
        keys = keys.split('.');
    var last = keys.pop();
    for (var i in keys) {
        if (!obj.hasOwnProperty(keys[i]))
            break;
        obj = obj[keys[i]];
    }
    if (obj.hasOwnProperty(last))
        return obj[last];
    return null;
}

/**
 * Chart creator.
 *
 * @param string $chart_id    chart ID
 * @param string $chart_type  chart type
 * @param string $data        standard data set
 * @param array  $data_titles data titles
 * @param array  $data_types  data types
 * @param array  $data_units  data units
 * @param object $options     options
 *
 * Supported $options: (see "Defaults" section below for details)
 * - options.xaxis_label = Label for the x-axis
 * - options.yaxis_label = Label for the y-axis
 * - options.series_threshold
 * - options.series_label_threshold
 */

function theme_chart(
    chart_id,
    chart_type,
    data,
    data_titles,
    data_types,
    data_units,
    options
)
{
    //-------------------------
    // O V E R V I E W
    //-------------------------

    // The data is passed into this function in a generic way.  This makes
    // it possible to support different chart engines, but it also makes theme
    // development more complex.

    //-------------------------
    // D E F A U L T S
    //-------------------------

    if (typeof options === 'undefined')
        options = new Object();

    // The app developer can limit the number of data points to display,
    // e.g. charting the top 10 domains in the web proxy report.
    if (typeof options['series_threshold'] == 'undefined')
        options['series_threshold'] = 2000; /* TODO: unlimited? */

    // Only label an item in the series above this threshold
    if (typeof options['series_label_threshold'] == 'undefined')
        options['series_label_threshold'] = 0.03;

    // Show labels by default
    if (typeof options['series_label_show'] == 'undefined')
        options['series_label_show'] = true;

    // Usually just for pie charts, see "data manipulation" section below
    if (typeof options['series_sum_above_threshold'] == 'undefined')
        options['series_sum_above_threshold'] = false;

    // Label precision (eg. decimal places)
    if (typeof options['series_label_precision'] == 'undefined')
        options['series_label_precision'] = 1;

    // Series title
    //---------------------------------------------------
    // The first item in the data set is the x-axis, series labels are the rest.
    // Consider the load average data:
    // date | 1-minute | 5-minute | 15-minute

    series_titles = data_titles;
    series_titles.shift();

    //----------------------------------
    // D A T A  M A N I P U L A T I O N
    //----------------------------------

    // This is where we massage the data set.  For one, data is converted
    // into flot-friendly formats, e.g.
    //
    // - IP addresses
    // - Timestamps in various formats
    //
    // In addition, the app developer can send a full data set to the chart
    // function and then set data set thresholds.  
    //
    // Example 1: the pie chart that shows the CPU process hogs shows the 
    // top 7 hogs, but then summarizes the rest of the process into the
    // "other" category.
    //
    // Example 2: the "top domains" list in the web proxy can be thousands
    // of data points, but the app developer can limit it to the top 20.

    var chart_data = new Array();  /* holds massaged data */
    var max_data_points = (data.length > options['series_threshold']) ? options['series_threshold'] : data.length;

    for (i = 0; i < data.length; i++) {
        number_of_row_items = data[i].length;

        if ((i >= max_data_points) && !options['series_sum_above_threshold']) 
            break;

        for (j = 0; j < number_of_row_items; j++) {

            var item = _report_friendly_format(data[i][j], data_types[j]);

            if (i >= max_data_points) {
                chart_data[max_data_points-1][j] = chart_data[max_data_points-1][j] + item;
                chart_data[max_data_points-1][0] = 'Others';
            } else {
                if (typeof chart_data[i] == 'undefined')
                    chart_data[i] = new Array();

                chart_data[i][j] = item;
            }
        }
    }

    //---------------
    // D A T A  S E T
    //---------------

    // This section is non-intuitive.  We basically have to take the standard
    // data format and convert it to the formats and series data that is
    // used in flot - https://github.com/flot/flot/blob/master/API.md#data-format
    //
    // The code below looks crazy, but it's really just shuffling data around.
    //  Every flot chart has a slight different data_set (the second parameter
    //  passed into $.plot("#" + chart_id, data_set, chart_options);

    data_set = Array();
    ticks = Array();

    // Pie chart data set
    if (chart_type == 'pie') {
        for (i = 0; i < chart_data.length; i++) {
            data_set[i] = {
                label: chart_data[i][0],
                data: chart_data[i][1],
                color: get_option_key(options, 'series.color.' + i) != null ? get_option_key(options, 'series.color.' + i) : i
            }
        }

    // Bar chart data set
    } else if (chart_type == 'bar') {
        var bar_data = Array();

        for (i = 0; i < chart_data.length; i++) {
            ticks[i] = [i, chart_data[i][0] ];
            bar_data[i] = [i, chart_data[i][1]]
        }

        data_set[0] = {
            label: series_titles[0],
            data: bar_data
        }

    // Horizontal bar chart data set
    } else if (chart_type == 'horizontal_bar') {
        var bar_data = Array();

        for (i = 0; i < chart_data.length; i++) {
            ticks[i] = [ i, chart_data[i][0] ];
            bar_data[i] = [data[i][1], i]
        }

        data_set[0] = {
            label: series_titles[0],
            data: bar_data
        }

    // Timeline series data set
    } else {
        series = new Array();
        // Timeline series is a different beast. TODO: document
        for (i = 0; i < chart_data.length; i++) {
            number_of_row_items = chart_data[i].length;
            x_item = chart_data[i][0];

            for (j = 1; j < number_of_row_items; j++) {
                // Create new series array
                if (typeof series[j-1] == 'undefined')
                    series[j-1] = new Array();

                // Convert timestamp (TODO: review)
                if ((j == 1) && (data_types[j-1] == 'timestamp'))
                    x_item = new Date(x_item.replace(' ', 'T')).getTime();

                // Add data item
                series[j-1].push([x_item, chart_data[i][j]]);
            }
        }

        for (i = 0; i < series.length; i++) {
            data_set[i] = {
                label: series_titles[i],
                data: series[i]
            }
        }
    }

    //--------------
    // O P T I O N S
    //--------------

    // The options below are mostly about picking a feature set for ClearOS
    // charts.  A few bits of data from above (e.g. "ticks" in bar charts)
    // come from the data set manipulation above.

    var chart_options = Array();

    // Bar
    //----

    if (chart_type == 'bar') {
        chart_options = {
            series: {
                bars: {
                    show: true
                },
                lines: {
                    show: false,
                    fill: true,
                },
            },
            grid: {
                hoverable: true,
                clickable: true,
            },
            bars: {
                lineWidth: 1,
            },
            xaxis: {
              ticks: ticks
            }
        };

    // Horizontal Bar
    //---------------

    } else if (chart_type == 'horizontal_bar') {
        chart_options = {
            series: {
                bars: {
                    show: true
                },
                lines: {
                    show: false,
                    fill: true,
                },
            },
            grid: {
                hoverable: true,
                clickable: true,
            },
            bars: {
                lineWidth: 1,
                horizontal: true,
                barWidth: 0.8,
                align: "center",
                fillColor: { colors: [{ opacity: 0.5 }, { opacity: 1}] },
            },
            yaxis: {
                ticks: ticks,
            },
            xaxis: {
                minTickSize: 1,
            },
            legend: {
                show: true,
                labelBoxBorderColor: '#FFF',
                backgroundColor: '#DDD',
            }
        };

    // Pie
    //----

    } else if (chart_type == 'pie') {
        // To disable labels, set options['series_label_show'] to false
        // To modify default label format, define options['series_label_format'] as array and set:
        // ['label'] = true/false (show/hide label)
        // ['value'] = true/false (show/hide value)
        // ['unit'] = string display a unit of measure
        
        chart_options = {
            series: {
                pie: {
                    show: options['series_label_show'],
                    radius: 1,
                    innerRadius: 0.1,
                    label: {
                        show: options['series_label_show'],
                        radius: 0.75,
                        threshold: options['series_label_threshold'],
                        formatter: function (label, series) {
                            var label_format = '<div class="theme-chart-label-format">' +
                                label + ' - ' + (series.data[0][1]).toFixed(options['series_label_precision']) +
                                '</div>';
                            if (typeof options['series_label_format'] != 'undefined') {
                                label_format = '<div class="theme-chart-label-format">';
                                if (options['series_label_format']['label'])
                                    label_format += label;
                                if (options['series_label_format']['value']) {
                                    if (options['series_label_format']['label'])
                                        label_format += ' - ';
                                    label_format += (series.data[0][1]).toFixed(options['series_label_precision']);
                                }
                                if (options['series_label_format']['unit'])
                                    label_format += ' ' + options['series_label_format']['unit'];
                                label_format += '</div>';
                            }
                            return label_format;
                        },
                    },
                }
            },
            legend: {
                    show: true,
                    backgroundOpacity: 0,
                    labelFormatter: function (label, series) {
                        return '<span style="font-weight: bold">' + label + '</span`>';
                    },
            },
            grid: {
                hoverable: false,
                clickable: false,
            },
        };

    // Timeline
    //---------

    } else if (chart_type == 'timeline') {
        chart_options = {
            series: {
                lines: { show: true },
                points: { show: true },
            },
            grid: {
                hoverable: true,
                clickable: true,
                backgroundColor: { colors: [ "#ffffff", "#eeeeee" ] },
            },
            xaxis: {
                mode: "time",
                timeformat: "%m/%d %H:%M"
            },
            legend: {
                show: true,
                labelBoxBorderColor: '#FFF',
                backgroundColor: '#DDD',
            }
        };

    // Timeline stack
    //---------------

    } else if (chart_type == 'timeline_stack') {

        chart_options = {
            series: {
                stack: true,
                lines: {
                    fill: true
                },
            },
            grid: {
                hoverable: true,
                clickable: true
            },
            xaxis: {
                mode: "time",
                timeformat: "%m/%d %H:%M"
            },
            legend: {
                show: true,
                labelBoxBorderColor: '#FFF',
                backgroundColor: '#DDD',
            }
        };
    }

    //-------------------------------
    // Axis labels
    //-------------------------------

    if (options.yaxis_label) {
        if (typeof chart_options['yaxis'] == 'undefined')
            chart_options['yaxis'] = Array();

        chart_options['yaxis']['axisLabel'] = options.yaxis_label;
    }

    if (options.xaxis_label) {
        if (typeof chart_options['xaxis'] == 'undefined')
            chart_options['xaxis'] = Array();

        chart_options['xaxis']['axisLabel'] = options.xaxis_label;
    }

    //-----------------
    // O T H E R
    //-----------------

    // Interactive data points
    //------------------------

    chart_options['tooltip'] = 'true';
    chart_options['tooltipOpts'] = {
        content: '%p.0%, %s',
        shifts: {
          x: 20,
          y: 0
        },
        defaultTheme: false 
    };

    $("#" + chart_id).bind("plothover", function (event, pos, item) {
        if (item) {
            if (!item)
                return;

            if (chart_type == 'pie') {
                var percent = parseFloat(item.series.percent).toFixed(2);
            } else {
                var x = item.datapoint[0].toFixed(2);
                var y = item.datapoint[1].toFixed(2);

                var date = new Date(Math.round(x));
                var hours = date.getHours();
                var minutes = "0" + date.getMinutes();
                var seconds = "0" + date.getSeconds();

                var formattedTime = hours + ':' + minutes.substr(minutes.length-2) + ':' + seconds.substr(seconds.length-2);

                $("#" + chart_id + "_chart_tooltip").html(formattedTime + " - " + y)
                    .css({top: item.pageY+5, left: item.pageX+5})
                    .fadeIn(200);
            }
        } else {
            $("#" + chart_id + "_chart_tooltip").hide();
        }
    });

    // Show plot
    //----------

    $.plot("#" + chart_id, data_set, chart_options);
}

function getPosition(element) {
    var xPosition = 0;
    var yPosition = 0;
      
    while (element) {
        xPosition += (element.offsetLeft - element.scrollLeft + element.clientLeft);
        yPosition += (element.offsetTop - element.scrollTop + element.clientTop);
        element = element.offsetParent;
    }
    return { x: xPosition, y: yPosition };
}

/**
 * Converts various data types into a human readable format.  For example:
 * - IP addresses are converted to a human readable formats
 */

function _report_friendly_format(value, type) {
    if (type == 'ip') {
        var ip = value%256;

        for (var i = 3; i > 0; i--) {
            value = Math.floor(value/256);
            ip = value%256 + '.' + ip;
        }

        return ip;
    } else {
        return value;
    }
}
