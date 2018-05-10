window.mynotification = {error:"", errorType: 'success'};


if(window.pageLoadHooks == undefined) {
    window.pageLoadHooks = [];
    function addPageHook(hook) {
        window.pageLoadHooks.push(hook);
    }
}

addPageHook('updateFloatingLabels');
addPageHook('attachCombo');
addPageHook('attachAjaxForm');
addPageHook('updateDatatable');
addPageHook('updateSummernote');
addPageHook('updateMenu');
addPageHook('updateSelect');
addPageHook('performNotification');
addPageHook('attachDatepicker');
addPageHook('autocompleteOff');
addPageHook('format_numbers');
addPageHook('others');

$(document).on("click", "a[ajax='true']", function() {
    return loadPage($(this).attr('href'));
});

$(document).on("click",  function(event) {
    if(!$(event.target).hasClass("combobox"))
        $(".combobox").siblings(".mz_select_elements").hide(100);
});

$(document).ready(function() {
    bindToHistory();
    runPageHooks();
    $('.main-header').addClass('fixed-header');
    var h = $(".main-header").css("height");
    $(".content-wrapper").css("margin-top", h);
    $('.main-sidebar').addClass('fixed-sidebar');

});

function loadPage(url, f, callback__){
    //if(f == undefined) {
    //    window.onpopstate = function (e) {
    //        loadPage(window.location, true);
    //    }
    //}

    initLoading();

    //$('[data-emoticon="popover"]').popover('hide');
    if($is_mobile){
        if($("body").hasClass("sidebar-open")){
            $("body").removeClass("sidebar-open")
        }
    }

    $.ajax({
        url : url,
        cache : false,
        type : 'GET',
        success : function(data) {
            if (data == 'login') {
                show_login();
                stopLoading();
            } else {
                try {
                    data = jQuery.parseJSON(data);
                } catch (e) {
                    console.log(e);
                    notifyError("Error retrieving page");
                    return;
                }
                if(data.version != $version){
                    confirmReload();
                    stopLoading();
                    return;
                }
                    var content = data.content;
                    var container = data.container;
                    var title = data.title;
                    mynotification = data.notification;
                    var name = data.system_name;
                    $(container).html(content);
                    $(".my_title").html(title);
                    document.title = title + " | " + name;
                    Pusher.setPageTitle(document.title);

                    if (f == undefined && currentPage != url) {
                        window.history.pushState({}, 'New URL:' + url, url);
                        $(window).scrollTop(0);
                    }

                    currentPage = url;

                    if (f == 'moveup')
                        $(window).scrollTop(0);

                    reloadInits();
                    stopLoading();
                    updateBalance(data);


                    runPageHooks();

                    loadNotification(data);
                    if ($('.side-footer').length > 0) {
                        $('.footer-content').hide();
                    } else {
                        $('.footer-content').show();
                    }
                    $('body').click();


            }
        },
        error : function() {
            stopLoading();
            login_required();
        }
    });
    return false;
}

function loadNotification(data){
    if(data.notification_alert){
        $("#my_notification").find(".title").html(data.notification_alert.title);
        $("#my_notification").find(".message").html(data.notification_alert.message);
        $("#my_notification").find(".close").attr("data-id", data.notification_alert.id);
        $("#my_notification").show(100);
    }else{
        $("#my_notification").hide(100);
    }

    if(data.notification_dialog){
        showDialogNotification(data.notification_dialog.title, data.notification_dialog.message, data.notification_dialog.id);
    }
}
function confirmReload(){
    show_dialog($('#reloadDialog'), function(confirm){
        if(confirm){
            window.location = window.location;
        }
    });
}

var loadinginterval;
function initLoading() {
    $("#loading-line").show();

    $x = 50 + Math.random() * 30;
    $("#loading-line").width(($x) + "%");

    if(loadinginterval)
        clearInterval(loadinginterval);
    var x = 0;
    loadinginterval = setInterval(function(){
        $y = $x + x;
        $("#loading-line").width($y + "%");
        x++;
        if($y > 90)
            x = 0
    }, 200);

    $(".hide-on-loading").hide();
}

function stopLoading() {
    $("#loading-line").width("100%").delay(200).fadeOut(500, function()  {
        $(this).width('0%');
    });
    $(".hide-on-loading").show();
    if(loadinginterval)
        clearInterval(loadinginterval);
}
function performNotification(notification) {
    if(notification != undefined){
        mynotification = notification;
    }
    if(mynotification.error != ''){
        if(mynotification.errorType == 'error'){
            notifyError(mynotification.error);
        }else{
            notifySuccess(mynotification.error);
        }
        mynotification.error_ = mynotification.error;
        mynotification.error = "";
    }
}

function others(){
    $('.counter').each(function () {
        $(this).text($(this).attr("data-count")).counterUp({
            delay: 1,
            time: 100
        });
    });
    $(".form-group:has(:required)").not(".required").addClass("required");
    $('[data-toggle="popover"]').not("[data-placement]").attr("data-placement","top");
    $('[data-toggle="popover"]').addClass("cursor").popover();

    $("[data-toggle='tooltip'],[data-original-title]").tooltip({html:true});
    $(".form-group:has(:required)").not(".required").addClass("required");

    $('time[datetime]').each(function(i, e) {
        var time = moment($(e).attr('datetime'));
        $(e).html('<span>' + time.from() + '</span>');
    });
}

