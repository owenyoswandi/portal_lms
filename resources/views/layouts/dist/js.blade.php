<!-- Vendor JS Files -->
<script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/chart.js/chart.min.js') }}"></script>
<script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
<script src="{{ asset('assets/vendor/quill/quill.min.js') }}"></script>
<script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
<script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
<script src="{{ asset('js/dselect.js') }}"></script>
<script src="{{ asset('js/moment.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>

<!-- Template Main JS File -->
<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="{{ asset('/assets/js/pagination.js') }}"></script>

<!-- Export -->
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>

<script>
    function formatBirthdate(dateString) {
        const dateObject = new Date(dateString + 'T00:00:00');
        const day = dateObject.getDate();
        const month = dateObject.getMonth() + 1; // Month is zero-based
        const year = dateObject.getFullYear();

        // Pad single-digit day and month with a leading zero
        const formattedDay = day < 10 ? '0' + day : day;
        const formattedMonth = month < 10 ? '0' + month : month;

        return formattedDay + '-' + formattedMonth + '-' + year;
    }

    function calculateTimeDifference(createdDate) {
        const tanggal = new Date()
        const formattedDate = new Date(tanggal.setHours(tanggal.getHours() + 7))
        const createdTime = new Date(createdDate);
        const currentTime = formattedDate
        const timeDifference = currentTime - createdTime;
        const hoursDifference = Math.floor(timeDifference / (1000 * 60 * 60));
        const daysDifference = Math.floor(timeDifference / (1000 * 60 * 60 * 24));

        return {
            hours: hoursDifference,
            days: daysDifference
        };
    }
</script>
</body>

</html>
