@extends('layouts.user.base')

@section('title', 'Order')

@section('content')
    <div class="pagetitle">
      <h1>Order Course</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Order Course</a></li>
          <li class="breadcrumb-item">View Data</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div id="course">

          </div>
        </div>
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title" id="title"></h5>
              <!-- <p>Berikut merupakan data News.</p> -->

			        <!-- Table with stripped rows -->
              <table class="table " id='mytable'>
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Course</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
              <!-- End Table with stripped rows -->
            </div>
          </div>

        </div>

      </div>
    </section>
@endsection

	<!-- silahkan isi dengan java script -->
	<script>
  const apiUrl = window.apiUrl || '{{ config('app.api_url') }}';
		const accessToken = '{{ session('token') }}';
    const accessMember = '{{ session('usermember') }}';
    const userId = '{{ session('userid') }}';

		window.onload = function() {
			getData();
      // getBalance();
		};

    function getBalance(){
        axios.get(apiUrl + '/transaction-balance-byuserid/' + userId, {
            headers: {
                'Authorization': `Bearer ${accessToken}`
            }
        })
        .then(response => {
            const data = response.data;
            if (data.success) {
                console.log(data.data);
                let amount_balance = Number(data.data).toLocaleString();
                document.getElementById('balance_all').innerHTML = "IDR " + amount_balance;
            } else {
                console.error(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

		function getData() {
			axios.get(apiUrl + '/transaction-course-byuserid/' + userId, {
					headers: {
						'Authorization': `Bearer ${accessToken}`
					}
				})
				.then(response => {
					const data = response.data;
					if (data.success) {
						updateTable(data.data);
					} else {
						console.error(data.message);
					}
				})
				.catch(error => {
					console.error('Error:', error);
				});
		}

		function updateTable(userData) {
			const tableBody = document.querySelector('.table tbody');
			tableBody.innerHTML = '';

			userData.forEach((data, index) => {
                var tbl = ''
				const row = document.createElement('tr');
				tbl += `
					<td style='text-align: left'>${index + 1}</td>
          <td style='text-align: left'>${data.p_judul}</td>
					<td style='text-align: left'>${data.t_created_date}</td>
					<td style='text-align: left'>${data.t_status == 'paid' ? '<span class="badge rounded-pill bg-success">paid</span>' : '<span class="badge rounded-pill bg-danger">unpaid</span>'}</td>
					<td>`;
        if(data.t_status == 'paid'){
          tbl += `<a href="${data.p_url_lms}?token=${accessToken}" target="_blank" class="btn btn-sm btn-primary"><i class="bi bi-box-arrow-right"></i> Masuk EMS</a>`;
        } else {
          tbl += `-`;
        }
				tbl += `</td>`;
                row.innerHTML = tbl;
				tableBody.appendChild(row);
			});
			const dataTable = new simpleDatatables.DataTable('#mytable');
		}

		function getById(Id) {
            axios.get(apiUrl + `/order/${Id}`, {
					headers: {
						'Authorization': `Bearer ${accessToken}`
					}
				})
                .then(response => {
                    const data = response.data;
					console.log(data);
                    if (data.success) {
                        displayEditModal(data.data[0]);
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

	</script>
