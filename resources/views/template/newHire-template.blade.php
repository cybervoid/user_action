<div class="theForm" id="content" >

    <div class="centerMe" ><br >
        Human Resources<br >
        * Actions processed within 24 hours <br >
    </div >
    <br >

    <form method="post" action="/add" name="newHire" id="newHire" >

        <input type="hidden" name="reportType" id="reportType" value="newHire" >

        <div class="report" id="report" hidden="" ></div >
        <div class="processForm" >

            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" >

            <p ></p >
            <div >
                Date of Hire (1 and 16th where applicable):
                <input type="text" class="inputRender" name="startDate" id="startDate" readonly
                       style="width: 100px"
                       required="" value="" >

                <br ><span id="startDateError" class="errorSpan" ></span >
                <br >
            </div >

            <div class="subHeader" >Personal information</div >
            <ul >
                <li >
                    <label >First Name</label >
                    <input type="text" class="inputRender" name="name" id="name" value="" required="" >
                </li >
                <li >
                    <label >Last Name</label >
                    <input type="text" class="inputRender" name="lastName" id="lastName" value="" required="" >
                </li >
                <li >
                    <label >
                        Date of Birth: </label >
                    <input type="text" class="inputRender" name="birthDate" id="birthDate"
                           style="width: 100px" >
                </li >
            </ul >
            <p >
            <div class="subHeader" >Company</div >
            </p>

            <li >
            <span class="left" >
                @if(count($companies)>0)
                    Will be working for
                    <select class="inputRender" name="company" id="company" >
                        <option value="" >Select company</option >
                        @foreach($companies as $company)
                            <option >{{ $company }}</option >
                        @endforeach
                    </select ><span id="companyError" class="errorSpan" >*</span ><br >
                @endif
            </span >

            <span class="left" >
                    @if(count($departments)>0)
                    Department
                    <select class="inputRender" name="department" id="department" >
                            <option value="" >Select department</option >
                        @foreach($departments as $department)
                            <option >{{ $department }}</option >
                        @endforeach
                        </select ><span id="departmentError" class="errorSpan" >*</span ><br >
                @endif
            </span >
                <br style="clear: left" >
            </li >
            <li >
                <div class="left" >
                    Buddy Name:
                    <input type="text" class="inputRender" name="buddy" id="buddy" size="20" >
                </div >
                <div class="left" >
                    JDE #
                    <input type="text" class="inputRender" name="employee" id="employee" > <br >
                </div >
                <br style="clear: left" >
            </li >
            <li >
                <div class="left" >
                    Title
                    <input type="text" class="inputRender" name="title" id="title" value="" required="" >
                </div >
                <div class="left" >
                    @if(count($locations)>0)
                        Location
                        <select class="inputRender" name="location" id="location" >
                            <option value="" >Select location</option >
                            @foreach($locations as $type)
                                <option >{{ $type }}</option >
                            @endforeach
                        </select ><span id="locationError" class="errorSpan" >*</span >
                    @endif
                    <span id="location_Other_Span" hidden="true" >
            <input class="inputRender" type="text" name="location_Other" id="location_Other" >
            </span >
                </div >
                <p ></p >
            </li >
            <li >
                <div >
            <span class="left" >
                <label >Manager</label >
                <input type="text" class="inputRender" name="manager" id="manager" required="" >
                <span id="searchProgress" ></span >
            </span >
            <span class="left" >
                <label >Manager's Email</label >
                <input type="text" class="inputRender" name="managerEmail" id="managerEmail" required="" >
            </span >

                    <p >&nbsp;</p >
                </div >
            </li >


            <!-- Employee New Hire Status -->
            <li >
                <div class="left" >
                    @if(count($hireStatus)>0)
                        Action
                        <select class="inputRender" name="hireStatus" id="hireStatus" >
                            <option value="" >Select action</option >
                            @foreach($hireStatus as $status)
                                <option >{{ $status }}</option >
                            @endforeach
                        </select ><span id="hireStatusError" class="errorSpan" >*</span ><br >
                    @endif

                </div >
                <div class="left" >
                    @if(count($associate_class)>0)
                        Associate Classification
                        <select class="inputRender" name="hireStatus" id="hireStatus" >
                            <option value="" >Select associate classification</option >
                            @foreach($associate_class as $item)
                                <option >{{ $item }}</option >
                            @endforeach
                        </select >
                    @endif

                </div >
                <br style="clear: left" >
            </li >

            <!-- following 30 days of employment -->
            <br ><br >
            <p >

            <div class="subHeader" >Payroll/Salary</div >
            </p>
            <hr >
            <ul >
                <li >
                    <span class="centerInsideLi" >
                        Payroll type:
                        <select name="payrollType" id="payrollType" class="inputRender" >
                            <option value="" >Select Payroll Type</option >
                            <option value="ADP Payroll" >ADP Payroll</option >
                            <option value="Non - ADP Payroll" >Non - ADP Payroll</option >
                            </select >
                    </span >
                </li >
                <li >
                    <div class="left3" >
                        @if(count($salaryType)>0)
                            <p >Payroll/Salary:</p >
                            $<input type="text" class="inputRender" name="salary" id="salary" style="width: 70px" >
                            <select name="salaryType" id="salaryType" class="inputRender" >
                                <option value="" >Select</option >
                                @foreach($salaryType as $type)
                                    <option >{{ $type }}</option >
                                @endforeach
                            </select ><span id="salaryTypeError" class="errorSpan" >*</span ><br >
                        @endif
                    </div >
                    <div class="left3" >
                        <p >Transportation Allowance</p >
                        <input type="text" class="inputRender" name="trans" id="trans" >
                    </div >
                    <div class="left3" >
                        <p >Bonus</p >
                        <input type="text" class="inputRender" name="bonus" id="bonus" style="width: 70px" >
                    </div >
                    <br style="clear: left" >
                </li >
                <li >
                <span class="left" >
                <select name="exepmtion" id="exepmtion" class="inputRender" >
                    <option value="No-Exempt" >Non-Exempt</option >
                    <option value="Exempt" >Exempt</option >
                </select >
            </span >
            <span class="left" >
                Benefits effective Date <br > (Medical, Dental, FSA) 1st of the month following 30 days
                of
                employment
                <input type="text" class="inputRender" name="benefitDate" id="benefitDate" readonly
                       style="width: 100px" >
                <span id="benefitDateError" class="errorSpan" ></span >
            </span >

                </li >

            </ul >


            <br style="clear: left" >
            <p ></p >

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
                    <textarea class="inputRender" cols="40" rows="6" id="payrollComments"
                              name="payrollComments" ></textarea >
            </li >
            <p >
            <div class="subHeader" >Information for other departments:</div >
            </p>
            <hr >
        </div >
        <br >

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
            <li ><label ><input type="checkbox" class="inputRender" name="iTDeptEmail[]" id="illyCanadaTeam"
                                value="illyCanada" >illy Canada Distribution Group</label ></li >
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
</span >
        <br >

        <div class="subHeader" >Specific assets and or functionalities needed: not listed on the User Notification
            form
            should be confirmed with hiring manager by IT.
            <p ></p >

            <P ></P ></div >
        <div class="subHeader" >JDE Setup - IT Team</div >
