// Made by Rafael Gil 2014

var App = App || {};

(function ($) {
    "use strict";

    App.org_change = App.org_change || {};
    $(document).ready(function () {
        $('#user').focus();

        $("#user").autocomplete({
            source: "/autocomplete",
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
                    url: "org_change_lookup",
                    data: {email: ui.item.value},
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

                        changeName();
                        //set defaults
                        lookupDepartment(msg["department"]);
                        lookupCompany(msg["company"])
                        findGroupMatch(msg["groups"]);

                    });
                return false;
            }
        });

        function changeName() {
            $("#name, #lastName").keyup(function () {
                $('#newEmail').val($('#name').val().toLowerCase() + '.' + $('#lastName').val().toLowerCase() + '@illy.com');
            });
        }

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

        $("#org_change").submit(function () {

            var canSubmit = false;

            $('#departmentError').html('*');
            if ($('#department').val() === "") {
                $('#departmentError').html('<div> * You have to choose a department before proceeding</div>');
                canSubmit = false;
            }

            $('#companyError').html('*');
            if ($('#company').val() === "") {
                $('#companyError').html('<div> * You have to choose a company before proceeding</div>');
                canSubmit = false;
            }


            return canSubmit;
        });

    });
}(jQuery));

