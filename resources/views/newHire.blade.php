@extends('mainTemplate')

@section('javascript')
    <script src="js/newHire.js" ></script >
@endsection

@section('css')
    <link rel="stylesheet" href="css/theForms.css" >
@endsection


@section('content')


    <div class="theForm" id="content" >

        <div class="centerMe" ><br >
            Human Resources<br >
            * Transactions to be processed within 48 hours of notification <br >
        </div >


        <br >

        <form method="post" action="/add" name="newHire" id="newHire" >

            <input type="hidden" name="reportType" id="reportType" value="newHire" >

            <div class="report" id="report" hidden="" ></div >
            <div class="processForm" >

                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" >

                <div class="subHeader" >Personal information</div >
                <ul >
                    <li >
                        <label >Name</label >

                        <input type="text" class="inputRender" name="name" id="name" required="" value="" >

                    </li >
                    <li >
                        <label >Last Name</label >
                        <input type="text" class="inputRender" name="lastName" id="lastName" required="" value="" >
                    </li >
                    <li >
                        <label >Buddy Name:</label >
                        <input type="text" class="inputRender" name="buddy" id="buddy" >
                    </li >
                </ul >

                <p >

                <div class="subHeader" >Company</div >
                </p>

<div >
    <label >Will be working for</label >
    <select class="inputRender" name="company" id="company" >
        <option value="empty" >Select</option >
        <option >illy caffè North America, Inc.</option >
        <option >Espressamente illy</option >
        <option >illy Espresso Canada</option >
    </select ><span id="companyError" class="errorSpan" >*</span ><br >
</div >

<p ></p >

<p >

<div class="subHeader" >Payroll</div >
</p>


<li >
    <div class="left3" >
        <label >Department</label >
        <select class="inputRender" name="department" id="department" >
            <option value="empty" >Select</option >
            <option >Sales</option >
            <option >Customer Care</option >
            <option >Finance</option >
            <option >Information Technology</option >
            <option >Marketing</option >
            <option >Human Resources</option >
            <option >Quality and Tech</option >
        </select ><span id="departmentError" class="errorSpan" >*</span ><br >
    </div >
    <div class="left3" >
        Employee #
        <input type="text" class="inputRender" name="employee" id="employee" > <br >
    </div >
    <div class="left3" >
        Date of Birth: <input type="text" class="inputRender" name="birthDate" id="birthDate" style="width: 100px" >
    </div >
    <br style="clear: left" >
</li >
<li >
    <label >Title</label >
    <input type="text" class="inputRender" name="title" id="title" required="" value="" >
</li >
<li >
    <div >
            <span class="left" >
                <label >Manager</label >
                <input type="text" class="inputRender" name="manager" id="manager" required="">
                <span id="searchProgress"></span>
            </span >
            <span class="left" >
                <label >Manager's Email</label >
                <input type="text" class="inputRender" name="managerEmail" id="managerEmail" required="">
            </span >

        <p >&nbsp;</p >
    </div >
</li >


<!-- Employee New Hire Status -->
<li >
    <div style="float:left; width:50%;" >
        <label >Employee New Hire Status</label >
        <select class="inputRender" name="hireStatus" id="hireStatus" >
            <option value="empty" >Select</option >
            <option value="Full-time" >Full-time</option >
            <option value="Part-Time" >Part-Time</option >
        </select ><span id="hireStatusError" class="errorSpan" >*</span >
        <br >
    </div >
    <div style="float:left; width:50%;" >
        <select name="exepmtion" id="exepmtion" class="inputRender" >
            <option value="No-Exempt" >Non-Exempt</option >
            <option value="Exempt" >Exempt</option >
        </select >
    </div >
    <br style="clear: left" >
</li >


<li >
    <div class="left" >
        Start Date
        <input type="text" class="inputRender" name="startDate" id="startDate" readonly style="width: 100px"
               required="" value="" >
        <br ><span id="startDateError" class="errorSpan" ></span >
    </div >
    <div class="left" >
        <label >Benefits effective Date <br > (Medical, Dental, FSA) 1st of the month following 30 days of
            employment</label >
        <input type="text" class="inputRender" name="benefitDate" id="benefitDate" readonly style="width: 100px" >
        <br ><span id="benefitDateError" class="errorSpan" ></span >
    </div >
    <br style="clear: left" >
</li >


<!-- following 30 days of employment -->

<br >
<br >

<p >

<div class="subHeader" >Payroll/Salary</div >
</p>
<hr >