function attachDatepicker(){
    $("[type=date],[type=datetime],[type=time],.date,.datetime,.time").each(function(){
        if($(this).is("[type=date],.date")){
            $(this).attr("data-field", "date");
        }else if($(this).is("[type=datetime],.datetime")){
            $(this).attr("data-field", "datetime");
        }else{
            $(this).attr("data-field", "time");
        }
        $(this).attr("type", "text");
    });
    return;
    $(".datepicker").each(function(){
        if(!$(this).next().is(".datepickerdiv")){
            $(this).after("<div class='datepickerdiv'></div>");
            $format = $(this).data("format");
            var picker = new Pikaday(
                {
                    field: $(this)[0],
                    format: $(this).data("format") == undefined?"DD/MM/YYYY":$(this).data("format"),
                    theme: 'triangle-theme',
                    showTime       : $format == undefined?false:true,
                    splitTimeView  : false,
                    showSeconds    : false,
                    hours24format  : false,
                    container: $(this).next()[0]
                });
        }
    });
}

function updateFloatingLabels(){
    $('.form-control').on('focus blur', function (e) {
        try {

            $(this).parents('.form-group').toggleClass('focused', (e.type === 'focus' || this.value.length > 0));
            if($(this).parents('.form-group').hasClass("focused")){
                $(this).attr("placeholder", $(this).data("placeholder"));

            }else{
                if($(this).attr("placeholder")) {
                    $(this).data("placeholder", $(this).attr("placeholder"));
                    $(this).attr("placeholder", "");
                }
            }

        }catch(e){
            console.log(e);
        }
        try{
            $(this).filter("select").not(".escape").parents('.form-group').addClass("fixed-focused");
            $(this).filter("select[multiple]").parents('.form-group').addClass("fixed-focused");
        }catch(e){}
    }).trigger('blur');

    $(".summernote").parents(".form-group").addClass("fixed-focused");

    //$('.form-control').on('focus blur', function (e) {
    //    try{
    //        $(this).parents('.form-group').addClass("bmd-form-group").toggleClass('is-focused', (e.type === 'focus')).toggleClass("is-filled",this.value.length > 0);
    //        $(this).filter("select").not(".escape").parents('.form-group').addClass("is-filled");
    //        $(this).filter("select[multiple]").parents('.form-group').addClass("is-filled");
    //
    //    }catch(e){
    //        console.log(e);
    //    };
    //}).trigger('blur');

    $(".switch").find("input[type='checkbox']").each(function(){
        if( $(this).parent().find(".bmd-switch-track").length == 0){
            $(this).parent().append('<span class="bmd-switch-track"></span>');
        }
    });

    $("label").find("input[type='checkbox'], input[type='radio']").each(function(){
        if($(this).hasClass('is_switch')){
            return;
        }
        if($(this).is("input[type='radio']") && $(this).parent().find(".bmd-radio-out-circle").length == 0){
            $(this).parent().append('<span class="bmd-radio-outer-circle"></span><span class="bmd-radio-inner-circle"></span>');
        }else   if( $(this).is("input[type='checkbox']")  && $(this).parent().find(".checkbox-decorator").length == 0 && $(this).parent().find(".bmd-switch-track").length == 0){
            $(this).parent().append('<span class="checkbox-decorator"><span class="check"></span></span>');
        }
    });


//<span class="bmd-switch-track"></span>

    //<span class="bmd-radio-outer-circle"></span><span class="bmd-radio-inner-circle"></span>
}



function format_numbers($amount, crcy){
    if($amount === undefined) {
        $('.number').blur(function () {
            if (this.value.trim() == "")
                return;
            $currency = $(this).data("currency") || currency;
            $value = this.value.replace(/[^\d.-]/g, "");
            $fixed = $value.toString().indexOf(".") > -1 ? 2 : 0;
            $fixed = $(this).data("decimal") || $fixed;
            $a = parseFloat($value).toFixed($fixed)
                .toString()
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            if($a == "NaN")
                $a = 0;
            this.value = $currency + "" +$a;
            $(this).removeClass("number");

        });
        $('.number').trigger("blur");
    }else{
        $currency = crcy || currency;
        $value = $amount.toString().replace(/[^\d.-]/g, "");
        $fixed = $value.toString().indexOf(".") > -1 ? 2 : 0;
        $a = parseFloat($value).toFixed($fixed)
                .toString()
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        if($a == "NaN")
            $a = 0;
        return $currency + "" +$a;
    }


}

function parse_number($number){
    $value = ($number+"").replace(/[^\d.-]/g, "");
    $fixed = $value.indexOf(".") > -1?2:0;
    if($number == undefined || $number == null || ($number+"").trim() == "")
        return 0;

    $a = parseFloat(parseFloat($value).toFixed($fixed));
    if($a == "NaN")
        return 0;
    return $a;
}

function updateSelect(){
    //setTimeout(function(){
    try {
        $("select, .select2").not(".escape,.selectize,.user-select2").select2({
            placeholder: "",
            width: "100%"
        });
    }catch(e){};
    //}, 10);
    if($is_mobile)
        $(".select2-search, .select2-focusser").remove();

    updateUserSelect();
}

