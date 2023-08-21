@extends('admin.template.dashboard')
@section('container')
<div class="section-header">
  <h1>Dashboard</h1>
</div>
<div class="row">
  <div class="col-xl-3 col-lg-6">
    <div class="card">
      <div class="card-body card-type-3">
        <div class="row">
          <div class="col">
            <h6 class="text-muted mb-0">Orders</h6>
            <span class="fw-bold mb-0">450</span>
          </div>
          <div class="col-auto">
            <div class="card-circle l-bg-orange text-white">
              <i class="fas fa-book-open"></i>
            </div>
          </div>
        </div>
        <p class="mt-3 mb-0 text-muted text-sm">
          <span class="text-success me-2"><i class="fa fa-arrow-up"></i> 10%</span>
          <span class="text-nowrap">Since last month</span>
        </p>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-6">
    <div class="card">
      <div class="card-body card-type-3">
        <div class="row">
          <div class="col">
            <h6 class="text-muted mb-0">New Booking</h6>
            <span class="fw-bold mb-0">1,562</span>
          </div>
          <div class="col-auto">
            <div class="card-circle l-bg-cyan text-white">
              <i class="fas fa-briefcase"></i>
            </div>
          </div>
        </div>
        <p class="mt-3 mb-0 text-muted text-sm">
          <span class="text-success me-2"><i class="fa fa-arrow-up"></i> 7.8%</span>
          <span class="text-nowrap">Since last month</span>
        </p>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-6">
    <div class="card">
      <div class="card-body card-type-3">
        <div class="row">
          <div class="col">
            <h6 class="text-muted mb-0">Inquiry</h6>
            <span class="fw-bold mb-0">7,897</span>
          </div>
          <div class="col-auto">
            <div class="card-circle l-bg-green text-white">
              <i class="fas fa-phone"></i>
            </div>
          </div>
        </div>
        <p class="mt-3 mb-0 text-muted text-sm">
          <span class="text-success me-2"><i class="fa fa-arrow-up"></i> 15%</span>
          <span class="text-nowrap">Since last month</span>
        </p>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-6">
    <div class="card">
      <div class="card-body card-type-3">
        <div class="row">
          <div class="col">
            <h6 class="text-muted mb-0">Earning</h6>
            <span class="fw-bold mb-0">$8,965</span>
          </div>
          <div class="col-auto">
            <div class="card-circle l-bg-purple text-white">
              <i class="fas fa-dollar-sign"></i>
            </div>
          </div>
        </div>
        <p class="mt-3 mb-0 text-muted text-sm">
          <span class="text-success me-2"><i class="fa fa-arrow-up"></i> 5.4%</span>
          <span class="text-nowrap">Since last month</span>
        </p>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h4>Revenue Chart</h4>
      </div>
      <div class="card-body">
        <canvas id="chart-1"></canvas>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h4>Revenue Chart</h4>
      </div>
      <div class="card-body">
        <canvas id="myChart"></canvas>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-12 col-sm-12 col-lg-12">
    <div class="card">
      <div class="card-header">
        <h4>Project Details</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive table-invoice">
          <table class="table">
            <tr>
              <th>Project</th>
              <th>Customer</th>
              <th>Team</th>
              <th>Status</th>
              <th>Start Date</th>
              <th>Delivery Date</th>
              <th>Action</th>
            </tr>
            <tr>
              <td><a href="#">Project 1</a></td>
              <td class="font-weight-600">Sarah Smith</td>
              <td class="text-truncate">
                <ul class="list-unstyled order-list m-b-0 m-b-0">
                  <li class="team-member team-member-sm">
                    <img class="rounded-circle" src="/assets/img/users/user-8.png" alt="user" data-bs-toggle="tooltip" title="" data-original-title="Wildan Ahdian">
                  </li>
                  <li class="team-member team-member-sm">
                    <img class="rounded-circle" src="/assets/img/users/user-9.png" alt="user" data-bs-toggle="tooltip" title="" data-original-title="John Deo">
                  </li>
                  <li class="team-member team-member-sm">
                    <img class="rounded-circle" src="/assets/img/users/user-10.png" alt="user" data-bs-toggle="tooltip" title="" data-original-title="Sarah Smith">
                  </li>
                  <li class="avatar avatar-sm">
                    <span class="badge badge-primary">+4</span>
                  </li>
                </ul>
              </td>
              <td>
                <div class="badge btn-warning">In Progress</div>
              </td>
              <td>July 19, 2018</td>
              <td>March 25, 2019</td>
              <td>
                <a href="#" class="btn btn-primary">Detail</a>
              </td>
            </tr>
            <tr>
              <td><a href="#">Project 2</a></td>
              <td class="font-weight-600">Airi Satou</td>
              <td class="text-truncate">
                <ul class="list-unstyled order-list m-b-0 m-b-0">
                  <li class="team-member team-member-sm">
                    <img class="rounded-circle" src="/assets/img/users/user-3.png" alt="user" data-bs-toggle="tooltip" title="" data-original-title="Wildan Ahdian">
                  </li>
                  <li class="team-member team-member-sm">
                    <img class="rounded-circle" src="/assets/img/users/user-7.png" alt="user" data-bs-toggle="tooltip" title="" data-original-title="Sarah Smith">
                  </li>
                  <li class="avatar avatar-sm">
                    <span class="badge badge-primary">+2</span>
                  </li>
                </ul>
              </td>
              <td>
                <div class="badge badge-success">Completed</div>
              </td>
              <td>March 21, 2015</td>
              <td>July 22, 2017</td>
              <td>
                <a href="#" class="btn btn-primary">Detail</a>
              </td>
            </tr>
            <tr>
              <td><a href="#">Project 3</a></td>
              <td class="font-weight-600">Ashton Cox</td>
              <td class="text-truncate">
                <ul class="list-unstyled order-list m-b-0 m-b-0">
                  <li class="team-member team-member-sm">
                    <img class="rounded-circle" src="/assets/img/users/user-1.png" alt="user" data-bs-toggle="tooltip" title="" data-original-title="Wildan Ahdian">
                  </li>
                  <li class="team-member team-member-sm">
                    <img class="rounded-circle" src="/assets/img/users/user-5.png" alt="user" data-bs-toggle="tooltip" title="" data-original-title="John Deo">
                  </li>
                  <li class="team-member team-member-sm">
                    <img class="rounded-circle" src="/assets/img/users/user-9.png" alt="user" data-bs-toggle="tooltip" title="" data-original-title="Sarah Smith">
                  </li>
                  <li class="avatar avatar-sm">
                    <span class="badge badge-primary">+5</span>
                  </li>
                </ul>
              </td>
              <td>
                <div class="badge badge-danger">cancelled</div>
              </td>
              <td>January 02, 2018</td>
              <td>March 12, 2019</td>
              <td>
                <a href="#" class="btn btn-primary">Detail</a>
              </td>
            </tr>
            <tr>
              <td><a href="#">Project 4</a></td>
              <td class="font-weight-600">Cara Stevens</td>
              <td class="text-truncate">
                <ul class="list-unstyled order-list m-b-0">
                  <li class="team-member team-member-sm">
                    <img class="rounded-circle" src="/assets/img/users/user-4.png" alt="user" data-bs-toggle="tooltip" title="" data-original-title="Wildan Ahdian">
                  </li>
                  <li class="team-member team-member-sm">
                    <img class="rounded-circle" src="/assets/img/users/user-7.png" alt="user" data-bs-toggle="tooltip" title="" data-original-title="John Deo">
                  </li>
                  <li class="team-member team-member-sm">
                    <img class="rounded-circle" src="/assets/img/users/user-10.png" alt="user" data-bs-toggle="tooltip" title="" data-original-title="John Deo">
                  </li>
                  <li class="team-member team-member-sm">
                    <img class="rounded-circle" src="/assets/img/users/user-2.png" alt="user" data-bs-toggle="tooltip" title="" data-original-title="Sarah Smith">
                  </li>
                  <li class="avatar avatar-sm">
                    <span class="badge badge-primary">+1</span>
                  </li>
                </ul>
              </td>
              <td>
                <div class="badge btn-warning">In Progress</div>
              </td>
              <td>July 19, 2018</td>
              <td>March 25, 2019</td>
              <td>
                <a href="#" class="btn btn-primary">Detail</a>
              </td>
            </tr>
            <tr>
              <td><a href="#">Project 5</a></td>
              <td class="font-weight-600">John Doe</td>
              <td class="text-truncate">
                <ul class="list-unstyled order-list m-b-0">
                  <li class="team-member team-member-sm">
                    <img class="rounded-circle" src="/assets/img/users/user-8.png" alt="user" data-bs-toggle="tooltip" title="" data-original-title="Wildan Ahdian">
                  </li>
                  <li class="team-member team-member-sm">
                    <img class="rounded-circle" src="/assets/img/users/user-4.png" alt="user" data-bs-toggle="tooltip" title="" data-original-title="John Deo">
                  </li>
                  <li class="team-member team-member-sm">
                    <img class="rounded-circle" src="/assets/img/users/user-3.png" alt="user" data-bs-toggle="tooltip" title="" data-original-title="Sarah Smith">
                  </li>
                  <li class="avatar avatar-sm">
                    <span class="badge badge-primary">+2</span>
                  </li>
                </ul>
              </td>
              <td>
                <div class="badge badge-success">Completed</div>
              </td>
              <td>May 11, 2017</td>
              <td>March 15, 2018</td>
              <td>
                <a href="#" class="btn btn-primary">Detail</a>
              </td>
            </tr>
            <tr>
              <td><a href="#">Project 6</a></td>
              <td class="font-weight-600">Angelica Ramos</td>
              <td class="text-truncate">
                <ul class="list-unstyled order-list m-b-0">
                  <li class="team-member team-member-sm">
                    <img class="rounded-circle" src="/assets/img/users/user-3.png" alt="user" data-bs-toggle="tooltip" title="" data-original-title="Wildan Ahdian">
                  </li>
                  <li class="team-member team-member-sm">
                    <img class="rounded-circle" src="/assets/img/users/user-1.png" alt="user" data-bs-toggle="tooltip" title="" data-original-title="Sarah Smith">
                  </li>
                  <li class="avatar avatar-sm">
                    <span class="badge badge-primary">+2</span>
                  </li>
                </ul>
              </td>
              <td>
                <div class="badge badge-danger">cancelled</div>
              </td>
              <td>November 02, 2018</td>
              <td>April 05, 2019</td>
              <td>
                <a href="#" class="btn btn-primary">Detail</a>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-4">
    <div class="card">
      <div class="card-header">
        <h4>Earning Details</h4>
      </div>
      <div class="card-body">
        <h4 class="header-title">Earning Reports</h4>
        <p class="text-muted">1 Mar - 31 Mar Data</p>
        <h2 class="mb-3"><i class="mdi mdi-currency-usd text-primary"></i>$1,65,203</h2>
        <div class="row mb-1">
          <div class="col-6">
            <p class="text-muted mb-1">This Month</p>
            <h3 class="mt-0 font-20">$117,968
            </h3>
          </div>
          <div class="col-6">
            <p class="text-muted mb-1">Last Month</p>
            <h3 class="mt-0 font-20">$74,568
            </h3>
          </div>
        </div>
        <div class="mt-1">
          <div class="recent-report__chart">
            <div id="chart2"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-8 col-md-12 col-12 col-sm-12">
    <div class="card">
      <div class="card-header">
        <h4>Task Details</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table">
            <tr>
              <th class="text-center">
                <div class="custom-checkbox custom-checkbox-table custom-control">
                  <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all">
                  <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                </div>
              </th>
              <th>Task Name</th>
              <th>Progress</th>
              <th>Due Date</th>
              <th>Action</th>
            </tr>
            <tr>
              <td class="p-0 text-center">
                <div class="custom-checkbox custom-control">
                  <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-1">
                  <label for="checkbox-1" class="custom-control-label">&nbsp;</label>
                </div>
              </td>
              <td>Ecommerce website</td>
              <td class="align-middle">
                <div class="progress" data-height="4" data-bs-toggle="tooltip" title="100%">
                  <div class="progress-bar bg-success" data-width="100"></div>
                </div>
              </td>
              <td>2018-01-20</td>
              <td>
                <a class="btn btn-primary btn-action me-1" data-bs-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                <a class="btn btn-danger btn-action" data-bs-toggle="tooltip" title="Delete" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="alert('Deleted')"><i class="fas fa-trash"></i></a>
              </td>
            </tr>
            <tr>
              <td class="p-0 text-center">
                <div class="custom-checkbox custom-control">
                  <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-4">
                  <label for="checkbox-4" class="custom-control-label">&nbsp;</label>
                </div>
              </td>
              <td>Android App</td>
              <td class="align-middle">
                <div class="progress" data-height="4" data-bs-toggle="tooltip" title="30%">
                  <div class="progress-bar bg-orange" data-width="30"></div>
                </div>
              </td>
              <td>2018-09-11</td>
              <td>
                <a class="btn btn-primary btn-action me-1" data-bs-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                <a class="btn btn-danger btn-action" data-bs-toggle="tooltip" title="Delete" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="alert('Deleted')"><i class="fas fa-trash"></i></a>
              </td>
            </tr>
            <tr>
              <td class="p-0 text-center">
                <div class="custom-checkbox custom-control">
                  <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-5">
                  <label for="checkbox-5" class="custom-control-label">&nbsp;</label>
                </div>
              </td>
              <td>Logo Design</td>
              <td class="align-middle">
                <div class="progress" data-height="4" data-bs-toggle="tooltip" title="67%">
                  <div class="progress-bar bg-purple" data-width="67"></div>
                </div>
              </td>
              <td>2018-04-12</td>
              <td>
                <a class="btn btn-primary btn-action me-1" data-bs-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                <a class="btn btn-danger btn-action" data-bs-toggle="tooltip" title="Delete" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="alert('Deleted')"><i class="fas fa-trash"></i></a>
              </td>
            </tr>
            <tr>
              <td class="p-0 text-center">
                <div class="custom-checkbox custom-control">
                  <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-6">
                  <label for="checkbox-6" class="custom-control-label">&nbsp;</label>
                </div>
              </td>
              <td>Java Project</td>
              <td class="align-middle">
                <div class="progress" data-height="4" data-bs-toggle="tooltip" title="43%">
                  <div class="progress-bar bg-success" data-width="43"></div>
                </div>
              </td>
              <td>2018-01-20</td>
              <td>
                <a class="btn btn-primary btn-action me-1" data-bs-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                <a class="btn btn-danger btn-action" data-bs-toggle="tooltip" title="Delete" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="alert('Deleted')"><i class="fas fa-trash"></i></a>
              </td>
            </tr>
            <tr>
              <td class="p-0 text-center">
                <div class="custom-checkbox custom-control">
                  <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-4">
                  <label for="checkbox-4" class="custom-control-label">&nbsp;</label>
                </div>
              </td>
              <td>Android App</td>
              <td class="align-middle">
                <div class="progress" data-height="4" data-bs-toggle="tooltip" title="30%">
                  <div class="progress-bar bg-orange" data-width="30"></div>
                </div>
              </td>
              <td>2018-09-11</td>
              <td>
                <a class="btn btn-primary btn-action me-1" data-bs-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                <a class="btn btn-danger btn-action" data-bs-toggle="tooltip" title="Delete" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="alert('Deleted')"><i class="fas fa-trash"></i></a>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection