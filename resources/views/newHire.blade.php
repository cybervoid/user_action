@extends('mainTemplate')

@section('content')

<link rel="stylesheet" href="css/theForms.css">


<div class="theForm" id="content">


<br>
<form method="post" action="newHire.php" name="newHire" id="newHire">
<div class="report" id="report" hidden=""></div>
<div class="processForm">

    <div class="subHeader">Personal information</div>
    <ul>
        <li>
            <label>Name</label>
            <input type="text" class="inputRender" name="name" id="name" required="">
        </li>
        <li>
            <label>Last Name</label>
            <input type="text" class="inputRender" name="lastName" id="lastName" required="">
        </li>
</ul>
        <p>
        <div class="subHeader">Payroll</div></p>


    <ul>
        <li>
            <div class="left3">
                <label>Department</label>
                <select class="inputRender" name="department" id="department">
                    <option value="empty">Select</option>
                    <option>Sales</option>
                    <option>Customer Care</option>
                    <option>Finance</option>
                    <option>IT</option>
                    <option>Marketing</option>
                    <option>HR</option>
                </select><span id="departmentError" class="errorSpan">*</span><br>
            </div>
            <div class="left3">
                Employee #
                <input type="text" class="inputRender" name="employee" id="employee"> <br>
            </div>
            <div class="left3">
                Date of Birth: <input type="text" class="inputRender" name="birthDate" id="birthDate" style="width: 100px">
            </div>
            <br style="clear: left">
        </li>
        <li>
            <label>Title</label>
            <input type="text" class="inputRender" name="title" id="title" required="">
        </li>
        <li>
            <div>
            <span class="left">
                <label>Manager</label>
                <input type="text" class="inputRender" name="manager" id="manager" required="">
            </span>
            <span class="left">
                <label>Manager's Email</label>
                <input type="text" class="inputRender" name="managerEmail" id="managerEmail" required="">
            </span>
                <p>&nbsp;</p>
            </div>
        </li>


        <!-- Employee New Hire Status -->

        <li>
            <div style="float:left; width:50%;">
                <label>Employee New Hire Status</label>
                <select class="inputRender" name="hireStatus" id="hireStatus">
                    <option value="empty">Select</option>
                    <option value="Full-time">Full-time</option>
                    <option value="Part-Time">Part-Time</option>
                </select><span id="hireStatusError" class="errorSpan">*</span>
                <br>
            </div>
            <div style="float:left; width:50%;">
                <select name="exepmtion" id="exepmtion" class="inputRender">
                    <option value="No-Exempt">Non-Exempt</option>
                    <option value="Exempt">Exempt</option>
                </select>
            </div>
            <br style="clear: left">
        </li>
        <li>
            <div class="left">
                Start Date
                <input type="text" class="inputRender" name="startDate" id="startDate" readonly style="width: 100px" required="">
                <br><span id="startDateError" class="errorSpan"></span>
            </div>
            <div class="left">
                <label>Benefits effective Date <br> (Medical, Dental, FSA) 1st of the month following 30 days of employment</label>
                <input type="text" class="inputRender" name="benefitDate" id="benefitDate" readonly style="width: 100px">
                <br><span id="benefitDateError" class="errorSpan"></span>
            </div>
            <br style="clear: left">
        </li>
    </ul>



        <!-- following 30 days of employment -->

        <br>
        <br>
        <p><div class="subHeader">Payroll/Salary</div></p>
        <hr>

    <ul>
        <li>

            <p style="text-align: center">
                Date: Hire Date (1 and 16th where applicable):
                <input type="text" class="inputRender" name="payrollDate" id="payrollDate" readonly style="width: 100px" required="">
                <br><span id="payrollDateError" class="errorSpan"></span>
            </p>


            <div class="left">
                <p>Payroll/Salary:</p>
                <input type="text" class="inputRender" name="salary" id="salary" style="width: 70px">
                <select name="salaryType" id="salaryType" class="inputRender">
                    <option value="Annual Salary">Annual Salary</option>
                    <option value="Hourly">Hourly</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="left">
                <p>Bonus</p>
                <input type="text" class="inputRender" name="bonus" id="bonus" style="width: 70px">
            </div>

            <br style="clear: left">
            <div class="center">
                <p>Transportation Allowance</p>
                <input type="text" class="inputRender" name="trans" id="trans">
            </div>
            <br style="clear: left">
        </li>
    </ul>

        <br><br><br>
        <!-- Employee Benefits Section: -->
        <p><div class="subHeader">Employee Benefits Section:</div></p>
        <hr>

        <label>HRB Entry Date:</label>
        <input type="text" class="inputRender" name="HRB" id="HRB" readonly style="width: 100px">
        <br><span id="HRBError" class="errorSpan"></span>
        <li>
            <label>Payroll Comments</label>
            <textarea class="inputRender" cols="40" rows="6" id="payrollComments" name="payrollComments"></textarea>
        </li>


        <p><div class="subHeader">Information for other departments:</div></p>
        <hr>


        <li>
            <label>Location</label>
            <select class="inputRender" name="location" id="location">
                <option value="empty">Select</option>
                <option value="Rye Brook">Rye Brook</option>
                <option value="New York City">NYC</option>
                <option value="Canada">Canada</option>
                <option value="Scottsdale">Scottsdale</option>
                <option value="Remote Users">Other</option>
            </select><span id="locationError" class="errorSpan">*</span>
        <span id="location_Other_Span" hidden="true">
            <input class="inputRender" type="text" name="location_Other" id="location_Other">
            </span>
        </li>