function updateUserSelect(){
    $('.user-select2').not(".selected").selectize({
        //valueField: 'username',
        //labelField: 'username',
        //searchField: 'username',
        valueField: 'id',
        labelField: 'name',
        searchField: ['name',"names"],
        create: false,
        render: {

            option: function(item, escape) {
                var x = item.username == undefined?"inactive":"";

                return '<div>' +
                    '<span class="title">' +
                    '<span class="name">' + escape(item.name) + '</span>' +
                    '</span>' +

                    '<ul class="meta '+ x +'">' +
                    (!is_empty(item.username) ? '<li class="language">Username: ' + escape(item.username) + '</li>' : '') +
                    '<li class="watchers">Name: <span>' + escape(item.names) + '</span></li>' +
                    '<li class="forks">Balance: <span>' + escape(item.balance) + '</span></li>' +
                    '</ul>' +
                    '</div>';
            }
        },
        score: function(search) {
            var score = this.getScoreFunction(search);
            return function(item) {
                var x = 10;
                return score(item) * (1 + Math.min(item.id / 100, 1));
            };
        },
        load: function(query, callback) {
            if (!query.length) return callback();
            //$.ajax({
            //    url: domain+'load/json/users/' + encodeURIComponent(query),
            //    type: 'GET',
            //    error: function() {
            //        callback();
            //    },
            //    success: function(res) {
            //        callback(res);
            //    }
            //});

            $.ajax({
                //url: 'https://api.github.com/legacy/repos/search/' + encodeURIComponent(query),
                url: domain+'load/json/users/?search=' + encodeURIComponent(query),
                type: 'GET',
                error: function() {
                    callback();
                },
                success: function(res) {
                    //var x = res.repositories;
                    var x = res;
                    callback(x);
                }
            });
        }
    });
    $('.user-select2').addClass("selected");
    return;
    $(".user-select2").not(".escape,.selectize").select2({
        ajax: {
            url: domain+"load/json/users",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {search: params};
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
            cache: true
        },
        placeholder: 'Search for a repository',
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        minimumInputLength: 1,
        templateResult: formatRepo,
        templateSelection: formatRepoSelection
    });

    function formatRepo (repo) {
        if (repo.loading) {
            return repo.text;
        }

        var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__avatar'><img src='" + repo.owner.avatar_url + "' /></div>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" + repo.full_name + "</div>";

        if (repo.description) {
            markup += "<div class='select2-result-repository__description'>" + repo.description + "</div>";
        }

        markup += "<div class='select2-result-repository__statistics'>" +
            "<div class='select2-result-repository__forks'><i class='fa fa-flash'></i> " + repo.forks_count + " Forks</div>" +
            "<div class='select2-result-repository__stargazers'><i class='fa fa-star'></i> " + repo.stargazers_count + " Stars</div>" +
            "<div class='select2-result-repository__watchers'><i class='fa fa-eye'></i> " + repo.watchers_count + " Watchers</div>" +
            "</div>" +
            "</div></div>";

        return markup;
    }

    function formatRepoSelection (repo) {
        return repo.full_name || repo.text;
    }
}


$current_form = null;
function loadingDiv(){
    return "<div id='loadingDiv' style='width: 100%;' align='center'><i class='fa fa-refresh fa-spin'></i> Loading...</div>";
}

function attachAjaxForm(){
    var options = {
        beforeSubmit:  function(formData, jqForm, options){
            initLoading();
            $(jqForm).find("button").not(".note-btn").attr("disabled","disabled");
        },
        success:       function (responseText, statusText, xhr, $form) {
            //stop loading
            if (responseText == 'login') {
                show_login();
                stopLoading();
                return;
            }
            $current_form = $form;
            $($form).find("button").find(".fa-spin").not(".note-btn").addClass("inactive");
            $($form).find("button").not(".note-btn").removeAttr("disabled");
            stopLoading();

            //check empty content
            if(responseText.notification != undefined){
                performNotification(responseText.notification);
            }

            $($form).find("input[name^='function_']").each(function(){
                $function = $(this).val();
                $function_name = $(this).attr("name");

                if(responseText.notification != undefined) {
                    $er = responseText.notification.errorType;
                    if ($(this).data("errorType") == $er || $function_name == "function_" + $er || $function_name == "function_all") {
                        safe_eval($function, responseText);
                    } else if($function_name.length > 9){
                        //DO NOTHING
                    }else if($(this).data("errorType") == undefined){
                        safe_eval($function, responseText);
                    }
                }else{
                    safe_eval($function,responseText);
                }
            });

            updateBalance(responseText);

            if(responseText.hide_ajax_modal === true){
                hideAjaxmodal();
            }

            if(responseText.showOnlyError != undefined && responseText.showOnlyError == true){
                return;
            }


            if($($form).find("input[name='dont_hide_ajax_modal']").length == 0 && responseText.dont_hide_ajax_modal == undefined) {
                hideAjaxmodal();
            }

            if($($form).find("input[name='container']").length > 0){
                $($($form).find("input[name='container']").val()).html(responseText.content);
            }else{
                $(responseText.container).html(responseText.content);
            }

            if($($form).find("input[name='current_url']").length == 1){
                responseText.current_url = $($form).find("input[name='current_url']").val();
            }

            if (responseText.current_url != undefined && responseText.current_url != currentPage && responseText.current_url != "") {
                var url = responseText.current_url;
                Pusher.setPageTitle(document.title);
                window.history.pushState({}, 'New URL:' + url, url);
                currentPage = url;
            }


            runPageHooks();


        },
        error:   function(responseText, statusText, xhr, $form)  {
            stopLoading();
            notifyError("Unknown Error occurred. Please try again");
            $($form).find("button").not(".note-btn").find("i").addClass("inactive");
            $($form).find("button").removeAttr("disabled");

        },
        // other available options:
        type:      'post',
        dataType:  'json',
        timeout:   60000
    };

    // bind to the form's submit event
    //all form except attached
    $("form").not(".attached").addClass("attached").each(function() {
        $(this).submit(function (e) {
            $(this).ajaxSubmit(options);
            return false;
        });

        $(this).find('button,input[type=submit]').each(function() {
            $(this).on("click", function () {
                var name = $(this).attr('name');
                buttonLoadingStart(this, false);
                if (typeof name == 'undefined') return;
                var value = $(this).attr('value');
                if($(this).is("button"))
                    value = $(this).text();

                var $form = $(this).parents('form').first();
                var $input = $('<input type="hidden" class="temp-hidden" />').attr('name', name).attr('value', value);
                $form.find('input.temp-hidden').remove();
                $form.append($input);
            });
        });
    });



}

