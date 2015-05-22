// Made by Rafael Gil 2014

var App = App || {};

(function ($) {
    "use strict";

    App.separation = App.separation || {};
    $(document).ready(function () {
        $('#email').focus();

        $('#frmUpdateInfo').submit( function(){
            $('#search').trigger('click');
            return false;
        });

        $("#search").click(function () {

            //validate form first
            if ($("#email").val() == "") {
                $('#errorDiv').html('We need a valid email in order to proceed width the search');
                $('#report').hide();
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
                    $('#report').html(App.templates.separation(msg));

                    /*
                    $('#report').html('');
                    $('#report').html(msg);
                    $('#submit').show();
                    $("#termDate,#effectiveDate,#effectiveDate1").datepicker({
                        onSelect: function (dateText) {
                            $("#startDateError").html("");
                        }
                    });
                    $('#other').click(function () {
                        if ($('#other').is(':checked')) {
                            $('#otherComments').html('<p></p><textarea class="inputRender" cols="40" rows="6" id="inputOtherComments" name="inputOtherComments"></textarea>');
                        }
                        else {
                            $('#otherComments').html('');
                        }

                    });
                    */
                });
        });

        /*
        $("#submit").click(function () {
            // validate form before submit
            cansubmit = true;
            if ($('#termDate').val().length < 2) {
                $('#termDateError').html('<span class="errorSpan"> * You have to choose a termination date before proceeding</span>');
                cansubmit = false;
            }
            else {
                $('#termDateError').html('');
            }

            if ($('#ptoDays').val() === "") {
                $('#ptoDaysError').html('<span class="errorSpan"> * You have to enter a PTO time before proceeding</span>');
                cansubmit = false;
            }
            else {
                $('#ptoDaysError').html('');
            }

            if (!cansubmit) {
                $('#errorDiv').html("* You have some errors in your form, Please check the fields in red.");
                $("html, body").animate({ scrollTop: 0 }, "slow");
            }
            else {
                $('#errorDiv').html("");
                $.ajax({
                    type: "POST",
                    url: "termination_export_ajax.php",
                    data: $("#frmUpdateInfo").serialize(),
                    beforeSend: function () {
                        $('<img src="files/images/wait.gif" align="middle">').load(function () {
                            $(this).width(52).height(52).appendTo('#report');
                        });

                        $('#report').html('Processing your request ...');
                    }
                })
                    .done(function (msg) {
                        $('#report').html(msg);
                        $('#report').show();
                        $('#submit').hide();

                        activateMenu().on('click', function (e) {
                            switch ($(this).attr('id')) {
                                case "home":
                                    window.location.href = 'mainPage.php';
                                    break;
                                case "another":
                                    window.location.href = 'newHire.php?cmd=end';
                                    break;
                            }
                        });
                    });
            }
        });
        */


    });

}(jQuery));

