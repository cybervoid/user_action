// Made by Rafael Gil 2014

var App = App || {};

(function ($) {
    "use strict";

    App.separation = App.separation || {};
    $(document).ready(function () {
        $('#email').focus();

        $('#email').bind('keypress', function (e) {
            if (e.keyCode == 13) {
                $('#search').click();
            }
        });

        /*
                $("#search").click(function () {

                    //validate form first
                    if ($("#email").val() == "") {
                        $('#errorDiv').html('We need a valid email in order to proceed width the search');
                        $('#email').focus();
                        return false;
                    }
                    $("#errorDiv").html('');

                    $.ajax({
                        type: "POST",
                        url: "separation_search",
                        data: {cmd: $(this).attr('id'), email: $("#email").val() },
                        beforeSend: function () {
                            $('<img src="images/wait.gif" align="middle">').load(function () {
                                $(this).width(52).height(52).appendTo('#report');
                            });
                            $('#report').html('Processing your request ...');
                        }
                    })
                        .done(function (msg) {
                            $('#homeMenu').html('');
                            $('#report').html(App.templates.separation(msg));
                            $("#cancel").click(function () {
                                document.location = '/';
                            });

                            $("#termDate,#effectiveDate,#effectiveDate1").datepicker({
                                onSelect: function (dateText) {
                                    $("#startDateError").html("");
                                }
                            });

                            $('#onTimePayment').keyup(function () {
                                $('#onetime').prop("checked", true);
                            });

                            $('#severancePay,#overTime').keyup(function () {
                                $('#severance').prop("checked", true);
                            });

                            $('#periodPaid').keyup(function () {
                                $('#cobra').prop("checked", true);
                            });

                        });
                });*/


        $("#separation").submit(function () {

            var cansubmit = true;


            var value = $('#termDate').val();

            if (typeof value != 'undefined') {
                if ($('#termDate').val().length < 2) {
                    $('#termDateError').html('<span class="errorSpan"> * You have to choose a termination date before proceeding</span>');
                    errorValidation($('#termDate'), cansubmit);
                    cansubmit = false;
                }
                else {
                    $('#termDateError').html('');
                }

            }
            else {
                return false;
            }


            if ($('#hireStatus').val() === "empty") {
                $('#hireStatusError').html('<span class="errorSpan"> * You have to choose a hire status before proceeding</span>');
                errorValidation($('#hireStatus'), cansubmit);
                cansubmit = false;
            }
            else {
                $('#hireStatusError').html('');
            }


            if ($('#ptoDays').val() === "") {
                $('#ptoDaysError').html('<span class="errorSpan"> * You have to enter a PTO time before proceeding</span>');
                errorValidation($('#ptoDays'), cansubmit);
                cansubmit = false;
            }
            else {
                $('#ptoDaysError').html('');
            }


            if (cansubmit) {
                $("#submit").attr('disabled', 'disabled');
            }

            return cansubmit;

        });


        function errorValidation(obj, cansubmit) {
            $('#errorDiv').html("* You have some errors in your form, Please check the fields in red.");
            if (!cansubmit) {
                return false;
            }
            var offset = obj.offset();
            $("html, body").animate({ scrollTop: offset.top }, "slow");
        }


        $("#email").autocomplete({
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
                if (ui.content.length === 0) {
                    $('#report').html('<span class="errorSpan">The user was not found in the system...</span>');
                }
                if ((ui.content.length === 1) && (ui.content[0].label.toLowerCase() == $('#email').val().toLowerCase())) {
                    $("#email").autocomplete("close");
                    getEmail(ui.content[0].value);

                }

            },
            select: function (event, ui) {
                $("#email").val(ui.item.label);

                $("#errorDiv").html('');
                getEmail(ui.item.value);
                return false;
            }
        });

        function getEmail(email) {
            $.ajax({
                type: "POST",
                url: "separation_search",
                data: {cmd: $(this).attr('id'), email: email},
                beforeSend: function () {
                    $('<img src="images/wait.gif" align="middle">').load(function () {
                        $(this).width(52).height(52).appendTo('#report');
                    });
                    $('#report').html('Processing your request ...');
                }
            })
                .done(function (msg) {
                    $('#homeMenu').html('');

                    $('#report').html(App.templates.separation(msg));

                    // check if the user has phones
                    if (msg["mobile"] != '') {
                        $("#cellphone").prop('checked', true);
                    }
                    if (msg["telephonenumber"] != '') {
                        $("#phone").prop('checked', true);
                    }

                    findGroupMatch(msg["groups"]);
                    $("#cancel").click(function () {
                        document.location = '/';
                    });

                    $("#termDate,#effectiveDate,#effectiveDate1").datepicker({
                        onSelect: function (dateText) {
                            $("#startDateError").html("");
                        }
                    });

                    $('#onTimePayment').keyup(function () {
                        $('#onetime').prop("checked", true);
                    });

                    $('#severancePay,#overTime').keyup(function () {
                        $('#severance').prop("checked", true);
                    });

                    $('#periodPaid').keyup(function () {
                        $('#cobra').prop("checked", true);
                    });

                });

        }

    });
}(jQuery));