function autocompleteOff(){
    $(".autocomplete-off").each(function(){
        try{
            if($(this).hasClass("autocompleted")){
                return;
            }
            $(this).attr('readonly', 'readonly');
            $(this).focus(function(){
                try{
                    if(!$(this).is("[readonly]"))
                        return;
                    this.removeAttribute('readonly');
                    this.focus();
                }catch(e){}
            });
        }catch(e){}

        $(this).addClass('autocompleted');
    })  ;
}

function safe_eval($function, $args){
    try{
        if($function.indexOf("(") > 0){
            eval($function);
        }else if($args == undefined){
            eval($function)();
        }else{
            eval($function)($args);
        }
    }catch(e){
        console.log(e);
    }
}

function calculate_airtime_fee(airtime_tf, amount, method){
    if(method == undefined)
        method = "airtime";

    airtime_tf = airtime_tf.toString();
    amount = parse_number(amount);
    var method = $("#method").val();
    if(method == "airtime"){
        if(!is_empty(airtime_tf)){
            var tf = parse_number(airtime_tf);
            if(airtime_tf.indexOf("%") > -1){
                var a = amount/(1+(tf/100));
                amount =  a;
            }else{
                amount = tf - amount;
            }
        }
    }
    return format_numbers(amount);

}

function updateSummernote(){
    $(".summernote").each(function(){
        if(!$(this).hasClass("loaded")){
            $options = $(this).data();
            $options['dialogsInBody'] = true;
            $(this).summernote($options);
            $(this).addClass("loaded");
        }
    });
}


function updateDatatable(){

    $(".datatable,.partial-datatable").each(function(){
        if(!$(this).hasClass("loaded")){

            $shown = [];
            $count = 0;
            $(this).find("tr").first().find("td, th").each(function(){
                if(!($(this).attr("show") == "false" || $(this).hasClass("no-print"))){
                    $shown.push($count);
                }
                $count++;
            });
            //$(this).DataTable( {dom: 'Bfrtipe',fBlrtip
            //f = search,B export buttons,l select
            $search = $(this).hasClass("partial-datatable")?'rtip':"fBlrtip";
            if($(this).hasClass("no-search")){
                $search = $search.replace("f","");
            }

            var pl = 25;
            if($(this).data("pagelength")){
                pl = $(this).data("pagelength");
            }

            var defer = 1;
            if($(this).data("totalrecords")){
                defer = $(this).data("totalrecords");
            }

            var columns = [];
            $.each($(this).find("thead td, thead th"), function(){
                var x = {};
                x['name'] = $(this).text().trim();
                columns.push(x);
            });

            $ajax = "";
            if($(this).data("serverSide")){
                $ajax = $(this).data("serverSide");
            }
            var maintable = this;

                $(this).DataTable({
                    dom: $search,
                    "columns": columns,
                    pageLength: $(this).data("pagelength") || 25,
                    allowClear: true,
                    responsive: $is_mobile ? true : false,
                    "processing": $ajax == ""?false:true,
                    "serverSide": $ajax == ""?false:true,
                    "drawCallback": function( settings ) {
                        if(settings.json == undefined)
                            return false;
                        var json = settings.json;
                        //$($(settings.json.content).find("table tbody tr")[0]).attr("style");
                        var count = 0;
                        var table = $(maintable).DataTable();

                        $.each($(json.content).find("table.datatable tbody tr, table.partial-datatable tbody tr"), function(){
                            var s = $(this).attr("style");
                            var c = $(this).attr("class");
                            if(s) {
                                $(table.rows().nodes().to$()[count++]).attr("style", s);
                            }
                            if(c){
                                $(table.rows().nodes().to$()[count++]).attr("class", c);
                            }
                        });

                        runPageHooks();

                    },
                    "ajax": $ajax,
                    "deferLoading": defer,
                    start: 50,
                    buttons: [
                        {
                            extend: 'pdf',
                            footer: true,
                            customize: function (csv) {
                                return "My header here....\n\n" + csv + "\n\nMy Footer here.....";
                            },
                            exportOptions: {
                                columns: $shown
                            }
                        },
                        {
                            extend: 'csv',
                            footer: false,
                            exportOptions: {
                                columns: $shown
                            }

                        },
                        {
                            extend: 'excel',
                            footer: false,
                            exportOptions: {
                                columns: $shown
                            }
                        },
                        {
                            extend: 'print',
                            customize: function (csv) {
                                return "My header here....\n\n" + csv + "\n\nMy Footer here.....";
                            },
                            footer: false,
                            exportOptions: {
                                columns: $shown
                            },
                            "order": [[$(this).data("order"), "asc"]]

                        }
                    ]
                });
            $(this).on('preXhr.dt', function ( e, settings, data ) {
                initLoading();
            }).on('xhr.dt', function ( e, settings, json, xhr ) {
                if(json) {
                    json.aaData = [];
                    $.each($(json.content).find("table.datatable tbody tr, table.partial-datatable tbody tr"), function () {
                        var y = [];
                        $.each($(this).find("td"), function (a, b) {
                            var x = $(b).html();
                            y.push(x);
                        });
                        json.aaData.push(y);
                    });
                    var total = $(json.content).find("table.datatable, table.partial-datatable").data("totalrecords");
                    json.iTotalRecords = total;
                    json.iTotalDisplayRecords = total;
                }else{
                    notifyError("Error Loading Table");
                }
                stopLoading();
                return;
                    for ( var i=0, ien=json.aaData.length ; i<ien ; i++ )
                    {
                        json.aaData[i].sum = json.aaData[i].one + json.aaData[i].two;
                    }
                    // Note no return - manipulate the data directly in the JSON object.
                } );
            $(this).addClass("loaded");
        }
    });

}

