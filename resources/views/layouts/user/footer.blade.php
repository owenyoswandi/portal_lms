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
    const userData = JSON.parse(localStorage.getItem('userData') || '{}');

    // Expose API and user information on window to avoid duplicate `const` declarations
    if (typeof window.apiUrl === 'undefined') {
        window.apiUrl = '{{ config('app.api_url') }}';
    }

    window.accessToken = window.accessToken || userData.api_token || '{{ session('token') }}';
    window.userId = window.userId || userData.id || '{{ session('userid') ?? '' }}';
    window.userRole = window.userRole || userData.role || '{{ session('role') ?? '' }}';
    window.rumah_sakit = window.rumah_sakit || '{{ session('rumah_sakit') ?? '' }}';

    function deleteLocalStorage() {
        const keyToDelete = 'userData';
        localStorage.removeItem(keyToDelete);
    }
</script>
