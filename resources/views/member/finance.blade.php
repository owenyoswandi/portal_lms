@extends('layouts.user.base')

@section('title', 'Finance')
    <style>
      
    </style>

@section('content')
<div class="pagetitle">
      <h1>Finance</h1>
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
        <div class="col-lg-3">
            
        </div>
        <div class="col-lg-6">

          <div class="card">
            <div class="card-body">
                <center>
                    <h6 class="card-title">TOTAL BALANCE</h6>
                    <h5 id="balance"></h5>
                <center>
            </div>
          </div>

        </div>
        <div class="col-lg-3">
            
        </div>

      </div>
      <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-3">
                    <table class="table table-striped table-hover" id='mytable'>
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Credit</th>
                        <th>Debit</th>
                        <th>Balance</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
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
            axios.get(apiUrl + '/transaction-byuserid/' + userId, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        console.log(data.data);
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
            var balance = 0;
			const tableBody = document.querySelector('.table tbody');
			tableBody.innerHTML = '';
			userData.forEach((data, index) => {
                let amount = Number(data.t_amount).toLocaleString();

				const row = document.createElement('tr');
				row.innerHTML = `
                    <td style='text-align: left'>${data.t_created_date}</td>
					
				`;
                if(data.t_code == '101'){
                    row.innerHTML += `
                        <td style='text-align: left'>${data.name}</td>
                        <td style='text-align: left'>IDR ${amount}</td>
                        <td style='text-align: left'> - </td>
                    `;
                    balance = balance + data.t_amount;
                } else {
                    row.innerHTML += `
                        <td style='text-align: left'>${data.name} ${data.t_p_id}</td>
                        <td style='text-align: left'> - </td>
                        <td style='text-align: left'>IDR ${amount}</td>
                    `;
                    balance = balance - data.t_amount;
                }
                let amount_balance = Number(balance).toLocaleString();
                row.innerHTML += `
                    <td style='text-align: left'>IDR ${amount_balance}</td>
				`;
				tableBody.appendChild(row);
			});
            let amount_balance = Number(balance).toLocaleString();
            document.getElementById('balance').innerHTML = "IDR " + amount_balance;
		}
        
    </script>
@endsection 