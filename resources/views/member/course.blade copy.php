@extends('dist.layout_member')

@section('title')
    {{env('APP_NAME')}} | My Course
@endsection
@section('css')
    <style>
      .link {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 1;
      }
      .card-footer p {
        margin-top: 0px;
        margin-bottom: 5px;
      }

      #course .card:hover{
        transform: scale(1.05);
        box-shadow: 0 10px 20px rgba(0,0,0,.12), 0 4px 8px rgba(0,0,0,.06);
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
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="row" id="course">

          </div>
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
                                <input type="text" name="p_judul" class="form-control" id="p_judul" required>
                                <!--<div class="invalid-feedback">Please enter the username!</div>-->
                            </div>
                            <input type="text" name="p_id_lms" class="form-control" id="p_id_lms" hidden>
                            <input type="text" name="p_deskripsi" class="form-control" id="p_deskripsi" hidden>
                            <input type="text" name="p_img" class="form-control" id="p_img" hidden>
                            <input type="text" name="p_url_lms" class="form-control" id="p_url_lms" hidden>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="add()">Order</button>
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
	const accessToken = '{{ session('token') }}';
    const accessMember = '{{ session('usermember') }}';
    const userId = '{{ session('userid') }}';

		window.onload = function() {
      getByUserID();
      fetchDataOther();
		};

    function getByUserID() {
      axios.get(apiUrl + `/order-byuserid/${userId}/`, {
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
        axios.get(`https://ems.ai4talent.my.id/api/course/${data.p_id_lms}/${accessMember}/progress`, {
          headers: {
            'Authorization': `Bearer ${accessToken}`
          }
        })
        .then(response => {
          var card = '';
          let html = document.getElementById("course").innerHTML;
          card += `<div class="col-sm-4">
                    <div class="card">`;
          if(data.p_img!=null&&p_img!=""){
            card += `<img src="https://ems.ai4talent.my.id/storage/app/${data2.image}" class="card-img-top" alt="...">`;
          }
          card += `<a href="{{ url('member/course') }}/${data.p_id_lms}/${accessMember}"><span class="link"></span></a>
                <div class="card-body">
                  <h5 class="card-title">${data.p_judul}</h5>
                  <p>${data.p_deskripsi}</p>`;
          userData2 = response.data.data;
          console.log(userData2);
          if(userData2.length != 0){
            userData2.forEach((data2, index) => {
              card += `<p>Final Exam Score : ${data2.final_score == null ? '-' : data2.final_score}</p>
                    </div>
                    <div class="card-footer">
                      <p>Progress : </p>
                      <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: ${data2.progress_precentage}%" aria-valuenow="${data2.progress_precentage}" aria-valuemin="0" aria-valuemax="100">${data2.progress_precentage}%
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              `;
            });
          } else {
            card += `<p>Final Exam Score : - </p>
                  </div>
                  <div class="card-footer">
                    <p>Progress : </p>
                    <div class="progress">
                      <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%
                      </div>
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

    function getProgress(courseid) {
      return axios.get(`https://ems.ai4talent.my.id/api/course/${courseid}/${accessMember}/progress`, {
          headers: {
            'Authorization': `Bearer ${accessToken}`
          }
        });
		}

    const fetchDataOther = async () => {
        try {
            const response = await axios.get("https://ems.ai4talent.my.id/api/courses");
            console.log(response.data);
            dataOtherCourse(response.data);
        } catch (error) {
            // Handle error
            console.error(error);
        }
    };

    function dataOtherCourse(userData) {
      // <a href="{{ url('member/course') }}/${data.id}/${accessMember}"><span class="link"></span></a>
      userData.forEach((data, index) => {
        axios.get(apiUrl + `/order-bycourseid/${data.id}/${userId}/`, {
          headers: {
            'Authorization': `Bearer ${accessToken}`
          }
        }).then(response => {
          var card = '';
          let html = document.getElementById("other_course").innerHTML;
          card += `
            <div class="col-sm-4">
              <div class="card">`;

          if(data.image!=null&&data.image!=""){
            card += `<img src="https://ems.ai4talent.my.id/storage/app/${data.image}" class="card-img-top" alt="...">`;
          }

          card += `
                <div class="card-body">
                    <h5 class="card-title">${data.title}</h5>
                    <p>${data.description}</p>
                  </div>
                  <div class="card-footer">
                    <div class="d-flex justify-content-end">`;

          var course = response.data.data;
          if(response.data.data!=null){
            console.log(course);
            if(course.or_status==1){
              card += ` <a href="${data.link}?token=${accessToken}" target="_blank" class="btn btn-sm btn-primary"><i class="bi bi-box-arrow-right"></i> Masuk EMS</a>`;
            } else {
              //harusnya menunggu confirmation
              card += ` <a href="${data.link}?token=${accessToken}" target="_blank" class="btn btn-sm btn-primary"><i class="bi bi-box-arrow-right"></i> Masuk EMS</a>`;
            }
          } else {
            card += ` <button class="btn btn-sm btn-success" onclick="orderConfirmation('${data.id}', '${data.title}', '${data.description}', '${data.image}', '${data.link}')">Order Course</button>`;
          }
          card += `</div>
              </a>
              </div>
            </div>
          </div>
        `;
        document.getElementById('other_course').innerHTML = html + card;
        })
        .catch(error => {
            console.error('Error:', error);
        });

      });

    }
    function orderConfirmation(id, title, desc, img, link) {
      document.getElementById('p_id_lms').value = id;
      document.getElementById('p_judul').value = title;
      document.getElementById('p_deskripsi').value = desc;
      document.getElementById('p_img').value = img;
      document.getElementById('p_url_lms').value = link;
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

    function addOrder(data) {
      const userData = {};
      userData['p_id'] = data.p_id;
      userData['user_id'] = userId;
			console.log(userData);

      axios.post(apiUrl + '/order/create', userData, {
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
              getByUserMember();
              fetchDataOther();
          } else {
              console.error('Adding data failed:', data.message);
          }
      })
      .catch(error => {
          console.error('Error:', error);
      });
    }
	</script>
@endsection
