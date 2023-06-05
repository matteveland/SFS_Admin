<?php
include('navigation.php');
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Log</title>
</head>
<body>

<h3 align="center">Change Log</h3>
<div style="margin: 50px">

    30 Apr-20:<ul>
        <li>Corrected: Ability to duplicate accounts.</li>
    </ul>

    3 Aug-19:<ul>
        <li>Added: Trends for ESS alarms, Quarterly and Monthly.</li>
        <li>Changed: Visible information within ESS search. Now properly displaying all parts.</li>
    </ul>

    30 Jul-19:<ul>
        <li>Changed: Display ESS records to match time period required.</li>
        <li>Changed: Submission of ESS items to match time period required for NARFAR ratings.</li>
    </ul>
    18 Jul-19:<ul>
        <li>Corrected: Unit_ESS permissions.</li>
    </ul>

    18 Jul-19:<ul>
        <li>Changed: Sort for ESS view alarm data.</li>
        <li>Corrected: Email distribution for form types .</li>
    </ul>
    13 Jul-19:<ul>
        <li>Added: Manual update for 340s. Historical weather information is pulled from <a href="https://darksky.net/poweredby/">https://darksky.net/poweredby/ <img src="https://darksky.net/dev/img/attribution/poweredby.png" style="height: 3rem"> </a></li>
        <li>Corrected: Registration information not being inserted properly.</li>
    </ul>

    11 Jul-19:<ul>
        <li>Added: ESS Search page.</li>
        <li>Added: Additional ESS items to 340/781A page.</li>
        <li>Changed: 799 SFS to 432 SFS.</li>
    </ul>

    9 Jul-19:<ul>
        <li>Added: ESS Section. </li>
    </ul>

    26-May-19:<ul>
        <li>Corrected: email not updating to correct version.</li>
    </ul>

    18-May-19:<ul>
        <li>Updated: Import data page.</li>
        <li>Changed: Removed email from home page, now you are refereed to the suggestion page.</li>

    </ul>
    29-Apr-19:<ul>
        <li>Updated: all files to reflect administration move. If an error is found, please use the suggestion page to notify admin of the issue.</li>

    </ul>

    10-Mar-19:<ul>
        <li>Added: Leave checked against section. Leave will be prevented if 10% of section is on leave at a time.</li>
        <li>Changed: Leave within section is now displaying within next 60 days, a change from 45 days.</li>

    </ul>

    21-Feb-19:<ul>
        <li>Corrected: Order appointments were displaying.</li>
    </ul>

    19-Feb-19:<ul>
        <li>Added: Added sections to announcements page. Individual section(s) can now create announcements specific to their section or sections(s)</li>
        <li>Corrected: Unit now properly deletes when CCTK is uploaded, replacing the current data.</li>
    </ul>

    18-Feb-19:<ul>
        <li>Correct: Reset password error</li>
    </ul>

    18-Jan-19:<ul>
        <li>Correct: Send appointments</li>

    </ul>
    2-Jan-19:<ul>
        <li>Changed: DPE annual date to match annaul due date.</li>
        <li>Added: Color change to annual DPE due date for 90/60/30 days out.</li>

    </ul>

    31-Dec-18:<ul>
        <li>Added: Gov email to appointment roster distribution.</b></li>
        <li>Corrected: Password reset error.</b></li>
        <li>Changes: Email Opt-in/out format within user settings.</b></li>
        <li>Corrected: SFMQ trends page to reflect correct data.</b></li>
        <li>Added: SFMQ High Missed Questions.</b></li>
        </li>
    </ul>

    18-Nov-18:<ul>
        <li>Added: SFMQ search page.</b></li>
        <li>Added: SFMQ trends page.</b></li>
        <li>Added: SFMQ High Missed Questions.</b></li>

        </li>
    </ul>

    12-Oct-18:<ul>
        <li>Added: Work Order Section within S5.
        <li>Added: Work Order request can now be added through the S5 menu. Unit Work Order POC know has the ability to view/edit/remove Work Order request.
        <li>Added: Work Order request form. Submitted for will sent to the respective Work Order POC for information. Information sent via email is the same information which is viewable within the "View Work Order Request" page.
        <li>Changed: Mock Fitness Assessments can be removed. Official Test can not be deleted.</b>
        </li>
    </ul>

    8-Oct-18:<ul>
        <li>Added: Email address to registration page and user settings.

        </li>
    </ul>

    6-Oct-18:<ul>
        <li>Changed: the way data is stored within.

        </li>
    </ul>

    26-Sep-18:  <ul>
        <li>Added: RA Section within S4.
        <li>Added: Purchase request can now be added through the S4 menu. Unit RA's have the ability to view/edit/remove purchase request.
        <li>Added: Purchase request form. Submitted for will sent to the respective RA for information. Information sent via email is the same information which is viewable within the "View Purchase Request" page.
        </li>
    </ul>

    21-Aug-18:  <ul>
        <li>Added: Update Member page will now refresh with added content. This prevents a user from refreshing with previous information and updating an individual that does not potentially exist.
        <li>Changed: Cancel on Update Member page will now redirect to query matching individual's last name.
        <li>Changed: Suggestion page now correctly states submission are for sfsadmin.com.
        <li>Fixed: Error where member's duty section was not updating correctly when updating a member within the update member page..
        </li>
    </ul>

    20-Aug-18:  <ul>
        <li>Added: Update member now displays all DPE information related to an individual.<br>
        <li>Added: Section for starting Phase II on an individual. Added the option to update, certify, or remove an individual from Phase II.<br>
        <li>Added: Now displays all fitness information related to an individual. <br>
        <li>Added: Section for inputting fitness information.
        </li>
    </ul>

    4-Aug-18:  <ul>
        <li>Added: Suggestion page at <a href="https://sfsadmin.com/UnitTraining/contact.php">https://www.sfsadmin.com/UnitTraining/contact.php</a>.<br>
        </li>
    </ul>

    2-Aug-18:  <ul>
        <li>Fixed: Error allowing users to use the url to view resrticted informaiton.<br>
        </li>
    </ul>

    1-Aug-18:  <ul>
        <li>Added: Ability for owners of Taskers and Announcements to delete each as required.<br>
        <li>Option: Update Member page to allow users if needed in future.<br>
        <li>Fixed: Added proper database configuration for Taskers and Announcements.<br>
        <li>Fixed: Footer placement on update member page.<br>
        <li>Fixed: Removed Users from seeing certian options during query.<br>
        </li>
    </ul>

    31-Jul-18:  <ul>
        <li>Added member's photo to search.<br>
        <li>Fixed: Search now displays by member's last name alphabetically.<br>
        <li>Fixed: Error showing deleted members within sections.<br>
        <li>Added: S2 Section.<br>
        </li>
    </ul>

    25-Jul-18:  <ul>
        <li>Fixed:  Corrected error when registering a new member creating duplicate entries in SFMQ database.<br>
        </li>
    </ul>

    24-Jul-18:  <ul>
        <li>Changed delete function to prevent accidental deletion for nefarious reasons. Deleted member will now display who deleted member in database.<br>
        <li>Updated section search to not show deleted members within sections.<br>
        <li>Updated import of CBTs.<br>
        </li>
    </ul>

    23-Jul-18:  <ul>
        <li>Added Change Log to footer. <br>
        <li>Allow Users to subscribe or unsubscribe from emails.<br>
        </li>
    </ul>
</div>



</body>
</html>
<?php include __DIR__.'/footer.php';?>