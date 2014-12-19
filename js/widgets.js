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
 * @param string $importance importance of the button ('high' or 'low')
 * @param string $class      CSS class
 * @param array  $options    options
 */

function theme_anchor(url, text, options)
{
    id = 'anchor-' + Math.random();

    if (typeof options != 'undefined') {
        if (options.id)
            id = options.id;

        if (options.buttons == 'extra-small')
            button_class = 'btn btn-xs btn-primary';
        else if (options.buttons)
            button_class = 'btn btn-sm btn-primary';
    }

    return '<a href="' + url + '" id="' + id + '" class="' + button_class + '">' + text + '</a>';
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
 * Add key/value pair to sidebar widget.
 */

function theme_add_sidebar_pair(key, value)
{
    $('#sidebar_additional_info_row').after(
        '<div class="row">' +
        '<div class="col-lg-6 theme-field">' + key + '</div>' +
        '<div class="col-lg-6">' + value + '</div>' +
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

    id = (options != undefined && options.id != undefined) ? ' id="' . options.id + '"' : '';

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
    if (typeof options != undefined) {
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
                                    <div  id="app-logo-' + app.basename + '" class="theme-app-logo box-body theme-placeholder">\
                                        ' + get_placeholder("svg") + '\
                                    </div>\
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

    // Make sure only to call this 'dotdotdot' once
    if (type == 'other_by_devel') {
        $('#app_' + type).append('\
            <script type="text/javascript">\
                $(".marketplace-app-info-description").dotdotdot({\
                    ellipsis: "..."\
                });\
            </script>\
        ');
    }
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
            var item = clearos_human_readable(data[i][j], data_type[j]);

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
 * @param string $chart_id   chart ID
 * @param string $chart_type chart type
 * @param string $data       standard data set
 * @param string $format     format information
 * @param array  $series     converted series data
 * @param array  $labels     labels for series data
 * @param object $custom     custom options
 *
 * Format information is passed via the $format variable.  Information includes:
 * - format.xaxis_label = Label for the x-axis
 * - format.yaxis_label = Label for the y-axis
 * - format.data_points = Number of data points to include in the chart
 */

function theme_chart(
    chart_id,
    chart_type,
    data,
    format,
    series,
    series_labels,
    series_units,
    series_title,
    custom
)
{
    //-------------------------
    // O V E R V I E W
    //-------------------------

    // The data is passed into this function in a generic way.  This makes
    // it possible to support different chart engines, but it also makes theme
    // development more complex.

    //-------------------------
    // F L O T  D A T A S E T S
    //-------------------------

    // This section is non-intuitive.  We basically have to take the standard
    // data format (FIXME: add link to doc) and convert it to the format
    // used in flot - https://github.com/flot/flot/blob/master/API.md#data-format
    // The code below looks crazy, but it's really just shuffling data around.

    data_set = Array();
    ticks = Array();

    if (typeof custom === 'undefined')
        custom = new Object();

    // Pie chart data set
    if (chart_type == 'pie') {
        for (i = 0; i < data.length; i++) {
            label = data[i][0];
            if (data[i][2] == 'format_ip')
                label = clearos_human_readable(data[i][0], 'ip');
            data_set[i] = {
                label: label,
                data: data[i][1],
                color: get_option_key(custom, 'series.color.' + i) != null ? get_option_key(custom, 'series.color.' + i) : i
            }
        }

    // Bar chart data set
    } else if (chart_type == 'bar') {
        var data_points = Array();
        for (i = 0; i < data.length; i++) {
            ticks[i] = [ i, data[i][0] ];
            data_points[i] = [i, data[i][1]]
        }
        data_set[0] = {
            label: series_labels[0],
            data: data_points
        }

    // Normal data set
    } else {
        for (i = 0; i < series.length; i++) {
            data_set[i] = {
                label: series_labels[i],
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

    var options = Array();

    // Bar
    //----

    if (chart_type == 'bar') {
        options = {
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
            xaxis: {
              ticks: ticks
            }
        };

    // Pie
    //----

    } else if (chart_type == 'pie') {
        options = {
            series: {
                pie: {
                    show: true,
                    innerRadius: (get_option_key(custom, 'pie.inner_radius') != null ? custom.pie.inner_radius : 0.0),
                    label: {
                        show: (get_option_key(custom, 'pie.label.show') != null ? true: true),
                        radius: .5,
                        color: '#ffffff'
                    }
                }
            },
            legend: {},
            grid: {
                hoverable: false,
                clickable: false,
            },
        };

        if (get_option_key(custom, 'pie.label_format') != null)
            options.series.pie.label['formatter'] = window[custom.pie.label_format];
        if (get_option_key(custom, 'pie.legend.show') != null)
            options['legend']['show'] = custom.pie.legend.show;

    // Timeline
    //---------

    } else if (chart_type == 'timeline') {
        options = {
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
        };

    // Timeline stack
    //---------------

    } else if (chart_type == 'timeline_stack') {

        options = {
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
        };
    }

    //-------------------------------
    // R E Q U E S T E D  F O R M A T
    //-------------------------------
    // See $format information in function doc above.

    if (format.yaxis_label) {
        if (typeof options['yaxis'] == 'undefined')
            options['yaxis'] = Array();

        options['yaxis']['axisLabel'] = format.yaxis_label;
    }

    if (format.xaxis_label) {
        if (typeof options['xaxis'] == 'undefined')
            options['xaxis'] = Array();

        options['xaxis']['axisLabel'] = format.xaxis_label;
    }

    //-----------------
    // O T H E R
    //-----------------

    // Interactive data points
    //------------------------

    options['tooltip'] = 'true';
    options['tooltipOpts'] = {
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

    $.plot("#" + chart_id, data_set, options);
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