<ul >
    <li >

        <p style="text-align: center" >
            Date: Hire Date (1 and 16th where applicable):
            <input type="text" class="inputRender" name="payrollDate" id="payrollDate" readonly style="width: 100px"
                   required="" value="" >
            <br ><span id="payrollDateError" class="errorSpan" ></span >
        </p >
    </li >
    <li >

        <div class="left3" >
            <p >Payroll/Salary:</p >
            <input type="text" class="inputRender" name="salary" id="salary" style="width: 70px" >
            <select name="salaryType" id="salaryType" class="inputRender" >
                <option value="" >Select</option >
                <option value="Annual Salary" >Annual Salary</option >
                <option value="Hourly" >Hourly</option >
                <option value="Half Month" >Half Month</option >
                <option value="Other" >Other</option >
            </select >
        </div >
        <div class="left3" >
            <p >Sales level</p >

            <select name="salesLevel" id="salesLevel" class="inputRender" >
                <option value="" >Select</option >
                <option value="Level I District Sales Manager" >Level I District Sales Manager</option >
                <option value="Level IA Business Development Manager" >Level IA Business Development Manager</option >
                <option value="Level II Branch Sales Manager" >Level II Branch Sales Manager</option >
                <option
                    value="Level III Regional / Division Sales Manager / <br> National Retail Managers / Systems Mgr" >
                    Level III
                </option >
                <option value="Level IV Director / VP" >Level IV Director / VP</option >
            </select >


        </div >
        <div class="left3" >
            <p >Bonus</p >
            <input type="text" class="inputRender" name="bonus" id="bonus" style="width: 70px" >
        </div >

        <br style="clear: left" >

        <p ></p >

        <div id="salesLevelDiv" class="center specialAnnouncements" ></div >
        <div class="center" >
            <p >Transportation Allowance</p >
            <input type="text" class="inputRender" name="trans" id="trans" >
        </div >
        <br style="clear: left" >
    </li >
</ul >

<br ><br ><br >
<!-- Employee Benefits Section: -->
<p >

    <div class="subHeader" >New Hire HRIS entry:</div >
</p>
<hr >

<label >HRB Entry Date:</label >
<input type="text" class="inputRender" name="HRB" id="HRB" readonly style="width: 100px" >
<br ><span id="HRBError" class="errorSpan" ></span >
<li >
    <label >Payroll Comments</label >
    <textarea class="inputRender" cols="40" rows="6" id="payrollComments" name="payrollComments" ></textarea >
</li >


<p >

<div class="subHeader" >Information for other departments:</div >
</p>
<hr >

<li >
    <label >Location</label >
    <select class="inputRender" name="location" id="location" >
        <option value="empty" >Select</option >
        <option value="Rye Brook" >Rye Brook</option >
        <option value="New York City" >NYC</option >
        <option value="Canada" >Canada</option >
        <option value="Scottsdale" >Scottsdale</option >
        <option value="Remote Users" >Other</option >
    </select ><span id="locationError" class="errorSpan" >*</span >
        <span id="location_Other_Span" hidden="true" >
            <input class="inputRender" type="text" name="location_Other" id="location_Other" >
            </span >
</li >
</div >


<br ><br >

<div class="subHeader" >
    IT Department Checklist: Rafael Gil and Service Desk<br >
    E-Mail Distribution List:
</div >
<span class="checkbox" >
        <ul id="itCheckList" >
            <li id="prepareLaptop" ><label ><input type="checkbox" class="inputRender" name="iTDept[]" id="laptop"
                                                   value="Laptop" >Laptop/Computer</label ></li >


            <p >Standard notification request includes on all computers/laptops: OfficeSuite, Adobe Acrobat Pro,
                CCleaner, VPN, Efax, Chrome, Firefox, Silverlight, FlashPlayer, Omniform, Skype, Dropbox, VLC Media
                Player, 7Zip. Outlook, Addition to distributions lists.</p >

            <p > All Cellphones will include a link to Hotspot set up.</p >

            <p > *Upon user notification request, IT provides customer service to hiring manager and new hire. Hiring
                managers will be contacted before new hire begins.</p >

            <p >Laptop needs to be shipped to an outside location, please contact Human Resources Manager for address.
                Computer and or other equipment will be delivered 3 days prior to hire date. An email confirmation
                notification
                will be sent to Hiring manager, Associate and Human Resources Manager.</p >
            <p ></p >

            <li ><label ><input type="checkbox" class="inputRender" name="iTDeptEmail[]" id="illyusaTeam"
                                value="illyusaNorth America" checked >illyusaTeam Distribution Group</label ></li >
            <li ><label ><input type="checkbox" class="inputRender" name="iTDeptEmail[]" id="illyRyeBrook"
                                value="illyryebrook" >illyusa Rye Brook Distribution Group</label ></li >
            <li ><label ><input type="checkbox" class="inputRender" name="iTDeptEmail[]" id="illyNYCTeam"
                                value="illyusa NYC Team" >illy NYC Team Distribution Group</label ></li >
            <li ><label ><input type="checkbox" class="inputRender" name="iTDeptEmail[]" id="illyManagers"
                                value="illyManagers" >illyusa Managers Distribution Group</label ></li >
            <li ><label ><input type="checkbox" class="inputRender" name="iTDeptEmail[]" id="illySales"
                                value="illySales" >illyusa Sales Team Distribution Group</label ></li >

            <p ></p >

            <p ></p >
            <li ><label ><input type="checkbox" class="inputRender" name="iTDept[]" id="cellphone"
                                value="Cell Phone (Samsung Galaxy) *Cell phone number and company, will be updated in outlook upon receipt." >
                    Cell Phone (Samsung Galaxy) *Cell phone number and company, will be updated in outlook upon
                    receipt.</label ></li >
            <li ><label ><input type="checkbox" class="inputRender" name="iTDept[]" id="phone" value="Phone extension" >
                    Phone extension/Voice mail</label ></li >
            <li ><label ><input type="checkbox" class="inputRender" name="iTDept[]" id="fax" value="Fax number" > Fax
                    number</label ></li >
            <li ><label ><input type="checkbox" class="inputRender" name="iTDept[]" id="outlook"
                                value="Add title and contact information in Outlook" > Add title and contact information
                    in Outlook</label ></li >
            <li ><label ><input type="checkbox" class="inputRender" name="iTDept[]" id="citrix"
                                value="Sales Center/Citrix and Genesys ID. (applicable for Customer Care)" > Sales
                    Center/Citrix and Genesys ID. (applicable for Customer Care)</label ></li >
            <li ><label ><input type="checkbox" class="inputRender" name="iTDept[]" id="email"
                                value="e-mail Scanner (if applicable)" > e-mail Scanner (if applicable)</label ></li >

        </ul >