</div>



<br><br>

<div class="subHeader">
    IT Service Desk
    E-Mail Distribution List:</div>
<span class="checkbox">
        <ul id="itCheckList">
            <li><label><input type="checkbox" class="inputRender" name="iTDeptEmail[]" id="illyusaNA" value="illyusaNorth America" checked> illyusaNorth America</label></li>
            <li><label><input type="checkbox" class="inputRender" name="iTDeptEmail[]" id="illyryebrook" value="illyryebrook"> illyryebrook</label></li>
            <li><label><input type="checkbox" class="inputRender" name="iTDeptEmail[]" id="illyManagers" value="illyManagers"> illyManagers</label></li>
            <li><label><input type="checkbox" class="inputRender" name="iTDeptEmail[]" id="illySales" value="illySales"> illySales</label></li>
            <li><label><input type="checkbox" class="inputRender" name="iTDeptEmail[]" id="citrix" value="Sales Center/Citrix and Genesys ID. (applicable for Customer Care)"> Sales Center/Citrix and Genesys ID. (applicable for Customer Care)</label></li>


            <li><label><input type="checkbox" class="inputRender" name="iTDept[]" id="email" value="e-mail Scanner (if applicable)"> e-mail Scanner (if applicable)</label></li>
            <li id="prepareLaptop"><label><input type="checkbox" class="inputRender" name="iTDept[]" id="laptop" value="Laptop"> Laptop</label></li>
            <li><label><input type="checkbox" class="inputRender" name="iTDept[]" id="cellphone" value="Cell Phone"> Cell Phone</label></li>
            <li><label><input type="checkbox" class="inputRender" name="iTDept[]" id="phone" value="Phone extension"> Phone extension</label></li>
            <li><label><input type="checkbox" class="inputRender" name="iTDept[]" id="software" value="Software"> Software</label></li>
            <li><label><input type="checkbox" class="inputRender" name="iTDept[]" id="outlook" value="Add title and contact information in Outlook"> Add title and contact information in Outlook</label></li>
        </ul>

<br>
<div class="subHeader">IT Oracle Specialist</div>
<label>
    <input type="checkbox" class="inputRender" name="oracle" id="oracle" value="Oracle Access (Sales, Finance, Logistics, Customer Care, IT, Tech Svcs)"> Oracle Access (Sales, Finance, Logistics, Customer Care, IT, Tech Svcs)</label>

    <br><br>
<div class="subHeader"> Administration Office</div>

    <ul>
        <li>
            <label><input type="checkbox" class="inputRender" name="oManager[]" id="accessCard" value="Access Card, if applicable"> Access Card, if applicable</label>
        </li>
        <li>
            <label><input type="checkbox" class="inputRender" name="oManager[]" id="seat" value="Seating Assignment, if applicable"> Seating Assignment, if applicable</label>
        </li>
        <li>
            <label><input type="checkbox" class="inputRender" name="oManager[]" id="corpCalendar" value="Corp Calendar"> Corp Calendar</label>
        </li>
        <li>
            <label><input type="checkbox" class="inputRender" name="oManager[]" id="giftCard" value="Gift Card, provide to HR Manager"> Gift Card, provide to HR Manager</label>
        </li>
        <li>
            <label><input type="checkbox" class="inputRender" name="oManager[]" id="businessCard" value="Business Cards"> Business Cards</label>
        </li>
        <li>
            <label><input type="checkbox" class="inputRender" name="oManager[]" id="fedex" value="FedEx Address Book"> FedEx Address Book</label>
        </li>
    </ul>

    <br><br>
Aditional Instructions if applicable: <br>
<textarea class="inputRender" cols="40" rows="6" id="comments" name="comments"></textarea>

    <br>
    <input type="submit" class="inputRender">

</div>




<script src="js/newHire.js"></script>


@endsection
