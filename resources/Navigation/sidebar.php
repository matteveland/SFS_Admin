<?php
//page includes functions from function.php which is included from homepage.php
$findUser = new FindUser();
$findUser->get_user($_SESSION['page_user'], $_SESSION['page_admin']);
//$findMember = new FindMember();
//$findMember->find_member($findUser->dodId, $findUser->lastName, $findUser->unitName);


?>

<!-- Main Sidebar Container -->

<head>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
</head>
<aside class="main-sidebar sidebar-dark-primary elevation-4">

  <!-- Brand Logo -->
  <a href="<?php echo '/homepage.php'; ?>" class="brand-link">
    <img src="<?php echo '/public/Images/SFS_Admin_logo.png';?>" alt="SFS_Admin_logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">SFS Admin (<?php echo $findUser->unitName;?>)</span>
  </a>


  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">

      <div class="image">

        <?php
        switch ($findUser->imageDetail) {
          case '1':
          echo '<img src="'.$findUser->image.'" class="img-circle elevation-2" alt="User Image">';

          break;

          default:
          echo '<img src="/public/Uploads/default.jpeg" class="img-circle elevation-2" alt="User Image">';
          break;
        }
        ?>

      </div>

      <div class="info">
        <a href='/resources/Admin/Edit-User/user-view-settings.php?ID=<?php echo $findUser->dodId."&last=".$findUser->lastName;?>'class="d-block">
          <?php echo "$findUser->firstName $findUser->lastName"; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
          with font-awesome or any other icon font library -->


          <li class="nav-item <?php menuOpenAdmin(); ?>">
            <a href="#" class="nav-link <?php header_active_admin();?>" "">
              <i class="bi bi-gear"></i>
              <p>
                Administration
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="/resources/Admin/Appointments/appointment-view.php" class="nav-link <?php active("appointment-view.php");?>">
                  <i class="bi bi-calendar2-plus"></i>
                  <p>Appointments</p>
                </a>
              </li>



              <li class="nav-item">
                <a href="/resources/Admin/Create-User/register-view-user.php" class="nav-link <?php active("register-view-user.php");?>">
                  <i class="bi bi-person-plus"></i>
                  <p>Register User</p>
                </a>
              </li>





              <li class="nav-item">
                <a href="/resources/Admin/Admin-Panel/admin-view.php" class="nav-link <?php active("admin-view.php");?>">
                  <i class="bi bi-lock"></i>
                  <p>View Squadron Personnel</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="/resources/Admin/Admin-Panel/admin-view-master-access.php" class="nav-link <?php active('admin-view-master-access.php');?>">
                  <i class="bi bi-file-earmark-plus"></i>
                  <p>Set Master Information</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/resources/Admin/Admin-Panel/import/import-view.php" class="nav-link <?php active("import-view.php");?>">
                  <i class="bi bi-cloud-upload"></i>
                  <p>Import Data</p>
                </a>
              </li>
            </ul>
          </li>
          <!-- section pages in navigation tree -->
          <div class="user-panel"></div>
          <li class="nav-item <?php menuOpenSection();?>">
            <a href="" class="nav-link <?php header_active_section(); ?>">
              <i class="bi bi-shield"></i>
              <p>
                Section Information
                <i class="right fas fa-angle-left "></i>
              </p></a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/resources/operations/section-view-roster.php" class="nav-link <?php active('section-view-roster.php');?>">
                    <i class="bi bi-people"></i>
                    <p>Section Roster</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="/resources/operations/section-view-supervision.php" class="nav-link <?php active('section-view-supervision.php');?>">
                    <i class="bi bi-diagram-3"></i>
                    <p>Section Supervision</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="/resources/operations/section-view-appointments.php" class="nav-link <?php active('section-view-appointments.php');?>">
                    <i class="bi bi-calendar-date"></i>
                    <p>Section Appointments</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="/resources/operations/section-view-leave.php" class="nav-link <?php active('section-view-leave.php');?>">
                    <i class="bi bi-geo"></i>
                    <p>Section Leave</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/resources/operations/section-view-quals.php" class="nav-link <?php active('section-view-quals.php');?>">
                    <i class="bi bi-patch-check"></i>
                    <p>Section Qualifications</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="/resources/operations/section-view-weapons.php" class="nav-link <?php active('section-view-weapons.php');?>">
                    <i class="bi bi-lightning-charge"></i>
                    <p>Section Weapons</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="/resources/operations/section-view-admin.php" class="nav-link <?php active('section-view-admin.php');?>">
                    <i class="bi bi-journal-bookmark"></i>
                    <p>Section Admin Actions</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="/resources/operations/section-view-fitness.php" class="nav-link <?php active('section-view-fitness.php');?>">
                    <i class="bi bi-trophy"></i>
                    <p>Section Fitness</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="/resources/operations/section-view-readiness.php" class="nav-link <?php active('section-view-readiness.php');?>">
                    <i class="bi bi-briefcase"></i>
                    <p>Section Readiness</p>
                  </a>
                </li>
              </ul>
            </li>


            <!-- ESS pages in navigation tree -->
            <div class="user-panel"></div>
            <li class="nav-item <?php menuOpenAlarm();?>">
              <a href="#" class="nav-link <?php header_active_alarm();?>">
                <i class="bi bi-bell"></i>
                <p>
                  ESS
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">

                <li class="nav-item">
                  <a href="/resources/ESS/alarm-report.php" class="nav-link <?php active('alarm-report.php');?>">


                    <i class="bi bi-cloud-plus"></i>
                    <p>Alarm Reporting</p>
                  </a>



                </li>

                <li class="nav-item">
                  <a href="/resources/ESS/alarm-status-completed.php" class="nav-link <?php active('alarm-status-completed.php');?>">
                    <i class="bi bi-view-list"></i>
                    <p>Completed Alarm Data</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/resources/ESS/alarm-status-exterior.php" class="nav-link <?php active('alarm-status-exterior.php');?>">
                    <i class="bi bi-view-list"></i>
                    <p>Exterior Alarm Data</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/resources/ESS/alarm-status-interior.php" class="nav-link <?php active('alarm-status-interior.php');?>">
                    <i class="bi bi-view-list"></i>
                    <p>Interior Alarm Data</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="/resources/ESS/alarm-view-trends.php" class="nav-link <?php active('alarm-view-trends.php');?>">
                    <i class="bi bi-activity"></i>
                    <p>Alarm Trends</p>
                  </a>
                </li>
              </ul>
            </li>
            <!-- Vehicle pages in navigation tree -->
            <div class="user-panel"></div>

            <!-- Vehicles pages in navigation tree -->
            <li class="nav-item <?php menuOpenVehicle();?>">
              <a href="#" class="nav-link <?php header_active_vehicle() ?>">

                <i class="bi bi-speedometer2"></i>
                <p>
                  Vehicle
                  <i class="right fas fa-angle-left "></i>
                </p>
              </a>
              <ul class="nav nav-treeview">


                <li class="nav-item">
                  <a href="/resources/VCO/vehicle-report.php" class="nav-link <?php active('vehicle-report.php');?>">
                    <i class="bi bi-cloud-plus"></i>

                    <p>Vehicle Reporting</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="/resources/VCO/vehicle-status.php" class="nav-link <?php active('vehicle-status.php'); ?>">
                    <i class="bi bi-view-list"></i>
                    <p>Vehicle Status Tables</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="/resources/VCO/vehicle-view-new.php" class="nav-link <?php active('vehicle-view-new.php');?>">
                    <i class="bi bi-file-earmark-plus"></i>
                    <p>Add New Vehicle</p>
                  </a>
                </li>

              </ul>
            </li>

            <!-- Equipment pages in navigation tree -->
            <div class="user-panel"></div>
            <li class="nav-item <?php menuOpenEquipment();?>">
              <a href="#" class="nav-link <?php header_active_equipment() ?>">

                <i class="bi bi-house"></i>
                <p>
                  Equipment
                  <i class="right fas fa-angle-left "></i>
                </p>
              </a>
              <ul class="nav nav-treeview">


                <li class="nav-item">
                  <a href="/resources/Supply/equipment-view-inital-issue.php" class="nav-link <?php active('equipment-view-inital-issue.php');?>">
                    <i class="bi bi-cloud-plus"></i>
                    <p>Equipment Issue</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="/resources/Supply/equipment-view-supply-levels.php" class="nav-link <?php active('equipment-view-supply-levels.php');?>">
                    <i class="bi bi-receipt"></i>
                    <p>Receive Equipment</p>
                  </a>
                </li>


                <li class="nav-item">
                  <a href="#" class="nav-link <?php active('#');?>">
                    <i class="bi bi-trash"></i>
                    <p>Destroy Equipment</p>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
          <div class="user-panel">

          </nav>
          <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->


      </aside>
