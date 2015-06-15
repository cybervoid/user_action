/**
 * Created by rafag on 3/21/15.
 */

var App = App || {};

(function ($) {
    "use strict";

    App.newHire = App.newHire || {};

    $(document).ready(function () {

        $('#department').change(function () {
            if ($('#department').val() == 'empty') {
                $('#department').toggleClass("inputRender", true);
                $('#departmentError').html('*');
            }
            else {
                $('#department').toggleClass('validateError', false);
                $('#department').toggleClass('inputRender', true);
                $('#departmentError').html('');
            }
        });
        $('#salesLevel').change(function () {
            if ($('#salesLevel option:selected').text() == 'Level III') {
                $('#salesLevelDiv').html('Level III Regional / Division Sales Manager / <br> National Retail Managers / Systems Mgr');
            }
            else {
                $('#salesLevelDiv').html('');
            }
        });

        $('#location').change(function () {
            if ($('#location').val() == 'empty') {
                $('#location').toggleClass('inputRender', true)
                $('#locationError').html('*');
            }
            else {
                $('#location').toggleClass('validateError', false);
                $('#location').toggleClass('inputRender', true);
                $('#locationError').html('');
                if ($('#location').val() == "Remote Users") {
                    $('#location_Other_Span').show();
                    $('#location_Other').focus();
                }
                else {
                    $('#location_Other').val("");
                    $('#location_Other_Span').hide();
                }

            }

        });


        $('#laptop').click(function () {  // add/remove li element to the list
            if ($('#laptop').is(":checked")) {
                $("#prepareLaptop").after('<li id="deliveryDateli" style="margin: 0px 0px 0px 30px">Delivery Date <input type="text" class="inputRender" name="deliveryDate" id="deliveryDate" style="width: 100px"></li>');
                $("#prepareLaptop").after('<li id="ship" style="margin: 0px 0px 0px 20px"><label><input type="checkbox" class="inputRender" name="iTDept[]" id="laptopShipping" value="Laptop needs to be shipped to an outside location, please contact hiring manager for address"> Laptop needs to be shipped to an outside location, please contact hiring manager for address</label></li>');

                if ($('#startDate').val() != '') {
                    var d = new Date($('#startDate').val());
                    d.setDate(d.getDate() - 3);

                    //yourDate.getDay()
                    if (d.getDay() == 6) {
                        d.setDate(d.getDate() + 2);
                        //alert('Saturday detected')
                    }
                    if (d.getDay() == 0) {
                        d.setDate(d.getDate() + 1);
                    }

                    var deliveryDate = (d.getMonth() + 1).toString() + '/' + d.getDate().toString() + '/' + d.getFullYear().toString();
                    $('#deliveryDate').val(deliveryDate);
                }


                $("#deliveryDate").datepicker({
                    onSelect: function (dateText) {
                        $("#startDateError").html("");
                    }
                });
            }
            else {
                $("#ship").remove();
                $("#deliveryDateli").remove();
            }
        });


        $('#cancel').click(function () {  // cancel the new hire and move to the main page
            window.location.href = "/";
        });

        $('#newHire').submit(function (event) {
            // VALIDATION
            var cansubmit = true;

            if ($('#company').val() == "empty") {
                $('#company').toggleClass('inputRender validateError')
                $('#companyError').html('<span class="errorSpan"> * You have to choose a department before proceeding</span>');
                cansubmit = false;
            }
            else {
                $('#companyError').html('<span class="errorSpan"> *</span>');
            }

            if ($('#department').val() == "empty") {
                $('#department').toggleClass('inputRender validateError')
                $('#departmentError').html('<span class="errorSpan"> * You have to choose a department before proceeding</span>');
                cansubmit = false;
            }
            else {
                $('#departmentError').html('<span class="errorSpan"> *</span>');
            }

            if ($('#hireStatus').val() == "empty") {
                $('#hireStatus').toggleClass('inputRender validateError')
                $('#hireStatusError').html('<span class="errorSpan"> * You have to choose a hire status before proceeding</span>');
                cansubmit = false;
            }
            else {
                $('#hireStatusError').html('<span class="errorSpan"> * </span>');
            }


            if ($('#startDate').val().length < 2) {
                $('#startDate').toggleClass('inputRender validateError')
                $('#startDateError').html('<span class="errorSpan"> * You have to choose a start date before proceeding</span>');
                cansubmit = false;
            }
            else {
                $('#startDateError').html('<span class="errorSpan"> * </span>');
            }


            if ($('#payrollDate').val().length < 2) {
                $('#payrollDate').toggleClass('inputRender validateError')
                $('#payrollDateError').html('<span class="errorSpan"> * You have to choose a payroll start date before proceeding</span>');
                cansubmit = false;
            }
            else {
                $('#payrollDateError').html('<span class="errorSpan"> * </span>');
            }

            if ($('#location').val() == "empty") {
                $('#location').toggleClass('inputRender validateError')
                $('#locationError').html('<span class="errorSpan"> * You must choose a location before proceeding</span>');
                cansubmit = false;
            }
            else {
                $('#locationError').html('<span class="errorSpan"> * </span>');
            }


            if (cansubmit == false) {
                $('#errorDiv').html("* You have some errors in your form, Please check the fields in red.");
                $("html, body").animate({ scrollTop: 0 }, "slow");
            }

        });


        $("#startDate").datepicker({"dateFormat": "mm/dd/yy"});


        var d = new Date();
        var n = d.getFullYear() - 30;
        $("#birthDate").datepicker({
            defaultDate: new Date('23 February ' + n),
            changeYear: true,
            changeMonth: true,
            "dateFormat": "mm/dd/yy",
            onSelect: function (dateText) {
                $("#startDateError").html("");
            }
        })

        $("#benefitDate").datepicker({
            "dateFormat": "mm/dd/yy",
            onSelect: function (dateText) {
                $("#startDateError").html("");
            }
        });

        $("#payrollDate").datepicker({
            "dateFormat": "mm/dd/yy",
            onSelect: function (dateText) {
                $("#startDateError").html("");
            }
        });

        $("#HRB").datepicker({
            "dateFormat": "mm/dd/yy",
            onSelect: function (dateText) {
                $("#startDateError").html("");
            }
        });


        /*
        function validateEmail(email){
            $.ajax({
                type: "POST",
                url: "chkeml",
                data: {email: $("#managerEmail").val() },
                beforeSend: function () {
                    $('#emailValidation').html('');
                    $('<img src="images/wait.gif" align="middle">').load(function () {
                        $(this).width(23).height(23).appendTo('#emailValidation');
                    });
                }
            })
                .done(function (msg) {
                    if(msg==='true')
                    $("#emailValidation").html('<span class="signature">✔ verified</span>'); else
                        $("#emailValidation").html('<span class="signature">(Not verified)</span>');
                })
        }
        */

        $("#manager").autocomplete({
            source: "/autocomplete",
            minLength: 2,
            select: function (event, ui) {
                $("#manager").val(ui.item.label);
                $("#managerEmail").val(ui.item.value);
                return false;
            }
        });

    });
}(jQuery));