function bindToHistory(){
    window.onpopstate = function(){
        loadPage(window.location, false);
        hideAjaxmodal();
    };
}

function updateMenu(){
    if(window.currentPage == undefined){
        return;
    }

    $(".my-main-list > li > button").addClass("collapsed");

    $target = $(".my-main-list").find("[href='"+currentPage+"']");
    $parent_menu =  $target.parents(".my-menu").prev();

    $(".my-main-list > li > button").removeClass('menu_active');
    $parent_menu.addClass("menu_active").removeClass("collapsed");
    $($($parent_menu).data('target')).addClass('in');

    $(".my-main-list").find("[href='"+currentPage+"']").find("button").addClass("menu_list_active");


}
function runPageHooks() {
    $destroy = [];
    for(i=0;i<=window.pageLoadHooks.length - 1;i++) {
        f = window.pageLoadHooks[i];
        r = null;
        $response = eval(window.pageLoadHooks[i])();
        if($response == 'destroy'){
            $destroy.push(window.pageLoadHooks[i]);
        }
    }

    if($destroy.length > 0){
        $temp = [];
        for(i=0;i<=window.pageLoadHooks.length - 1;i++) {
            if($destroy.indexOf(window.pageLoadHooks[i]) == -1){
                $temp.push(window.pageLoadHooks[i]);
            }
        }
        window.pageLoadHooks = $temp;
    }

    //SET ON HOOK
    $destroy = [];
    for(i=0;i<=window.pageOnNextHook.length - 1;i++) {
        addPageHook(window.pageOnNextHook[i]);
    }

    window.pageOnNextHook = [];

}

window.pageOnNextHook = [];
function addToNextHook($function){
    window.pageOnNextHook.push($function);
}



function reloadInits() {
    //$(".timeago").timeago();
    //$('[data-toggle="tooltip"]').tooltip();
    //$(".slimscroll").each(function() {
    //    $(this).slimScroll({
    //        height : $(this).data('height')
    //    });
    //});


    $(document).ready(function(){


    });


}


var Pusher = {
    hooks : [],
    alert : false,
    pushIds : [],
    titleCount : 0,
    pageTitle : '',
    userid : '',
    onAlert: function() {
        this.alert = true;
    },
    offAlert: function() {
        this.alert = false;
    },

    finish : function() {
        if (this.alert) document.getElementById('update-sound').play();
        this.alert = false;
        this.refreshPageTitle();
    },

    setPageTitle : function(t) {
        this.pageTitle = t;
        this.refreshPageTitle();
    },

    refreshPageTitle : function() {
        if (this.titleCount > 0) {
            pageTitle = this.pageTitle;
            pageTitle = '(' + this.titleCount + ') ' + pageTitle;
            document.title = pageTitle;
            this.titleCount = 0;
        } else {
            document.title = this.pageTitle;
        }
    },

    setUser : function(userid) {
        this.userid = userid;
    },
    getUser : function() {
        return this.userid;
    },
    addCount : function(c) {
        this.titleCount  = parseInt(this.titleCount) + parseInt(c);
    },

    removeCount : function(c) {
        this.titleCount -= c;
        this.refreshPageTitle();
    },

    addHook : function(hook) {
        this.hooks.push(hook);
    },

    run : function(type, d) {
        for(i=0;i<=this.hooks.length - 1;i++) {
            f = this.hooks[i];
            r = null;
            eval(this.hooks[i])(type, d);

        }
    },

    addPushId : function(id) {
        this.pushIds.push(id);
    },
    hasPushId : function(id) {
        if (jQuery.inArray(id, this.pushIds) != -1) return true;
        return false;
    }
}


