@extends('layouts.user.base')

@section('title', 'Course')

    <style>
      .link {
        position: absolute;
        width: 100%;
        height: 80%;
        top: 0;
        left: 0;
        z-index: 1;
      }

      .card-body{
        padding-bottom: 5px;
      }

      #course .card:hover{
        transform: scale(1.05);
        box-shadow: 0 10px 20px rgba(0,0,0,.12), 0 4px 8px rgba(0,0,0,.06);
      }

      .card-title{
        min-height: 75px;
        margin-bottom: 0px;
        padding-bottom: 0px;
      }

      .card-img-top {
        height: 200px;
      }
    </style>

@section('content')
    <div class="pagetitle">
      <h1>My Course</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">My Course</a></li>
          <li class="breadcrumb-item">View Data</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="row" id="course">
            
          </div>
        </div>
        <div id="error">
          
        </div>
        <div class="pagetitle">
          <h1>Other Course</h1>
        </div><!-- End Page Title -->
        <div class="col-lg-12">
          <div class="row" id="other_course">
            
          </div>

        </div>

      </div>	  
      <div class="modal fade" id="addOrder" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Order Course</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" id="addForm" enctype="multipart/form-data" novalidate>
                @csrf             
                  <div class="col-12">
                    <label for="p_judul" class="form-label">Title</label>
                    <input type="text" name="p_judul" class="form-control" id="p_judul" readonly>
                    <!--<div class="invalid-feedback">Please enter the username!</div>-->
                  </div>
                  <div class="col-12">
                    <label for="p_deskripsi" class="form-label">Description</label>
                    <textarea id="p_deskripsi" class="form-control" name="p_deskripsi" readonly></textarea>
                    <!--<div class="invalid-feedback">Please enter the username!</div>-->
                  </div>
                  <input type="hidden" name="p_id" class="form-control" id="p_id">
                  <div class="col-12">
                    <label for="p_harga" class="form-label">Price</label>
                    <input type="text" name="p_harga_view" class="form-control" id="p_harga_view" readonly>
                    <input type="hidden" name="p_harga" class="form-control" id="p_harga" required>
                    <!--<div class="invalid-feedback">Please enter the username!</div>-->
                  </div>
                  <div class="col-12">
                    <label for="p_judul" class="form-label">Modules</label>
                      <!-- Default Accordion -->
                    <div class="accordion" id="accordionExample">
                      
                    </div><!-- End Default Accordion Example -->
                      <!--<div class="invalid-feedback">Please enter the username!</div>-->
                  </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="addOrder()">Order</button>
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
    const url = '{{ config('app.app_url') }}'
		const accessToken = '{{ session('token') }}';
    const userId = '{{ session('userid') }}';

		window.onload = function() {
      getByUserID();
      fetchDataOther();
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

    function getByUserID() {
      axios.get(apiUrl + `/transaction-course-byuserid/${userId}`, {
        headers: {
          'Authorization': `Bearer ${accessToken}`
        }
      })
      .then(response => {
          const data = response.data;
            if (data.success) {
              console.log(data.data);
              getCourse(data.data)
            } else {
              console.error(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    function getCourse(userData) {
      var card = '';
			userData.forEach((data, index) => {	      
        axios.get(apiUrl + `/transaction-course-byuserid/${data.user_id}` , {
          headers: {
            'Authorization': `Bearer ${accessToken}`
          }
        })
        .then(response => {
          var card = ''; 
          let html = document.getElementById("course").innerHTML;
          card += `<div class="col-sm-3">
                    <div class="card">`;
          if(data.p_img!=null&&data.p_img!=""){
            let link_img = url + `public/${data.p_img}`;
            console.log(url);
            card += `<img src="${link_img}" class="card-img-top" alt="...">`;
          }
          card += `<a href="{{ url('member/course/topic') }}/${data.p_id}"><span class="link"></span></a>
                <div class="card-body">
                  <h5 class="card-title">${data.p_judul}</h5>`;
          userData2 = response.data.data;
          console.log(userData2);
          if(userData2.length != 0){
            userData2.forEach((data2, index) => {
              card += `<p class="mb-1">Final Exam Score : </p>
                    </div>
                    <div class="card-footer">
                      <p class="mt-0 mb-1">Progress : </p>
                      <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: ${data2.progress_precentage}%" aria-valuenow="${data2.progress_precentage}" aria-valuemin="0" aria-valuemax="100"> %
                        </div>
                      </div>
                      <div class="d-flex justify-content-end">
                        <a href="{{ url('member/course/topic') }}/${data.p_id}" target="_blank" class="btn btn-sm btn-primary mt-3"><i class="bi bi-box-arrow-right"></i> Masuk Course</a>
                      </div>
                    </div>
                  </div>
                </div>
              `;
            });
          } else {
            card += `<p class="mb-1">Final Exam Score : - </p>
                  </div>
                  <div class="card-footer">
                    <p class="mt-0 mb-1">Progress : </p>
                    <div class="progress">
                      <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%
                      </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href="{{ url('member/course/topic') }}/${data.p_id}"" target="_blank" class="btn btn-sm btn-primary mt-3"><i class="bi bi-box-arrow-right"></i> Masuk Course</a>
                    </div>
                  </div>
                </div>
              </div>
            `;
          }
          
        card += `
                </div>
              </div>`;
        document.getElementById('course').innerHTML = html + card;
        })
        .catch(error => {
          console.error('Error:', error);
        });
      });
		}

    function fetchDataOther(){
        axios.get(apiUrl + '/product-byjenisstatusgroup/course/' + userId, {
					headers: {
						'Authorization': `Bearer ${accessToken}`
					}
				})
				.then(response => {
					const data = response.data;
					if (data.success) {
            console.log(data.data);
						dataOtherCourse(data.data);
					} else {
						console.error(data.message);
					}
				})
				.catch(error => {
					console.error('Error:', error);
				});
    }
    
    // card += ` <a href="${data.link}?token=${accessToken}" target="_blank" class="btn btn-sm btn-primary"><i class="bi bi-box-arrow-right"></i> Masuk EMS</a>`;

    function dataOtherCourse(userData) {
      if (!userData || !Array.isArray(userData)) return;

      let card = '';
      //hanya menampilkan course yang aktif
      userData.forEach((data) => {
        if (data.p_status == 1) {
          card += `
            <div class="col-sm-3">
              <div class="card">`;

          if (data.p_img != null && data.p_img !== "") {
            // Replace base path as needed if not using Laravel Blade here
            const imgSrc = url + `public/${data.p_img}`;
            card += `<img src="${imgSrc}" class="card-img-top" alt="...">`;
          }

          card += `
                <div class="card-body">
                  <h5 class="card-title">${data.p_judul}</h5>
                </div>
                <div class="card-footer">
                  <div class="d-flex justify-content-end">
                    <button class="btn btn-sm btn-success" onclick="getById('${data.p_id}', '${data.p_id_lms}', '${data.p_harga}')">
                      Order Course
                    </button>
                  </div>
                </div>
              </div>
            </div>
          `;
        }
      });

      document.getElementById('other_course').innerHTML = card;
    }


    function getById(p_id, idlms, harga) {
      var p_id = p_id;
      console.log(p_id);
      axios.get(apiUrl + `/product/${p_id}`, {
          headers: {
              "Content-Type": "multipart/form-data",
              'Authorization': `Bearer ${accessToken}`
          }
      })
      .then(response => {
        const data = response.data;
        console.log(data);
        orderConfirmation(data, p_id, harga);
      })
      .catch(error => {
          console.error('Error:', error);
      });
    }

    function orderConfirmation(data, id, harga) {
      let text = Number(harga).toLocaleString();
      document.getElementById('p_id').value = id;
      document.getElementById('p_judul').value = data.data.p_judul;
      document.getElementById('p_harga_view').value = "IDR "+text;
      document.getElementById('p_harga').value = harga;
      document.getElementById('p_deskripsi').value = data.data.p_deskripsi;
      
	  /*
	  const modul = data[0].modules;
	  
      var accordion ='';
      modul.forEach((mdl, index) => {
        accordion += `<div class="accordion-item">
                        <h2 class="accordion-header" id="heading${mdl.id}">
                          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${mdl.id}" aria-expanded="true" aria-controls="collapse${mdl.id}">
                            ${mdl.title}
                          </button>
                        </h2>
                        <div id="collapse${mdl.id}" class="accordion-collapse collapse" aria-labelledby="heading${mdl.id}" data-bs-parent="#accordionExample">
                          <div class="accordion-body">
                            <strong>${mdl.title}.</strong> ${mdl.description}
                          </div>
                        </div>
                      </div>`;
      })
	  */
      document.getElementById('accordionExample').innerHTML = '';//accordion;
      const orderConfirmationModal = new bootstrap.Modal(document.getElementById('addOrder'));
      orderConfirmationModal.show();
    }

    function add() {
      const form = document.getElementById('addForm');
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
      userData['p_jenis'] = "Course";
			console.log(userData);

      axios.post(apiUrl + '/product/create', userData, {
          headers: {
              "Content-Type": "multipart/form-data",
              'Authorization': `Bearer ${accessToken}`
          }
      })
      .then(response => {
          const data = response.data;
          if (data.success) {
            console.log(data);
              form.reset();
              addOrder(response.data.data);
          } else {
              console.error('Adding data failed:', data.message);
          }
      })
      .catch(error => {
          console.error('Error:', error);
      });
    }

    function addOrder() {
      const userData = {};
      userData['t_p_id'] = document.getElementById('p_id').value;
      userData['t_amount'] = document.getElementById('p_harga').value;
      userData['t_user_id'] = userId;
      userData['t_type'] = 'outflow';
      userData['t_status'] = 'paid';
      //userData['t_code'] = "102"; // buy course
			console.log(userData);

      axios.post(apiUrl + '/transaction/create-ordercourse', userData, {
          headers: {
              "Content-Type": "multipart/form-data",
              'Authorization': `Bearer ${accessToken}`
          }
      })
      .then(response => {
          const data = response.data;
          if (data.success) {
              console.log('Data added successfully.');
              var myModalEl = document.getElementById('addOrder');
              var modal = bootstrap.Modal.getInstance(myModalEl)
              modal.hide();
              
			  location.reload();
			  
			  //getByUserID();
              //fetchDataOther();
              //getBalance();
          } else {
              console.error('Adding data failed:', data.message);
              var error = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                ${data.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>`;
              document.getElementById('error').innerHTML = error;
              var myModalEl = document.getElementById('addOrder');
              var modal = bootstrap.Modal.getInstance(myModalEl)
              modal.hide();
          }
      })
      .catch(error => {
          console.error('Error:', error);
      });
    }
	</script>
@endsection 