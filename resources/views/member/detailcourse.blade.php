@extends('dist.layout_member') 

@section('title')
    {{env('APP_NAME')}} | My Course
@endsection

@section('css')
    <style>
      .profile .profile-overview .row {
        margin-bottom: 10px;
        font-size: 15px;
      }
    </style>
@endsection

@section('menu')
@include('dist.menu_member') 
@endsection 

@section('content')
    <div class="pagetitle">
      <h1>My Course</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">My Course</a></li>
          <li class="breadcrumb-item">View Data</li>
          <li class="breadcrumb-item active">Course Detail</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card profile">
            <div class="card-body">
                <h5 class="card-title">Course Detail</h5>
                <div class="profile-overview" id="course">
                
                </div>
            </div>    
          </div>
        </div>
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Course Progress</h5>
              <!-- <p>Berikut merupakan data News.</p> -->
			  
			        <!-- Table with stripped rows -->
              <table class="table " id='mytable'>
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Modul</th>
                    <th>Pretest</th>
                    <th>Posttest</th>
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
		const apiUrl = '{{ config('app.api_url') }}';
    var get_main_id = `{{ $p_id }}`;
    const accessMember = '{{ session('usermember') }}';
		const accessToken = '{{ session('token') }}';
    const userId = '{{ session('userid') }}';

		window.onload = function() {
      getCourse();
      // getBalance();
		};

    function getCourse(){
      axios.get(apiUrl + '/product-byid/' + get_main_id, {
          headers: {
              'Authorization': `Bearer ${accessToken}`
          }
      })
      .then(response => {
          const data = response.data;
          if (data.success) {
              console.log(data.data);
              datacourse(data.data);
              dataModul(data.data.p_id_lms);
          } else {
              console.error(data.message);
          }
      })
      .catch(error => {
          console.error('Error:', error);
      });
    }

    function datacourse(data){
      html = '';
      let text = Number(data.p_harga).toLocaleString();
      html = `
        <div class="row">
          <div class="col-lg-2 col-md-4 label ">Title</div>
          <div class="col-lg-10 col-md-8" id="title">${data.p_judul}</div>
        </div>

        <div class="row">
          <div class="col-lg-2 col-md-4 label">Description</div>
          <div class="col-lg-10 col-md-8" id="desk">${data.p_deskripsi}</div>
        </div>

        <div class="row">
          <div class="col-lg-2 col-md-4 label">Price</div>
          <div class="col-lg-10 col-md-8" id="desk">IDR ${text}</div>
        </div>

        <div class="row">
          <div class="col-lg-2 col-md-4 label">Course Date</div>
          <div class="col-lg-10 col-md-8" id="desk">${data.p_start_date} to ${data.p_end_date}</div>
        </div>
      `;
      document.getElementById('course').innerHTML = html;
    }

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
    
		function updateTable(userData) {
			const tableBody = document.querySelector('.table tbody');
			tableBody.innerHTML = '';

			userData.forEach((data, index) => {
        console.log(data);
        const modul = data.modules;
        modul.forEach((mdl, index)=>{
          const row = document.createElement('tr');
          row.innerHTML = `
            <td style='text-align: left'>${index + 1}</td>
            <td style='text-align: left'>${mdl.title}</td>
            <td style='text-align: left'>${mdl.pretest_score == null ? '-' : mdl.pretest_score}</td>
            <td style='text-align: left'>${mdl.posttest_score == null ? '-' : mdl.posttest_score}</td>
          `;
          tableBody.appendChild(row);
        });
				
			});
			const dataTable = new simpleDatatables.DataTable('#mytable');
		}

    function dataModul(id) {
      return axios.get(`https://ems.ai4talent.my.id/api/course/${id}/${accessMember}/progress`, {
            headers: {
                'Authorization': `Bearer ${accessToken}`
            }
          }).then(response => {
            updateTable(response.data.data);
          })
          .catch(error => {
              console.error('Error:', error);
          });
      }
    
	</script>