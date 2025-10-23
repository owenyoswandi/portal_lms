<!-- ======= Footer ======= -->
<footer id="footer" class="footer">
    <div class="copyright">
        &copy; Copyright <strong><span style="color: #dc3545">{{ config('variables.appName1') }}</span>              
            <span>
                <script>        
                    document.write(new Date().getFullYear())
                </script>
            </span></strong>. All Rights Reserved
    </div>
    <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
    </div>
</footer><!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>
<script>
    const userName = storedUserData.nama
    const displayUserNameElements = document.querySelectorAll('.displayUserName');
    displayUserNameElements.forEach(element => {
        element.innerText = userName;
    });

    const userData = JSON.parse(localStorage.getItem('userData'));
    const apiurl = '{{ config('app.api_url') }}';
    const accesstoken = userData.api_token;
    const user_id = userData.id;
    const user_role = userData.role;


    function deleteLocalStorage() {
        const keyToDelete = 'userData';
        localStorage.removeItem(keyToDelete);
    }
</script>
