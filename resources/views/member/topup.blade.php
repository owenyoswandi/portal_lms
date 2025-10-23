@extends('layouts.user.base')

@section('title', 'Top Up')
    <style>
      .modal-body p, #last_topup p {
        margin-top: 0px;
        margin-bottom: 0px;
        font-size: 15px;
      }

      .class-button {
        margin-top: 10px;
      }

      .p-topup {
        margin-top: -10px;
      }

    </style> 

@section('content')
<div class="pagetitle">
      <h1>Top Up</h1>
      <!-- <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Pages</li>
          <li class="breadcrumb-item active">Blank</li>
        </ol>
      </nav> -->
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-6">

          <div class="card">
            <div class="card-body">
              <h6 class="card-title">How much do you want to top up?</h6>
              <form class="row g-3 needs-validation" id="topUpForm" enctype="multipart/form-data" novalidate>
                @csrf
                    <div class="col-9">
                        <input type="number" name="amount_topup" class="form-control" id="amount_topup" required>
                    </div>
                    <div class="col-3">
                        <button type="button" class="btn btn-primary" onclick="topup()">Submit</button>
                    </div>
                </form>
            </div>
          </div>

        </div>
        <div class="col-lg-6">
            <div id="last_topup">
            </div>
        </div>

      </div>
      <!-- MODAL TOP UP -->
      <div class="modal fade" id="topUpConfirmationModal" tabindex="-1" aria-labelledby="topUpConfirmationModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="topUpConfirmationModalLabel">Top Up Information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <b><p>Admin Bank Account Details</p></b>
                        <p>Please transfer the following amount to the provider bank account</p>
                        <p>Bank : Admin Bank Name</p>
                        <p>Account Number : Admin Account Number</p>
                        <p>Account Name : Admin Account Name</p>
                        <p id="amnt"></p>
						<input type="text" name="amount" id="amount" hidden>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-secondary" onclick="sendData()">Send</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="topUpProofModal" tabindex="-1" aria-labelledby="topUpProofModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="topUpProofModalLabel">Top Up Information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form class="row g-3 needs-validation" id="confirmForm" enctype="multipart/form-data" novalidate>
                        <b><p>Admin Bank Account Details</p></b>
                        <p>Please transfer the following amount to the provider bank account</p>
                        <p>Bank : Admin Bank Name</p>
                        <p>Account Number : Admin Account Number</p>
                        <p>Account Name : Admin Account Name</p>
                        <p id="amnt_confirm"></p>
                        <br><br>
                        <p>After transfering the amount upload the transaction receipt and click Confirmation button below:</p>
						<input type="text" name="amount_confirm" id="amount_confirm" hidden>
                        <input type="text" name="t_id" id="t_id" hidden>
                        <div class="col-12">
                            <label for="t_user_proof" class="form-label">Upload the Transaction Receipt</label>
                            <input type="file" name="t_user_proof" class="form-control" id="t_user_proof" required>
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

        
      <!-- Delete Confirmation Modal -->
      <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteConfirmationModalLabel">Cancel Top Up</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to cancel this top up?</p>
						<input type="text" name="t_id_delete" id="t_id_delete">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">NO</button>
                        <button type="button" class="btn btn-danger" onclick="deleteData()">YES</button>
                    </div>
                </div>
            </div>
        </div>
	  
    </section>
    
@endsection 

@section('java_script')
	<!-- silahkan isi dengan java script -->
	<script>
        const apiUrl = '{{ config('app.api_url') }}';
        const userId = '{{ session('userid') }}';
		const accessToken = '{{ session('token') }}';

        window.onload = function() {
            getDataTopUp();
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

        function getDataTopUp() {
            axios.get(apiUrl + '/transaction-topup-byuserid/' + userId, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        dataLastTopup(data.data);
                        console.log(data.data);
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function dataLastTopup(userData) {
            if(userData.t_status == 'unpaid' || userData.t_status == 'waiting confirmation'){
                card = `<div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div
                            <h6 class="card-title">Last Top Up </h6>
                        </div>
                        `;
                let text = Number(userData.t_amount).toLocaleString();
                if(userData.t_status == "unpaid"){
                    card += `<div class="class-button">
                            <button type="button" class="btn btn-danger" onclick="cancel(${userData.t_id})">Cancel</button>
                            <button type="button" class="btn btn-primary" onclick="confirmTopUp(${userData.t_id})">Confirm</button></div>
                        </div>
                        <div class="p-topup"><p>Top Up at : ${userData.t_created_date}</p>
                        <p>Amount : IDR ${text} <span class="badge rounded-pill bg-danger">${userData.t_status}</span>`;
                } else {
                    card += `</div><div class="p-topup"><p>Top Up at : ${userData.t_created_date}</p>
                        <p>Amount : IDR ${text} <span class="badge rounded-pill bg-warning">${userData.t_status}</span>`;
                }
                card += `</p></div>
                </div>
                </div>`;
                document.getElementById('last_topup').innerHTML = card;
            }
		}

        function topup() {
            let amount = document.getElementById('amount_topup').value;
            const topUpConfirmationModal = new bootstrap.Modal(document.getElementById('topUpConfirmationModal'));
            topUpConfirmationModal.show();

            let text = Number(amount).toLocaleString();

            document.getElementById('amnt').innerHTML = "Amount : IDR " + text;
            document.getElementById('amount').value = amount;
        }

        function sendData() {
            const userData = {};

            // userData['t_transaction_id'] = "TRANS123";
            userData['t_code'] = "101";
            userData['t_user_id'] = userId;
            userData['t_type'] = "inflow";
            userData['t_amount'] = document.getElementById('amount').value;
            userData['t_status'] = "unpaid";
			console.log(userData);

            axios.post(apiUrl + '/transaction/create-topup', userData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        console.log('Data added successfully.');
                        var myModalEl = document.getElementById('topUpConfirmationModal');
                        var modal = bootstrap.Modal.getInstance(myModalEl)
                        modal.hide();
                        getDataTopUp();
                    } else {
                        var myModalEl = document.getElementById('topUpConfirmationModal');
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

            let text = Number(amount).toLocaleString();

            document.getElementById('amnt_confirm').innerHTML = "Amount : IDR " + text;
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
            userData['t_status'] = "waiting confirmation";
			console.log(userData);

            axios.post(apiUrl + '/transaction/confirm-topup', userData, {
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
                        getDataTopUp();
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

        function cancel(id) {
            document.getElementById('t_id_delete').value = id;
            const deleteConfirmationModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
            deleteConfirmationModal.show();
        }

        function deleteData() {
            const id = document.getElementById('t_id_delete').value;
            axios.delete(apiUrl + '/transaction/delete', {
                    data: {
                        t_id: id
                    },
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        var myModalEl = document.getElementById('deleteConfirmationModal');
                        var modal = bootstrap.Modal.getInstance(myModalEl)
                        modal.hide();
                        
                    } else {
                        console.error(data.message);
                    }
                    getDataTopUp();
                })
                .catch(error => {
                    console.error('Error:', error);
                });

        }
    </script>
@endsection 