function notify(m, t, time) {
    var countDown;
    if(m == undefined || m == "")
        return;
    var c = $('#site-wide-notification').clone();
    c.attr("id", "");
    $("#my_loading_bar").append(c);
    var cM = c.find('.message');
    var lD = c.find('.my-loading-line');
    var time = (time == undefined) ? 8000 : time;
    //c.fadeOut();
    c.removeClass('error').removeClass('success').removeClass('info').removeClass('warning').addClass(t);
    cM.html(m);
    if(c.css("display") == 'block'){
        countDown = time;
        return;
    }
    lD.css({width: "100%"});
    c.fadeIn('slow');

    countDown = time;
    var int = setInterval(function(){
        if(c.is(":hover")){
            countDown = time;
        }
        var percentage = countDown/time * 100;
        lD.css({width: percentage+"%"});
        if(countDown <= 0){
            c.fadeOut('slow');
            c.remove();
            clearInterval(int);
        }
        countDown = countDown - 500;

    }, 500);

    c.on("click",function(){
        //c.addClass("fadeOutUp animated");
        c.fadeOut('slow');
        clearInterval(int);
        c.remove();
        return false;
    });
}
function notifyError(m, time) {notify(m,'error', time);}
function notifySuccess(m, time) {notify(m,'success', time);}
function notifyInfo(m, time) {notify(m,'info', time);}
function notifyWarning(m, time) {notify(m,'warning', time);}

function login_required() {
    notifyError($('body').data('general-error'))
}

function exportTable(id, $type){

    if(!$(id).is("table")){
        id = $(id).parent().parent().find("table");
    }
    $(id).tableExport({
        type: $type,
        escape: 'false'
    });
}

function reloadPage(){
    return loadPage(window.location);
}

function runUrl(url, moveup){
    if(moveup == undefined)
        moveup = true;
    loadPage(url, moveup);
    return false;
}

function loadTab(tab){
    $link = $(tab).attr("href");
    var target = $(tab).data('target');

    if($.trim($(target).html()) != ''){
        return true;
    }

    $(".hide-on-tab-loading").each(function(){
        if($(this).is(":hidden")){
            $(this).removeClass("hotl-hidden");
        }else{
            $(this).addClass("hotl-hidden");
            $(this).hide();
        }
    });
    $(target).html("<div align='center' style='padding: 100px; width: 100%;'><span><i class='fa fa-refresh fa-spin'></i> Loading...</span></div>");

    loadURL($link, function(response){
        $(target).html(response.content);
        runPageHooks();
        $(".hide-on-tab-loading").each(function(){
            if($(this).hasClass('hotl-hidden')) {
                $(this).show();
                $(this).removeClass("hotl-hidden");
            }
        })
    }, function(){
        $(".hide-on-tab-loading").hasClass('hotl-hidden').show();
        notifyError("Error Loading Tab...");
        $(target).html("");
    });
}

function updateBalance(response){
    try{
        $("#my_balance").html(response.balance);
    }catch(e){}
}

function loadContainer(source, container, options){

    $is_url = false;

    if(source == "")
        return;

    try{
        var url = $(source).attr("href");
        var x = '';
        if($(source).is("input[type='checkbox'],input[type='radio']")){
            if($(source).is(":checked")){
                x = $(source).val();
            }
        }else if($(source).is(".fa-toggle-on,.fa-toggle-off")){
            if($(source).is(".fa-toggle-off")) {
                x = "on";
                $(source).removeClass("fa-toggle-off").addClass("fa-toggle-on");
            }else{
                $(source).removeClass("fa-toggle-on").addClass("fa-toggle-off");
            }
        }else if($(source).is("select,input,textarea")){
           if($(source).is("[type=color]")){
               x = $(source).val().substring(1);
           }else
            x = $(source).val();
        }else if($(source).is(".fa-refresh")){
            $(source).addClass("fa-spin");
        }else if($(source).is("button")){
            buttonLoadingStart(source);
        }

        url = url+"/"+x;

        $(source).find(".fa-spin").removeClass("inactive");
    }catch(e){
        $is_url = true;
        var url = source;
    }

    if(url == undefined || url == '')
        return;

    loadURL(url, function(response){

        if(container == undefined || container == null || container == ""){
            $(response.container).html(response.content);
        }

        if(container != undefined && container != '')
            $(container).html(response.content);

        mynotification = response.notification;

        updateBalance(response);
        //if(f == undefined) {
        //    window.history.pushState({}, 'New URL:' + url, url);
        //}
        if(options != undefined){
            if(options.scroll)
                $(window).scrollTop(0);;

            if(options.run_function != undefined){
                options.run_function(response);
            }

            if(options.function_success != undefined){
                options.function_success(response);
            }
        }

        if(!$is_url){
            $(source).find(".fa-spin").addClass("inactive");
            if($(source).is(".fa-refresh")) {
                $(source).removeClass("fa-spin");
            }
        }
        this.end(true);

        runPageHooks();
    }, function(){

        if(options != undefined && options.run_function != undefined){
            options.run_function();
        }
        notifyError("Error getting content...");
        if(!$is_url)
            $(source).find(".fa-spin").addClass("inactive");
        this.end(false);
    });


    this.end = function(is_success){
        try {
            if ($(source).is("button")) {
                buttonLoadingStop(source);
            }
        }catch(e){}
    }
    return false;
}



function post_data(url, data, success_, failed__){
    initLoading();
    $.ajax({
        url : url,
        cache : false,
        type : "POST",
        timeout:   120000,
        dataType: "json",
        data: data,
        success : function(data) {
            if (data == 'login') {
                show_login();
                stopLoading();
                return;
            }
            stopLoading();
            if(success_ != undefined)
                success_(data);

        },
        error : function(e) {
            stopLoading();
            if(failed__ != undefined)
                failed__(e);
            //login_required();
        }
    });
    return false;
}

