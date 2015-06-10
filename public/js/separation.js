// Made by Rafael Gil 2014

var App = App || {};

(function ($) {
    "use strict";

    App.separation = App.separation || {};
    $(document).ready(function () {
        $('#email').focus();

        $( '#email' ).bind('keypress', function(e){
            if ( e.keyCode == 13 ) {
                $('#search').click();
            }
        });



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


                    // set the groups where the user is registered


                    /*
                    $('#report').html('');
                    $('#report').html(msg);
                    $('#submit').show();


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

       $("#separation").submit(function () {
            return validateSubmit();
        });

        function validateSubmit() {
            var cansubmit = true;

            if ($('#termDate').val().length < 2) {
                $('#termDateError').html('<span class="errorSpan"> * You have to choose a termination date before proceeding</span>');
                cansubmit = false;
            }
            else {
                $('#termDateError').html('');
            }

            if($('#hireStatus').val()==="empty"){
                $('#hireStatusError').html('<span class="errorSpan"> * You have to choose a hire status before proceeding</span>');
                cansubmit = false;
            } else $('#hireStatusError').html('');

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

            return cansubmit;
        }



    });

}
    (jQuery)
    )
;

