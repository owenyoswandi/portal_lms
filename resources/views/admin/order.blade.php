@extends('layouts.user.base')

@section('title', 'Manage Order - Order')

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
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Order Course</h5>
              <!-- <p>Berikut merupakan data Order Course.</p> -->
			  
			  <!-- Table with stripped rows -->
              <table class="table " id='mytable'>
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Course Title</th>
                    <th>Price</th>
                    <th>Status</th>
					<!-- <th>Action</th> -->
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
              <!-- End Table with stripped rows -->
			  @include('component.admin.order_acc_modal')
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
			axios.get(apiUrl + '/transaction-course', {
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
                var tbl = ''
				const row = document.createElement('tr');
				tbl += `
					<td style='text-align: left'>${index + 1}</td>
                    <td style='text-align: left'>${data.nama}</td>
					<td style='text-align: left'>${data.p_judul}</td>
                    <td style='text-align: left'>IDR ${text}</td>
					<td style='text-align: left'>${data.t_status == 'paid' ? '<span class="badge rounded-pill bg-success">paid</span>' : '<span class="badge rounded-pill bg-danger">unpaid</span>'}</td>
					`;
                // if(data.status == 0){
                //     tbl += `<td><button class="btn btn-primary btn-sm" onclick="getById('${data.id}')">ACC</button>`;
                // }
				// tbl += `</td>`;
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
		
		function displayEditModal(userData) {
            const editModal = new bootstrap.Modal(document.getElementById('editOrderModal'));
            populateEditForm(userData);
            editModal.show();
        }
		
		function populateEditForm(userData) {
            document.getElementById('usermember_update').value = userData.usermember;
            document.getElementById('title_update').value = userData.title;
			document.getElementById('id_update').value = userData.id;
        }
		
		function edit() {
            const form = document.getElementById('editForm');
            const formData = new FormData(form);

            var currentdate = new Date(); 
			var datetime = currentdate.getFullYear() + "-"
                + (currentdate.getMonth()+1)  + "-" 
                + currentdate.getDate() + " "  
                + currentdate.getHours() + ":"  
                + currentdate.getMinutes() + ":" 
                + currentdate.getSeconds();

            const userData = {};
            formData.forEach((value, key) => {
                userData[key] = value;
            });
            userData['modidate'] = datetime;
            userData['status'] = 1;

            axios.put(apiUrl + `/order/update`, userData, {
					headers: {
						'Authorization': `Bearer ${accessToken}`
					}
				})
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        console.log('Data updated successfully.');
                        var myModalEl = document.getElementById('editOrderModal');
                        var modal = bootstrap.Modal.getInstance(myModalEl)
                        modal.hide();
                        getData();
                    } else {
                        console.error('Updating data failed:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
	</script>
@endsection 