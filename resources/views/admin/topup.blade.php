@extends('layouts.user.base')

@section('title', 'Manage Order - Top Up')

@section('content')
    <div class="pagetitle">
      <h1>Top Up</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Top Up</a></li>
          <li class="breadcrumb-item">View Data</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <!-- <p>Berikut merupakan data Comment.</p> -->
			  
			  <!-- Table with stripped rows -->
              <table class="table " id='mytable'>
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Transfer Receipt</th>
                    <th>Admin Receipt</th>
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

      <div class="modal fade" id="topUpProofModal" tabindex="-1" aria-labelledby="topUpProofModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="topUpProofModalLabel">Upload the Transaction Receipt</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form class="row g-3 needs-validation" id="confirmForm" enctype="multipart/form-data" novalidate>
						<input type="text" name="amount_confirm" id="amount_confirm" hidden>
                        <input type="text" name="t_id" id="t_id" hidden>
                        <div class="col-12">
                            <label for="t_admin_proof" class="form-label">User Transaction Receipt</label>
                            <br>
                            <img id="userproof" style="width: 50%"/>
                            <!--<div class="invalid-feedback">Please enter the username!</div>-->
                        </div>
                        <div class="col-12">
                            <label for="t_admin_proof" class="form-label">Upload the Transaction Receipt</label>
                            <input type="file" name="t_admin_proof" class="form-control" id="t_admin_proof" required>
                            <!--<div class="invalid-feedback">Please enter the username!</div>-->
                        </div>
                    </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="confirm()">Confirmation</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection 

@section('java_script')
	<!-- silahkan isi dengan java script -->
	<script>
		window.onload = function() {
			getData();
		};
		const apiUrl = '{{ config('app.api_url') }}';
		const accessToken = '{{ session('token') }}';

		function getData() {
			axios.get(apiUrl + '/transaction-topUp', {
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
                let text = Number(data.t_amount).toLocaleString();

				const row = document.createElement('tr');
				row.innerHTML = `
					<td style='text-align: left'>${index + 1}</td>
                    <td style='text-align: left'>${data.nama}</td>
                    <td style='text-align: left'>${data.t_created_date}</td>
                    <td style='text-align: left'>IDR ${text}</td>`;
                    // <td style='text-align: left'><img src="{{asset('public/user_proof/${data.t_user_proof}')}}" style="width: 100%"/></td>
                    // <td style='text-align: left'><img src="{{asset('public/admin_proof/${data.t_admin_proof}')}}" style="width: 100%"/></td>
                if(data.t_status == 'unpaid'){
                    row.innerHTML += `<td style='text-align: left'><span class="badge rounded-pill bg-danger">unpaid</span></td>
                    <td style='text-align: left'> - </td>
                    <td style='text-align: left'> - </td>
					<td> - </td>`;
                } else if (data.t_status == 'waiting confirmation') {
                    row.innerHTML += `<td style='text-align: left'><span class="badge rounded-pill bg-warning">waiting confirmation</span></td>
                    <td style='text-align: left'><a class="btn btn-sm btn-secondary" href="{{ url('/admin/downloadFile/user_proof/${data.t_user_proof}')}}"><i class="bx bxs-download"></i></a></td>
                    <td style='text-align: left'> - </td>
					<td><button class="btn btn-primary" onclick="confirmTopUp('${data.t_id}')">Validate</button>
					</td>`;
                } else {
                    row.innerHTML += `<td style='text-align: left'><span class="badge rounded-pill bg-success">paid</span></td>
                    <td style='text-align: center'><a class="btn btn-sm btn-secondary" href="{{ url('/admin/downloadFile/user_proof/${data.t_user_proof}')}}"><i class="bx bxs-download"></i></a></td>
                    <td style='text-align: center'><a class="btn btn-sm btn-secondary" href="{{ url('/admin/downloadFile/admin_proof/${data.t_admin_proof}')}}"><i class="bx bxs-download"></i></a></td>
					<td> - </td>`;
                }
                row.innerHTML += ` 
						
				`;
				tableBody.appendChild(row);
			});
			const dataTable = new simpleDatatables.DataTable('#mytable');
		}
		
		
		function confirmTopUp(id) {
            axios.get(apiUrl + '/transaction-topup-byid/' + id, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        confirmData(data.data);
                        console.log(data.data);
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function confirmData(userData) {
            let amount = userData.t_amount;
            const topUpConfirmationModal = new bootstrap.Modal(document.getElementById('topUpProofModal'));
            topUpConfirmationModal.show();

            let src = `{{asset('public/user_proof/${userData.t_user_proof}')}}`;
            document.getElementById("userproof").src = src;

            document.getElementById('amount_confirm').value = amount;
            document.getElementById('t_id').value = userData.t_id;
        }

        function confirm() {
            const form = document.getElementById('confirmForm');
            const formData = new FormData(form);

            const userData = {};
            formData.forEach((value, key) => {
                userData[key] = value;
            });

            var currentdate = new Date(); 
			var datetime = currentdate.getFullYear() + "-"
                + (currentdate.getMonth()+1)  + "-" 
                + currentdate.getDate() + " "  
                + currentdate.getHours() + ":"  
                + currentdate.getMinutes() + ":" 
                + currentdate.getSeconds();
                
            userData['t_modified_date'] = datetime;
            userData['t_status'] = "paid";
			console.log(userData);

            axios.post(apiUrl + '/transaction/validate-topup', userData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        console.log('Data added successfully.');
                        var myModalEl = document.getElementById('topUpProofModal');
                        var modal = bootstrap.Modal.getInstance(myModalEl)
                        modal.hide();
                        getData();
                    } else {
                        var myModalEl = document.getElementById('topUpProofModal');
                        var modal = bootstrap.Modal.getInstance(myModalEl)
                        modal.hide();

                        alert('Silahkan Lakukan Konfirmasi Top Up Sebelumnya');
                        // console.error('Adding data failed:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
	</script>
@endsection 