function loadURLNoJson(url, container){
    initLoading();
    $.ajax({
        url : url,
        cache : false,
        type : "GET",
        timeout:   120000,
        success : function(data) {
            if (data == 'login') {
                show_login();
                stopLoading();
                return;
            }
            stopLoading();
            $(container).html(data);

        },
        error : function() {
            stopLoading();
            notifyError("Error loading");
            //login_required();
        }
    });
    return false;
}


function loadURL(url, success_, failed__, method){
    initLoading();
    $.ajax({
        url : url,
        cache : false,
        type : method==undefined?'GET':"POST",
        timeout:   120000,
        success : function(data) {
            stopLoading();
            if (data == 'login') {
                show_login();
            } else {
                data = jQuery.parseJSON(data);
                success_(data);
            }

        },
        error : function() {
            stopLoading();
            if(failed__ != undefined)
                failed__();
            //login_required();
        }
    });
    return false;
}


function exportTableToCSV(id, filename) {
    if(!$(id).is("table")){
        id = $(id).parent().parent().find("table");
    }
    if(filename == undefined){
        var filename = "data.csv";
    }
    var csv = [];
    var rows = id[0].querySelectorAll("tr");

    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll("td, th");

        for (var j = 0; j < cols.length; j++)
            row.push(cols[j].innerText.trim());

        csv.push(row.join(","));
    }

    // Download CSV file
    downloadCSV(csv.join("\n"), filename);
    function downloadCSV(csv, filename) {
        var csvFile;
        var downloadLink;

        // CSV file
        csvFile = new Blob([csv], {type: "text/csv"});

        // Download link
        downloadLink = document.createElement("a");

        // File name
        downloadLink.download = filename;

        // Create a link to the file
        downloadLink.href = window.URL.createObjectURL(csvFile);

        // Hide download link
        downloadLink.style.display = "none";

        // Add the link to DOM
        document.body.appendChild(downloadLink);

        // Click download link
        downloadLink.click();
    }
}

function buttonLoadingStart(me, dnt_disable){
    $(me).find(".fa-spin").removeClass("inactive").removeClass("inactive-single");
    if(dnt_disable == undefined)
        $(me).attr("disabled", "disabled");
}

function buttonLoadingStop(me){
    $(me).find(".fa-spin").addClass("inactive").addClass("inactive-single");
    $(me).removeAttr("disabled");
}

function attachCombo(){
    $(".combobox").not("combobox_attached").each(function() {
        $(this).attr('autocomplete','off');
        $(this).keyup(function(){
            $val = $(this).val().toLowerCase();
            $(this).siblings(".mz_select_elements").find("span").each(function () {
                $x = $(this).html().toLowerCase();
                if($x.indexOf($val) > -1){
                    $(this).show(50);
                }else{
                    $(this).hide(100);
                }
            });
        });

        $(this).siblings(".mz_select_elements").find("span").click(function(event){
            $val = $(this).html();
            $(this).parents(".mz_select_elements").siblings(".combobox").val($val);
            updateFloatingLabels()
        });


        $(this).focus(function(){
            $(this).siblings(".mz_select_elements").show(100);
        });
        $(this).addClass("combobox_attached");

    });
}

$doc_count = 0;
function add_document(){
    $doc_count++;
    $x = '<tr> <td> <div class="form-group"> <label class="bmd-label-floating">Title</label> <input type="text" required name="file_'+$doc_count+'" class="form-control" > </div> </td> <td> <br> <div class="fileinput fileinput-new m-b-0" data-provides="fileinput"> <div class="fileinput-preview thumbnail m-b-0" data-trigger="fileinput" style="width: 100px; height: 33px; display: inline-block;"> <label class="btn btn-sm btn-raised btn-info">Select</label> </div> <div align="center" style="display: inline-block"> <span class="btn-file"><span style="display: none;" class="fileinput-new">Select</span><span class="fileinput-exists btn btn-default">Change</span><input type="file" name="file_'+$doc_count+'"></span> </div> </div> </td> <td> <br> ' +
        '<div><a class="btn btn-secondary btn-raised btn-sm" onclick="$(this).parents(\'tr\').remove(); return false;" href="javascript:void(0)"> <i class="fa fa-trash" aria-hidden="true"></i>	Remove </a></div> </td> </tr>';
    $('#document_table').append($x);

    runPageHooks();

    return false;
}

function is_empty($value){
    if($value == null)
        return true;
    if($value == undefined)
        return true;
    if(typeof($value) == "string" && $value.trim() == "")
        return true;

    return false;
}

function open_link(me){
    $("#perform_click").attr("href", $(me).data("href"));

    if(!is_empty($(me).attr("target"))){
        $("#perform_click").attr("target", $(me).attr("target"));
    }else{
        $("#perform_click").removeAttr("target");
    }

    if(!is_empty($(me).attr("ajax"))){
        $("#perform_click").attr("ajax", $(me).attr("ajax"));
    }else{
        $("#perform_click").removeAttr("ajax");
    }

    $("#perform_click")[0].click();
}

function get_hash(removeHash){
    if(window.location.hash) {
        var hash = window.location.hash;
        if(removeHash){
            hash = hash.substring(1);
        }
        return hash;
    } else {
      return false;
    }
}

function trigger_tab(id){
    if(!is_empty(id)){
        $("[data-target='"+id+"']").trigger("click");
    }
}

function on_select_show(me, id){
    if($(me).is(":checked")){
        $(id).show(100);
    }else{
        $(id).hide(100);
    }
}


