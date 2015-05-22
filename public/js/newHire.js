/**
 * Created by rafag on 3/21/15.
 */

var App = App || {};

(function ($) {
    "use strict";

    App.newHire = App.newHire || {};

    $(App.templates.newHire()).appendTo('#newHireFrm');

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
                $("#prepareLaptop").after('<li id="ship" style="padding-left: 20px"><label><input type="checkbox" class="inputRender" name="iTDept[]" id="laptopShipping" value="Laptop needs to be shipped to an outside location, please contact hiring manager for address"> Laptop needs to be shipped to an outside location, please contact hiring manager for address</label></li>');
            }
            else {
                $("#ship").remove()
            }
        });
        $('#cancel').click(function () {  // cancel the new hire and move to the main page
            window.location.href = "/";
        });

        $('#manager').keyup(function () {
            $('#managerEmail').val($("#manager").val().toLowerCase().trim().replace(" ", ".") + "@illy.com");
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
            //else {  // run ajax

                // create the user
                /*
                $.ajax({
                    type: "POST",
                    url: "add",
                    data: $("#newHire").serialize()
                })
                    .done(function (msg) {
                        $('#newHireFrm').html(App.templates.newHire(msg));
                        console.log(msg);
                        //$('#report').html(msg);
                    });


                // create word document with the form info

                $.ajax({
                    type: "POST",
                    url: "newHire_export_ajax.php",
                    data: $("#newHire").serialize(),
                    start: function(){
                        $("#content").html('Processing your request ...');
                    }
                })
                    .done(function( msg ) {
                        $("#errorDiv").html("");
                        if(msg !="done"){
                            $("#errorDiv").html("Unexpected error occurred while processing your request.");
                            $("#content").html(msg);
                        } else{

                            donePage = '<br><br><p class="center">Your request has been processed successfully<p>';
                            donePage = donePage + '<p>We have created two forms, one has been sent to Payroll and the other to service desk, these are the download links</p>';
                            donePage = donePage + '<p>Employee: ' + $("#name").val() + ' ' + $("#lastName").val();

                            donePage = donePage + '<ul>';
                            donePage = donePage + '<li>Payroll form: <a target="_blank" href="files/docs/Action User Notification-' + $("#name").val() + ' ' + $('#lastName').val() + '.doc">pAYROLL User Notification-'+ $("#name").val() + ' ' + $("#lastName").val() + '.doc</a></li>';
                            donePage = donePage + '<li>Service desk form: <a target="_blank" href="files/docs/User Notification-' + $("#name").val() + ' ' + $('#lastName').val() + '.doc">User Notification-'+ $("#name").val() + ' ' + $("#lastName").val() + '.doc</a></li>';
                            donePage = donePage + '</ul>';

                            donePage = donePage + '<p>The reports are being stored in the <strong>"Human Resources"</strong> shared drive, under a folder named <strong>"Employee Action Forms"</strong>.</p>';
                            donePage = donePage + '<br><br><br><p class="subHeader">What\'s next: <br></p>';

                            donePage = donePage + '<ul class="navigation" style="text-align: center"><li class="myNavigation navigationLink" id="home">Home Screen</a></li><li class="myNavigation navigationLink" id="another">Add another employee</li></ul>';

                            $("#content").html(donePage);
                        }

                        activateMenu().on('click', function (e) {
                            switch ($(this).attr('id')){
                                case "home":
                                    window.location.href='mainPage.php';
                                    break;
                                case "another":
                                    window.location.href='newHire.php';
                                    break;
                            }
                        });

                    });
                */

            //}

        });
        $("#startDate").datepicker({
            onSelect: function (dateText) {
                $("#startDateError").html("");
            }
        });
        var d = new Date();
        var n = d.getFullYear() - 30;
        $("#birthDate").datepicker({
            defaultDate: new Date('23 February ' + n),
            changeYear: true,
            changeMonth: true,
            onSelect: function (dateText) {
                $("#startDateError").html("");
            }
        })

        $("#benefitDate").datepicker({
            onSelect: function (dateText) {
                $("#startDateError").html("");
            }
        });

        $("#payrollDate").datepicker({
            onSelect: function (dateText) {
                $("#startDateError").html("");
            }
        });

        $("#HRB").datepicker({
            onSelect: function (dateText) {
                $("#startDateError").html("");
            }
        });

// aqui


    });

}(jQuery));