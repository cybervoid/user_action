// Made by Rafael Gil 2014

var App = App || {};

(function ($) {
    "use strict";

    App.org_change = App.org_change || {};
    $(document).ready(function () {
        $('#user').focus();

        $("#user").autocomplete({
            source: "/lookup_chng_org",
            minLength: 2,
            search: function (event, ui) {
                $("#searchProgress").html("");
                $('<img src="images/wait.gif" align="middle">').load(function () {
                    $(this).width(23).height(23).appendTo('#searchProgress');
                });
            },
            response: function (event, ui) {
                $("#searchProgress").html("");
            },
            select: function (event, ui) {
                $("#user").val(ui.item.label);

                $("#errorDiv").html('');

                $.ajax({
                    type: "POST",
                    url: "lookup",
                    data: {uname: ui.item.value },
                    beforeSend: function () {
                        $('<img src="images/wait.gif" align="middle">').load(function () {
                            $(this).width(52).height(52).appendTo('#report');
                        });
                        $('#report').html('Processing your request ...');
                    }
                })
                    .done(function (msg) {
                        $('#homeMenu').html('');
                        $('#report').html(App.templates.change_org(msg));

                        $("#cancel").click(function () {
                            document.location = '/';
                        });

                        $("#effectiveDate").datepicker({
                            onSelect: function (dateText) {
                                $("#startDateError").html("");
                            }
                        });

                        //set default department
                        lookupDepartment(msg["department"]);
                        lookupCompany(msg["company"])
                        findGroupMatch(msg["groups"]);

                    });
                return false;
            }
        });

        function lookupDepartment(department) {
            if (department != undefined) {
                $("#department option").each(function (i) {
                    if ($(this).text() === department) {
                        $(this).prop('selected', true);
                    }
                });
            }
        }

        function lookupCompany(company) {
            if (company != undefined) {
                $("#company option").each(function (i) {
                    if ($(this).text() === company) {
                        $(this).prop('selected', true);
                    }
                });
            }

        }
    });
}(jQuery));