function filter_local_numbers(text, include_international, notify){
    var x = text;
    x = x.replace(/[^\d]/g, ",");
    y = x.split(",");

    var array = [];

    $.each(y, function(k, v) {
        f = v.charAt(0);
        if (v.length == 13 && f == 2) {
            array.push("0" + v.substring(3));
        } else if (v.length == 11 && f == 0){
            array.push(v);
        }else if(v.length == 10 && f >= 7 && f<=9) {
            array.push("0" + v);
        }else if(include_international != undefined && v.length >= 8 && v.length<=17){
            array.push(v);
        }

    });

    return array.join(", ");
}

function calculate_cost(numbers, rate){
    var x = numbers;
    x = x.replace(/ /g, "");
    y = x.split(",");
    var array = [];
    var total = 0;

    var national = 0, international = 0, totalcount = 0, notvalid = 0, duplicate= 0;
    $.each(y, function(k, v) {
        f = v.charAt(0);

        var ct = rate_cost(v, rate);
        totalcount++;

        if(ct == 0) {
            notvalid++;
            return;
        }

        if($.inArray(v, array) > -1){
            duplicate++;
            return;
        }

        total += ct;
        if (v.length == 11 && f == 0) {
            national++;
            array.push(v);
        }else{
            international++;
            array.push("+"+v);
        }

    });

    return {national: national, international: international, total_count: totalcount, not_valid: notvalid, duplicate: duplicate, numbers: array.join(", "), cost: total};
}

function rate_cost(number, rate){
    number = number+"";
    if(number.length == 11 && number.charAt(0) == "0"){
        number = "234"+number.substring(1);
    }
    var price = 0;
    $.each(rate, function(num, amount){
        var len = (num+"").length;
        var sub = number.substring(0, len);
        if(sub == num){
            price = parse_number(amount);
            return false;
        }
    });

    return price;
}

function getIndex($array, $value, $default){
    $default = $default || "";
    $ex = $value.toString().split(",");
        try{
            $newarray = $array[$ex[0]];
            if($ex.length > 1){
                $x = $ex.slice(1);
                return getIndex($newarray, $x.join(","), $default);
            }
        }catch(e){
            return $default;
        }
    return $newarray;
}

var bulk_message = {
     message: "",
     message_type: "text",
     msg_lenght: function(){
        var extraChars = 0;

        for(var i = 0; i<this.message.length; i++){
            if (this.message.charAt(i) == '^') {
                extraChars++;
            }
            else if (this.message.charAt(i) == '{') {
                extraChars++;
            }
            else if (this.message.charAt(i) == '}') {
                extraChars++;
            }
            else if (this.message.charAt(i) == '\\') {
                extraChars++;
            }
            else if (this.message.charAt(i) == '[') {
                extraChars++;
            }
            else if (this.message.charAt(i) == '~') {
                extraChars++;
            }
            else if (this.message.charAt(i) == ']') {
                extraChars++;
            }
            else if (this.message.charAt(i) == '|') {
                extraChars++;
                //} else if (this.message.charAt(i) == '\n') {
                //       extraChars++;
            }
            else if (this.message.charCodeAt(i) == 0x20AC) {
                extraChars++;
            }
        }

        var z = this.message;

        var y = z.length + extraChars;

        return y;

    },
    sms_number: function(num){
        var length = this.message_type == "text"?160:70;
        var num = this.msg_lenght();

        var x = 0;
        var b = 3;
        if(length == 160){
            x = Math.ceil(num/length) * 7;
            b = 7;
        }else if(length == 280){
            x = Math.ceil(num/length) * 12;
            b = 12;
        }else{
            x = Math.ceil(num/length) * 3;
        }

        var y = x + num;
        var z = Math.ceil(y/length);
        var a = (z * length) - (z * b);
        return z;

    },
     count: function(){
        var length = this.message_type == "text"?160:70;
        var num = this.msg_lenght();

        if(num == 0){
            return num+"/"+length+" (0 SMS)";

        }else if(num > 5000){
            return num+" Maximum sms character reached (5000)";

        }else if(num > length){

            var x = 0;
            var b = 3;
            if(length == 160){
                x = Math.ceil(num/length) * 7;
                b = 7;
            }else if(length == 280){
                x = Math.ceil(num/length) * 12;
                b = 12;
            }else{
                x = Math.ceil(num/length) * 3;
            }

            var y = x + num;
            var z = Math.ceil(y/length);
            var a = (z * length) - (z * b);
            return num+"/"+a+" ("+z+" SMS)";

        }else{
            return num+"/"+length+" (1 SMS)";
        }


    }


}

function show_login(){
    $("#modal_login").modal();
    $("#modal_login").find("[name=password]").val("");
    notifyError("Please Re-login again");
}

function hide_login(){
    $("#modal_login").modal('hide');
}

function whatisdnd(){
    var dnd = "DND means Do Not Disturb (DND): its a service enforced by NCC on Network providers. It allow a recipient to decide to stop receiving bulk sms. Any Number that has DND activated will not receive bulk sms except using the 'Banking Route'.<br>" +
        "Although MTN activated some numbers without there consent. <br><br>To check whether a number is on DND, the owner should send: <br>STATUS to 2442. <br><br>To deactivate DND and start recieving bulk sms, the number (recipient) should send:<br>STOP to 2442. <br>After you receive a response then send:<br>ALLOW to 2442.";

    my_alert(dnd);
return false;
}