<br >
        <div class="subHeader" >Specific assets and or functionalities needed: not listed on the User Notification form
            should be confirmed with hiring manager by IT.
            <p ></p >
            SPECIFIC INSTRUCTIONS HERE:<P ></P ></div >
<div class="subHeader" >IT Oracle Specialist</div >
<label >
    <input type="checkbox" class="inputRender" name="oracle" id="oracle"
           value="Oracle Access/Oracle (HR) Number Approval (Sales, Finance, Logistics, Customer Care, IT, Tech Svcs)" >
    Oracle Access/Oracle (HR) Number Approval (Sales, Finance, Logistics, Customer Care, IT, Tech Svcs)</label >

    <br ><br >
<div class="subHeader" >Administration Office</div >

    <ul >
        <li >
            <label ><input type="checkbox" class="inputRender" name="oManager[]" id="accessCard"
                           value="Access Card, if applicable" > Access Card, if applicable</label >
        </li >
        <li >
            <label ><input type="checkbox" class="inputRender" name="oManager[]" id="seat"
                           value="Seating Assignment, if applicable" > Seating Assignment, if applicable</label >
        </li >
        <li >
            <label ><input type="checkbox" class="inputRender" name="oManager[]" id="corpCalendar"
                           value="Corp Calendar" > Corp Calendar</label >
        </li >
        <li >
            <label ><input type="checkbox" class="inputRender" name="oManager[]" id="giftCard"
                           value="Gift Card, provide to HR Manager" > Gift Card, provide to HR Manager</label >
        </li >
        <li >
            <label ><input type="checkbox" class="inputRender" name="oManager[]" id="businessCard"
                           value="Business Cards, if need to ship to outside location please contact
                hiring manager for address" > Business Cards, if need to ship to outside location please contact
                hiring manager for address</label >
        </li >
        <li >
            <label ><input type="checkbox" class="inputRender" name="oManager[]" id="fedex" value="FedEx Address Book" >
                FedEx Address Book</label >
        </li >
    </ul >
<p ></p >
    <div class="subHeader" >New Driver for Company Vehicle Form-Erik Tellone (new hire notification only) (if
        applicable)
    </div >

        <label ><input type="checkbox" class="inputRender" name="newDriver" id="newDriver"
                       value="Form to Hiring Manager" > Form to Hiring Manager</label >
    <p ></p >
    <div class="subHeader" >
        Finance - Marjorie Guthrie<br >
        (Credit Card and Concur Access Requests) *new hires and separation


    </div >
    <ul >
        <li >
            <label ><input type="checkbox" class="inputRender" name="creditCard[]" id="creditCard"
                           value="COMPANY CREDIT CARD" > COMPANY CREDIT CARD</label >
        </li >
        <li >
            <label ><input type="checkbox" class="inputRender" name="creditCard[]" id="concur" value="Concur Access" >
                Concur Access</label >
        </li >
    </ul >





    <br ><br >
Aditional Instructions if applicable: <br >
<textarea class="inputRender" cols="40" rows="6" id="comments" name="comments" ></textarea >

    <br ><br >
    <input type="submit" class="inputRender" name="submit" id="submit" >
    <input type="button" class="inputRender" id="cancel" value="Cancel" >

</div >

@endsection