<span class="checkbox" >
<ul >
    <li >
        <label >
            <input type="checkbox" class="inputRender" name="application" id="application"
                   value="Contact Hiring manager to get job requirements for proper JDE setup" >
            Contact Hiring manager to get job requirements for proper JDE setup</label >
        </li >
    </ul >
    </span >
        <br ><br >

        <div class="subHeader" >HQ Office Manager-Suzie Schwab and Stephanie Brush</div >

<span class="checkbox" >
<ul >
    <li >
        <label ><input type="checkbox" class="inputRender" name="oManager[]" id="accessCard"
                       value="Access Card, if applicable" > Access Card, if applicable</label >
    </li >
    <li >
        <label ><input type="checkbox" class="inputRender" name="oManager[]" id="seat"
                       value="Seating Assignment, if applicable" > Seating Assignment, if
            applicable</label >
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
        <label ><input type="checkbox" class="inputRender" name="oManager[]" id="fedex"
                       value="FedEx Address Book" >
            FedEx Address Book</label >
    </li >
</ul >
</span >

        <p ></p >

        <div class="subHeader" >New Driver for Company Vehicle Form-Erik Tellone (new hire notification only) (if
            applicable)
        </div >
<span class="checkbox" >
<ul >
    <li >
        <label ><input type="checkbox" class="inputRender" name="newDriver" id="newDriver"
                       value="Form to Hiring Manager" > Form to Hiring Manager</label >
</li >
    </ul >
    </span >
        <p ></p >

        <div class="subHeader" >
            Finance - Marjorie Guthrie<br >
            (Credit Card and Concur Access Requests) *new hires and separation


        </div >
        <span class="checkbox" >
<ul >
    <li >
        <label ><input type="checkbox" class="inputRender" name="creditCard[]" id="creditCard"
                       value="COMPANY CREDIT CARD" > COMPANY CREDIT CARD</label >
    </li >
    <li >
        <label ><input type="checkbox" class="inputRender" name="creditCard[]" id="concur"
                       value="Concur Access" >
            Concur Access</label >
    </li >
</ul >
</span >

        <br ><br >
<span ><div class="subHeader" >
        SPECIFIC INSTRUCTIONS HERE:
    </div ></span >
        <textarea class="inputRender" cols="40" rows="6" id="comments" name="comments" ></textarea >

        <br ><br >
        <input type="button" class="inputRender" id="cancel" value="Cancel" >
        <input type="submit" class="inputRender" name="submit" id="submit" >
